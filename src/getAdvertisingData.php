<?php
include_once('../dbad_lib.php');


// 호출이 왔을시 데이터 취득방법 여부에 따라 방법이 달라짐
// 1. 데이터 전달없이 접속해서 받아오기

// 2. 직접 데이터 전달시
$name = "";
$tel = "";
$ip = "";
$date = "";
$hour = "";
$class = "";
$type = "";

// DB 입력처리
$sql = "INSERT INTO d_log_info SET
name = '{$name}', tel = '{$tel}', ip_addr = '{$ip}', w_date = '{$date}', w_hour = '{$hour}', class = $class, type = '{$type}'";
// $re = sql_query($sql);

if($re){
  $success = 1;
}else{
  $success = 0;
}


// 알림톡 전송처리
// 알림토큰 받기
$alim_token = getAlimToken();

// 템플릿에따라 치환내용에 따른 데이터 세팅
$sql = "SELECT * FROM d_ad_member WHERE class = $class";
$re = sql_query($sql);

$i = 0;
while($rs = sql_fetch_array($re)){
  $telbox[$i] = $rs['mb_tel'];
  $namebox[$i] = $rs['mb_name'];
  $i++;
}

$tel_txt = implode(",",$telbox);


$msg = "";
$target = "";
$receiver = "";
$subject = "";

$result = sendAlim($receiver,$target,$subject,$msg,$alim_token);


?>
