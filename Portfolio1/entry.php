<html>
    <head>
        <meta charset = "utf-8">
        <title>登録完了</title>
        <link href = "stationerystore.css" rel = "stylesheet">
    </head>

    <body>
        <h1>Stationery Store</h1>

        <?php
            $a_name = $_POST["a_name"];
            $a_pass = $_POST["a_pass"];
            $a_address = $_POST["a_address"];
            
            //接続
            try{
                $dbh=new PDO('mysql:host=localhost;dbname=ngr4686_stationerystore','ngr4686_1','ecsitetest');
            }catch(PDOException $e){
                echo $e->getmessage();
                exit;
            }

            //処理 
            if(isset($_POST["add"]) && (!empty($a_name)) && !empty($a_pass) && !empty($a_address)){        //登録がクリックされたら
                $sql = "insert into customer_table(name,password,address) value(:key_name,:key_password,:key_address)";
                $stmt = $dbh -> prepare($sql);
                $stmt -> bindParam(":key_name", $a_name);
                $stmt -> bindParam(":key_password", $a_pass);
                $stmt -> bindParam(":key_address", $a_address);
                $stmt -> execute();
                $sql2 = "select id, name, address from customer_table order by id desc limit 1";
                $stmt2 = $dbh ->prepare($sql2);
                $stmt2 -> execute();
                foreach($stmt2 -> fetchAll(PDO::FETCH_ASSOC) as $e){
                    echo "ID:".$e["id"]."<br>"."名前:".$e["name"]."<br>"."配送先住所:".$e["address"]."<br>";
                }
            }else{
                header("Location:signup.php");
            }

            //切断
            $dbh =null;
        ?>
    
        <p>ユーザー情報の登録が完了しました。
        <br>ログインにはIDとパスワードが必要になります。
        <br>ユーザー情報はマイページから確認・変更できます。</p>

        <form action="login.php" method="POST">
            <p><button type="submit" name="to_login" class="t_button">ログインページ</button>へ</p>
        </form>
    </body>
</html>