<?php
include_once('../dbad_lib.php');


$token = $_SESSION['token'];
$mb_id = $_SESSION['mb_id'];
// echo session_id();
// echo "<br>";
// print_r($_SESSION);

if(!chk_token($token,$mb_id)){
  $mb_id = "";
}


// echo $mb_id;
// echo "<br>";
// echo $token;

// print_r($_SESSION);


if(!$mb_id){
  echo "
    <script>
      alert('로그인 해주세요.');
      document.location.href='../index.php'
    </script>
    ";
}

// echo "mb_id : $mb_id <br>";



?>

<!DOCTYPE html>
<html lang="ko">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="dbad.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="./dbad.js"></script>

  </head>

  <body cellpadding="0" cellspacing="0" marginleft="0" margintop="0" width="100%" height="100%" align="center">

  <div id="content">

    <div class="top">
      <div class="top_title">
        <p class="tp">데이터 리스트</p>
        <div class="btn-group">
          <button type="button" class="btn btn-danger"><?=$mb_id?></button>
          <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <span class="caret"></span>
            <span class="sr-only"></span>
          </button>
          <ul class="dropdown-menu" role="menu">
            <!-- <li role="presentation"><a href="../index.php?logout=out">로그아웃</a></li> -->
            <li role="presentation"><a onclick="location.replace('../index.php?logout=out')">로그아웃</a></li>
          </ul>
        </div>
      </div>
    </div>

    <div class="place">
      <div class="left_menu">
        <div class="btn-group-vertical" role="group">
          <button class="btn btn-primary" onclick="move(1)">리스트</button>
      <? if($mb_id=="admin"){ ?>
          <button class="btn btn-primary" onclick="move(2)">회원관리</button>
          <button class="btn btn-primary" onclick="move(3)">광고관리</button>
          <button class="btn btn-primary" onclick="move(4)">전송관리</button>
        <? } ?>
        </div>
      </div>
