<?php
// require_once(__DIR__.'/../Controller.php');
require_once('Controller.php');
require_once('config.php');
class EditController extends Controller {

    public function editProcess(){

        if($_SERVER['REQUEST_METHOD']==='POST'){
            
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

        return $this->findById();
        
    }

    private function findById() {
        $sql = "SELECT * FROM media WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        
        $stmt -> bindValue(":id", $_GET['id'], PDO::PARAM_INT);
        $stmt -> execute();
        
        return $stmt -> fetch(PDO::FETCH_ASSOC);

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
            $sql = "UPDATE media SET title = :title, updated_at = :updated_at, fname = :fname, extension = :extension, raw_data = :raw_data WHERE id = :id";
            
            $stmt = $this->pdo->prepare($sql);
    
            $stmt -> bindValue(":fname",$this->fname, PDO::PARAM_STR);
            $stmt -> bindValue(":extension",$this->extension, PDO::PARAM_STR);
            $stmt -> bindValue(":raw_data",$this->raw_data, PDO::PARAM_STR);
    
        }
        
        $stmt -> bindValue(":title", $this->title, PDO::PARAM_STR);
        $stmt -> bindValue(":updated_at", date("Y/m/d H:i:s"));

        $stmt -> bindValue(":id", $_GET['id'], PDO::PARAM_INT);
        
        $stmt -> execute();

        header('Location: http://' . $_SERVER['HTTP_HOST'].'/edit_complete.php');

    }

}
?>