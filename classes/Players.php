<?php

//Класс для работы с таблицей игрока

namespace Game\App\Classes;

use Game\App\Interfaces\GameInterface;

class Players implements GameInterface {

    protected $id;
    protected $image;
    protected $player_name;
    protected $career_description;
    protected $game_experience;
    protected $country_of_origin;
    protected $total_earnings;
   
    protected $uploadedImagePath;
    protected $imageSave = false;

    public function __construct($image, $player_name, $career_description, $game_experience, $country_of_origin, $total_earnings,  $id = null) {
        $this->id = $id;
        $this->image = $image;
        $this->player_name = $player_name;
        $this->career_description = $career_description;
        $this->game_experience = $game_experience;
        $this->country_of_origin = $country_of_origin;
        $this->total_earnings = $total_earnings;
        $this->cleanInputFormXSS();
    }

    private function cleanInputFormXSS() {
        $this->player_name = htmlspecialchars($this->player_name, ENT_QUOTES, 'UTF-8');
        $this->career_description = htmlspecialchars($this->career_description, ENT_QUOTES, 'UTF-8');
        $this->game_experience = htmlspecialchars($this->game_experience, ENT_QUOTES, 'UTF-8');
        $this->country_of_origin = htmlspecialchars($this->country_of_origin, ENT_QUOTES, 'UTF-8');
        $this->total_earnings = htmlspecialchars($this->total_earnings, ENT_QUOTES, 'UTF-8');
    }

    public function getId() {
        return $this->id;
    }
    public function getImage() {
        return $this->image['name'];
    }
   
    public function getPlayerName() {
        return $this->player_name;
    }
    public function getCareerDescription() {
        return $this->career_description;
    }
    public function getGameExperience() {
        return $this->game_experience;
    }
    public function getCountryOfOrigin() {
        return $this->country_of_origin;
    }
    public function getTotalEarnings() {
        return $this->total_earnings;
    }
  

    public function validateInput() {
        if (empty($_POST['player_name']) || empty($_POST['career_description']) || empty($_POST['game_experience']) || empty($_POST['country_of_origin']) || empty($_POST['total_earnings'])) {
            throw new \Exception("Заповніть всі поля");
        }
     
    }

    public function saveImage() {

        if(empty($this->image)) {
            return;
        }
        $allowed_types = ['image/jpeg', 'image/png'];
        if(!in_array(mime_content_type($_FILES['image']['tmp_name']), $allowed_types)) {
            throw new \Exception("Невірний тип файлу");
        }
        if ($_FILES['image']['size'] > 5000000) {
            throw new \Exception("Розмір файлу перевищуе допустимий ліміт у 5 Мб");
        } 
        
        
        $uploads_dir = 'uploads';
        if(!file_exists($uploads_dir)) {
            mkdir($uploads_dir, 0777, true);
        }
        if(isset($this->image['error']) && isset($this->image['tmp_name'])) {
            if($this->image['error'] == 0) {
                $tmp_name = $this->image['tmp_name'];
                $name = $this->image['name'];
                $image_path = $uploads_dir . "/" . $name;
                if(move_uploaded_file($tmp_name, $image_path)) {
                    $this->uploadedImagePath = $image_path;
                    $this->imageSave = true;
                }
            } else {
                throw new \Exception("Помилка завантаження файлу");
            }
        } else {
            throw new \Exception("Файл не передан або відсутній");
        }
    }

    public function saveDb() {
        if($this->id === null) {
            $this->insertDb();
        } else {
            $this->updateDb();
        }
    }
    private function insertDb() {

        $dbConnection = Database::getInstance()->getConnection();
        $stmt = $dbConnection->prepare("INSERT INTO player_table (image_path, player_name, career_description, game_experience, country_of_origin, total_earnings) VALUES (?, ?, ?, ?, ?, ?)");
        if($stmt === false) {
            throw new \Exception("Помилка підключення до бази даних");
        }
         // Раскомментировать для прохождения теста  testSaveDbPlayers
         //$this->uploadedImagePath = $this->image['name'];
        $stmt->bind_param('sssiss', $this->uploadedImagePath, $this->player_name, $this->career_description, $this->game_experience, $this->country_of_origin, $this->total_earnings);
        if(!$stmt->execute()) {
            throw new \Exception("Помилка збереження: " . $stmt->error);
        }
        $this->id = $stmt->insert_id;
        $stmt->close();
    }

    private function updateDb() {

        $dbConnection = Database::getInstance()->getConnection();
        $stmt = $dbConnection->prepare("UPDATE player_table SET image_path = ?, player_name = ?, career_description = ?, game_experience = ?, country_of_origin = ?, total_earnings = ? WHERE id = ?"); 
        if($stmt === false) {
            throw new \Exception("Помилка підключення до бази даних");
        }
        $stmt->bind_param('sssissi', $this->uploadedImagePath, $this->player_name, $this->career_description, $this->game_experience, $this->country_of_origin, $this->total_earnings, $this->id);
        if($stmt->execute() === false) {
            throw new \Exception("Помилка оновлення ");
        }
        $stmt->close();
    }
    
    public function saveAll() {
        $this->saveImage();
        $this->saveDb();
    }

    public static function fetchById($id) {
        $dbConnection = Database::getInstance()->getConnection();
        $stmt = $dbConnection->prepare("SELECT * FROM player_table WHERE id = ?");
        if($stmt === false) {
            throw new \Exception("Помилка підготовкі запиту");
        }
        $stmt->bind_param('i', $id);
        if(!$stmt->execute()) {
            throw new \Exception("Помилка виконання запиту");
        }
        $result = $stmt->get_result();
        if($result === false) {
            throw new \Exception("Помилка отримання id з бази даних");
        }
        $play = $result->fetch_assoc();
        if($stmt === null) {
            throw new \Exception("Запісь по id = ($id) не знайдено");
        }
        $stmt->close();
        return $play;
    }

    public static function fetchAll() {
        $dbConnection = Database::getInstance()->getConnection();
        $stmt = $dbConnection->prepare("SELECT * FROM player_table ORDER BY created_at DESC");
        $stmt->execute();
        $result = $stmt->get_result();
        if($result === false) {
            throw new \Exception("Помилка отримання даних з бази даних");
        }
        $player_table = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $player_table;
    }

    public static function deleteById($id) {
        $table_players = self::fetchById($id);
        $dbConnection = Database::getInstance()->getConnection();
        $stmt = $dbConnection->prepare("DELETE FROM player_table WHERE id = ?");
        if($stmt === false) {
            throw new \Exception("Помилка підготовки запиту");
        }
        $stmt->bind_param('i', $id);
        if($stmt->execute() === false) {
            throw new \Exception("Помилка видалення");
        }
        $stmt->close();

        if(file_exists($table_players['image_path'])) {
            unlink($table_players['image_path']);
        }
    }

}