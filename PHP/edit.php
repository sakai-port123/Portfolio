<?php
//編集ページ
$user = 'root';
$pass = 'root';
if(empty($_GET['id'])){
    echo 'IDを入力してください';
    exit;
}
$id = (int)$_GET['id'];
try{
    $dbh = new PDO('mysql:host=localhost;dbname=phptodo;charset=utf8',$user,$pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT * FROM todos WHERE id = :id';
    $stmt = $dbh->prepare($sql);
    $stmt -> bindValue(':id',$id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $dbh = null;
}catch(PDOException $e){
    echo 'エラー発生:' . htmlspecialchars($e->getMessage(), ENT_QUOTES) . '<br>';
    exit;
}
?>
<?php $date = new DateTime($result['day'])?>
<!DOCTYPE htmll>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>TODO編集</title>
</head>
<body>
<div align="center">
    <h1>TODOリストの一覧</h1>
    <h2>予定を登録する</h2>
    <form  method="POST" action="update.php?id=<?=htmlspecialchars($result['id'], ENT_QUOTES)?>">
        <label>日時<br>
        <input type="datetime-local"  name="day" value="<?= $date->Format('Y-m-d\TH:i')?>" required></label><br>
        <label>カテゴリ<br>
        <select name="category">
        <option hidden>選択してください</option>
		<option value="1" <?php if ($result['category'] == 1) echo 'selected' ?>>仕事</option>
		<option value="2" <?php if ($result['category'] == 2) echo 'selected' ?>>家事</option>
		<option value="3" <?php if ($result['category'] == 3) echo 'selected' ?>>趣味</option>
		<option value="4" <?php if ($result['category'] == 4) echo 'selected' ?>>子ども</option>
		<option value="5" <?php if ($result['category'] == 5) echo 'selected' ?>>その他</option>
		</select></label><br>
        <label>タイトル<br>
        </label><input type="text" name="title" value="<?= htmlspecialchars($result['title'], ENT_QUOTES) . PHP_EOL;?>"><br>
        <label>詳細<br>
        </label><textarea name="detail" cols="40" rows="4" maxlength="320"><?= htmlspecialchars($result['detail'], ENT_QUOTES) . PHP_EOL;?></textarea><br>
        <input type="submit" value="登録">
    </form>
</div>
</body>