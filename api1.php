<?php

$zipcode = filter_input(INPUT_GET,"zipcode");

$url = "https://zipcloud.ibsnet.co.jp/api/search?zipcode=". $zipcode;

$json = file_get_contents($url);

$response = json_decode($json, true);

$address = "";
$message = "";

if($response["results"]){
  $address1 = $response["results"][0]["address1"];
  $address2 = $response["results"][0]["address2"];
  $address3 = $response["results"][0]["address3"];

  $address = $address1.$address2.$address3;


}else{
    if($response["message"]){
        $message = $response["message"];
    }else{
        $message = "該当する住所はありません！";
    }
}


?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>郵便番号検索</title>
</head>
<body>
    <h1>郵便番号検索</h1>
    <form action="" method="GET">
     <labe for="zipcode">郵便番号入力：</label>
     <input type="text" name="zipcode" id="zipcode">
     <p>住所： <?php 
                if($zipcode == "" || $address){
                    echo $address;
                }else{
                    echo $message;
                }
                ?></p>
     <button type="submit">検索</button>
    </form>
</body>
</html>