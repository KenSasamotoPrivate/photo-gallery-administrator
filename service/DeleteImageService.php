<?php
require_once('ImageServiceParent.php');

class DeleteImageService extends ImageServiceParent {
        
    public function delete() {
        $sql = "DELETE FROM media WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":id", $_POST['id'], PDO::PARAM_INT);
        $stmt->execute();
    }

}

?>