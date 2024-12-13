<?php

use Game\App\Classes\Teams;


ini_set('display_errors',1);
error_reporting(E_ALL);
require __DIR__ . '/../vendor/autoload.php';

$teams =  Teams::fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Команди</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1 {
            color: #333;
        }

        a {
            text-decoration: none;
            color: #007BFF;
            font-weight: bold;
        }

        a:hover {
            color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: separate;
            margin: 20px 0;
        }

        th, td {
            border: 1px solid black;
            padding: 12px;
            text-align: left;
            /* border-bottom: 1px solid #ddd; */
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        button {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 5px;
        }

        button:hover {
            background-color: #0056b3;
        }

        img {
            max-width: 100px;
            height: auto;
        }
    </style>
</head>
<body>
    <h1>Команди!</h1>
    <a href="/teams_form.php">Додати команду</a>
    <br/>
    <br/>
    <a href="/table_list.php" target="_blank">До списку учасників</a>
    <br/>
    <br/>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Назва команди</th>
                <th>Логотип команди</th>
                <th>Опис команди</th>
                <th>Ім'я тренера</th>
                <th>Стаж тренера</th>
                <th>Дата створення запису </th>
                <th>Дії</th>
            </tr>
        </thead>
        <tbody>
            <?php
          
            foreach ($teams as $team) {
                echo "<tr>";
                echo "<td>{$team['id']}</td>";
                echo "<td>{$team['name']}</td>";
                echo "<td><img src='{$team['logo_path']}' alt='Обкладинка'></td>";
                echo "<td>{$team['description']}</td>";
                echo "<td>{$team['coach_name']}</td>";
                echo "<td>{$team['coach_experience']} года</td>";
                echo "<td>{$team['created_at']}</td>";
                echo "<td><a href='/teams_display.php?id={$team['id']}'>Переглянути команду</a></td>";
                echo "</tr>";
            }  
            ?>
        </tbody>
    </table>
</body>
</html>
