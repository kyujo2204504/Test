<?php
session_start();

// ログイン状態チェック
if (!isset($_SESSION["NAME"])) {
    header("Location: logout.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title>卒研テストページ（管理者用）</title>
    <script type="text/javascript">
<!--
    window.onload = function() {
        document.body.oncontextmenu = function () {
            return false;
        }
    }
// -->
</script>
  </head>
  <body>
    <h1>卒研テストページ【管理者用】</h1>
    <p>ようこそ<u><?php echo htmlspecialchars($_SESSION["NAME"], ENT_QUOTES); ?></u>さん</p>  <!-- ユーザー名をechoで表示 -->
    <p>管理者専用ページです。　ながの</p>
    <a href="Zemisei.php">ゼミ生ページ</a>
    <p>ユーザ管理▸▸<!-- ボタンにするスタイルシート ここから -->
<style>
.sample3_btn {
    display: inline-block;
    padding: 10px 20px 10px 20px;
    text-decoration: none;
    color: white;
    background: Orange;
    font-weight: bold;
    border: solid 4px orange;
    border-radius: 8px;
}

.sample3_btn:hover {
    background: white;
    color: orange;
}
</style>
<!-- ボタンにするスタイルシート ここまで -->
<th><a href="signup.php" class="sample3_btn">追加</a></th><th><a href="user_tou.php" class="sample3_btn">削除</a></th><a href="user_tou.php" class="sample3_btn">パスワード変更</a></p>
    <p>卒研管理▸▸▸<!-- ボタンにするスタイルシート ここから -->
<style>
.sample2_btn {
    display: inline-block;
    padding: 10px 20px 10px 20px;
    text-decoration: none;
    color: white;
    background: Green;
    font-weight: bold;
    border: solid 4px Green;
    border-radius: 8px;
}

.sample2_btn:hover {
    background: white;
    color: green;
}
</style>
<!-- ボタンにするスタイルシート ここまで -->

<a href="sotuken_tuika.php" class="sample2_btn">追加</a><a href="sotuken_tuika.html" class="sample2_btn">削除</a></p>

<ul>
    <li><a href="logout.php">ログアウト</a></li>
</ul>
</body>

</html>
