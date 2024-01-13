<?php
    session_start();
?>

<html>
    <head>
        <meta charset = "utf-8">
        <title>一覧ページ</title>
        <link href = "stationerystore.css" rel = "stylesheet">
    </head>

    <body>
        <h1>Stationery Store</h1>

        <?php

        //接続
        try{
            $dbh=new PDO('mysql:host=localhost;dbname=ngr4686_stationerystore','ngr4686_1','ecsitetest');
        }catch(PDOException $e){
            echo $e->getmessage();
            exit;
        }

        //処理
        if ( isset ($_POST["log_in"])){    //ログインがクリックされたら
            $l_id = $_POST["l_id"];
            $l_pass = $_POST["l_pass"];

            if(!empty($l_id) && !empty($l_pass)){
                $l_sql = "select count(id), name, password, address from customer_table where id = :key_id";
                $l_stmt = $dbh -> prepare($l_sql);
                $l_stmt -> bindParam(":key_id", $l_id);
                $l_stmt -> execute();
                foreach($l_stmt -> fetchAll(PDO::FETCH_ASSOC) as $l){
                    if ($l["count(id)"] == 1 && $l_pass == $l["password"]){
                        ?> <p><?= $l["name"]."さん、ようこそ<br>"; ?></p><?php
                        $_SESSION["l_id"] = $l_id;
                        $l_id = $_SESSION["l_id"];
                    }else{
                        header("Location:login.php");
                    }
                }
            }elseif (empty($l_id) || empty($l_pass)){
                header("Location:login.php");
            }
        }
        
        ?><h2>商品一覧</h2>

        <form action="category.php" method="POST">
            <?php $c_sql = "select category from category_table";
            $c_stmt = $dbh -> prepare($c_sql);
            $c_stmt -> execute();

            foreach($c_stmt -> fetchAll(PDO::FETCH_ASSOC) as $c){
                ?>
                <div style="float: left;">
                    <input type="submit" name="category" value=<?= $c["category"]; ?> class="c_button">
                </div>
                <?php } ?>
        </form>

        <div class="clear"></div>

        <br><br>

        <form action="userpage.php" method="POST">
            <button type="submit" name="to_mypage" class="l_button">マイページ</button>
        </form>

        <form action="index.html" method="POST">
            <button type="submit" name="logout" class="l_button">ログアウト</button>
        </form>

        <?= //切断
        $dbh =null; ?>
    </body>
</html>