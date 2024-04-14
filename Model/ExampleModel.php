<?php

    namespace Model;
    use Config\Database;

    class ExampleModel {
        private string $name;
        private string $email;
        private string $password;

        function __construct($body)
        {
            $this->name = $body["name"];   
            $this->email = $body["email"];   
            $this->password = $body["password"];
        }

        static function getById($idUser){
            $db = Database::instance();
            return $db->query("select * from users where id = '$idUser'")->fetch();
        }

        static function getByEmail($email){
            $db = Database::instance();
            return $db->query("select * from users where email = '$email'")->fetch();
        }

        static function getAll(){
            $db = Database::instance();
            return $db->query("SELECT * FROM users")->fetchAll();
        }

        function save(){
            $db = Database::instance();
            $user = self::getByEmail($this->email);
            if($user){
                $db->query("UPDATE USERS SET password = :password, nama = :name where email = :email",[
                    "password"=> $this->password,
                    "name"=>$this->name,
                    "email"=>$this->email
                ]);
            }
            else{
                $db->query("INSERT INTO USERS(email,password,nama) values(:email,:password,:name)",[
                    "password"=> $this->password,
                    "name"=>$this->name,
                    "email"=>$this->email
                ]);
            }
            return $this;
        }
    }
?>