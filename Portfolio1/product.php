<html>
    <head>
        <meta charset = "utf-8">
        <title>詳細ページ</title>
        <link href = "stationerystore.css" rel = "stylesheet">
    </head>

    <body>
        <h1>Stationery Store</h1>
        <h2>詳細ページ</h2>

        <?php

        //接続
        try{
            $dbh=new PDO('mysql:host=localhost;dbname=ngr4686_stationerystore','ngr4686_1','ecsitetest' );
        }catch(PDOException $e){
            echo $e->getmessage();
            exit;
        }

        //処理
        if(isset($_POST["pro_num"])){  //商品がクリックされたら
            $pro_num = $_POST["pro_num"];
            $sql = "select * from product_table where product_num = '$pro_num'";
            $stmt = $dbh -> prepare($sql);
            $stmt -> execute();
            foreach ( $stmt ->fetchAll(PDO::FETCH_ASSOC) as $pro){ ?>
            <div style="float: left; width: 330;"> 
                <img src="<?= $pro['product'] ?>.png" width="300"> 
                <form action="buy.php" method="POST">
                    <input type="hidden" name="pro_num" id="pro_num" value="<?= $pro_num; ?>">
            </div>
                    <p class="p_name"><?= $pro["product"]; ?></p>
                    <p>商品説明<br><?= $pro["exp"] ?></p>
                    <p>価格：<?= $pro["price"]; ?>円</p><br>
                    <p>数量:<input type="number" name="qty" id="qty" min=1 max=10 value=1 class="input_field">
                    <input type="submit" name="buy" value="購入" class="input_button"></p>
                </form>
            <div class="clear"></div>
                <?php
            }
        }

        //切断
        $dbh =null;
        ?>

        <form action="category.php" method="POST">
        <input type="hidden" name="sc_id" id="sc_id" value="<?= $pro_num % 10 ?>">
        <input type="hidden" name="s_h2" id="s_h2" value="<?= $pro_num % 10 ?>">
        <input type="submit" name=to_category value="戻る" class="back_button">
        </form>

        <form action="catalog.php" method="POST">
        <button class="back_button">商品一覧へ</button>
        </form>

    </body>
</html>