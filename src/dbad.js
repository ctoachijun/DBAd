function chk_login(){
  let id = $("#uid").val();
  let pw = $("#upw").val();

  if(!id){
    alert("아이디를 입력해 주세요");
    $("#uid").focus();
    return false;
  }
  if(!pw){
    alert("비밀번호를 입력해 주세요");
    $("#upw").focus();
    return false;
  }

  $("FORM").submit();
}

function move(num){
  if(num==1){
    location.href='dbad_list.php';
  }else if(num==2){
    location.href='dbad_member.php';
  }else if(num==3){
    location.href='dbad_class.php';
  }
}


function insert_mem(){
  let mb_id = $("input[name=mb_id]").val();
  let mb_password = $("input[name=mb_password]").val();
  let mb_password_re = $("input[name=mb_password_re]").val();
  let mb_name = $("input[name=mb_name]").val();
  let class_num = $("#sl2").val();

  if(!mb_id){
    alert("아이디를 입력해 주세요.");
    $("#txt1").focus();
    return false;
  }
  if(!mb_password){
    alert("비밀번호를 입력해 주세요.");
    $("#pw1").focus();
    return false;
  }
  if(!mb_password_re){
    alert("비밀번호 확인을 입력해 주세요.");
    $("#pw2").focus();
    return false;
  }
  if(mb_password != mb_password_re){
    alert("비밀번호가 일치하지 않습니다.");
    return false;
  }
  if(!mb_name){
    alert("업체명을 입력해 주세요.");
    $("#cn").focus();
    return false;
  }


  let box = { "w_type":"insert_member", "mb_name":mb_name, "class":class_num, "mb_id":mb_id, "mb_password":mb_password };

  $.ajax({
          url: "ajax.dbad_proc.php",
          type: "post",
          contentType:'application/x-www-form-urlencoded;charset=UTF8',
          data: box
  }).done(function(data){
    let json = JSON.parse(data);
    console.log(json.sql);
    if(json.state=="Y"){
      alert("등록 했습니다.");
      history.go(0);
    }else{
      alert("실패 했습니다.");
    }
  });

}

function edit_mem(num){
  let mb_name = $("input[name=mb_name"+num+"]").val();
  let class_num = $("select[name=class"+num+"]").val();
  let box = {"w_type":"edit_member", "idx":num, "mb_name":mb_name, "class":class_num};

  $.ajax({
          url: "ajax.dbad_proc.php",
          type: "post",
          contentType:'application/x-www-form-urlencoded;charset=UTF8',
          data: box
  }).done(function(data){
    let json = JSON.parse(data);
    if(json.state=="Y"){
      alert("변경 했습니다.");
      history.go(0);
    }else{
      alert("실패 했습니다.");
    }
  });
}


function delete_mem(num){

  let box = {"w_type":"delete_member", "idx":num};

  if(confirm("삭제 하시겠습니까?")){
    $.ajax({
            url: "ajax.dbad_proc.php",
            type: "post",
            contentType:'application/x-www-form-urlencoded;charset=UTF8',
            data: box
    }).done(function(data){
      let json = JSON.parse(data);
      if(json.state=="Y"){
        alert("삭제 했습니다.");
        history.go(0);
      }else{
        alert("실패 했습니다.");
      }
    });
  }
}



function insert_class(){
  let c_name = $("#txt1").val();
  let c_code = $("#cc").val();

  if(!c_name){
    alert("광고명을 입력해 주세요.")
    $("#txt1").focus();
    return false;
  }
  if(!c_code){
    alert("광고코드를 입력해 주세요.")
    $("#cc").focus();
    return false;
  }

  let box = {"w_type":"insert_class", "c_name":c_name, "c_code":c_code};
  $.ajax({
          url: "ajax.dbad_proc.php",
          type: "post",
          contentType:'application/x-www-form-urlencoded;charset=UTF8',
          data: box
  }).done(function(data){
    let json = JSON.parse(data);
    if(json.state=="Y"){
      alert("등록 했습니다.");
      history.go(0);
    }else{
      alert("실패했습니다.");
    }
  });
}


function edit_class(num){
  let c_name = $("input[name=mb_name"+num+"]").val();
  let c_code = $("input[name=mb_code"+num+"]").val();

  if(!c_name){
    alert("광고명을 입력해 주세요.")
    return false;
  }
  if(!c_code){
    alert("광고코드를 입력해 주세요.")
    return false;
  }

  let box = {"w_type":"edit_class", "c_name":c_name, "c_code":c_code, "idx":num};
  $.ajax({
          url: "ajax.dbad_proc.php",
          type: "post",
          contentType:'application/x-www-form-urlencoded;charset=UTF8',
          data: box
  }).done(function(data){
    let json = JSON.parse(data);
    if(json.state=="Y"){
      alert("변경 했습니다.");
      history.go(0);
    }else{
      alert("실패 했습니다.");
    }
  });
}


function delete_class(num){

  let box = {"w_type":"delete_class", "idx":num};

  if(confirm("삭제 하시겠습니까?")){
    $.ajax({
            url: "ajax.dbad_proc.php",
            type: "post",
            contentType:'application/x-www-form-urlencoded;charset=UTF8',
            data: box
    }).done(function(data){
      let json = JSON.parse(data);
      if(json.state=="Y"){
        alert("삭제 했습니다.");
        history.go(0);
      }else{
        alert("실패 했습니다.");
      }
    });
  }
}
