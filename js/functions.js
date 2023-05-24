//Variables
var php_link = 'ajax.php';
var file_link = 'file.php';
var user_link = 'user.php';
var category_link = 'content_files.php';
var file_operation_link = 'file_o.php';
var edit_anket_link = 'edit.php';
var friends_link = 'friends.php';
var dialog_link = 'dialog.php';

function get_count_ntf_msg(){
$.ajax({
  url: php_link,
  type:'GET',
  dataType: 'json',
  data: ({act : 'ntf_msg'}),
  success: function(data){
      $(".mail").html(data[0]);
      $(".notification").html(data[1]);
  }
  });
}

function footer_date()
{
var time = new Date();
$("#time-span").html(time.toLocaleTimeString());
}

function get_comments(link_id, id){
  $.ajax({
    url: php_link,
    type:'GET',
    data:({
      act: 'get_cmt',
      link_id: link_id,
      id: id
    }),
    dataType: 'json',
    success: function(data){
      $('.comments-count').html(data.length);
      data.forEach(function(element){
        var delete_comment = "";
        if(element.can_delete){
          delete_comment = '<span style="cursor: pointer;" onclick="delete_comment('+element.comment_id+')">Удалить</span>';
        }
        $('ul').append('<li class="comment"><a href="'+user_link+'?id='+element.author_id+'"><img class="avatar-middle" alt="Аватар" src="'+element.author_avatar+'">'+element.author_name+'</a><span class="date-span">'+element.date+'</span><p>'+element.text+'</p>'+delete_comment+'</li>');
        });
    }
  });
}
function send_comment(link_id, id){
  var text = document.getElementById("comment-input").value;
  $.ajax({
    url: php_link,
    type:'GET',
    data:({
      act: 'send_cmt',
      link_id: link_id,
      id: id,
      text: text
    }),
    dataType: 'html',
    success: location.reload()
  });
}
function delete_comment(id){
  $.ajax({
    url: php_link,
    type:'GET',
    data:({
      act: 'del_cmt',
      id : id
    }),
    dataType: 'html',
    success: location.reload()
  });
}

function search_users(){
  var request = document.getElementById("search-input").value
  if(request!=''){
    $.ajax({
    url: php_link,
    type:'GET',
    data:({
      act: 'srch_usrs',
      request: request
    }),
    dataType: 'json',
    success: function(data){
      $('.search-count').html(data.length);
      data.forEach(function(element){
        $('.search-ul').append('<li>'+element.num+'.<img class="avatar-middle" alt="Аватар" src="'+element.avatar+'"><a href="'+user_link+'?id='+element.id+'">'+element.name+'</a>'+element.online+'</li>');
        });
      }
    });
  }
}

function get_users(){
  $.ajax({
  url: php_link,
  type:'GET',
  data:({
    act: 'get_users'
  }),
  dataType: 'json',
  success: function(data){
    $('.users-count').html(data.length);
    data.forEach(function(element){
      $('.users-ul').append('<li>'+element.num+'.<img class="avatar-middle" alt="Аватар" src="'+element.avatar+'"><a href="'+user_link+'?id='+element.id+'">'+element.name+'</a>'+element.online+'</li>');
      });
    }
  });
}

function get_glob_chat(){
  $.ajax({
    url: php_link,
    type:'GET',
    data:({
      act: 'get_glob_chat'
    }),
    dataType: 'json',
    success: function(data){
      $('.chat-ul').html("");
      data.forEach(function(element){
          $('.chat-ul').append('<li><a href="'+user_link+'?id='+element.id+'"><img class="avatar-middle" alt="Аватар" src="'+element.avatar+'">'+element.name+'</a> <span class="dialog-replica">'+element.text+'</span> <span class="date">'+element.date+'</span></li>');
      });
      $('.chat-ul').scrollTop(9999);
      document.getElementById('chat-input').value = "";
    }
  });
}

function send_glob_chat(){
  var text = document.getElementById("chat-input").value;
$.ajax({
  url: php_link,
  type:'GET',
  data:({
    act: 'send_glob_chat',
    text: text
  }),
  dataType: 'json',
  success: get_glob_chat()
});
}

function register(){
  var login = document.getElementById("reg-login").value;
  var password = document.getElementById("reg-password").value;
  $.ajax({
  url: php_link,
  type:'GET',
  data:({
    act: 'reg',
    login: login,
    pwd: password
  }),
  dataType: 'json',
  success: function(data){
    console.log(data);
    if(data.result){
      $(".result").html("Добро пожаловать, "+data.name+"!");
      window.location.href = user_link+'?id='+data.id;
    }else {
      $(".result").html("Этот логин уже занят!");
    }
  }
  });
}

  function login(){
    var login = document.getElementById("log-login").value;
    var password = document.getElementById("log-password").value;
    $.ajax(
    {
    url: php_link,
    type:'GET',
    data:({
      act: 'login',
      login: login,
      pwd: password
    }),
    dataType: 'json',
    success: function(data){
      if(data.result){
        $(".result").html("Добро пожаловать, "+data.name+"!");
        window.location.href = user_link+'?id='+data.id;
      }else {
        $(".result").html("Логин или пароль не верный!");
      }
    }
    });
  }

function get_files(link_id, user_id, page){
  $.ajax({
    url:  php_link,
    type: 'GET',
    dataType: 'json',
    data:({
      act: 'get_files',
      link_id: link_id,
      user_id: user_id,
      page: page
    }),
    success: function(data){
      data.forEach(function(element){
        $('ul').append('<li>'+element.num+'.<img class="poster" alt="Скриншот" src="'+element.poster+'"><a href="'+file_link+'?link_id='+link_id+'&id='+element.id+'">'+element.name+'</a></li>');
        });
    }
  });
}
function get_file(link_id, id){
  $.ajax({
    url:  php_link,
    type: 'GET',
    dataType: 'json',
    data:({
      act: 'get_file',
      link_id: link_id,
      id: id
    }),
    success: function(data){
      $('.file-name').html(data.name);
      $('.file-name').html(data.name);
      $('.file-poster').attr('src', data.poster);
      $('.file-description').html(data.description);
      $('.file-author-link').attr('href', user_link+'?id='+data.author_id);
      $('.file-author-name').html(data.author_name);
      $('.file-date').html(data.date);
      $('.file-download-link').attr('href',data.path);
    }
  });
}

function get_categories(){
  $.ajax({
    url:  php_link,
    type: 'GET',
    data:({
      act: 'get_categories'
    }),
    dataType: 'json',
    success: function(data){
      data.forEach(function(element){
        $('.categories-ul').append('<li><a href="'+category_link+'?link_id='+element.link_id+'&user_id=0&page=0"><img src="img/folder_mini.png" alt="Папка">'+element.name+'</a></li>');
      });
    }
  });
}
function get_photogallery(link_id, user_id, page){
  $.ajax({
    url:  php_link,
    type: 'GET',
    dataType: 'json',
    data:({
      act: 'get_files',
      link_id: link_id,
      user_id: user_id,
      page: page
    }),
    success: function(data){
      if(data.length > 0){
      data.forEach(function(element){
        $('.gallery-items').prepend('<img class="avatar-middle" src="'+element.path+'">');
        $('.carousel-inner').prepend('<div class="carousel-item"><img src="'+element.path+'">');
        });
          var carousel_item = document.getElementsByClassName('carousel-item')[0].classList;
          $('.text-empty').remove();
          carousel_item.add("active");
        }else{
          $('.gallery-items').remove();
        }
    }
  });
}

function get_friend_status(id){
  $.ajax({
    url: php_link,
    type:'GET',
    data: ({
      act: 'get_friend_status',
      id: id
    }),
    dataType: 'json',
    success: function(data){
      if(data.status == 1){
        $('.friend-status').attr('onclick', 'set_friend_status(\''+id+'\',\'delete\')');
        $('.friend-status-span').html('Удалить с друзей');
      }else if(data.status == -1){
        $('.friend-status').attr('onclick', 'set_friend_status(\''+id+'\',\'add\')');
        $('.friend-status-span').html('Добавить в друзья');
      } else {
        if(data.id_u == id){
          if(data.status == 0){
            $('.friend-status').attr('onclick', 'set_friend_status(\''+id+'\',\'some\')');
            $('.friend-status-span').html('Принять заявку');
          }
        } else if(data.id_u2 == id){
          if(data.status == 0){
            $('.friend-status').attr('onclick', 'set_friend_status(\''+id+'\',\'some\')');
            $('.friend-status-span').html('Отменить заявку');
          }
        }
      }
      }
  });
}
function set_friend_status(id, set){
$.ajax({
  url: php_link,
  type:'GET',
  data:({
    act: 'set_friend_status',
    id: id,
    set: set
  }),
  dataType: 'json',
  success: window.location.reload()
  });
}
function get_dialog(id){
  $.ajax({
    url: php_link,
    type:'GET',
    data:({
      act: 'get_dialog',
      id: id
    }),
    dataType: 'json',
    success: function(data){
      $('.dialog-ul').html("");
      data.forEach(function(element){
        if(element.id_u == id){
          $('.dialog-ul').append('<li><a href="'+user_link+'?id='+element.id+'"><img class="avatar-middle" alt="Аватар" src="'+element.avatar+'">'+element.name+'</a> <span class="dialog-replica">'+element.text+'</span> <span class="date">'+element.date+'</span></li>');
        }else{
          $('.dialog-ul').append('<li><a href="'+user_link+'?id='+element.id+'"><img class="avatar-middle" alt="Аватар" src="'+element.avatar+'">'+element.name+'</a> <span class="dialog-replica">'+element.text+'</span> <span class="date">'+element.date+'</span></li>');
        }
      });
      $('.dialog-ul').scrollTop(9999);
      document.getElementById('dialog-input').value = "";
    }
  });
}
function dialog_send_message(id){
  var text = document.getElementById('dialog-input').value;
  $.ajax({
    url: php_link,
    type: 'GET',
    data:({
      act: 'dialog_send_message',
      id: id,
      text: text
    }),
    dataType: 'json',
    success: get_dialog(id)
  });
}
function get_mail(){
  $.ajax({
    url: php_link,
    type:'GET',
    data:({
      act: 'get_mail'
    }),
    dataType: 'json',
    success: function(data){
      console.log(data);
      if(data.length > 0)
      $('.mail-ul').html("");
      data.forEach(function(element){
        var readed_mark = '';
        if(element.readed == 0)
          readed_mark = 'Не прочитано';
        $('.mail-ul').append('<li><a href="'+user_link+'?id='+element.id+'"><img class="avatar-middle" alt="Аватар" src="'+element.avatar+'">'+element.name+'</a> <span class="date">'+element.date+'</span><p><a href="'+dialog_link+'?id='+element.chat_id+'">'+element.text+'</a>'+readed_mark+'</li>');
      });
    }
  });
}
function get_notification(){
  $.ajax({
    url: php_link,
    type: 'GET',
    data:({
      act: 'get_notification'
    }),
    dataType: 'json',
    success: function(data){
      if(data.length > 0){
        $('.notification-ul').html("");
        data.forEach(function(element){
          $('.notification-ul').append('<li><a href="'+user_link+'?id='+element.id+'"><img class="avatar-middle" alt="Аватар" src="'+element.avatar+'">'+element.name+' Заявка в друзья <span class="date">'+element.date+'</span></a><button class="btn btn-warning" onclick="delete_notification(\''+element.id+'\')">Удалить</button></li>');
        });
      }
    }
  });
}
function delete_notification(id){
  $.ajax({
    url: php_link,
    type: 'GET',
    data:({
      act: 'delete_notification',
      id: id
    }),
    dataType: 'json',
    success: window.location.reload()
  });
}
function user_set_status(){
  var text = document.getElementById('status-edit-input').value;
  $.ajax({
    url: php_link,
    type: 'GET',
    data:({
      act: 'user_set_status',
      text: text
    }),
    dataType: 'json',
    success: function(data){
      user_get_status(data);
    }
  });
}
function user_get_status(id){
  $.ajax({
    url: php_link,
    type: 'GET',
    data:({
      act: 'user_get_status',
      id: id
    }),
    dataType: 'json',
    success: function(data){
      $('.avatar-status').html(data.status);
    }
  });
}
function user_set_profile(){
  var name = document.getElementById('name').value;
  var surname = document.getElementById('surname').value;
  var sity = document.getElementById('sity').value;
  var bdate = document.getElementById('bdate').value;
  var sex = document.getElementById('sex').value;
  $.ajax({
    url: php_link,
    type: 'GET',
    data:({
      act: 'user_set_profile',
      name: name,
      surname: surname,
      sity: sity,
      bdate: bdate,
      sex: sex
    }),
    dataType: 'json',
    success: function(data){
      user_get_profile(data);
    }
  });
}
function user_get_profile(id){
  $.ajax({
    url: php_link,
    type: 'GET',
    data:({
      act: 'user_get_profile',
      id: id
    }),
    dataType: 'json',
    success: function(data){
      var sex = '';
      var pos = '';
      if(data.owner){
        $('.user-coins').html("У Вас : <span class='user-coins'>"+data.coins+"</span> коинов<img src='img/coin.png'>");
        $('.user-edit-item-1').attr('href', file_operation_link + '?do=add&link_id=photogallery&t2=a');
        $('.user-edit-item-2').attr('href', file_operation_link + '?do=delete&link_id=photogallery&t2=a&id='+data.id+'&link_id=photogallery');
        $('.user-edit-item-3').attr('href', edit_anket_link);
        $('.photogallery-add').attr('href', file_operation_link + '?link_id=photogallery&do=add&t2=p');
        $('.status-edit-input').attr('placeholder', data.status);
        $('.for-guest').remove();
      }else{
        $('.owner').remove();
        $('.buttons').prepend('<li><a href="'+dialog_link+'?id='+data.id+'"><img src="img/mail_mini.png" alt="Чат"> Написать '+data.login+'</a></li>');
      }
      if(data.pos == 1){
        pos = 'Пользователь';
      } else if(data.pos == 2){
        pos = 'Модератор';
      } else{
        pos = 'Администратор';
      }
      if(data.sex == 1){
        sex = 'М';
      } else{
        sex = 'Ж';
      }
      $('.avatar-top').html(data.login+'('+sex+')'+data.online);
      $('.avatar-img').attr('src', data.avatar);
      $('.avatar-pos').html(pos);

      $('.profile-name').html(data.name);
      $('.profile-surname').html(data.surname);
      $('.profile-sity').html(data.sity);
      $('.profile-bdate').html(data.bdate);

      $('.user-friends').attr('href', friends_link + '?id='+data.id);
    }
  });
}
function user_set_avatar(){
  var text = document.getElementById('avatar-edit-input').value;
  $.ajax({
    url: php_link,
    type: 'GET',
    data:({
      act: 'user_set_avatar',
      text: text
    }),
    dataType: 'json',
    success: function(data){
      user_get_avatar(data);
    }
  });
}
function user_get_avatar(id){
  $.ajax({
    url: php_link,
    type: 'GET',
    data:({
      act: 'user_get_avatar',
      id: id
    }),
    dataType: 'json',
    success: function(data){
      console.log(data);
    }
  });
}
