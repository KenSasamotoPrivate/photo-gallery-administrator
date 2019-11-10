<?php

//namespace MyApp\Controller;

require_once('../config.php');
require_once('../model/Model.php');
require_once('../model/User.php');

class Login extends Model {
  
  // private $_errors;
  // private $_values;

  public function __construct() {
    
    if(!isset($_SESSION['token'])) {
      $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(16));
    }
    // $this->_errors = new \stdClass();
    // $this->_values = new \stdClass();

  }

  public function run() {
    //ログイン中ならTOPにリダイレクト
    if ($this->isLoggedIn()) {
      header('Location: http://' . $_SERVER['HTTP_HOST'].'/controller/IndexController.php');
      exit;
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $this->postProcess();
    }

  }

  protected function postProcess() {
    try {
      $this->_validate();

    } catch (Exception $e) {
        $this->setErrors('login', "IDまたはパスワードが空です。");
        return;
    } 

    $this->setValues(email, $_POST['email']);

    if($this->hasErrors()){
      return;
    } else {
      try {

        $userModel = new User();

        $user =$userModel->login([
          'email' => $_POST['email'],
          'password' => $_POST['password']
        ]);
     
      } catch(Exception $e){
        $this->setErrors('login', "IDもしくはパスワードが一致しません。");
        return;
      }

      session_regenerate_id(true);
      $_SESSION['me'] = $user;

      // redirect to Top
      header('Location: http://' . $_SERVER['HTTP_HOST'].'/controller/IndexController.php');
      exit;
    }
  }

  private function _validate() {
    if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
      echo "Invalid Token!";
      exit;
    }

    if (!isset($_POST['email']) || !isset($_POST['password'])) {
      echo "Invalid Form!";
      exit;
    }

    if ($_POST['email'] === '' || $_POST['password'] === '') {
      throw new Exception();
    }
  }
  /*
  protected function setValues($key, $value) {
    $this->_values->$key = $value;
  }

  public function getValues() {
    return $this->_values;
  }

  protected function setErrors($key, $error) {
    $this->_errors->$key = $error;
  }

  public function getErrors($key) {
    return isset($this->_errors->$key) ? $this->_errors->$key : '';
  }

  private function hasErrors() {
    return !empty(get_object_vars($this->_errors));
  }

  private function isLoggedIn(){
    //$userModel->login() ログイン結果が入っているか
    return isset($_SESSION['me']) && !empty($_SESSION['me']);
  }
   */

}