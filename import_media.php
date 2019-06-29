<?php
    require_once('config.php');
    
    if(isset($_GET["id"]) && $_GET["id"] !== ""){
        $id = $_GET["id"];
    }
    else{
        header("Location: index.php");
    }
    $MIMETypes = array(
        'png' => 'image/png',
        'jpeg' => 'image/jpeg',
        'gif' => 'image/gif',
        'mp4' => 'video/mp4'
    );
    try {
        $pdo = new PDO(DSN, user, pass);
        // $user = "points-and-lines";
        // $pass = "sasamotoken1957";
        // $pdo = new PDO("mysql:host=mysql719.db.sakura.ne.jp;dbname=points-and-lines_mediatest;charset=utf8", $user, $pass);
        $sql = "SELECT * FROM media WHERE id = :id;";
        $stmt = $pdo->prepare($sql);
        $stmt -> bindValue(":id", $id, PDO::PARAM_INT);
        $stmt -> execute();
        $row = $stmt -> fetch(PDO::FETCH_ASSOC);
        header("Content-Type: ".$MIMETypes[$row["extension"]]);
        echo ($row["raw_data"]);
    }
    catch (PDOException $e) {
        echo("<p>500 Inertnal Server Error</p>");
        exit($e->getMessage());
    }
?>