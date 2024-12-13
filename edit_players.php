<?php

use Game\App\Classes\Players;

require __DIR__ . '/../vendor/autoload.php';

ini_set('display_errors',1);
error_reporting(E_ALL);

if (!isset($_GET['id'])) {
    header('Location: table_players.php');
}

$play = Players::fetchById($_GET['id']);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Edit_players</title>
    </head>
    <body>
        <h1>Players</h1>

        <form method="POST" action="players_handler.php" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $play['id']; ?>">
            <p>Фото гравця</p>
            <input type="file" name="image">
            <p>Ім'я гравця</p>
            <input type="text" name="player_name" palceholder="Ім'я гравця" value="<?php echo $play['player_name']; ?>">
            <p>Опис кар'єри гравця</p>
            <textarea name="career_description" placeholder="Опис кар'єри гравця"><?php echo $play['career_description']; ?></textarea>
            <p>Досвід</p>
            <input type="number" name="game_experience" placeholder="Досвід гравця" value="<?php echo $play['game_experience']; ?>">
            <p>Країна гравця</p>
            <input type="text" name="country_of_origin" placeholder="Країна гравця" value="<?php echo $play['country_of_origin']; ?>">
            <p>Максимальний виграш</p>
            <input type="number" name="total_earnings" placeholder="Максимальний виграш"  value="<?php echo $play['total_earnings']; ?>">
           
            <br/>
            <input type="submit" value="Редагувати">
        </form>
    </body>
</html>

