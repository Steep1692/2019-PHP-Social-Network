<?php
session_start();


if(isset($_SESSION['login'])){
  $id = $_GET["id"];
  include "connect.php";
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <?php
    include "head.php";
  ?>
  <title>corner.ua - Чат</title>
</head>
<body>

<?php
include "header.php";
?>

<div class="container">

    <ul class = "dialog-ul">
    </ul>

  <div class="dialog-form">
    <textarea class="form-control" id="dialog-input" type="text" name="msg" size="70" maxlength="75" placeholder="Напишите сообщение..."></textarea>
    <button class="btn btn-success" type="button" name="button" onclick="dialog_send_message('<?php echo $id; ?>')">Отправить</button>
  </div>

<?php
  include "footer.php";
?>

</div>
<script type="text/javascript">
get_dialog('<?php echo $id; ?>');
</script>
</body>
</html>
