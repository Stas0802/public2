<?php


use Game\App\Classes\Teams;

require __DIR__ . '/../vendor/autoload.php'; 

ini_set('display_errors',1);
error_reporting(E_ALL);

if (!isset($_GET['id'])) {
    header("Location: /table_teams.php");
    exit;
}

try{
    $team = Teams::fetchById($_GET['id']);
}catch (\Exception $e) {
    echo "Помилка:" . $e->getMessage();
    echo "<a href='/teams_form.php'><button type='button'>Повернутися до форми</button></a><br/>";
    exit;
} 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        try {
            Teams::deleteById($_GET['id']);
            echo "<p> Команда була видалена</p>";
            echo "<a href='/table_teams.php'><button type='button'>Повернутися до списку команд</button></a><br/>";
        } catch (\Exception $e) {
            echo "Помилка при видаленні команди: " . $e->getMessage();
        }
    } else {
        echo "<p>Команда збережена</p>";
        echo "<a href='/teams_form.php'><button type='button'>Повернутися до форми</button></a><br/>";
    }
} else {

    echo "<form method='POST'>";
    echo "<button type='submit' name='delete' formation='/teams_display.php?id=" . $team['id'] ."'>Видалити команду</button>";
    echo "</form>";
    echo "<a href='/table_teams.php'><button type='button'>Повернутися до списку команд</button></a><br/>";
    echo "<br/>";
    echo "<a href='/edit_teams.php?id=" . $team['id'] . "'><button type='button'>Редагувати команду</button></a><br/>";
    echo "<br/>";
    echo "Назва команди:" . $team['name'] . "<br/>";
    echo "Логотип: <img src='" . $team['logo_path'] . "'/><br/>";
    echo "Опис команди:" . $team['description'] . "<br/>";
    echo "Ім'я тренера:" . $team['coach_name'] . "<br/>";
    echo "Стаж тренера:" . $team['coach_experience'] . "<br/>";

}