<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Players</title>
    </head>
    <body>
        <h1>Players</h1>

        <form method="POST" action="players_handler.php" enctype="multipart/form-data">
            <p>Фото гравця</p>
            <input type="file" name="image" required>
            <p>Ім'я гравця</p>
            <input type="text" name="player_name" placeholder="Ім'я гравця" required>
            <p>Опис кар'єри гравця</p>
            <textarea name="career_description" placeholder="Опис кар'єри гравця" required></textarea>
            <p>Досвід</p>
            <input type="number" name="game_experience" placeholder="Досвід гравця" required>
            <p>Країна гравця</p>
            <input type="text" name="country_of_origin" placeholder="Країна гравця" required>
            <p>Максимальний виграш</p>
            <input type="number" name="total_earnings" placeholder="Максимальний виграш" required>
           
            <br/>
            <input type="submit" value="Додати">
        </form>
    </body>
</html>

