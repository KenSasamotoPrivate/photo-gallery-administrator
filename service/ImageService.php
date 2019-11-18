<?php
require_once('../config.php');
require_once('../ErrorHandler_trait.php');

class ImageService {
    
    protected $pdo;

    public function __construct(){

        $this->ErrorHandlerinitialize();

        if($this->isLoggedIn() === false){
            header('Location: http://' . $_SERVER['HTTP_HOST'].'/controller/LoginController.php');          
            exit;
        }

        if(!isset($_SESSION['token'])) {
            $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(16));
        }

        $this->pdo = new PDO(DSN, user, pass);
    } 
    
    protected function isLoggedIn(){
        return isset($_SESSION['me']) && !empty($_SESSION['me']);
    }
}
?>