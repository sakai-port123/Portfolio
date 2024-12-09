<?php
date_default_timezone_set('Asia/Tokyo');
$date = new DateTime('now');

session_start();
$user = 'root';
$pass = 'root';
$selectId = $_SESSION['id'];
$day = $_POST['day'];
$detail = $_POST['detail'];
try{
    $dbh = new PDO('mysql:host=localhost;dbname=phptodo;charset=utf8',$user,$pass);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //SQL
    $sql = 'INSERT INTO `todos`( `selectid`, `day`, `detail`, `created_date`) VALUES(?,?,?,?)';
    $stmt = $dbh->prepare($sql);
    //プレースホルダの値を指定
    $stmt-> bindValue(1, $selectId, PDO::PARAM_INT);
    $stmt-> bindValue(2, $day, PDO::PARAM_STR);
    $stmt-> bindValue(3, $detail, PDO::PARAM_STR);
    $stmt-> bindValue(4, $date->Format('Y-m-d H:i:s'), PDO::PARAM_STR);
    $stmt->execute();
    $dbh = null;
    header("Location: todo.php");
}catch(PDOException $e){
    echo 'エラー発生:' . htmlspecialchars($e->getMessage(), ENT_QUOTES), '<br>';
}
?>