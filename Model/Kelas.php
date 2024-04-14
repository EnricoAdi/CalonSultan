<?php

namespace Model;

use Config\Database;

class Kelas {
    private string $namaKelas;
    private string $namaPembicara;
    private string $tanggal;
    private string $tipe;
    private string $lokasi;
    private string $kapasitas;
    private string $deskripsi;

    function __construct($namaKelas, $namaPembicara, $tanggal, $tipe, $lokasi, $kapasitas, $deskripsi)
    {
        $this->namaKelas = $namaKelas;
        $this->namaPembicara = $namaPembicara;
        $this->tanggal = $tanggal;
        $this->tipe = $tipe;
        $this->lokasi = $lokasi;
        $this->kapasitas = $kapasitas;
        $this->deskripsi = $deskripsi;
    }

    function add(){
        $db = Database::instance();
        $db->query("INSERT INTO kelas (nama, tanggal_pelaksanaan, kapasitas, pembicara, deskripsi, tipe, lokasi) VALUES (:nama, :tanggal, :kapasitas, :pembicara, :deskripsi, :tipe, :lokasi)", [
            "nama" => $this->namaKelas,
            "tanggal" => $this->tanggal,
            "kapasitas" => $this->kapasitas,
            "pembicara" => $this->namaPembicara,
            "deskripsi" => $this->deskripsi,
            "tipe" => $this->tipe,
            "lokasi" => $this->lokasi
        ]);
    }

    static function getAll(){
        $db = Database::instance();
        return $db->query("SELECT * FROM kelas")->fetchAll();
    }

    static function deleteById($id){
        $db = Database::instance();
        $db->query("DELETE FROM KELAS WHERE id = $id");
    }

    static function getById($id){
        $db = Database::instance();
        return $db->query("SELECT * FROM kelas WHERE id = $id")->fetch();
    }

    static function update($id, $namaKelas, $namaPembicara, $tanggal, $tipe, $lokasi, $kapasitas, $deskripsi){
        $db = Database::instance();
        $db->query("UPDATE KELAS SET nama = :nama, tanggal_pelaksanaan = :tanggal, kapasitas = :kapasitas, pembicara = :pembicara, deskripsi = :deskripsi, tipe = :tipe, lokasi = :lokasi WHERE id = :id", [
            "id" => $id,
            "nama" => $namaKelas,
            "tanggal" => $tanggal,
            "kapasitas" => $kapasitas,
            "pembicara" => $namaPembicara,
            "deskripsi" => $deskripsi,
            "tipe" => $tipe,
            "lokasi" => $lokasi
        ]);
    }
}