<?php
include_once('./dbad_head.php');

if(!$num){
  $num=1;
}
$table = "d_log_info";

if(!$cur_page){
  $cur_page = 1;
}
if(!$end){
  $end = 10;   // page_rows 값을 넣어줌
}

?>

  <div id="data_list">
    <div class="list">
      <table class="table table-hover">
        <tr class="tr_head">
          <th class="th_num">번호</th>
          <th class="th_name">이름</th>
          <th class="th_cont">전화번호</th>
          <th class="th_cont">ip주소</th>
          <th class="th_date">날짜 시간</th>
          <th class="th_class">분류</th>
        </tr>

    <?  getList($cur_page,$end,$mb_id)  ?>

      </table>
    </div>
    <div class="paging">
      <? getPaging($table,$cur_page,$mb_id) ?>
    </div>
  </div>


<? include_once("./dbad_tail.php");  ?>
