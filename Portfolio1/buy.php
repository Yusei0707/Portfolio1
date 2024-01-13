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
        <title>購入確認ページ</title>
        <link href = "stationerystore.css" rel = "stylesheet">
    </head>

    <body>
        <h1>Stationery Store</h1>
        <h2>購入確認ページ</h2>

        <?php

            $cate;
            $pro;
            // $_SESSION["qty"] = isset($_POST['qty']);

            //接続
            try{
                $dbh=new PDO('mysql:host=localhost;dbname=ngr4686_stationerystore','ngr4686_1','ecsitetest');
            }catch(PDOException $e){
                echo $e->getmessage();
                exit;
            }

            //処理
            if(isset($_POST["buy"])){
                $_SESSION["qty"] = $_POST['qty'];
                $p_num = $_POST["pro_num"];
                $c_num = $p_num % 10;

                $c_sql = "select category from category_table where category_num = :key_category";
                $c_stmt = $dbh -> prepare($c_sql);
                $c_stmt -> bindParam(":key_category",$c_num);
                $c_stmt -> execute();
                foreach($c_stmt -> fetchAll(PDO::FETCH_ASSOC) as $c){
                    $cate = $c["category"];
                }

                $p_sql = "select product from product_table where product_num = :key_product";
                $p_stmt = $dbh -> prepare($p_sql);
                $p_stmt -> bindParam(":key_product",$p_num);
                $p_stmt -> execute();
                foreach($p_stmt -> fetchAll(PDO::FETCH_ASSOC) as $p){
                    $pro = $p["product"];
                }

                $u_sql = "select address from customer_table where id = $l_id";
                $u_stmt = $dbh -> prepare($u_sql);
                $u_stmt -> execute();
                foreach($u_stmt -> fetchAll(PDO::FETCH_ASSOC) as $u){
                    $deladd = $u["address"];
                }

                $dt_sql = "select now()";
                $dt_stmt = $dbh -> prepare($dt_sql);
                $dt_stmt -> execute();
                foreach($dt_stmt -> fetchAll(PDO::FETCH_ASSOC) as $dt){
                    $datetime = $dt["now()"];
                }

                $b_sql = "insert into buy_table(category,product,qty,deladd,datetime) value(:key_category,:key_product,:key_qty,:key_add,:key_dt)";
                $b_stmt = $dbh -> prepare($b_sql);
                $b_stmt -> bindParam(":key_category", $cate);
                $b_stmt -> bindParam(":key_product", $pro);
                $b_stmt -> bindParam(":key_qty", $_SESSION["qty"]);
                $b_stmt -> bindParam(":key_add", $deladd);
                $b_stmt -> bindParam(":key_dt", $datetime);
                $b_stmt -> execute();
                $b_sql2 = "select * from product_table where product_num ='$p_num'";
                $b_stmt2 = $dbh ->prepare($b_sql2);
                $b_stmt2 -> execute();

                foreach($b_stmt2 -> fetchAll(PDO::FETCH_ASSOC) as $b){
                    $_SESSION["total"] = $b["price"] * $_SESSION["qty"];
                    $_SESSION["product"] = $b["product"];

                }

                $o_sql = "select order_num from buy_table order by order_num desc limit 1";
                $o_stmt = $dbh -> prepare($o_sql);
                $o_stmt -> execute();

                foreach($o_stmt -> fetchAll(PDO::FETCH_ASSOC) as $o){
                    $order_num = $o["order_num"]; 
                }

                $h_sql = "insert into history_table(order_num, id) value(:key_order, :key_id)";
                $h_stmt = $dbh -> prepare($h_sql);
                $h_stmt -> bindParam(":key_order", $order_num);
                $h_stmt -> bindParam(":key_id", $l_id);
                $h_stmt -> execute();
            }

            echo "<p>".$_SESSION["product"]."を".$_SESSION["qty"]."個買いました<br>金額は".$_SESSION["total"]."円です</p>";

            if($_SERVER["REQUEST_METHOD"] == "POST"){
                header("Location:buy.php");
            }


            //切断
            $dbh =null;
        ?>

        <form action="catalog.php" method="POST">
            <button class="l_button">一覧ページへ</button>
        </form>
    </body>
<html> 