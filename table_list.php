<?php

use Game\App\Classes\ListPlayers;



ini_set('display_errors',1);
error_reporting(E_ALL);
require __DIR__ . '/../vendor/autoload.php';

$players_list =  ListPlayers::fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Учасники</title>
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
            border-bottom: 1px solid #ddd;
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
    <h1>Учасники!</h1>
    <a href="/list_form.php">Додати учасника</a>
    <br/>
    <br/>
    <a href="/table_calendar.php" target="_blank">До календаря турнірів</a>
    <br/>
    <br/>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Ім'я учасника</th>
                <th>Роль учасника</th>
                <th>Країна учасника</th>
                <th>Дата створення запису </th>
                <th>Дії</th>
            </tr>
        </thead>
        <tbody>
            <?php
          
            foreach ($players_list as $list) {
                echo "<tr>";
                echo "<td>{$list['id']}</td>";
                echo "<td>{$list['name']}</td>";
                echo "<td>{$list['role']}</td>";
                echo "<td>{$list['country']}</td>";
                echo "<td>{$list['created_at']}</td>";
                echo "<td><a href='/list_display.php?id={$list['id']}'>Переглянути учасника</a></td>";
                echo "</tr>";
            }  
            ?>
        </tbody>
    </table>
</body>
</html>
