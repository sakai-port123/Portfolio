<?php
session_start();
$_SESSION = array();//セッションの全てを消去
session_destroy();//セッション破棄
header("Location: index.php");
exit;
?>
