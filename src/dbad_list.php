<?php
include_once('./dbad_head.php');

$url = $_SERVER['REQUEST_URI'];

if(!$ref){
  $ref=0;
}
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
      <div class="d_list">
        <table class="table table-hover">
          <tr class="tr_head">
            <th class="th_num">번호</th>
            <th class="th_name">이름</th>
            <th class="th_cont">전화번호</th>
            <th class="th_cont">ip주소</th>
            <th class="th_date">날짜 시간</th>
            <th class="th_class_name">분류</th>
            <th class="th_class">광고</th>
          </tr>

      <?  getList($cur_page,$end,$mb_id,$ref)  ?>

        </table>
      </div>
      <div class="r_btn">
        <form method="POST" name="sort_form" id="sform" action="<?=$url?>">
          <div class="radio_b">
            <input type="radio" id="r1" name="ref" value="0" onclick="sortRef()" <? if($ref==0) echo "checked"; ?>/>
            <label for="r1">전체</label>
          </div>
          <div class="radio_b">
            <input type="radio" id="r2" name="ref" value="1" onclick="sortRef()" <? if($ref==1) echo "checked"; ?>/>
            <label for="r2">다음</label>
          </div>
          <div class="radio_b">
            <input type="radio" id="r3" name="ref" value="2" onclick="sortRef()" <? if($ref==2) echo "checked"; ?>/>
            <label for="r3">네이버</label>
          </div>
          <div class="radio_b">
            <input type="radio" id="r4" name="ref" value="3" onclick="sortRef()" <? if($ref==3) echo "checked"; ?>/>
            <label for="r4">구글</label>
          </div>
          <div class="radio_b">
            <input type="radio" id="r5" name="ref" value="4" onclick="sortRef()" <? if($ref==4) echo "checked"; ?>/>
            <label for="r5">뉴스</label>
          </div>
          <div class="radio_b">
            <input type="radio" id="r6" name="ref" value="5" onclick="sortRef()" <? if($ref==5) echo "checked"; ?>/>
            <label for="r6">블로그</label>
          </div>
        </form>
      </div>
    </div>
    <div class="paging">
      <? getPaging($table,$cur_page,$mb_id,$ref) ?>
    </div>
  </div>


<? include_once("./dbad_tail.php");  ?>
