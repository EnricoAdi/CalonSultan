<?php
namespace Model;

use Config\Database;

class Artikel {
    static function getAll(){
        $db = Database::instance();
        return $db->query("SELECT * FROM artikel")->fetchAll();
    }

    static function getRecent3(){
        $db = Database::instance();
        return $db->query("SELECT * FROM artikel ORDER BY tanggal_rilis DESC LIMIT 3")->fetchAll();
    }

    static function getById($id){
        $db = Database::instance();
        return $db->query("SELECT * FROM artikel WHERE id = $id")->fetch();
    }

    static function deleteById($id){
        $db = Database::instance();
        return $db->query("DELETE FROM artikel WHERE id = $id")->fetch();
    }
}