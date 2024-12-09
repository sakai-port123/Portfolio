<?php
date_default_timezone_set('Asia/Tokyo');
$date = new DateTime('now');
$count = 1;
$count1 = 0;
//セッション開始
session_start();
$userId = $_SESSION['userId'];
$selectid = $_SESSION['id'];
if(isset($_SESSION['id'])){//ログイン中
    $msg = 'エージェント' . htmlspecialchars($userId, \ENT_QUOTES, 'UTF-8') . '';
    $link = '<a href="logout.php">ログアウト<a/>';
} else{//ログインしていない
    $msg = '新人君。まずはログインしよう';
    $link = '<a href="index.php">ログイン</a>';
}
?><!--------------------------------------------------------------------------------------------------------------------------->
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>TodoTop</title>
        <meta name="description" content="自分だけのMyTODOリストを作ろう">
        <!-- css -->                
        <link rel="stylesheet" href="https://unpkg.com/modern-css-reset/dist/reset.min.css">
        <link href="https://fonts.googleapis.com/css?family=Philosopher" rel="stylesheet">
        <link href="../CSS/tes.css" rel="stylesheet" >
        <!--レスポンシブ-->
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
        <!-- JavaScriptファイル読み込み-->
        <script src="../JS/todo.js" defer></script>
    </head>
<body>
<!--背景画像-->
<main id="todo">
        <!-- ページ上部のヘッダー-->
            <header class="page-header ">
                <h1><a href="complete.php"><img class="logo" src="../images/todo9.png" alt="MyTODOログイン画面"></a></h1>
                <div class="username">ようこそ<br>
                    <?=$msg?></div>
                    <nav>
                        <ul class="main-nav">
                            <div class="nav-top">
                                <li><a href="todo.php">Top</a></li></span>
                            </div>
                            <div class="nav-log">
                                 <li><a href="logout.php">LogOut</a></li>
                            </div>
                            <div class="nav-cont">
                                <li><a href="">Contact</a></li>
                            </div>
                        </ul>
                    </nav>
            </header> 
    <div class = "contact">        
        <h1>MissionTodo お問い合わせ</h1>
        <form action="complete.php" method="post">
            <table class="contact-table">
                <tr>
                    <th class="contact-item">ユーザーID</th>
                    <td class="contact-body">
                        <input type="text" name="name" placeholder="例)test" required class="form-text" />
                    </td>
                    </tr>
                    <tr>
                    <th class="contact-item">性別</th>
                    <td class="contact-body">
                        <label class="contact-sex">
                        <input type="radio" name="sex" />
                        <span class="contact-sex-txt">男</span>
                        </label>
                        <label class="contact-sex">
                        <input type="radio" name="性別" />
                        <span class="contact-sex-txt">女</span>
                        </label>
                    </td>
                    </tr>
                    <tr>
                    <th class="contact-item">メール</th>
                    <td class="contact-body">
                        <input type="email" name="mail" placeholder="例)test@com" required  class="form-text" />
                    </td>
                    </tr>
                    
                    <tr>
                    <th class="contact-item">職業</th>
                    <td class="contact-body">
                        <select name="work" class="form-select">
                        <option>選択</option>
                        <option>学生</option>
                        <option>主婦</option>
                        <option>会社員</option>
                        </select>
                    </td>
                    </tr>
                    <tr>
                    <th class="contact-item">利用した感想</th>
                    <td class="contact-body">
                        <label class="contact-skill">
                        <input type="checkbox" name="thoughts" />
                        <span class="contact-skill-txt">非常にいい</span>
                        </label>
                        <label class="contact-skill">
                        <input type="checkbox" name="thoughts" />
                        <span class="contact-skill-txt">良い</span>
                        </label>
                        <label class="contact-skill">
                        <input type="checkbox" name="thoughts" />
                        <span class="contact-skill-txt">普通</span>
                        </label>
                        <label class="contact-skill">
                        <input type="checkbox" name="thoughts" />
                        <span class="contact-skill-txt">よくない</span>
                        </label>
                    </td>
                    </tr>
                    <tr>
                    <th class="contact-item">お問い合わせ内容</th>
                    <td class="contact-body">
                        <textarea name="contact_body" placeholder="お問い合わせ内容を入力してください。" required  cols="80" rows="7" maxlength="320" required class="form-textarea"></textarea>
                    </td>
                </tr>
            </table>
            <input class="contact-submit" type="submit" value="送信" />
        </form>
    </div><!--./contact-->
    <footer>
        <div class="footer2">
            <p><small>&copy; 2024 sakai</small></p>
        </div>
    </footer>
</main>
<!--scrptに変数渡し-->
<script> const No1time ="<?= $no1['day']?>"</script>
</body>
</html>