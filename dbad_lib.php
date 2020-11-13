<?php
include_once('../dbad_config.php');
$host = $_SERVER["SERVER_NAME"];

ini_set("session.use_trans_sid", 0);    // PHPSESSID를 자동으로 넘기지 않음
ini_set("url_rewriter.tags","");  // 링크에 PHPSESSID가 따라다니는것을 무력화함 (해뜰녘님께서 알려주셨습니다.)
ini_set("session.cache_expire", 15); // 세션 캐쉬 보관시간 (분)
ini_set("session.gc_maxlifetime", 30); // session data의 garbage collection 존재 기간을 지정 (초)
ini_set("session.gc_probability", 1); // session.gc_probability는 session.gc_divisor와 연계하여 gc(쓰레기 수거) 루틴의 시작 확률을 관리합니다. 기본값은 1입니다. 자세한 내용은 session.gc_divisor를 참고하십시오.
ini_set("session.gc_divisor", 100); // session.gc_divisor는 session.gc_probability와 결합하여 각 세션 초기화 시에 gc(쓰레기 수거) 프로세스를 시작할 확률을 정의합니다. 확률은 gc_probability/gc_divisor를 사용하여 계산합니다. 즉, 1/100은 각 요청시에 GC 프로세스를 시작할 확률이 1%입니다. session.gc_divisor의 기본값은 100입니다.
ini_set("session.cookie_lifetime",0);
ini_set("display_errors",0);


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

function getList($start,$end,$mb_id,$ref){
  $sql = "SELECT class FROM d_ad_member WHERE mb_id='{$mb_id}'";
  $box = sql_fetch($sql);
  $m_class = $box['class'];

  $slimit = $start * $end - $end;
  if($slimit < 0){
    $slimit = 1;
  }

  if($mb_id=='admin'){
    $class_txt = "1";
  }else{
    $class_txt = "class = {$m_class}";
  }

  if($ref > 0){
    $type_txt = "&& type={$ref}";
  }else{
    $type_txt = "";
  }

  $sql = "SELECT * FROM d_log_info WHERE {$class_txt} {$type_txt} ORDER BY w_date DESC, w_hour DESC LIMIT {$slimit},{$end}";
  $re = sql_query($sql);

  $i = $slimit + 1;
  while($rs = sql_fetch_array($re)){
    $name = $rs['name'];
    $tel = $rs['tel'];
    $ip_addr = $rs['ip_addr'];
    $w_date = $rs['w_date'];
    $w_hour = $rs['w_hour'];
    $type = $rs['type'];
    $class = $rs['class'];

    $wh = $w_date." ".$w_hour;
    $csql = "SELECT c_name FROM d_class WHERE idx={$class}";
    $cbox = sql_fetch($csql);
    $c_name = $cbox['c_name'];

    // 오늘 중복된 휴대전화 번호 검색
    $jsql = "SELECT * FROM d_log_info WHERE tel='{$tel}' && w_date like '{$w_date}%'";
    $joong = sql_num_rows(sql_query($jsql));
    if($joong > 1){
      $red_class = " class='red'";
    }else{
      $red_class = "";
    }

    if($type==1){
      $type_txt = "다음";
    }else if($type==2){
      $type_txt = "네이버";
    }else if($type==3){
      $type_txt = "구글";
    }else if($type==4){
      $type_txt = "뉴스기사";
    }else if($type==5){
      $type_txt = "블로그";
    }else if($type==6){

    }else if($type==7){

    }else if($type==8){

    }else{
      $type_txt = "불명";
    }


    echo "<tr>";
    echo "<td {$red_class}>{$i}</td>";
    echo "<td {$red_class}>{$name}</td>";
    echo "<td {$red_class}>{$tel}</td>";
    echo "<td {$red_class}>{$ip_addr}</td>";
    echo "<td {$red_class}>{$wh}</td>";
    echo "<td {$red_class}>{$type_txt}</td>";
    echo "<td {$red_class}>{$c_name}</td>";
    echo "</tr>";

    $i++;
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


function getMember($start,$end){
  if($start==1){
    $start=0;
  }else{
    $start = $start * $end - $end;
  }
  $sql = "SELECT * FROM d_ad_member WHERE mb_id <> 'admin' && view='Y' ORDER BY idx LIMIT {$start},{$end}";
  $re = sql_query($sql);

  $i = $start + 1;
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


function getIpaddr(){
  $sql = "SELECT * FROM d_ipaddr";
  $re = sql_query($sql);

  $cnt = 1;
  while($rs = sql_fetch_array($re)){
    $provider = $rs['provider'];
    $idx = $rs['idx'];
    $ipbox1 = explode(".",$rs['ip1']);
    $ipbox2 = explode(".",$rs['ip2']);

    $div_class = "ipaddr".$cnt;
    $sel_class = "ip2".$cnt;

    $ip11 = $ipbox1[0];
    $ip12 = $ipbox1[1];
    $ip22 = $ipbox2[1];

    $gap = $ip22 - $ip12;

    echo "<div class='{$div_class}'>";
    echo "<input type='radio' class='in_radio' name='cho_ip' value='{$idx}' readonly />";
    echo "<input type='text' class='in_text' name='ip{$cnt}1' value='{$ip11}' readonly />";
    echo "<select class='{$sel_class}' id='{$sel_class}'>";
    for($i=0; $i<=$gap; $i++){
      echo "<option value={$ip12}>{$ip12}</option>";
      $ip12++;
    }
    echo "</select>";
    echo "<input type='text' class='in_text' name='ip{$cnt}3' maxlength='3' onKeyup='this.value=this.value.replace(/[^0-9]/g,\"\");' placeholder='입력범위 : 2~255'/>";
    echo "<input type='text' class='in_text' name='ip{$cnt}4' maxlength='3' onKeyup='this.value=this.value.replace(/[^0-9]/g,\"\");' placeholder='입력범위 : 2~254'/>";
    echo "<input type='button' class='btn' onclick='confirmIp()' value='확인' />";
    echo "</div>";

    $cnt++;
  }
}


function getClassSelector(){
  $csql = "SELECT * FROM d_class WHERE view='Y'";
  $cre = sql_query($csql);

  echo "<select name='class' class='form-control' id='sl2'>";
  while($row=sql_fetch_array($cre)){
    $idx = $row['idx'];
    $c_name = $row['c_name'];
    echo "<option value='{$idx}'>{$c_name}</option>";
  }
  echo "</select>";
}


function getPaging($table,$cur_page,$mb_id,$ref){
  if($table == "d_ad_member"){
    $where = "mb_id <> 'admin'";
  }else if($table == "d_class"){
    $where .= "view = 'Y'";
  }else if($table == "d_log_info"){
    $sql = "SELECT class FROM d_ad_member WHERE mb_id='{$mb_id}'";
    $box = sql_fetch($sql);
    $m_class = $box['class'];

    if($mb_id=='admin'){
      $where = "1";
    }else{
      $where = "class = {$m_class}";
    }

    if($ref > 0){
      $type_txt = "&& type={$ref}";
    }else{
      $type_txt = "";
    }
    $where .= $type_txt;
  }


  $sql = "SELECT * FROM {$table} WHERE {$where}";
  // 페이징
  $total_cnt = sql_num_rows(sql_query($sql));  // 전체 게시물수
  $page_rows = 10;  // 한페이지에 표시할 데이터 수
  $total_page = ceil($total_cnt / $page_rows); // 총 페이지수

    // 총페이지가 0이라면 1로 설정
  if($total_page == 0){
    ++$total_page;
  }

  $block_limit = 5; // 한 화면에 뿌려질 블럭 개수
  $total_block = ceil($total_page / $block_limit);  // 전체 블록수
  $cur_page = $cur_page ? $cur_page : 1;  // 현재 페이지
  $cur_block = ceil($cur_page / $block_limit); // 현재블럭 : 화면에 표시 될 페이지 리스트
  $first_page = (((ceil($cur_page / $block_limit) -1) * $block_limit) +1);  // 현재 블럭의 시작
  $end_page = $first_page + $block_limit - 1; // 현재 블럭의 마지막

  if($total_page < $end_page){
    $end_page = $total_page;
  }


  $prev = $first_page - 1;
  $next = $end_page + 1;
  // 페이징 준비 끝


  $sql = "SELECT * FROM {$table} WHERE {$where} LIMIT {$first_page},{$end_page}";
  $total_cnt = sql_num_rows($sql);

  // 이전 블럭을 눌렀을때 현재 페이지 세팅.
  $pre_block = $cur_page - $block_limit;
  if($pre_block < $block_limit+1){
    $pre_block = $block_limit;
  }

  // 다음블럭의 첫번째 페이지 산출
  $next_block = $cur_page + $block_limit;
  if($next_block > $total_page){
    $next_block = (($cur_block + 1) * $block_limit) - ($block_limit-1);
  }

  // 이전 버튼을 눌렀을때 LIMIT 처리
  $prev_start = $first_page - $block_limit;
  $prev_end = $end_page - $block_limit;
  if($prev_start < $block_limit+1){
    $prev_start = 1;
    $prev_end = $block_limit;
  }

  // 다음 버튼을 눌렀을때 LIMIT 처리
  $next_start = $first_page + $block_limit;
  $next_end = $end_page + $block_limit;
  if($next_end > $total_page){
    $next_end = $total_page;
    if($next_start > $next_end){
      $next_start = $cur_block * $block_limit + 1;
    }
  }


  $cur_path = $_SERVER['SCRIPT_NAME'];
  $prev_url = $cur_path."?table={$table}&cur_page={$pre_block}&start={$prev_start}&end={$page_rows}";
  $next_url = $cur_path."?table={$table}&cur_page={$next_block}&start={$next_start}&end={$page_rows}";


  // 이전, 다음버튼 제어 처리
  if($cur_block == $total_block){
    $end_class = "disabled";
    $li_href2 = " ";
  }else{
    $end_class = " ";
    $li_href2 = "href='{$next_url}'";
  }
  if($cur_block == 1){
    $start_class = "disabled";
    $li_href1 = " ";
  }else{
    $start_class = " ";
    $li_href1 = "href='{$prev_url}'";
  }



  echo "<ul class='pagination'>";
    // <!-- li태그의 클래스에 disabled를 넣으면 마우스를 위에 올렸을 때 클릭 금지 마크가 나오고 클릭도 되지 않는다.-->
    // <!-- disabled의 의미는 앞의 페이지가 존재하지 않다는 뜻이다. -->
  echo "<li class='{$start_class}'>";
  echo "<a {$li_href1}><span>«</span></a>";
  echo "</li>";
  // <!-- li태그의 클래스에 active를 넣으면 색이 반전되고 클릭도 되지 않는다. -->
  // <!-- active의 의미는 현재 페이지의 의미이다. -->
  for($i=$first_page; $i<=$end_page; $i++){
    if($i==$cur_page){
      $act = "active";
      $cont = "<a>{$i}</a>";
    }else{
      $act = " ";
      $cur_url = $cur_path."?table={$table}&cur_page={$i}&end={$page_rows}";
      $cont = "<a href='{$cur_url}'>{$i}</a>";
    }
    echo "<li class='{$act}'>{$cont}</li>";
  }
  echo "<li class='{$end_class}'><a {$li_href2}><span>»</span></a></li>";
  echo "</ul>";



}



?>
