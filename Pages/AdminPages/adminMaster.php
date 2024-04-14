<?php
include_once("../../Config/load.php");
use Model\Artikel;
use Model\Kelas;

if (isset($_POST['deleteArtikel'])) {
    # code...
    $id = $_POST['deleteArtikel'];
    Artikel::deleteById($id);
    header('location: adminPageMasterArtikel.php');
}
if (isset($_POST['seeArtikel'])) {
    # code...
    $id = $_POST['seeArtikel'];
    $res = Artikel::getById($id);
    var_dump($res);
    $_SESSION['seeArtikel'] = $res;
    header('location: ../../seeArtikel.php');
}
if (isset($_POST['editArtikel'])) {
    # code...
    $id = $_POST['editArtikel'];
    $res = Artikel::getById($id);
    $_SESSION['idEditArtikel'] = $res;
    header('location: editArtikel.php');
}
if (isset($_POST['backToMArtikel'])) {
    # code...
    unset($_SESSION['idEditArtikel']);
    header('location: adminPageMasterArtikel.php');
}

if (isset($_POST['deleteKelas'])) {
    # code...
    $id = $_POST['deleteKelas'];
    Kelas::deleteById($id);
    header('location: adminPageMasterKelas.php');
}
if (isset($_POST['editKelas'])) {
    # code...
    $id = $_POST['editKelas'];
    $res = Kelas::getById($id);
    $_SESSION['editKelas'] = $res;
    header('location: editKelas.php');
}
if (isset($_POST['backToMKelas'])) {
    # code...
    unset($_SESSION['editKelas']);
    header('location: adminPageMasterKelas.php');
}
?>