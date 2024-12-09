<?php
//削除ページ
$user = 'root';
$pass = 'root';
if(empty($_GET['id'])){
    echo 'IDを入力してください';
    exit;
}
try{
    $id = (int)$_GET['id'];
    $dbh = new PDO('mysql:host=localhost;dbname=phptodo;charset=utf8',$user,$pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'DELETE FROM todos WHERE id = ?';
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, $id,PDO::PARAM_INT);
    $stmt->execute();
    $dbh = null;
    echo '削除が完了しました<br>';
 } catch(PDOException $e){
    echo'エラー発生:' . htmlspecialchars($e->getMessage(), ENT_QUOTES) . '<br>';
    exit;
 }
 echo "<a href = todo.php>戻る</a>";
?>