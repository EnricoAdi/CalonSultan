<?php

use Config\Database;

include_once("../../Config/load.php");

if (isset($_SESSION['idEditArtikel'])) {
    # code...
    $ses = $_SESSION['idEditArtikel'];
    $db = Database::instance();
}

if (isset($_POST['submitArtikel'])) {
    $judul = $_POST['judul'];
    $isi = $_POST['editor'];
    $date = date('Y-m-d');

    // edit artikel yang sudah ada
    $stmt = $db->query("UPDATE artikel SET judul = :judul, tanggal_rilis = :tanggal, isi = :isi WHERE id = :id",[
        'judul' => $judul,
        'tanggal' => $date,
        'isi' => $isi,
        'id' => $_SESSION['idEditArtikel']['id']]);
    unset($_SESSION['idEditArtikel']);
    $_SESSION["message"] = "Berhasil Edit Artikel";
    header('location: adminPageMasterArtikel.php');
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
    <!-- CKEditor -->
    <script src="https://cdn.ckeditor.com/4.18.0/full/ckeditor.js"></script>
    <!-- Jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>Document</title>
</head>
<style>
    #back {
        position: absolute;
    }
    body {
        background: linear-gradient(90deg, #487f63 0%, #f0b86c 100%);
    }
</style>
<body>
    <nav class="p-3 bg-dark text-white">
        <div class="container-fluid">
            <span class="text-white">Menu Edit Artikel</span>
        </div>
    </nav>
    <br>
    <div class="container">
        <div class="row">
            <h1><?= "Update Artikel : ".$ses['judul'] ?></h1>
            <form method="POST" id="formS">
                <!-- Judul <input type="text" name="judul" > <br> -->
                <div class="input-group flex-nowrap">
                    <span class="input-group-text" id="addon-wrapping">Judul Artikel : </span>
                    <input type="text" class="form-control" placeholder="Judul Artikel" aria-label="Username" aria-describedby="addon-wrapping" 
                    value="<?= $ses['judul'] ?>" name="judul">
                </div>
                <br>
                <textarea name="editor"><?= $ses['isi'] ?></textarea>

                <br>
                <button type="submit" class="btn btn-primary" name="submitArtikel" style="margin-right: 2%;">Save !</button>
                <button type="button" class="btn btn-danger" id="back" data-bs-toggle="modal" data-bs-target="#exampleModal">Back Without Saving</button>
            </form>
        </div>
        <div class="row">
            <div class="col-2">
            </div>
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
        <form method="POST" action="adminMaster.php">
            <button class="btn btn-danger" data-dismiss="modal" name="backToMArtikel" id="confirmDelete">Confirm Back</button>
        </form>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
    </div>
</div>
<!-- End of Modal -->    
</body>
<script>
CKEDITOR.replace('editor', {

});

$('#back').click(function () {
    let value = $(this).val();
    let text = $(this).attr('judul');
    $('.modal-title').html('Konfirmasi');
    $('.modal-body').html('Yakin ingin kembali ke halaman tanpa menyimpan perubahan ?');
    $('#confirmDelete').val(value);
});
</script>
</html>