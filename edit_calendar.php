<?php

use Game\App\Classes\CalendarTournaments;

require __DIR__ . '/../vendor/autoload.php';

ini_set('display_errors',1);
error_reporting(E_ALL);

if(!isset($_GET['id'])) {
    header('Location: table_calendar.php');
}

$cal_tour = CalendarTournaments::fetchById($_GET['id']);
$calendar = CalendarTournaments::fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit_calendar</title>
</head>
<body>
<h1>Calendar Form</h1>
    <form method="POST" action="calendar_handler.php" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $cal_tour['id']; ?>">
        <label for="event_name">Назва турніру:</label>
        <input type="text" id="event_name" name="event_name"  value="<?php echo $cal_tour['event_name']; ?>"><br/>

        <label for="start_date">Дата початку:</label>
        <input type="date" id="start_date" name="start_date"  value="<?php echo $cal_tour['start_date']; ?>"><br/>

        <label for="end_date">Дата кінця:</label>
        <input type="date" id="end_date" name="end_date"  value="<?php echo $cal_tour['end_date']; ?>"><br/>

        <label for="event_city">Місто турніру:</label>
        <input type="text" id="event_city" name="event_city"  value="<?php echo $cal_tour['event_city']; ?>"><br/>

        <label for="event_country">Країна турніру:</label>
        <input type="text" id="event_country" name="event_country" value="<?php echo $cal_tour['event_country']; ?>"><br/>

        <label for="description">Опис турніру:</label>
        <textarea id="description" name="description" ><?php echo $cal_tour['description']; ?></textarea><br/>

        <label for="format">Формат турніру:</label>
        <input type="text" id="format" name="format" value="<?php echo $cal_tour['format']; ?>"><br/>

        <label for="prize_pool">Призовий фонд:</label>
        <input type="number" id="prize_pool" name="prize_pool"  value="<?php echo $cal_tour['prize_pool']; ?>"><br/>

        <label for="logo">Logo:</label>
        <input type="file" id="logo" name="logo" accept="image/*"><br/>

        <button type="submit">Створити</button>
    </form>
    
</body>
</html>