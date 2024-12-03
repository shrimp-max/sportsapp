<?php
//エラー表示
ini_set("display_errors", 1);

//insert.phpを読み込んで、データベース情報を取得する
include "insert.php";

$f_syushi = $_POST["f_syushi"];
$f_money_b = $_POST["f_money_b"];
$f_money_u = $_POST["f_money_u"];
$f_category = $_POST["f_category"];
$f_wallet = $_POST["f_wallet"];
$f_indate_b = $_POST["f_indate_b"];
$f_indate_u = $_POST["f_indate_u"];
$f_comment = $_POST["f_comment"];

//1.  DB接続します
try {
  //Password:MAMP='root',XAMPP=''
  // $pdo = new PDO('mysql:dbname=ebitaku_kakeiboapp;charset=utf8;host=mysql57.ebitaku.sakura.ne.jp','ebitaku','zVmjN92n9B-ZjEE'); //PDO：DBに接続するための関数 DB名、id,password設定する
  $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root',''); //PDO：DBに接続するための関数 DB名、id,password設定する
} catch (PDOException $e) {
  exit('DBError:'.$e->getMessage());
}

//２．データ登録SQL作成
$sql = "SELECT syushi, money, category, wallet, indate, comment FROM gs_kk_table 
WHERE (syushi = :f_syushi
AND money BETWEEN  :f_money_b AND  :f_money_u
AND category LIKE'%:f_category%'
AND wallet LIKE '%:f_wallet%'
AND indate BETWEEN  :f_indate_b AND  :f_indate_b
AND comment LIKE '%:f_comment%')";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute(); //実行

//３．データ表示
$view="";
if($status==false) { //True or Falseで返す
  //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("SQLError:".$error[2]);
}

//全データ取得
$values =  $stmt->fetchAll(PDO::FETCH_ASSOC); //PDO::FETCH_ASSOC[カラム名のみで取得できるモード]
//JSONに値を渡す場合に使う
$json = json_encode($values,JSON_UNESCAPED_UNICODE);

?>