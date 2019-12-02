<?php
require_once('../model/ErrorHandler_trait.php');

class UploadedData {

    use ErrorHandler;
    
    public $title;
    public $extension;
    public $raw_data;

    public $comment;

    public function __construct(){
        $this->ErrorHandlerinitialize();
    } 

    public function validate() {
        /*
        var_dump($_POST['comment']);
        exit;
         */

        if($this->isMaxSizeOver())
        return;
        $this->tokenCheck();

        $this->setTitle();

        $this->setComment();
        
        if ($this->isFileUploaded()){
            if($this->isfileHasError())
            return;
            $this->raw_data = file_get_contents($_FILES['upfile']['tmp_name']);
            $this->setExtension();              
        }

    }

    private function isfileHasError(){
        if($_FILES['upfile']['error'] === UPLOAD_ERR_OK){            
            return false;
        }
        $this->setErrors('fileError','ファイルをアップロード出来ません');
        return true;
    }

    private function isMaxSizeOver(){   
        if( $_SERVER["CONTENT_LENGTH"] < post_max_size  )
        return false;          
        
        $this->setErrors('fileError','ファイルサイズが大きすぎます。');
        return true;
        
    }

    private function tokenCheck(){
        if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
            echo "token error";
            exit;
        }
    }

    private function setTitle(){
        $posted_title = str_replace(array(" ","　"),"",$_POST['title']);

        if(!isset($posted_title) || $posted_title == ''){
            $this->setErrors('titleError','タイトルを入力してください。'); 
            return;
        } 

        $this->title = $posted_title;

        if(40 < mb_strlen($_POST['title'])){
            $this->setErrors('titleError','40文字以内で入力してください。');
        }
    }

    private function setComment(){
        $posted_comment = str_replace(array(" ","　"),"", $_POST['comment']);
        
        if(!isset($posted_comment) || $posted_comment == ''){
            return;
        } 

        $this->comment = $posted_comment;

        if(100 < mb_strlen($posted_comment)){
            $this->setErrors('commentError','100文字以内で入力してください。');
            return;
        }  
    } 

    private function isFileUploaded(){
        if(isset($_FILES['upfile']['error']) && is_int($_FILES['upfile']['error']) && $_FILES["upfile"]["name"] !== ""){
            return true;
        } 
        if($_POST['mode'] === 'edit')
        return;
        $this->setErrors('fileError','ファイルが選択されていません。'); 
        return false;
    }

    private function setExtension() {
        if(in_array($_FILES["upfile"]["type"], EXTENSIONS)){
            $this->extension = $_FILES["upfile"]["type"];
            return;
        } 
        $this->setErrors('fileError','非対応ファイルです');
    }
}
?>