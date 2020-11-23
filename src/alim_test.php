<?php
include_once("../dbad_lib.php");

echo "알림톡 테스트<br>";
echo "================<br><br>";

$class=4;
echo "class = $class <br>";

$sql = "SELECT * FROM d_ad_member WHERE class = $class";
$re = sql_query($sql);

$i = 1;
while($rs = sql_fetch_array($re)){
  $telbox[$i] = $rs['mb_tel'];
  $namebox[$i] = $rs['mb_name'];
  $i++;
}

$cnt = count($telbox);
$msg="ab";
$alim_token = getAlimToken();
$token = $alim_token->token;
$subject = "[DBAD 알림]";

$result = sendAlim($telbox,$namebox,$subject,$msg,$token,$cnt);


echo "<br><br><br>";
print_r($result);


function sendAlim($receiver,$recv_name,$subject,$msg,$token,$cnt){
  $_apiURL    =	'https://kakaoapi.aligo.in/akv10/alimtalk/send/';
  $_hostInfo  =	parse_url($_apiURL);
  $_port      =	(strtolower($_hostInfo['scheme']) == 'https') ? 443 : 80;

  $variables =	array(
    'apikey'      => 'zybsha98q0ef1vxnkl2yajhp4oge7055',
    'userid'      => 'rhkrdmsxor',
    'token'       => $token,
    'senderkey'   => 'be33d86d72a5237b79186eee03064049f5ea1e47',
    'tpl_code'    => '전송할 템플릿 코드',
    'sender'      => '01064631248',
    'testMode'    => 'Y'  // 연동테스트
  );

  for($i=1; $i<=$cnt; $i++){
    $variables['receiver_'.$i]=$receiver[$i];
    $variables['recvname_'.$i]=$recv_name[$i];
    $variables['subject_'.$i]=$subject;
    $variables['message_'.$i]=$msg;
  }

  // return $variables;

  // $_variables =	array(
  //   'apikey'      => 'zybsha98q0ef1vxnkl2yajhp4oge7055',
  //   'userid'      => 'rhkrdmsxor',
  //   'token'       => $token,
  //   'senderkey'   => 'be33d86d72a5237b79186eee03064049f5ea1e47',
  //   'tpl_code'    => '전송할 템플릿 코드',
  //   'sender'      => '010-6463-1248',
  //   'receiver_1'  => '첫번째 알림톡을 전송받을 휴대폰 번호',
  //   'recvname_1'  => '첫번째 알림톡을 전송받을 사용자 명',  // 필수아님
  //   'subject_1'   => $subject,
  //   'message_1'   => '첫번째 템플릿내용을 기초로 작성된 전송할 메세지 내용',
  //   // 'button_1'    => '{"button":[{"name":"테스트 버튼","linkType":"DS"}]}', // 템플릿에 버튼이 없는경우 제거하시기 바랍니다.
  //   'receiver_2'  => '010-6463-1248',
  //   'recvname_2'  => '곽은택 대표님',
  //   'subject_2'   => $subject,
  //   'message_2'   => '첫번째 템플릿내용을 기초로 작성된 전송할 메세지 내용',
  //   // 'button_2'    => '{"button":[{"name":"테스트 버튼","linkType":"DS"}]}' // 템플릿에 버튼이 없는경우 제거하시기 바랍니다.
  //   'testMode'    => 'Y'  // 연동테스트
  // );


  $oCurl = curl_init();
  curl_setopt($oCurl, CURLOPT_PORT, $_port);
  curl_setopt($oCurl, CURLOPT_URL, $_apiURL);
  curl_setopt($oCurl, CURLOPT_POST, 1);
  curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($oCurl, CURLOPT_POSTFIELDS, http_build_query($_variables));
  curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);

  $ret = curl_exec($oCurl);
  $error_msg = curl_error($oCurl);
  curl_close($oCurl);

  // 리턴 JSON 문자열 확인
  // print_r($ret . PHP_EOL);

  // JSON 문자열 배열 변환
  $retArr = json_decode($ret);

  // 결과값 출력
  print_r($retArr);
}



 ?>
