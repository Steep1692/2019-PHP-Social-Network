<?php
session_start();
include "ajax.php";
include "connect.php";
$id = $_GET['id'];
$get_user = mysqli_query($db,"SELECT * FROM `user` WHERE `id` ='$id'") or die(mysqli_error());
$get_user_arr = mysqli_fetch_array($get_user);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <?php
    include "head.php";
  ?>
  <title><?php echo $get_user_arr['login']; ?> - corner.ua</title>
</head>
<body>

<?php
include "header.php";
?>

<div class="container">

  <div class='avatar'>
    <div class="avatar-top">
    </div>
    <div class="avatar-main avatar-big">
      <img class='avatar-img avatar-big' src='users/0/no_avatar.gif' alt='Аватар'>
      <div class="edit-avatar-items owner">
        <a href='#!' onclick="">Загрузить</a>
        <a href='#!' onclick="user_delete_avatar()">Удалить</a>
      </div>
    </div>
    <div class="avatar-bottom">
      <span class="avatar-pos"></span>
      <p>
        <span class='avatar-status'></span>
        <a class="owner" href='#!' @click="show_status_form=!show_status_form"><img class="icon-sm" src='img/edit_2.png' alt='Редактировать'></a>
      </p>
      <div class="user-status-form owner" v-show="show_status_form">
        <input id="status-edit-input" class="form-control" type="text" maxlength="100" placeholder="">
        <button class="btn btn-success" onclick="user_set_status()">Сохранить</button>
      </div>
    </div>
  </div>

  <div class="profile">
      <p class='title'><img src='img/more.png' alt='Иконка'> Анкета <a class="owner" href='#!' @click="show_profile_form=!show_profile_form"><img class="icon-sm" src='img/edit_2.png' alt='Редактировать'></a></p>
      <div class="user-profile-form owner" v-show="show_profile_form">
        <input id="name" class="form-control" type="text" maxlength="15" placeholder="Имя">
        <input id="surname" class="form-control" type="text" maxlength="15" placeholder="Фамилия">
        <input id="bdate" class='form-control' type="date" value = "" name="mydate">
        <input id="sity" class="form-control" type="text" maxlength="60" placeholder="Страна, город...">
        <select id="sex">
          <option type="radio" checked name="sex" value="1">Мужчина</option>
          <option type="radio" name="sex" value="2">Женщина</option>
        </select>
        <button class="btn btn-success" onclick="user_set_profile()">Сохранить</button>
      </div>
      <p>Имя : <span class='profile-name'></span></p>
      <p>Фамилия : <span class='profile-surname'></span></p>
      <p>Место проживания : <span class='profile-sity'></span></p>
      <p>Дата рождения : <span class='profile-bdate'></span></p>
      <p class='user-coins owner'></p>
  </div>

    <div class='gallery'>
      <p class='title'><img src='img/photo_gallery.png' alt='Иконка'> Фотогалерея</p>
      <p class="text-empty">Пусто</p>
      <div style='cursor: pointer;' class="gallery-items" @click='show_carousel=!show_carousel'>
      </div>
      <div v-show='show_carousel' id='carouselExampleControls' class='carousel'>
        <div class='carousel-inner'>

          <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          </a>
          <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
          </a>
        </div>
      </div>
      <a class="owner" href='file_o.php?'><img src='img/add.png' alt='Добавить'></a>
    </div>

  <ul class="buttons">
    <li class="for-guest">
      <a class="friend-status" href='#!' onclick="get_friend_status()"><img src='img/user.png' alt="Иконка"> <span class="friend-status-span"></span></a>
    </li>
    <li>
      <a class="user-friends" href='friends.php?#'><img src='img/friends.png' alt="Иконка"> Друзья</a>
    </li>
    <li class="owner">
      <a href='ajax.php?act=logout'><img src='img/exit.png' alt="Иконка"> Выход</a>
    </li>
  </ul>


  <script type="text/javascript">
  user_get_profile('<?php echo $id; ?>');
  user_get_status('<?php echo $id; ?>');
  get_photogallery('photogallery', '<?php echo $id; ?>', '0');
  get_friend_status('<?php echo $id; ?>');
  </script>


<?php
  include "footer.php";
?>

</div>
<script src="js/vue.js"></script>
<script src="js/user.js"></script>
<script src="http://cdn.jsdelivr.net/webshim/1.12.4/extras/modernizr-custom.js"></script>
<script src="http://cdn.jsdelivr.net/webshim/1.12.4/polyfiller.js"></script>
<script>
  webshims.setOptions('waitReady', false);
  webshims.setOptions('forms-ext', {type: 'date'});
  webshims.setOptions('forms-ext', {type: 'time'});
  webshims.polyfill('forms forms-ext');
</script>
</body>
</html>
