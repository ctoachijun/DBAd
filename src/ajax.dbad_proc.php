<?php
include_once('../dbad_lib.php');

$whoisKey = "2020111118402606320220";


switch($w_type){
  // 넘겨받은 데이터 입력
  case "insert_data":

    $sql = "INSERT INTO d_log_info SET
    name='{$name}', tel='{$tel}', ip_addr='{$ipaddr}', w_date='{$w_date}', w_hour='{$w_hour}', type='{$type}'
    ";
    $re = sql_query($sql);

    if($re){
      $output['state'] = 'Y';
    }else{
      $output['state'] = 'N';
    }

    echo json_encode($output,JSON_UNESCAPED_UNICODE);
  break;


  case "insert_member" :

    $pwd = base64_encode($mb_password);
    $sql = "INSERT INTO d_ad_member SET
    mb_id='{$mb_id}', mb_tel='{$mb_tel}', mb_password='{$pwd}', mb_name='{$mb_name}', class='{$class}'
    ";
    $re = sql_query($sql);

    $output['sql'] = $sql;
    if($re){
      $output['state'] = 'Y';
    }else{
      $output['state'] = 'N';
    }

    echo json_encode($output,JSON_UNESCAPED_UNICODE);
  break;


  case "edit_member" :
    $sql = "UPDATE d_ad_member SET
    mb_name='{$mb_name}', mb_tel='{$mb_tel}', class='{$class}' WHERE idx={$idx}";
    $re = sql_query($sql);

    if($re){
      $output['state'] = 'Y';
    }else{
      $output['state'] = 'N';
    }

    echo json_encode($output,JSON_UNESCAPED_UNICODE);
  break;


  case "delete_member" :
    $sql = "UPDATE d_ad_member SET
    view='N' WHERE idx={$idx} ";

    $re = sql_query($sql);

    if($re){
      $output['state'] = 'Y';
    }else{
      $output['state'] = 'N';
    }

    echo json_encode($output,JSON_UNESCAPED_UNICODE);
  break;


  case "insert_class" :
    $sql = "INSERT INTO d_class SET
    c_name='{$c_name}', c_code='{$c_code}', w_date=DEFAULT";
    $re = sql_query($sql);

    if($re){
      $output['state'] = 'Y';
    }else{
      $output['state'] = 'N';
    }

    echo json_encode($output,JSON_UNESCAPED_UNICODE);
  break;


  case "edit_class" :
    $sql = "UPDATE d_class SET
    c_name='{$c_name}', c_code='{$c_code}' WHERE idx={$idx} ";

    $re = sql_query($sql);

    if($re){
      $output['state'] = 'Y';
    }else{
      $output['state'] = 'N';
    }
    echo json_encode($output,JSON_UNESCAPED_UNICODE);
  break;


  case "delete_class" :
    $sql = "UPDATE d_class SET
    view='N' WHERE idx={$idx} ";

    $re = sql_query($sql);

    if($re){
      $output['state'] = 'Y';
    }else{
      $output['state'] = 'N';
    }

    echo json_encode($output,JSON_UNESCAPED_UNICODE);
  break;

  case "chk_ip" :
    $url = "http://whois.kisa.or.kr/openapi/ipascc.jsp?query={$ipaddr}&key={$whoisKey}&answer=json";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    curl_close($ch);

    $response = json_decode($response,true);
    $output['re'] = $response['whois']['countryCode'];

    echo json_encode($output,JSON_UNESCAPED_UNICODE);

  break;

  case "send_dummy" :
    $name_box = explode("/",$name);
    $tel_box = explode("/",$tel_num);


    // 이름입력수를 기준으로 처리
    $cnt = count($name_box);
    $output['cnt'] = $cnt;

    for($i=0,$a=0; $i<$cnt; $i++,$a++){
      // 랜덤IP
      $ip = getRandIp();

      // 랜덤시간
      $hour = sprintf("%02d",rand(0,23));
      $min = sprintf("%02d",rand(0,59));
      $sec = sprintf("%02d",rand(0,59));
      $hms = $hour.":".$min.":".$sec;

      // 랜덤 타입
      $type = rand(1,6);

      $tel = htmlspecialchars(preg_replace('/\r\n|\r|\n/','',$tel_box[$i]));
      $name = htmlspecialchars(preg_replace('/\r\n|\r|\n/','',$name_box[$i]));
      if($name){
        $sql = "INSERT INTO d_log_info SET
        name='{$name}', tel='{$tel}', ip_addr='{$ip}', w_date='{$w_date}', w_hour='{$hms}', type={$type}, class={$class}";

        $re = sql_query($sql);
        // 오천건마다 2초 딜레이
        $sleepint = $a % 5000;
        $output['sleep'.$i] = $sleepint;
        if($a!=0 && $sleepint == 0){
          sleep(2);
        }
      }
    }


    // $output['sql'] = $sql;
    if($re){
      $output['state'] = "Y";
    }else{
      $output['state'] = "N";
    }

    echo json_encode($output,JSON_UNESCAPED_UNICODE);

    // 전송할 API 에 curl 처리할거있으면 하기

  break;

  case "del_info" :
    $sql = "DELETE FROM d_log_info WHERE idx={$idx}";
    $re = sql_query($sql);

    $output['sql'] = $sql;
    if($re){
      $output['state'] = "Y";
    }else{
      $output['state'] = "N";
    }

    echo json_encode($output,JSON_UNESCAPED_UNICODE);
  break;

  case "secondPw" :
    $pwd = base64_encode($pw);
    if($num==1){
      $sql = "update d_ad_member SET mb_password='{$pwd}' WHERE mb_id='admin'";
    }else{
      $sql = "update d_second_pw SET password='{$pwd}'";
    }
    $re = sql_query($sql);
    $output['sql'] = $sql;
    if($re){
      $output['state'] = "Y";
    }else{
      $output['state'] = "N";
    }
    echo json_encode($output,JSON_UNESCAPED_UNICODE);
  break;

  case "lookup2ndpw" :
    $sql = "SELECT * FROM d_second_pw";
    $rs = sql_fetch($sql);
    $pwd = base64_decode($rs['password']);

    if($pw == $pwd){
      $output['state'] = "Y";
    }else{
      $output['state'] = "N";
    }
    echo json_encode($output,JSON_UNESCAPED_UNICODE);
  break;



}






 ?>
