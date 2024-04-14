<?php

namespace Model;

use Config\Database;
use Exception;

class Pengeluaran
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
            $db->query("INSERT INTO pengeluaran(email_user, jumlah, tanggal, id_kategori, note) VALUES(:email, :jumlah, :dt, :idKategori, :note)", [
                "email" => $this->email_user,
                "jumlah" => $this->jumlah,
                "dt" => $this->tanggal,
                "idKategori" => $this->id_kategori,
                "note" => $this->note
            ]);
        } catch (Exception $ex) {
            echo $ex->getMessage();
            error_log($ex->getCode() . " - " . $ex->getMessage(), 3, __DIR__ . "/../error.log");
        }
    }

    public static function getAll()
    {
        $db = Database::instance();
        return $db->query("SELECT * FROM kategori")->fetchAll();
    }

    public static function getPengeluaranByEmailKelompok($email, $kelompok)
    {
        $db = Database::instance();
        return $db->query("select p.id, p.email_user, SUM(p.jumlah) as jumlah, kl.id, kl.nama, k.nama as namaKategori from pengeluaran p, kategori k, kelompok kl WHERE p.id_kategori = k.id AND k.id_kelompok = kl.id and p.email_user = '$email' AND kl.id = '$kelompok' GROUP BY k.id")->fetchAll();
    }

    public static function getPengeluaranByEmail($email)
    {
        $db = Database::instance();
        return $db->query("select p.id, p.email_user, p.jumlah, p.tanggal, p.id_kategori, k.nama, p.note from pengeluaran p, kategori k where p.id_kategori = k.id AND p.email_user = '$email'")->fetchAll();
    }

    public static function getByPengeluaranUserDate($bln, $email, $kategori)
    {
        $db = Database::instance();
        return $db->query("SELECT P.JUMLAH, DATE_FORMAT(P.TANGGAL, '%d/%m/%Y') as TANGGAL, P.NOTE FROM pengeluaran P, kategori K WHERE P.ID_kategori = K.ID AND DATE_FORMAT(P.TANGGAL, '%Y%m') = :bln AND P.EMAIL_USER = :email AND K.NAMA = :kategori", ["bln" => $bln, "email" => $email, "kategori" => $kategori])->fetchAll();
    }

    public static function getMostPengeluaranByEmail($email, $month)
    {
        $db = Database::instance();
        return $db->query("select nvl(sum(p.jumlah), 0) as jumlah, k.nama from pengeluaran p, kategori k where p.id_kategori = k.id AND p.email_user = '$email' AND month(p.tanggal) = '$month' GROUP BY k.nama ORDER BY jumlah DESC")->fetchAll();
    }

    public static function getSubtotalByUserDate($bln, $email)
    {
        $db = Database::instance();
        return $db->query("SELECT nvl(SUM(P.JUMLAH), 0) as subtotal FROM pengeluaran P WHERE DATE_FORMAT(P.TANGGAL, '%Y%m') = :bln AND P.EMAIL_USER = :email", ["bln" => $bln, "email" => $email])->fetch();
    }

    public static function getTotalByKategori($bln, $email, $kategori)
    {
        $db = Database::instance();
        return $db->query("SELECT sum(P.JUMLAH) as total FROM pengeluaran P, kategori K WHERE P.ID_kategori = K.ID AND DATE_FORMAT(P.TANGGAL, '%Y%m') = :bln AND P.EMAIL_USER = :email AND K.NAMA = :kategori", ["bln" => $bln, "email" => $email, "kategori" => $kategori])->fetch();
    }

    public static function getTotalbyEmail($email)
    {
        $db = Database::instance();
        return $db->query("SELECT nvl(sum(jumlah),0) AS subtotal FROM pengeluaran WHERE email_user = '$email'")->fetch();
    }

    public static function getTotalPengeluaranByEmailKelompok($email, $kelompok)
    {
        $db = Database::instance();
        return $db->query("select nvl(sum(p.jumlah),0) AS subtotal FROM pengeluaran p, kategori k, kelompok kl where email_user = '$email' AND p.id_kategori = k.id AND k.id_kelompok = kl.id AND kl.id = '$kelompok'")->fetch();
    }

    public static function getMonthlyPengeluaranByEmailKelompok($bln, $email, $kelompok)
    {
        $db = Database::instance();
        return $db->query("SELECT NVL(SUM(P.JUMLAH), 0) as total FROM pengeluaran P, kategori K, kelompok KE WHERE P.ID_kategori = K.ID AND K.ID_kelompok = KE.ID AND  P.EMAIL_USER = :email AND KE.ID = :kelompok AND DATE_FORMAT(P.TANGGAL, '%Y%m') = :bln", ["bln" => $bln, "email" => $email, "kelompok" => $kelompok])->fetch();
    }
}
