<?php
require_once "db.php";

$sql = "SELECT * FROM users";

$stmt = $pdo->query($sql);

$users = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザー一覧</title>

</head>
<body>
    <h1>ユーザー一覧</h1><!--autocommit しないとデータは表示しないときもある show variables like 'autocommit';-->
    <?php foreach($users as $user):?>
        <p>
            ID:<?= $user["id"] ?><br>
            名前:<?= $user["name"] ?><br>
            Email:<?= $user["email"] ?>
        </p>
        <?php endforeach; ?>
</body>
</html>