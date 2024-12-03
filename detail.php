<?php
//最初にSESSIONを開始！！ココ大事！！
session_start(); //SESSION使うよ

//１．PHP
//select.phpのPHPコードをマルっとコピーしてきます。
//※SQLとデータ取得の箇所を修正します。
$id = $_GET["id"];

//以下がselect.phpから持ってきたcodeです。
include("funcs.php");
sschk();//sessionチェック！
$pdo = db_conn();


//２．データ登録SQL作成
$sql = "SELECT * FROM gs_kk_table WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

//３．データ表示
$values = "";
if($status==false) {
  sql_error($stmt);
}

//全データ取得
$v =  $stmt->fetch(); //PDO::FETCH_ASSOC[カラム名のみで取得できるモード]


//更新前データを保持するための関数

//更新画面遷移後、選択していたカテゴリを保持するための関数
// function sel_list($v){
//     $doc = new DomDocument;
//     $test = $doc->getElementsByTagName("option");
//     if($v["category"] == $test){
//         return true;
//         echo h($test);
//     }else{
//         return false;
//     };
// };

//関数呼び出し


?>
<!--
２．HTML
以下にindex.phpのHTMLをまるっと貼り付ける！
理由：入力項目は「登録/更新」はほぼ同じになるからです。
※form要素 input type="hidden" name="id" を１項目追加（非表示項目）
※form要素 action="update.php"に変更
※input要素 value="ここに変数埋め込み"
-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./css/style.css" rel="stylesheet">
    <title>Document</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
</head>
<body>
    <header>
        <?php include("menu.php");?>
    </header>
    <section class="kakeibo">
        <div class="daily-input-box">
            <h2 class="syushi-title">収支登録（更新/削除）</h2>
                <form class="touroku" method="post" action="?">

                    <!-- 支出？収入？ -->
                    <div class="input-yoso">
                        <div class = "icon-title">
                            <div class = "icon-margin">
                                <img class = "icon" src="./img/icon_plmi.png" alt="収支">
                            </div>
                            <span>支出？収入？</span>
                        </div>
                        <div class="">
                            <label><input type="radio" name="syushi" value=-1  <?=$v["syushi"] ==-1 ? 'checked' : '' ?> required>支出</label>
                            <label><input type="radio" name="syushi" value=1  <?=$v["syushi"] ==1 ? 'checked' : '' ?> >収入</label>
                        </div>
                    </div>

                    <!-- 費用 -->
                    <div class="input-yoso">
                        <div class = "icon-title">
                            <label class="label-yoko" for = "input_money">
                                <div class = "icon-margin">
                                    <img class = "icon" src="./img/icon_money.png" alt="金額">
                                </div>
                                <span>金額</span>
                            </label>
                        </div>
                        <div class="">
                            <div><input id="input_money" class="form_input" type="text" inputmode="numeric" name="money" value="<?=$v["money"]?>"></div>
                            <div></div>
                        </div>
                    </div>

                    <!-- カテゴリ -->
                    <div class="input-yoso">
                        <div class = "icon-title">
                            <label class="label-yoko" for = "input_category">
                                <div class = "icon-margin">
                                    <img class = "icon" src="./img/icon_category.png" alt="カテゴリ">
                                </div>
                                <span>カテゴリ</span>
                            </label>
                        </div>
                        <div class="">
                            <select name="category" id = "input_category" class="select_input" size="1" required>
                                <option  value="食費" <?=$v["category"]=="食費" ? 'selected' : '' ?>>食費</option>
                                <option  value="交際費" <?=$v["category"]=="交際費" ? 'selected' : '' ?>>交際費</option>
                                <option  value="交通費" <?=$v["category"]=="交通費" ? 'selected' : '' ?>>交通費</option>
                                <option  value="光熱費" <?=$v["category"]=="光熱費" ? 'selected' : '' ?>>光熱費</option>
                                <option  value="通信費" <?=$v["category"]=="通信費" ? 'selected' : '' ?>>通信費</option>
                                <option  value="生活用品" <?=$v["category"]=="生活費" ? 'selected' : '' ?>>生活用品</option>
                                <option  value="美容" <?=$v["category"]=="美容" ? 'selected' : '' ?>>美容</option>
                                <option  value="ファッション"<?=$v["category"]=="ファッション" ? 'selected' : '' ?>>ファッション</option>
                                <option  value="給与" <?=$v["category"]=="給与" ? 'selected' : '' ?>>給与</option>
                            </select>
                            <div></div>
                        </div>
                    </div>

                    <!-- 財布 -->
                    <div class="input-yoso">
                        <div class = "icon-title">
                            <label class="label-yoko" for = "input_wallet">
                                <div class = "icon-margin">
                                    <img class = "icon" src="./img/icon_wallet.png" alt="お財布">
                                </div>
                                <span>お財布</span>
                            </label>
                            </div>
                        <div class="">
                            <select name="wallet" id = "input_wallet" class="select_input" size="1" required>
                                <option value="現金" <?=$v["wallet"]=="現金" ? 'selected' : '' ?>>現金</option>
                                <option value="dカード" <?=$v["wallet"]=="dカード" ? 'selected' : '' ?>>dカード</option>
                                <option value="楽天カード" <?=$v["wallet"]=="楽天カード" ? 'selected' : '' ?>>楽天カード</option>
                                <option value="d払い" <?=$v["wallet"]=="d払い" ? 'selected' : '' ?>>d払い</option>
                                <option value="paypay" <?=$v["wallet"]=="paypay" ? 'selected' : '' ?>>paypay</option>
                                <option value="楽天銀行" <?=$v["wallet"]=="楽天銀行" ? 'selected' : '' ?>>楽天銀行</option>
                                <option value="ゆうちょ銀行" <?=$v["wallet"]=="ゆうちょ銀行" ? 'selected' : '' ?>>ゆうちょ銀行</option>
                                <option value="楽天証券" <?=$v["wallet"]=="楽天証券" ? 'selected' : '' ?>>楽天証券</option>
                            </select>
                            <div></div>
                        </div>
                    </div>

                    <!-- 日付 -->
                    <div class="input-yoso">
                        <div class = "icon-title">
                            <label class="label-yoko" for="input_date">
                                <div class = "icon-margin">
                                    <img class = "icon" src="./img/icon_calendar.png" alt="日付">
                                </div>
                                <span>日付</span>
                            </label>
                        </div>
                        <div class="">
                            <div><input id="input_date" class="select_input" type="date" name="indate" value="<?=$v["indate"]?>" required></div>
                            <div></div>
                        </div>
                    </div>

                    <!-- コメント -->
                    <div class="input-yoso">
                        <div class = "icon-title">
                            <label class="label-yoko" id="input_comment">
                                <div class = "icon-margin">
                                    <img class = "icon" src="./img/icon_comment.png" alt="コメント">
                                </div>
                                <span>コメント</span>
                            </label>
                        </div>
                        <div class="">
                            <div><textarea name="comment" id="input_comment" class="form_input" maxlength="200" ><?=$v["comment"]?></textarea></div>
                            <div><input type="hidden" name="id" value="<?=$v["id"]?>"></div>
                        </div>
                    </div>
                    <div class="touroku_btn">
                        <button type="submit" formaction="update.php">更&nbsp;新</button>
                        <button type="submit" id="dlt_btn" formaction="delete.php">削&nbsp;除</button>
                        <button type="submit" formaction="index.php">戻&nbsp;る</button>
                    </div>
                </form>
        </div>
    </section>

    <script>
        $("#dlt_btn").on("click",function(){
            return confirm("入力内容を収支一覧から削除しても良いですか？")
        });
    </script>
</body>
