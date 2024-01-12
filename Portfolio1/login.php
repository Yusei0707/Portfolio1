<html>
    <head>
        <meta charset = "utf-8">
        <title>ログインページ</title>
        <link href = "stationerystore.css" rel = "stylesheet">
    </head>

    <body>
        <h1>Stationery Store</h1>
        <br><br>

        <form action="catalog.php" method="POST">
            <p>ID：<input type="text" name="l_id" id="l_id" class="input_field"></p>
            <p>パスワード：<input type="password" name="l_pass" id="l_pass" class="input_field"> <button id="passview" class="view_button" onClick="view()">表示</button></p>
            <input type="submit" name="log_in" onClick="check()" value="ログイン" class="l_button"><br><br>
        </form>

        <form action="signup.php" method="POST">
            <p>登録がまだの方はこちらから<button class="t_button">新規登録</button></p>
            </form>
            <form action="index.html" method="POST">
            <p><button class="t_button">トップページ</button>へ戻る</p>
        </form>

        <script>
            function view(){
                event.preventDefault();
                let pvElm = document.getElementById("passview");
                let passElm = document.getElementById("l_pass");
                if(passElm.type === "password"){
                    passElm.type = "text";
                    pvElm.textContent = "非表示";
                }else{
                    passElm.type = "password";
                    pvElm.textContent = "表示";
                }
            }

            function check(){
                var idElm = document.getElementById("l_id").value;
                var passElm = document.getElementById("l_pass").value;
                
                if(idElm == "" && passElm == ""){
                    alert("入力してください");
                    return;
                }else if(idElm == ""){
                    alert("IDを入力してください");
                }else if(passElm == ""){
                    alert("パスワードを入力してください");
                }
            }
        </script>
    </body>

</html>