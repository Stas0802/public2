<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Список игроков</title>
    </head>
    <body>
        <h1>Players</h1>
        <form method="POST" action="list_handler.php" enctype="multipart/form-data">
            <p>Введіть Ім'я учасника</p>
            <input type="text" name="name" placeholder="Ім'я">
            <p>Вкажіть роль учасника</p>
            <input type="text" name="role" placeholder="Роль">
            <p>Країна походження учасника</p>
            <input type="text" name="country" placeholder="Країна">
            <br/>
            <input type="submit" value="Додати учасника">
        </form>
    </body>
</html>