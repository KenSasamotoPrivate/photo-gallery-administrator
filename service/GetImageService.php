<?php
require_once('ImageServiceParent.php');
require_once('../model/UploadedData.php');

class GetImageService extends ImageServiceParent  {

    public function findAll($current){
    
        $offsetNum = $this->getOffsetNum($current);
    
        $sql = "SELECT * FROM media ORDER BY id desc LIMIT 10 OFFSET $offsetNum";
        $stmt = $this->pdo->prepare($sql);
        $stmt -> execute();
        return $stmt -> fetchAll(PDO::FETCH_OBJ);
    }

    public function findById($id) {

        $sql = "SELECT * FROM media WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);        
        $stmt -> bindValue(":id", $id, PDO::PARAM_INT);
        $stmt -> execute();
        
        $result = $stmt -> fetch(PDO::FETCH_OBJ);

        if(empty($result)){        
            header('Location: http://' . $_SERVER['HTTP_HOST'].'/controller/IndexController.php'); 
        }        
        return $result;
    }
    
    public function getTotalNumber(){        
        $sql = "SELECT COUNT(title) FROM media";
    
        $stmt = $this->pdo->prepare($sql);
        $stmt -> execute();
        $result = $stmt -> fetch(PDO::FETCH_ASSOC);  
        return $result;
    }
    
    private function getOffsetNum($current){
        if($current == 1){
            return 0;
        } 
        $current = $current -1;
        return $current * 10;
    }
}
?>