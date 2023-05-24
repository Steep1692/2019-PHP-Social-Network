<?php
session_start();
include "connect.php";
$id = $_GET['id'];
$link_id = $_GET['link_id'];
$do = $_GET['do'];
$t2 = $_GET['t2'];
function get_name($g){
  $g = strtr($g, array('а'=>'a','б'=>'b','в'=>'v','г'=>'g','д'=>'d','е'=>'e','ё'=>'e','ж'=>'j','з'=>'z','и'=>'i','й'=>'y','к'=>'k','л'=>'l','м'=>'m','н'=>'n','о'=>'o','п'=>'p','р'=>'r','с'=>'s','т'=>'t','у'=>'u','ф'=>'f','х'=>'h','ц'=>'c','ч'=>'ch','ш'=>'sh','щ'=>'shch','ы'=>'y','э'=>'e','ю'=>'yu','я'=>'ya','ъ'=>'','ь'=>''));
  $g = str_replace(" ", "-", $g); // заменяем пробелы знаком минус
  $g = function_exists('mb_strtolower') ? mb_strtolower($g) : strtolower($g); // переводим строку в нижний регистр (иногда надо задать локаль)
  $g = preg_replace("/[^0-9a-z-_.]/i", "", $g); // очищаем строку от недопустимых символов
  $g = str_replace(array("\n", "\r"), "", $g);
  return $g;
}
function mk_dir($path){
  if (!file_exists($path)){
    mkdir($path, 0700, true);
  }
  return $path;
}
?>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" href="images/logo.png" type="image/x-icon">
<link rel="stylesheet" href="style/style.css">
<title>Результат</title>
<style type="text/css">
 </style>
</head>
<body>
<div id="body">
<!--//block1-->
<div  id="header">
    <a href='index.php'><div id="btn_index"><img src='images/index.png' id='header_btn'></div></a>
 <?php
include "header.php";
    ?>
</div>
<?php if ($do=="add"){
if ($t2=="d"){
$name_file = $_FILES[$link_id."_file"]["name"];
$g=get_name($name_file);
$name_scrfile = $_FILES[$link_id."_scrfile"]["name"];
$s=get_name($name_scrfile);
if (isset($_POST["name"]))
{
  $name = $g;
}
   if (isset($_POST["description"]))
{
  $description = "Описание отсутствует.";
}
$dir="files/$link_id/$_SESSION[id]/";
$file_path=mk_dir($dir).$g;
$scr_dir="files/$link_id/$_SESSION[id]/scr/";
if($link_id!="image"){
  $scr_path=mk_dir($scr_dir).$s;
  if($scr_path!="files/$link_id/$_SESSION[id]/scr/"){
    move_uploaded_file($_FILES[$link_id."_scrfile"]["tmp_name"],$scr_path) or die("move scr");
  }else {
    $scr_path="img/poster.png";
  }
}
$time = time();
move_uploaded_file($_FILES[$link_id."_file"]["tmp_name"],$file_path) or die("move file");
mysqli_query($db,"INSERT INTO `$link_id` (`name`,`path`,`scr_path`,`id_u`,`description`,`time_stamp`) VALUES ('$name','$file_path','$scr_path','".$_SESSION['id']."','$description','$time')") or die("query");
echo "Файл успешно загружен. Сейчас Вы автоматически будете перенаправлены в раздел.";
echo '<script type="text/javascript">';
echo 'window.location.href="content_files.php?link_id='.$link_id.'";';
echo '</script>';
}
else if ($t2 =="p"){
$g = $_FILES[$link_id."_file"]["name"];
get_name($g);
if (isset($_POST["name"]))
{
  $name = $g;
}
   if (isset($_POST["description"]))
{
  $description = "Описание отсутствует.";
}
$file_path='users/'.$_SESSION[id].'/photogallery/'.$g;
$time=time();
           if (!file_exists('users/'.$_SESSION[id].'/photogallery/'))
        {
        mkdir('users/'.$_SESSION[id].'/photogallery/', 0700, true);
        }
move_uploaded_file($_FILES[$link_id."_file"]["tmp_name"],$file_path) or die("move");
mysqli_query($db,"INSERT INTO `photogallery` (`name`,`path`,`id_u`,`description`,`time_stamp`) VALUES ('$name','$file_path','".$_SESSION['id']."','$description','$time')") or die("query");
echo '<script type="text/javascript">';
echo 'window.location.href="user.php?id='.$_SESSION['id'].'";';
echo '</script>';
}else if ($t2 =="add"){
$g = get_name($_FILES[$link_id."_file"]["name"]);
if (isset($_POST["name"])){
  $name = $g;
}
if (isset($_POST["description"])){
  $description = "Описание отсутствует.";
}
$file_path='users/'.$_SESSION[id].'/photogallery/'.$g;
echo $g;
$time=time();
   if (!file_exists('users/'.$_SESSION[id].'/photogallery/'))
        {
        mkdir('users/'.$_SESSION[id].'/photogallery/', 0700, true);
        }
mysqli_query($db,"UPDATE `user` SET avatar='$file_path' WHERE id='".$_SESSION['id']."'");
move_uploaded_file($_FILES[$link_id."_file"]["tmp_name"],$file_path) or die("move");
mysqli_query($db,"INSERT INTO `photogallery` (`name`,`path`,`id_u`,`description`,`time_stamp`) VALUES ('$name','$file_path','".$_SESSION['id']."','$description','$time')") or die("query");
echo '<script type="text/javascript">';
echo 'window.location.href="user.php?id='.$_SESSION['id'].'";';
echo '</script>';
}
}
if ($do=="delete"){
        if($t2=="a")
        {
$avatar_path="/users/0/no_avatar.gif";
mysqli_query($db,"UPDATE `user` SET avatar='$avatar_path' WHERE id='".$_SESSION['id']."'");
mysqli_query($db,"DELETE  FROM `photogallery` WHERE `path`='$id'");
            echo '<script type="text/javascript">';
            echo 'window.location.href="user.php?id='.$_SESSION['id'].'";';
            echo '</script>';
        }
    else if($t2=="p")
        {
mysqli_query($db,"DELETE  FROM `photogallery` WHERE `id`='$id'");
mysqli_query($db,"DELETE  FROM `comments` WHERE `file_id`='$id' AND `value`='$link_id'");
            echo '<script type="text/javascript">';
            echo 'window.location.href="user.php?id='.$_SESSION['id'].'";';
            echo '</script>';
        }
    else if($do=="d")
        {
$res = mysqli_query($db,"SELECT * FROM `$link_id` WHERE `id`='$id'") or die("mysqli res error");
$row = mysqli_fetch_array($res);
if($row[scr_path]!="0"){
unlink($row[scr_path]) or die("unlink scr error");
}
mysqli_query($db,"DELETE  FROM `$link_id` WHERE `id`='$id'");
mysqli_query($db,"DELETE  FROM `comments` WHERE `file_id`='$id' AND `value`='$link_id'");
unlink($row[path]) or die("unlink file error");
         echo '<script type="text/javascript">';
         echo 'window.location.href="content_files.php?val='.$link_id.'";';
         echo '</script>';
        }
    }
    if ($do=="edit"){
if ($t2=="p"){
      $_POST[name] = str_replace(" ", "_", $_POST[name]);;
    if ($_POST[name]=="" and $_POST[description]=="")
    {
echo "Изменений нет";
    }
    else if($_POST[name]=="")
    {
    mysqli_query($db,"UPDATE `$link_id` SET `description`='$_POST[description]' WHERE `id`='$id'");
    }
    else if($_POST[description]=="")
    {
     mysqli_query($db,"UPDATE `$link_id` SET `name`='$_POST[name]' WHERE `id`='$id'");
    }
    else
    {
    mysqli_query($db,"UPDATE `$link_id` SET `name`='$_POST[name]', `description`='$_POST[description]' WHERE `id`='$id'");
    }
echo '<script type="text/javascript">';
echo 'window.location.href="file.php?id='.$id.'&val='.$link_id.'&t2='.$t2.'";';
echo '</script>';
    }else if ($t2=="scr"){
$res = mysqli_query($db,"SELECT * FROM `$link_id` WHERE `id`='$id'") or die("mysqli res error");
$row = mysqli_fetch_array($res);
if(isset($row[scr_path])){
  mysqli_query($db,"UPDATE `$link_id` SET `scr_path`='img/poster.png' WHERE `id`='$id'") or die("upd mysqli scr_path");
  unlink($row[scr_path]) or die("unlink old scr error");
}
echo '<script type="text/javascript">';
echo 'window.location.href="file.php?id='.$id.'&link_id='.$link_id.'";';
echo '</script>';
}else{
$res = mysqli_query($db,"SELECT * FROM `$link_id` WHERE `id`='$id'") or die("mysqli res error");
$row = mysqli_fetch_array($res);
$name_scrfile = $_FILES[$link_id."_scrfile"]["name"];
$s=get_name($name_scrfile);
$scr_dir="files/$link_id/$_SESSION[id]/scr/";
$scr_path=mk_dir($scr_dir).$s;
if($scr_path!="files/$link_id/$_SESSION[id]/scr/"){
if($row[scr_path]!="0"){
unlink($row[scr_path]) or die("unlink old scr error");
}
move_uploaded_file($_FILES[$link_id."_scrfile"]["tmp_name"],$scr_path) or die("move scr");
mysqli_query($db,"UPDATE `$link_id` SET `scr_path`='$scr_path' WHERE `id`='$id'") or die("upd mysqli scr_path");
}
      $_POST[name] = str_replace(" ", "_", $_POST[name]);;
            if($_POST[name]=="")
    {
    mysqli_query($db,"UPDATE `$link_id` SET `description`='$_POST[description]' WHERE `id`='$id'");
    }
    else if($_POST[description]=="")
    {
     mysqli_query($db,"UPDATE `$link_id` SET `name`='$_POST[name]' WHERE `id`='$id'");
    }
    else
    {
    mysqli_query($db,"UPDATE `$link_id` SET `name`='$_POST[name]', `description`='$_POST[description]' WHERE `id`='$id'");
    }
echo '<script type="text/javascript">';
echo 'window.location.href="file.php?id='.$id.'&link_id='.$link_id.'&t2='.$t2.'";';
echo '</script>';
    }
    }
    ?>
</a>
</div>
<div id="footer">
<?php
include "footer.php";
?>
</div>
</body>
</html>
