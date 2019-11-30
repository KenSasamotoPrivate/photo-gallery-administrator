<?php
require_once('ImageServiceParent.php');
require_once('../model/UploadedData.php');

class PostImageService extends ImageServiceParent {

    public $uploadedData;

    public function __construct(){
        parent::__construct();
        $this->$uploadedData = new UploadedData;
    }

    public function postProcess(){

        $_uploadedData = $this->$uploadedData;

        try {
            $_uploadedData->validate();
        } catch(PDOException $e){
            echo("<p>500 Inertnal Server Error</p>");
            exit($e->getMessage());
        } catch(Exception $e){
            exit($e->getMessage());
        } 

        if($_uploadedData->hasErrors()){
            $_uploadedData->setValues(titleValue, $_uploadedData->title);
            $_uploadedData->setValues(commentValue, $_uploadedData->comment);
            return;
        } 
        
        $this->execute($_uploadedData);
    }

    private function execute($_uploadedData) {

        $this->pdo->beginTransaction();
        
        $sql = "INSERT INTO media(title, comment, posted_at, updated_at, extension, raw_data) VALUES 
        (:title, :comment, :posted_at, :updated_at, :extension, :raw_data);";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt -> bindValue(":title", $_uploadedData->title, PDO::PARAM_STR);
        
        $stmt -> bindValue(":comment", $_uploadedData->comment, PDO::PARAM_STR);
        
        $stmt -> bindValue(":posted_at", date("Y/m/d H:i:s"));
        $stmt -> bindValue(":updated_at", date("Y/m/d H:i:s"));
        $stmt -> bindValue(":extension", $_uploadedData->extension, PDO::PARAM_STR);
        $stmt -> bindValue(":raw_data", $_uploadedData->raw_data, PDO::PARAM_STR);
        $stmt -> execute();
        $this->pdo->commit();
        header('Location: http://' . $_SERVER['HTTP_HOST'].'/controller/IndexController.php');
    }

}

?>