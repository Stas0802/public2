<?php

//Класс для обработки таблицы календаря турниров 

namespace Game\App\Classes;


use Game\App\Interfaces\GameInterface;

class CalendarTournaments implements GameInterface
{
    protected $id;
    protected $event_name;
    protected $start_date;
    protected $end_date;
    protected $event_city;
    protected $event_country;
    protected $description;
    protected $format;
    protected $prize_pool;
    protected $logo;
    protected $uploadedLogoPath;
    protected $saveImage = false;

    public function __construct($event_name, $start_date, $end_date, $event_city, $event_country, $description, $format, $rize_pool, $logo, $id = null) {
        $this->id = $id;
        $this->event_name = $event_name;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->event_city = $event_city;
        $this->event_country = $event_country;
        $this->description = $description;
        $this->format = $format;
        $this->prize_pool = $rize_pool;
        $this->logo = $logo;
        $this->cleanInputFormXSS();
        
    }

    private function cleanInputFormXSS() {

        $this->event_name = htmlspecialchars($this->event_name, ENT_QUOTES, 'UTF-8');
        $this->event_city = htmlspecialchars($this->event_city, ENT_QUOTES, 'UTF-8');
        $this->event_country = htmlspecialchars($this->event_country,ENT_QUOTES, 'UTF-8');
        $this->description = htmlspecialchars($this->description, ENT_QUOTES, 'UTF-8');
        $this->format = htmlspecialchars($this->format, ENT_QUOTES, 'UTF-8');
        $this->prize_pool = htmlspecialchars($this->prize_pool, ENT_QUOTES, 'UTF-8');
    }

    public function getId() {
        return $this->id;
    }
    public function getEventName() {
        return $this->event_name;
    }
    public function getStartDate() {
        return $this->start_date;
    }
    public function getEndDate() {
        return $this->end_date;
    }
    public function getEventCity() {
        return $this->event_city;
    }
    public function getEventCountry() {
        return $this->event_country;
    }
    public function getDescription() {
        return $this->description;
    }
    public function getFormat() {
        return $this->format;
    }
    public function getPrizePool() {
        return $this->prize_pool;
    }
    public function getLogo() {
        return $this->logo['name'];
    }

    public function validateInput() {

        if (empty($_POST['event_name']) || empty($_POST['event_city']) || empty($_POST['event_country']) || empty($_POST['description']) || empty($_POST['format']) || empty($_POST['prize_pool'])) {
            throw new \Exception("Заповніть всі поля");
        }
        $allowed_types = ['image/jpeg', 'image/png'];
        if (!in_array(mime_content_type($_FILES['logo']['tmp_name']),$allowed_types)) {
            throw new \Exception("Файл повинен бути у форматі JPG або PNG");
        }
        if ($_FILES['logo']['size'] > 5000000) {
            throw new \Exception("Розмір файлу перевищуе допустимий ліміт у 5 Мб");
        }

    }
    public function saveImage() {

        if(empty($this->logo)) {
            return;
        }

        $uploads_dir = 'uploads';
        if(!file_exists($uploads_dir)) {
            mkdir($uploads_dir, 0777, true);
        }
        if(isset($this->logo['error']) && isset($this->logo['tmp_name'])) {
            if($this->logo['error'] == 0) {
                $tmp_name = $this->logo['tmp_name'];
                $name = $this->logo['name'];
                $logo_path = $uploads_dir . "/" . $name;
                if(move_uploaded_file($tmp_name, $logo_path)) {
                    $this->uploadedLogoPath = $logo_path;
                    $this->saveImage = true;
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
        $stmt = $dbConnection->prepare("INSERT INTO calendar (event_name, start_date, end_date, event_city, event_country, description, format, prize_pool, logo_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if($stmt === false) {
            throw new \Exception("Помилка підключення до бази даних");
        }
         // Раскомментировать для прохождения теста  testSaveDbCalendarTournaments
         //$this->uploadedLogoPath = $this->logo['name'];

        $stmt->bind_param('sssssssds', $this->event_name, $this->start_date, $this->end_date, $this->event_city,$this->event_country, $this->description, $this->format, $this->prize_pool, $this->uploadedLogoPath);
        if(!$stmt->execute()) {
            throw new \Exception("Помилка збереження: " . $stmt->error);
        }
        $this->id = $stmt->insert_id;
        $stmt->close();
    }

    private function updateDb() {

        $dbConnection = Database::getInstance()->getConnection();
        $stmt = $dbConnection->prepare("UPDATE calendar SET event_name = ?, start_date = ?, end_date = ?, event_city = ?, event_country = ?, description = ?, format = ?, prize_pool = ?, logo_path = ? WHERE id = ?");
        if($stmt === false) {
            throw new \Exception("Помилка підключення до бази даних");       
        }
        $stmt->bind_param('sssssssdsi', $this->event_name, $this ->start_date, $this->end_date, $this->event_city, $this->event_country, $this->description, $this->format, $this->prize_pool, $this->uploadedLogoPath, $this->id);
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

        $stmt = $dbConnection->prepare("SELECT * FROM calendar WHERE id = ?");
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
        $cal_tour = $result->fetch_assoc();
        if($stmt === null) {
            throw new \Exception("Запісь по id = ($id) не знайдено");
        }
        $stmt->close();
        return $cal_tour;
    }

    public static function fetchAll() {

        $dbConnection = Database::getInstance()->getConnection();
        $stmt = $dbConnection->prepare("SELECT * FROM calendar ORDER BY created_at DESC");
        $stmt->execute();
        $result = $stmt->get_result();
        if($result === false) {
            throw new \Exception("Помилка отримання даних з бази даних");
        }
        $calendar = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $calendar;
    }

    public static function deleteById($id) {

        $cal_tour = self::fetchById($id);
        $dbConnection = Database::getInstance()->getConnection();

        $stmt = $dbConnection->prepare("DELETE FROM calendar WHERE id = ?");
        if($stmt === false) {
            throw new \Exception("Помилка підгатовки запиту");
        }
        $stmt->bind_param('i', $id);
        if($stmt->execute() === false) {
            throw new \Exception("Помилка видалення");
        }
        $stmt->close();

        if(file_exists($cal_tour['logo_path'])) {
            unlink($cal_tour['logo_path']);
        }
    }

}