<?php
include_once('../dbad_lib.php');

if($logout=="out"){
  session_destroy();
}

?>
<!DOCTYPE html>
<html lang="ko">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="./src/dbad.css">
    <title>로그인</title>

  </head>

  <body cellpadding="0" cellspacing="0" marginleft="0" margintop="0" width="100%" height="100%" align="center">

  <div class="login_content">

	<div class="card align-middle" style="width:20rem; border-radius:20px;">
		<div class="card-title" style="margin-top:30px;">
			<h2 class="card-title text-center" style="color:#113366;">로그인</h2>
		</div>
		<div class="card-body">
      <form class="form-signin" method="POST" action="./src/dbad_check.php">
        <h5 class="form-signin-heading">로그인 정보를 입력하세요</h5>
        <input type="text" id="uid" name="uid" class="form-control" placeholder="ID" required autofocus><BR>
        <input type="password" id="upw" name="upw" class="form-control" placeholder="Password" required><br>
        <button id="btn-Yes" class="btn btn-lg btn-primary btn-block" onclick="chk_login()" type="submit">로 그 인</button>
      </form>

		</div>
	</div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </div>
  </body>
</html>

<script>

function chk_login(){
  let id = $("#uid").val();
  let pw = $("#upw").val();

  let box = {"id":id, "pw":pw, "w_type":"chk_login"};
  $.ajax({
          url: "ajax.dbad_test_proc.php",
          type: "post",
          contentType:'application/x-www-form-urlencoded;charset=UTF8',
          // async: false,
          data: box
  }).done(function(data){
    let json = JSON.parse(data);
    if(json.state=="Y"){
      alert("계정일치.");
      // move_back();
    }else{
      alert("ID 또는 비밀번호를 확인 해 주세요");
    }
  });
  return false;
}

</script>
