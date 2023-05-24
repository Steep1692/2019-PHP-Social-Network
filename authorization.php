<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <?php
    include "head.php";
  ?>
  <title>corner.ua - Авторизация</title>
</head>
<body>

<?php
include "header.php";
?>

<div class="container">

  <nav>
    <button class="btn btn-info" @click="show=!show">
      <span v-if="show">Регистрация</span>
      <span v-else>Вход</span>
    </button>
  </nav>

  <div v-show="show" class="log-block">
    Логин: <input class="form-control form-control-sm" type="text" id="log-login">
    Пароль: <input class="form-control form-control-sm" type="password" id="log-password">
    <br>
    <button class="btn btn-primary" type="button" name="button" onclick="login()">Войти</button>
  </div>

  <div v-show="!show" class="reg-block">
    Логин: <input class="form-control form-control-sm" type="text" id="reg-login">
    Пароль: <input class="form-control form-control-sm" type="password" id="reg-password">
    <br>
    <button class="btn btn-warning" type="button" name="button" onclick="register()">Зарегистрировать</button>
  </div>

  <div class="result">

  </div>

  <?php
  include "footer.php";
  ?>
</div>

<script src="js/vue.js"></script>
<script src="js/authorization.js"></script>

</body>
</html>
