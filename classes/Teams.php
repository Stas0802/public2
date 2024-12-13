<?php

//Класс для обработки таблицы команды и тренера

namespace Game\App\Classes;

use Game\App\Interfaces\GameInterface;

class Teams implements GameInterface
{
  protected $id;
  protected $name;
  protected $logo;
  protected $description;
  protected $coach_name;
  protected $coach_experience;
  protected $uploadedLogoPath;
  protected $saveImage = false;

  public function __construct( $name, $logo, $description, $coach_name, $coach_experience,$id = null){
    $this->id = $id;
    $this->name = $name;
    $this->logo = $logo;
    $this->description = $description;
    $this->coach_name = $coach_name;
    $this->coach_experience = $coach_experience;
    $this->cleanInputFormXSS();
  }

  private function cleanInputFormXSS() {

    $this->name = htmlspecialchars($this->name, ENT_QUOTES, 'UTF-8');
    $this->description = htmlspecialchars($this->description, ENT_QUOTES, 'UTF-8');
    $this->coach_name = htmlspecialchars($this->coach_name, ENT_QUOTES, 'UTF-8');
    $this->coach_experience = htmlspecialchars($this->coach_experience, ENT_QUOTES, 'UTF-8');
  }

  public function getId(){
    return $this->id;
  }
  public function getName(){
    return $this->name;
  }
  public function getLogo(){
    return $this->logo['name'];
  }
  public function getDescription(){
    return $this->description;
  }
  public function getCoachName(){
    return $this->coach_name;
  }
  public function getCoachExperience(){
    return $this->coach_experience;
  }

  public function validateInput(){

    if(empty($_POST['name']) || empty($_POST['description']) || empty($_POST['coach_name']) || empty($_POST['coach_experience'])){
    throw new \Exception("Заповніть всі поля");
    }

    $allowed_types = ['image/jpeg', 'image/png'];
    if(!in_array(mime_content_type($_FILES['logo']['tmp_name']), $allowed_types)){
      throw new \Exception("Файл повинен бути у форматі JPG або PNG");
    }
    if($_FILES['logo']['size'] > 5000000){
      throw new \Exception("Розмір файлу перевищуе допустимий ліміт у 5 Мб");
    }

  }

  public function saveImage(){

    if(empty($this->logo)){
      return;
    }

    $uploads_dir = 'uploads';
    if(!file_exists($uploads_dir)){
      mkdir($uploads_dir, 0777, true );
    }
    if(isset($this->logo['error']) && isset($this->logo['tmp_name'])) {
      if($this->logo['error'] == 0) {
        $tmp_name = $this->logo['tmp_name'];
        $name = $this->logo['name'];
        $logo_path = $uploads_dir . "/" . $name;
        if(move_uploaded_file($tmp_name, $logo_path)){
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

  public function saveDb(){
    if($this->id === null){
      $this->insertDb();
    } else {
      $this->updateDb();
    }
  }

  private function insertDb() {
    
    $dbConnection = Database::getInstance()->getConnection();
    $stmt =$dbConnection->prepare("INSERT INTO teams (name, logo_path, description, coach_name, coach_experience) VALUES (?, ?, ?, ?, ?)");
    if($stmt === false) {
      throw new \Exception("Помилка підключення до бази даних");
    }
    // Раскомментировать для прохождения теста  testSaveDbTeams
        // $this->uploadedLogoPath = $this->logo['name'];
    $stmt->bind_param('ssssi', $this->name, $this->uploadedLogoPath, $this->description, $this->coach_name, $this->coach_experience);
    if(!$stmt->execute()) {
      throw new \Exception("Помилка збереження: " . $stmt->error);
    }
    $this->id = $stmt->insert_id;
    $stmt->close();

  }

  private function updateDb() {
    $dbConnection = Database::getInstance()->getConnection();
    $stmt =$dbConnection->prepare("UPDATE teams SET name = ?, logo_path = ?, description = ?, coach_name = ?, coach_experience = ? WHERE id = ?");
    if($stmt === false) {
      throw new \Exception ("Помилка підключення до бази даних");
    }
    $stmt->bind_param("ssssii", $this->name, $this->uploadedLogoPath, $this->description, $this->coach_name, $this->coach_experience, $this->id);
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

    $stmt = $dbConnection->prepare("SELECT * FROM teams WHERE id = ?");
    if ($stmt === false) {
      throw new \Exception("Помилка підготовкі запиту");
     }

     $stmt->bind_param("i", $id);
     if (!$stmt->execute()) {
      throw new \Exception("Помилка виконання запиту");
     }

     $result = $stmt->get_result();
     if ($result === false) {
      throw new \Exception("Помилка отримання id з бази даних");
     }

     $team = $result->fetch_assoc();
     if ($stmt === null) {
      throw new \Exception("Запісь по id = ($id) не знайдено");
     }

     $stmt->close();
     return $team;
  }

  public static function fetchAll() {

    $dbConnection = Database::getInstance()->getConnection();
    $stmt = $dbConnection->prepare("SELECT * FROM teams ORDER BY created_at DESC");
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result === false) {
      throw new \Exception("Помилка отримання даних з бази даних");
    }
    $teams = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $teams;
  }

  public static function deleteById($id){

    $team = self::fetchById($id);
    $dbConnection = Database::getInstance()->getConnection();

    $stmt = $dbConnection->prepare("DELETE FROM teams WHERE id = ?");
    if ($stmt === false) {
      throw new \Exception("Помилка підгатовки запиту");
    }

    $stmt->bind_param('i', $id);
    if ($stmt->execute() === false) {
      throw new \Exception("Помилка видалення");
    }

    $stmt->close();

    if (file_exists($team['logo_path'])) {
      unlink($team['logo_path']);
    }
  }

}