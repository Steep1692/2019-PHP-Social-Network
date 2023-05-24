<?php
session_start();
include "connect.php";
$link_id = $_GET['link_id'];
$id = $_GET['id'];
$t2=$_GET['t2'];

$file_info = mysqli_query($db,"SELECT * FROM `$link_id` WHERE `id` ='$id'");
$file_info_array = mysqli_fetch_array($file_info);

$add_comment = "<a href='authorization.php'>Зарегистрируйтесь или войдите для того, что бы оставить комментарий</a>";
$edit_file = "";
if(isset($_SESSION['login'])){

  $edit_file = "<div class='edit-items'><a href='file_o.php?id=$id&link_id=$link_id&do=delete&t2=$t2'><img src='img/delete.png'></a>
  <a href='file_o.php?id=$id&link_id=$link_id&do=edit&t2=$t2'><img src='img/edit.png'></a></div>";
  $add_comment = "<div class='comment-form'>
  <textarea id='comment-input' class='form-control' type='text' name='comment' size='50' maxlength='500' placeholder='Напишите что-нибудь...'></textarea>
  <input class='btn btn-info' type='button' value='Оставить комментарий' onclick=\"send_comment('$link_id',$id)\"></div>";
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <?php
    include "head.php";
  ?>
  <title><?php echo $file_info_array['name']; ?> - corner.ua</title>
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
    echo "<a href='content_files.php?link_id=$link_id&id=$file_info_array[id_u]'>".$link_id."</a>";
     ?>
  </div>
</div>

<div class="file-info">
  <p class="file-name"></p>
  <img class="file-poster avatar-big" src="img/poster.png" alt="Скриншот">
  <?php echo $preview; ?>
  <p class="file-description"></p>
  <p><img src="img/about.png" alt='Автор'> Загрузил : <a class="file-author-link" href="#"><span class="file-author-name"></span></a><span class="file-date"></span></p>
  <a class="file-download-link" href="#"><img src="img/download_icon.png" alt="Загрузить">Скачать</a>
  <div class="edit-items">
    <?php
      echo $edit_file;
    ?>
  </div>
</div>

<div class="comments">
  <p>Комментарии(<span class="comments-count">0</span>)</p>
  <ul>

  </ul>
</div>


  <?php
    echo $add_comment;
  ?>
  <?php
    include "footer.php";
  ?>
</div>

<script type="text/javascript">
get_file('<?php echo $link_id; ?>','<?php echo $id; ?>');
get_comments("<?php echo $link_id; ?>", <?php echo $id; ?>);
</script>
</body>
</html>
