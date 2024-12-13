<?php

use Game\App\Classes\CalendarTournaments;


ini_set('display_errors', 1);
error_reporting(E_ALL);
require __DIR__ . '/../vendor/autoload.php';

$calendar = CalendarTournaments::fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Календар турніру</title>
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
    <h1>Календар турніру</h1>
    <a href="/calendar_form.php">Додати турнір</a>
    <br/><br/>
    <a href="/table_players.php" target="_blank">Перегляд гравця</a>
    <br/><br/>
    
    <table id="gamesTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Назва турніру</th>
                <th>Дата початку турніру</th>
                <th>Дата закінчення турніру</th>
                <th>Місто турніру</th>
                <th>Країна турніру</th>
                <th>Опис</th>
                <th>Формат</th>
                <th>Призовий фонд</th>
                <th>Логотип</th>
                <th>Дата створення</th>
                <th>Дії</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($calendar as $cal_tour) {
                echo "<tr>";
                echo "<td>{$cal_tour['id']}</td>";
                echo "<td>{$cal_tour['event_name']}</td>";
                echo "<td>{$cal_tour['start_date']}</td>";
                echo "<td>{$cal_tour['end_date']}</td>";
                echo "<td>{$cal_tour['event_city']}</td>";
                echo "<td>{$cal_tour['event_country']}</td>";
                echo "<td>{$cal_tour['description']}</td>";
                 echo "<td>{$cal_tour['format']} </td>";
                echo "<td>{$cal_tour['prize_pool']} $ </td>";
                echo "<td><img src='{$cal_tour['logo_path']}' alt='Логотип'></td>";
                echo "<td>{$cal_tour['created_at']}</td>";
                echo "<td><a href='/calendar_display.php?id={$cal_tour['id']}'>Переглянути</a></td>";
                echo "</tr>";
            }  
            ?>
        </tbody>
    </table>
</body>
</html>
