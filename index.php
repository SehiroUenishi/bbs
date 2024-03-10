<html>
<head>
	<title>hashinoshita ログイン画面</title>
</head>

<body bgcolor="#b2f9b2" text="black">
	<font color="#4d064d" size="7">登録済み</font>のかたはこちらから<br/>
	<form action="login_check.php" method="post">

        <label for="userName">ユーザー名</label>
		<input type="text" id="userName" name="userName" required>

		<label for="password">パスワード</label>
		<input type="password" id="password" name="password" required>

        <input type="submit" value="送信">
    </form>

	<br/><br/>

	<font color="#4d064d" size="7">未登録</font>のかたはこちらから<br/>
	<form action="register_check.php" method="post">

        <label for="userName">ユーザー名</label>
		<input type="text" id="userName" name="userName" required>

		<label for="password">パスワード</label>
		<input type="password" id="password" name="password" required>

        <input type="submit" value="送信">
    </form>

	<hr align="left" size="10" width="80%">
	<font color="#a22041" size="5">注意!</font><br/>
	・ユーザー名は他の人と同じものを使用することはできません。<br/>

</body>

</html>