<?php

use Game\App\Classes\ListPlayers;

require __DIR__ . '/../vendor/autoload.php';

ini_set('display_errors',1);
error_reporting(E_ALL);

if (!isset($_GET['id'])) {
    header("Location: /table_list.php");
    exit;
}

try {
    $list = ListPlayers::fetchById($_GET['id']);
}catch (\Exception $e) {
    echo "Помилка" . $e->getMessage();
    echo "<a href='/table_list.php'><button type='button'>Повернутися до списку учасников</button></a><br/>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        try {
            ListPlayers::deleteById($_GET['id']);
            echo "<p>Учасника успішно видалено!</p>";
            echo "<a href='/table_list.php'><button type='button'>Повернутися до списку учасников</button></a><br/>";
        } catch (\Exception $e) {
            echo "Помилка при видаленні" . $e->getMessage();
        }
    } else {
        echo "Список збереженний";
        echo "<a href='/list_form.php'><button type='button'>Повернутися до форми </button></a><br/>";
    }
} else {
    echo "<form method='POST'>";
    echo "<button type='submit' name='delete' formation='/teams_display.php?id=" . $list['id'] ."'>Видалити учасника</button>";
    echo "</form>";
    echo "<a href='/table_list.php'><button type='button'>Повернутися до списку учасников</button></a><br/>";
    echo "<br/>";
    echo "<a href='/edit_list.php?id=" . $list['id'] . "'><button type='button'>Редагувати учасника</button></a><br/>";
    echo "<br/>";
    echo "Ім'я учасника:" . $list['name'] . "<br/>";
    echo "Роль учасника:" . $list['role'] . "<br/>";
    echo "Країна учасника:" . $list['country'] . "<br/>";

}