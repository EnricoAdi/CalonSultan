<?php

    use Config\Database;
    use Model\Kategori;
    use Model\Kelompok;

    $kategori = Kategori::getAll();
    $kelompok = Kelompok::getAll();

    if (isset($_COOKIE["user"])) {
        $c = json_decode($_COOKIE["user"], true);
        // var_dump($c["email"]);
        $email_login = $c["email"];
    }
?>
<section id="laporan">
    <div class="judulPage">
        Laporan Keuangan
    </div>
    <div class="grid grid-cols-2 gap-5">
        <form action="../../Controller/get-laporan.php" method="GET" id="getLaporan" class="col-span-2">
            <div class="col-span-2 min-w-min flex justify-between card">
            <!-- <div class="bg-red-700 flex w-7/12 justify-between"> -->
                <div class="bg-yellowColor rounded-lg text-black px-2 flex items-center py-3"><!-- cek tgl1 hrs > tgl2 -->
                    <label for="tgl1" class="text-lg">Range laporan : &nbsp;</label>
                    <input type="month" name="tgl1" id="tgl1" class="text-black rounded-lg px-2 py-0.5" required>
                    <label for="tgl2" class="text-lg mx-3">s/d </label>
                    <input type="month" name="tgl2" id="tgl2" class="text-black rounded-lg px-2 py-0.5" required>
                </div>
                <div class="bg-yellowColor rounded-lg text-black px-2 flex items-center py-3">
                    Order : &nbsp;
                    <select name="urutan" id="urutan" class="text-black rounded-lg">
                        <option value="DESC" selected>Terbaru - Terlama</option>
                        <option value="ASC">Terlama - Terbaru</option>
                    </select>
                </div>
            <!-- </div> -->
            <!-- <div class="bg-violet-400 flex w-4/12"> -->
                <!-- <div class="bg-yellowColor rounded-lg text-black px-2 flex items-center py-3">
                    Tipe : &nbsp;
                    <select name="urutan" id="urutan" class="text-black rounded-lg">
                        <option value="0">Semua</option>
                        <option value="1" selected>Pendapatan</option>
                        <option value="2">Pengeluaran</option>
                    </select>
                </div>
                <div class="bg-yellowColor rounded-lg text-black px-2 flex items-center py-3">
                    <label for="kategori">Kategori : &nbsp;</label>
                    <select name="kategori" id="kategori" class="w-56 py-3">
                        <?php foreach ($kategori as $key => $k) : ?>
                            <option value="<?= $k['id'] ?>"><?= $k["nama"] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div> -->
                <div class="bg-yellowColor rounded-lg text-black px-2 flex items-center py-3">
                    <label for="kelompok">Kelompok : &nbsp;</label>
                    <select name="kelompok" id="kelompok" class="rounded-lg">
                        <option value="-1">Semua</option>
                        <?php foreach ($kelompok as $key => $k) : ?>
                            <option value="<?= $k['id'] ?>"><?= $k["nama"] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            <!-- </div> -->
            </div><br>
            <div class="card col-span-2 flex">
                <button name="preview" id="preview" class="bg-yellowColor text-black rounded-md py-3 text-center align-middle text-lg w-full mr-1 shadow-md shadow-gray-900 hover:shadow-none">Preview Laporan</button>
                <!-- <button name="cetak" id="cetak" >Cetak Laporan</button> -->
                <button id="printLaporan" class="bg-yellowColor text-black rounded-md py-3 text-center align-middle text-lg w-full ml-1 shadow-md shadow-gray-900 hover:shadow-none">Cetak Laporan</button>
                <!-- <div class="bg-yellowColor text-black rounded-md py-3 text-center align-middle text-lg w-full ml-1 shadow-md shadow-gray-900 hover:shadow-none"><a href="javascript:generatePDF()">Cetak Laporan</a></div> -->
            </div>
        </form>
        <!-- tempat hasil preview laporan -->
        <div id="hasilLaporan" class="col-span-2">
            <div class="card relative h-96 flex justify-center items-center text-center">
                <div class="<?= $u_subscriber == 1 ? 'blur-sm no-copy ' : '' ?>w-full h-full">
                    <canvas id="barChart" class="w-full h-full"></canvas>
                </div>
                <?php
                    if($u_subscriber == 1){
                ?>
                <div class='absolute w-full h-full flex justify-center items-center'>
                    <span class='font-bold bg-slate-600 shadow-md rounded-md p-1 opacity-75'>Fitur ini hanya tersedia untuk premium</span>
                </div>
                <?php
                    }
                ?>
            </div>
            <br>
            <div id='detailContainer' class="card flex flex-col col-span-2">
                <!-- <div class="bg-green-500 w-full rounded-lg p-2 my-1.5 flex justify-between text-lg">
                    <div>05/05/2022 - Metik dari pohon</div>
                    <div>Rp. 50.000</div>
                </div>
                <div class="bg-red-500 w-full rounded-lg p-2 my-1.5 flex justify-between text-lg">
                    <div>06/05/2022 - Makan sama pacar bayangan :')</div>
                    <div>Rp. 50.000</div>
                </div> -->
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
                <div class="text-white">Rp. 0</div>
            </div>
        </div>
    </div>
</section>
<!-- <script src="https://cdn.ckeditor.com/4.18.0/full/ckeditor.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js" integrity="sha512-qZvrmS2ekKPF2mSznTQsxqPgnpkI4DNTlrdUmTzrDgektczlKNRRhy5X5AAOnx5S09ydFYWWNSfcEqDTTHgtNA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.14.305/pdf.min.js" integrity="sha512-dw+7hmxlGiOvY3mCnzrPT5yoUwN/MRjVgYV7HGXqsiXnZeqsw1H9n9lsnnPu4kL2nx2bnrjFcuWK+P3lshekwQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.debug.js"></script>
<!-- <script src="https://unpkg.com/jspdf-autotable@3.5.24/dist/jspdf.plugin.autotable.js"></script> -->
<script>
    // $(function(){
    //     $("#kategori").select2({
    //         width: 'resolve',
    //         height: 'resolve'
    //     });
    // });
    // CKEDITOR.replace('editor');

    const getLaporan = (pbln1, pbln2, email_login, urutan, kelompok, u_subscriber) => {
        $.ajax({
            url: "Controller/get-laporan.php",
            method: "get",
            data: {
                action: "getLaporan",
                bln1: pbln1,
                bln2: pbln2,
                email_login: email_login,
                urutan: urutan,
                kelompok: kelompok,
                sub: u_subscriber
            },
            success: function (response){
                // console.log(response);
            }
        }).done((data) => {
            const hasil = $("#hasilLaporan");
            hasil.html("");
            hasil.html(data);
            // console.log(data);
            // let hasilData = JSON.parse(data);
            // console.log(typeof hasilData);
            // hasil.html(hasilData["isiBody"]);
            // console.log(data["laporan"]);  
            // console.log(data);
            loadBarChart(pbln1, pbln2);
        })
    }

    const getDataLaporan = (pbln1, pbln2, email_login, urutan, kelompok, u_subscriber) => {
        $.ajax({
            url: "Controller/get-laporan.php",
            method: "get",
            data: {
                action: "getDataLaporan",
                bln1: pbln1,
                bln2: pbln2,
                email_login: email_login,
                urutan: urutan,
                kelompok: kelompok,
                sub: u_subscriber
            },
            success: function (response){
                // console.log(response);
            }
        }).done((data) => {
            // console.log(data);
            let hasilData = JSON.parse(data);
            // console.log(typeof hasilData);
            // console.log(hasilData[0]["TANGGAL"]);
            // var result = Object.entries(hasilData);
            // console.log(hasilData[0]["TANGGAL"]);
            // console.log(Object.keys(hasilData).length);
            // downloadPdf(hasilData);
            // let dataStr = JSON.stringify(dataArr); // jadiin string spy bisa disimpen
            // console.log(dataStr);
            loadBarChart(pbln1, pbln2);
            localStorage.setItem("laporanKeuangan", data);
            // window.location.href = "./Pages/Application/CetakLaporan.php";
            let win = window.open();
            win.location.href = "./Pages/Application/CetakLaporan.php";
        })
    }

    async function loadBarChart(pbln1, pbln2){
        let barChart = document.getElementById("barChart").getContext("2d");
        let chartStatus1 = Chart.getChart("barChart");
        if (chartStatus1 != undefined) {
            chartStatus1.destroy();
        }
        let listBulan = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        pbln1 = parseInt(pbln1.toString().substr(4, 2));
        pbln2 = parseInt(pbln2.toString().substr(4, 2));
        // console.log(pbln1 + " - " + pbln2);
        let bulan = [];
        let pemasukanPerBulan = [];
        let pengeluaranPerBulan = [];

        let dataPemasukan = [];
        let dataPengeluaran = [];
        for (let i = 1; i <= 12; i++) {
            i = i < 10 ? "0" + i : i;
            let a = (JSON.parse(await getTotalPemasukanByEmail(new Date().getFullYear().toString() + i)));
            dataPemasukan.push(a.subtotal);
            let b = (JSON.parse(await getTotalPengeluaranByEmail(new Date().getFullYear().toString() + i)));
            dataPengeluaran.push(b.subtotal);
        }
        // console.log(dataPemasukan);
        // console.log(dataPengeluaran);

        for (let i = pbln1; i <= pbln2; i++) {
            bulan.push(listBulan[i-1]);
            pemasukanPerBulan.push(dataPemasukan[i-1]);
            pengeluaranPerBulan.push(dataPengeluaran[i-1]);
        }
        localStorage.setItem("bulan", JSON.stringify(bulan));
        localStorage.setItem("pemasukanPerBulan", JSON.stringify(pemasukanPerBulan));
        localStorage.setItem("pengeluaranPerBulan", JSON.stringify(pengeluaranPerBulan));
        // console.log(bulan);

        const data = {
            labels: bulan,
            datasets: [{
                    label: 'Pengeluaran',
                    data: pengeluaranPerBulan,
                    backgroundColor: 'rgba(240, 82, 82, 1)',
                    // borderColor: 'rgb(200, 42, 42)',
                    borderWidth: 1,
                    fontColor: "#000000",
                    hoverBackgroundColor: 'rgb(200, 42, 42)',
                },{
                    label: 'Pemasukan',
                    data: pemasukanPerBulan,
                    backgroundColor: 'rgba(14, 159, 110, 1)',
                    // borderColor: 'rgb(44, 189, 140)',
                    borderWidth: 1,
                    fontColor: "#000000",
                    hoverBackgroundColor: 'rgb(54, 199, 150)',
            }]
        };

        const bgColor = {
            id: 'bgColor',
            beforeDraw: (chart, steps, options) => {
                const { ctx, width, height } = chart;
                ctx.fillStyle = options.backgroundColor;
                ctx.fillRect(0, 0, width, height);
                ctx.restore();
            }
        };

        // config 
        const config = {
            type: 'bar',
            data,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        labels: {
                            color: '#000000'
                        }
                    },
                    bgColor: {
                        backgroundColor: '#F0B86C' //ini buat bg color nya
                    }
                },
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: "#000000"
                        },
                        grid: {
                            color: "#000000"
                        },
                    },
                    x: {
                        beginAtZero: true,
                        ticks: {
                            color: "#000000"
                        },
                        grid: {
                            color: "#000000"
                        }
                    }
                }
            },
            plugins: [bgColor]
        };

        // render init block
        const myChart = new Chart(barChart, config);
    };

    function downloadPdf(dataLaporan){
        const canvas = document.getElementById('barChart');

        // create image
        const canvasImage = canvas.toDataURL('image/jpeg', 1.0);
        // console.log(canvasImage);

        // image ke pdf
        let pdf = new jsPDF('l', 'mm', 'a4', true);
        pdf.setFontSize(20);
        pdf.addImage(canvasImage, 'JPEG', 15, 25, 270, 100); // 2 angka pertama itu margin trus yg 2 terakhir itu width height
        pdf.text(120, 15, "Laporan Keuangan");
        pdf.addPage();
        pdf.setFontSize(16);
        for (let i = 0; i < Object.keys(dataLaporan).length; i++) {
            pdf.text(15, 20 + (i * 15), dataLaporan[i]["TANGGAL"] + " - " + dataLaporan[i]["NOTE"] + " - Rp. " + parseInt(dataLaporan[i]["JUMLAH"]).toLocaleString());
        }
        // let ctr = 1;
        // for (let j = 1; j <= 50; j++){
        //     for (let i = ctr; i <= 50; i++) {
        //         pdf.text(15, 20 + (i * 15), i + ". halo");
        //         if (i % 13 == 0) {
        //             pdf.addPage();
        //             ctr = i;
        //             break;
        //         }
        //     }
        // }
        
        // pdf.text(15, 15, "yesyes\nyesyes");
        // autoTable(doc, {
        //     head: [['Name', 'Email', 'Country']],
        //     body: [
        //         ['David', 'david@example.com', 'Sweden'],
        //         ['Castille', 'castille@example.com', 'Spain'],
        //         // ...
        //     ],
        // })
        window.open(pdf.output('bloburl'), '_blank');
        // pdf.save('myChart.pdf');
    }

    function generatePDF() {
        // var doc = new jsPDF();  //create jsPDF object
        // doc.fromHTML(document.getElementById("hasilLaporan"), // page element which you want to print as PDF
        // 15,
        // 15, 
        // {
        //     'width': 170  //set width
        // },
        // function(a) 
        // {
        //     doc.save("HTML2PDF.pdf"); // save file name as HTML2PDF.pdf
        // });
        // var canvas = document.getElementById("barChart");
        // var win = window.open();
        // window.document.write("<br><img src='" + canvas.toDataURL() + "'/>");
        window.print();
        // win.location.reload();
        // $("ckeditorpdf").val("<div>Halooo</div><p>h</p>")
        // console.log(dataPemasukan);

        // var canvas = document.getElementById("barChart");
        // var win = window.open();
       
        // win.document.write("<br><img src='" + canvas.toDataURL() + "'/>");
        // setTimeout(function(){win.print();}, 1000);

    }

    $(document).ready(()=> {
        loadBarChart(10, 10);
        $('#getLaporan').submit(function (e) { 
            e.preventDefault();
            var pbln1 = document.getElementById("tgl1").value.split("-");
            pbln1 = pbln1[0] + pbln1[1];
            var pbln2 = document.getElementById("tgl2").value.split("-");
            pbln2 = pbln2[0] + pbln2[1];
            var email_login = "<?= $email_login; ?>";
            var order = document.getElementById("urutan").value;
            var kelompok = document.getElementById("kelompok").value;
            
            // console.log(pbln1, pbln2, email_login, urutan, kelompok);
            if (e.originalEvent.submitter == document.getElementById("printLaporan")) {
                // downloadPdf();
                if (document.getElementById("detailContainer").children.length > 0) {
                    getDataLaporan(pbln1, pbln2, email_login, order, kelompok, <?= $u_subscriber ?>);
                }
                else{
                    alert('Preview/Masukkan Data Laporan Terlebih Dahulu');
                }
                // generatePDF();
            }
            else{
                getLaporan(pbln1, pbln2, email_login, order, kelompok, <?= $u_subscriber ?>);
            }
        });

    });
</script>