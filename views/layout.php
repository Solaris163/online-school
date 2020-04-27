<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/style/main.css">
    <title>Онлайн школа</title>
</head>
<body>
<div class="main-container">
    <header>
        <h1 class="header_h1">Онлайн школа бухгалтеров</h1>
        <div class="header_menu">
            <div class="header_left">
                <a href="/">Главная</a>
            </div>
            <div class="header_right">
                <?php if ($auth): //проверка аутентификации пользователя ?>
                    <form action="/user/logout/">
                        Добро пожаловать <?=$login?>
                        <input type="submit" name="send" value="Выйти">
                    </form>
                <?php else: ?>
                    <form action="/user/login/" method="post">
                        <input type="text" name='login' placeholder="Введите login">
                        <input type="text" name='pass' placeholder="Введите пароль">
                        <input type='checkbox' name='save'> Запомнить?
                        <input type="submit" name="send" value="Войти">
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <?=$content?>
</div>

</body>
</html>
