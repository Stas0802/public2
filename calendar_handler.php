<?php

use Game\App\Classes\CalendarTournaments;

require __DIR__ . '/../vendor/autoload.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

$id = $_POST['id'] ?? null;
$event_name = $_POST['event_name'] ?? null;
$start_date = $_POST['start_date'] ?? null;
$end_date = $_POST['end_date'] ?? null;
$event_city = $_POST['event_city'] ?? null;
$event_country = $_POST['event_country'] ?? null;
$description = $_POST['description'] ?? null;
$format = $_POST['format'] ?? null;
$prize_pool = $_POST['prize_pool'] ?? null;
$logo = $_FILES['logo'] ?? null;


try {
    $cal_tour = new CalendarTournaments($event_name, $start_date, $end_date, $event_city, $event_country, $description, $format, $prize_pool, $logo, $id);
    $cal_tour->validateInput();
    $cal_tour->saveAll();

    header("Location: /calendar_display.php?id=" . $cal_tour->getId());
    exit;
} catch (Exception $e) {
    echo "Помилка" . $e->getMessage();
}