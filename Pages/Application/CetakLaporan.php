<?php

    if (isset($_COOKIE["user"])) {
        $c = json_decode($_COOKIE["user"], true);
        // var_dump($c["email"]);
    }

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
    <div class="flex flex-col items-center w-full">
        <div class="w-full flex py-3 justify-center text-center text-xl font-bold">Laporan Keuangan</div>
        <div class="w-6/12 2xl:w-4/12 p-2 flex justify-center" id="canvasContainer">
            <canvas id="barChart" aria-label="Hello ARIA World" role="img"></canvas>
        </div>
        <div id="container" class="w-full p-5 justify-center">
            <div class="w-full flex py-3 justify-center text-center text-xl font-bold">Detail</div>
            <div class='rounded-md w-full'>
                <table class='w-full border border-black'>
                    <thead>
                        <tr>
                            <th rowspan="2" class='border border-black'>Tanggal</th>
                            <th rowspan="2" class='border border-black'>Catatan</th>
                            <th colspan="2" class='border border-black'>Jumlah</th>
                        </tr>
                        <tr>
                            <th class='border border-black text-green-500'>Debit</th>
                            <th class='border border-black text-red-500'>Kredit</th>
                        </tr>
                    </thead>
                    <tbody id="bodyTableDetail">
                        <!-- <tr>
                            <td class='border border-black'>0</td>
                            <td class='border border-black'>1</td>
                            <td class='border border-black'>2</td>
                            <td class='border border-black'>3</td>
                        </tr> -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
    <script>

        function loadChart(){
            let bulan = localStorage.getItem("bulan");
            bulan = JSON.parse(bulan);
            let pemasukanPerBulan = localStorage.getItem("pemasukanPerBulan");
            pemasukanPerBulan = JSON.parse(pemasukanPerBulan);
            let pengeluaranPerBulan = localStorage.getItem("pengeluaranPerBulan");
            pengeluaranPerBulan = JSON.parse(pengeluaranPerBulan);
            // console.log(bulan);
            // console.log(pemasukanPerBulan);
            // console.log(pengeluaranPerBulan);
            localStorage.removeItem('bulan');
            localStorage.removeItem('pemasukanPerBulan');
            localStorage.removeItem('pengeluaranPerBulan');

            let barChart = document.getElementById("barChart").getContext("2d");
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
        }


        $(document).ready(function() {
            let data = localStorage.getItem("laporanKeuangan");
            dataArr = JSON.parse(data);
            localStorage.removeItem('laporanKeuangan');
            
            var isi = "";
            let total = 0;
            let div = $("<div class='w-full'></div>");
            // for (let i = 0; i < dataArr.length; i++) {
            //     if (dataArr[i]["p"] == 0 || dataArr[i]["p"] == "0") {
            //         isi = $(`<div class='border-4 border-gray-300 text-green-500 w-full rounded-lg p-2 my-1.5 flex justify-between text-lg'>
            //                         <div>${dataArr[i]["TANGGAL"]} - ${dataArr[i]["NOTE"]}</div>
            //                         <div>Rp. ${dataArr[i]["JUMLAH"].toLocaleString()}</div>
            //                     </div>`);
            //                     // <div class='w-10/12'>${dataArr[i]["TANGGAL"]} - ${dataArr[i]["NOTE"]}</div>
            //                     // <div class='text-left w-2/12'>Rp. ${dataArr[i]["JUMLAH"].toLocaleString()}</div>
            //         total += dataArr[i]["JUMLAH"];
            //     }
            //     else{
            //         isi = $(`<div class='border-4 border-gray-300 text-red-500 w-full rounded-lg p-2 my-1.5 flex justify-between text-lg'>
            //                         <div>${dataArr[i]["TANGGAL"]} - ${dataArr[i]["NOTE"]}</div>
            //                         <div>Rp. ${dataArr[i]["JUMLAH"].toLocaleString()}</div>
            //                     </div>`);
            //         total -= dataArr[i]["JUMLAH"];
            //     }
            //     div.append(isi);
            // }

            // ========== INI PAKE TABEL ==============
            // let tr = $(`<tr></tr>`);
            for (let i = 0; i < dataArr.length; i++){
                if (dataArr[i]["p"] == 0 || dataArr[i]["p"] == "0"){
                    isi = $(`<tr><td class='border border-black px-2'>${dataArr[i]["TANGGAL"]}</td><td class='border border-black px-2'>${dataArr[i]["NOTE"]}</td><td class='border border-black text-green-500 px-2'>Rp. ${dataArr[i]["JUMLAH"].toLocaleString()}</td><td class='border border-black'></td></tr>`);
                    total += dataArr[i]["JUMLAH"];
                }
                else{
                    isi = $(`<tr><td class='border border-black px-2'>${dataArr[i]["TANGGAL"]}</td><td class='border border-black px-2'>${dataArr[i]["NOTE"]}</td><td class='border border-black'></td><td class='border border-black text-red-500 px-2'>Rp. ${dataArr[i]["JUMLAH"].toLocaleString()}</td></tr>`);
                    total -= dataArr[i]["JUMLAH"];
                }
                $("#bodyTableDetail").append(isi);
            }
            // $("#bodyTableDetail").append(tr);

            let divTotal = `<br><div class='w-full flex justify-center items-center text-xl font-bold'>
            <div class='flex'>
            <div>Total</div>
            <div class='text-green-500'>&nbsp;Pemasukan </div>
            <div>&nbsp;/</div>
            <div class='text-red-500'>&nbsp;Pengeluaran</div>
            <div>&nbsp;:&nbsp;</div>
            </div>`;
            if (total > 0) {
                divTotal += `<div class='text-green-500'>Rp. ${total.toLocaleString()}</div></div>`;
            }
            else if(total < 0){
                divTotal += `<div class='text-red-500'>Rp. ${(total * -1).toLocaleString()}</div></div>`;
            }
            else{
                divTotal += `<div class='text-black>Rp. ${total.toLocaleString()}</div></div>`;
            }
            div.append(divTotal);
            $("#container").append(div);
            // console.log(div);
            let role = '<?= $c["status"] ?>';
            // console.log(role);
            if (role == '2') {
                loadChart();
            }
            else{
                $("#canvasContainer").remove();
                // $("#canvasContainer").removeClass("p-5");
            }
            setTimeout(function(){window.print();}, 1000);
        });

    </script>
</body>
</html>