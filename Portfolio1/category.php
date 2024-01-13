<html>
    <head>
        <meta charset = "utf-8">
        <title>商品ページ</title>
        <link href = "stationerystore.css" rel = "stylesheet">
    </head>

    <body>
        <h1>Stationery Store</h1>

        <?php

            $c_id = 0;
            $p_id = 0;
            $h2 = "";

            //接続
            try{
                $dbh=new PDO('mysql:host=localhost;dbname=ngr4686_stationerystore','ngr4686_1','ecsitetest');
            }catch(PDOException $e){
                echo $e->getmessage();
                exit;
            }

            //処理
            if(isset($_POST["category"])){
                $h2 = $_POST["category"];
            }

            $_SESSION["h2"] = $h2;
            if(isset($_POST["to_category"])){
                $h2_id = $_POST["s_h2"];
                $h2_sql = "select category from category_table where category_num = $h2_id";
                $h2_stmt = $dbh  -> prepare($h2_sql);
                $h2_stmt -> execute();
                foreach($h2_stmt -> fetchAll(PDO::FETCH_ASSOC) as $c_h2){
                    $h2 = $c_h2["category"];
                }
            }

            ?><h2><?= $h2; ?></h2><?php

            

            if(isset($_POST["category"])){
                $category = $_POST["category"];
                $c_sql = "select category_num from category_table where category = :key_c";
                $c_stmt = $dbh -> prepare($c_sql);
                $c_stmt-> bindParam(":key_c", $category);
                $c_stmt -> execute();

                foreach($c_stmt -> fetchAll(PDO::FETCH_ASSOC) as $c){
                    $c_id = $c["category_num"];
                }
            }

            if(isset($_POST["to_category"])){
                $c_id = $_POST["sc_id"];
            }

            $sql = "select * from product_table where product_num like '_$c_id'";
            $stmt = $dbh->query($sql);
            foreach($stmt -> fetchAll(PDO::FETCH_ASSOC) as $product):
            
            $c_id;
            $p_id += 10;
            $pro_num = $p_id + $c_id;

            //切断
            $dbh =null;
        ?>        
        <form action="product.php" method="POST">
            <div style="float: left; width: 220px;">
                <input type="hidden" name="pro_num" id="pro_num" value="<?= $pro_num; ?>">
                <input type="image" name="product" src= "<?= $product['product'] ?>.png" width="200" class="p_img"><br>
                <input type="submit" name="product" value="<?= $product['product'] ?>" class="p_button">
            </div>
        </form>
        <?php endforeach; ?>

        <div class="clear"></div><br><br>

        <form action="catalog.php" method="POST">
        <button class="back_button">戻る</button>
        </form>

    </body>
</html>
