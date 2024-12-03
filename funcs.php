<?php
//XSS対応（ echoする場所で使用！それ以外はNG ）
function h($str){
    return htmlspecialchars($str, ENT_QUOTES);
}

//DB接続関数：db_conn()

// // ローカル編集用
function db_conn(){
    try {
        $db_name = "gs_db";    //データベース名 データベース名をここで変えるだけでどんなdbも楽に呼び出せる
        $db_id   = "root";      //アカウント名
        $db_pw   = "";          //パスワード：XAMPPはパスワード無し or MAMPはパスワード”root”に修正してください。
        $db_host = "localhost"; //DBホスト
        return new PDO('mysql:dbname='.$db_name.';charset=utf8;host='.$db_host, $db_id, $db_pw); //returnでfunctionの外に出す、functionを呼びだしたところに返す。
    } catch (PDOException $e) {
        exit('DB Connection Error:'.$e->getMessage());
    }
};
// // ローカル編集用

// さくらサーバ用
// function db_conn(){
//     try {
//         $db_name = "ebitaku_kakeiboapp";    //データベース名 データベース名をここで変えるだけでどんなdbも楽に呼び出せる
//         $db_id   = "ebitaku";      //アカウント名
//         $db_pw   = "zVmjN92n9B-ZjEE";          //パスワード：XAMPPはパスワード無し or MAMPはパスワード”root”に修正してください。
//         $db_host = "mysql57.ebitaku.sakura.ne.jp"; //DBホスト
//         return new PDO('mysql:dbname='.$db_name.';charset=utf8;host='.$db_host, $db_id, $db_pw); //returnでfunctionの外に出す、functionを呼びだしたところに返す。
//     } catch (PDOException $e) {
//         exit('DB Connection Error:'.$e->getMessage());
//     }
// };
// さくらサーバ用





//SQLエラー関数：sql_error($stmt)
function sql_error($stmt){ //functionの外で使っている変数をfunctionの中で使う場合、（）の中に記載する（引数）
    $error = $stmt->errorInfo();
    exit("SQLError:".$error[2]);
};



//リダイレクト関数: redirect($file_name)
function redirect($filename){ //$filenameという変数を使うことで、関数を呼び出すごとにリダイレクト先のファイルを自在にできる
    header("Location: ".$filename);
    exit();
};

//SessionCheck(スケルトン)
function sschk(){
    if(!isset($_SESSION["chk_ssid"]) || $_SESSION["chk_ssid"]!=session_id()){
      // redirect("login.php");
       exit("Login Error");
    }else{
       session_regenerate_id(true);
       $_SESSION["chk_ssid"] = session_id();  //sessionidを新しく作成する
    }
  };

?>



