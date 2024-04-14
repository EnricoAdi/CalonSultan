<?php

namespace Model;

use Config\Database;

class Kategori
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
        return $db->query("SELECT * FROM kategori")->fetchAll();
    }

    public static function getByPemasukanUserDate($bln, $email)
    {
        $db = Database::instance();
        return $db->query("SELECT DISTINCT K.NAMA FROM PEMASUKAN P, KATEGORI K WHERE P.ID_KATEGORI = K.ID AND DATE_FORMAT(P.TANGGAL, '%Y%m') = :bln AND P.EMAIL_USER = :email", ["bln"=>$bln, "email"=>$email])->fetchAll();
    }

    public static function getByPengeluaranUserDate($bln, $email)
    {
        $db = Database::instance();
        return $db->query("SELECT DISTINCT K.NAMA FROM PENGELUARAN P, KATEGORI K WHERE P.ID_KATEGORI = K.ID AND DATE_FORMAT(P.TANGGAL, '%Y%m') = :bln AND P.EMAIL_USER = :email", ["bln"=>$bln, "email"=>$email])->fetchAll();
    }

    public static function getKategoriPemasukan(){
        $db = Database::instance();
        return $db->query("Select * from kategori where tipe = '0'")->fetchAll();
    }

    public static function getKategoriPengeluaran($kelompok = -1){
        $db = Database::instance();
        if($kelompok == -1){
            return $db->query("Select * from kategori where tipe = '1'")->fetchAll();
        }else{
            return $db->query("Select * from kategori where tipe = '1' AND id_kelompok = '$kelompok'")->fetchAll();
        }
    }

    public static function getKelompokByKategori($kategori){
        $db = Database::instance();
        return $db->query("select id_kelompok from kategori where id = '$kategori'")->fetch()["id_kelompok"];
    }
}