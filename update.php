<?php
//PHP:コード記述/修正の流れ
//1. insert.phpの処理をマルっとコピー。
//   POSTデータ受信 → DB接続 → SQL実行 → 前ページへ戻る
//2. $id = POST["id"]を追加
//3. SQL修正
//   "UPDATE テーブル名 SET 変更したいカラムを並べる WHERE 条件"
//   bindValueにも「id」の項目を追加
//4. header関数"Location"を「select.php」に変更

//最初にSESSIONを開始！！ココ大事！！
session_start();

//1. POSTデータ取得
$syushi = $_POST["syushi"];
$money = $_POST["money"];
$category = $_POST["category"];
$wallet = $_POST["wallet"];
$indate = $_POST["indate"];
$comment = $_POST["comment"];
$id = $_POST["id"];

//2. DB接続します
//*** function化する！  *****************
//共通して3回以上使うようなら関数化しよう！関数化したい場合は、function(){}でくくる
include("funcs.php");
sschk();//sessionチェック！
$pdo =  db_conn(); //function内のreturn部分を受け取ることができる

//３．データ登録SQL作成
$sql = "UPDATE gs_kk_table SET syushi=:syushi, money=:money, category=:category, wallet=:wallet, indate=:indate, comment=:comment WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':syushi',   $syushi,   PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':money',  $money,  PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':category',    $category,    PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':wallet', $wallet, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':indate', $indate, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':comment', $comment, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':id',    $id,    PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)

$status = $stmt->execute(); //実行

//４．データ登録処理後
if($status==false){
    //*** function化する！*****************
    sql_error($stmt); //引数を指定する
}else{
    //*** function化する！*****************
    redirect("index.php");
};

?>









