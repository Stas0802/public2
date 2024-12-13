<?php


use Game\App\Classes\Players;

ini_set('display_errors', 1);
error_reporting(E_ALL);


require __DIR__ . '/../vendor/autoload.php';
// Перевіряємо, чи встановлено параметр 'id' в GET-запиті
// Якщо 'id' не встановлено, перенаправляємо користувача на сторінку форми
if (!isset($_GET['id'])) {
    header("Location: /table_players.php");
    exit;
   
}

// Получаемо турнір по id - якщо гравця немае(Помилека-гравец по id не знайдена)
try {
    $play = Players::fetchById($_GET['id']);
} catch (Exception $e) {
    echo "Ошибка: " . $e->getMessage();
    echo "<a href='/table_players.php'><button type='button'>Повернутися до календаря</button></a><br/>";
    exit;
}

// Переверяемо метод запиту
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        try {
            // Видаляемо гравця по id
            Players::deleteById($_GET['id']);
            echo "<p>Гравц видалено</p>";
            echo "<a href='/table_players.php'><button type='button'>Повернутися до списку гравців</button></a><br/>";
        } catch (Exception $e) {
            
            echo "Помилка при видаленні гравця: " . $e->getMessage();
        }
     }
    
    } else {
    // Отображаем форму для  удаления и редактирование гравця
    echo "</form>";
    echo "<form method='POST'>";
    echo "<button type='submit' name='delete' formaction='/players_display.php?id=" . $play['id'] ."'>Видалити  гравця</button>";

    echo "</form>";
    echo "<a href='/table_players.php'><button type='button'>Повернутися до списку гравців</button></a><br/><br/>";
    echo "</form>";
    echo "<a href='/edit_players.php?id=" . $play['id'] . "'><button type='button'>Редагувати гравця</button></a><br/>";

    echo "</form>";
    echo "<h1>Гравец!</h1>";
    echo "Фото гравця: <img src='" . $play['image_path'] . "'/><br>";
    echo "Ім'я гравця: " . $play['player_name'] . "<br>";
    echo "Опис кар'єри гравця: " . $play['career_description'] . "<br>";
    echo "Досвід гравця: " . $play['game_experience'] . "роки <br>";
    echo "Країна гравця: " . $play['country_of_origin'] . "<br>";
    echo "Максимальний виграш гравця: " . $play['total_earnings'] . " $ <br>";
   
} 