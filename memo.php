<div class="syushi-table">
            <?php foreach($values as $v){ ?>
                <div class="syushi-record">
                    <div class="syushi-grid"><?=$v["indate"]?></div>
                    <div class="syushi-grid"><?=$v["category"]?></div>
                    <div id="money" class="syushi-grid">¥<?php echo number_format($v["money"])?></div>
                    <div class="syushi-grid"><?=$v["wallet"]?></div>
                    <div class="syushi-grid"><?=$v["comment"]?></div>
                    <div id="syushi" class="syushi-grid"><?=$v["syushi"]?></div>
                    <script>
                        if(<?=$v["syushi"]?> == 1){
                            $("#syushi").replaceAll("収入").css("color","blue");
                            $("#money").css("color","blue");
                        };
                        if(<?=$v["syushi"]?> == -1){
                            $("#syushi").html("支出").css("color","red");
                            $("#money").css("color","red");
                        };
                    </script>
                </div>
        <?php } ?>
</div>