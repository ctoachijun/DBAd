<?php
include_once('../dbad_lib.php');

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

}



 ?>
