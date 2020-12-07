<?php


function setCountryCode(){

  // csv 파일내용대로 DB에 입력
  $fre = @fopen("./ISO_countryCode.csv","r");
  while(!feof($fre)){
    // $ctxt = fgets($fre);
    $ctxt = explode(",",fgets($fre));
    $code = $ctxt[0];
    $tcode = $ctxt[2];
    $name = $ctxt[1];
    $sql = "INSERT INTO w_country SET code={$code}, tcode='{$tcode}', name='{$name}'";

    echo $sql;
    echo "<br>";

    if($code=="HK"){
      echo "홍콩 <br>";
    }
  }
  fclose($fre);

}



 ?>
