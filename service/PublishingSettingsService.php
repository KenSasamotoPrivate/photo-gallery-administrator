<?php
require_once('ImageServiceParent.php');

class PublishingSettingsService extends ImageServiceParent {

    public function statusUpdate() {

        $this->pdo->beginTransaction();
        $status_before = $this->getStatus();
        
        $status = 'public';
        
        if($status_before === 'public') {
            $status = 'private';
        }

        $sql = "UPDATE media SET status = '$status' WHERE id = :id";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt -> bindValue(":id", $_POST['id'], PDO::PARAM_INT);
        $stmt -> execute();
        
        $status_after = $this->getStatus();
        $this->pdo->commit();
        return ['status' => $status_after];    
    }

    private function getStatus(){
        $sql ="SELECT status FROM media WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt -> bindValue(":id", $_POST['id'], PDO::PARAM_INT);
        $stmt -> execute();
        return $stmt->fetchColumn();        
    }
    /*
    private function sqlExecute($sql){
        $stmt = $this->pdo->prepare($sql);
        $stmt -> bindValue(":id", $_POST['id'], PDO::PARAM_INT);
        $stmt -> execute();
    }
     */

}
?>
