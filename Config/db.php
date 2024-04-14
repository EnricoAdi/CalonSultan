<?php
    namespace Config;
    use PDO;
    use PDOException;
    
    include_once("dbinfo.php");

    class Database {
        private static $instance;
        private $db;
        
        private function __construct()
        {
            $opt = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            try {
                $this->db = new PDO("mysql:dbname=".DB_NAME.";host=".DB_HOST.";port=".DB_PORT.";charset=utf8mb4",DB_USER,DB_PASS,$opt);
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }

        static function instance(){
            if(!isset(self::$instance)){
                self::$instance = new Database();
            }
            return self::$instance;
        }

        function query($sql,$args = NULL){
            if (!$args){
                return $this->db->query($sql);
            }
            $stmt = $this->db->prepare($sql);
            $stmt->execute($args);
            return $stmt;
        }
    }
?>