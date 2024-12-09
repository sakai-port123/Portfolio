<?php
//削除(テーブル移動)ページ
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
    //sq文で別テーブル(deletelist)に移動
    $sql = 'INSERT INTO deletelist(id,selectid,day,detail,is_nodeleted,is_deleted,created_date) 
    SELECT id,selectid,day,detail,is_nodeleted,is_deleted,created_date FROM todos WHERE id = ?';
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, $id,PDO::PARAM_INT);
    $stmt->execute();
    //元のデータは削除
    $sql2 = 'DELETE FROM todos WHERE id = ?';
    $stmt2 = $dbh->prepare($sql2);
    $stmt2->bindValue(1, $id,PDO::PARAM_INT);
    $stmt2->execute();
    $dbh = null;
    //画面遷移(list.php)
    header("Location: list.php");
 } catch(PDOException $e){
    echo'エラー発生:' . htmlspecialchars($e->getMessage(), ENT_QUOTES) . '<br>';
    exit;
 }
?>