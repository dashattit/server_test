<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        * {
            font-family: Arial;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        header {
            background: #CDCDCD;
            height: 150px;
            width: 100%;
        }

        header {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-evenly;
        }

        nav a {
            text-decoration: none;
            color: #000;
            font-size: 32px;
            font-weight: bold;
            margin: 0 30px;
        }

        .login-container {
            background-color: #B1B1B1;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 500px;
            text-align: center;
            margin: 0 auto;
            font-size: 24px;
        }

        h2 {
            margin-bottom: 20px;
        }

        .input-group {
            margin-bottom: 15px;
        }

        input[type="text"],
        input[type="password"],
        .search-field,
        select {
            width: 100%;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 3px;
            font-size: 16px;
        }

        input[type="radio"] {
            height: 25px;
            width: 25px;
        }

        .divider {
            margin: 15px 0;
            border-top: 1px solid #000000;
        }

        .login-container button, .search-button, .search-form a, .login-container a {
            width: fit-content;
            padding: 5px;
            background-color: #FFFFFF;
            border: none;
            border-radius: 3px;
            color: rgb(0, 0, 0);
            font-size: 16px;
            text-decoration: none;
        }

        table {
            width: 100%;
            border: 1px solid black;
            border-collapse: collapse;
        }

        .table-container {
            background-color: #CDCDCD;
            width: 80%;
            height: fit-content;
        }

        caption {
            font-weight: bolder;
            margin-bottom: 32px;
            margin-top: 32px;
            font-size: 24px;
        }

        th {
            background-color: #EEEEEE;
        }

        th, td {
            border: 2px solid black;
            text-align: center;
            padding: 5px;
            height: 30px;
        }
        .avatar {
            width: 96px;
            height: 96px;
            padding: 0;
        }

        .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .reader-button {
            width: fit-content;
            margin: 20px;
        }

        .body-container {
            padding: 100px;
            font-size: 20px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
        }

        .body-container > a, .book-actions > a {
            background-color: #CDCDCD;
            text-decoration: none;
            color: black;
            border-radius: 3px;
            font-size: 24px;
            width: fit-content;
            padding: 10px;
            height: 50px;
        }

        .container {
            width: 90%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .errors {
            color: red;
            background-color: white;
            border-radius: 3px;
            margin-top: 20px;
            padding: 5px 0;
        }

        .errors > ul {
            list-style: none;
        }

        .book-actions {
            display: flex;
            flex-direction: column;
            gap: 30px;
        }

        select {
            width: 100%;
            border-radius: 3px;
            border-color: white;
        }

        textarea {
            width: 100%;
            border-radius: 3px;
            border-color: white;
        }

        .search-form {
            width: 300px;
            background-color: #CDCDCD;
            height: fit-content;
            padding: 20px;
            border-radius: 3px;
            display: flex;
            gap: 10px;
            flex-direction: column;
            align-items: center;
            font-size: 20px;
        }

        legend {
            text-align: center;
        }

        .right-panel {
            display: flex;
            flex-direction: column;
            gap: 30px;
        }

        .checkbox {
            width: 30px;
            height: 30px;
        }
    </style>
</head>
<body>
<header>
    <div class="container">
        <div class="logo">
            <a href="<?= app()->route->getUrl('/') ?>">
                <img src="/server/public/img/logo.png" alt="logo">
            </a>
        </div>
        <nav>
            <?php if (!app()->auth::check()): ?>
                <a href="<?= app()->route->getUrl('/login') ?>">Вход</a>
                <a href="<?= app()->route->getUrl('/signup') ?>">Регистрация</a>
                <a href="<?= app()->route->getUrl('/books') ?>">Книги</a>
            <?php else: ?>
                <a href="<?= app()->route->getUrl('/logout') ?>">Выход <?= app()->auth::user()->name ?></a>
            <?php if (app()->auth->user()->role->role_name == "Администратор"): ?>
                    <a href="<?= app()->route->getUrl('/librarians') ?>">Библиотекари</a>
            <?php endif; ?>
                <a href="<?= app()->route->getUrl('/readers') ?>">Читатели</a>
                <a href="<?= app()->route->getUrl('/books') ?>">Книги</a>
                <a href="<?= app()->route->getUrl('/authors') ?>">Авторы</a>
            <?php endif; ?>
        </nav>
    </div>
</header>
<main>
    <?= $content ?? '' ?>
</main>
</body>
</html>
