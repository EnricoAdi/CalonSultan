<?php

    use Model\Kategori;
    use Model\Pemasukan;
    use Model\Pengeluaran;
    $kategori;

    $email_login = "";
    $kategoriPemasukan = [];
    $kategoriPengeluaran = [];
    $subtotalPemasukan = 0;
    $subtotalPengeluaran = 0;
    $subtotalNet = 0;
    if (isset($_COOKIE["user"])) {
        $c = json_decode($_COOKIE["user"], true);
        // var_dump($c["email"]);
        $email_login = $c["email"];
    }

    // if(isset($_GET["btnCari"])){
    //     $pbulan = $_GET["bulan"];
    //     $pbulan = str_replace("-", "", $pbulan);
    //     $kategoriPemasukan = Kategori::getByPemasukanUserDate($pbulan, $email_login);
    //     $kategoriPengeluaran = Kategori::getByPengeluaranUserDate($pbulan, $email_login);

    //     // HITUNG SUBTOTAL PEMASUKAN
    //     $subtotalPemasukan = Pemasukan::getSubtotalByUserDate($pbulan, $email_login);
    //     $subtotalPemasukan = $subtotalPemasukan["subtotal"];
    //     // HITUNG SUBTOTAL PENGELUARAN
    //     $subtotalPengeluaran = Pengeluaran::getSubtotalByUserDate($pbulan, $email_login);
    //     $subtotalPengeluaran = $subtotalPengeluaran["subtotal"];
    //     // HITUNG SUBTOTAL NET
    //     $subtotalNet = $subtotalPemasukan - $subtotalPengeluaran;
    // }

?>
<section id="history">
    <!-- History ini dilimit sampe brp row tertentu atau ga?? -->
    <!-- history regular = history premium -->
    <div class="judulPage">
        History Keuangan
    </div>
    <div class="grid grid-cols-2 gap-5">
        <div class="card col-span-2">
            <form action="../../Controller/get-history.php" id="searchHistory" method="GET" class="flex justify-start align-middle items-center col-span-2 h-full">
                <div>
                    <label for="bulan" class="text-lg">Bulan : </label>
                    <input type="month" name="bulan" id="bulan" class="text-black rounded-lg px-2 py-0.5">
                </div>
                <button name="btnCari" id="btnCari" class="bg-yellowColor text-black rounded-md ml-2 w-1/12 py-0.5 text-center align-middle text-lg shadow-md shadow-gray-900 hover:shadow-none min-w-min">Cari!</button>
            </form>
        </div>
        <div id="containerSearch" class="w-full col-span-2">
            <div class="card py-5 flex w-full col-span-2">
                <div class="bg-yellowColor rounded-lg w-1/2 mr-2 px-6 overflow-x-auto">
                    <!-- PENGELUARAN -->
                    <div class="text-2xl text-red-600 font-bold py-4">Pengeluaran</div>
                    <div class="pl-9 text-lg">
                        <?php foreach ($kategoriPengeluaran as $key => $p) : ?>
                            <div class="text-black">
                                <div class="font-bold"><?= $p["NAMA"] ?></div>
                                <ul class="list-disc marker:text-green-900">
                                    <?php 
                                        $kategori = $p["NAMA"];
                                        $pengeluaran = Pengeluaran::getByPengeluaranUserDate($pbulan, $email_login, $kategori);
                                    ?>
                                    <?php foreach ($pengeluaran as $key => $pe) : ?>
                                        <li class="flex justify-between">
                                            <div><?= $pe["TANGGAL"]." - ".$pe["NOTE"] ?></div>
                                            <div>Rp. <?= $pe["JUMLAH"] ?></div>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                                <?php 
                                    $total = Pengeluaran::getTotalByKategori($pbulan, $email_login, $kategori);
                                    $total = $total["total"];
                                ?>
                                <div class="py-4 w-full flex justify-end font-bold text-lg">Total : Rp. <?= $total; ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="py-4 w-full flex justify-end font-bold text-lg text-red-600" id="subtotalPengeluaran">Subtotal : Rp. <?= $subtotalPengeluaran ?></div>
                </div>
                <div class="bg-yellowColor rounded-lg w-1/2 px-6">
                    <!-- PEMASUKAN -->
                    <div class="text-2xl text-green-600 font-bold py-4">Pemasukan</div>
                    <div class="pl-9 text-lg">
                        <?php foreach ($kategoriPemasukan as $key => $p) : ?>
                            <div class="text-black">
                                <div class="font-bold"><?= $p["NAMA"] ?></div>
                                <ul class="list-disc marker:text-green-900">
                                    <?php 
                                        $kategori = $p["NAMA"];
                                        $pemasukan = Pemasukan::getByPemasukanUserDate($pbulan, $email_login, $kategori);
                                    ?>
                                    <?php foreach ($pemasukan as $key => $pe) : ?>
                                        <li class="flex justify-between">
                                            <div><?= $pe["TANGGAL"]." - ".$pe["NOTE"] ?></div>
                                            <div>Rp. <?= $pe["JUMLAH"] ?></div>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                                <?php 
                                    $total = Pemasukan::getTotalByKategori($pbulan, $email_login, $kategori);
                                    $total = $total["total"];
                                ?>
                                <div class="py-4 w-full flex justify-end font-bold text-lg">Total : Rp. <?= $total; ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="py-4 w-full flex justify-end font-bold text-lg text-green-600" id="subtotalPemasukan">Subtotal : Rp. <?= $subtotalPemasukan ?></div>
                </div>
            </div>
            <br>
            <div class="card flex xl:flex-row lg:flex-row md:flex-row sm:flex-col justify-center items-center text-xl font-bold col-span-2">
                <div class='flex'>
                    <div>Total &nbsp;</div>
                    <div class="text-green-500">Pemasukan</div>
                    <div>&nbsp;/&nbsp;</div>
                    <div class="text-red-500">Pengeluaran &nbsp;</div>
                    <div>: &nbsp;</div>
                </div>
                <div>
                    <?php if($subtotalNet > 0) : ?>
                        <div class="text-green-500">Rp. <?= $subtotalNet ?></div>
                    <?php elseif($subtotalNet < 0) : ?>
                        <div class="text-red-500">Rp. <?= $subtotalNet * -1 ?></div>
                    <?php else : ?>
                        <div class="text-white">Rp. <?= $subtotalNet ?></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    const getHistory = (bln, email_login) => {
        $.ajax({
            url: "Controller/get-history.php",
            method: "get",
            data: {
                action: "getHistory",
                bln: bln,
                email_login: email_login
            },
            success: function (response){
                // console.log(response);
            }
        }).done((data) => {
            const containerSearch = $("#containerSearch");
            // containerSearch.html("");
            containerSearch.html(data);
            console.log(data);
        })
    }

    $(document).ready(()=> {

        const d = new Date();
        var bln = d.getMonth() + 1;
        var thn = d.getFullYear();
        if (bln < 10) {
            bln = "0" + bln;
        }
        document.getElementById("bulan").value =  thn.toString() + "-" + bln.toString();

        $('#searchHistory').submit(function (e) { 
            e.preventDefault(); 
            var pbln = document.getElementById("bulan").value.split("-");
            pbln = pbln[0] + pbln[1];
            var email_login = "<?= $email_login; ?>";
            getHistory(pbln, email_login);
        });
    })

</script>