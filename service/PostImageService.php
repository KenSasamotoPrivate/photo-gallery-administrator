<?php
//require_once('ImageService.php');
require_once('../model/UploadedData.php');

class PostImageService {
    
    private $pdo;
    public $uploadedData;

    public function __construct(){

        if($this->isLoggedIn() === false){
            header('Location: http://' . $_SERVER['HTTP_HOST'].'/controller/LoginController.php');          
            exit;
        }

        if(!isset($_SESSION['token'])) {
            $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(16));
        }

        $this->pdo = new PDO(DSN, user, pass);

        $this->$uploadedData = new UploadedData;

    }

    public function postProcess(){

        $_uploadedData = $this->$uploadedData;

        try {
            //$this->validate();
            $_uploadedData->validate();
        } catch(PDOException $e){
            echo("<p>500 Inertnal Server Error</p>");
            exit($e->getMessage());
        } catch(Exception $e){
            exit($e->getMessage());
        } 

        if($_uploadedData->hasErrors()){
            $_uploadedData->setValues(titleValue, $_uploadedData->title);
            
            return;
        } 
        
        $this->execute($_uploadedData);
    }

    private function execute($_uploadedData) {
        
        $this->pdo->beginTransaction();
        // echo 'execute'.'<br>';exit;
        $sql = "INSERT INTO media(title, posted_at, updated_at, extension, raw_data) VALUES 
        (:title, :posted_at, :updated_at, :extension, :raw_data);";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt -> bindValue(":title", $_uploadedData->title, PDO::PARAM_STR);
        $stmt -> bindValue(":posted_at", date("Y/m/d H:i:s"));
        $stmt -> bindValue(":updated_at", date("Y/m/d H:i:s"));
        $stmt -> bindValue(":extension", $_uploadedData->extension, PDO::PARAM_STR);
        $stmt -> bindValue(":raw_data", $_uploadedData->raw_data, PDO::PARAM_STR);
        $stmt -> execute();
        $this->pdo->commit();
        header('Location: http://' . $_SERVER['HTTP_HOST'].'/controller/IndexController.php');
    }

    protected function isLoggedIn(){
        return isset($_SESSION['me']) && !empty($_SESSION['me']);
    }
}

?>