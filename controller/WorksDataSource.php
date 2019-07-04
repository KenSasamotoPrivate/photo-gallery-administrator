<?php
require_once(__DIR__.'/../Controller.php');

class WorksDataSource extends Controller {
    
    public function findAll(){
        $sql = "SELECT * FROM media ORDER BY id desc;";
        $stmt = $this->pdo->prepare($sql);
        $stmt -> execute();
        //$records = $stmt -> fetchAll(PDO::FETCH_ASSOC);
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
    }

}

?>