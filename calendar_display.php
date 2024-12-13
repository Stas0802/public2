<?php

use Game\App\Classes\CalendarTournaments;
ini_set('display_errors', 1);
error_reporting(E_ALL);


require __DIR__ . '/../vendor/autoload.php';
// Перевіряємо, чи встановлено параметр 'id' в GET-запиті
// Якщо 'id' не встановлено, перенаправляємо користувача на сторінку форми
if (!isset($_GET['id'])) {
    header("Location: /table_calendar.php");
    exit;
   
}

// Получаемо турнір по id - якщо турніру немае(Помилека-турнір по id не знайдена)
try {
    $cal_tour = CalendarTournaments::fetchById($_GET['id']);
} catch (Exception $e) {
    echo "Ошибка: " . $e->getMessage();
    echo "<a href='/table_calendar.php'><button type='button'>Повернутися до календаря</button></a><br/>";
    exit;
}

// Переверяемо метод запиту
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        try {
            // Видаляемо календар по id
            CalendarTournaments::deleteById($_GET['id']);
            echo "<p>Календар видалено</p>";
            echo "<a href='/table_calendar.php'><button type='button'>Повернутися до календаря</button></a><br/>";
        } catch (Exception $e) {
            
            echo "Помилка при видаленні календаря: " . $e->getMessage();
        }
     }
    
    } else {
    // Отображаем форму для  удаления и редактирование турніру
    echo "</form>";
    echo "<form method='POST'>";
    echo "<button type='submit' name='delete' formaction='/calendar_display.php?id=" . $cal_tour['id'] ."'>Видалити  календар</button>";

    echo "</form>";
    echo "<a href='/table_calendar.php'><button type='button'>Повернутися до календаря</button></a><br/><br/>";
    echo "</form>";
    echo "<a href='/edit_calendar.php?id=" . $cal_tour['id'] . "'><button type='button'>Редагувати календар</button></a><br/>";

    echo "</form>";
    echo "<h1>Календар готов!</h1>";
    echo "Назва турніру: " . $cal_tour['event_name'] . "<br>";
     echo "Дата початку турніру: " . $cal_tour['start_date'] . "<br>";
    echo "Дата закінчення турніру: " . $cal_tour['end_date'] . "<br>";
    echo "Місто проведення турніру: " . $cal_tour['event_city'] . "<br>";
    echo "Країна проведення турніру: " . $cal_tour['event_country'] . "<br>";
    echo "Опис турніру: " . $cal_tour['description'] . "<br>"; 
    echo "Формат турніру:" . $cal_tour['format'] . "<br>";
    echo "Призовой фонд:" . $cal_tour['prize_pool'] . " $ <br>";
    echo "Зображення: <img src='" . $cal_tour['logo_path'] . "'/><br>";
} 