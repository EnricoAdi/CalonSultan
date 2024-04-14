<?php
include_once("Config/load.php");

use Model\Kelas;
use Model\User;
use Config\Database;

if (isset($_SESSION["message"])) {
    echo "<script>alert('$_SESSION[message]');</script>";
    unset($_SESSION["message"]);
}

if (isset($_COOKIE['user'])) {
    # code...
    $usr = json_decode($_COOKIE["user"], true);
    $u = User::getByEmail($usr["email"]);
} else {
    $_SESSION["message"] = "User harus login terlebih dahulu";
    header('Location: index.php');
}


//Pagination
$db = Database::instance();
$jumlahDataPerHalaman = 5;
$jumlahData = count($db->query("SELECT * FROM kelas")->fetchAll());
if (isset($_GET['search'])) {
    $key = $_GET['value'];
    if ($key != "") {
        # code...
        $jumlahData = count($db->query("SELECT * FROM kelas WHERE nama LIKE '%$key%' ")->fetchAll());
    }
}
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
$halamanAktif = (isset($_GET['halaman'])) ? $_GET['halaman'] : 1;
$awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;
$kelas = $db->query("SELECT * FROM kelas LIMIT $awalData, $jumlahDataPerHalaman")->fetchAll();
//Untuk dapatkan Data
if (isset($_GET['search'])) {
    $key = $_GET['value'];
    if ($key != "") {
        # code...
        $kelas = $db->query("SELECT * FROM kelas WHERE nama LIKE '%$key%' LIMIT $awalData, $jumlahDataPerHalaman")->fetchAll();
    }
}

// Join Kelas
if (isset($_POST['joinKelas'])) {
    $idKelas = $_POST['joinKelas'];
    $uEmail = $u['email'];
    $db->query("INSERT INTO registrasi_kelas(email_user, id_kelas) VALUES('$uEmail',$idKelas)");
    $_SESSION["message"] = "Berhasil join kelas";
    header('location: kelasPage.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <!-- Jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>Document</title>
</head>
<style>
    .rowArtikel {
        border-radius: 20px;
        box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
        background-color: white;
        margin-top: 2%;
        padding: 2%;
        position: relative;
    }

    #formRow {
        display: inline-block;
    }
</style>

<body>
    <nav class="navbar navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="landingpage.php">
                <img src="Images/logo.png" alt="" width="40" height="34" class="d-inline-block align-text-top">
                Calon Sultan
            </a>
            <span class="text-white">Rajin Belajar Pangkal Pintar !</span>
            <!-- <a href="daftarKelas.php"><button class="btn btn-success">Lihat Daftar Kelas</button></a> -->
            <a href="landingpage.php"><button class="btn btn-dark">Back</button></a>
        </div>
    </nav>
    <br>
    <div class="container">
        <div class="row">
            <h1>Cari Kelas Sesuai Gayamu !</h1>
            <form class="d-flex" method="GET">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="value">
                <button class="btn btn-success" name="search">Search</button>
            </form>
        </div>
        <br>
        <div class="row">
            <?php
            foreach ($kelas as $key => $value) {
                # code...
                $uEmail = $u['email'];
                $idKelasRow = $value['id'];
                $checkTerdaftar = count($db->query("SELECT * FROM registrasi_kelas WHERE email_user = '$uEmail' AND id_kelas = $idKelasRow")->fetchAll());

                $status = "";
                $text = "Join";
                if ($checkTerdaftar > 0) {
                    $status = "disabled";
                    $text = "Joined";
                }
            ?>
                <div class="klikinfo rowArtikel" data-bs-toggle="modal" data-bs-target="#exampleModal" nama="<?= $value['nama'] ?>" tanggal="<?= $value['tanggal_pelaksanaan'] ?>" pembicara="<?= $value['pembicara'] ?>" lokasi="<?= $value['lokasi'] ?>" deskripsi="<?= $value['deskripsi'] ?>">
                    <h5> <?= $value['nama'] ?></h5>
                    <p>Created At : <?= $value['tanggal_pelaksanaan'] ?></p>
                    <div style="right: 2%; top: 40%; position:absolute">
                        <form method="POST" id="formRow">
                            <button class="btn btn-success" name="joinKelas" value="<?= $value['id'] ?>" <?= $status ?>><?= $text ?></button>
                        </form>
                        <!-- <button class="klikdel btn btn-danger" value="<?= $value['id'] ?>" judul="<?= $value['nama'] ?>" data-bs-toggle="modal" data-bs-target="#exampleModal">Delete</button> -->
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
        <br>
        <div class="row">
            <div class="col-4"></div>
            <div class="col-4">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <?php
                        //Navigasi
                        $ctr = 1;
                        for ($i = 0; $i < $jumlahHalaman; $i++) : ?>
                            <?php if ($i + 1 == $halamanAktif) : ?>
                                <li class="page-item active"><a href="?halaman=<?= $ctr ?>" class="page-link"><?= $ctr ?></a></li>
                            <?php else : ?>
                                <li class="page-item"><a href="?halaman=<?= $ctr ?>" class="page-link"><?= $ctr ?></a></li>
                            <?php endif; ?>
                        <?php $ctr++;
                        endfor; ?>
                    </ul>
                </nav>
            </div>
            <div class="col-4"></div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary">Save changes</button> -->
                    <form method="POST" action="adminMaster.php">
                        <button class="btn btn-danger" data-dismiss="modal" name="deleteKelas" id="confirmDelete">Confirm Delete</button>
                    </form>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
            <!-- End Of Modal -->
</body>
<script type="text/javascript">
    $('.klikdel').click(function() {
        let value = $(this).val();
        let text = $(this).attr('judul')
        $('.modal-title').html('Konfirmasi Delete Kelas');
        $('.modal-body').html('Yakin ingin menghapus Kelas dengan judul : <br><b>' + text + '</b>');
        $('#confirmDelete').val(value);
    });

    $('.klikinfo').click(function() {
        let nama = $(this).attr('nama');
        let tanggal = $(this).attr('tanggal');
        let pembicara = $(this).attr('pembicara');
        let lokasi = $(this).attr('lokasi');
        let deskripsi = $(this).attr('deskripsi');

        $('.modal-title').html('Informasi Kelas');
        $('.modal-body').html('Nama Kelas : <b>' + nama + '</b><br>' +
            'Tanggal Pelaksanaan : <b>' + tanggal + '</b><br>' +
            'Pembicara Kelas : <b>' + pembicara + '</b><br>' +
            'Lokasi Kelas : <b>' + lokasi + '</b><br>' +
            '<hr>Deskripsi Kelas :' +
            '<p>' + deskripsi + '</p>');
        $('.modal-footer').html('<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>');
    });
</script>

</html>