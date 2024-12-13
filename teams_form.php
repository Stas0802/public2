

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>TEAMS</title>
    </head>
    <body>
        <h1>Teams</h1>

        <form method="POST" action="teams_handler.php" enctype="multipart/form-data">
            <p>Введіть назву команди</p>
            <input type="text" name="name" placeholder="Назва команди">
            <p>Виберіть логотіп команди</p>
            <input type="file" name="logo">
            <p>Введіть опис команди</p>
            <textarea name="description" placeholder="Опис команди"></textarea>
            <p>Тренір</p>
            <input type="text" name="coach_name" placeholder="Ім'я треніра">
            <p>Стаж треніра</p>
            <input type="number" name="coach_experience" placeholder="Стаж треніра">
            <br/>
            <input type="submit" value="Додати">
        </form>
    </body>
    </html>
  