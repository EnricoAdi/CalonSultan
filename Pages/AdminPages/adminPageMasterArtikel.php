<?php
include_once("../../Config/load.php");

if (isset($_SESSION["message"])) {
    echo "<script>alert('$_SESSION[message]');</script>";
    unset($_SESSION["message"]);
}

use Config\Database;
use Model\User;

if (isset($_COOKIE['user'])) {
    # code...
    $usr = json_decode($_COOKIE["user"],true);
    $u = User::getByEmail($usr["email"]);
    if ($u['status'] != 0) {
        # code...
        header('Location: ../../index.php');
        $_SESSION['message'] = 'non admin dilarang ke page Admin ya..';
    }
}else{
    header('Location: ../../index.php');
}

//Pagination
$db = Database::instance();
$jumlahDataPerHalaman = 4;
$jumlahData = count($db->query("SELECT * FROM artikel")->fetchAll());
if (isset($_GET['search'])) {
    $key = $_GET['value'];
    if ($key != "") {
        # code...
        $jumlahData = count($db->query("SELECT * FROM artikel WHERE judul LIKE '%$key%' ")->fetchAll());
    }
}
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
$halamanAktif = (isset($_GET['halaman'])) ? $_GET['halaman'] : 1;
$awalData = ( $jumlahDataPerHalaman * $halamanAktif ) - $jumlahDataPerHalaman;
$artikels = $db->query("SELECT * FROM artikel LIMIT $awalData, $jumlahDataPerHalaman")->fetchAll();
//Untuk dapatkan Data
if (isset($_GET['search'])) {
    $key = $_GET['value'];
    if ($key != "") {
        # code...
        $artikels = $db->query("SELECT * FROM artikel WHERE judul LIKE '%$key%' LIMIT $awalData, $jumlahDataPerHalaman")->fetchAll();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CDN BOOTSTRAP 5.1.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <!-- Jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- CSS -->
    <link href="admin.css" rel="stylesheet">
    <title>Admin Page</title>
</head>
<style>
a {
    text-decoration: none;
    color: black;
}
</style>
<body>
    <!-- Header  -->
    <header class="p-3 bg-dark text-white">
        <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">

            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                <li><a href="adminPageHome.php" class="nav-link px-2 text-white">Home</a></li>
                <li><a href="adminPageMasterArtikel.php" class="nav-link px-2 text-secondary">Master Artikel</a></li>
                <li><a href="adminPageMasterKelas.php" class="nav-link px-2 text-white">Master Kelas</a></li>
                <!-- <li><a href="adminPagePostKelas.php" class="nav-link px-2 text-white">Post Kelas Baru</a></li>
                <li><a href="adminPagePostArtikel.php" class="nav-link px-2 text-white">Post Artikel Baru</a> -->
            </ul>

            <div class="dropdown text-end">
            <button type="button" href="#" class="btn btn-warning" data-bs-toggle="dropdown" aria-expanded="false" id="btnUser"><?= $u['nama'] ?></button>
            <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
                <li><a class="dropdown-item" href="../../forgot-password.php">Change Password</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="../../Controller/logout.php">Sign out</a></li>
            </ul>
            </div>
        </div>
        </div>
    </header>

    <br>

    <div class="container">
        <div class="row">
            <h1 class="text-white">List Artikel</h1>
            <form class="d-flex" method="GET">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="value">
                <button class="btn btn-success" name="search">Search</button>
            </form>
        </div>
        <br>
        <div class="row">
            <a href="adminPagePostArtikel.php"><button class="btn btn-primary" style="width: 100%;">Buat Artikel !</button></a>
        </div>
        <hr>
        <div class="row">
            <?php
            foreach ($artikels as $key => $value) {
                # code...
            ?>
                <div class="rowArtikel">
                    <a href="../../seeArtikel.php?idArtikel=<?= $value['id'] ?>"><h5> <?= $value['judul'] ?></h5>
                    <p>Created At : <?= $value['tanggal_rilis'] ?></p></a>
                    <div style="right: 2%; top: 40%; position:absolute">
                        <form method="POST" id="formRow" action="adminMaster.php">
                            <button class="btn btn-warning" name="editArtikel" value="<?= $value['id'] ?>">Edit</button>
                        </form>
                        <button type="button" class="klik btn btn-danger" value="<?= $value['id'] ?>" judul="<?= $value['judul'] ?>" data-bs-toggle="modal" data-bs-target="#exampleModal">Delete</button>
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
                            <?php if( $i+1 == $halamanAktif) : ?>
                                <li class="page-item active"><a href="?halaman=<?= $ctr ?>" class="page-link"><?= $ctr ?></a></li>
                            <?php else : ?>
                                <li class="page-item"><a href="?halaman=<?= $ctr ?>" class="page-link"><?= $ctr ?></a></li>
                            <?php endif; ?>
                        <?php $ctr++; endfor; ?>
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
            <button class="btn btn-danger" data-dismiss="modal" name="deleteArtikel" id="confirmDelete">Confirm Delete</button>
        </form>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
    </div>
</div>
<!-- End of Modal -->
</body>
<script type="text/javascript">
$('.klik').click(function () {
    let value = $(this).val();
    let text = $(this).attr('judul');
    $('.modal-title').html('Konfirmasi Delete Artikel');
    $('.modal-body').html('Yakin ingin menghapus Artikel dengan judul : <br><b>' + text + '</b>');
    $('#confirmDelete').val(value);
});
</script>
</html>