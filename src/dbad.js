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
  }else if(num==4){
    location.href='dbad_pw_mng.php';
  }else if(num==5){
    location.href='dbad_trans.php';
  }

}


function insert_mem(){
  let mb_id = $("input[name=mb_id]").val();
  let mb_password = $("input[name=mb_password]").val();
  let mb_password_re = $("input[name=mb_password_re]").val();
  let mb_name = $("input[name=mb_name]").val();
  let mb_tel = $("input[name=mb_tel]").val();
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
  if(!mb_tel){
    alert("연락처를 입력해 주세요.");
    $("#ct").focus();
    return false;
  }

  let box = { "w_type":"insert_member", "mb_name":mb_name, "class":class_num, "mb_id":mb_id, "mb_password":mb_password, "mb_tel":mb_tel };
  $.ajax({
          url: "ajax.dbad_proc.php",
          type: "post",
          contentType:'application/x-www-form-urlencoded;charset=UTF8',
          data: box
  }).done(function(data){
    let json = JSON.parse(data);
    // console.log(json.sql);
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
  let mb_tel = $("input[name=mb_tel"+num+"]").val();
  let class_num = $("select[name=class"+num+"]").val();
  let box = {"w_type":"edit_member", "idx":num, "mb_name":mb_name, "mb_tel":mb_tel, "class":class_num};

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

function chkIp(){
  let rchk = $("input[name=cho_ip]:checked").val();
  let ip1 = $("input[name=ip"+rchk+"1]").val();
  let ip2 = $("#ip2"+rchk).val();
  let ip3 = $("input[name=ip"+rchk+"3]").val();
  let ip4 = $("input[name=ip"+rchk+"4]").val();

  if(!rchk){
    alert("IP대역을 선택 해 주세요.");
    return false;
  }
  if(!ip3){
    alert("세번째칸이 입력되지 않았습니다");
    return false;
  }
  if(!ip4){
    alert("네번째칸이 입력되지 않았습니다");
    return false;
  }
  if(ip3 < 2){
    alert("세번째칸은 2보다 작을 수 없습니다.");
    return false;
  }
  if(ip3 > 254){
    alert("세번째칸은 254보다 클 수 없습니다.");
    return false;
  }
  if(ip4 < 2){
    alert("네번째칸은 2보다 작을 수 없습니다.");
    return false;
  }
  if(ip4 > 254){
    alert("네번째칸은 254보다 클 수 없습니다.");
    return false;
  }
  let cho_ip = ip1+"."+ip2+"."+ip3+"."+ip4;
  return cho_ip;
}


function confirmIp(){
  let ipaddr = chkIp();
  if(ipaddr){
    let box = {"w_type":"chk_ip", "ipaddr":ipaddr}
    $.ajax({
            url: "ajax.dbad_proc.php",
            type: "post",
            contentType:'application/x-www-form-urlencoded;charset=UTF8',
            data: box
    }).done(function(data){
      let json = JSON.parse(data);
      if(json.re=="KR"){
        alert(ipaddr+"\n국내 IP주소 입니다.");
      }else{
        alert(ipaddr+"\n해외 IP주소 입니다.");
      }
    });
  }
}


function sendDummy(){
  let w_date = $("#DatePicker").val();
  let name = $("#txta1").val();
  let tel_num = $("#txta2").val();
  let sclass = $("#sl2").val();

  if(!name){
    alert("이름을 입력해 주세요");
    return false;
  }
  if(!tel_num){
    alert("연락처를 입력해 주세요");
    return false;
  }


  if(confirm("전송하시겠습니까?")){
    let box = {"w_type":"send_dummy", "w_date":w_date, "name":name, "tel_num":tel_num, "class":sclass,}
    $.ajax({
            url: "ajax.dbad_proc.php",
            type: "post",
            contentType:'application/x-www-form-urlencoded;charset=UTF8',
            data: box
    }).done(function(data){
      let json = JSON.parse(data);
      console.log(json.cnt);
      if(json.state=="Y"){
        alert("전송했습니다.");
      }else{
        alert("전송에 실패 했습니다.");
      }
    });
  }

  // 위 데이터들을 원하는 데이터형식으로 취합해 URL 또는 API를 이용하면 된다.
}


function sortRef(){
  $("#curp").val(1);
  $("FORM").submit();
}


function onlyNum(obj){
  let val1;
  val1 = obj.value;
  val1 = val1.replace(/[^0-9]/g,"");
  obj.value = val1;
}


function del_info(idx){
  if(confirm("삭제하시겠습니까?")){
    let box = {"w_type":"del_info", "idx":idx}
    $.ajax({
            url: "ajax.dbad_proc.php",
            type: "post",
            contentType:'application/x-www-form-urlencoded;charset=UTF8',
            data: box
    }).done(function(data){
      let json = JSON.parse(data);
      console.log(json.sql);
      if(json.state=="Y"){
        alert("삭제했습니다.");
        history.go(0);
      }else{
        alert("삭제에 실패 했습니다.");
      }
    });
  }
}

function setting_pw(num){
  let msg = "";
  let pw1;
  let pw2;
  if(num==1){
    pw1 = $("#admin_pw").val();
    pw2 = $("#admin_pw_re").val();
    if(!pw1){
      alert("비밀번호를 입력해주세요.");
      $("#admin_pw").focus();
      return false;
    }
    if(!pw2){
      alert("비밀번호를 입력해주세요.");
      $("#admin_pw_re").focus();
      return false;
    }
    if(pw1 != pw2){
      alert("비밀번호가 맞지않습니다.");
      $("#admin_pw").focus();
      return false;
    }else{
      msg = "관리자 비밀번호를";
    }

  }else if(num==2){
    pw1 = $("#second_pw").val();
    pw2 = $("#second_pw_re").val();
    if(!pw1){
      alert("비밀번호를 입력해주세요.");
      $("#second_pw").focus();
      return false;
    }
    if(!pw2){
      alert("비밀번호를 입력해주세요.");
      $("#second_pw_re").focus();
      return false;
    }
    if(pw1 != pw2){
      alert("비밀번호가 맞지않습니다.");
      $("#second_pw").focus();
      return false;
    }else{
      msg = "2차 비밀번호를";
    }
  }

  let box = {"w_type":"secondPw","pw":pw1, "num":num}
  if(confirm(msg+" 설정하시겠습니까?")){
    $.ajax({
            url: "ajax.dbad_proc.php",
            type: "post",
            contentType:'application/x-www-form-urlencoded;charset=UTF8',
            data: box
    }).done(function(data){
      let json = JSON.parse(data);
      console.log(json.sql);
      if(json.state=="Y"){
        alert(msg + "설정 했습니다.");
        history.go(0);
      }else{
        alert(msg + "설정에 실패 했습니다.");
      }
    });
  }
}


function confirm_pw(){
  let pw = $("#second_pw").val();
  let box = {"w_type":"lookup2ndpw","pw":pw,}
  $.ajax({
          url: "ajax.dbad_proc.php",
          type: "post",
          contentType:'application/x-www-form-urlencoded;charset=UTF8',
          data: box
  }).done(function(data){
    let json = JSON.parse(data);
    if(json.state=="Y"){
      location.replace('dbad_trans.php?spw=Y');
    }else{
      alert("비밀번호를 확인 해 주세요.");
    }
  });
}
