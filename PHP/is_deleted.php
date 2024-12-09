<?php
//完了ページ trueにするだけなのでidだけ取得する。
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
        //SQL文　is_deletedのフラグをたてる。
        $sql = 'UPDATE todos SET is_deleted = true WHERE  id = ?';
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(1, $id,PDO::PARAM_INT);
        $stmt->execute();
        $dbh = null;    
 } catch(PDOException $e){
    echo'エラー発生:' . htmlspecialchars($e->getMessage(), ENT_QUOTES) . '<br>';
    exit;
 }
 header("Location: todo.php");
?>
