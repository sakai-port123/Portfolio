<?php
//編集した内容データベースに反映
$user = 'root';
$pass = 'root';
if(empty($_GET['id'])){
    echo 'IDを入力してください';
    exit;
}
$id = (int)$_GET['id'];
$day = $_POST['day'];
$category = $_POST['category'];
$title = $_POST['title'];
$detaile = $_POST['detail'];
try{
    $dbh = new PDO('mysql:host=localhost;dbname=phptodo;charset=utf8',$user,$pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //編集させて、is_deletedをfalseにする。
    $sql = 'UPDATE todos SET `day` = ?, `category` = ?, `title` = ?, `detail` = ?, is_nodeleted = false WHERE id = ?';
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1,$day);
    $stmt->bindValue(2,$category,PDO::PARAM_STR);
    $stmt->bindValue(3,$title,PDO::PARAM_STR);
    $stmt->bindValue(4,$detaile,PDO::PARAM_STR);
    $stmt->bindValue(5, $id, PDO::PARAM_INT);
    $stmt-> execute();
    $dbh = null;
    header("Location: todo.php");
}catch(PDOException $e){
    echo 'エラー発生' . htmlspecialchars($e->getMessage() , ENT_QUOTES) . '<br>';
    exit;
}
?>