<?php
//エラー表示
ini_set("display_errors", 1);

//1.  DB接続します
try {
  //Password:MAMP='root',XAMPP=''
  // $pdo = new PDO('mysql:dbname=ebitaku_kakeiboapp;charset=utf8;host=mysql57.ebitaku.sakura.ne.jp','ebitaku','zVmjN92n9B-ZjEE'); //PDO：DBに接続するための関数 DB名、id,password設定する
  $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root',''); //PDO：DBに接続するための関数 DB名、id,password設定する
} catch (PDOException $e) {
  exit('DBError:'.$e->getMessage());
}

//２．データ登録SQL作成
$sql = "SELECT * FROM gs_kk_table";
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