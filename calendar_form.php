<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Calendar Form</title>
</head>
<body>
    <h1>Calendar Form</h1>
    <form method="POST" action="calendar_handler.php" enctype="multipart/form-data">
        <label for="event_name">Назва турніру:</label>
        <input type="text" id="event_name" name="event_name" placeholder="Введіть назву турніру" required><br/>

        <label for="start_date">Дата початку турніру:</label>
        <input type="date" id="start_date" name="start_date" placeholder="YYYY-MM-DD" required><br/>

        <label for="end_date">Дата кінця турніру:</label>
        <input type="date" id="end_date" name="end_date" placeholder="YYYY-MM-DD" required><br/>

        <label for="event_city">Місто провидіння турніру:</label>
        <input type="text" id="event_city" name="event_city" placeholder="Введіть місто провидіння турніру" required><br/>

        <label for="event_country">Країна провидіння турніру:</label>
        <input type="text" id="event_country" name="event_country" placeholder="Введіть країну провидіння турніру" required><br/>

        <label for="description">Опис турніру:</label>
        <textarea id="description" name="description" placeholder="Введіть опис турніру" rows="5" required></textarea><br/>

        <label for="format">Формат турніру:</label>
        <input type="text" id="format" name="format" placeholder="Введіть формат турніру" required><br/>

        <label for="prize_pool">Призовий фонд:</label>
        <input type="number" id="prize_pool" name="prize_pool" placeholder="Введіть призовий фонд" required><br/>

        <label for="logo">Logo:</label>
        <input type="file" id="logo" name="logo" accept="image/*" required><br/>

        <button type="submit">Створити</button>
    </form>
</body>
</html>
