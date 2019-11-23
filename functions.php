<?php
function h($s){
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}
function isLoggedIn(){
    return isset($_SESSION['me']) && !empty($_SESSION['me']);
}
?>