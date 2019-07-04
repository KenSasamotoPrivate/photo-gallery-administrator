<?php
require_once(__DIR__.'/../Controller.php');
require_once('config.php');
class WorksDataSource extends Controller {

    public function run() {       

        //adminでPOSTリクエストしたとき（リクエスト先はadmin自身）
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $this->postProcess();
        }
        return $this->findAll();

    }

    private function postProcess(){
        try {
            $this->validate();
            
        } catch(PDOException $e){
            echo("<p>500 Inertnal Server Error</p>");
            exit($e->getMessage());
        }

        if($this->hasErrors()){
            $this->setValues(titleValue, $this->title);
            return;
        } else { /* エラーがない場合 */
            $this->create();
        }
    }

    private function findAll(){
        $sql = "SELECT * FROM media ORDER BY id desc;";
        $stmt = $this->pdo->prepare($sql);
        $stmt -> execute();
        //$records = $stmt -> fetchAll(PDO::FETCH_ASSOC);
        return $stmt -> fetchAll(PDO::FETCH_ASSOC);
    }

    private function create() {
        $this->pdo->beginTransaction();
        // echo 'execute'.'<br>';exit;
        $sql = "INSERT INTO media(title, posted_at, updated_at, fname, extension, raw_data) VALUES 
        (:title, :posted_at, :updated_at, :fname, :extension, :raw_data);";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt -> bindValue(":title",$this->title, PDO::PARAM_STR);
        $stmt -> bindValue(":posted_at",date("Y/m/d H:i:s"));
        $stmt -> bindValue(":updated_at",date("Y/m/d H:i:s"));
        $stmt -> bindValue(":fname",$this->fname, PDO::PARAM_STR);
        $stmt -> bindValue(":extension",$this->extension, PDO::PARAM_STR);
        $stmt -> bindValue(":raw_data",$this->raw_data, PDO::PARAM_STR);
        $stmt -> execute();
        $this->pdo->commit();

        //session_destroy();
        header('Location: http://' . $_SERVER['HTTP_HOST'].'/admin.php');
    }

/*
    private function isLoggedIn(){
        return isset($_SESSION['me']) && !empty($_SESSION['me']);
    } 
     */
}

?>