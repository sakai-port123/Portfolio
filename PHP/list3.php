<?php
$count = 0;
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
<html lang="list">
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
                                <li><a href="">Contact</a></li>
                            </div>
                        </ul>
                    </nav>
            </header> 
        
<!--------------------------------------------------------------------------------------------------------------------------->
<?php
    $user = 'root';
    $pass = 'root';
    try{
        $dbh = new PDO('mysql:host=localhost;dbname=phptodo;charset=utf8',$user, $pass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //selectIdで取得範囲を選択し、dayの新しい順に取得and未完了フラグが立っていないやつのみ取得
        $sql = 'SELECT COUNT(*) AS count FROM todos WHERE selectid = :selectid AND is_nodeleted = true AND is_deleted = false ORDER BY day ASC';
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':selectid', $selectid, PDO::PARAM_INT);
        //実行結果をresultに代入
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?><!------------------------------------------------------------------------------------------------------------------------->
            <!--リスト表示の並べ替え--> 
            <div class="list-todo" >
                <form id="form">
                    <select name="select" id="list">
                        <option value="list.php">日付順(新)</option>
                        <option value="list2.php">日付順(古)</option>
                        <option value="list3.php">未達成のみ</option>
                        <option value="list4.php">達成のみ</option>
                    </select>
                </form>
                <table border=1 class="todo-list" id=select1>
                    <tr>
                        <th>順位</th> <th>任務開始　日時</th> <th>ミッション内容</th> <th>任務終了　日時</th><th>完全に削除する</th>
                    </tr>
                <!--TODO一覧繰り返し表示-->
                <?php foreach ($result as $row) {?>
                    <tr>
                        <td><?= $count+=1 ?></td>
                        <td><?= htmlspecialchars($row['created_date'], ENT_QUOTES) ?></td> 
                        <td><?= htmlspecialchars($row['detail'], ENT_QUOTES)?></td>
                        <td><?= htmlspecialchars($row['day'], ENT_QUOTES)?></td>                   
                        <td><a href="deleteList.php?id=<?= htmlspecialchars($row['id'], ENT_QUOTES) ?>"> 
                        <label><input  type="button" value="削除" onclick="return Check()"></label></a></td>
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
             <div class="top"><a href="#">トップに戻る</a></div>
            </div><!--./list-todo-->
</main>
<!--scrptに変数渡し-->
<script> const No1time ="<?= $no1['day']?>"</script>
</body>
</html>