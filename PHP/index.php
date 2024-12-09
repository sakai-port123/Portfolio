<!DOCTYPE html>
<html lang="ja">
<head>	
 <meta charset="utf-8">
 <title>TodoLogin</title>
 <meta name="description" content="自分だけのMyTODOリストを作ろう">

 <!-- css -->                
 <link rel="stylesheet" href="https://unpkg.com/modern-css-reset/dist/reset.min.css">
 <link href="https://fonts.googleapis.com/css?family=Philosopher" rel="stylesheet">
 <link href="../CSS/style.css" rel="stylesheet">
 <!-- JavaScriptファイル読み込み -->
 <script src="../JS/clock.js" defer></script>
</head>
<body>
    <!--背景画像-->
    <div id="home"class=big-bg>
    <!-- ページ上部のヘッダー-->
    <header class="page-header wrapper">
        <h1><a href="index.php"><img class="logo" src="../images/todo9.png" alt="MyTODOログイン画面"></a></h1>
            <nav>
                <ul class="main-nav">
                    <li><a href="todo.php">Top</a></li>
                    <li><a href="logout.php">LogOut</a></li>
                    <li><a href="">Contact</a></li>
                </ul>
            </nav>
    </header> 
            <!--タイマー表示-->
        <div id="timer">
            <div class="container">
                <div class="clock">
                    <p class="clock-date"></p>
                    <p class="clock-time"></p>
                </div>
            </div>
        </div><!--./timer-->
    <div class="home-content ">
            <h2 >-carry out the mission-</h2>
            <h2>ミッションを遂行しろ</h2>
            <p>「・・また今度にしよう。」なんて言わせない</p>
            <p>タイムリミットつきTODO</p>
            <P>MyTODOに時間制限をかけて自分を追い込め</P>
    </div><!--./homecontent-->
    <div class="login-content">
            <img class="logo2" src="../images/24684351.png" alt="MyTODOログイン画面"><br>
            <h1>Missionログイン</h1>
                <form action="login.php" method="post">
                <div class="form-group">
                    <label>
                        メールアドレス:<input type="text"  name="mail" required><br>
                    </label>
                </div>
                <div class="form-group">
                    <label>
                        パスワード:<input type="password" name="pass" required><br>
                    </label>
                </div>
                <input type="submit" value="ログイン">
                </form> 
    <h2><a href="signup.php">新規登録はこちら</a></h2>
    </div><!-- ./login-content-->
    <footer>
        <div class="footer">
            <p><small>&copy; 2024 sakai</small></p>
        </div>
    </footer>
    </div><!-- ./home-->
</body>
</html>