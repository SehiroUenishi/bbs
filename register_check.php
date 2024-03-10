<?php
    $inputDataUN = (string)$_POST['userName'];
    $inputDataPW = (string)$_POST['password'];

    // db接続
    try 
    {
        $db = new PDO('mysql:host=localhost;dbname=snsDatabase;charset=utf8', $_ENV['DBUSER'], $_ENV['DBPASS']);
    } 
    catch (PDOException $e) 
    {
        exit();
    }

    //すでに登録されていないかuserNameを検索
    $stmt = $db->prepare('SELECT userName FROM userTable WHERE userName LIKE :searchChar');
    $stmt -> execute(array(':searchChar' => $inputDataUN));

    //検索結果をsearchResultに格納
    $searchResult = $stmt -> fetchall();
    if( count($searchResult) !== 0 )
    {
        // db解放
        $db = null;    

        //失敗画面に飛ばす
        header( 'location:failure.php' );
        exit();
    }
    else
    {
        // dbに内容を登録
        $stmt = $db->prepare('INSERT INTO userTable ( userName, password ) VALUES (:userName, :password)');
        $stmt -> execute(array( ':userName' => $inputDataUN, ':password' => $inputDataPW ));

        // ログインユーザーを登録するためにIDを検索
        $stmt = $db->prepare('SELECT * FROM userTable WHERE userName LIKE :searchChar');
        $stmt -> execute(array(':searchChar' => $inputDataUN));
        $registerUserData = $stmt -> fetchall();

        // db解放
        $db = null;

        //セッションにログインユーザーを登録
        session_start();
        $_SESSION['nowLogInUserId'] = $registerUserData[0]['userId'];

        //成功画面に飛ばす
        header( 'location:success.php' );
        exit();
    }

    //ここは通らないはず
    echo "この文章は表示されないはずです";
    exit();
?>