<?php if ($is_admin): //проверка, является ли пользователь администратором ?>

<h1>Вы находитесь в панели администратора</h1>

<a href="/adminPanel/userList">Посмотреть список пользователей</a><br><br>

<?=$content;?>

<?php else: ?>

<h3>Эта страница только для администраторов</h3>

<?php endif; ?>