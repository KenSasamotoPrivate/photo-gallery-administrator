<?php
require_once('config.php');
class User {
    protected $db;

    public function __construct() {
        try {
            $this->db = new PDO(DSN_LOGIN_TABLE, user, pass);
        } catch (PDOExecption $e){
            echo $e->getMessage();
            exit;
        }
        
    }  
    /* Sing Up 
    public function create($values) {
        $stmt = $this->db->prepare("INSERT INTO users(email, password, created, modified) VALUES(:email, :password, now(), now())");

        $res = $stmt->execute([
            ':email' => $values['email'],
            ':password' => password_hash($values['password'], PASSWORD_DEFAULT)
        ]);
        if($res === false) {
            throw new \MyApp\Exception\DuplicateEmail();
        }
    }*/

    /* login */
    public function login($values) {

        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");

        $stmt->execute([
            ':email' => $values['email']
        ]);
        
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'stdClass');
        $user = $stmt->fetch();

        if(empty($user)) {
            throw new Exception();
        }

        if(!password_verify($values['password'], $user->password)) {
            throw new Exception();
        }
        
        //Login.phpで$_SESSION['me']に格納するためにreturn
        return $user;

    }

    /*
    public function findAll() {

        $stmt = $this->db->query("SELECT * FROM users ORDER BY id DESC");

        $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
        
        return $stmt->fetchAll();

    }
    */

}

?>