<?php
session_start();

$user = "kyujo220_4504";  // ユーザー名
$password = "Sasuke1611";  // ユーザー名のパスワード

// ログイン状態チェック
if (isset($_SESSION["NAME"])) {
  if($_SESSION["Lev"]==1){//2は生徒
    header("Location: kanri.php");
    exit;
  }elseif($_SESSION["Lev"]==2){
    header("Location: Zemisei.php");
    exit;
  }
}
header("Location: logout.php");
exit;
?>



<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>メイン</title>
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
        <h1>メイン画面</h1>
        <!-- ユーザーIDにHTMLタグが含まれても良いようにエスケープする -->
        <p>ようこそ<u><?php echo htmlspecialchars($_SESSION["NAME"], ENT_QUOTES); ?></u>さん</p>  <!-- ユーザー名をechoで表示 -->
        <ul>
            <li><a href="logout.php">ログアウト</a></li>
        </ul>
    </body>
</html>
