<?php
    require_once("../Config/load.php");
    include_once("Config/cdn.php");
    use Model\Kategori;
    use Model\Pemasukan;
    use Model\Pengeluaran;
    $total = 0;

    function getKategoriPengeluaran($pbulan, $email_login){
        $kategoriPengeluaran = Kategori::getByPengeluaranUserDate($pbulan, $email_login);
        return $kategoriPengeluaran;
    }

    function getKategoriPemasukan($pbulan, $email_login){
        $kategoriPemasukan = Kategori::getByPemasukanUserDate($pbulan, $email_login);
        return $kategoriPemasukan;
    }

    function getSubtotalPengeluaran($pbulan, $email_login){
        $subtotalPengeluaran = Pengeluaran::getSubtotalByUserDate($pbulan, $email_login);
        $subtotalPengeluaran = $subtotalPengeluaran["subtotal"];
        return $subtotalPengeluaran;
    }

    function getSubtotalPemasukan($pbulan, $email_login){
        $subtotalPemasukan = Pemasukan::getSubtotalByUserDate($pbulan, $email_login);
        $subtotalPemasukan = $subtotalPemasukan["subtotal"];
        return $subtotalPemasukan;
    }

    if(isset($_REQUEST["action"])){
        if ($_REQUEST["action"] == "getHistory") {
            $kategoriPengeluaran = getKategoriPengeluaran($_GET["bln"], $_GET["email_login"]);
            $kategoriPemasukan = getKategoriPemasukan($_GET["bln"], $_GET["email_login"]);

            $subtotalPemasukan = Pemasukan::getSubtotalByUserDate($_GET["bln"], $_GET["email_login"]);
            $subtotalPemasukan = $subtotalPemasukan["subtotal"];

            $subtotalPengeluaran = Pengeluaran::getSubtotalByUserDate($_GET["bln"], $_GET["email_login"]);
            $subtotalPengeluaran = $subtotalPengeluaran["subtotal"];

            $subtotalNet = $subtotalPemasukan - $subtotalPengeluaran;

            $isiBody = "<div class='card py-5 min-w-min flex w-full col-span-2'>
                            <div class='bg-yellowColor min-w-min rounded-lg w-1/2 mr-2 px-6 overflow-x-auto'>
                                <!-- PENGELUARAN -->
                                <div class='text-2xl text-red-600 font-bold py-4'>Pengeluaran</div>
                                <div class='pl-9 text-lg'>";
            foreach ($kategoriPengeluaran as $key => $p){
                $isiBody .= "<div class='text-black'>
                                <div class='font-bold'>$p[NAMA]</div>
                                <ul class='list-disc marker:text-green-900'>";
                $kategori = $p["NAMA"];
                $pengeluaran = Pengeluaran::getByPengeluaranUserDate($_GET["bln"], $_GET["email_login"], $kategori);
                foreach ($pengeluaran as $key => $pe){
                    $isiBody .= "<li class='flex justify-between'>
                                    <div>$pe[TANGGAL]"." - "."$pe[NOTE]</div>
                                    <div>Rp. ".number_format($pe['JUMLAH'])."</div>
                                </li>";
                }
                $total = Pengeluaran::getTotalByKategori($_GET["bln"], $_GET["email_login"], $kategori);
                $total = $total["total"];
                $isiBody .= "<div class='py-4 w-full flex justify-end font-bold text-lg'>Total : Rp. ".number_format($total)."</div>
                    </div>";
            }
            $isiBody .= "</div>
            <div class='py-4 w-full flex justify-end font-bold text-lg text-red-600' id='subtotalPengeluaran'>Subtotal : Rp. ".number_format($subtotalPengeluaran)."</div></div>";
            
            $isiBody .= "<div class='bg-yellowColor min-w-min rounded-lg w-1/2 px-6'>
            <!-- PEMASUKAN -->
            <div class='text-2xl text-green-600 font-bold py-4'>Pemasukan</div>
            <div class='pl-9 text-lg'>";

            foreach ($kategoriPemasukan as $key => $p){
                $isiBody .= "<div class='text-black'>
                <div class='font-bold'>$p[NAMA]</div>
                <ul class='list-disc marker:text-green-900'>";
                $kategori = $p["NAMA"];
                $pemasukan = Pemasukan::getByPemasukanUserDate($_GET["bln"], $_GET["email_login"], $kategori);
                foreach ($pemasukan as $key => $pe){
                    $isiBody .= "<li class='flex justify-between'>
                        <div>$pe[TANGGAL]"." - "."$pe[NOTE]</div>
                        <div>Rp. ".number_format($pe['JUMLAH'])."</div>
                    </li>";
                }
                $total = Pemasukan::getTotalByKategori($_GET["bln"], $_GET["email_login"], $kategori);
                $total = $total["total"];
                $isiBody .= "<div class='py-4 w-full flex justify-end font-bold text-lg'>Total : Rp. ".number_format($total)."</div>
                </div>";
            }
            $isiBody .= "</div>
                        <div class='py-4 w-full flex justify-end font-bold text-lg text-green-600' id='subtotalPemasukan'>Subtotal : Rp. ".number_format($subtotalPemasukan)."</div>
                    </div>
                </div>";
            $isiBody .= "<br><div class='card flex xl:flex-row lg:flex-row md:flex-row sm:flex-col justify-center items-center text-xl font-bold col-span-2'>
            <div class='flex'>
            <div>Total &nbsp;</div>
            <div class='text-green-500'>Pemasukan</div>
            <div>&nbsp;/&nbsp;</div>
            <div class='text-red-500'>Pengeluaran &nbsp;</div>
            <div>: &nbsp;</div></div>";

            if($subtotalNet > 0){
                $isiBody .= "<div class='text-green-500'>Rp. ".number_format($subtotalNet)." </div>";
            }
            elseif($subtotalNet < 0) {
                $subtotalNet *= -1;
                $isiBody .= "<div class='text-red-500'>Rp. ".number_format($subtotalNet)."</div>";
            }
            else {
                $isiBody .= "<div class='text-white'>Rp. ".number_format($subtotalNet)."</div>";
            }

            $isiBody .= "</div>";
            echo $isiBody;
        }
    }

?>