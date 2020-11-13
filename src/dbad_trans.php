<?php
include_once('./dbad_head.php');

$hour = sprintf("%02d",rand(0,23));
$min = sprintf("%02d",rand(0,59));
$sec = sprintf("%02d",rand(0,59));

$hms = $hour.":".$min.":".$sec;



?>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">


  <div id="ad_trans">
    <div class="cont">
      <div class="left">
        <div class="title_top">
          <h3>IP주소 선택</h3>
        </div>
        <div class="ipaddress">

    <?   getIpaddr(); ?>

        </div>
      </div>

      <div class="right">
        <div class="title_top">
          <h3>데이터 입력</h3>
        </div>
        <div class="data_send">
          <input type="hidden" id="hms" value="<?=$hms?>" />
          <table name="send_table">
            <tr>
              <th>날짜 선택</th>
              <td class="td_cont"><input type="text" name="w_date" id="DatePicker" /></td>
            </tr>
            <tr><td class="blank"></td></tr>
            <tr>
              <th>이름</th>
              <td class="td_cont"><input type="text" name="name" /></td>
            </tr>
            <tr><td class="blank"></td></tr>
            <tr>
              <th>휴대폰번호</th>
              <td class="td_cont"><input type="text" name="tel_num" maxlength="11" oninput="this.value=this.value.replace(/[^0-9.]/g,'').replace(/(\..*)\./g, '$1');" placeholder=" - 빼고입력"/></td>
            </tr>
            <tr><td class="blank"></td></tr>
            <tr>
              <th>광고선택</th>
              <td class="td_cont">
                <? getClassSelector() ?>
              </td>
            </tr>
            <tr>
              <td class="btn_td" colspan="2"><button onclick="sendDummy()" class="btn send">전송</button></td>
            </tr>
          </table>

        </div>
      </div>

    </div>
  </div>

  <script>
  $(function() {
      $("#DatePicker").datepicker({
        dateFormat: 'yy-mm-dd' //Input Display Format 변경
        ,showOtherMonths: true //빈 공간에 현재월의 앞뒤월의 날짜를 표시
        ,showMonthAfterYear:true //년도 먼저 나오고, 뒤에 월 표시
        ,changeYear: true //콤보박스에서 년 선택 가능
        ,changeMonth: true //콤보박스에서 월 선택 가능
        ,showOn: "both" //button:버튼을 표시하고,버튼을 눌러야만 달력 표시 ^ both:버튼을 표시하고,버튼을 누르거나 input을 클릭하면 달력 표시
        ,buttonImage: "http://jqueryui.com/resources/demos/datepicker/images/calendar.gif" //버튼 이미지 경로
        ,buttonImageOnly: true //기본 버튼의 회색 부분을 없애고, 이미지만 보이게 함
        ,buttonText: "선택" //버튼에 마우스 갖다 댔을 때 표시되는 텍스트
        ,yearSuffix: "년" //달력의 년도 부분 뒤에 붙는 텍스트
        ,monthNamesShort: ['1','2','3','4','5','6','7','8','9','10','11','12'] //달력의 월 부분 텍스트
        ,monthNames: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'] //달력의 월 부분 Tooltip 텍스트
        ,dayNamesMin: ['일','월','화','수','목','금','토'] //달력의 요일 부분 텍스트
        ,dayNames: ['일요일','월요일','화요일','수요일','목요일','금요일','토요일'] //달력의 요일 부분 Tooltip 텍스트
        ,minDate: "-3M" //최소 선택일자(-1D:하루전, -1M:한달전, -1Y:일년전)
        ,maxDate: "+0D" //최대 선택일자(+1D:하루후, -1M:한달후, -1Y:일년후)
      });
       $('#DatePicker').datepicker('setDate', 'today'); //(-1D:하루전, -1M:한달전, -1Y:일년전), (+1D:하루후, -1M:한달후, -1Y:일년후)
  });
  </script>

<? include_once("./dbad_tail.php");  ?>
