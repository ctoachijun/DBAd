<?php
include_once('./dbad_head.php');

$sql = "SELECT * FROM d_class";
$re = sql_query($sql);

?>

<div id="mb_list">
  <div class="cont">
    <div class="list">
      <table class="table table-hover">
        <tr class="tr_head">
          <th>번호</th>
          <th>ID</th>
          <th>업체명</th>
          <th>광고종류</th>
          <th></th>
        </tr>

<?     getMember()    ?>

      </table>
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
                    <label for="sl1">광고종류</label>
                    <select name="class" class="form-control" id="sl2">
                  <? while($row=sql_fetch_array($re)){ ?>
                        <option value="<?=$row['idx']?>"><?=$row['c_name']?></option>
                  <? } ?>
                    </select>
                </div>
                <div class="form-group btn">
                    <input type="button" class="btn" onclick="insert_mem()" value="등록" />
                </div>
            </form>
        </div>
    </div>


  </div>
</div>
