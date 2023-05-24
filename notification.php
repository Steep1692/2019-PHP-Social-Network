<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <?php
    include "head.php";
  ?>
  <title>Оповещения: <?php echo $_SESSION['login']; ?> - corner.ua</title>
</head>
<body>

<?php
include "header.php";
?>

<div class="container">
  <p class="title"><img src='img/notifi_mini.png' alt='Иконка'> Оповещения : </p>
  <ul class="notification-ul">
    <p>Список оповещений пуст.</p>
  </ul>
<?php
  include "footer.php";
?>

</div>
<script type="text/javascript">
  get_notification();
</script>
</body>
</html>
