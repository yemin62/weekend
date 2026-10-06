<?php

$host = "localhost";
$dbname = "php_test";
$user = "root";
$password = "root";


try{$pdo = new PDO(
    "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
    $user,$password
);

echo "データベース接続成功！";
}catch(PDOException $e){
    echo "接続失敗:" .$e->getMessage();
}

?>