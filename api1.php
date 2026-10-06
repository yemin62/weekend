<?php

//① GET から郵便番号を受け取る
$zipcode = filter_input(INPUT_GET, "zipcode");

//② API URL を作る
$url = "https://zipcloud.ibsnet.co.jp/api/search?zipcode=" . $zipcode;

//④ json_decode() で配列にする
$json = file_get_contents($url);

//⑤ results があるか確認
$response = json_decode($json, true);

$address = "";
$message = "";
//⑥ address1 + address2 + address3⑦ なければ message を表示

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