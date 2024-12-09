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
                <h1><a href="index.php"><img class="logo" src="../images/todo9.png" alt="MyTODOログイン画面"></a></h1>
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
                                <li><a href="contact.php">Contact</a></li>
                            </div>
                        </ul>
                    </nav>
            </header> 
        
    <div class="upper">
        <h2>Mission</h2>
        <div class="Regist">
                    <h1>ミッションを登録する</h1>
                    <form action="add.php" method="POST" novalidate>
                    <span class="regiIn">完了日時を指定</span><br>
                    <input type="datetime-local"  name="day" value="<?= $date->Format('Y-m-d H:i:s')?>" ><br>
                    <label class="regiIn">ミッション内容を入力<br>
                    </label><textarea name="detail" cols="50" rows="10" maxlength="320" required></textarea><br>
                    <input class="nextRegi" type="submit" value="登録" onclick="return Check()" ><!--onclick　scriptで実行するかポップアップさせる-->
                    </form>
        </div><!--regist-->
        <div class="gale">
            <img  src="../images/1081585.png">
        </div>
    </div><!--./upper-->   
<!--------------------------------------------------------------------------------------------------------------------------->
<?php
    $user = 'root';
    $pass = 'root';
    try{
        $dbh = new PDO('mysql:host=localhost;dbname=phptodo;charset=utf8',$user, $pass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //selectIdで取得範囲を選択し、dayの新しい順に取得and未完了フラグが立っていないやつのみ取得
        $sql = 'SELECT * FROM `todos` WHERE selectid = :selectid AND is_nodeleted = false AND is_deleted = false ORDER BY day ASC';
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':selectid', $selectid, PDO::PARAM_INT);
        //実行結果をresultに代入
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?><!------------------------------------------------------------------------------------------------------------------------->
    <section>      
    <!--result配列の最初の要素だけ変数に代入-->
        <?php $no1 = reset($result);?>
    <!--$no1のnull判定-->
        <?php if(empty($no1)){?>
            <span class="count-null">ミッションを登録してください</span>
        <?php }else{?>
        <!--タイムリミットが１番近いのだけ上部に別で表示-->
        <div class="tama"><img src="../images/23631687.png"></div>
        <div class="warning"><img src="../images/1104708.png" art="warning"></div>
        
        <span class="timetop">最初のミッション終了まで残り</span>
        
        <div id="countdown"></div><!--トップのscriptカウントダウン-->
        <article>
                <table border=1 class="no1todo">
                    <tr>
                        <th>優先順位</th> <th>任務開始　日時</th> <th>ミッション内容</th> <th>任務終了　日時</th> <!--<th>遂行失敗まで残り</th>--> <th>ミッション完了</th> <th>編集</th> 
                    </tr>
                    <tr>
                        <td class="icon"> 1 </td>
                        <td><?= htmlspecialchars($no1['created_date'], ENT_QUOTES) ?></td> 
                        <td><?= htmlspecialchars($no1['detail'], ENT_QUOTES)?></td>
                        <td><?= htmlspecialchars($no1['day'], ENT_QUOTES)?></td>                   
                        <td><a href="is_deleted.php?id=<?= htmlspecialchars($no1['id'], ENT_QUOTES) ?>"> 
                        <label><input  type="button" value="完了" onclick="return Check()"></label></a></td>
                        <td><a href="edit1.php?id=<?= htmlspecialchars($no1['id'], ENT_QUOTES)?>"> 
                        <label><input type="button" value="編集"></label></a></td>
                    </tr>
                </table>
            <div class="causion"><img src="../images/25683653.png" art=""causion></div>
            </article>
        <?php } ?>
    <!--ミッション2番目以降の表示↓----------------------------------------------------------------------------------------->    
            <div class="subtodo">    
            <span class="no2todo">others Mission</span>
            <span class="no2todo2">その他のミッション(優先順位２位以降)</span>
            <span class="nottodo">未達成ミッション</span>
            <span class="nottodo2">もう１度チャレンジする場合は再チャレンジを押してください。</span>
           
            <?php 
            //ページに表示する数を定数で宣言
            define('max_view',6);
            $count_sql = 'SELECT COUNT(*) AS count FROM todos WHERE selectid = :selectid AND is_nodeleted = false AND is_deleted = false';
            $count_stmt = $dbh->prepare($count_sql);
            $count_stmt->bindValue(':selectid', $selectid, PDO::PARAM_INT);
            $count_stmt->execute();
            $total_count = $count_stmt->fetch(PDO::FETCH_ASSOC);
            $pages = ceil($total_count['count'] / max_view);
            //現在いるページの番号を取得
            if(!isset($_GET['page_id'])){
                $now = 1;
            }else{
                $now = $_GET['page_id'];
            }
            //表示する記事を取得するSQL
            $page_sql = 'SELECT * FROM `todos` WHERE selectid = :selectid AND is_nodeleted = false AND is_deleted = false ORDER BY day ASC  LIMIT :start,:max ';
            $page_stmt = $dbh->prepare($page_sql);
            if($now == 1){
                $page_stmt->bindValue(':selectid', $selectid, PDO::PARAM_INT);
                $page_stmt->bindValue(":start", $now -1,PDO::PARAM_INT);
                $page_stmt->bindValue(":max",max_view,PDO::PARAM_INT);
            }else{
                $page_stmt->bindValue(':selectid', $selectid, PDO::PARAM_INT);
                $page_stmt->bindValue(":start", ($now -1) * max_view,PDO::PARAM_INT);
                $page_stmt->bindValue(":max",max_view,PDO::PARAM_INT);
            }
            //実行結果
            $page_stmt->execute();
            $page_data = $page_stmt->fetchAll(PDO::FETCH_ASSOC);
            //先頭要素だけ削除
            unset($page_data[0]); ?>
                <table border=1 class="no2todo">
                    <tr>
                        <th>順位</th> <th>任務開始　日時</th> <th>ミッション内容</th> <th>任務終了　日時</th><th>遂行失敗まで残り</th> <th>ミッション完了</th> <th>編集</th> 
                    </tr>
                <!--TODO一覧繰り返し表示-->
                <?php foreach ($page_data as $row) {?>
                    <tr>
                        <td><?= $count+=1 ?></td>
                        <td><?= htmlspecialchars($row['created_date'], ENT_QUOTES) ?></td> 
                        <td><?= htmlspecialchars($row['detail'], ENT_QUOTES)?></td>
                        <td><?= htmlspecialchars($row['day'], ENT_QUOTES)?></td>                   
                        <td><div class="countdown" data-target-time= "<?= htmlspecialchars($row['day'], ENT_QUOTES)?> ">
                                <span class="zan">残り</span>
                                <span class="countdown-day">0</span>日<br>
                                <span class="countdown-hour">0</span>時間
                                <span class="countdown-min">0</span>分
                                <span class="countdown-sec">0</span>秒
                            </div>
                        </td>
                        <td><a href="is_deleted.php?id=<?= htmlspecialchars($row['id'], ENT_QUOTES) ?>"> 
                        <label><input  type="button" value="完了" onclick="return Check()"></label></a></td>
                        <td><a href="edit1.php?id=<?= htmlspecialchars($row['id'], ENT_QUOTES)?>"> 
                        <label><input type="button" value="編集"></label></a></td>
                    </tr>
                <?php
                }//foreach
                 ?>
                </table>
                <?php
                $dbh = null;
                } catch (PDOException $e){ 
                    echo 'エラー発生' . htmlspecialchars($e->getMessage(), ENT_QUOTES) ;
                    exit;
                }?> 
        
        <!-- ./未達成ミッション↓---------------------------------------------------------------------------------------------------->
        <?php
        $user = 'root';
        $pass = 'root';
        try{
        $dbh = new PDO('mysql:host=localhost;dbname=phptodo;charset=utf8',$user, $pass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        define('max_view2',5);
        //selectIdで取得範囲を選択し、dayの新しい順に取得& 完了フラグが立っていないやつ＆タイムオーバーした(is_nodereted)を取得
            $count2_sql = 'SELECT COUNT(*) AS count FROM todos WHERE selectid = :selectid AND is_nodeleted = true AND is_deleted = false ORDER BY day ASC';
            $count2_stmt = $dbh->prepare($count2_sql);
            $count2_stmt->bindValue(':selectid', $selectid, PDO::PARAM_INT);
            $count2_stmt->execute();
            $total2_count = $count2_stmt->fetch(PDO::FETCH_ASSOC);
            $pages2 = ceil($total2_count['count'] / max_view2);
            //現在いるページの番号を取得
            if(!isset($_GET['page_id2'])){
                $now2 = 1;
            }else{
                $now2 = $_GET['page_id2'];
            }
            //表示する記事を取得するSQL
            $page_sql2 = 'SELECT * FROM `todos` WHERE selectid = :selectid AND is_nodeleted = false AND is_deleted = false ORDER BY day ASC  LIMIT :start,:max ';
            $page_stmt2 = $dbh->prepare($page_sql);
            if($now2 == 1){
                $page_stmt2->bindValue(':selectid', $selectid, PDO::PARAM_INT);
                $page_stmt2->bindValue(":start", $now2 -1,PDO::PARAM_INT);
                $page_stmt2->bindValue(":max",max_view2,PDO::PARAM_INT);
            }else{
                $page_stmt2->bindValue(':selectid', $selectid, PDO::PARAM_INT);
                $page_stmt2->bindValue(":start", ($now2 -1) * max_view2,PDO::PARAM_INT);
                $page_stmt2->bindValue(":max",max_view2,PDO::PARAM_INT);
            }
            //実行結果
            $page_stmt2->execute();
            $page_data2 = $page_stmt2->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <table border=1 class="fail-todo">
                    <tr>
                        <th>NO</th> <th>任務失敗　日時</th> <th>ミッション内容</th> <th>編集してミッション再開</th> 
                    </tr>
                <!--TODO一覧繰り返し表示-->
                <?php foreach ($page_data2 as $row) {?>
                    <tr>
                        <td><?= $count1+=1 ?></td>
                        <td><?= htmlspecialchars($row['day'], ENT_QUOTES) ?></td> 
                        <td><?= htmlspecialchars($row['detail'], ENT_QUOTES)?></td>                 
                        <td><a href="edit1.php?id=<?= htmlspecialchars($row['id'], ENT_QUOTES) ?>"> 
                        <label><input type="button" value="再チャレンジ" onclick="return Check()"></label></a></td>
                    </tr>
                <?php
                }
                echo '</table>' . PHP_EOL;
                $dbh = null;
                } catch (PDOException $e){ 
                    echo 'エラー発生' . htmlspecialchars($e->getMessage(), ENT_QUOTES) ;
                    exit;
                }?> 
        </div><!-- ./subtodo-->
    </section> 
<!---時間切れのリストは論理削除------------------------------------------------------------------------------------------------------------------------>
<?php
        try{
            $dbh = new PDO('mysql:host=localhost;dbname=phptodo;charset=utf8',$user,$pass);
            $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //SQL文　条件式で現在時刻とdayの時刻を比べて、タイムオーバーしていたらフラグをたてる。
            $sql = 'UPDATE todos SET is_nodeleted = TRUE WHERE day < CURRENT_TIME()';
            $stmt = $dbh->prepare($sql);
            $stmt->execute();
            $dbh = null;
        }catch(PDOException $e){
            echo 'エラー発生:' . htmlspecialchars($e->getMessage(), ENT_QUOTES), '<br>';
            exit;
        }      
?>
<!--ページネーションを表示　2位以降リスト---------------------------------------------------------->
    <div class="page">
        <?php
            for($n = 1; $n <= $pages; $n ++){
                if($n == $now){?>
                    <span><?= $now ?></span>
        <?php }else{ ?>
                    <a class="page_a" href='tete.php?page_id=<?= $n ?>'><?= $n ?></a>
        <?php }
            }?>
    </div>
<!--ページネーションを表示　未達成リスト---------------------------------------------------------->
    <div class="page2">
        <?php
            for($n2 = 1; $n2 <= $pages; $n2 ++){
                if($n2 == $now2){?>
                    <span><?= $now2 ?></span>
        <?php }else{ ?>
                    <a class="page_a" href='tete.php?page_id2=<?= $n2 ?>'><?= $n2 ?></a>
        <?php }
            }?>
    </div>
    <div class="list-page">
        <a href="list.php">全ミッション一覧</a>
    </div>
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