<?php
    // require("Utils/date.php");
    // $usr = json_decode($_COOKIE["user"],true);
    // $u = User::getByEmail($usr["email"]);


?>
<section id="dashboard">
    <div class="judulPage">
        Dashboard <br>
        <div class="text-2xl">
            Welcome, <span class="italic"><?= $u["nama"] ?></span>
        </div>
    </div>
    <div class="">
        <div class="grid grid-cols-4 gap-5">
            <div class="card col-span-4 md:col-span-2 row-span-2 h-73 md:h-105 ">    
                <div class="flex flex-col h-full pb-2">
                    <div class="flex items-center justify-center h-4/6" id="containerPieChart">
                        <!-- <div class="bg-red-300 w-full lg:w-3/4 md:w-2/4 sm:w-1/4 lg:h-full sm:h-14 flex justify-center"> -->
                            <canvas id="pieChartPerbandingan" class="w-full"></canvas>
                        <!-- </div> -->
                    </div>
                    <!-- <div class="bg-red-400">a</div> -->
                    <div class="h-2/6 flex flex-col justify-end mt-2">
                        <div class="text-white text-sm md:text-xl">
                            Total pengeluaran dan pemasukan bulan ini
                        </div>
                        <div class="text-2xs md:text-xs font-bold mb-2">
                            <i><?= getDateNow()["mName"] ?>, <?= getDateNow()["y"] ?></i>
                        </div>
                        <div>
                            <div class="text-green-500">
                                Pendapatan : <span id="dashboard-pemasukanTotal">-</span>
                            </div>
                            <div class="text-red-500">
                                Pengeluaran : <span id="dashboard-pengeluaranTotal">-</span>
                            </div>
                            <div id="dashboard-selisihTotal" class="text-red-500 font-bold">
                                Total : -
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div onclick="skorKeuangan()" class="col-span-2 md:col-span-1 card h-48 md:h-52 flex flex-col items-center cursor-pointer">
                <div class="md:text-xl">
                    Skor keuangan
                </div>
                <div class="flex justify-center h-full items-center text-3xl md:text-4xl font-bold" id="dashboard-skorKeuangan">
                    Getting data...
                </div>
                <div class="text-2xs md:text-xs">Klik untuk mengetahui lebih lanjut</div>
            </div>

            <div onclick="pengeluaranBerlebihan()" class="col-span-2 md:col-span-1 card h-48 md:h-52 flex flex-col items-center cursor-pointer justify-between">
                <div class="">
                    <div class="text-sm lg:text-lg text-left">Pengeluaran berlebihan Bulan ini</div>
                    <div class="text-xs font-bold">
                        <i><?= getDateNow()["mName"] ?>, <?= getDateNow()["y"] ?></i>
                    </div>
                </div>
                <div id="dashboard-pengeluaranBerlebihan" class="w-full">
                    
                </div>
                <div class="text-2xs md:text-xs">Klik untuk mengetahui lebih lanjut</div>
            </div>

            <div class="card h-48 md:h-52 col-span-2 md:col-span-1">
                <div class="text-sm md:text-lg">Pendapatan Terbesar Bulan ini</div>
                <div class="text-xs font-bold mb-2">
                    <i><?= getDateNow()["mName"] ?>, <?= getDateNow()["y"] ?></i>
                </div>
                <div class="flex justify-around flex-col md:flex-row md:mt-7" id="dashboard-pemasukanTerbesar">
                    Loading...
                </div>
            </div>

            <div class="card h-48 md:h-52 col-span-2 md:col-span-1">
                <div class="text-sm md:text-lg">Pengeluaran Terbesar Bulan ini</div>
                <div class="text-xs font-bold mb-2">
                    <i><?= getDateNow()["mName"] ?>, <?= getDateNow()["y"] ?></i>
                </div>
                <div class="flex justify-around flex-col md:flex-row md:mt-7" id="dashboard-pengeluaranTerbesar">
                    Loading...
                </div>
            </div>

            <div class="card w-full col-span-4 flex flex-col justify-center items-center">
                <span class="text-xl font-bold">Total Growth Keuangan</span>
                <span class="italic text-sm">per <?= getDateNow()["y"] ?></span>
                <div class="w-full h-64 mt-4">
                    <canvas id="lineChartGrowth"></canvas>
                </div>
            </div>


        </div>
    </div>
</section>