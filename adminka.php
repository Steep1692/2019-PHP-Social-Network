<?php
session_start();
include "connect.php";
include "ajax.php";
$res_user = mysqli_query($db,"SELECT * FROM `user` WHERE `id`='1'") or die("mysqli : get user information error!");
$arr_res_user = mysqli_fetch_array($res_user);
if($arr_res_user['pos']=="3"){
?>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" href="images/logo.png" type="image/x-icon">
<link rel="stylesheet" href="style/style.css">
<title>Управление сайтом</title>
<style type="text/css">
 </style>
</head>
<body>
<div id="body">
<!--//block1-->
<?php
include "header.php";
?>
      <?php
echo "Изменить каталог :";
       echo "<form action='adminka_o.php' method='get'>";
    $res = mysqli_query($db,"SELECT * FROM `categories`") or die ("categories error");
    $arr_res = mysqli_fetch_array($res);
    if(count($arr_res)>0){
    do{
    echo '<input type="radio" name="value" value="'.$arr_res[value].'"><p id="link" style="margin-top:7px;"><a href="adminka_o.php?o=a_d_f&value='.$arr_res[value].'">Удалить</a> <a id="link" href="files_cat.php?val='.$arr_res[value].'"><img src="images/folder_mini.png"> '.$arr_res[name].'</a>(Exp : '.$arr_res[expansion].')</p></a>';
    }while($arr_res = mysqli_fetch_array($res));
    }
    else
    {
        echo "Каталоги отсутствуют!<br/>";
    }
echo "Name : <input name='name' type='text'></input><br/>";
echo "Expansion : <input name='exp' type='text'></input><br/>";
echo "o : <input name='o' type='o' value='e_c_f'></input><br/>";
echo "<input type='submit' value='Изменить'>";
echo "</form>";
echo "<hr/>Добавить каталог :";
echo "<form action='adminka_o.php' method='get'>";
echo "Name : <input name='name' type='text'></input><br/>";
echo "Value : <input name='value' type='text'></input><br/>";
echo "Expansion : <input name='exp' type='text'></input><br/>";
echo "o : <input name='o' type='o' value='a_c_f'></input><br/>";
echo "<input type='submit' value='Создать'></input>";
echo "</form>";
echo "<hr/>Операции с пользователями :";
$res2 = mysqli_query($db,"SELECT * FROM `user`") or die ("users error");
$arr_res2 = mysqli_fetch_array($res2);
echo "<form action='adminka_o.php' method='get'>";
echo "List : <select name='id'>";
do{
echo "<option value='$arr_res2[id]'>id : $arr_res2[id] login : $arr_res2[login] pos : $arr_res2[pos] coins : $arr_res2[coins]</option>";
}while($arr_res2 = mysqli_fetch_array($res2));
echo "</select><button formaction='lk.php'>К осмотру</button><br/>";
echo "Pos : <select name='pos'>";
echo "<option value='1'>1</option>";
echo "<option value='2'>2</option>";
echo "<option value='3'>3</option>";
echo "</select><br/>";
echo "Coins : <input type='text' name='coins'></input><br/>";
echo "o : <input name='o' type='o' value='a_e_u'></input><br/>";
echo "<input type='submit' value='Изменить'></input>";
echo "</form>";
?>
</div>
<?php
include "footer.php";
?>
</body>
</html>
<?php }else {echo "You are not admin!";}?>
