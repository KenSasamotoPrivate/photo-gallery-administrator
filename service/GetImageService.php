<?php
require_once('../model/UploadedData.php');

class GetImageService {
    
    private $pdo;

    public function __construct(){

        if($this->isLoggedIn() === false){
            header('Location: http://' . $_SERVER['HTTP_HOST'].'/controller/LoginController.php');          
            exit;
        }

        if(!isset($_SESSION['token'])) {
            $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(16));
        }

        $this->pdo = new PDO(DSN, user, pass);

    }
    
    public function findAll(){
        
        $sql = "SELECT * FROM media ORDER BY id desc;";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        // return $stmt -> fetchAll(PDO::FETCH_CLASS,'ExportData');
        return $stmt -> fetchAll(PDO::FETCH_OBJ);
    }

    public function findById($id) {

        $sql = "SELECT * FROM media WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        
        $stmt -> bindValue(":id", $id, PDO::PARAM_INT);
        $stmt -> execute();
        // $result = $stmt -> fetch(PDO::FETCH_CLASS,'ExportData');        
        $result = $stmt -> fetch(PDO::FETCH_OBJ);

        if(empty($result)){        
            header('Location: http://' . $_SERVER['HTTP_HOST'].'/controller/IndexController.php'); 
        }
        
        return $result;
    }

    protected function isLoggedIn(){
        return isset($_SESSION['me']) && !empty($_SESSION['me']);
    }

}
?>