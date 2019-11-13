<?php
// require_once('config.php');
trait ErrorHandler {
    
    protected $_errors;
    protected $_values;

    private function ErrorHandlerinitialize() {
        $this->_errors = new stdClass();
        $this->_values = new stdClass();
    }

    protected function setErrors($key, $error){
        $this->_errors->$key = $error;
    }
    public function getErrors($key){
        return isset($this->_errors->$key) ? $this->_errors->$key : '';
    }
    
    protected function setValues($key, $value) {
        $this->_values->$key = $value;
    }
    public function getValues($key) {
        return isset($this->_values->$key) ? $this->_values->$key : '';
    }

    protected function hasErrors(){

        if(empty(get_object_vars($this->_errors))){
            return false;       
        } else {
            return true;
        }
    }
    
    // protected function isLoggedIn(){
    //     return isset($_SESSION['me']) && !empty($_SESSION['me']);
    // }
}
?>