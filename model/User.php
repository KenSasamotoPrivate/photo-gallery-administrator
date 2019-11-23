<?php
class User {
    protected $db;

    public function __construct() {
        try {
            $this->db = new PDO(DSN, user, pass);
        } catch (PDOExecption $e){
            echo $e->getMessage();
            exit;
        }
    }  

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
    
}

?>