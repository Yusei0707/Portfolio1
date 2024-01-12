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
        <title>マイページ</title>
        <link href = "stationerystore.css" rel = "stylesheet">
    </head>

    <body>
        <h1>Stationery Store</h1>
        <h2>マイページ</h2>

        <?php
            //接続
            try{
                $dbh=new PDO('mysql:host=localhost;dbname=ngr4686_stationerystore','ngr4686_1','ecsitetest');
            }catch(PDOException $e){
                echo $e->getmessage();
                exit;
            }

            //処理
            $u_sql = "select * from customer_table where id = '$l_id'";
            $u_stmt = $dbh -> prepare($u_sql);
            $u_stmt -> execute();
            foreach ( $u_stmt ->fetchAll(PDO::FETCH_ASSOC) as $u){
            }

            if(isset($_POST["change"])){
                $c_name = $_POST["c_name"];
                $c_pass = $_POST["c_pass"];
                $c_address = $_POST["c_address"];

                if(empty($c_name)){
                    $c_name = $u["name"];
                }
                if(empty($c_pass)){
                    $c_pass = $u["password"];
                }
                if(empty($c_address)){
                    $c_address = $u["address"];
                }

                $c_sql = "update customer_table set name=:key_name, password=:key_pass, address=:key_address where id = $l_id";
                $c_stmt = $dbh -> prepare($c_sql);
                $c_stmt -> bindParam(":key_name", $c_name);
                $c_stmt -> bindParam(":key_pass", $c_pass);
                $c_stmt -> bindParam(":key_address", $c_address);
                $c_stmt -> execute();
                header("Location:userinfo.php");
            }
        ?>

        <form action="userinfo.php" method="POST">
            <button class="l_button">ユーザー情報の確認・変更</button>
        </form>

        <form action="userhistory.php" method="POST">
            <button class="l_button">購入履歴</button>
        </form>

        <form action="index.html" method="POST">
            <button type="submit" name="logout" class="l_button">ログアウト</button>
        </form>

        <form action="catalog.php" method="POST">
            <button class="back_button">戻る</button>
        </form>

    </body>
</html>