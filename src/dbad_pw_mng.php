<?php
include_once('./dbad_head.php');

if($mb_id!="admin"){
  echo "<script>location.replace('./dbad_list.php');</script>";
}

?>

<div id="pw_mng">
  <div class="cont">
    <div class="admin_pw">
      <div class="page-header">
            <h3>관리자 비밀번호 설정</h3>
      </div>
      <div class="pw_cont">
        <input type="text" class="admin_id form-control" value="admin" disabled/>
        <input type="password" name="admin_pw" class="pw1 form-control" id="admin_pw" maxlength="20" placeholder="비밀번호"/>
        <input type="password" name="admin_pw_re" class="pw2 form-control" id="admin_pw_re" maxlength="20" placeholder="비밀번호 확인"/>
        <input type="button" class="btn" value="설정" onclick="setting_pw(1)" />
      </div>
    </div>
    <div class="second_pw">
      <div class="page-header">
            <h3>2차 비밀번호 설정</h3>
      </div>
      <div class="pw_cont">
        <input type="password" name="second_pw" class="form-control" id="second_pw" maxlength="20" placeholder="비밀번호"/>
        <input type="password" name="second_pw_re" class="form-control" id="second_pw_re" maxlength="20" placeholder="비밀번호 확인"/>
        <input type="button" class="btn" value="설정" onclick="setting_pw(2)" />
      </div>
    </div>

  </div>
</div>


<? include_once("./dbad_tail.php");  ?>
