<!DOCTYPE html>
<html>
    <head>
        <meta charset = "UTF-8">
        <title>mission_5-1</title>
    </head>
    <body>
        好きな食べ物をコメントしてもらえたらと思います！<br>
        名前、コメント、パスワードをすべて入力すると新規で作成できます。<br>
        パスワードの変更はできないので、忘れないようにお願いします。<br>
        <?php
        // DB接続設定
	    $dsn = ʼデータベース名ʼ;
	    $user = ʼユーザー名ʼ;
	    $password = ʼパスワードʼ ;
	    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
        //新規入力sql（できてる）
        if(isset($_POST["nam"])&&isset($_POST["com"])&&isset($_POST["pass"])&&empty($_POST["renum"])) {
    	    $name = $_POST["nam"];
    	    $comment = $_POST["com"];
    	    $date = date("Y/m/d H:i:s");
    	    $pass = $_POST["pass"];
    	    if(strlen($name&&$comment&&$pass)){
    	        $sql = $pdo -> prepare("INSERT INTO tbform (name, comment, date, pass)VALUES (:name, :comment, :date, :pass)");
	            $sql -> bindParam(':name', $name, PDO::PARAM_STR);
    	        $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
	            $sql -> bindParam(':date', $date, PDO::PARAM_STR);
	            $sql -> bindParam(':pass', $pass, PDO::PARAM_STR);
	            $sql -> execute();
	            echo "送信成功";
    	    }
        }
        
        //編集入力(たぶんOK)
        if(isset($_POST["renum"])&&isset($_POST["nam"])&&isset($_POST["com"])&&isset($_POST["pass"])) {
            $name = $_POST["nam"];
    	    $comment = $_POST["com"];
    	    $pass = $_POST["pass"];
    	    $reid =  $_POST["renum"];
            if(strlen($name&&$comment&&$pass&&$reid)){
                $sql = 'SELECT * FROM tbform WHERE id=:id ';
                $stmt = $pdo->prepare($sql);                  // ←差し替えるパラメータを含めて記述したSQLを準備し、
                $stmt->bindParam(':id', $reid, PDO::PARAM_INT); // ←その差し替えるパラメータの値を指定してから、
                $stmt->execute();                             // ←SQLを実行する。
                $results = $stmt->fetchAll(); 
	            foreach ($results as $rowedi){
		        //$rowの中にはテーブルのカラム名が入る
    		        if(isset($rowedi['pass'])){
		                $passa= $rowedi['pass'];
	                    if(isset($pass)&&$passa==$pass){//ここのpassaがおかしくなる
                            $sql = 'UPDATE tbform SET name=:name,comment=:comment WHERE id=:id AND pass=:pass';
	                        $stmt = $pdo->prepare($sql);
	                        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    	                    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
	                        $stmt->bindParam(':id', $reid, PDO::PARAM_INT);
	                        $stmt->bindParam(':pass', $pass, PDO::PARAM_INT);
	                        $stmt->execute();
	                        echo "編集成功";
                        }else{//パスワードが違うとき
                            echo "パスワードが違います。<br>";
                        }
		            }
	            }
            }
        }
        
        //削除(たぶんできてる)
        if(isset($_POST["num"])&&isset($_POST["delpass"])){
            $delid = $_POST["num"];
            $delpass = $_POST["delpass"];
            if(strlen($delid&&$delpass)){
                $sql = 'SELECT * FROM tbform WHERE id=:id ';
                $stmt = $pdo->prepare($sql);                  // ←差し替えるパラメータを含めて記述したSQLを準備し、
                $stmt->bindParam(':id', $delid, PDO::PARAM_INT); // ←その差し替えるパラメータの値を指定してから、
                $stmt->execute();                             // ←SQLを実行する。
                $results = $stmt->fetchAll(); 
	            foreach ($results as $rowdel){
		        //$rowの中にはテーブルのカラム名が入る
    		        if(isset($rowdel['pass'])){
		                $passb = $rowdel['pass'];
	                    if($passb == $delpass){
                            $sql = 'delete from tbform WHERE id=:id AND pass=:pass';
	                        $stmt = $pdo->prepare($sql);
	                        $stmt->bindParam(':id', $delid, PDO::PARAM_INT);
	                        $stmt->bindParam(':pass', $delpass, PDO::PARAM_INT);
	                        $stmt->execute();
                        }else{
                            echo "パスワードが違います。<br>";
                        }
		            }
	            }
            }
        } 
         //編集表示
        if(isset($_POST["edit"])&&isset($_POST["edipass"])){
            $ediid =  $_POST["edit"];
            $edipass = $_POST["edipass"];
            if(strlen($ediid&&$edipass)){
                $sql = 'SELECT * FROM tbform WHERE id=:id ';
                $stmt = $pdo->prepare($sql);                  // ←差し替えるパラメータを含めて記述したSQLを準備し、
                $stmt->bindParam(':id', $ediid, PDO::PARAM_INT); // ←その差し替えるパラメータの値を指定してから、
                $stmt->execute();                             // ←SQLを実行する。
                $results = $stmt->fetchAll(); 
	            foreach ($results as $rowedi){
		        //$rowの中にはテーブルのカラム名が入る
    		        if(isset($rowedi['pass'])){
		                $passc= $rowedi['pass'];
	                    if($passc==$edipass){
                            $sql = 'SELECT * FROM tbform WHERE id=:id AND pass=:pass';
                            $stmt = $pdo->prepare($sql);                  // ←差し替えるパラメータを含めて記述したSQLを準備し、
                            $stmt->bindParam(':id', $ediid, PDO::PARAM_INT); // ←その差し替えるパラメータの値を指定してから、
                            $stmt->bindParam(':pass', $edipass, PDO::PARAM_INT);
        	                $stmt->execute();                             // ←SQLを実行する。
                            $results = $stmt->fetchAll(); 
	                        foreach ($results as $rowedi2){
		                    //$rowの中にはテーブルのカラム名が入る
		                        $reedit = $rowedi2['id'];
		                        $rename = $rowedi2['name'];
                                $recomment = $rowedi2['comment'];
		                    }
    	                }else{
                            echo "パスワードが違います。<br>";
                        }
		            }
	            }
            }
        }
        ?>
        <form action = "" method="post">
            <!--入力フォーム-->
            <input type="hidden" name= "renum" value="<?php
            if(isset($reedit)) {
                echo $reedit;}
            ?>">
            <label type= "name">名前：</label>
            <input type="text" name= "nam" id ="name" value="<?php
            if(isset($rename)) {
                echo $rename;}
            ?>">
            <label type= "comment">コメント：</label>
            <input type="text" name= "com" id ="comment" value="<?php
            if(isset($recomment)) {
                echo $recomment;}
            ?>">
            <label type= "password">パスワード：</label>
            <input type="text" name= "pass" id ="password">
            <input type="submit" name= "submit" id="comment">
            <br>
            <!--削除フォーム-->
            <label type="del">削除対象番号：</label>
            <input type="number" name="num" id="del">
            <label type= "pass2">パスワード：</label>
            <input type="text" name= "delpass" id ="pass2">
            <input type="submit" name="delete" id="del" value="削除">
            <br>
            <!--編集フォーム-->
            <label type="edi">編集対象番号：</label>
            <input type="number" name="edit" id="edi">
            <label type= "pass2">パスワード：</label>
            <input type="text" name= "edipass" id ="pass2">
            <input type="submit" name="editer" id="edi" value="編集">
        </form>
        <?php
         //表示(たぶんOK)
	    $sql2 = 'SELECT * FROM tbform';
	    $stmt2 = $pdo->query($sql2);
	    $results2 = $stmt2->fetchAll();
	    foreach ($results2 as $row2){
		    //$rowの中にはテーブルのカラム名が入る
		    echo $row2['id'].',';
		    echo $row2['name'].',';
		    echo $row2['comment'].',';
		    echo $row2['date'].'<br>';
	    }
        ?>

    </body>
</html>