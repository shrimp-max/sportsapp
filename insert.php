<?php
//エラー表示
ini_set("display_errors", 1);


//１. DB接続をfunctionで実行
include("funcs.php");
$pdo = db_conn();

//1. POSTデータ取得
$syushi = $_POST["syushi"];
$money = $_POST["money"];
$category = $_POST["category"];
$wallet = $_POST["wallet"];
$indate = $_POST["indate"];
$comment = $_POST["comment"];


//３．データ登録SQL作成
$sql = "INSERT INTO gs_kk_table(syushi,money,category,wallet,indate,comment,user_id)VALUES(:syushi,:money,:category,:wallet,:indate,:comment,:user_id)";
$stmt = $pdo->prepare($sql); //$pdoの中のorepareを使う

//SQLに変数を設定する場合、bindValueを通すこと！SQLインジェクションを起こすようなデータを無効化する
$stmt->bindValue(':syushi', $syushi, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':money', $money, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':category', $category, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':wallet', $wallet, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':indate', $indate, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':comment', $comment, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)

$status = $stmt->execute(); //実行

//４．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  sql_error($stmt);
}else{
  //５．index.phpへリダイレクト（エラーなく正常に完了した場合）
  redirect("index.php");
}

?>
