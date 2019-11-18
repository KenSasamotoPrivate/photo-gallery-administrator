<?php
//require_once('../config.php');
require_once('../ErrorHandler_trait.php');

class UploadedData {

    use ErrorHandler;
    
    //protected $pdo;
    
    public $title;
    public $extension;
    public $raw_data;

    public function __construct(){

        $this->ErrorHandlerinitialize();
/*
        if($this->isLoggedIn() === false){
            header('Location: http://' . $_SERVER['HTTP_HOST'].'/controller/LoginController.php');          
            exit;
        }

        if(!isset($_SESSION['token'])) {
            $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(16));
        }

        $this->pdo = new PDO(DSN, user, pass);
*/
    } 

    public function validate() {

        if($this->isMaxSizeOver()) return;

        $this->tokenCheck();

        $this->setTitle();
        
        if ($this->isFileUploaded()){
            
            if($this->isfileHasError()) return;

            //バイナリデータにする
            $this->raw_data = file_get_contents($_FILES['upfile']['tmp_name']);
            $this->setExtension();
            return;                 
        }

        if($_POST['mode'] !== 'edit'){            
            $this->setErrors(fileError,'ファイルが選択されていません。');
            return;
        }
    }

    private function isfileHasError(){
        if($_FILES['upfile']['error'] === UPLOAD_ERR_OK){            
            return false;
        }
        $this->setErrors(fileError,'ファイルをアップロード出来ません');
        return true;
    }

    private function isMaxSizeOver(){
        if( post_max_size < $_SERVER["CONTENT_LENGTH"] ) {            
            $this->setErrors(fileError,'ファイルサイズが大きすぎます。');
            return true;
        } 
        return false;
    }

    private function tokenCheck(){
        if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
            echo "token error";
            exit;
        }
    }

    private function setTitle(){
        $posted_title = str_replace(array(" ","　"),"",$_POST['title']);

        if(isset($posted_title) && $posted_title !== ''){
            $this->title = $posted_title;
        } else {
            $this->setErrors(titleError,'タイトルを入力してください。');
        }
    }

    private function isFileUploaded(){
        if(isset($_FILES['upfile']['error']) && is_int($_FILES['upfile']['error']) && $_FILES["upfile"]["name"] !== ""){
            return true;
        } 
        return false;
    }

    private function setExtension() {
        if(in_array($_FILES["upfile"]["type"], EXTENSIONS)){
            $this->extension = $_FILES["upfile"]["type"];
        } else {
            $this->setErrors(fileError,'非対応ファイルです');
            return;
        }  
    }
}
?>