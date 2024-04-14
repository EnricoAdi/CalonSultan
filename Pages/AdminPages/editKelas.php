<?php
include_once("../../Config/load.php");
use Model\Kelas;

if (isset($_POST['inputKelas'])) {
    $namaKelas = $_POST['namaKelas'];
    $namaPembicara = $_POST['namaPembicara'];
    $tanggal = $_POST['tanggal'];
    $tipe = $_POST['tipe'];
    $lokasi = $_POST['lokasi'];
    $kapasitas = $_POST['jumKelas'];
    $deskripsi = $_POST['deskripsi'];

    $valid = true;
    if ($tipe == 0) {
        echo '<script>alert("pilih tipe kelas!")</script>';
        $valid = false;
    }
    if ($kapasitas == 0) {
        echo '<script>alert("kapasitas kelas tidak boleh 0")</script>';
        $valid = false;
    }

    if ($valid) {
        //edit
        echo '<script>alert("Berhasil edit kelas")</script>';
        $obj =  $_SESSION['editKelas'];
        Kelas::update($obj['id'], $namaKelas, $namaPembicara, $tanggal, $tipe, $lokasi, $kapasitas, $deskripsi);
        unset($_SESSION['editKelas']);
        $_SESSION["message"] = "Berhasil Edit Kelas";
        header('location: adminPageMasterKelas.php');
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
            <h1><?= "Edit Kelas : ".$_SESSION['editKelas']['nama'] ?>"</h1>
            <form method="POST">
                <div class="input-group mb-3">
                    <span class="input-group-text" id="addon-wrapping">Nama Kelas</span>
                    <input type="text" class="form-control" placeholder="Nama Pembicara" aria-label="Username" name="namaKelas" required 
                    value="<?= $_SESSION['editKelas']['nama'] ?>">
                </div>
                <div class="row">
                    <div class="col">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="addon-wrapping">Nama Pembicara</span>
                            <input type="text" class="form-control" placeholder="Nama Pembicara" aria-label="Username" name="namaPembicara" required 
                            value="<?= $_SESSION['editKelas']['pembicara'] ?>">
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-group mb-3">
                            <span class="input-group-text">Tanggal Pelaksanaan</span>
                            <input type="date" class="form-control" placeholder="Server" aria-label="Server" name="tanggal" required 
                            value="<?= $_SESSION['editKelas']['tanggal_pelaksanaan'] ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="addon-wrapping">Tipe Kelas</span>
                            <select class="form-select" aria-label="Default select example" name="tipe" required>
                                <option value="1" <?php echo ($_SESSION['editKelas']['tipe'] == 1) ? 'selected' : ''; ?>>Online</option>
                                <option value="2" <?php echo ($_SESSION['editKelas']['tipe'] == 2) ? 'selected' : ''; ?>>Offline</option>
                            </select>
                        </div>
                    </div>
                <div class="col">
                    <div class="input-group mb-3">
                        <span class="input-group-text">Lokasi Pelaksanaan Kelas</span>
                        <input type="text" class="form-control" placeholder="Lokasi Kelas" aria-label="Server" name="lokasi" required value="<?php
                        echo isset($_SESSION['editKelas']) ? $_SESSION['editKelas']['lokasi'] : ''; ?>">
                    </div>
                </div>
            </div>
            <div>
                <span id="kapasitasKelas">Kapasitas Kelas : </span>
                <input type="number" name="jumKelas" id="inpjumlah" 
                value="<?= $_SESSION['editKelas']['kapasitas'] ?>" onchange="jumlahChange(this)">
                <input type="range" class="form-range" min="0" max="1000" step="5" id="rangeKelas" value="<?= $_SESSION['editKelas']['kapasitas'] ?>" onchange="rangeChange(this)" name="kapasitas" required>
            </div>
            <div class="input-group">
                <span class="input-group-text">Deskripsi Kelas</span>
                <textarea class="form-control" aria-label="With textarea"  name="deskripsi" required style="height: 300px;"><?= $_SESSION['editKelas']['deskripsi'] ?></textarea>
            </div>
            
            <br>
            <button type="submit" class="btn btn-warning" name="inputKelas" style="margin-right: 2%;">Edit !</button>
            <button type="button" class="btn btn-danger" id="back" data-bs-toggle="modal" data-bs-target="#exampleModal">Back Without Saving</button>
            </form>
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
            <button class="btn btn-danger" data-dismiss="modal" name="backToMKelas" id="confirmDelete">Confirm Back</button>
        </form>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
    </div>
</div>
<!-- End of Modal -->  
</body>
<script>
$('#back').click(function () {
    let value = $(this).val();
    let text = $(this).attr('judul');
    $('.modal-title').html('Konfirmasi');
    $('.modal-body').html('Yakin ingin kembali ke halaman tanpa menyimpan perubahan ?');
    $('#confirmDelete').val(value);
});


let inpJumlah = document.getElementById('inpjumlah');
let rangeJumlah = document.getElementById('rangeKelas');
function rangeChange(e){
    //capacityText.innerHTML = e.value;
    inpJumlah.value = e.value;
}

function jumlahChange(e){
    let val = e.value;
    if (val > 1000) {
        alert('jumlah maks 1000');
        e.value = 0;
        rangeJumlah.value = 0;
    }else{
        rangeJumlah.value = e.value;
    }
}
</script>
</html>