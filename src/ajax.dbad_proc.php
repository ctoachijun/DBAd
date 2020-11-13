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
    mb_id='{$mb_id}', mb_password='{$pwd}', mb_name='{$mb_name}', class='{$class}'
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
    mb_name='{$mb_name}', class='{$class}' WHERE idx={$idx}";
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

    $box = explode(":",$response);
    $box2 = explode("\"",end($box));
    $contry = $box2[1];

    $output['re'] = $contry;
    echo json_encode($output,JSON_UNESCAPED_UNICODE);

  break;

  case "send_dummy" :
    $sql = "INSERT INTO d_log_info SET
    name='{$name}', tel='{$tel_num}', ip_addr='{$ipaddr}', w_date='{$w_date}', w_hour='{$hms}', type={$type}, class={$class}";
    $re = sql_query($sql);

    $output['sql'] = $sql;
    if($re){
      $output['state'] = "Y";
    }else{
      $output['state'] = "N";
    }

    echo json_encode($output,JSON_UNESCAPED_UNICODE);

    // 전송할 API 에 curl 처리할거있으면 하기

  break;


}






 ?>
