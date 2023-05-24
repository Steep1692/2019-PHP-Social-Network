<?php
session_start();
if(isset($_SESSION['id'])){
  upd_online_usr();
}
$act = $_GET["act"];
if($act == "user_set_profile"){
  $name = $_GET['name'];
  $surname = $_GET['surname'];
  $sity = $_GET['sity'];
  $bdate = $_GET['bdate'];
  $sex = $_GET['sex'];
  user_set_profile($name, $surname, $sity, $bdate, $sex);
}
if($act == "user_get_profile"){
  $id = $_GET['id'];
  user_get_profile($id);
}
if($act == "user_set_status"){
  $text = $_GET['text'];
  user_set_status($text);
}
if($act == "user_set_avatar"){
  $file = $_GET[''];
  user_set_status($text);
}
if($act == "user_get_avatar"){
  $id = $_GET['id'];
  user_get_status($id);
}
if($act == "get_files"){
  $link_id = $_GET['link_id'];
  $user_id = $_GET['user_id'];
  $page = $_GET['page'];
  get_files($link_id, $user_id, $page);
}
if($act == "get_categories"){
  get_categories();
}
if($act == "get_user"){
  $id = $_GET['id'];
  get_user($id);
}
if($act == "get_file"){
  $link_id = $_GET['link_id'];
  $id = $_GET['id'];
  get_file($link_id, $id);
}
if($act == "logout"){
  if(isset($_SESSION['login']) && isset($_SESSION['id'])){
    session_destroy();
    echo '<script type="text/javascript">';
    echo 'window.location.href="authorization.php";';
    echo '</script>';
  } else {
    exit ("Выход с личного кабинета доступен только зарегистрированым пользователям!");
  }
}
if($act == "set_status"){
  $status = $_POST['status'];
  set_status($status);
}
if($act == "save_anket"){
  $name = $_POST['name'];
  $surname = $_POST['surname'];
  $sex = $_POST['sex'];
  $bdate = $_POST['bdate'];
  $sity = $_POST['sity'];
  save_anket($name, $surname, $sex, $bdate, $sity);
}
if($act == "get_dialog"){
  $id = $_GET["id"];
  get_dialog($id);
}
if($act=="dialog_send_message"){
  $id = $_GET['id'];
  $text = $_GET['text'];
  dialog_send_message($id, $text);
}
if($act=="ntf_msg"){
  ntf_msg();
}
if($act == "get_glob_chat"){
  get_glob_chat();
}
if($act == "send_glob_chat"){
  $text = $_GET['text'];
  send_glob_chat($text);
}
if($act=="login"){
  $login = $_GET['login'];
  $pwd = $_GET['pwd'];
  login($login,$pwd);
}
if($act=="reg"){
  $login = $_GET['login'];
  $pwd = $_GET['pwd'];
  register($login,$pwd);
}
if($act=="get_cmt"){
  $link_id = $_GET['link_id'];
  $id = $_GET['id'];
  get_comments($link_id, $id);
}
if($act=="send_cmt"){
  $id = $_GET['id'];
  $link_id = $_GET['link_id'];
  $text = $_GET['text'];
  send_comment($id,$link_id,$text);
}
if($act=='del_cmt'){
  $id = $_GET['id'];
  delete_comment($id);
}
if($act=='srch_usrs'){
  $request = $_GET['request'];
  search_users($request);
}
if($act=='get_users'){
  get_users();
}
if($act == 'set_friend_status'){
  $id = $_GET['id'];
  $set = $_GET['set'];
  set_friend_status($id, $set);
}
if($act=='get_friend_status'){
  $id = $_GET['id'];
  if($id != $_SESSION['id'])
    get_friend_status($id);
}
if($act=='get_mail'){
  get_mail();
}
if($act == 'get_notification'){
  get_notification();
}
if($act == 'delete_notification'){
  $id = $_GET['id'];
  delete_notification($id);
}
function user_set_profile($name, $surname, $sity, $bdate, $sex){
  include "connect.php";
  mysqli_query($db,"UPDATE `user` SET `sex`='$sex' WHERE `id` = '".$_SESSION['id']."'");
  if($name != "")
    mysqli_query($db,"UPDATE `user` SET `name` = '$name' WHERE `id` = '".$_SESSION['id']."'");
  if($surname != "")
    mysqli_query($db,"UPDATE `user` SET `surname` = '$surname' WHERE `id` = '".$_SESSION['id']."'");
  if($bdate != "")
    mysqli_query($db,"UPDATE `user` SET `bdate` = '$bdate' WHERE `id` = '".$_SESSION['id']."'");
  if($sity != "")
    mysqli_query($db,"UPDATE `user` SET `sity` = '$sity' WHERE `id` = '".$_SESSION['id']."'");
    echo json_encode($_SESSION['id']);
}
function user_get_profile($id){
  include "connect.php";
  $get_user = mysqli_query($db,"SELECT * FROM `user` WHERE `id` ='$id'") or die(mysqli_error());
  $get_user_arr = mysqli_fetch_array($get_user);
  $owner = false;
  $coins = "";
  $online = get_user_online($get_user_arr['id']);
  if ($id == $_SESSION['id']){
    $owner = true;
    $coins = $get_user_arr['coins'];
  }
  $return = [ "owner" => $owner,
              "id" => $get_user_arr['id'],
              "login" => $get_user_arr['login'],
              "name" => $get_user_arr['name'],
              "surname" => $get_user_arr['surname'],
              "avatar" => $get_user_arr['avatar'],
              "pos" => $get_user_arr['pos'],
              "bdate" => $get_user_arr['bdate'],
              "status" => $get_user_arr['status'],
              "sex" => $get_user_arr['sex'],
              "sity" => $get_user_arr['sity'],
              "coins" => $coins,
              "online" => $online
  ];
  echo json_encode($return);
}
function delete_notification($id){
  include "connect.php";
  mysqli_query($db, "DELETE FROM `notifi` WHERE `id_u` = '$_SESSION[id]' AND `id_u2`='$id'") or die("delete_notification");
}
function get_notification(){
  include "connect.php";
  $notification = array();
  $return = array();
  $get_notification = mysqli_query($db,"SELECT * FROM `notifi` WHERE `id_u` = '$_SESSION[id]'") or die("get_notification");
  $get_notification_arr = mysqli_fetch_array($get_notification);
  if(count($get_notification_arr) > 0){
    do {
      $get_user = mysqli_query($db,"SELECT * FROM `user` WHERE `id` ='$get_notification_arr[id_u2]'") or die(mysqli_error());
      $get_user_arr = mysqli_fetch_array($get_user);
      $date = date("d.m.y h:s",$get_notification_arr['time_stamp']);
      $notification = [ "id" => $get_notification_arr['id_u2'],
                        "name" => $get_user_arr['login'],
                        "avatar" => $get_user_arr['avatar'],
                        "date" => $date
      ];
      array_push($return, $notification);
    } while ($get_notification_arr = mysqli_fetch_array($get_notification));
    echo json_encode($return);
  }
}
function get_user($id){
    include 'connect.php';
    $get_user = mysqli_query($db,"SELECT * FROM `user` WHERE `id` ='$id'") or die(mysqli_error());
    $get_user_arr = mysqli_fetch_array($get_user);
    $owner = false;
    $coins = "";
    $online = get_user_online($get_user_arr['id']);
    if ($id == $_SESSION['id']){
      $owner = true;
      $coins = $get_user_arr['coins'];
    }
    $return = [ "owner" => $owner,
                "id" => $get_user_arr['id'],
                "login" => $get_user_arr['login'],
                "name" => $get_user_arr['name'],
                "surname" => $get_user_arr['surlogin'],
                "avatar" => $get_user_arr['avatar'],
                "pos" => $get_user_arr['pos'],
                "bdate" => $get_user_arr['bdate'],
                "sex" => $get_user_arr['sex'],
                "sity" => $get_user_arr['sity'],
                "status" => $get_user_arr['status'],
                "coins" => $coins,
                "online" => $online
    ];
    echo json_encode($return);
}
function user_set_status($text){
  include("connect.php");
  if(isset($text))
    mysqli_query($db,"UPDATE `user` SET `status`='$text' WHERE `id`='".$_SESSION['id']."'");
  echo json_encode($_SESSION['id']);
}
function user_get_status($id){
  include("connect.php");
  $get_status = mysqli_query($db,"SELECT `status` FROM `user` WHERE id='$id'") or die('get_user_status');
  $get_status_arr = mysqli_fetch_array($get_status);
  echo json_encode($get_status_arr);
}
function can_edit($id){
    include "connect.php";
  $get_user =mysqli_query($db,"SELECT * FROM `user` WHERE `id`='$_SESSION[id]'") or die("mysqli_query error");
  $get_user_array = mysqli_fetch_array($get_user);
  if($id = $_SESSION[id] || $get_user_array['pos'] == "2" || $get_user_array['pos'] == "3"){
    return true;
  }else{
    return false;
  }
}
//private_messages(get)
function get_dialog($id){
    include "connect.php";
  $message = array();
  $return = array();
  $get_dialog = mysqli_query($db, "SELECT * FROM `private_messages` WHERE `id_u`='$id' AND `id_u2`='".$_SESSION['id']."' OR `id_u`='".$_SESSION['id']."' AND `id_u2`='$id'   ORDER BY `time_stamp`") or die("get_dialog");
  $get_dialog_arr = mysqli_fetch_array($get_dialog);
  $get_user = mysqli_query($db, "SELECT * FROM `user` WHERE `id`='$id'") or die("get_user");
  $get_user_arr = mysqli_fetch_array($get_user);
  if(count($get_dialog_arr) > 0){
    do {
      $date = date("d.m.Y г. в h:i:s", $get_dialog_arr['time_stamp']);
      if($get_dialog_arr['id_u'] == $id){
        mysqli_query($db, "UPDATE `private_messages` SET `readed` = '1' WHERE `id` = '$get_dialog_arr[id]'") or die('set readed');
        $message = [  "id_u" => $get_dialog_arr['id_u'],
                      "id_u2" => $get_dialog_arr['id_u2'],
                      "text" => $get_dialog_arr['text'],
                      "date" => $date,
                      "readed" => $get_dialog_arr['readed'],
                      "id" => $get_user_arr['id'],
                      "name" => $get_user_arr['name'],
                      "avatar" => $get_user_arr['avatar']
        ];
      } else {
        $message = [  "id_u" => $get_dialog_arr['id_u'],
                      "id_u2" => $get_dialog_arr['id_u2'],
                      "text" => $get_dialog_arr['text'],
                      "date" => $date,
                      "readed" => $get_dialog_arr['readed'],
                      "id" => $_SESSION['id'],
                      "name" => $_SESSION['login'],
                      "avatar" => $_SESSION['avatar']
        ];
      }

      array_push($return, $message);
    } while($get_dialog_arr = mysqli_fetch_array($get_dialog));
  }
  echo json_encode($return);
}
//private_messages(send)
function dialog_send_message($id, $text){
    include "connect.php";
  $date = time();
  mysqli_query($db,"INSERT INTO `private_messages` (`id_u` ,`id_u2` ,`text`,`time_stamp`)VALUES ('$_SESSION[id]', '$id', '$text', '$date');");
}
  //notifi and msg(header)
function ntf_msg(){
    if (isset($_SESSION['login']) && isset($_SESSION['id'])){
      function check_messages(){
        include "connect.php";
        $get_messages = mysqli_query($db,"SELECT * FROM `private_messages` WHERE `id_u2`='$_SESSION[id]' AND `readed`='0'");
        $get_messages_arr = mysqli_fetch_array($get_messages);
        $return = 0;
        if(count($get_messages_arr)>0){
        do{
            $return++;
          }while($get_messages_arr = mysqli_fetch_array($get_messages));
        }
        else{
          $return = 0;
        }
        return $return;
    }

  function check_notifi(){
  include "connect.php";
  $get_notification = mysqli_query($db,"SELECT `id` FROM `notifi` WHERE `id_u`='$_SESSION[id]'");
  $get_notification_arr = mysqli_fetch_array($get_notification);
  $return = 0;
  if(count($get_notification_arr)>0){
  do{
      $return++;
    }while($get_notification_arr = mysqli_fetch_array($get_notification));
  }
  else{
    $return = 0;
  }
  return $return;
  }

    $return = array();
    array_push($return, check_messages(), check_notifi());
    echo json_encode($return);
  }
}
//chat(get)
function get_glob_chat(){
  include "connect.php";
  $id = '';
  $avatar = '';
  $name = '';
  $message = array();
  $return = array();
  $get_chat = mysqli_query($db, "SELECT * FROM `chat` ORDER BY `time_stamp`") or die('get chat');
  $get_chat_arr = mysqli_fetch_array($get_chat);
  if(count($get_chat_arr) > 0){
    do{
      $date = date("d.m.Y г. в h:i:s", $get_chat_arr['time_stamp']);
      if($get_chat_arr['id_sender'] == 0){
        $id = 0;
        $name = "Гость";
        $avatar ="users/0/no_avatar2.png";
      } else {
        $get_user = mysqli_query($db, "SELECT * FROM `user` WHERE `id` = '$get_chat_arr[id_sender]'")  or die('get user');
        $get_user_arr = mysqli_fetch_array($get_user);
        $id = $get_user_arr['id'];
        $name = $get_user_arr['login'];
        $avatar = $get_user_arr['avatar'];
      }
      $message = [  "id" => $id,
                    "name" => $name,
                    "avatar" => $avatar,
                    "text" => $get_chat_arr['text'],
                    "date" => $date
      ];
      array_push($return, $message);
    } while($get_chat_arr = mysqli_fetch_array($get_chat));
    echo json_encode($return);
  }
}
//chat(send)
function send_glob_chat($text){
  include "connect.php";

  if(!isset($_SESSION['id']))
    $id = 0;
    else
      $id = $_SESSION['id'];
  $date = time();
  mysqli_query($db, "INSERT INTO `chat` (`text` ,`time_stamp` ,`id_sender`)VALUES ('$text','$date','$id');");
}
//log in
function login($login,$pwd){
    include "connect.php";
  $return = array();
  $get_user = mysqli_query($db,"SELECT * FROM `user` WHERE `login` = '$login'") or die("get_user");
  $get_user_arr = mysqli_fetch_array($get_user);
  if($pwd != $get_user_arr['pwd']){
    $return = [ "result" => false
               ];
    echo json_encode($return);
  } else{
    $_SESSION['login'] = $get_user_arr['login'];
    $_SESSION['id'] = $get_user_arr['id'];
    $_SESSION['avatar'] = $get_user_arr['avatar'];
    $return = [ "result" => true,
                "id" => $get_user_arr['id'],
                "name" => $get_user_arr['login']
               ];
    echo json_encode($return);
  }
}
//reg
function register($login,$pwd){
    include "connect.php";
  $return = array();
  $get_user = mysqli_query($db,"SELECT * FROM `user` WHERE `login` = '$login'") or die("get_user");
  $get_user_arr = mysqli_fetch_array($get_user);
  if(isset($get_user_arr)){
    $return = [ "result" => false
               ];
    echo json_encode($return);
  } else{
    $result = mysqli_query($db,"INSERT INTO `user` (`login`,`pwd`) VALUES ('$login','$pwd')") or die(mysqli_error());
    $get_user = mysqli_query($db,"SELECT * FROM `user` WHERE `login` = '$login'") or die(mysqli_error());
    $get_user_arr = mysqli_fetch_array($get_user);
    $_SESSION['id'] = $get_user_arr['id'];
    $_SESSION['login'] = $get_user_arr['login'];
    $return = [ "result" => true,
                "id" => $get_user_arr['id'],
                "name" => $get_user_arr['login']
               ];
    echo json_encode($return);
  }
}
// comments(get)
function get_comments($link_id,$id){
    include "connect.php";
  $comment = array();
  $return = array();
  $get_comments = mysqli_query($db,"SELECT * FROM `comments` WHERE `file_id` ='$id' AND `value`='$link_id'");
  $get_comments_array = mysqli_fetch_array($get_comments);
  do {
    $get_author = mysqli_query($db,"SELECT * FROM `user` WHERE `id` ='$get_comments_array[author_id]'");
    $get_author_array = mysqli_fetch_array($get_author);
    if(can_edit($get_comments_array['author_id']))
    $can_delete = true;
    else
    $can_delete = false;
    $date = date("d.m.Y г. в h:i:s",$get_comments_array['time']);
    $comment = [ "author_id" => $get_comments_array['author_id'],
                "author_avatar" => $get_author_array['avatar'],
                "author_name" => $get_author_array['login'],
                "date" => $date,
                "text" => $get_comments_array['text'],
                "can_delete" => $can_delete,
                "comment_id" => $get_comments_array['id'],
               ];
    array_push($return, $comment);
  } while ($get_comments_array = mysqli_fetch_array($get_comments));
  echo json_encode($return);
}
// comments(send)
function send_comment($id,$link_id,$text){
    include "connect.php";
  $time = time();
  mysqli_query($db,"INSERT INTO `comments` (`author_id`,`file_id`,`text`,`value`,`time`) VALUES ('$_SESSION[id]','$id','$text','$link_id','$time')") or die("send_comment");
}
// comments(del)
function delete_comment($id){
    include "connect.php";
  mysqli_query($db,"DELETE FROM `comments` WHERE `id`='$id'") or die("delete_comment");
}
// получить каталоги
function get_files($link_id, $user_id, $page){
  include "connect.php";
  $files_on_page = 10;
  $file_num = $page*$files_on_page;
  $file = array();
  $return = array();
  if ($link_id == "photogallery"){
    $get_files = mysqli_query($db,"SELECT * FROM `$link_id` WHERE `id_u`='$user_id' LIMIT ".$files_on_page*$page.",$files_on_page") or die('get_files');
    $get_files_arr = mysqli_fetch_array($get_files);
    }else {
      $get_files = mysqli_query($db,"SELECT * FROM `$link_id` LIMIT ".$files_on_page*$page.",$files_on_page") or die('get_files');
      $get_files_arr = mysqli_fetch_array($get_files);
    }
  if(count($get_files_arr) > 0){
    do {
      $file_num++;
      $file = [ "num" => $file_num,
                "poster" => $get_files_arr['scr_path'],
                "name" => $get_files_arr['name'],
                "id" => $get_files_arr['id'],
                "path"=> $get_files_arr['path']
                 ];
      array_push($return, $file);
      } while ($get_files_arr = mysqli_fetch_array($get_files));
    }
  echo json_encode($return);
}
// получить файл
function get_file($link_id,$id){
  include "connect.php";
  $get_file = mysqli_query($db,"SELECT * FROM `$link_id` WHERE `id` ='$id'");
  $get_file_arr = mysqli_fetch_array($get_file);
  $get_author = mysqli_query($db,"SELECT * FROM `user` WHERE `id` ='".$get_file_arr[id_u]."'");
  $get_author_arr = mysqli_fetch_array($get_author);
  $date = date("d.m.y h:s",$get_file_arr['time_stamp']);
  $return = [ "name" => $get_file_arr['name'],
              "poster" => $get_file_arr['scr_path'],
              "path" => $get_file_arr['path'],
              "description" => $get_file_arr['description'],
              "author_id" => $get_author_arr['id'],
              "author_name" => $get_author_arr['login'],
              "date" => $date
             ];
  echo json_encode($return);
}
function get_mail(){
    include 'connect.php';
  $ids = array();
  $dialog = array();
  $return = array();
  $get_messages = mysqli_query($db, "SELECT * FROM `private_messages` WHERE `id_u`='$_SESSION[id]' GROUP BY `id_u2` ORDER by `time_stamp`") or die("res_msg");
  $get_messages_array = mysqli_fetch_array($get_messages);
    if(count($get_messages_array) > 0){
      do{
        $date = date("d.m.y h:s",$get_messages_array['time_stamp']);
        $dialog = [ "avatar" => $_SESSION['avatar'],
                    "id" => $_SESSION['id'],
                    "chat_id" => $get_messages_array['id_u2'],
                    "name" => $_SESSION['login'],
                    "text" => $get_messages_array['text'],
                    "date" => $date,
                    "readed" => $get_messages_array['readed']
        ];
        array_push($return, $dialog);
        array_push($ids, $get_messages_array['id_u2']);
      }while($get_messages_array=mysqli_fetch_array($get_messages));
    }
    $get_messages = mysqli_query($db, "SELECT * FROM `private_messages` WHERE `id_u2`='$_SESSION[id]' GROUP BY `id_u` ORDER by `time_stamp` DESC") or die("res_msg");
    $get_messages_array = mysqli_fetch_array($get_messages);
      if(count($get_messages_array) > 0){
        do{
          if(!in_array($get_messages_array['id_u'], $ids)){
            $get_users = mysqli_query($db,"SELECT * FROM `user` WHERE `id` = '$get_messages_array[id_u]'") or die("function search_users");
            $get_users_arr = mysqli_fetch_array($get_users);
            $date = date("d.m.y h:s",$get_messages_array['time_stamp']);
            $dialog = [ "avatar" => $get_users_arr['avatar'],
                        "id" => $get_users_arr['id'],
                        "chat_id" => $get_messages_array['id_u'],
                        "name" => $get_users_arr['login'],
                        "text" => $get_messages_array['text'],
                        "date" => $date,
                        "readed" => $get_messages_array['readed']
            ];
            array_push($return, $dialog);
            array_push($ids, $get_messages_array['id_u']);
          }
        }while($get_messages_array = mysqli_fetch_array($get_messages));
      }
      echo json_encode($return);
}
function get_categories(){
  include "connect.php";
  $category = array();
  $return = array();
  $get_categories = mysqli_query($db,"SELECT * FROM `categories`");
  $get_categories_arr = mysqli_fetch_array($get_categories);
  if(count($get_categories_arr) > 0){
    do {
      $category = $get_categories_arr;
      array_push($return, $category);
    }while ($get_categories_arr = mysqli_fetch_array($get_categories));
  echo json_encode($return);
  }
}
//Поиск(Юзеры)
function search_users($request){
  include "connect.php";
  $user = array();
  $return = array();
  $get_users = mysqli_query($db,"SELECT * FROM `user` WHERE `login`='$request' OR `name`='$request' OR `surname`='$request' OR `sity`='$request'") or die("function search_users");
  $get_users_arr = mysqli_fetch_array($get_users);
  if(count($get_users_arr)>0){
    $num = 0;
    do{
    $num++;
    $online = get_user_online($get_users_arr['id']);
    $user = [ "num" => $num,
              "id" => $get_users_arr['id'],
              "avatar" => $get_users_arr['avatar'],
              "name" => $get_users_arr['login'],
              "online" => $online
            ];
    array_push($return, $user);
    } while($get_users_arr = mysqli_fetch_array($get_users));
  }
  echo json_encode($return);
}

function get_users(){
  include "connect.php";
  $user = array();
  $return = array();
  $get_users = mysqli_query($db,"SELECT * FROM `user`");
  $get_users_arr = mysqli_fetch_array($get_users);
  if(count($get_users_arr)>0){
    $num = 0;
    do{
    $num++;
    $online = get_user_online($get_users_arr['id']);
    $user = [ "num" => $num,
              "id" => $get_users_arr['id'],
              "avatar" => $get_users_arr['avatar'],
              "name" => $get_users_arr['login'],
              "online" => $online
            ];
    array_push($return, $user);
    } while($get_users_arr = mysqli_fetch_array($get_users));
  }
  echo json_encode($return);
}
// Подать, отменить заявку в друзья. Добавить, удалить друга.
function set_friend_status($id, $set){
    if($id != $_SESSION['id']){
    include "connect.php";
    if ($set == "add"){
      $time = time();
      mysqli_query($db,"INSERT INTO `friends` (`id_u`,`id_u2`,`status`) VALUES ('$_SESSION[id]',$id,'0')") or die("add friend");
      mysqli_query($db,"INSERT INTO `notifi` (`id_u`,`id_u2`,`time_stamp`) VALUES ('$id','$_SESSION[id]','$time')") or die("add notifi");
    } else if ($set == "delete"){
      $get_friend_status = mysqli_query($db, "SELECT * FROM `friends` WHERE `id_u`='$id' AND `id_u2`='$_SESSION[id]' OR `id_u2`='$id' AND `id_u`='$_SESSION[id]'") or die("get friend");
      $get_friend_status_arr = mysqli_fetch_array($get_friend_status);
      if($get_friend_status_arr['id_u'] == $_SESSION['id']){
        mysqli_query($db,"UPDATE `friends` SET `id_u` = '$id', `id_u2` = '$_SESSION[id]', `status` = '0' WHERE `id` = '$get_friend_status_arr[id]'") or die("add friend");
      }else if($get_friend_status_arr['id_u2'] == $_SESSION['id']){
        mysqli_query($db,"UPDATE `friends` SET `status` = '0' WHERE `id` = '$get_friend_status_arr[id]'") or die("add friend");
      }
    } else if ($set = "some"){
      $get_friend_status = mysqli_query($db, "SELECT * FROM `friends` WHERE `id_u`='$id' AND `id_u2`='$_SESSION[id]' OR `id_u2`='$id' AND `id_u`='$_SESSION[id]'") or die("get friend");
      $get_friend_status_arr = mysqli_fetch_array($get_friend_status);
      if($get_friend_status_arr['id_u'] == $_SESSION['id']){
        if($get_friend_status_arr['status'] == 0)
          mysqli_query($db,"DELETE FROM `friends` WHERE `id` = '$get_friend_status_arr[id]'") or die("delete friend");
        }else if($get_friend_status_arr['id_u2'] == $_SESSION['id']){
          if($get_friend_status_arr['status'] == 0)
          mysqli_query($db,"UPDATE `friends` SET `status` = '1' WHERE `id` = '$get_friend_status_arr[id]'") or die("add friend");
        }
      }
  }
}
// get(статус дружбы)
function get_friend_status($id){
    if($id != $_SESSION['id']){
    include "connect.php";
    $get_friends = mysqli_query($db,"SELECT * FROM `friends` WHERE `id_u`='$id' OR `id_u2`='$id'") or die("get_friends");
    $get_friends_arr = mysqli_fetch_array($get_friends);
    $return = [ "status" => -1
    ];
      do {
        if($get_friends_arr['id_u'] == $_SESSION['id']){
            $return = $get_friends_arr;
          } else if($get_friends_arr['id_u2'] == $_SESSION['id']){
            $return = $get_friends_arr;
          }
      } while ($get_friends_arr = mysqli_fetch_array($get_friends));
    echo json_encode($return);
  }
}
function chat_online(){
  include "connect.php";
  $wine = 10;
  $time = time();
  $user_ip = $_SERVER['REMOTE_ADDR'];
  $del = mysqli_query($db, "DELETE FROM `online` WHERE `users` = 'chat' and `time_stamp`+".$wine."<".$time." OR `ip`='$user_ip'") or die("delete_old_users");
  $ins = mysqli_query($db, "INSERT INTO `online` (`ip`, `time_stamp`, `users`) VALUES ('$user_ip','$time', 'chat')") or die("add_user");
  $sel = mysqli_query($db, "SELECT `id` FROM `online` WHERE `users` = 'chat'") or die("select_online_users");
  $users_online = mysqli_num_rows($sel);
  return $users_online;
}

function site_online(){
  include "connect.php";
  $wine = 10;
  $time = time();
  $sel = mysqli_query($db, "SELECT `id` FROM `user` WHERE `time_stamp`+$wine>$time") or die("select_online_users");//Дырка?
  $users_online = mysqli_num_rows($sel);
  return $users_online;
}

function get_user_online($id){
  include "connect.php";
  $time = time();
  $usr_time = mysqli_query($db,"SELECT * FROM `user` WHERE id='$id'");
  $t = mysqli_fetch_row($usr_time);
  $res =  $time - $t[11];
  if($res<10){
    return "<img src='img/online.png'> <span color='#929292'>online</span>";
  } else{
      if (date('d.m.y')==date('d.m.y',$t[11])){
        $date = 'сегодня в ';
      } else if (date('d.m.y')-date('d.m.y',$t[11])==1){
          $date = 'вчера в ';
        } else{
            $date = date('d.m в',$t[11]);
          }
      return "<img src='img/offline.png'><span color='#929292'> offline. Был в сети : ".$date." ".date('H:i',$t[11])."</span>";
    }
}
function upd_online_usr(){
  include "connect.php";
  $time = time();
  $upd_time = mysqli_query($db,"UPDATE `user` SET `time_stamp`='$time' WHERE id='".$_SESSION['id']."'");
}
?>
