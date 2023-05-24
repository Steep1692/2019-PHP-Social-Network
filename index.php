<?php
session_start();
include "ajax.php";
$welcome_name = "<a href='authorization.php'>гость</a>";

if(isset($_SESSION['id'])){
  $welcome_name = "<a href='user.php?id=".$_SESSION['id']."'>".$_SESSION['login']."</a>";
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <?php
    include "head.php";
  ?>
  <title>corner.ua - Главная</title>
</head>
<body>

<?php
include "header.php";
?>

<div class="container">

  <h5>Добро пожаловать,
  <?php
  echo $welcome_name;
  ?>
  !</h5>
  <p>Онлайн пользователей: <?php echo site_online(); ?></p>
<ul>
  <li><a href="content.php"><img src="img/files.png" alt='Иконка'> Контент</a></li>
  <li><a href="users.php"><img src="img/users.png" alt='Иконка'> Юзеры</a></li>
  <li><a href="chat.php"><img src="img/chat.png" alt='Иконка'> Чат</a></li>
</ul>



<?php
  include "footer.php";
?>

</div>

</body>
</html>
