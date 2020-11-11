<?php
include_once('./dbad_head.php');

?>

<div id="ad_list">
  <div class="cont">
    <div class="list">
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
                    <input type="button" class="btn" onclick="insert_class()" value="등록">
                </div>
            </form>
        </div>
    </div>


  </div>
</div>
