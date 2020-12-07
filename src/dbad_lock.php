<?php
include_once('./dbad_head.php');


?>


<div id="lock">
  <div class="lock_pw">
    <label for="second_pw">비밀번호 : </label>
    <input type="password" name="second_pw" id="second_pw" maxlength="20"/>
    <input type="button" value="확인" onclick="confirm_pw()" />
  </div>
</div>




<? include_once("./dbad_tail.php");  ?>
