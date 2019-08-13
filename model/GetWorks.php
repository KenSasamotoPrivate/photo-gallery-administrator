<?php
require_once('Model.php');

class GetWorks extends Model {

    public function findAll(){
        $sql = "SELECT * FROM media ORDER BY id desc;";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
    }

}
?>