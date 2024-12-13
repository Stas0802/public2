<?php

use Game\App\Classes\ListPlayers;


require __DIR__ . '/../vendor/autoload.php';

ini_set('display_errors',1);
error_reporting(E_ALL);

if (!isset($_GET['id'])) {
    header('Location: index.php');
}

$list = ListPlayers::fetchById($_GET['id']);


?>



<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Players</title>
    </head>
    <body>
        <h1>Players</h1>

        <form method="POST" action="list_handler.php" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $list['id']; ?>">
            <p>Ім'я учасника</p>
            <input type="text" name="name" placeholder="Ім'я учасника" value="<?php echo $list['name']; ?>">
            <p>Роль учасника</p>
            <textarea name="role" placeholder="Роль учасника"><?php echo $list['role']; ?></textarea>
            <p>Країна учасника</p>
            <input type="text" name="country" placeholder="Країна учасника" value="<?php echo $list['country']; ?>">
            <br/>
            <input type="submit" value="Додати">
        </form>
    </body>
    </html>
  