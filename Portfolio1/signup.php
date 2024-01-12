<html>
    <head>
        <meta charset = "utf-8">
        <title>新規登録ページ</title>
        <link href = "stationerystore.css" rel = "stylesheet">
    </head>

    <body>
        <h1>Stationery Store</h1>
        <br><br>

        <h2>新規登録</h2>
        <form action="entry.php" method="POST">
            <p>名前：<input type="text" name="a_name" id="a_name" class="input_field"></p>
            <p>パスワード：<input type="password" name="a_pass" id="a_pass" class="input_field" placeholder="8文字以内で設定"> <button id="passview" class="view_button" onClick="view()">表示</button> </p>
            <p>配送先住所：<input type="text" name="a_address" id="a_address" class="input_field"></p>
            <input type="submit" name="add" onClick="check()" value=登録 class="l_button"><br><br>
        </form>

        <form action="login.php" method="POST">
        <p>登録済みの方はこちらから<button class="t_button">ログイン</button></p>
        </form>

        <form action="index.html" method="POST">
        <p><button class="t_button">トップページ</button>へ戻る</p>
        </form>

        <script>
            function view(){
                event.preventDefault();
                let pvElm = document.getElementById("passview");
                let passElm = document.getElementById("a_pass");
                if(passElm.type === "password"){
                    passElm.type = "text";
                    pvElm.textContent = "非表示";
                }else{
                    passElm.type = "password";
                    pvElm.textContent = "表示";
                }
            }   

            function check(){
                var nameElm = document.getElementById("a_name").value;
                var passElm = document.getElementById("a_pass").value;
                var addElm = document.getElementById("a_address").value;
                if (nameElm == "" || passElm == "" || addElm == ""){
                    alert("すべての項目に入力してください");
                    event.preventDefault();
                    return;
                }
            }
        </script>
    </body>
</html>