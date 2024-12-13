<?php

use Game\App\Classes\Teams;

require __DIR__ . '/../vendor/autoload.php'; 

ini_set('display_errors',1);
error_reporting(E_ALL);

$id = $_POST['id'] ?? null;
$name = $_POST['name'] ?? null;
$logo = $_FILES['logo'] ?? null;
$description = $_POST['description'] ?? null;
$coach_name = $_POST['coach_name'] ?? null;
$coach_experience = $_POST['coach_experience'] ?? null;

try{
    $team = new Teams($name, $logo, $description, $coach_name, $coach_experience, $id);
    $team->validateInput();
    $team->saveAll();

    header("Location: /teams_display.php?id=" . $team->getId());
    exit;
} catch (\Exception $e) {
    echo "Помилка" . $e->getMessage();
}
