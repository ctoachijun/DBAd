<?php
include_once('../dbad_config.php');
$host = $_SERVER["SERVER_NAME"];

ini_set("session.use_trans_sid", 0);    // PHPSESSID를 자동으로 넘기지 않음
ini_set("url_rewriter.tags","");  // 링크에 PHPSESSID가 따라다니는것을 무력화함 (해뜰녘님께서 알려주셨습니다.)
ini_set("session.cache_expire", 180); // 세션 캐쉬 보관시간 (분)
ini_set("session.gc_maxlifetime", 10800); // session data의 garbage collection 존재 기간을 지정 (초)
ini_set("session.gc_probability", 1); // session.gc_probability는 session.gc_divisor와 연계하여 gc(쓰레기 수거) 루틴의 시작 확률을 관리합니다. 기본값은 1입니다. 자세한 내용은 session.gc_divisor를 참고하십시오.
ini_set("session.gc_divisor", 100); // session.gc_divisor는 session.gc_probability와 결합하여 각 세션 초기화 시에 gc(쓰레기 수거) 프로세스를 시작할 확률을 정의합니다. 확률은 gc_probability/gc_divisor를 사용하여 계산합니다. 즉, 1/100은 각 요청시에 GC 프로세스를 시작할 확률이 1%입니다. session.gc_divisor의 기본값은 100입니다.
ini_set("session.cookie_lifetime",0);
ini_set("display_errors",0);
// ini_set("session.cookie_domain",$host);
// ini_set('display_errors', 1);
// ini_set('error_reporting', E_ALL);

session_start();

//==========================================================================================================================
// extract($_GET); 명령으로 인해 page.php?_POST[var1]=data1&_POST[var2]=data2 와 같은 코드가 _POST 변수로 사용되는 것을 막음
// 081029 : letsgolee 님께서 도움 주셨습니다.
//--------------------------------------------------------------------------------------------------------------------------
$ext_arr = array ('PHP_SELF', '_ENV', '_GET', '_POST', '_FILES', '_SERVER', '_COOKIE', '_SESSION', '_REQUEST',
                  'HTTP_ENV_VARS', 'HTTP_GET_VARS', 'HTTP_POST_VARS', 'HTTP_POST_FILES', 'HTTP_SERVER_VARS',
                  'HTTP_COOKIE_VARS', 'HTTP_SESSION_VARS', 'GLOBALS');
$ext_cnt = count($ext_arr);
for ($i=0; $i<$ext_cnt; $i++) {
    // POST, GET 으로 선언된 전역변수가 있다면 unset() 시킴
    if (isset($_GET[$ext_arr[$i]]))  unset($_GET[$ext_arr[$i]]);
    if (isset($_POST[$ext_arr[$i]])) unset($_POST[$ext_arr[$i]]);
}

// PHP 4.1.0 부터 지원됨
// php.ini 의 register_globals=off 일 경우
@extract($_GET);
@extract($_POST);
@extract($_SERVER);


/*
  여기서부터 함수 등록
*/

function get_token(){
  $token = "";
  $token1 = "";

  // 32비트의 보안키 생성
  // 리눅스 커널 안전성이 보장된 urandom 으로 보안키 생성
  $fp = @fopen('/dev/urandom','rb');

  if($fp !== FALSE) {
      $token .= @fread($fp,16);
      @fclose($fp);
      // echo "urandom";
  }else{
    // urandom 접속 실패시 보안키 작성
    $token = openssl_random_pseudo_bytes(16,$result);
  }

  // 바이너리 형식을 변환
  $box = bin2hex($token);
  // 64비트로 재암호화.
  $token = base64_encode(hash('sha512',$box,true));

  return $token;

}


function chk_token($token,$mb_id){
  $sql = "SELECT _token FROM d_ad_member WHERE mb_id='{$mb_id}'";
  $re = sql_fetch($sql);
  $db_token = $re['_token'];

  if($db_token != $token){
    return false;
  }else{
    return true;
  }

}


function getClass(){
  $sql = "SELECT * FROM d_class WHERE view='Y'";
  $re = sql_query($sql);
  $i = 1;

  while($rs = sql_fetch_array($re)){
    $c_name = $rs['c_name'];
    $c_code = $rs['c_code'];
    $idx = $rs['idx'];

    echo "
      <tr>
        <td class='td_num'>{$i}</td>
        <td class='td_cont'><input type='text' name='mb_name{$idx}' class='form-control' value='{$c_name}' /></td>
        <td class='td_cont'><input type='text' name='mb_code{$idx}' class='form-control' value='{$c_code}' /></td>
        <td class='td_btn'><button class='btn1' onclick='edit_class({$idx})'>수정</button><button class='btn2' onclick='delete_class({$idx})'>삭제</button></td>
      </tr>
      ";
    $i++;
  }
}


function getMember(){
  $sql = "SELECT * FROM d_ad_member WHERE mb_id <> 'admin' && view='Y'";
  $re = sql_query($sql);

  $i = 1;
  while($rs = sql_fetch_array($re)){
    $mb_id = $rs['mb_id'];
    $mb_name = $rs['mb_name'];
    $idx = $rs['idx'];
    $class = $rs['class'];

    $csql = "SELECT * FROM d_class WHERE view='Y'";
    $cre = sql_query($csql);

    echo "
          <tr>
            <td class='td_num'>{$i}</td>
            <td class='td_id'><p>{$mb_id}</p></td>
            <td class='td_cont'><input type='text' name='mb_name{$idx}' class='form-control' value='{$mb_name}' /></td>
            <td class='td_cont'>
              <select name='class{$idx}' class='form-control' id='sl1'>
          ";
             while($row=sql_fetch_array($cre)){
               echo $row['idx'];
               if($row['idx'] == $class){
                 $selected = "selected";
               }else{
                 $selected = "";
               }
    echo "      <option value='".$row['idx']."' {$selected}>".$row['c_name']."</option>";
             }
    echo "
              </select>
            </td>
            <td class='td_btn'><button class='btn1' onclick='edit_mem({$idx})'>수정</button><button class='btn2' onclick='delete_mem({$idx})'>삭제</button></td>
          </tr>
          ";
    $i++;
  }





}






?>
