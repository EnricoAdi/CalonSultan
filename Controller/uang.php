<?php

    include_once("../Config/load.php");

    use Model\Pemasukan;
    use Model\Pengeluaran;
    use Model\Kategori;
    use Model\Limit;

    if(isset($_POST["action"])){

        if($_POST["action"] == "getPemasukanTotalKategoriByEmail"){
            echo json_encode(Pemasukan::getPemasukanTotalKategoriByEmail($_POST["email"]));
        }

        if($_POST["action"] == "getPengeluaranByEmailKelompok"){
            echo json_encode(Pengeluaran::getPengeluaranByEmailKelompok($_POST["email"],$_POST["kelompok"]));
        }

        if($_POST["action"] == "getMostPemasukanByEmail"){
            echo json_encode(Pemasukan::getMostPemasukanByEmail($_POST["email"], $_POST["month"]));
        }

        if($_POST["action"] == "getMostPengeluaranByEmail"){
            echo json_encode(Pengeluaran::getMostPengeluaranByEmail($_POST["email"], $_POST["month"]));
        }

        if($_POST["action"] == "getTotalPemasukanByEmail"){
            if(isset($_POST["month"])){
                echo json_encode(Pemasukan::getSubtotalByUserDate($_POST["month"],$_POST["email"]));
            }else{
                echo json_encode(Pemasukan::getTotalbyEmail($_POST["email"]));
            }
        }

        //Get total pengeluaran of user by email (SUM)
        if($_POST["action"] == "getTotalPengeluaranByEmail"){
            if(isset($_POST["month"])){
                echo json_encode(Pengeluaran::getSubtotalByUserDate($_POST["month"],$_POST["email"]));
            }else{
                echo json_encode(Pengeluaran::getTotalbyEmail($_POST["email"]));
            }
        }

        if($_POST["action"] == "getTotalPengeluaranByEmailKelompok"){
            echo json_encode(Pengeluaran::getTotalPengeluaranByEmailKelompok($_POST["email"],$_POST["kelompok"]));
        }

        if($_POST["action"] == "getLimitByEmail"){
            echo json_encode(Limit::getLimitByEmail($_POST["email"]));
        }

        if($_POST["action"] == "getLimitByEmailKategori"){
            echo json_encode(Limit::getLimitByEmailKategori($_POST["email"], $_POST["kategori"]));
        }

        if($_POST["action"] == "getLimitById"){
            echo json_encode(Limit::getLimitById($_POST["idLimit"]));
        }

        if ($_POST["action"] == "getMonthlyPemasukanByEmailKelompok") {
            echo json_encode(Pemasukan::getMonthlyPemasukanByEmailKelompok($_POST["month"], $_POST["email"]));
        }

        if ($_POST["action"] == "getMonthlyPengeluaranByEmailKelompok") {
            echo json_encode(Pengeluaran::getMonthlyPengeluaranByEmailKelompok($_POST["month"], $_POST["email"], $_POST["kelompok"]));
        }

        //AUTOCOMMA
        if($_POST["action"] == "inputPendapatan"){
            $email = $_POST["email"];
            $nama = $_POST["formData"][0]["value"];
            $kategori = $_POST["formData"][1]["value"];
            $nominal = $_POST["formData"][2]["value"];
            
            $nominal = str_replace(",","",$nominal);

            $pemasukan = new Pemasukan(-1,$email, $nominal, date('Y-m-d H:i:s'), $kategori, $nama);
            echo $pemasukan->save();
        }

        //AUTOCOMMA
        if($_POST["action"] == "inputPengeluaran"){
            $email = $_POST["email"];
            $nama = $_POST["formData"][0]["value"];
            $kategori = $_POST["formData"][1]["value"];
            $nominal = $_POST["formData"][2]["value"];

            $nominal = str_replace(",","",$nominal);

            $pengeluaran = new Pengeluaran(-1,$email, $nominal, date('Y-m-d H:i:s'), $kategori, $nama);
            echo $pengeluaran->save();
        }

        //AUTOCOMMA
        if($_POST["action"] == "inputLimit"){
            $nominal = $_POST["formData"][1]["value"];
            $nominal = str_replace(",","",$nominal);

            $limit = new Limit($_POST["email"],$_POST["formData"][0]["value"],$nominal);
            echo $limit->save();
        }

        //AUTOCOMMA
        if($_POST["action"] == "editLimit"){
            $nominal = str_replace(",","",$_POST["nominal"]);
            Limit::editLimit($_POST["idLimit"],$nominal);
        }

        if($_POST["action"] == "deleteLimit"){
            Limit::deleteLimit($_POST["idLimit"]);
        }
    }
?>