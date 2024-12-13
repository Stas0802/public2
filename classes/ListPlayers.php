<?php

//Класс для обработки таблицы списка участников
namespace Game\App\Classes;



class ListPlayers
{
    protected $id;
    protected $name;
    protected $role;
    protected $country;

    public function __construct($name, $role, $country, $id = null) {
        $this->id = $id;
        $this->name = $name;
        $this->role = $role;
        $this->country = $country;
        $this->cleanInputFormXSS();
    }

    private function cleanInputFormXSS() {

        $this->name = htmlspecialchars($this->name, ENT_QUOTES, 'UTF-8');
        $this->role = htmlspecialchars($this->role, ENT_QUOTES, 'UTF-8');
        $this->country = htmlspecialchars($this->country, ENT_QUOTES, 'UTF-8');
    }
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }
    public function getRole() {
        return $this->role;
    }
    public function getCountry() {
        return $this->country;
    }

    public function validateInput() {

        if (empty($_POST['name']) || empty($_POST['role']) || empty($_POST['country'])) {
            throw new \Exception(":Заповніть всі поля");
        }
    }

    public function saveDb() {
        if ($this->id === null) {
            $this->insertDb();
        } else {
            $this->updateDb();
        }
    }
    private function insertDb() {

        $dbConnection = Database::getInstance()->getConnection();
        $stmt = $dbConnection->prepare("INSERT INTO players_list (name, role, country) VALUES (?, ?, ?)");
        if($stmt === false) {
            throw new \Exception("Помилка підключення до базі даних");
        }
        $stmt->bind_param('sss', $this->name, $this->role, $this->country);
        if (!$stmt->execute()) {
            throw new \Exception("Помилка збереження: " . $stmt->error);
        }
        $this->id = $stmt->insert_id;
        $stmt->close();
    }

    private function updateDb() {
        $dbConnection = Database::getInstance()->getConnection();
        $stmt = $dbConnection->prepare("UPDATE players_list SET name = ?, role = ?, country = ? WHERE id = ?");
        if ($stmt === false) {
            throw new \Exception("Помилка підключення до базі даних");
        }
        $stmt->bind_param('sssi', $this->name, $this->role, $this->country, $this->id);
        if ($stmt->execute() === false) {
            throw new \Exception("Помилка оновлення");
        }
        $stmt->close();
    }

    public static function fetchById($id) {

        $dbConnection = Database::getInstance()->getConnection();
        $stmt = $dbConnection->prepare("SELECT * FROM players_list WHERE id = ?");
        if ($stmt === false) {
            throw new \Exception ("Помилка підготовкі запиту");
        }
        $stmt->bind_param('i', $id);
        if (!$stmt->execute()) {
            throw new \Exception("Помилка виконання запиту");
        }
        $result = $stmt->get_result();
        if ($result === false) {
            throw new \Exception("Помилка отримання id з бази даних");
        }
        $list = $result->fetch_assoc();
        if ($list === null) {
            throw new \Exception("Запісь по id = ($id) не знайдено");
        }
        $stmt->close();
        return $list;
    }
    public static function fetchAll() {

        $dbConnection = Database::getInstance()->getConnection();
        $stmt = $dbConnection->prepare("SELECT * FROM players_list ORDER BY created_at DESC");
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result === false) {
            throw new \Exception(" Помилка отримання даних з бази даних");
        }
        $players_list = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $players_list;
    }
    public static function deleteById($id) {

        $list = self::fetchById($id);
        $dbConnection = Database::getInstance()->getConnection();
        $stmt = $dbConnection->prepare("DELETE FROM players_list WHERE id = ?");
        if ($stmt === false) {
            throw new \Exception("Помилка підготовки запиту");
        }
        $stmt->bind_param('i', $id);
        if ($stmt->execute() === false) {
            throw new \Exception("Помилка видалення");
        }
        $stmt->close();
        
    }
}