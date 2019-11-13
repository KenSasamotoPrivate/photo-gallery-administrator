<?php
require_once('ImageService.php');

class GetImageService extends ImageService {

    public function findAll(){
        
        $sql = "SELECT * FROM media ORDER BY id desc;";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById() {
        $sql = "SELECT * FROM media WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        
        $stmt -> bindValue(":id", $_GET['id'], PDO::PARAM_INT);
        $stmt -> execute();
        
        $result = $stmt -> fetch(PDO::FETCH_ASSOC);
        
        if(empty($result)){        
            header('Location: http://' . $_SERVER['HTTP_HOST'].'/controller/IndexController.php'); 
        }
        
        return $result;
    }

}
?>