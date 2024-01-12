<?php
    session_start();
    $l_id = $_SESSION["l_id"];
    if(empty($l_id)){
        echo "<script>alert('a')</script>";
        header("Location:session.php");
        exit;
    }
?>

<html>
    <head>
        <meta charset = "utf-8">
        <title>購入履歴</title>
        <link href = "stationerystore.css" rel = "stylesheet">
    </head>

    <body>
        <h1>Stationery Store</h1>
        <h2>購入履歴</h2>

        <form action="userpage.php" method="POST">
            <button class="back_button">戻る</button>
        </form>

        <?php

            //接続
            try{
                $dbh=new PDO('mysql:host=localhost;dbname=ngr4686_stationerystore','ngr4686_1','ecsitetest');
            }catch(PDOException $e){
                echo $e->getmessage();
                exit;
            }

            //処理
            $h_sql = "select h.*, cus.name, p.price, b.product, qty,deladd,datetime from history_table as h, customer_table as cus, product_table as p, buy_table as b where h.id = cus.id and h.order_num = b.order_num and p.product = b.product
            and h.id = $l_id order by h.order_num";
            $h_stmt = $dbh -> prepare($h_sql);
            $h_stmt -> execute();

            ?>

            <table border="1">
                <tr><th>注文番号</th><th>ID</th><th>名前</th><th>商品名</th><th>数量</th><th>金額(円)</th><th>配送先住所</th><th>購入日時</th></tr>

                <?php foreach($h_stmt -> fetchAll(PDO::FETCH_ASSOC) as $h): ?>
                    <tr><th><?= $h["order_num"] ?></th><th><?= $h["id"] ?></th><th><?= $h["name"] ?></th><th><?= $h["product"] ?></th><th><?= $h["qty"] ?></th><th><?= $h["price"] * $h["qty"] ?></th><th><?= $h["deladd"] ?></th><th><?= $h["datetime"] ?></th></tr>
                <?php endforeach; ?>
            </table>

            
            <div id="topScroll" class="topIcon" onclick="goTop()">▲</div>

            <script type="text/javascript">
                var vGoTop = {};
                function goTop(){
                
                    vGoTop["coef"] = 50
                    vGoTop["cnt"]  = 0;

                    var startX = document.body.scrollLeft || document.documentElement.scrollLeft;
                    var startY = document.body.scrollTop  || document.documentElement.scrollTop;

                    var moveSplitCnt = 0;
                    for(var i = 1; i <= vGoTop["coef"]; i++) {
                        moveSplitCnt += i * i;
                    }
                    vGoTop["unitH"] = startY / ( moveSplitCnt * 2 );
                    
                    vGoTop["nextX"] = startX;
                    vGoTop["nextY"] = startY;

                    goTopLoop();
                }
                function goTopLoop(){                //  スクロール実行
                
                    vGoTop["cnt"]++;

                    var Coef = 0;
                    if(vGoTop["cnt"] <= vGoTop["coef"]){
                        Coef = vGoTop["cnt"];
                    }else{
                        Coef = ((vGoTop["coef"] * 2) + 1) - vGoTop["cnt"];
                    }
                    vGoTop["nextY"] = vGoTop["nextY"] - Math.round( vGoTop["unitH"] * ( Coef * Coef) );
                    if((vGoTop["cnt"] >= (vGoTop["coef"] * 2))||(vGoTop["nextY"] <= 0)){
                        vGoTop["nextY"] = 0;
                    }

                    window.scrollTo(vGoTop["nextX"], vGoTop["nextY"]);
                    if(vGoTop["nextY"] <= 0){
                        clearTimeout(vGoTop["timer"]);
                    }else{
                        vGoTop["timer"] = setTimeout("goTopLoop()",10);
                    }
                }

                window.addEventListener("scroll", goTopDisp, false);
                function goTopDisp(){                //  先頭表示時のボタン消去
                    var btn  = document.getElementById("topScroll");
                    
                    var nowY = document.body.scrollTop  || document.documentElement.scrollTop;
                    if(nowY ==0){
                        btn.style.display = "none";
                    }else{
                        btn.style.display = "";
                    }
                }
            </script>

    </body>
</html>