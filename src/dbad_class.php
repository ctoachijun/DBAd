<?php
include_once('./dbad_head.php');

if(!$table){
  $table = "d_class";
}
if(!$cur_page){
  $cur_page = 1;
}
if(!$end){
  $end = 10;   // page_rows 값을 넣어줌
}
?>

  <div id="ad_list">
    <div class="cont">

      <div class="layer_div">
      <div class="list">
        <div class="div_table">
          <table class="table table-hover">
            <tr class="tr_head">
              <th>번호</th>
              <th>광고명</th>
              <th>광고코드</th>
              <th></th>
            </tr>

    <?      getClass();    ?>

          </table>
        </div>
      </div>
      <div class="row right">
          <div class="col-md-12">

              <div class="page-header">
                    <h3>광고 등록</h3>
              </div>

              <form method="POST" action="">
                  <div class="form-group top_div">
                  <label for="txt1">광고명</label>
                      <input type="text" name="c_name" class="form-control" id="txt1">
                  </div>
                  <div class="form-group">
                      <label for="cc">광고코드</label>
                      <input type="text" name="c_code" class="form-control" id="cc">
                  </div>
                  <div class="form-group btn">
                      <input type="button" class="btn send" onclick="insert_class()" value="등록">
                  </div>
              </form>
          </div>
      </div>
      </div>

      <div class="paging">
        <? getPaging($table,$cur_page,$mb_id) ?>
      </div>


    </div>
  </div>




<? include_once("./dbad_tail.php");  ?>
