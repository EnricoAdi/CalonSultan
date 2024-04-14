<?php
    use Model\Kategori;
    use Model\Limit;

    $kPemasukan = Kategori::getKategoriPemasukan();
    $kPengeluaran1 = Kategori::getKategoriPengeluaran(1);
    $kPengeluaran2 = Kategori::getKategoriPengeluaran(2);
    $kPengeluaran3 = Kategori::getKategoriPengeluaran(3);
    $kPengeluaran4 = Kategori::getKategoriPengeluaran(4);
?>
<section id="keuangan">
    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        .box{
            height:50px;
            width:50px;
            background-color: red;
        }
    </style>
    <div class="judulPage">
        Keuangan
    </div>
    <div class="">
        <div class="grid grid-cols-4 gap-5">

            <!-- PORTOFOLIO PENDAPATAN -->
            <div class="card col-span-4">
                <div class="mb-2 font-bold text-lg md:text-2xl">
                    Portofolio Pendapatan
                </div>
                <div class="border-l-4 border-yellowColor pl-3" id="keuangan-portofolioPemasukan">
                    Getting data...
                </div>
                <div class="flex justify-end font-bold text-base md:text-lg mt-3">
                    TOTAL KESELURUHAN : <span class="italic" id="keuangan-portofolioPemasukanTotal">Loading...</span>
                </div>
            </div>

            <!-- PORTOFOLIO PENGELUARAN -->
            <div class="card col-span-4">
                <div class="mb-2 font-bold text-lg md:text-2xl">
                    Portofolio Pengeluaran
                </div>
                <div class="grid grid-cols-1 md:grid-cols-4">
                    <div class="border-l-4 border-yellowColor pl-3 mb-4">
                        <div class="font-bold text-lg md:text-xl">
                            Kebutuhan
                        </div>
                        <div id="keuangan-portofolioPengeluaranKebutuhan">
                            Loading...
                        </div>
                        <div class="grid grid-cols-2 font-bold">
                            <div class="">Total</div>
                            <div class="" id="keuangan-portofolioPengeluaranKebutuhanTotal">Loading...</div>
                        </div>
                    </div>
                    <div class="border-l-4 border-yellowColor pl-3 mb-4">
                        <div class="font-bold text-lg md:text-xl">
                            Keinginan
                        </div>
                        <div id="keuangan-portofolioPengeluaranKeinginan">
                            Loading...
                        </div>
                        <div class="grid grid-cols-2">
                            <div class="font-bold">Total</div>
                            <div class="italic font-bold" id="keuangan-portofolioPengeluaranKeinginanTotal">Loading...</div>
                        </div>
                    </div>
                    <div class="border-l-4 border-yellowColor pl-3 mb-4">
                        <div class="font-bold text-lg md:text-xl">
                            Tabungan
                        </div>
                        <div id="keuangan-portofolioPengeluaranTabungan">
                            Loading...
                        </div>
                        <div class="grid grid-cols-2">
                            <div class="font-bold">Total</div>
                            <div class="italic font-bold" id="keuangan-portofolioPengeluaranTabunganTotal">Loading...</div>
                        </div>
                    </div>
                    <div class="border-l-4 border-yellowColor pl-3 mb-4">
                        <div class="font-bold text-lg md:text-xl">
                            Sedekah
                        </div>
                        <div id="keuangan-portofolioPengeluaranSedekah">
                            Loading...
                        </div>
                        <div class="grid grid-cols-2">
                            <div class="font-bold">Total</div>
                            <div class="italic font-bold" id="keuangan-portofolioPengeluaranSedekahTotal">Loading...</div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end font-bold text-base md:text-lg mt-3">
                    TOTAL KESELURUHAN : <span class="italic" id="keuangan-portofolioTotal">Loading...</span>
                </div>
            </div>

            <!-- INPUT PENDAPATAN -->
            <div class="card col-span-2">
                <div class="font-bold text-lg md:text-2xl">
                    Pendapatan
                </div>
                <div class="text-sm md:text-base">
                    Total Bulan Ini : <span class="italic" id="keuangan-pendapatanBulanIni">Rp500.000</span>
                </div>
                <div class="mt-4">
                    <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-3 md:px-4 rounded-full"
                        type="button" data-modal-toggle="modal-pendapatan">
                        <span class="text-xs md:text-base">Tambah Pendapatan</span>
                    </button>
                </div>
            </div>

            <!-- INPUT PENGELUARAN -->
            <div class="card col-span-2">
                <div class="font-bold text-lg md:text-2xl">
                    Pengeluaran
                </div>
                <div class="text-sm md:text-base">
                    Total Bulan Ini : <span class="italic" id="keuangan-pengeluaranBulanIni">Rp800.000</span>
                </div>
                <div class="mt-4">
                    <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-3 md:px-4 rounded-full"
                        type="button" data-modal-toggle="modal-pengeluaran">
                        <span class="text-xs md:text-base">Tambah Pengeluaran</span>
                    </button>
                </div>
            </div>

            <!-- RASIO KEUANGAN -->
            <div class="card col-span-4 md:col-span-2">
                <div class="font-bold text-lg md:text-2xl">
                    Rasio Keuangan Bulanan
                </div>
                <div class='relative'>
                    <form action="" method="post" onsubmit="keuanganSimulasi(event)" class='<?= $u_subscriber == 1 ? 'blur-sm no-copy' : '' ?>'>
                        <div>
                            <label for="small" class="block mb-2 text-sm font-medium text-white">Pilih Rasio</label>
                            <select id="small" class="block w-full p-2 mb-6 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required name="modalSimulasiRasio">
                                <option selected hidden value="">Pilih Rasio</option>
                                <option value="rasioA">10/20/30/40</option>
                                <option value="rasioB">50/30/20</option>
                                <option value="rasioC">60/20/20</option>
                            </select>
                        </div>
                        <div>
                            <button type="<?= $u_subscriber == 1 ? 'button' : 'submit'?>" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full">
                                <span class="text-sm md:text-base">Mulai simulasi</span>
                            </button>
                        </div>
                    </form>
                    <?php
                        if($u_subscriber == 1){
                    ?>
                    <div class='absolute left-0 top-0 w-full h-full flex justify-center items-center'>
                        <span class='font-bold bg-slate-600 shadow-md rounded-md p-1 opacity-75'>Fitur ini hanya tersedia untuk premium</span>
                    </div>
                    <?php
                        }
                    ?>
                </div>
            </div>

            <!-- KESEHATAN KEUANGAN -->
            <div class="card col-span-4 md:col-span-2 md:row-span-2" id="keuangan-skorKeuanganModule">
                <div class="font-bold text-lg md:text-2xl">
                    Kesehatan Keuangan
                </div>
                <div class="mt-2 mb-3">
                    Skor kesehatan keuangan anda : <span class="font-bold" id="keuangan-skorKeuangan">Calculating...</span>
                </div>
                <div class='relative'>
                    <div class='<?= $u_subscriber == 1 ? 'blur-sm no-copy' : '' ?>'>
                    <div id="keuangan-detailSkorKeuangan">
                    </div>
                    <!-- Tambah button buat cetak laporan -->
                    <button id='cetakLaporanKesehatan' class='w-full p-2 py-4 bg-slate-600 text-black rounded-md text-sm md:text-base font-bold' style="color:white">Cetak Laporan Kesehatan Keuangan</button>
                    </div>
                    <?php
                        if($u_subscriber == 1){
                    ?>
                    <div class='absolute left-0 top-0 w-full h-full flex justify-center items-center'>
                        <div class='absolute left-0 top-0 w-full h-full flex justify-center items-center'>
                            <span class='font-bold bg-slate-600 shadow-md rounded-md p-1 opacity-75'>Fitur ini hanya tersedia untuk premium</span>
                        </div>
                    </div>
                    <?php
                        }
                    ?>
                </div>
            </div>

            <!-- LIMIT KEUANGAN -->
            <div class="card col-span-4 md:col-span-2" id="keuangan-limitKeuanganModule">
                <div class="font-bold text-lg md:text-2xl mb-3">
                    Limit Pengeluaran Bulanan
                </div>
                <div id="limit-limitBar">
                    Loading...
                </div>
                <button
                    class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-2 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2 text-center"
                    data-modal-toggle="modal-tambahLimit">
                    <span class="text-smmd:text-base">Tambah Limit Baru</span>
                </button>
            </div>

        </div>         
    </div>

    <div class="bg-gray-900 bg-opacity-50 dark:bg-opacity-80 fixed inset-0 z-40 hidden"></div>
    
    <!-- Modal Limit Berlebihan -->
    <div id="modal-confirmPengeluaran" tabindex="-1"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 md:inset-0 h-modal md:h-full">
        <div class="relative p-4 w-full max-w-md h-full md:h-auto">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button" onclick="closeModalConfirmPengeluaran()"
                    class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
                <div class="p-6 text-center">
                    <svg class="mx-auto mb-4 w-14 h-14 text-gray-400 dark:text-gray-200" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="mb-1 text-lg font-normal text-gray-500 dark:text-gray-400">Yakin tambah pengeluaran?</h3>
                    <div class="mb-3 text-gray-500 dark:text-gray-400 text-xs">Pengeluaran kategori <span class="font-bold italic" id="kategoriBerlebihan">{Getting data...}</span> akan melebihi limit!</div>
                    <div class="mb-5" id="barBerlebihan">

                    </div>
                    <form action="" onsubmit="insertBerlebihan(event)" class="inline">
                        <input type="hidden" name="InputBerlebihanNama" id="InputBerlebihanNama">
                        <input type="hidden" name="InputBerlebihanKategori"id="InputBerlebihanKategori">
                        <input type="hidden" name="InputBerlebihanNominal" id="InputBerlebihanNominal">
                        <button type="submit" class="text-white bg-green-500 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                            Tambah
                        </button>
                    </form>
                    <button type="button"
                        class="text-white bg-gray-500 hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-white focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600" onclick="closeModalConfirmPengeluaran()">Cancel
                    <button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal Hapus Limit -->
    <div id="modal-deleteLimit" tabindex="-1"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 md:inset-0 h-modal md:h-full">
        <div class="relative p-4 w-full max-w-md h-full md:h-auto">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button" onclick="closeModalDeleteLimit()"
                    class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
                <div class="p-6 text-center">
                    <svg class="mx-auto mb-4 w-14 h-14 text-gray-400 dark:text-gray-200" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Yakin delete limit <span id="namaModalDeleteLimit" class="font-bold italic">{Loading...}</span><span id="namaModalDeleteLimitKelompok" class="text-sm"></span>?</h3>
                    <form action="" onsubmit="removeLimit(event)" class="inline">
                        <input type="hidden" name="keuangan-deleteLimitId">
                        <button type="submit"
                            class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                            Delete
                        </button>
                    </form>
                    <button type="button"
                        class="text-white bg-gray-500 hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-white focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600" onclick="closeModalDeleteLimit()">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Limit -->
    <div id="modal-tambahLimit" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
        <div class="relative p-4 w-full max-w-md h-full md:h-auto">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button"
                    class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                    onclick="closeModalLimit()">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
                <div class="py-6 px-6 lg:px-8">
                    <h3 class="mb-4 text-2xl font-medium text-gray-900 dark:text-white">Tambah Limit</h3>
                    <form class="space-y-6" action="#" id="formInputLimit" onsubmit="inputModalLimit(event)">
                        <div>
                        <label for="inputLimitKategori" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Kategori</label>
                            <select id="kategoriSelectLimit" class="block w-full p-2 mb-6 text-sm" required name="inputLimitKategori" style="width:100%">
                                <option></option>
                                <optgroup label="Kebutuhan">
                                    <?php
                                        foreach ($kPengeluaran1 as $k => $v) {
                                    ?>
                                        <option value="<?= $v["id"] ?>"><?= $v["nama"] ?></option>
                                    <?php
                                        }
                                    ?>
                                </optgroup>
                                <optgroup label="Keinginan">
                                    <?php
                                        foreach ($kPengeluaran2 as $k => $v) {
                                    ?>
                                        <option value="<?= $v["id"] ?>"><?= $v["nama"] ?></option>
                                    <?php
                                        }
                                    ?>
                                </optgroup>
                                <optgroup label="Tabungan">
                                    <?php
                                        foreach ($kPengeluaran3 as $k => $v) {
                                    ?>
                                        <option value="<?= $v["id"] ?>"><?= $v["nama"] ?></option>
                                    <?php
                                        }
                                    ?>
                                </optgroup>
                                <optgroup label="Sedekah">
                                    <?php
                                        foreach ($kPengeluaran4 as $k => $v) {
                                    ?>
                                        <option value="<?= $v["id"] ?>"><?= $v["nama"] ?></option>
                                    <?php
                                        }
                                    ?>
                                </optgroup>
                            </select>
                        </div>
                        <div>
                            <label for="inputLimit"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Limit</label>
                            <div class="flex items-center gap-2">
                                Rp<input type="text" min="1" name="inputLimitNominal" id="inputLimit"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white "
                                    required autocomplete="off">
                            </div>
                        </div>
                        <button type="submit"
                            class="w-full text-white bg-green-500 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">Tambah
                            Limit</button>
                    </form>
                    <button
                        class="w-full text-white bg-gray-500 hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                        data-modal-toggle="modal-tambahLimit" id="btnKembaliModalInputLimit" hidden></button>
                    <button
                        class="w-full text-white bg-gray-500 hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                        onclick="closeModalLimit()">
                        Kembali
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail Skor -->
    <div id="modal-detailSkor" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
        <div class="relative p-4 w-full max-w-md h-full md:h-auto">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button" onclick="closeModalDetailSkor(event)"
                    class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
                <div class="py-6 px-6 lg:px-8">
                    <h3 class="mb-2 text-2xl font-medium text-gray-900 dark:text-white" id="modal-detailSkorJudul">Loading rasio type...</h3>
                    <div>
                        <!-- Getting Data... -->
                        <div class="text-lg text-gray-800">
                            Skor anda : <span id="modalDetailSkor" class="font-bold">...</span>
                        </div>
                        <div class="text-2xl text-gray-800 font-bold">
                            Detail
                        </div>
                        <div class="text-gray-800" id="modalDetailSkorContent">

                        </div>
                        <div class="text-2xl text-gray-800 font-bold">
                            Saran
                        </div>
                        <div class="text-gray-800 text-sm" id="modalDetailSkorSaran">

                        </div>
                    </div>
                    <button class="mt-3 w-full text-white bg-gray-500 hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center" onclick="closeModalDetailSkor(event)">
                        Kembali
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal Edit Limit-->
    <div id="modal-editLimit" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
        <div class="relative p-4 w-full max-w-md h-full md:h-auto">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button"
                    class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                    onclick="closeModalEditLimit()">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
                <div class="py-6 px-6 lg:px-8">
                    <h3 class="mb-4 text-2xl font-medium text-gray-900 dark:text-white">Edit limit pengeluaran</h3>
                    <form class="space-y-6" action="#" onsubmit="updateLimit(event)">
                        <div>
                            <label for="small"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Kategori</label>
                            <span class="font-bold" id="namaModalEditLimit">Makanan</span><span class="italic" id="namaModalEditLimitKelompok"></span>
                        </div>
                        <div>
                            <input type="hidden" name="keuangan-editLimitId">
                            <label for="keuangan-editLimitNominal"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Limit</label>
                            <div class="flex items-center gap-2">
                                Rp<input type="text" min="1" name="keuangan-editLimitNominal" id="keuangan-editLimitNominal"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white "
                                    required autocomplete="off">
                            </div>
                        </div>
                        <button type="submit"
                            class="w-full text-white bg-blue-500 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">Edit</button>
                    </form>
                    <button
                        class="w-full text-white bg-gray-500 hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                        onclick="closeModalEditLimit()">
                        Kembali
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Pendapatan -->
    <div id="modal-pendapatan" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
        <div class="relative p-4 w-full max-w-md h-full md:h-auto">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button"
                    class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                    onclick="closeModalPemasukan()">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
                <div class="py-6 px-6 lg:px-8">
                    <h3 class="mb-4 text-2xl font-medium text-gray-900 dark:text-white">Masukkan pendapatan</h3>
                    <form class="space-y-6" action="#" id="formInputPendapatan" onsubmit="inputModalPendapatan(event)">
                        <div>
                            <label for="namaInputPendapatan"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Nama</label>
                            <div class="flex items-center gap-2">
                                <input type="text" name="inputPendapatanNama" id="namaInputPendapatan"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white "
                                    required placeholder="Contoh : Gaji Bulanan">
                            </div>
                        </div>
                        <div>
                            <label for="kategoriSelectPendapatan"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Kategori</label>
                            <select id="kategoriSelectPendapatan" class="block w-full p-2 mb-6 text-sm" name="inputPendapatanKategori" required style="width: 100%;">
                                <option></option>
                                <?php
                                    foreach ($kPemasukan as $k => $v) {
                                ?>
                                    <option value="<?= $v["id"] ?>"><?= $v["nama"] ?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                        <div>
                            <label for="inputPendapatan"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Nominal</label>
                            <div class="flex items-center gap-2">
                                Rp<input type="text" min="1" name="inputPendapatanNominal" id="inputPendapatan"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white "
                                    required autocomplete="off">
                            </div>
                        </div>
                        <button type="submit"
                            class="w-full text-white bg-green-500 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Tambahkan</button>
                    </form>
                    <button data-modal-toggle="modal-pendapatan" id="btnKembaliModalInputPendapatan" hidden></button>
                    <button
                        class="w-full text-white bg-gray-500 hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                        onclick="closeModalPemasukan()">
                        Kembali
                    </button>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal Pengeluaran -->
    <div id="modal-pengeluaran" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
        <div class="relative p-4 w-full max-w-md h-full md:h-auto">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button"
                    class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                    onclick="closeModalPengeluaran()">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
                <div class="py-6 px-6 lg:px-8">
                    <h3 class="mb-4 text-2xl font-medium text-gray-900 dark:text-white">Masukkan pengeluaran</h3>
                    <form class="space-y-6" action="#" id="formInputPengeluaran" onsubmit="inputModalPengeluaran(event)">
                        <div>
                            <label for="namaInputPengeluaran"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Nama</label>
                            <div class="flex items-center gap-2">
                                <input type="text" name="inputPengeluaranNama"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white "
                                    required placeholder="Contoh : Minum kopi starbook">
                            </div>
                        </div>
                        <div>
                            <label for="kategoriSelectPengeluaran"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Kategori</label>
                            <select id="kategoriSelectPengeluaran" class="block w-full p-2 mb-6 text-sm" required name="inputPengeluaranKategori" style="width:100%">
                            <option></option>
                                <optgroup label="Kebutuhan">
                                    <?php
                                        foreach ($kPengeluaran1 as $k => $v) {
                                    ?>
                                        <option value="<?= $v["id"] ?>"><?= $v["nama"] ?></option>
                                    <?php
                                        }
                                    ?>
                                </optgroup>
                                <optgroup label="Keinginan">
                                    <?php
                                        foreach ($kPengeluaran2 as $k => $v) {
                                    ?>
                                        <option value="<?= $v["id"] ?>"><?= $v["nama"] ?></option>
                                    <?php
                                        }
                                    ?>
                                </optgroup>
                                <optgroup label="Tabungan">
                                    <?php
                                        foreach ($kPengeluaran3 as $k => $v) {
                                    ?>
                                        <option value="<?= $v["id"] ?>"><?= $v["nama"] ?></option>
                                    <?php
                                        }
                                    ?>
                                </optgroup>
                                <optgroup label="Sedekah">
                                    <?php
                                        foreach ($kPengeluaran4 as $k => $v) {
                                    ?>
                                        <option value="<?= $v["id"] ?>"><?= $v["nama"] ?></option>
                                    <?php
                                        }
                                    ?>
                                </optgroup>
                            </select>
                        </div>
                        <div>
                            <label for="inputPengeluaran"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Nominal</label>
                            <div class="flex items-center gap-2">
                                Rp<input type="text" min="1" name="inputPengeluaranNominal" id="inputPengeluaran"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white "
                                    required autocomplete="off">
                            </div>
                        </div>
                        <button type="submit"
                            class="w-full text-white bg-red-500 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">Tambahkan</button>
                    </form>
                    <button data-modal-toggle="modal-pengeluaran" id="btnKembaliModalInputPengeluaran" hidden></button>
                    <button
                        class="w-full text-white bg-gray-500 hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                        onclick="closeModalPengeluaran()">
                        Kembali
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Simulasi -->
    <div id="modal-simulasi" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
        <div class="relative p-4 w-full max-w-md h-full md:h-auto">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button" onclick="closeModalSimulasi(event)"
                    class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
                <div class="py-6 px-6 lg:px-8">
                    <h3 class="mb-1 text-2xl font-medium text-gray-900 dark:text-white">Simulasi rasio keuangan bulanan
                        menggunakan rasio <span id="modalSimulasiJudul">Loading...</span>
                    </h3>
                    <div id="">
                        <div class="bg-darkColor rounded-md flex items-center justify-center">
                            <div class="h-full w-full" id="simulasi-Chart">
                                <!-- Loading Pie Chart... -->
                                <canvas id="pieChartSimulasi" class="w-full h-full"></canvas>
                            </div>
                    </div>
                        <div class="mb-4 text-xs">Total Pemasukan Bulan Ini : <span class="italic font-bold" id="modalSimulasiTotalPemasukan"></span></div>

                        <div id="modalSimulasiContent">
                            Calculating...
                        </div>
                    <button
                        class="w-full text-white bg-gray-500 hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center" onclick="closeModalSimulasi(event)">
                        Kembali
                    </button>
                </div>
            </div>
        </div>
    </div>

</section>