async function loadDashboardBulanIni(){
    let month = (new Date().getMonth()+1).toString();

    month = month.length == 1 ? "0"+month : month;

    let masuk = await getTotalPemasukanByEmail(new Date().getFullYear().toString()+month);
    masuk = JSON.parse(masuk,true)["subtotal"];
    if(masuk == null){
        masuk = 0;
    }
    masuk = parseInt(masuk);
    chartMasuk = masuk;

    let keluar = await getTotalPengeluaranByEmail(new Date().getFullYear().toString()+month);
    keluar = JSON.parse(keluar,true)["subtotal"];
    if(keluar == null){
        keluar = 0;
    }
    keluar = parseInt(keluar);
    chartKeluar = keluar;

    let selisih = masuk - keluar;
    
    masuk = masuk.toLocaleString();
    keluar = keluar.toLocaleString();

    $("#dashboard-pemasukanTotal").text("Rp"+masuk);
    $("#dashboard-pengeluaranTotal").text("Rp"+keluar);
    
    $("#dashboard-selisihTotal").removeClass();
    $("#dashboard-selisihTotal").addClass("font-bold");
    if(selisih < 0){
        $("#dashboard-selisihTotal").addClass("text-red-500");

    }else if(selisih > 0){
        $("#dashboard-selisihTotal").addClass("text-green-500");
    }
    selisih = selisih.toLocaleString();
    
    $("#dashboard-selisihTotal").text("Total : Rp"+selisih);

    var kelompok = [];
    // let p = (JSON.parse(await getMonthlyPemasukanByEmailKelompok(new Date().getFullYear().toString()+month)))["total"];
    // kelompok.push(p);
    for (let i = 1; i <= 4; i++) {
        let p = (JSON.parse(await getMonthlyPengeluaranByEmailKelompok(new Date().getFullYear().toString()+month, i)))["total"];
        kelompok.push(p);
    }
    loadPieChart(kelompok);

    var dataPemasukan = [];
    var dataPengeluaran = [];
    for (let i = 1; i <= new Date().getMonth()+1; i++) {
        i = i < 10 ? "0" + i : i;
        let a = (JSON.parse(await getTotalPemasukanByEmail(new Date().getFullYear().toString() + i)));
        dataPemasukan.push(a.subtotal);
        let b = (JSON.parse(await getTotalPengeluaranByEmail(new Date().getFullYear().toString() + i)));
        dataPengeluaran.push(b.subtotal);
    }
    loadLineChart(dataPemasukan, dataPengeluaran);
}

async function loadPieChart(kelompok){
    let pieChartPerbandingan = document.getElementById("pieChartPerbandingan").getContext("2d");
    let chartStatus1 = Chart.getChart("pieChartPerbandingan");
    if (chartStatus1 != undefined) {
        chartStatus1.destroy();
    }

    let pieChart = new Chart(pieChartPerbandingan, {
        type: "pie",
        data: {
            labels: ["Kebutuhan", "Keinginan", "Investasi/Tabungan", "Sedekah"],
            // fontColor: "#ffffff",
            datasets: [{
                label: "Keuangan",
                data: kelompok,
                // backgroundColor: "green"
                backgroundColor: [
                    // "rgb(14, 159, 110)",
                    "rgba(251, 146, 60, 1)",
                    "rgba(34, 211, 238, 1)",
                    "rgba(168, 85, 247, 1)",
                    "rgba(253, 224, 71, 1)",
                ],
                borderWidth: 2,
                fontColor: "#ffffff",
                // borderColor: "rgb(50, 60, 70)",
                hoverBorderWidth: 4,
                hoverBorderColor: [
                    // "rgb(34, 179, 130)",
                    "rgb(240, 82, 82)",
                    "rgb(240, 82, 82)",
                    "rgb(240, 82, 82)",
                    "rgb(240, 82, 82)",
                ],
                hoverOffset: 10
            }]
        },
        options: {
            layout: {
                padding: {
                    bottom: 15
                }
            },
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    labels: {
                        color: '#ffffff'
                    }
                },
                title: {
                    display: true,
                    text: 'Rasio Pengeluaran',
                    color: '#ffffff',
                    font : {
                        size: 20
                    }
                }
                // dataLabels: {
                //     formatter: (value, context) => {
                //         return value;
                //     }
                // }
            },
            maintainAspectRatio: false
        },
        // plugins: [ChartDataLabels]
    });
}

async function loadLineChart(dataPemasukan, dataPengeluaran){
    let myChart = document.getElementById("lineChartGrowth").getContext("2d");
    let chartStatus2 = Chart.getChart("lineChartGrowth");
    if (chartStatus2 != undefined) {
        chartStatus2.destroy();
    }
    // console.log(dataPemasukan);
    // console.log(dataPengeluaran);

    let delayed;
    var labels = [
        "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"
    ];

    // gradient
    let gradient = myChart.createLinearGradient(0,0,0,400);
    gradient.addColorStop(0, "rgba(14, 159, 110, 1)");
    gradient.addColorStop(1, "rgba(14, 159, 110, 0.1)");

    let gradient2 = myChart.createLinearGradient(0,0,0,400);
    gradient2.addColorStop(0, "rgba(240, 82, 82, 1)");
    gradient2.addColorStop(1, "rgba(240, 82, 82, 0.1)");

    var data = {
        labels,
        fontColor: "#ffffff",
        datasets: [{
            data: dataPemasukan,
            label: "Pemasukan",
            fill: true,
            backgroundColor: gradient,
            borderColor: "rgb(14, 119, 70)",
            pointBackgroundColor: "rgb(14, 119, 70)",
            tension: 0.2,
            fontColor: "#ffffff",
        },{
            data: dataPengeluaran,
            label: "Pengeluaran",
            fill: true,
            backgroundColor: gradient2,
            borderColor: "rgb(200, 42, 42)",
            pointBackgroundColor: "rgb(200, 42, 42)",
            tension: 0.2,
            fontColor: "#ffffff"
        }]
    }

    var config = {
        type: "line",
        data: data,
        options: {
            radius: 5, // ini radius lingkaran point tiap titiknya
            hitRadius: 20, // ini supaya waktu di hover di pointnya, gausa bener2 di point, jd dibesarin radiusnya
            hoverRadius: 10,
            responsive: true,
            animation:{
                onComplete: () => {
                    delayed = true;
                },
                delay: (context) => {
                    let delay = 0;
                    if (context.type === "data" && context.mode === "default" && !delayed) {
                        delay = context.dataIndex * 300 + context.datasetIndex * 100;
                    }
                    return delay;
                }
            },
            scales: {
                y: {
                    ticks: {
                        color: "#ffffff",
                        callback: function (value){
                            return "Rp. " + value.toLocaleString();
                        }
                    },
                    grid: {
                        color: "#FFFFFF"
                    },
                }, 
                x: {
                    ticks: {
                        color: "#ffffff",
                    },
                    grid: {
                        color: "#FFFFFF"
                    },
                }
            },
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    labels: {
                        color: '#ffffff'
                    }
                },
                // dataLabels: {
                //     formatter: (value, context) => {
                //         return value;
                //     }
                // }
            },
                maintainAspectRatio: false
            }
    }

    var chart = new Chart(myChart, config);
}

function loadPemasukanTerbesarBulanIni(){
    let month = (new Date().getMonth()+1).toString();

    $.ajax({
        url:"Controller/uang.php",
        method:"post",
        data:{
            action:"getMostPemasukanByEmail",
            email:$("#emailUser").text(),
            month:month,
        }
    }).done(d => {
        let data = JSON.parse(d,true);
        $("#dashboard-pemasukanTerbesar").empty();
        if(data.length == 0){
            $("#dashboard-pemasukanTerbesar").text("Tidak ada pendapatan!");
        }else{
            let ctr = 0;
            data.forEach(el => {
                if(ctr < 2){
                    let nama = el["nama"];
                    let jumlah = parseInt(el["jumlah"]).toLocaleString();
                    let em = $(`<div>
                    <span class="text-xs md:text-base font-bold">${nama}</span>
                    <br>
                    <span class="text-xs md:text-sm italic">Rp${jumlah}</span></div>`);
                    $("#dashboard-pemasukanTerbesar").append(em);
                    ctr++;
                }
            });
        }
    })
}

function loadPengeluaranTerbesarBulanIni(){
    let month = (new Date().getMonth()+1).toString();

    $.ajax({
        url:"Controller/uang.php",
        method:"post",
        data:{
            action:"getMostPengeluaranByEmail",
            email:$("#emailUser").text(),
            month:month,
        }
    }).done(d => {
        let ctr = 0;
        let data = JSON.parse(d,true);
        $("#dashboard-pengeluaranTerbesar").empty();
        if(data.length == 0){
            $("#dashboard-pengeluaranTerbesar").text("Tidak ada pendapatan!");
        }else{
            data.forEach(el => {
                if(ctr >= 2){
                    return
                };
                ctr++;
                let nama = el["nama"];
                let jumlah = parseInt(el["jumlah"]).toLocaleString();
                let em = $(`<div>
                <span class="text-xs md:text-base font-bold">${nama}</span>
                <br>
                <span class="text-xs md:text-sm italic">Rp${jumlah}</span></div>`);
                $("#dashboard-pengeluaranTerbesar").append(em);
            });
        }
    })
}

function loadPengeluaranBerlebihan(){
    $.ajax({
        url:"Controller/uang.php",
        method:"post",
        data:{
            action:"getLimitByEmail",
            email:$("#emailUser").text(),
        }
    }).done(d => {
        let data = JSON.parse(d,true);
        $("#dashboard-pengeluaranBerlebihan").empty();
        if(data.length == 0){
            $("#dashboard-pengeluaranBerlebihan").text("Tidak ada limit pengeluaran!")
        }else{
            let pengeluaran = parseInt(data[0]["pengeluaran"]);
            let limitTotal = parseInt(data[0]["jumlah_limit"]);
            let nama = data[0]["nama"];
            let percent = parseInt((pengeluaran/limitTotal)*100);
            let barwidth = percent;
            if(barwidth > 100){
                barwidth = 100;
            }
            let barColor = "bg-green-600";

            if(percent >= 75){
                barColor = "bg-red-600";
            }else if(percent >= 50){
                barColor = "bg-yellow-400";
            }

            let bar = $(`<div class="w-full flex flex-col items-center justify-center">
            <span class="mb-2 text-2xs md:text-sm">${nama}</span>
            <div class="w-full bg-gray-200 rounded-full">
                <div class="${barColor} text-2xs md:text-xs font-medium rounded-full text-blue-100 text-center p-0.5 leading-none rounded-l-full" style="width:${barwidth}%">${percent}%</div>
            </div>
            <span class="text-2xs md:text-xs mt-2">Rp${pengeluaran.toLocaleString()} / Rp${limitTotal.toLocaleString()}</span>
            </div>`);
            $("#dashboard-pengeluaranBerlebihan").append(bar);
        }
    });
}

async function loadSkorKeuanganDashboard(){
    let skors = await calculateSkorKeuangan();
    let sumSkors = skors.map(function(x) {
        if(x < 0){
            return 0;
        }else{
            return x;
        }
    })
    let totalSkor = sumSkors.reduce((a,b) => a+b,0);
    if(totalSkor < 0) {totalSkor = 0};
    $("#dashboard-skorKeuangan").text(totalSkor+"/100");
}

jQuery.fn.scrollTo = function(elem, speed) { 
    $(this).animate({
        scrollTop:  $(this).scrollTop() - $(this).offset().top + $(elem).offset().top 
    }, speed == undefined ? 1000 : speed); 
    return this; 
};

function pengeluaranBerlebihan(){
    showPage(1);
    $("#keuangan").scrollTo("#keuangan-limitKeuanganModule");
}

function skorKeuangan(){
    showPage(1);
    $("#keuangan").scrollTo("#keuangan-skorKeuanganModule");
}

function loadDashboard(){
    loadDashboardBulanIni();
    loadPemasukanTerbesarBulanIni();
    loadPengeluaranTerbesarBulanIni();
    loadPengeluaranBerlebihan();
    loadSkorKeuanganDashboard();
}

loadDashboard();

// window.addEventListener("resize", () => {
//     let pieChartPerbandingan = document.getElementById("pieChartPerbandingan");
//     pieChartPerbandingan.setSize(window.innerWidth, window.innerHeight);
//     // cam.aspect = window.innerWidth / window.innerHeight;
//     // cam.updateProjectionMatrix();
// });