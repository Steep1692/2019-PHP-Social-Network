<?php
session_start();
include "connect.php";
include "ajax.php";
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <?php
    include "head.php";
  ?>
  <title>Чат - corner.ua</title>
</head>
<body>
<?php
include "header.php";
?>

<div class="container">

  <p>В чате : <?php echo chat_online(); ?></p>
  <ul class="chat-ul">
  </ul>
  <div class="chat-form">
    <input id="chat-input" type="text" name="msg" size="70" maxlength="75" placeholder="Напишите сообщение...">
    <button class="btn btn-success" onclick="send_glob_chat()">Отправить</button>
  </div>

<?php
  include "footer.php";
?>

</div>
<script type="text/javascript">
  get_glob_chat();
</script>
</body>
</html>
