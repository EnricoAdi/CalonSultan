<?php
namespace Model;

use Config\Database;
use Exception;

// require("Utils/date.php");

class Pemasukan
{

    private string $id;
    private string $email_user;
    private string $jumlah;
    private string $tanggal;
    private string $id_kategori;
    private string $note;
    
    function __construct($id = -1, $email_user, $jumlah, $tanggal, $id_kategori, $note)
    {
        $this->id = $id;
        $this->email_user = $email_user;
        $this->jumlah = $jumlah;
        $this->tanggal = $tanggal;
        $this->id_kategori = $id_kategori;
        $this->note = $note;
    }

    function save()
    {
        $db = Database::instance();
        try {
            $db->query("INSERT INTO pemasukan(email_user, jumlah, tanggal, id_kategori, note) VALUES(:email, :jumlah, :dt, :idKategori, :note)", [
                "email" => $this->email_user,
                "jumlah" => $this->jumlah,
                "dt" => $this->tanggal,
                "idKategori" => $this->id_kategori,
                 "note" => $this->note
            ]);
        } catch (\Exception $th) {
            error_log($th->getCode() . " - " . $th->getMessage(), 3, __DIR__ . "/../error.log");
        }
    }

    public static function getAll()
    {
        $db = Database::instance();
        return $db->query("SELECT * FROM kategori")->fetchAll();
    }

    public static function getPemasukanByEmail($email){
        $db = Database::instance();
        return $db->query("select p.id, p.email_user, p.jumlah, p.tanggal, p.id_kategori, k.nama, p.note from pemasukan p, kategori k where p.id_kategori = k.id AND p.email_user = '$email'")->fetchAll();
    }

    public static function getPemasukanTotalKategoriByEmail($email){
        $db = Database::instance();
        return $db->query("select SUM(p.jumlah) AS jumlah, k.nama from pemasukan p, kategori k where p.id_kategori = k.id AND p.email_user = '$email' GROUP BY k.nama")->fetchAll();
    }

    public static function getMostPemasukanByEmail($email,$month){
        $db = Database::instance();
        return $db->query("select sum(p.jumlah) as jumlah, k.nama from pemasukan p, kategori k where p.id_kategori = k.id AND p.email_user = '$email' AND month(p.tanggal) = '$month' GROUP BY k.nama ORDER BY jumlah DESC")->fetchAll();
    }

    public static function getByPemasukanUserDate($bln, $email, $kategori)
    {
        $db = Database::instance();
        return $db->query("SELECT P.JUMLAH, DATE_FORMAT(P.TANGGAL, '%d/%m/%Y') as TANGGAL, P.NOTE FROM pemasukan P, kategori K WHERE P.ID_kategori = K.ID AND DATE_FORMAT(P.TANGGAL, '%Y%m') = :bln AND P.EMAIL_USER = :email AND K.NAMA = :kategori", ["bln"=>$bln, "email"=>$email, "kategori"=>$kategori])->fetchAll();
    }

    public static function getSubtotalByUserDate($bln, $email)
    {
        $db = Database::instance();
        return $db->query("SELECT nvl(SUM(P.JUMLAH), 0) as subtotal FROM pemasukan P WHERE DATE_FORMAT(P.TANGGAL, '%Y%m') = :bln AND P.EMAIL_USER = :email", ["bln"=>$bln, "email"=>$email])->fetch();
    }

    public static function getTotalByKategori($bln, $email, $kategori)
    {
        $db = Database::instance();
        return $db->query("SELECT ifnull(sum(P.JUMLAH), 0) as total FROM pemasukan P, kategori K WHERE P.ID_kategori = K.ID AND DATE_FORMAT(P.TANGGAL, '%Y%m') = :bln AND P.EMAIL_USER = :email AND K.NAMA = :kategori", ["bln"=>$bln, "email"=>$email, "kategori"=>$kategori])->fetch();
    }

    public static function getTotalbyEmail($email){
        $db = Database::instance();
        return $db->query("SELECT nvl(sum(jumlah),0) AS subtotal FROM pemasukan WHERE email_user = '$email'")->fetch();
    }

    public static function getMonthlyPemasukanByEmailKelompok($bln, $email){
        $db = Database::instance();
        return $db->query("SELECT NVL(SUM(P.JUMLAH), 0) as total FROM pemasukan P, kategori K, kelompok KE WHERE P.ID_kategori = K.ID AND K.ID_kelompok = KE.ID AND  P.EMAIL_USER = :email AND KE.ID = 0 AND DATE_FORMAT(P.TANGGAL, '%Y%m') = :bln", ["bln"=>$bln, "email"=>$email])->fetch();
    }
}