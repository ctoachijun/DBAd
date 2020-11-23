<?php
include_once('./dbad_head.php');

if($mb_id!="admin"){
  echo "<script>location.replace('./dbad_list.php');</script>";
}


if(!$table){
  $table = "d_ad_member";
}
if(!$cur_page){
  $cur_page = 1;
}
if(!$end){
  $end = 10;   // page_rows 값을 넣어줌
}



?>

  <div id="mb_list">
    <div class="cont">

      <div class="layer_div">
      <div class="list">
        <div class="div_table">
          <table class="table table-hover">
            <tr class="tr_head">
              <th>번호</th>
              <th>ID</th>
              <th>연락처</th>
              <th>업체명</th>
              <th>광고종류</th>
              <th></th>
            </tr>

    <?     getMember($cur_page,$end)    ?>

          </table>
        </div>
      </div>

      <div class="row right">
          <div class="col-md-12">

              <div class="page-header">
                    <h3>계정 등록</h3>
              </div>

              <form method="POST" action="">
                  <div class="form-group top_div">
                  <label for="txt1">아이디</label>
                      <input type="text" name="mb_id" class="form-control" id="txt1" />
                  </div>
                  <div class="form-group">
                      <label for="pw1">비밀번호</label>
                      <input type="password" name="mb_password" class="form-control" id="pw1">
                  </div>
                  <div class="form-group">
                      <label for="pw2">비밀번호 확인</label>
                      <input type="password" name="mb_password_re" class="form-control" id="pw2">
                  </div>
                  <div class="form-group">
                      <label for="cn">업체명</label>
                      <input type="text" name="mb_name" class="form-control" id="cn">
                  </div>
                  <div class="form-group">
                      <label for="ct">연락처</label>
                      <input type="text" maxlength="11" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');" placeholder='숫자만 입력' name="mb_tel" class="form-control" id="ct">
                  </div>
                  <div class="form-group">
                      <label for="sl1">광고종류</label>
                      <? getClassSelector() ?>
                  </div>
                  <div class="form-group btn_div">
                      <input type="button" class="btn" onclick="insert_mem()" value="등록" />
                  </div>
              </form>
          </div>
      </div>
      </div>

      <div class="paging">
        <? getPaging($table,$cur_page,$mb_id,$ref) ?>
      </div>

    </div>
  </div>

<? include_once("./dbad_tail.php");  ?>
