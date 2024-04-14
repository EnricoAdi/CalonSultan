<?php

namespace Model;

use Config\Database;
// require ("Utils/date.php");
class Limit
{
    private string $email;
    private string $kategori;
    private string $limit;

    function __construct($email, $kategori, $limit)
    {
        $this->email = $email;
        $this->kategori = $kategori;
        $this->limit = $limit;
    }

    function save(){
        $db = Database::instance();
        $exist = count(Limit::getLimitByEmailKategori($this->email,$this->kategori));
        try {
            if($exist == 0){
                $db->query("insert into limit_user(email_user,id_kategori,jumlah_limit) VALUES(:email, :kategori, :limit)", [
                    "email" => $this->email,
                    "kategori" => $this->kategori,
                    "limit" => $this->limit,
                ]);   
            }
            return $exist;
        } catch (\Exception $th) {
            error_log($th->getCode() . " - " . $th->getMessage(), 3, __DIR__ . "/../error.log");
        }
    }

    public static function editLimit($idLimit, $nominal){
        $db = Database::instance();
        try {
            return $db->query("UPDATE limit_user set jumlah_limit = :nominal WHERE id = :idLimit", ["nominal" => $nominal, "idLimit" => $idLimit]);
        } catch (\Exception $th) {
            error_log($th->getCode() . " - " . $th->getMessage(), 3, __DIR__ . "/../error.log");
        }
        
    }

    public static function deleteLimit($idLimit){
        $db = Database::instance();
        return $db->query("DELETE FROM limit_user WHERE id = :idLimit", ["idLimit" => $idLimit]);
    }

    public static function getLimitByEmail($email){
        $db = Database::instance();
        $month = getDateNow()["m"];
        return $db->query("select l.id, l.email_user, l.id_kategori, k.nama, kl.nama AS namakelompok, l.jumlah_limit, NVL(SUM(p.jumlah),0) as pengeluaran from limit_user l LEFT JOIN kategori k ON l.id_kategori = k.id AND l.email_user = :email LEFT JOIN kelompok kl ON kl.id = k.id_kelompok LEFT JOIN pengeluaran p ON l.id_kategori = p.id_kategori AND p.email_user = :email2 AND month(p.tanggal) = month(current_date()) AND year(p.tanggal) = year(current_date()) GROUP BY l.id, l.email_user, l.id_kategori, k.nama, kl.nama, l.jumlah_limit ORDER BY (SUM(p.jumlah) / l.jumlah_limit)*100 DESC", [
            "email" => $email,
            "email2" => $email,
        ])->fetchAll();
    }

    public static function getLimitById($id){
        $db = Database::instance();
        return $db->query("select * from limit_user where id = :id",[
            "id" => $id,
        ])->fetch();
    }

    public static function getLimitByEmailKategori($email, $kategori){
        $db = Database::instance();
        $month = getDateNow()["m"];
        return $db->query("select l.id, l.email_user, l.id_kategori, k.nama, l.jumlah_limit, SUM(p.jumlah) as pengeluaran from limit_user l LEFT JOIN kategori k ON l.id_kategori = k.id LEFT JOIN pengeluaran p ON l.id_kategori = p.id_kategori AND p.email_user = :email WHERE l.email_user = :email2 AND month(p.tanggal) = $month AND l.id_kategori = :kategori GROUP BY l.id, l.email_user, l.id_kategori, k.nama, l.jumlah_limit", [
            "email" => $email,
            "email2" => $email,
            "kategori" => $kategori,
        ])->fetchAll();
    }

    public static function getLimitKategori($email){
        $db = Database::instance();
        return $db->query("select l.id_kategori from limit_user l where l.email_user = '$email'")->fetchAll();
    }
}
