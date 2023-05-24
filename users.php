<?php
session_start();
include "ajax.php";
include "connect.php";
$request = $_GET['request'];
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <?php
    include "head.php";
  ?>
  <title>Пользователи - corner.ua</title>
</head>
<body>

<?php
include "header.php";
?>

<div class="container">

  <p class="title"><img src='img/search_2.png' alt="Иконка"> Поиск</p>
<div class="search">
  <input id='search-input' type='text' name='search' size='33' maxlength='33' placeholder='Саня' value="<?php echo $request; ?>">
  <button class='btn btn-success' onclick="search_users()">Искать</button>
    <p>Результат: <span class="search-count">0</span></p>
    <ul class='search-ul'>
    </ul>
  </div>
  <div class="users">
    <p><img src='img/users_2.png' alt="Иконка"> Пользователи : <span class="users-count">0</span></p>
    <ul class='users-ul'>
    </ul>
  </div>

<?php
  include "footer.php";
?>

</div>
<script type="text/javascript">
  search_users();
  get_users();
</script>
</body>
</html>
