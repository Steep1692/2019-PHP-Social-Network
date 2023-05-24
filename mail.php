<?php
session_start();

if(isset($_SESSION['id'])){
  include "connect.php";
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <?php
    include "head.php";
  ?>
  <title>Почта: <?php echo $_SESSION['login']; ?> - corner.ua</title>
</head>
<body>
<?php
include "header.php";
?>

<div class="container">

<p class="title"><img src='img/mail_2.png' alt='Иконка'> Диалоги</p>

<ul class="mail-ul">
  <p>История сообщений пуста, но Вы легко сможете найти себе собеседника <a href='users.php'>здесь</a> =)</p>
</ul>
<?php
  include "footer.php";
?>

</div>

<script type="text/javascript">
  get_mail();
</script>

</body>
</html>
