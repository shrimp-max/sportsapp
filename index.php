<?php
//最初にSESSIONを開始！！ココ大事！！
session_start();

//１. DB接続をfunctionで実行
include("funcs.php");
sschk();//sessionチェック！
$pdo = db_conn();

//２．データ登録SQL作成
$sql = "SELECT * FROM gs_kk_table";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

//３．データ表示
$values = "";
if($status==false) {
  sql_error($stmt);
}

//全データ取得
$values =  $stmt->fetchAll(PDO::FETCH_ASSOC); //PDO::FETCH_ASSOC[カラム名のみで取得できるモード]
$json = json_encode($values,JSON_UNESCAPED_UNICODE);

// echo $json; json形式でechoすることで、javascriptのajaxから、APIのようにjson形式で受け取ることができる

?>


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
            <h2 class="syushi-title">収支登録</h2>
                <form class="touroku" method="post" action="insert.php">

                    <!-- 支出？収入？ -->
                    <div class="input-yoso">
                        <div class = "icon-title">
                            <div class = "icon-margin">
                                <img class = "icon" src="./img/icon_plmi.png" alt="収支">
                            </div>
                            <span>支出？収入？</span>
                        </div>
                        <div class="">
                            <label><input type="radio" name="syushi" value=-1 required>支出</label>
                            <label><input type="radio" name="syushi" value=1>収入</label>
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
                            <div><input id="input_money" class="form_input" type="text" inputmode="numeric" name="money" required></div>
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
                                <option value="" hidden>選択してください</option>
                                <option value="食費">食費</option>
                                <option value="交際費">交際費</option>
                                <option value="交通費">交通費</option>
                                <option value="光熱費">光熱費</option>
                                <option value="通信費">通信費</option>
                                <option value="生活用品">生活用品</option>
                                <option value="美容">美容</option>
                                <option value="ファッション">ファッション</option>
                                <option value="給与">給与</option>
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
                                <option value="" hidden>選択してください</option>
                                <option value="現金">現金</option>
                                <option value="dカード">dカード</option>
                                <option value="楽天カード">楽天カード</option>
                                <option value="d払い">d払い</option>
                                <option value="paypay">paypay</option>
                                <option value="楽天銀行">楽天銀行</option>
                                <option value="ゆうちょ銀行">ゆうちょ銀行</option>
                                <option value="楽天証券">楽天証券</option>
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
                            <div><input id="input_date" class="select_input" type="date" name="indate" required></div>
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
                            <div><textarea name="comment" id="input_comment" class="form_input" maxlength="200"></textarea></div>
                            <div></div>
                        </div>
                    </div>
                    <div class="touroku_btn">
                        <button type="submit">登&nbsp;録</button>
                    </div>
                </form>
        </div>
        <!-- select.phpを読み込む ここから-->

        <!-- ここまで -->


        <!-- 結果表示欄 -->
        <div class="syushi-table">
            <!-- 絞り込み機能 -->
            <div class="filter">
                <form class="touroku" method="post" action="select_filter.php">
                                <!-- 支出？収入？ -->
                    <div class="input-yoso">
                        <div class = "icon-title_2">
                            <div class = "icon-margin_2">
                                <img class = "icon_2" src="./img/icon_plmi.png" alt="収支">
                            </div>
                            <span>支出？収入？</span>
                        </div>
                        <div class="">
                            <label><input type="radio" name="f_syushi" value=-1>支出</label>
                            <label><input type="radio" name="f_syushi" value=1>収入</label>
                        </div>
                    </div>

                    <!-- 費用 -->
                    <div class="input-yoso">
                        <div class = "icon-title_2">
                            <label class="label-yoko">
                                <div class = "icon-margin_2">
                                    <img class = "icon_2" src="./img/icon_money.png" alt="金額">
                                </div>
                                <span>金額</span>
                            </label>
                        </div>
                        <div class="filter_money">
                            <div><input class="form_input_2" type="text" inputmode="numeric" name="f_money_b"></div>
                            <div style="font-size: 20px;">~</div>
                            <div><input class="form_input_2" type="text" inputmode="numeric" name="f_money_u"></div>
                        </div>
                    </div>

                    <!-- カテゴリ -->
                    <div class="input-yoso">
                        <div class = "icon-title_2">
                            <label class="label-yoko" for = "input_category">
                                <div class = "icon-margin_2">
                                    <img class = "icon_2" src="./img/icon_category.png" alt="カテゴリ">
                                </div>
                                <span>カテゴリ</span>
                            </label>
                        </div>
                        <div class="checkbox">
                            <label for="f_syokuhi"><input type="checkbox" name="f_category" id="f_syokuhi" value="食費">食費</label>
                            <label for="f_kousaihi"><input type="checkbox" name="f_category" id="f_kousaihi" value="交際費">交際費</label>
                            <label for="f_koutsuhi"><input type="checkbox" name="f_category" id="f_koutsuhi" value="交通費">交通費</label>
                            <label for="f_kounetsuhi"><input type="checkbox" name="f_category" id="f_kounetsuhi"value="光熱費">光熱費</label>
                            <label for="f_tsushinhi"><input type="checkbox" name="f_category" id="f_tsushinhi" value="通信費">通信費</label>
                            <label for="f_seikatsuhi"><input type="checkbox" name="f_category" id="f_seikatsuhi" value="生活用品">生活用品</label>
                            <label for="f_biyou"><input type="checkbox" name="f_category" id="f_biyou" value="美容">美容</label>
                            <label for="f_fashion"><input type="checkbox" name="f_category" id="f_fashion" value="ファッション">ファッション</label>
                            <label for="f_kyuyo"><input type="checkbox" name="f_category" id="f_kyuyo" value="給与">給与</label>
                            <div></div>
                        </div>
                    </div>

                    <!-- 財布 -->
                    <div class="input-yoso">
                        <div class = "icon-title_2">
                            <label class="label-yoko" for = "input_wallet">
                                <div class = "icon-margin_2">
                                    <img class = "icon_2" src="./img/icon_wallet.png" alt="お財布">
                                </div>
                                <span>お財布</span>
                            </label>
                        </div>
                        <div class="checkbox">
                            <label for="f_cash"><input type="checkbox" name="f_wallet" id="f_cash" value="現金">現金</label>
                            <label for="f_dc"><input type="checkbox" name="f_wallet" id="f_dc" value="dカード">dカード</label>
                            <label for="f_rc"><input type="checkbox" name="f_wallet" id="f_rc" value="楽天カード">楽天カード</label>
                            <label for="f_db"><input type="checkbox" name="f_wallet" id="f_db"value="d払い">d払い</label>
                            <label for="f_pp"><input type="checkbox" name="f_wallet" id="f_pp" value="paypay">paypay</label>
                            <label for="f_rb"><input type="checkbox" name="f_wallet" id="f_rb" value="楽天銀行">楽天銀行</label>
                            <label for="f_yb"><input type="checkbox" name="f_wallet" id="f_biyou" value="f_yb">ゆうちょ銀行</label>
                            <label for="f_rsh"><input type="checkbox" name="f_wallet" id="f_rsh" value="楽天証券">楽天証券</label>
                            <div></div>
                        </div>
                    </div>

                    <!-- 日付 -->
                    <div class="input-yoso">
                        <div class = "icon-title_2">
                            <label class="label-yoko">
                                <div class = "icon-margin_2">
                                    <img class = "icon_2" src="./img/icon_calendar.png" alt="日付">
                                </div>
                                <span>日付</span>
                            </label>
                        </div>
                        <div class="filter_money">
                            <div><input class="form_input_2" type="date" name="f_indate_b"></div>
                            <div style="font-size: 20px;">~</div>
                            <div><input class="form_input_2" type="date" name="f_indate_u"></div>
                        </div>
                    </div>
                    <!-- コメント -->
                    <div class="input-yoso">
                        <div class = "icon-title_2">
                            <label class="label-yoko" id="input_comment">
                                <div class = "icon-margin_2">
                                    <img class = "icon_2" src="./img/icon_comment.png" alt="コメント">
                                </div>
                                <span>コメント</span>
                            </label>
                        </div>
                        <div class="">
                            <div><textarea name="f_comment" id="input_comment" class="select_input_2" maxlength="200"></textarea></div>
                            <div></div>
                        </div>
                    </div>
                    <div class="touroku_btn">
                            <button type="submit" style="font-size: 12px;">この条件で絞り込む</button>
                    </div>
                </form>

                <!-- select.phpを読み込む ここから-->
   
                <!-- ここまで -->

            </div>
            <!-- 絞り込み機能ここまで -->

            <?php foreach($values as $v){
                if($v["syushi"] == 1):?>
                    <div class="syushi-record">
                        <div class="syushi-grid"><?=$v["indate"]?></div>
                        <div class="syushi-grid"><?=$v["category"]?></div>
                        <div id="money" class="syushi-grid" style="color: blue;">¥<?php echo number_format($v["money"])?></div>
                        <div class="syushi-grid"><?=$v["wallet"]?></div>
                        <div class="syushi-grid"><?=$v["comment"]?></div>
                        <div id="syushi" class="syushi-grid" style="color: blue;">収入</div>
                        <div id="edit_test"><a href="detail.php?id=<?=h($v["id"])?>" style="text-decoration:none;" class="edit-btn">編集</a></div>
                    </div>       
                <?php elseif($v["syushi"] == -1):?>
                    <div class="syushi-record">
                        <div class="syushi-grid"><?=$v["indate"]?></div>
                        <div class="syushi-grid"><?=$v["category"]?></div>
                        <div id="money" class="syushi-grid" style="color: red;">¥<?php echo number_format($v["money"])?></div>
                        <div class="syushi-grid"><?=$v["wallet"]?></div>
                        <div class="syushi-grid"><?=$v["comment"]?></div>
                        <div id="syushi" class="syushi-grid" style="color: red;">支出</div>
                        <div id="edit_test"><a href="detail.php?id=<?=h($v["id"])?>" style="text-decoration:none;" class="edit-btn">編集</a></div>
                    </div>
                <?php endif; ?>
            <?php };?>
        </div>
                

       </div>
    </section>

</body>
</html>