<?php

namespace Model;

use Config\Database;

class User
{
    private string $nama;
    private string $email;
    private string $password; //hasil hashing
    private string $tanggal_lahir;
    private int $status;
    private string $exp_sub;

    function __construct($nama, $email, $password, $birthday, $status, $expsub)
    {
        $this->nama = $nama;
        $this->email = $email;
        $this->password = $password;
        $this->tanggal_lahir = $birthday;
        $this->status = $status;
        $this->exp_sub = $expsub;
    }

    static function getByEmail($email)
    {
        $db = Database::instance();
        return $db->query("select email,password,nama,status from users where email = '$email'")->fetch();
    }

    static function getUserRole($email)
    {
        $db = Database::instance();
        $status = $db->query("select status from users where email = '$email'")->fetch();
        if ($status == 1) {
            //kalo basic false
            return false;
        } else {
            //kalo premium true
            return true;
        }
    }

    static function getRoleCode($email)
    {
        $db = Database::instance();
        return $db->query("select status from users where email = '$email'")->fetch();
    }
    static function getAll()
    {
        $db = Database::instance();
        return $db->query("SELECT * FROM users")->fetchAll();
    }

    function save()
    {
        $db = Database::instance();
        $user = self::getByEmail($this->email);
        if ($user) {
            //update karena usernya found
            try {
                $db->query("UPDATE users SET password = :password, nama = :nama, tanggal_lahir = :tanggal_lahir, status= :status, exp_sub = :exp_sub where email = :email", [
                    "password" => $this->password,
                    "nama" => $this->nama,
                    "tanggal_lahir" => $this->tanggal_lahir,
                    "status" => $this->status,
                    "exp_sub" => $this->exp_sub,
                    "email" => $this->email
                ]);
            } catch (\Exception $th) {
                error_log($th->getCode() . " - " . $th->getMessage(), 3, __DIR__ . "/../error.log");
            }
        } else {
            //register
            //proses ini dilakukan setelah validation user
            try {
                $db->query("INSERT INTO users(email,password,nama,tanggal_lahir, status, exp_sub) values(:email,:password,:nama,:tanggal_lahir, :status, :exp_sub)", [
                    "password" => password_hash($this->password, PASSWORD_DEFAULT),
                    "nama" => $this->nama,
                    "tanggal_lahir" => $this->tanggal_lahir,
                    "status" => $this->status,
                    "exp_sub" => $this->exp_sub,
                    "email" => $this->email
                ]);
            } catch (\Exception $th) {
                error_log($th->getCode() . " - " . $th->getMessage(), 3, __DIR__ . "/../error.log");
            }
        }
        return $this;
    }
}
