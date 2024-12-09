<!--新規登録-->
<?php
//フォームからの値をそれぞれ変数に代入する
$userId = $_POST['userId'];
$mail = $_POST['mail'];
$password = password_hash($_POST['pass'],PASSWORD_DEFAULT);
//DBユーザー
$user = 'root';
$pass = 'root';
try{
    $dbh = new PDO('mysql:host=localhost;dbname=phptodo;charset=utf8',$user, $pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT * FROM users WHERE mail = :mail';
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':mail',$mail);
    $stmt->execute();
    //実行結果をresultに代入
    $result = $stmt->fetch();
    //フォームに入力されたmailがすでに登録されていないかチェック
    if ($result['mail'] === $mail){
        $html = 1;
        $msg = '同じメールアドレスが存在します';
        $link = '<a href="signup.php">登録画面に戻る</a>';
    }else{
        //登録されていなかったらinsret
        $sql = "INSERT INTO users(userId,pass,mail) VALUES (:userId, :pass, :mail )";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue('userId', $userId);
        $stmt->bindValue('pass',$password);
        $stmt->bindValue('mail',$mail);
        $stmt->execute();
        $html = 2;
        $msg ='会員登録が完了しました';
        $link = '<a href="index.php">ログインページへ進む</a>';
    }
    $dbh = null;
}catch(PDOException $e){
    echo 'エラー発生:'. htmlspecialchars($e->getMessage().ENT_QUOTES).'<br>';
    exit;
}
?>
<!--HTML-------------------------------------------------------------------------------->
<!DOCTYPE html>
<html lang="ja">
<head>	
 <meta charset="utf-8">
 <title>TodoLogin</title>
 <meta name="description" content="自分だけのMyTODOリストを作ろう">

 <!-- css -->                
 <link rel="stylesheet" href="https://unpkg.com/modern-css-reset/dist/reset.min.css">
 <link href="https://fonts.googleapis.com/css?family=Philosopher" rel="stylesheet">
 <link href="../CSS/style2.css" rel="stylesheet">
 <!-- JavaScriptファイル読み込み -->
 <script src="../JS/clock.js" defer></script>
</head>
<body>
    <!--背景画像-->
    <div id="newLogin"class=big-bg>
        <!-- ページ上部のヘッダー-->
        <header class="page-header wrapper">
            <h1><a href="index.php"><img class="logo" src="../images/todo9.png" alt="MyTODO新規登録画面"></a></h1>
                <nav>
                    <ul class="main-nav">
                        <li><a href="todo.php">Top</a></li>
                        <li><a href="logout.php">LogOut</a></li>
                        <li><a href="">Contact</a></li>
                    </ul>
                </nav>
        </header> 
<!------------------------------------------------------------------------------------------------------>
<!--PHPで表示の条件分岐-->

<?php if($html == 1) : ?>
<div class="Login">        
            <img class="logo4" src="../images/23384835.png" alt="MyTODOログイン画面"><br>
            <div class="logincontent">
                <img class="logo3" src="../images/2637839.png" alt="MyTODOログイン画面"><br>
                <h1 class="Login1"><?=$msg?></h1><br>
                <h1 class="Login2"><span><?=$link?></span></h1>
            </div><!-- ./logincontent-->
</div>
<?php else : ?>
<div class="Login">        
            <img class="logo4" src="../images/23376258.png" alt="MyTODOログイン画面"><br>
            <div class="logincontent">
                <img class="logo3" src="../images/2637839.png" alt="MyTODOログイン画面"><br>
                <h1 class="Login1"><?=$msg?></h1><br>
                <h1 class="Login2"><span><?=$link?></span></h1>
            </div><!-- ./logincontent-->
    <?php endif;?>
</div>
<!------------------------------------------------------------------------------------------------------>
        <footer>
            <div class="footer">
                <p><small>&copy; 2024 sakai</small></p>
            </div>
        </footer>
    </div><!-- ./newLogin-->
</body>
</html>