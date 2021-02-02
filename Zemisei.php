<?php
require 'password.php';   // password_hash()はphp 5.5.0以降の関数のため、バージョンが古くて使えない場合に使用
// セッション開始
session_start();
// ログイン状態チェック
if (!isset($_SESSION["NAME"])) {
    header("Location: logout.php");
    exit;
}
// タイムゾーン設定
date_default_timezone_set('Asia/Tokyo');

//変数の初期化
$now_date=null;



$db['user'] = "kyujo220_4504";  // ユーザー名
$db['pass'] = "Sasuke1611";  // ユーザー名のパスワード

$dsn = 'mysql:host=mysql1.php.xdomain.ne.jp;dbname=kyujo220_testes;charset=utf8';

// エラーメッセージ、登録完了メッセージの初期化
$errorMessage = "";
$signUpMessage = "";

//エラーがない場合は「0」を、ある場合は「1」を代入し結果を表示する際のフラグとする
$error = 0;

// ログインボタンが押された場合
if (isset($_POST["comUp"])) {
    // 1. ユーザIDの入力チェック
    if (empty($_POST["message"])) {
        $errorMessage = 'コメントが未入力です。';
    }
    //テーマ
    //$_POST['comment']がすでに定義されている（値が送信されている）場合
    if(isset($_POST['message'])) {
      //エスケープ処理
      $tex1 = htmlspecialchars($_POST['theme'], ENT_QUOTES, 'UTF-8');
      //改行タグの挿入
      $texta1 = nl2br($tex1);
    }else{  //$_POST['comment']が未定義の場合
      $tex1 = "この文字列が初期値として表示されます。";
      $texta1 = "";
    }
    if ( !empty($_POST["message"])  && $error == 0) {
        // 入力した卒業年、学科、ゼミ名、学籍番号、名前、テーマ、キーワード、概要、ファイルを登録
        $view_name = $_SESSION["NAME"];
        $message=$_POST["message"];



				// 書き込み日時を取得
				$now_date = date("Y-m-d H:i:s");
				/*//テキストで保存
				$data = "'".$_POST['view_name']."','".$_POST['message']."','".$now_date."'\n";
				// ファイルへのパス
				$file=fopen("Com/message.txt","a+b");
				@fwite($file,$data);//追記する

				fclose($file);*/

				// 2. ユーザIDとパスワードが入力されていたら認証する
        //$dsn = sprintf('mysql: host=%s; dbname=%s; charset=utf8', $db['host'], $db['dbname']);


        // 3. エラー処理
        try {
            $pdo = new PDO($dsn, $db['user'], $db['pass'], array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
            $stmt = $pdo->prepare("INSERT INTO message(view_name, message, post_date) VALUES (:view_name,:message,:post_date)");
						$stmt->execute(array(':view_name'=>$view_name,':message'=>$message,':post_date'=>$now_date));

						$id = $pdo->lastinsertid();  // 登録した(DB側でauto_incrementした)IDを$idに入れる

						//$row = $stmt->fetch(PDO::FETCH_ASSOC);

						//$sql = "SELECT * FROM message"; //WHERE id = $id";  //入力したIDからユーザー名を取得
						//$stmt = $pdo->query($sql);

						//データベース接続切断
						$dbh = null;
            $signUpMessage = '登録が完了しました。';  // ログイン時に使用するIDとパスワード
        } catch (PDOException $e) {
            $errorMessage = 'データベースエラー';
            // $e->getMessage() でエラー内容を参照可能（デバッグ時のみ表示）
             echo $e->getMessage();
        }
    }/* else if($_POST["password"] != $_POST["password2"]) {
        $errorMessage = 'パスワードに誤りがあります。';
    }*/
}
$pdo = new PDO($dsn, $db['user'], $db['pass'], array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));

$stmt = $pdo->prepare("SELECT * FROM message");
if($stmt->execute()){
//レコード件数取得
	$row_count = $stmt->rowCount();

  while($row = $stmt->fetch()){
		$rows[] = $row;
	}
}

$pd = new PDO($dsn, $db['user'], $db['pass'], array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
$stmt2 = $pd->prepare("SELECT * FROM userData");
if($stmt2->execute()){
//レコード件数取得
	$row_count2 = $stmt2->rowCount();

  while($row2 = $stmt2->fetch()){
		$rows2[] = $row2;
	}
}
?>

<!doctype html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>卒研テストページ(荒平ゼミ生用)</title>
  <style>
  .sample3_btn {
    display: inline-block;
    padding: 10px 20px 10px 20px;
    text-decoration: none;
    color: white;
    background: royalblue;
    font-weight: bold;
    border: solid 4px midnightblue;
    border-radius: 8px;
  }
  .sample3_btn:hover {
    background: white;
    color: midnightblue;
  }
  .sample2_btn {
    display: inline-block;
    padding: 10px 20px 10px 20px;
    text-decoration: none;
    color: white;
    background: hotpink;
    font-weight: bold;
    border: solid 4px deeppink;
    border-radius: 8px;
  }
 .sample2_btn:hover {
    background: white;
    color: deeppink;
  }
  .wrapper {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr 1fr;
    grid-template-rows: 1fr 1fr;
    grid-gap: 0;
  }
  .operation{
    grid-column: 1 / 4;
    grid-row: 1;
  }
  .group{
    grid-column: 4;
    grid-row: 1/2;
  }
  .comment{
    grid-column: 1 / 4;
    grid-row: 2;
  }
  #wrapper {
    height: 100px;
    width: 400px;
    overflow-y: scroll;
  }
  #wrapper2{
    height: 250px;
    width: 1000px;
    overflow-y: scroll;
  }
  #contents {
    background-color: cadetblue;
  }
</style>
</head>
<body>
  <div class="wrapper">
    <div class="operation">
      <form action="logout.php">
        <input type="submit" value="ログアウト">
      </form>
      <?php
      if($_SESSION["Lev"]==="1") {
        ?>
      <form action="kanri.php">
        <input type="submit" value="管理画面へ戻る">
      </form>
      <?php
    }
    ?>
      <h1>卒研テストページ（荒平ゼミ生用）</h1>
      <p>ようこそ<b><u style="background-color:Yellow"><?php echo htmlspecialchars($_SESSION["NAME"], ENT_QUOTES); ?></u></b>さん</p>  <!-- ユーザー名をechoで表示 -->
      <p>このページは、荒平ゼミ生専用ページです。
          雑なつくりをしているため、安全性は一切の保障をいたしません。
          故に、使用後はデータの削除を推奨しております。
        どうしてもデータを残したい場合は自己責任でお願いいたします。　ながの</p>

        <p><a href="chart_main.html" class="sample3_btn">▼表・図作成</a>   <a href="pdo_search_form.php" class="sample2_btn">▼卒論検索</a></p>
      </div>
      <div class="group">
        <fieldset>
        <legend><h2>卒研グループ</h2></legend>
        <?php if (count($errors) === 0): ?>
        <div id="wrapper">
          <?php
          foreach($rows2 as $row2){if(!empty($row2['group'])){
            ?>
            <li><a href="signUp.php"><?=htmlspecialchars($row2['group'],ENT_QUOTES,'UTF-8')?></a></li>
            <?php
          }
          }
          ?>
        </div>
      <?php endif; ?>
    </fieldset>
    </div>
    <div class="comment">
        <fieldset>
        <legend><h2>投稿一覧</h2></legend>
        <?php if (count($errors) === 0): ?>
          <div id="wrapper2">
            <?php
            foreach($rows as $row){
              ?>
              <p><?=$row['id']?>:<font color="Blue"><?=htmlspecialchars($row['view_name'],ENT_QUOTES,'UTF-8')?></font>    :<?=$row['post_date']?></p>
              <p><?=$row['message']?></p>
              <hr>
              <?php
            }
            ?>
            <form id="comment" name="comment" action="" method="POST"enctype="multipart/form-data">
              <fieldset>
                <legend>コメント投稿フォーム</legend>
                <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font></div>
                <div><font color="#0000ff"><?php echo htmlspecialchars($signUpMessage, ENT_QUOTES); ?></font></div>
                <br>
                <!--コメント-->
                <textarea name="message" rows="3" cols="50"><?= $textarea ?></textarea>
                <br>
                <input type="submit" id="comUp" name="comUp" value="投稿">
              </fieldset>
              <br>
            </form>
          </div>
        <?php elseif(count($errors) > 0): ?>
          <?php
          foreach($errors as $value){
            echo "<p>".$value."</p>";
          }
          ?>
        <?php endif; ?>
      </fieldset>
    </div>
  </div>
</body>
</html>
