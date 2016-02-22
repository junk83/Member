<?php

class Member{

    //プロパティ宣言
    private $name = ''; //名前
    private $age = ''; //年齢
    private $email = ''; //メールアドレス
    private $dbh = ''; //dbハンドラ


    //コンストラクタ（インスタンス生成時にDB接続）
    public function __construct(){
        //DB接続情報
        define('DSN', 'mysql:host=localhost;dbname=homework;charset=utf8');
        define('USER', 'root');
        define('PASSWORD', 'root');

        //DB接続
        try{
            $this->dbh = new PDO(DSN, USER, PASSWORD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        }
        catch(PDOException $e){
            throw $e;
        }
     }

    //データセットメソッド
    public function set($data){
        $this->name = $data['name'];
        $this->age = $data['age'];
        $this->email = $data['email'];
    }

    //データ挿入メソッド
    public function insert(){
        try{
            $sql = "insert into members(name, age, email, created_at) values
                    (:name, :age, :email, now())";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":age", $this->age);
            $stmt->bindParam(":email", $this->email);
            $stmt->execute();
        }catch(PDOException $e){
            return false;
        }

        return true;

    }

    //データ検索メソッド
    public function findByEmail($email){
        try{
            $sql = "select * from  members where email = :email";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindParam(":email", $email);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            //データがヒットしない場合はfalseを返す
            if(!$result){
                return false;
            }
        }catch(PDOException $e){
            return false;
        }

        return $result;

    }

    //データ削除メソッド
    public function delete($id){
        //データがすでに削除されていないかチェック
        try{
            $sql = "select id from members where id = :id";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            $result = $stmt->fetch();

            //データがすでに削除されている場合はfalseを返す
            if(!$result){
                return false;
            }

        }catch(PDOException $e){
            return false;
        }

        //データの削除を実施
        try{
            $sql = "delete from members where id = :id";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindParam(":id", $id);
            $stmt->execute();

        }catch(PDOException $e){
            return false;
        }

        return true;
    }
}
