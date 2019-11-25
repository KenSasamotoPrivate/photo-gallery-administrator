<?php
require_once('ImageServiceParent.php');
require_once('../model/UploadedData.php');

class EditImageService extends ImageServiceParent {
    
    public $uploadedData;

    public function __construct(){
        parent::__construct();
        $this->$uploadedData = new UploadedData;
    }

    public function editProcess(){
        
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
        } else {
            $this->editExecute($_uploadedData);
        }
    }

    private function editExecute($_uploadedData) {
        
        if($_FILES["upfile"]["name"] === ""){
            $sql = "UPDATE media SET title = :title, updated_at = :updated_at WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
        } else {
            $sql = "UPDATE media SET title = :title, updated_at = :updated_at, extension = :extension, raw_data = :raw_data WHERE id = :id";
            
            $stmt = $this->pdo->prepare($sql);
    
            $stmt -> bindValue(":extension", $_uploadedData->extension, PDO::PARAM_STR);
            $stmt -> bindValue(":raw_data", $_uploadedData->raw_data, PDO::PARAM_STR);
    
        }
        
        $stmt -> bindValue(":title", $_uploadedData->title, PDO::PARAM_STR);
        $stmt -> bindValue(":updated_at", date("Y/m/d H:i:s"));

        $stmt -> bindValue(":id", $_GET['id'], PDO::PARAM_INT);
        
        $stmt -> execute();

        header('Location: http://' . $_SERVER['HTTP_HOST'].'/view/edit_complete.php');

    }

}
?>