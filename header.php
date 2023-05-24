<header>
  <div class="row align-items-center">
    <div class="col">
      <a href="index.php"><img src='img/index.png' alt='Главная'></a>
    </div>
    <div class="col">
      <?php
      $empty = "Авторизация";
      $link = "authorization.php";
      $icon = "<img src='img/authorization.png' alt='Аккаунт'>";
      if(!isset($_SESSION['login'])){
        echo "<a href='".$link."'>".$icon.$empty."</a>";

      }else{
        $icon = "<img class='avatar-middle' src='".$_SESSION['avatar']."' alt='Аватар'>";
        echo "<a href='user.php?id=".$_SESSION['id']."'>".$icon.$_SESSION['login']."</a>";
      }
     ?>
    </div>
      <?php
      if(isset($_SESSION['login'])){
        echo "<div class='col'><a href='mail.php'><img src='img/mail.png' alt='Почта'><span class='mail'></span></a>
        </div>
        <div class='col'>
        <a href='notification.php'><img src='img/notifi.png' alt='Уведомления'><span class='notification'></span></a>
        </div>";
      }
       ?>
    <div class="col">
      <a href="users.php"><img src='img/search_head.png' alt='Поиск'></a>
    </div>
  </div>
</header>
<script type="text/javascript">
get_count_ntf_msg();
</script>
