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
    <div id="signup"class=big-bg>
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
       <h2>今日から君もミッションに参加せよ</h2>
        <div class="content">
            <img class="gazou" src="../images/todo10.png" alt="MyTODOログイン画面"><br>
            
            <div class="login-content">
                <img class="logo2" src="../images/24684351.png" alt="MyTODOログイン画面"><br>
                    <h1>ミッション登録</h1>
                        <form action="newLogin.php" method="post">
                            <div class="form-group">
                                <label>ユーザーID:
                                <input type="text" name = "userId" required>
                                </label>
                                <label>メールアドレス:
                                    <input type="text"  name="mail" required><br>
                                </label>
                                <label>パスワード:
                                    <input type="password" name="pass" required><br>
                                </label>
                            </div>
                                <input type="submit" value="ログイン">
                        </form> 
            </div><!-- ./login-content-->
        </div>

<!------------------------------------------------------------------------------------------------------>
        <footer>
            <div class="footer">
                <p><small>&copy; 2024 sakai</small></p>
            </div>
        </footer>
    </div><!-- ./背景-->
</body>
</html>