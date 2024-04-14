<?php

namespace Model;

use Config\Database;

class Kelompok
{

    private string $id;
    private string $nama;
    
    function __construct($id, $nama)
    {
        $this->id = $id;
        $this->nama = $nama;
    }

    public static function getAll()
    {
        $db = Database::instance();
        return $db->query("SELECT * FROM kelompok")->fetchAll();
    }
}