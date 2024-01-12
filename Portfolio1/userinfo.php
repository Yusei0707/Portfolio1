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
        <title>ユーザー情報</title>
        <link href = "stationerystore.css" rel = "stylesheet">
    </head>

    <body>
        <h1>Stationery Store</h1>
        <h3>ユーザー情報の確認</h3>

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
            foreach($u_stmt -> fetchAll(PDO::FETCH_ASSOC) as $u){
                ?>
                <p> <?= "ID：".$u["id"] ?> </p> 
                <p> <?= "名前：".$u["name"] ?> </p>
                <p> <?= "配送先住所：".$u["address"]; ?> </p> 
                <?php
            }

            //切断
            $dbh =null;
        ?>

        <br>
        <h3>ユーザー情報の変更</h3>
        <p>変更したい項目のみ入力してください<p>
        <form action="userpage.php" method="POST">
            <p>名前：<input type="text" name="c_name" id="c_name" class="input_field"></p>
            <p>パスワード：<input type="password" name="c_pass" id="c_pass" maxlength="8" placeholder="8文字以内で設定" class="input_field"> <button id="passview" class="view_button" onClick="view()">表示</button> </p>
            <p>配送先住所：<input type="text" name="c_address" id="c_address" class="input_field"></p>
            <input type="submit" name="change" id="change" value="変更" onClick="alert('ユーザー情報を変更しました')" class="back_button">
        </form>

        <br>
        
        <form action="index.html" method="POST">
            <button type="submit" name="logout" class="l_button">ログアウト</button>
        </form>

        <br>
        <form action="userpage.php" method="POST">
            <button class="back_button">戻る</button>
        </form>

        <script>
            function view(){
                event.preventDefault();
                let pvElm = document.getElementById("passview");
                let passElm = document.getElementById("c_pass");
                if(passElm.type === "password"){
                        passElm.type = "text";
                        pvElm.textContent = "非表示";
                    }else{
                        passElm.type = "password";
                        pvElm.textContent = "表示";
                    }
            }

            // function change(){
            //     alert("ユーザー情報を変更しました");
            // }
        </script>

    </body>
</html>