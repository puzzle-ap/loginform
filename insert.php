<?php
mb_internal_encoding('utf8');
session_start();

// パスワードのハッシュ化
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

try {
    $pdo = new PDO("mysql:dbname=php_practice;host=localhost;", "root", ""); //DBに接続
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //エラーモードを例外に設定
    $stmt = $pdo->prepare('insert into user (name,mail,age, password, comments) values(?,?,?,?,?)');
    $stmt->execute([$_POST['name'], $_POST['mail'], $_POST['age'], $password, $_POST['comments']]);
} catch (PDOException $e) {
    $e->getMessage(); //例外発生時にエラーメッセージを出力
}

// DB切断
$pdo = null;

// セッション変数をすべて解除する
$_SESSION = [];
if (isset($_COOKIE["session_name()"])) {
    setcookie("session_name()", "", time() - 1800, "/"); //sessionIDの削除
}

session_destroy(); //セッションの破棄
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="フォームを作る">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>フォームを作る</title>
    <link rel="stylesheet" href="style2.css">
</head>

<body>
    <h1>登録完了</h1>
    <div class="confirm">
        <p>登録ありがとうございました。</p>
        <form action="index.php">
            <input type="submit" class="button1" value="TOPに戻る">
        </form>
    </div>
</body>

</html>