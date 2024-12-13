<?php 

use Game\App\Classes\Teams;

require __DIR__ . '/../vendor/autoload.php';

ini_set('display_errors',1);
error_reporting(E_ALL);

if (!isset($_GET['id'])) {
    header('Location: index.php');
}

$team = Teams::fetchById($_GET['id']);


?>



<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>TEAMS</title>
    </head>
    <body>
        <h1>Teams</h1>

        <form method="POST" action="teams_handler.php" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $team['id']; ?>">
            <p>Введіть назву команди</p>
            <input type="text" name="name" placeholder="Назва команди" value="<?php echo $team['name']; ?>">
            <p>Виберіть логотіп команди</p>
            <input type="file" name="logo">
            <p>Введіть опис команди</p>
            <textarea name="description" placeholder="Опис команди"><?php echo $team['description']; ?></textarea>
            <p>Тренір</p>
            <input type="text" name="coach_name" placeholder="Ім'я треніра" value="<?php echo $team['coach_name']; ?>">
            <p>Стаж треніра</p>
            <input type="number" name="coach_experience" placeholder="Стаж треніра" value="<?php echo $team['coach_experience']; ?>">
            <br/>
            <input type="submit" value="Додати">
        </form>
    </body>
    </html>
  