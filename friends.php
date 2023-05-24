<?php
session_start();
include "ajax.php";
include "connect.php";
$uid_2=$_GET['id_u2'];
$res_fr1 = mysqli_query($db,"SELECT * FROM `friends` WHERE `id_u`='$uid_2' AND `status_u`='1' AND `status_u2`='1' OR `id_u2`='$uid_2' AND `status_u`='1' AND `status_u2`='1'") or die("res_fr1");
$row_fr1 = mysqli_fetch_array($res_fr1);
$res_fr2 = mysqli_query($db,"SELECT * FROM `friends` WHERE `id_u`='$uid_2' AND `status_u`='1' AND `status_u2`='1' OR `id_u2`='$uid_2' AND `status_u`='1' AND `status_u2`='1'") or die("res_fr1");
$row_fr2 = mysqli_fetch_array($res_fr2);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <?php
    include "head.php";
  ?>
  <title>Друзья - corner.ua</title>
</head>
<body>

<?php
include "header.php";
?>

<div class="container">

  <?php
  echo "<p><img src='img/friends.png' alt='Иконка'> Друзья : </p>";
  echo "<ul>";
  if(count($row_fr1)>0){
    if($uid_2==$_SESSION[id]){
      do{
        if($row_fr1[id_u]==$_SESSION[id]){
        $res= mysqli_query($db,"SELECT * FROM `user` WHERE `id`='$row_fr1[id_u2]'");
        $row=mysqli_fetch_array($res);
        printf("<li><a href='user.php?id=$row[id]'>
        <img class='avatar-middle' src='".$row['avatar']."' alt='Аватар'>$row[login] ".on_line_usr($row[id])."</a></li>");
        }
      }while($row_fr1=mysqli_fetch_array($res_fr1));
      do{
        if($row_fr2[id_u2]==$uid_2){
          $res= mysqli_query($db,"SELECT * FROM `user` WHERE `id`='$row_fr2[id_u]'");
          $row=mysqli_fetch_array($res);
          printf("<li><a href='user.php?id=$row[id]'>
          <img class='avatar-middle' src='".$row['avatar']."' alt='Аватар'>$row[login] ".on_line_usr($row[id])."</a></li>");
        }
      }while($row_fr2=mysqli_fetch_array($res_fr2));
    }
    if($uid_2!=$_SESSION[id]){
      do{
      if($row_fr1[id_u2]==$uid_2){
        $res= mysqli_query($db,"SELECT * FROM `user` WHERE `id`='$row_fr1[id_u]'");
        $row=mysqli_fetch_array($res);
        printf("<li><a href='user.php?id=$row[id]'>
        <img class='avatar-middle' src='".$row['avatar']."' alt='Аватар'>$row[login] ".on_line_usr($row[id])."</a></li>");
      }
      }while($row_fr1=mysqli_fetch_array($res_fr1));
      do{
        if($row_fr2[id_u]==$uid_2){
          $res= mysqli_query($db,"SELECT * FROM `user` WHERE `id`='$row_fr2[id_u2]'");
          $row=mysqli_fetch_array($res);
          printf("<li><a href='user.php?id=$row[id]'>
          <img class='avatar-middle' src='".$row['avatar']."' alt='Аватар'>$row[login] ".on_line_usr($row[id])."</a></li>");
        }
      }while($row_fr2=mysqli_fetch_array($res_fr2));
    }
  }else {
    if($uid_2==$_SESSION[id]){
      echo "<p>Ваш список друзей пуст. Найти друга Вы сможете <a href='users.php'>здесь</a> =)</p>";
    }else {
      echo "<p>Список друзей пуст =(</p>";
    }
  }
  echo "</ul>";
  ?>

<?php
  include "footer.php";
?>

</div>

</body>
</html>
