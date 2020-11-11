<?php
include_once('../dbad_lib.php');

$sql = "SELECT * FROM d_ad_member WHERE mb_id='{$uid}'";

$re = sql_fetch($sql);
$mb_id = $re['mb_id'];
$mb_password = base64_decode($re['mb_password']);


// $mb_password = $upw;
if($upw != $mb_password){
  echo "
    <script>
      alert('아이디 또는 비밀번호를 확인 해 주세요.');
      history.go(-1);
    </script>
  ";
}else{

  // 토큰 받아서 세션에 입력 후 DB에 저장
  $curr_token = get_token();
  $_SESSION['token'] = $curr_token;
  $_SESSION['mb_id'] = $uid;

  // print_r($_SESSION);

  $sql = "UPDATE d_ad_member SET _token = '{$curr_token}' WHERE mb_id='{$uid}'";
  $re = sql_query($sql);
  echo "<script>document.location.href='./dbad_list.php'</script>";
}



?>
