<?php
//① GET から郵便番号を受け取る
$zipcode = filter_input(INPUT_GET, "zipcode");

//② API URL を作る
$url = "https://zipcloud.ibsnet.co.jp/api/search?zipcode=" . $zipcode;

//④ json_decode() で配列にする
$json = file_get_contents($url);

//⑤ results があるか確認
$response = json_decode($json, true);

echo "<pre>";
print_r($response);
echo "</pre>";

$address = "";
$message = "";
//⑥ address1 + address2 + address3⑦ なければ message を表示
if ($response["results"]) {
    $address1 = $response["results"][0]["address1"];
    $address2 = $response["results"][0]["address2"];
    $address3 = $response["results"][0]["address3"];

    $address = $address1 . $address2 . $address3;

} else {

    if ($response["message"]) {
        $message = $response["message"];
    } else {
        $message = "該当する住所がありません！";
    }
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>郵便番号検索</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;

            font-family:
                "Noto Sans JP",
                "Yu Gothic",
                sans-serif;

            background:
                radial-gradient(circle at 20% 20%, #dff6ff 0, transparent 30%),
                radial-gradient(circle at 80% 80%, #e8ddff 0, transparent 30%),
                #f5f7fb;

            display: flex;
            justify-content: center;
            align-items: center;

            color: #222;

            overflow: hidden;
        }


        /* 背景の動く線 */

        body::before,
        body::after {
            content: "";

            position: fixed;

            width: 500px;
            height: 500px;

            border: 1px solid rgba(0, 120, 255, 0.15);

            transform: rotate(45deg);

            animation: rotateLine 15s linear infinite;

            pointer-events: none;
        }

        body::before {
            top: -300px;
            left: -200px;
        }

        body::after {
            bottom: -300px;
            right: -200px;

            animation-direction: reverse;
        }


        @keyframes rotateLine {

            0% {
                transform: rotate(45deg);
            }

            100% {
                transform: rotate(405deg);
            }

        }


        /* メイン */

        .container {

            width: min(650px, 90%);

            position: relative;

            padding: 50px 55px;

            background: rgba(255, 255, 255, 0.75);

            backdrop-filter: blur(12px);

            border-left: 5px solid #1677ff;

            box-shadow:
                20px 20px 0 rgba(22, 119, 255, 0.08),
                0 20px 60px rgba(0, 0, 0, 0.08);

            animation: appear 0.8s ease forwards;
        }


        @keyframes appear {

            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }

        }


        /* タイトル */

        h1 {

            margin: 0 0 8px;

            font-size: 36px;

            letter-spacing: 4px;

            font-weight: 800;

            position: relative;

            display: inline-block;
        }


        h1::after {

            content: "";

            position: absolute;

            width: 45px;
            height: 4px;

            background: #1677ff;

            left: 3px;
            bottom: -10px;

            animation: titleLine 2s ease-in-out infinite alternate;
        }


        @keyframes titleLine {

            from {
                width: 35px;
            }

            to {
                width: 100px;
            }

        }


        .subtitle {

            margin-top: 25px;
            margin-bottom: 35px;

            color: #777;

            font-size: 14px;

            letter-spacing: 1px;
        }


        /* フォーム */

        form {

            display: flex;

            align-items: center;

            gap: 12px;

            margin-bottom: 30px;
        }


        #zipcode {

            width: 100%;

            padding: 16px 18px;

            border: none;

            border-bottom: 2px solid #ccc;

            background: transparent;

            font-size: 18px;

            outline: none;

            transition: 0.3s;
        }


        #zipcode:focus {

            border-bottom-color: #1677ff;

            padding-left: 25px;

        }


        #zipcode::placeholder {

            color: #aaa;

        }


        /* 検索ボタン */

        button {

            position: relative;

            overflow: hidden;

            border: none;

            background: #1677ff;

            color: white;

            padding: 15px 28px;

            font-size: 15px;

            font-weight: bold;

            cursor: pointer;

            white-space: nowrap;

            transition: 0.3s;
        }


        button::before {

            content: "";

            position: absolute;

            top: 0;
            left: -100%;

            width: 100%;
            height: 100%;

            background: rgba(255, 255, 255, 0.25);

            transform: skewX(-20deg);

            transition: 0.5s;

        }


        button:hover::before {

            left: 100%;

        }


        button:hover {

            transform: translateY(-3px);

            box-shadow: 0 8px 20px rgba(22, 119, 255, 0.3);

        }


        button:active {

            transform: translateY(0);

        }


        /* 住所 */

        .result {

            position: relative;

            margin-top: 25px;

            padding: 25px 0;

            border-top: 1px solid #ddd;

            animation: resultAppear 0.6s ease;
        }


        @keyframes resultAppear {

            from {

                opacity: 0;
                transform: translateX(-20px);

            }

            to {

                opacity: 1;
                transform: translateX(0);

            }

        }


        .result-title {

            font-size: 13px;

            color: #1677ff;

            font-weight: bold;

            letter-spacing: 2px;

            margin-bottom: 10px;
        }


        .address {

            font-size: 22px;

            font-weight: bold;

            line-height: 1.7;

            word-break: break-all;

        }


        .error {

            color: #e53935;

            font-weight: bold;

        }


        /* 小さい文字 */

        .hint {

            margin-top: 25px;

            font-size: 12px;

            color: #999;

            letter-spacing: 0.5px;
        }


        /* スマホ */

        @media (max-width: 600px) {

            .container {

                padding: 35px 25px;

            }

            h1 {

                font-size: 28px;

            }

            form {

                flex-direction: column;

                align-items: stretch;

            }

            button {

                width: 100%;

            }

            .address {

                font-size: 18px;

            }

        }

    </style>

</head>


<body>

    <main class="container">

        <h1>郵便番号検索</h1>

        <p class="subtitle">
            POSTAL CODE → ADDRESS
        </p>


        <form action="" method="GET">

            <input
                type="text"
                name="zipcode"
                id="zipcode"
                placeholder="例：5300001"
                maxlength="7"
            >

            <button type="submit">
                検索
            </button>

        </form>


        <div class="result">

            <div class="result-title">
                ADDRESS
            </div>

            <div class="address">

                <?php

                if ($zipcode == "" || $address) {
                    echo  $address ;
                } else {
                    echo $message;
                }

                ?>

            </div>

        </div>


        <div class="hint">
            7桁の郵便番号を入力してください
        </div>

    </main>

</body>

</html>