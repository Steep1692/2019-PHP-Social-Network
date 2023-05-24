<?php
include "connect.php";
$o = $_GET['o'];
if($o=="e_c_f")
{
$v = $_GET['value'];
$n = $_GET['name'];
$e = $_GET['exp'];
mysqli_query($db,"UPDATE `categories` SET `name`='$n', `expansion`='$e' WHERE `value`='$v'") or die("e_c_f mysqli error");
echo '<script type="text/javascript">';
echo 'window.location.href="adminka.php";';
echo '</script>';
}
if($o=="a_c_f")
{
$n = $_GET['name'];
$v = $_GET['value'];
$e = $_GET['exp'];
mysqli_query($db,"CREATE TABLE `$v` (`id` INT(9) NOT NULL AUTO_INCREMENT,PRIMARY KEY(`id`),`name` VARCHAR(75),`path` VARCHAR(255),`scr_path` VARCHAR(255) DEFAULT 'img/poster.png',`id_u` VARCHAR(9),`description` VARCHAR(300),`time_stamp` VARCHAR(60))") or die("a_c_f mysqli_query error 1");
$path='files/'.$v.'/';
if (!file_exists($path))
{
mkdir($path, 0700, true);
}
mysqli_query($db,"INSERT INTO `categories` (`name`,`value`,`expansion`) VALUES ('$n','$v','$e')") or die("a_c_f mysqli_query error 2");
echo '<script type="text/javascript">';
echo 'window.location.href="adminka.php";';
echo '</script>';
}
if($o=="a_d_f")
{
$v = $_GET['value'];
mysqli_query($db,"DROP TABLE `$v`") or die("a_d_f mysqli error");
mysqli_query($db,"DELETE FROM `categories` WHERE `value`='$v'") or die("a_d_f mysqli error 2");
function removeDirectory($dir){
if ($objs = glob($dir."/*"))
{
foreach($objs as $obj) {
is_dir($obj) ? removeDirectory($obj) : unlink($obj);
}
}
rmdir($dir);
}
removeDirectory('files/'.$v);
removeDirectory($v);
echo '<script type="text/javascript">';
echo 'window.location.href="adminka.php";';
echo '</script>';
}
if($o=="a_e_u")
{
$id = $_GET['id'];
$pos = $_GET['pos'];
$c = $_GET['coins'];
mysqli_query($db,"UPDATE `user` SET `pos`='$pos', `coins`='$c' WHERE `id`='$id'") or die("a_e_u mysqli_query error");
echo '<script type="text/javascript">';
echo 'window.location.href="adminka.php";';
echo '</script>';
}
?>
