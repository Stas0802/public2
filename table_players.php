<?php

use Game\App\Classes\Players;



ini_set('display_errors',1);
error_reporting(E_ALL);
require __DIR__ . '/../vendor/autoload.php';

$player_table =  Players::fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Гравці</title>
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
    <h1>Гравці!</h1>
    <a href="/players_form.php">Додати гравця</a>
    <br/>
    <br/>
    <a href="/table_teams.php" target="_blank">До списку команд</a>
    <br/>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Фото гравця</th>
                <th>Ім'я гравця</th>
                <th>Опис кар'єри гравця</th>
                <th>Досвід гравця</th>
                <th>Країна гравця</th>
                <th>Максимальний виграш гравця</th>
                <th>Дата створення запису </th>
                <th>Дії</th>
            </tr>
        </thead>
        <tbody>
            <?php
          
            foreach ($player_table as $play) {
                echo "<tr>";
                echo "<td>{$play['id']}</td>";
                echo "<td><img src='{$play['image_path']}' alt='Обкладинка'></td>";
                echo "<td>{$play['player_name']}</td>";
                echo "<td>{$play['career_description']}</td>";
                echo "<td>{$play['game_experience']} роки</td>";
                echo "<td>{$play['country_of_origin']} </td>";
                echo "<td>{$play['total_earnings']} $</td>";
                echo "<td>{$play['created_at']}</td>";
                echo "<td><a href='/players_display.php?id={$play['id']}'>Переглянути гравця</a></td>";
                echo "</tr>";
            }  
            ?>
        </tbody>
    </table>
</body>
</html>
