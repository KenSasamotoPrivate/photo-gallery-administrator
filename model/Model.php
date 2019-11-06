<?php
require_once('config.php');
class Model {
    
    protected $_errors;
    protected $_values;
    protected $pdo;

    protected $title;
    protected $fname;
    protected $extension;
    protected $raw_data;

    public function __construct(){

        if($this->isLoggedIn() === false){
            header('Location: http://' . $_SERVER['HTTP_HOST'].'/login.php');            
            exit;
        }

        if(!isset($_SESSION['token'])) {
            $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(16));
        }
        $this->_errors = new stdClass();
        $this->_values = new stdClass();
        $this->pdo = new PDO(DSN, user, pass);
    } 

    protected function setValues($key, $value) {
        $this->_values->$key = $value;
    }
    public function getValues($key) {
        return isset($this->_values->$key) ? $this->_values->$key : '';
    }

    protected function setErrors($key, $error){
        $this->_errors->$key = $error;
    }
    public function getErrors($key){
        return isset($this->_errors->$key) ? $this->_errors->$key : '';
    }

    protected function hasErrors(){
        /* return empty(get_object_vars($this->_errors)) === false;*/
        if(empty(get_object_vars($this->_errors))){
            return false;       
        } else {
            return true;
        }
    }

    protected function validate() {
        if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
            echo "token error!";
            exit;
        }
    
        $this->title = str_replace(array(" ","　"),"",$_POST['title']);

        
        if(!isset($this->title) || $this->title === ''){
            $this->setErrors(titleError,'タイトルを入力してください');
        }
        
        if (isset($_FILES['upfile']['error']) && is_int($_FILES['upfile']['error']) && $_FILES["upfile"]["name"] !== ""){
            
            switch ($_FILES['upfile']['error']) {
                case UPLOAD_ERR_OK: // OK
                    break;
                case UPLOAD_ERR_NO_FILE:   // 未選択
                    throw new RuntimeException('ファイルが選択されていません', 400);
                case UPLOAD_ERR_INI_SIZE:  // php.ini定義の最大サイズ超過
                    throw new RuntimeException('ファイルサイズが大きすぎます', 400);
                default:
                    throw new RuntimeException('その他のエラーが発生しました', 500);
            }
      
            //画像・動画をバイナリデータにする．
            $this->raw_data = file_get_contents($_FILES['upfile']['tmp_name']);

            //拡張子を見る pathinfo関数
            $tmp = pathinfo($_FILES["upfile"]["name"]);
            $extension = $tmp["extension"];
            
            if($extension === "jpg" || $extension === "jpeg" || $extension === "JPG" || $extension === "JPEG"){
                $this->extension = "jpeg";
            }
            elseif($extension === "png" || $extension === "PNG"){
                $this->extension = "png";
            }
            elseif($extension === "gif" || $extension === "GIF"){
                $this->extension = "gif";
            }
            elseif($extension === "mp4" || $extension === "MP4"){
                $this->extension = "mp4";
            }
            else{
                echo "非対応ファイルです．<br/>";
                echo ("<a href=\"IndexController.php\">戻る</a><br/>");
                exit(1);
            }
      
            //DBに格納するファイルネーム設定
            //サーバー側の一時的なファイルネームと取得時刻を結合した文字列にsha256をかける．
            $date = getdate();
            $fname = $_FILES["upfile"]["tmp_name"].$date["year"].$date["mon"].$date["mday"].$date["hours"].$date["minutes"].$date["seconds"];
            $this->fname = hash("sha256", $fname);
            return;
        }
        //ファイル選択がない
            //新規投稿のとき ->　エラーをセットする
            //編集のとき -> エラーをセットしない
        if($_POST['mode'] !== 'edit'){
            $this->setErrors(fileError,'ファイルを選択してください');
        }
        
    }
    
    protected function isLoggedIn(){
        return isset($_SESSION['me']) && !empty($_SESSION['me']);
    }
}
?>