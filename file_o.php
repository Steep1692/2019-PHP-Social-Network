<?php
session_start();
if(isset($_SESSION['id'])){
  include "connect.php";
  $id = $_GET['id'];
  $link_id = $_GET['link_id'];
  $do = $_GET['do'];
  $t2 = $_GET['t2'];
  $res_exp = mysqli_query($db,"SELECT * FROM `categories` WHERE `value` ='$link_id'") or die ("exp mysqli error");
  $array_res_exp = mysqli_fetch_array($res_exp);
  $exp =  $array_res_exp[expansion];
  $scrsht=0;
  if ($link_id=="image" or $link_id=="photogallery")
  {
  $scrsht=1;
  }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <?php
    include "head.php";
  ?>
  <title>Файл - corner.ua</title>
</head>
<body>
<?php
include "header.php";
?>

<div class="container">

  <?php
  if ($do=="add"){
    echo "<form enctype='multipart/form-data' action='file_o_res.php?link_id=$link_id&do=$do&t2=$t2' method='post'>";
    if($scrsht=='0')
      echo 'Скриншот : <input class="form-control" type="file" name="'.$link_id.'_scrfile" accept="image/*">';
      echo 'Название:<input class="form-control" type="text" name="name" size="21" maxlength="75" placeholder="Назовите файл...">
      Описание:<textarea class="form-control" type="text" name="description" maxlength="300" cols="75" rows="5" placeholder="Напишите описание..."></textarea>
      <input class="form-control" type="file" name="'.$link_id.'_file" accept="'.$exp.'">
      <input class="btn btn-success" type="submit" value="Загрузить"></form>';
    }
  if ($do=="delete"){
    echo '<p>Удалить файл?</p>
    <a href="file_o_res.php?id='.$id.'&link_id='.$link_id.'&do='.$do.'&t2='.$t2.'"><button class="btn btn-success" >Да</button></a>
    <a href="file.php?id='.$id.'&link_id=='.$link_id.'" ><button class="btn btn-success" >Нет</button></a>
    </a>';
  }
  if ($do=="edit"){
    echo '<form enctype="multipart/form-data" action="file_o_res.php?id='.$id.'&link_id='.$link_id.'&do='.$do.'&t2=scr" method="post">';
    if($scrsht=='0')
      echo '<button name="scr" value="0">Удалить скриншот</button>';
      echo '</form>
      <form enctype="multipart/form-data" action="file_o_res.php?id='.$id.'&link_id='.$link_id.'&do='.$do.'&t2='.$t2.'" method="post">
      Скриншот:<input class="form-control" type="file" name="'.$link_id.'_scrfile" accept="image/*">
      Название:<input class="form-control" type="text" name="name" size="21" maxlength="75" placeholder="Назовите файл...">
      Описание:<textarea class="form-control" type="text" name="description" maxlength="300" cols="75" rows="5" placeholder="Напишите описание..."></textarea>
      <input class="btn btn-success" type="submit" value="Сохранить">
      </form>';
  }
  ?>

<?php
  include "footer.php";
?>

</div>

</body>
</html>
