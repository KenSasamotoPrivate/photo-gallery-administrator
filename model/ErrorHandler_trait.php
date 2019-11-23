<?php
// require_once('config.php');
trait ErrorHandler {
    
    public $_errors;
    public $_values;

    private function ErrorHandlerinitialize() {
        $this->_errors = new stdClass();
        $this->_values = new stdClass();
    }

    function setErrors($key, $error){
        $this->_errors->$key = $error;
    }
    function getErrors($key){
        return isset($this->_errors->$key) ? $this->_errors->$key : '';
    }
    
    function setValues($key, $value) {
        $this->_values->$key = $value;
    }
    function getValues($key) {
        return isset($this->_values->$key) ? $this->_values->$key : '';
    }

    function hasErrors(){

        if(empty(get_object_vars($this->_errors))){
            return false;       
        } else {
            return true;
        }
    }
}
?>