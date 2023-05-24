<?php
session_start();
include "connect.php";
include "ajax.php";

$link_id = $_GET['link_id'];
$user_id = $_GET['user_id'];
$page = $_GET['page'];

$get_files=mysqli_query($db,"SELECT * FROM `categories` WHERE `link_id`='$link_id'") or die("get_files");
$get_files_arr=mysqli_fetch_array($get_files);

$add_file = "<a href='authorization.php'>Зарегистрируйтесь или войдите для того, что бы добавить файл</a>";
if(isset($_SESSION['id'])){
  $add_file = "<a href='file_o.php?link_id=$link_id&do=add&t2=d'>Добавить файл</a>";
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <?php
    include "head.php";
  ?>
  <title><?php echo $get_files_arr['name']; ?> - corner.ua</title>
</head>
<body>

<?php
include "header.php";
?>

<div class="container">

  <div class="row">
    <div class="col">
      <img src="img/folder.png">
      <a href="content.php">Файлотека</a>
    </div>
    <div class="col">
      <?php
      echo "<a href='content_files.php?link_id=$get_files_arr[value]&id=$user_id&p=0'>".$get_files_arr['name']."</a>";
       ?>
    </div>
  </div>

<ul>

</ul>

  <span>
    <?php
    echo $add_file;
    ?>
  </span>


  <?php
  include "footer.php";
  ?>

</div>

<script type="text/javascript">
  get_files('<?php echo $link_id; ?>','<?php echo $user_id; ?>','<?php echo $page; ?>');
</script>

</body>
</html>
