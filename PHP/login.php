<?php
//セッションスコープ開始
session_start();
$mail = $_POST['mail'];
$user = 'root';
$pass = 'root';
try{
    $dbh = new PDO('mysql:host=localhost;dbname=phptodo;charset=utf8',$user,$pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM users WHERE mail = :mail";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':mail', $mail);
    $stmt->execute();
    $result = $stmt->fetch();
    //データベース内の情報(ハッシュ)とマッチしているかチェック
    if(password_verify($_POST['pass'],$result['pass'])){
        //DBユーザーをセッションに保存
        $_SESSION['id'] = $result['id'];
        $_SESSION['userId'] = $result['userId'];
        header("Location: todo.php");
        exit;
        // $msg = 'ログインしました！';
        // $link = '<a href="todo.php">TODOを始める</a>';
    }else{
        $msg ='メールアドレスもしくはパスワードがまちがっています。';
        $link = '<a href="index.php">ログイン画面にもどる</a>';
    }
    
    $dbh = null;  
} catch(PDOException $e){
    echo 'エラー発生:' . htmlspecialchars($e->getMessage().ENT_QUOTES) . '<br>';
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

<div class="Login">        
            <img class="logo4" src="../images/23384835.png" alt="MyTODOログイン画面"><br>
            <div class="logincontent">
                <img class="logo3" src="../images/2637839.png" alt="MyTODOログイン画面"><br>
                <h1 class="Login1"><?=$msg?></h1><br>
                <h1 class="Login2"><span><?=$link?></span></h1>
            </div><!-- ./logincontent-->
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