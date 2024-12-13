<?php

use Game\App\Classes\Players;



ini_set('display_errors', 1);
error_reporting(E_ALL); 
require __DIR__ . '/../vendor/autoload.php';


$id = $_POST['id'] ?? null;
$image = $_FILES['image'] ?? null;
$player_name = $_POST['player_name'] ?? null;
$career_description = $_POST['career_description'] ?? null;
$game_experience = $_POST['game_experience'] ?? null;
$country_of_origin = $_POST['country_of_origin'] ?? null;
$total_earnings = $_POST['total_earnings'] ?? null;





try {
    $play = new Players( $image,$player_name, $career_description, $game_experience, $country_of_origin, $total_earnings,  $id);
    $play->validateInput();
    $play->saveAll();

    header("Location: /players_display.php?id=" . $play->getId());
    exit;
} catch (Exception $e) {
    echo "Помилка " . $e->getMessage();
}