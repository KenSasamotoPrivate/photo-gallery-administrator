<?php
class PublishingSettingsService {
    
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

    public function stateUpdate() {

        $this->pdo->beginTransaction();
        
        // check status
        //$status =  $this->getStatus()
        $sql ="SELECT status FROM media WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt -> bindValue(":id", $_POST['id'], PDO::PARAM_INT);
        $stmt -> execute();
        $status =  $stmt->fetchColumn();

        /* update */
        if($status === 'public') {
            $sql = "UPDATE media SET status = 'private' WHERE id = :id";
            //$sql = sprintf("UPDATE media SET status = 'private' WHERE id = %d", $_POST['id']);
        }
        if($status === 'private'){
            $sql = "UPDATE media SET status = 'public' WHERE id = :id";
            //$sql = sprintf("UPDATE media SET status = 'public' WHERE id = %d", $_POST['id']);
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt -> bindValue(":id", $_POST['id'], PDO::PARAM_INT);
        $stmt -> execute();
        
        // return status
        $sql = "SELECT status FROM media WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt -> bindValue(":id", $_POST['id'], PDO::PARAM_INT);
        $stmt -> execute();
        $status = $stmt -> fetchColumn();

        $this->pdo->commit();

        return ['status' => $status];
        
    }

    protected function isLoggedIn(){
        return isset($_SESSION['me']) && !empty($_SESSION['me']);
    }

}

?>
