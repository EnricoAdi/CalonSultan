<?php

    $usr = json_decode($_COOKIE["user"],true);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    
    <link rel="stylesheet" type="text/css" href="../../CSS/tailwind.css">
    <title>&nbsp;</title>
    <link rel="icon" href="../../Images/logo.png" type="image/x-icon">
</head>
<body>
    <span hidden id="emailUser"><?= $usr["email"] ?></span>
    <h1 class='w-full text-center text-2xl font-bold my-8'>Laporan Kesehatan Keuangan</h1>
    <div class='w-full'>
        <div id='container' class='w-full grid grid-cols-2 gap-5 px-5'>
            <!-- <div class='bg-red-300 w-full rounded-lg'>
                <div class='m-4'>
                    <div class='my-3 text-xl font-bold'>Judul</div>
                    <div class='text-lg font-semibold flex'>
                        <div>Skor : </div>
                        <div>&nbsp;100/100</div>
                    </div>
                    <div class='text-lg font-semibold my-2'>Detail</div>
                    <div>
                        <div>Pemasukan Total</div>
                        <div>Pengeluaran Total</div>
                        <div>Selisih</div>
                    </div>
                    <div class='text-lg font-semibold my-2'>Saran</div>
                    <div>bla bla bla</div>
                </div>
            </div>
            <div class='bg-blue-300 w-full rounded-lg'>
                <div class='m-4'>
                    <div class='my-3 text-xl font-bold'>Judul</div>
                    <div class='text-lg font-semibold flex'>
                        <div>Skor : </div>
                        <div>&nbsp;100/100</div>
                    </div>
                    <div class='text-lg font-semibold my-2'>Detail</div>
                    <div>
                        <div>Pengeluaran Total</div>
                        <div>Pengeluaran Kebutuhan Total</div>
                        <div>Rasio kebutuhan dengan pengeluaran total</div>
                    </div>
                    <div class='text-lg font-semibold my-2'>Saran</div>
                    <div>bla bla bla</div>
                </div>
            </div>
            <div class='bg-blue-300 w-full rounded-lg'>
                <div class='m-4'>
                    <div class='my-3 text-xl font-bold'>Judul</div>
                    <div class='text-lg font-semibold flex'>
                        <div>Skor : </div>
                        <div>&nbsp;100/100</div>
                    </div>
                    <div class='text-lg font-semibold my-2'>Detail</div>
                    <div>
                        <div>Pengeluaran Kebutuhan</div>
                        <div>Pengeluaran Keinginan</div>
                        <div>Rasio kebutuhan dengan pengeluaran total</div>
                    </div>
                    <div class='text-lg font-semibold my-2'>Saran</div>
                    <div>bla bla bla</div>
                </div>
            </div>
            <div class='bg-blue-300 w-full rounded-lg'>
                <div class='m-4'>
                    <div class='my-3 text-xl font-bold'>Judul</div>
                    <div class='text-lg font-semibold flex'>
                        <div>Skor : </div>
                        <div>&nbsp;100/100</div>
                    </div>
                    <div class='text-lg font-semibold my-2'>Detail</div>
                    <div>
                        <div>Pengeluaran Tabungan</div>
                        <div>Pengeluaran Total</div>
                        <div>Rasio kebutuhan dengan pengeluaran total</div>
                    </div>
                    <div class='text-lg font-semibold my-2'>Saran</div>
                    <div>bla bla bla</div>
                </div>
            </div>
        </div> -->
    </div>
    <script>
        function getTotalPemasukanByEmail(inpMonth = -1){
            if(inpMonth == -1){
                return $.ajax({
                    url:"../../Controller/uang.php",
                    method:"post",
                    data:{
                        action:"getTotalPemasukanByEmail",
                        email:$("#emailUser").text()
                    }
                });
            }else{
                return $.ajax({
                    url:"../../Controller/uang.php",
                    method:"post",
                    data:{
                        action:"getTotalPemasukanByEmail",
                        email:$("#emailUser").text(),
                        month:inpMonth
                    }
                });
            }
            
        }

        function getTotalPengeluaranByEmail(inpMonth = -1){
            if(inpMonth == -1){
                return $.ajax({
                    url:"../../Controller/uang.php",
                    method:"post",
                    data:{
                        action:"getTotalPengeluaranByEmail",
                        email:$("#emailUser").text()
                    }
                });
            }else{
                return $.ajax({
                    url:"../../Controller/uang.php",
                    method:"post",
                    data:{
                        action:"getTotalPengeluaranByEmail",
                        email:$("#emailUser").text(),
                        month:inpMonth,
                    }
                });
            }
            
        }

        function getTotalPengeluaranByEmailKelompok(kelompok){
            return $.ajax({
                url:"../../Controller/uang.php",
                method:"post",
                data:{
                    action:"getTotalPengeluaranByEmailKelompok",
                    email:$("#emailUser").text(),
                    kelompok:kelompok
                }
            })
        }

        var maxSkor1 = 40;
        var maxSkor2 = 20;
        var maxSkor3 = 20;
        var maxSkor4 = 20;

        async function getDataKeuangan(){
            let pemasukanTotal = parseInt(JSON.parse(await getTotalPemasukanByEmail(), true)["subtotal"]);
            let pengeluaranTotal = parseInt(JSON.parse(await getTotalPengeluaranByEmail(),true)["subtotal"]);
            
            let pengeluaranKebutuhan = parseInt(JSON.parse(await getTotalPengeluaranByEmailKelompok(1),true)["subtotal"]);
            let pengeluaranKeinginan = parseInt(JSON.parse(await getTotalPengeluaranByEmailKelompok(2),true)["subtotal"]);
            let pengeluaranTabungan = parseInt(JSON.parse(await getTotalPengeluaranByEmailKelompok(3),true)["subtotal"]);
            let pengeluaranSedekah = parseInt(JSON.parse(await getTotalPengeluaranByEmailKelompok(4),true)["subtotal"]);

            return([pemasukanTotal, pengeluaranTotal, pengeluaranKebutuhan, pengeluaranKeinginan, pengeluaranTabungan, pengeluaranSedekah]);
        }

        var dataKeuangan = [];
        var skors = [];

        async function calculateSkorKeuangan(){
            dataKeuangan = await getDataKeuangan();
            let pemasukanTotal = dataKeuangan[0];
            let pengeluaranTotal = dataKeuangan[1];
            
            let pengeluaranKebutuhan = dataKeuangan[2];
            let pengeluaranKeinginan = dataKeuangan[3];
            let pengeluaranTabungan = dataKeuangan[4];
            let pengeluaranSedekah = dataKeuangan[5];

            // console.log(pemasukanTotal);
            // console.log(pengeluaranTotal);
            // console.log(pengeluaranKebutuhan);
            // console.log(pengeluaranKeinginan);
            // console.log(pengeluaranTabungan);
            // console.log(pengeluaranSedekah);

            // (40 poin) = Pengeluaran < Pendapatan
            let skor1 = 0;
            selisih = pengeluaranTotal - pemasukanTotal <= 0 ? 0 : pengeluaranTotal - pemasukanTotal;
            if(selisih == 0){
                skor1 = maxSkor1;
            }else{
                //If pengeluaran 2x lipat pemasukan total = 0
                if(selisih >= pemasukanTotal){
                    skor1 = 0;
                }else{
                    skor1 = (1 - selisih/pemasukanTotal)*maxSkor1;
                }
            }
            skor1 = parseInt(skor1);
            if(pengeluaranTotal == 0){skor1 = -1};
            // console.log("Skor1 : "+skor1);


            // (20 Poin) = Kebutuhan < 60%
            let skor2 = 0;
            let rasioKebutuhan = pengeluaranKebutuhan / pengeluaranTotal;
            if(rasioKebutuhan > 0.6){
                skor2 = maxSkor2-((rasioKebutuhan-0.6)/0.4*maxSkor2)
            }else{
            skor2 = rasioKebutuhan == 0? 0: maxSkor2; 
            }
            skor2 = parseInt(skor2);
            if(pengeluaranKebutuhan == 0) {skor2 = -1};
            // console.log("Skor2 : "+skor2);


            // (20 poin) = Keinginan < Kebutuhan
            let skor3 = 0;
            if(pengeluaranKeinginan < pengeluaranKebutuhan){
                skor3 = maxSkor3;
            }else{
                skor3 = maxSkor3 - (pengeluaranKeinginan-pengeluaranKebutuhan)/pengeluaranKebutuhan*maxSkor3;
                skor3 = skor3 <= 0 ? 0 : skor3;
                if(pengeluaranKeinginan + pengeluaranKebutuhan == 0){
                    skor3 = 0;
                }
            }
            skor3 = parseInt(skor3);
            if(pengeluaranKeinginan == 0 && pengeluaranKebutuhan == 0){
                skor3 = -1;
            }
            // console.log("Skor 3 : "+skor3);

            // (20 poin) = Tabungan 30% dari seluruh pemasukan
            let skor4 = 0;
            let rasioTabungan = pengeluaranTabungan / pengeluaranTotal;
            if(rasioTabungan >= 0.3){
                skor4 = maxSkor4;
            }else{
                skor4 = (pengeluaranTabungan/pengeluaranTotal)/0.3*maxSkor4;
                skor4 = skor4 > maxSkor4 ? maxSkor4: skor4;
            }
            skor4 = parseInt(skor4);
            if(pengeluaranTotal == 0) {skor4 = -1}
            // console.log("Skor 4 : "+skor4);
            return [skor1,skor2,skor3,skor4];
        }

        async function hitungBang(){
            var skors = await calculateSkorKeuangan();
            console.log(skors);
            console.log("============")
            console.log(dataKeuangan);
            console.log("============")
            showData(skors, dataKeuangan)
        }

        function showData(skors, dataKeuangan){
            for (let idx = 0; idx <= 4; idx++) {
                if(idx == 0){
                    saran = `<div class='italic'>Pengeluaran yang ideal selalu <span class='font-bold'> di bawah total pemasukan.</span> Apabila jumlah pengeluaran mencapai <span class='font-bold'>2x lipat dari total pemasukan</span> maka anda harus mengatur ulang pengeluaran anda</div>`;
                    if(skors[idx] == -1){
                        element = $(`<div>Rasio tidak ditemukan, pengeluaran kosong!</div>`);
                    }else{
                        let color = "text-white";
                        if(dataKeuangan[0] - dataKeuangan[1] > 0){
                            color = "text-green-500";
                        }else if(dataKeuangan[0] - dataKeuangan[1] < 0){
                            color="text-red-500";
                        }
                        element = $(`
                            <div class='border-4 border-gray-300 rounded-lg p-3'>
                                <div class='my-3 text-center text-xl font-bold'>Rasio Total Pengeluaran dengan Total Pemasukan</div>
                                <div class='text-lg font-semibold flex'>
                                <div>Skor : </div>
                                    <div>&nbsp;${skors[idx]}/40</div>
                                </div>
                                <div class='text-lg font-semibold my-2'>Detail</div>
                                <div>Pemasukan Total : <span class='italic text-green-500 font-bold'>Rp${dataKeuangan[0].toLocaleString()}</span></div>
                                <div>Pengeluaran Total : <span class='italic text-red-500 font-bold'>Rp${dataKeuangan[1].toLocaleString()}</span></div>
                                <div>Selisih : <span class='${color} italic font-bold'>Rp${(dataKeuangan[0] - dataKeuangan[1]).toLocaleString()}</span></div>
                                <div class='text-lg font-semibold my-2'>Saran</div>
                                <div>${saran}</div>
                            </div>
                        `);
                    }
                    $("#container").append(element);
                }else if(idx == 1){
                    saran = `<div class='italic'>Pengeluaran kebutuhan yang baik selalu <span class='font-bold'>di bawah 60% dari total seluruh pengeluaran.</span> Apabila Anda mendapati bahwa rasio pengeluaran kebutuhan anda diatas 60% maka Anda harus memikirkan kembali mengenai pengeluaran kebutuhan yang <span class='font-bold'> harus dipotong.</span></div>`;
                    if(skors[idx] == -1){
                        element = $(`<div>Rasio tidak ditemukan, pengeluaran kebutuhan kosong!</div>`);
                    }else{
                        let rasio = parseInt(dataKeuangan[2]/dataKeuangan[1]*100);
                        let color = "text-green-500";
                        if(rasio > 60){
                            color = "text-red-500";
                        }

                        element = $(`
                        <div class='border-4 border-gray-300 rounded-lg p-3'>
                            <div class='my-3 text-center text-xl font-bold'>Rasio Total Pengeluaran Kebutuhan dengan Total Pengeluaran</div>
                            <div class='text-lg font-semibold flex'>
                                <div>Skor : </div>
                                <div>&nbsp;${skors[idx]}/20</div>
                            </div>
                            <div class='text-lg font-semibold my-2'>Detail</div>
                            <div>Pengeluaran Total : <span class='italic text-red-500 font-bold'>Rp${dataKeuangan[1].toLocaleString()}</span></div>
                            <div>Pengeluaran Kebutuhan Total : <span class='italic text-red-500 font-bold'>Rp${dataKeuangan[2].toLocaleString()}</span></div>
                            <div>Rasio kebutuhan dengan pengeluaran total : <span class='${color} italic font-bold'>${rasio.toLocaleString()}%</span></div>
                            <div class='text-lg font-semibold my-2'>Saran</div>
                            <div>${saran}</div>
                        </div>
                        `);
                    }
                    $("#container").append(element);
                }else if(idx == 2){
                        saran = `<div class='italic'>Pengeluaran keinginan sebaiknya <span class='font-bold'>di bawah pengeluaran kebutuhan.</span> Pengeluaran yang berlebihan sebaiknya <span class='font-bold'>digunakan untuk tabungan.</span></div>`;
                    if(skors[idx] == -1){
                        element = $(`<div>Rasio tidak ditemukan, pengeluaran kebutuhan dan keinginan kosong!</div>`);
                    }else{
                        let selisih = (dataKeuangan[2] - dataKeuangan[3]);
                        let color = "text-green-500";
                        if(selisih < 0){
                            color = "text-red-500";
                        }
                        element = $(`
                        <div class='border-4 border-gray-300 rounded-lg p-3'>
                            <div class='my-3 text-center text-xl font-bold'>Rasio Pengeluaran Keinginan dengan Pengeluaran Kebutuhan</div>
                            <div class='text-lg font-semibold flex'>
                                <div>Skor : </div>
                                <div>&nbsp;${skors[idx]}/20</div>
                            </div>
                            <div class='text-lg font-semibold my-2'>Detail</div>
                            <div>Pengeluaran Kebutuhan : <span class='italic text-green-500 font-bold'>Rp${dataKeuangan[2].toLocaleString()}</span></div>
                            <div>Pengeluaran Keinginan : <span class='italic text-red-500 font-bold'>Rp${dataKeuangan[3].toLocaleString()}</span></div>
                            <div>Selisih : <span class='${color} italic font-bold'>Rp${selisih.toLocaleString()}</span></div>
                            <div class='text-lg font-semibold my-2'>Saran</div>
                            <div>${saran}</div>
                        </div>
                    `);
                    }
                    $("#container").append(element);
                }else if(idx == 3){
                        saran = `<div class='italic'>Rasio pengeluaran tabungan dengan pengeluaran total yang <span class='font-bold'>ideal yaitu 30%.</span> Apabila rasio anda di bawah 30% maka sebaiknya Anda <span class='font-bold'>memikirkan ulang untuk menambah pengeluaran tabungan Anda.</span></div>`;
                    if(skors[idx] == -1){
                        element = $(`<div>Rasio tidak ditemukan, pengeluaran tabungan kosong!</div>`);
                    }else{
                        let rasio = parseInt(dataKeuangan[4]/dataKeuangan[1]*100);
                        let color = "text-red-500";
                        if(rasio >= 30){
                            color = "text-green-500";
                        }
                        element = $(`
                        <div class='border-4 border-gray-300 rounded-lg p-3'>
                            <div class='my-3 text-center text-xl font-bold'>Rasio Pengeluaran Tabungan dengan Pengeluaran Total</div>
                            <div class='text-lg font-semibold flex'>
                                <div>Skor : </div>
                                <div>&nbsp;${skors[idx]}/20</div>
                            </div>
                            <div class='text-lg font-semibold my-2'>Detail</div>
                            <div>Pengeluaran Tabungan : <span class='italic text-green-500 font-bold'>Rp${dataKeuangan[4].toLocaleString()}</span></div>
                            <div>Pengeluaran Total : <span class='italic text-red-500 font-bold'>Rp${dataKeuangan[1].toLocaleString()}</span></div>
                            <div>Rasio kebutuhan dengan pengeluaran total : <span class='${color} italic font-bold'>${rasio.toLocaleString()}%</span></div>
                            <div class='text-lg font-semibold my-2'>Saran</div>
                            <div>${saran}</div>
                        </div>`);
                    }
                    $("#container").append(element);
                }
            }
            
        }

        hitungBang();
        setTimeout(function(){window.print();}, 1000);

    </script>
</body>
</html>