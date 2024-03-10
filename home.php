<html>

<head>
    <title>hashinoshita</title>
	<link rel="stylesheet" type="text/css" href="styles.css" />
</head>

<?php
    session_start();
    // セッションからログインしているユーザーのIDを取得
    $nowLogInUserId = $_SESSION['nowLogInUserId'];
?>

<header>
    橋の下の落書きへようこそ！<br/>

    <form action="" method="post">

        <textarea id="content" name="content" placeholder="ここに書き込み" required></textarea>

        <input type="submit" value="落書き">
    </form>

    <?php
        $inputData = (string)$_POST['content'];
        if($inputData !== "")
        {
            // db接続
            try 
            {
                $db = new PDO('mysql:host=localhost;dbname=snsDatabase;charset=utf8', $_ENV['DBUSER'], $_ENV['DBPASS']);
            } 
            catch (PDOException $e) 
            {
                exit();
            }

            // dbに内容を登録
            $stmt = $db->prepare('INSERT INTO graffitiTable ( userId, content ) VALUES (:userId, :content)');

            $stmt -> execute(array( ':userId' => $nowLogInUserId, ':content' => $inputData ));

            // db解放
            $db = null;
        }
    ?>

    <hr align="left" size="10" width="80%">
</header>

<body>
    <!-- dbからデータを取ってきてdata変数に格納、変数をechoしてlineを引く -->
    <?php
        //db接続
        try 
        {
            $db = new PDO('mysql:host=localhost;dbname=snsDatabase;charset=utf8', $_ENV['DBUSER'], $_ENV['DBPASS']);
        } 
        catch (PDOException $e) 
        {
            exit();
        }
        //dbから内容と書いたユーザーのデータ取得
        $stmt = $db->prepare('SELECT * FROM graffitiTable');
        $check = $stmt -> execute();
        if($check)
        {
            $data = $stmt->fetchall();
        }

        foreach($data as $value)
        {
            // userIdから書いたユーザの名前を特定
            $stmt = $db->prepare('SELECT userId,userName FROM userTable WHERE userId = :userId');
            $check = $stmt -> execute(array(':userId' => $value['userId']));
            if($check)
            {
                $graffitiUser = $stmt->fetch();
            }
            else
            {
                $graffitiUser = "不明なユーザー";
            }
            
            echo '<font color="#4d064d"><b>'.$graffitiUser['userName'].'</b></font>';
            echo "<br/>";
            echo nl2br($value['content']);
            echo "<br/>";
            echo "<br/>";
            echo "///---------------------------------------------------------///";
            echo "<br/>";
        }

        //db解放
        $db = null;
    ?>
</body>

</html>