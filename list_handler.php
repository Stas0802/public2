<?php 

use Game\App\Classes\ListPlayers;

require __DIR__ . '/../vendor/autoload.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

$id = $_POST['id'] ?? null;
$name = $_POST['name'] ?? null;
$role = $_POST['role'] ?? null;
$country = $_POST['country'] ?? null;

try {
    $list = new ListPlayers($name, $role, $country, $id);
    $list->validateInput();
    $list->saveDb();

    header("Location: /list_display.php?id=" . $list->getId());
    exit;
} catch (Exception $e) {
    echo "Помилка" . $e->getMessage();
}
