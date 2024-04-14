<?php

namespace Model;

use Config\Database;

class Laporan
{

    private string $id;
    
    function __construct($id)
    {
        $this->id = $id;
    }

    public static function getAll()
    {
        $db = Database::instance();
        return $db->query("SELECT * FROM kategori")->fetchAll();
    }

    public static function getLaporan($bln1, $bln2, $email, $urutan, $kelompok)
    {
        $db = Database::instance();
        return $db->query("SELECT * FROM (SELECT '0' as p, DATE_FORMAT(P.TANGGAL, '%d/%m/%Y') AS TANGGAL, NVL(P.NOTE, 'Tidak ada keterangan') as NOTE, P.JUMLAH FROM PEMASUKAN P, KATEGORI K, KELOMPOK KE WHERE P.ID_KATEGORI = K.ID AND K.ID_KELOMPOK = KE.ID AND KE.ID = $kelompok AND P.EMAIL_USER = '$email' AND DATE_FORMAT(P.TANGGAL, '%Y%m') <= '$bln2' AND DATE_FORMAT(P.TANGGAL, '%Y%m') >= '$bln1' UNION SELECT '1' as p, DATE_FORMAT(P.TANGGAL, '%d/%m/%Y') AS TANGGAL, NVL(P.NOTE, 'Tidak ada keterangan') as NOTE, P.JUMLAH FROM PENGELUARAN P, KATEGORI K, KELOMPOK KE WHERE P.ID_KATEGORI = K.ID AND K.ID_KELOMPOK = KE.ID AND KE.ID = $kelompok AND P.EMAIL_USER = '$email' AND DATE_FORMAT(P.TANGGAL, '%Y%m') <= '$bln2' AND DATE_FORMAT(P.TANGGAL, '%Y%m') >= '$bln1') a ORDER BY substr(a.tanggal, 4, 2) $urutan, substr(a.tanggal, 1, 2) $urutan")->fetchAll();
    }

    public static function getLaporanAllKelompok($bln1, $bln2, $email, $urutan){
        $db = Database::instance();
        return $db->query("SELECT * FROM (SELECT '0' as p, DATE_FORMAT(P.TANGGAL, '%d/%m/%Y') AS TANGGAL, NVL(P.NOTE, 'Tidak ada keterangan') as NOTE, P.JUMLAH FROM PEMASUKAN P, KATEGORI K, KELOMPOK KE WHERE P.ID_KATEGORI = K.ID AND K.ID_KELOMPOK = KE.ID AND P.EMAIL_USER = '$email' AND DATE_FORMAT(P.TANGGAL, '%Y%m') <= '$bln2' AND DATE_FORMAT(P.TANGGAL, '%Y%m') >= '$bln1' UNION SELECT '1' as p, DATE_FORMAT(P.TANGGAL, '%d/%m/%Y') AS TANGGAL, NVL(P.NOTE, 'Tidak ada keterangan') as NOTE, P.JUMLAH FROM PENGELUARAN P, KATEGORI K, KELOMPOK KE WHERE P.ID_KATEGORI = K.ID AND K.ID_KELOMPOK = KE.ID AND P.EMAIL_USER = '$email' AND DATE_FORMAT(P.TANGGAL, '%Y%m') <= '$bln2' AND DATE_FORMAT(P.TANGGAL, '%Y%m') >= '$bln1') a ORDER BY substr(a.tanggal, 4, 2) $urutan, substr(a.tanggal, 1, 2) $urutan")->fetchAll();
    }
}

?>