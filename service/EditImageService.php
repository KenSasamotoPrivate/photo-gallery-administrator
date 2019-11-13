<?php
require_once('ImageService.php');

class EditImageService extends ImageService {
        
    public function editProcess(){
        
        try {
            $this->validate();
            
        } catch(PDOException $e){
            echo("<p>500 Inertnal Server Error</p>");
            exit($e->getMessage());
        }
        
        if($this->hasErrors()){
            $this->setValues(titleValue, $this->title);
        } else { /* エラーがない場合 */
            $this->editExecute();
        }
    }

    private function editExecute() {

        //!is_int($_FILES['upfile']['error']
        
        if($_FILES["upfile"]["name"] === ""){
            // echo 'edit title only' ;
            // exit;
            $sql = "UPDATE media SET title = :title, updated_at = :updated_at WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
        } else {
            // echo 'edit file title';
            // exit;
            $sql = "UPDATE media SET title = :title, updated_at = :updated_at, extension = :extension, raw_data = :raw_data WHERE id = :id";
            
            $stmt = $this->pdo->prepare($sql);
    
            $stmt -> bindValue(":extension",$this->extension, PDO::PARAM_STR);
            $stmt -> bindValue(":raw_data",$this->raw_data, PDO::PARAM_STR);
    
        }
        
        $stmt -> bindValue(":title", $this->title, PDO::PARAM_STR);
        $stmt -> bindValue(":updated_at", date("Y/m/d H:i:s"));

        $stmt -> bindValue(":id", $_GET['id'], PDO::PARAM_INT);
        
        $stmt -> execute();

        header('Location: http://' . $_SERVER['HTTP_HOST'].'/view/edit_complete.php');

    }

}
?>