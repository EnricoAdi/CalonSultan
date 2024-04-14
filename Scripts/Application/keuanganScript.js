$(document).ready(function() {
    $("#kategoriSelectPengeluaran").select2({
        width:'resolve',
        placeholder: "Pilih kategori",
        allowClear: true,
    });
    $("#kategoriSelectPendapatan").select2({
        width:'resolve',
        placeholder: "Pilih kategori",
        allowClear: true,
    });
    $("#kategoriSelectLimit").select2({
        width:'resolve',
        placeholder: "Pilih kategori",
        allowClear: true,
    })
    inputModalMasuk = new AutoNumeric("#inputPendapatan",{
        minimumValue : "0",
    });
    inputModalKeluar = new AutoNumeric("#inputPengeluaran",{
        minimumValue : "0",
    });
    inputModalLimitText = new AutoNumeric("#inputLimit",{
        minimumValue : "0",
    });
    inputModalEditLimit = new AutoNumeric("#keuangan-editLimitNominal",{
        minimumValue : "0",
    });
})

var inputModalMasuk;
var inputModalKeluar;
var inputModalLimitText;
var inputModalEditLimit;

function inputModalPendapatan(e){
    e.preventDefault();
    let frm = $(e.target).serializeArray();
    $.ajax({
        url:"Controller/uang.php",
        method:"post",
        data:{
            action:"inputPendapatan",
            email:$("#emailUser").text(),
            formData:frm
        }
    }).done(d => {
        loadKeuangan();
        closeModalPemasukan();
    });
}

let modalSimulasi = new Modal($("#modal-simulasi")[0]);
async function keuanganSimulasi(e){
    e.preventDefault();
    let frm = $(e.target).serializeArray();
    let month = (new Date().getMonth()+1).toString();
    month = month.length == 1 ? "0"+month : month;

    let masuk = await getTotalPemasukanByEmail(new Date().getFullYear().toString()+month);
    masuk = JSON.parse(masuk,true)["subtotal"];
    masuk = parseInt(masuk)

    let textSimulasi = $("select[name='modalSimulasiRasio'] option:selected").text();
    let valSimulasi = $("select[name='modalSimulasiRasio'] option:selected").val();

    let rasio = textSimulasi.split("/").map(function(n) {
        return parseInt(n);
    });
    // console.log(rasio);
    let namaRasio = [];
    let colorRasio = ["text-blue-500","text-green-500","text-red-400","text-purple-500"];

    if(valSimulasi == "rasioA"){
        namaRasio.push("Sedekah");
        namaRasio.push("Tabungan");
        namaRasio.push("Cicilan");
        namaRasio.push("Kebutuhan");
    }else if(valSimulasi == "rasioB"){
        namaRasio.push("Kebutuhan");
        namaRasio.push("Keinginan");
        namaRasio.push("Tabungan");
    }else if(valSimulasi == "rasioC"){
        namaRasio.push("Kebutuhan");
        namaRasio.push("Tabungan");
        namaRasio.push("Keinginan");
    }
    
    //Isi tempat simulasi-Chart adalah pie chart. Ubah ini. (Untuk Michael Kevin)
    // $("#simulasi-Chart");
    let pieChartSimulasi = document.getElementById("pieChartSimulasi").getContext("2d");
    let statusChartSimulasi = Chart.getChart("pieChartSimulasi");
    if (statusChartSimulasi != undefined) {
        statusChartSimulasi.destroy();
    }

    let hasilKalkulasi = [];

    for (let i = 0; i < rasio.length; i++) {
        hasilKalkulasi.push(masuk*rasio[i]/100);
    }

    let pieChart = new Chart(pieChartSimulasi, {
        type: "pie",
        data: {
            labels: namaRasio,
            // fontColor: "#ffffff",
            datasets: [{
                label: "Keuangan",
                data: hasilKalkulasi,
                // backgroundColor: "green"
                backgroundColor: [
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
    //

    $("#modalSimulasiContent").empty();
    $("#modalSimulasiJudul").text(textSimulasi);
    $("#modalSimulasiTotalPemasukan").text("Rp"+masuk.toLocaleString());

    for (let i = 0; i < rasio.length; i++) {
        let color = colorRasio[i];
        let nama = namaRasio[i];

        let content = $(`<div>
                            <span class="font-bold ${color}">${nama}</span> (<span class="italic">${rasio[i]}%</span>)
                        </div>
                        <div class="italic mb-2">
                            Rp${(masuk*rasio[i]/100).toLocaleString()}
                        </div>`);
        $("#modalSimulasiContent").append(content);
    }

    modalSimulasi.show();
}
let xxx;
let modalBerlebihan = new Modal($("#modal-confirmPengeluaran")[0]);
function inputModalPengeluaran(e){
    e.preventDefault();

    let month = (new Date().getMonth()+1).toString();
    month = month.length == 1 ? "0"+month : month;

    let frm = $(e.target).serializeArray();
    $.ajax({
        url:"Controller/uang.php",
        method:"post",
        data:{
            action:"getLimitByEmail",
            email:$("#emailUser").text(),
            kategori:frm[1]["value"],
        }
    }).done(d => {
        let kategoriInput = frm[1]["value"];
        let data = JSON.parse(d,true);
        
        let limit;
        data.forEach(el => {
            if(el["id_kategori"] == kategoriInput){
                let limitTotal = parseInt(el["jumlah_limit"]);
                let pengeluaranTotal = parseInt(el["pengeluaran"]);
                let inpPengeluaran = parseInt((frm[2]["value"]).replace(new RegExp(",","g"),""));
                if(pengeluaranTotal + inpPengeluaran >= limitTotal){
                    limit = el;
                }
            }
        });

        if(limit == null){
            insertPengeluaran(frm);
        }else{
            $("#kategoriBerlebihan").text(limit["nama"]);
            closeModalPengeluaran(0);
            let bar = getLimitBar(limit,"noButton");
            $("#barBerlebihan").empty();

            $("#InputBerlebihanNama").val(frm[0]["value"]);
            $("#InputBerlebihanKategori").val(frm[1]["value"]);
            $("#InputBerlebihanNominal").val(frm[2]["value"]);
            $("#barBerlebihan").append(bar);

            modalBerlebihan.show();
        }
    })

    // insertPengeluaran(frm);
}

function insertBerlebihan(e){
    e.preventDefault();
    let frm = $(e.target).serializeArray();
    modalBerlebihan.hide();
    insertPengeluaran(frm,0);
}

function insertPengeluaran(frm, closeModal = -1){
    $.ajax({
        url:"Controller/uang.php",
        method:"post",
        data:{
            action:"inputPengeluaran",
            email:$("#emailUser").text(),
            formData:frm
        }
    }).done(d => {
        loadKeuangan();
        if(closeModal == -1){
            closeModalPengeluaran();
        }else if(closeModal == 0){
            $("#formInputPengeluaran :input[name='inputPengeluaranNama']").val("");
            // $("#formInputPengeluaran :input[name='inputPengeluaranKategori']").val("");
            $("#formInputPengeluaran :input[name='inputPengeluaranNominal']").val("");
            $("#kategoriSelectPengeluaran").val('').trigger('change')
            inputModalKeluar.clear();
        }
    })
}

function inputModalLimit(e){
    e.preventDefault();
    let frm = $(e.target).serializeArray();
    $.ajax({
        url:"Controller/uang.php",
        method:"post",
        data:{
            action:"inputLimit",
            email:$("#emailUser").text(),
            formData:frm
        }
    }).done(d => {
        if(d >= 1){
            alert("Limit sudah ada, harap gunakan edit!")
        }else{
            loadKeuangan();
        }
        closeModalLimit();
    })
}

function closeModalPemasukan(){
    $("#formInputPendapatan :input[name='inputPendapatanNama']").val("")
    // $("#formInputPendapatan :input[name='inputPendapatanKategori']").val("")
    $("#kategoriSelectPendapatan").val('').trigger('change')
    $("#formInputPendapatan :input[name='inputPendapatanNominal']").val("")

    inputModalMasuk.clear();

    $("#btnKembaliModalInputPendapatan").click();
}

function closeModalConfirmPengeluaran(){
    $("#barBerlebihan").empty();
    $("#kategoriBerlebihan").text("Getting data...");

    modalBerlebihan.hide();
    closeModalPengeluaran(0);
}

function closeModalPengeluaran(mode = -1){
    if(mode == -1){
        $("#formInputPengeluaran :input[name='inputPengeluaranNama']").val("");
        // $("#formInputPengeluaran :input[name='inputPengeluaranKategori']").val("");
        $("#formInputPengeluaran :input[name='inputPengeluaranNominal']").val("");
        $("#kategoriSelectPengeluaran").val('').trigger('change')
        inputModalKeluar.clear();
    }
    $("#btnKembaliModalInputPengeluaran").click();
}

function closeModalEditLimit(){
    $("#modal-editLimit").find(":input[name='keuangan-editLimitId']").val("");
    $("#modal-editLimit").find(":input[name='keuangan-editLimitNominal']").val("");
    inputModalEditLimit.clear();
    modalEdit.hide();
}

function closeModalLimit(){
    $("#formInputLimit :input[name='inputLimitKategori']").val("");
    $("#formInputLimit :input[name='inputLimitNominal']").val("");
    inputModalLimitText.clear();

    $("#btnKembaliModalInputLimit").click();
}

function closeModalDeleteLimit(){
    $("#modal-deleteLimit").find(":input[name='keuangan-deleteLimitId']").val("");
    $("#namaModalDeleteLimit").text("{Loading...}");
    modalDelete.hide();
}

function closeModalSimulasi(){
    $("#modalSimulasiJudul").text("Loading...");
    $("#modalSimulasiContent").text("Loading...");
    // $("#simulasi-Chart").text("Loading Pie Chart...");
    // $("#simulasi-Chart").append("<canvas id='pieChartSimulasi' class='w-full h-full' width='100' height='100'></canvas>");

    modalSimulasi.hide();
}

function closeModalDetailSkor(){
    $("#modal-detailSkorJudul").text("Loading rasio type...");
    $("#modalDetailSkorContent").text("Getting data...")
    $("#modalDetailSkor").text("...");
    $("#modalDetailSkorSaran").text("Loading...")
    modalDetailSkor.hide();   
}

function loadPortofolioPendapatan(){
    $.ajax({
        url:"Controller/uang.php",
        method:"post",
        data:{
            action:"getPemasukanTotalKategoriByEmail",
            email:$("#emailUser").text()
        }
    }).done(d => {
        let data = JSON.parse(d,true);
        let porto = $("#keuangan-portofolioPemasukan");
        let porto_total = $("#keuangan-portofolioPemasukanTotal");
        let total = 0;

        porto.empty();
        porto_total.empty();
        if(data.length == 0){
            porto.text("Portofolio Pemasukan Kosong. Yuk isi pemasukan!");
            porto_total.text("Rp0");   
        }else{
            data.forEach(el => {
                let nama = el["nama"];
                let jumlah = el["jumlah"];
                total += parseInt(jumlah);

                let grid = $(`<div class="grid grid-cols-2">
                <div>${nama}</div>
                <div>Rp${parseInt(jumlah).toLocaleString()}</div>
                </div>`);

                porto.append(grid);
            });
            porto_total.text("Rp"+total.toLocaleString());
        }
    });
}

function loadPortofolioPengeluaran(){
    let keinginan;
    let kebutuhan;
    let tabungan;
    let sedekah;

    let portoKeinginan = $("#keuangan-portofolioPengeluaranKeinginan");
    let portoKebutuhan = $("#keuangan-portofolioPengeluaranKebutuhan");
    let portoTabungan = $("#keuangan-portofolioPengeluaranTabungan");
    let portoSedekah = $("#keuangan-portofolioPengeluaranSedekah");
    let portofolioTotal = $("#keuangan-portofolioTotal");


    portoKeinginan.empty();
    portoKebutuhan.empty();
    portoTabungan.empty();
    portoSedekah.empty();

    $.ajax({
        url:"Controller/uang.php",
        method:"post",
        data:{
            action:"getPengeluaranByEmailKelompok",
            email:$("#emailUser").text(),
            kelompok:"1"
        }
    }).done(d => {
        kebutuhan = JSON.parse(d,true);
        // namaKategori
        let total = 0;
        if(kebutuhan.length == 0){
            portoKebutuhan.text("Pengeluaran kosong nih!")
        }else{
            kebutuhan.forEach(el => {
                let namaKategori = el["namaKategori"];
                let nominal = parseInt(el.jumlah).toLocaleString();
                total += parseInt(el.jumlah);
    
                let grid = $(`<div class="grid grid-cols-2">
                <div class="">${namaKategori}</div>
                <div class="italic">Rp${nominal}</div>
                </div>`);
                portoKebutuhan.append(grid);
            });
        }
        $("#keuangan-portofolioPengeluaranKebutuhanTotal").text("Rp"+total.toLocaleString());
    });

    $.ajax({
        url:"Controller/uang.php",
        method:"post",
        data:{
            action:"getPengeluaranByEmailKelompok",
            email:$("#emailUser").text(),
            kelompok:"2"
        }
    }).done(d => {
        keinginan = JSON.parse(d,true);
        let total = 0;
        if(keinginan.length == 0){
            portoKeinginan.text("Pengeluaran kosong nih!");
        }else{
            keinginan.forEach(el => {
                let namaKategori = el["namaKategori"];
                let nominal = parseInt(el.jumlah).toLocaleString();
                total += parseInt(el.jumlah);
    
                let grid = $(`<div class="grid grid-cols-2">
                <div class="">${namaKategori}</div>
                <div class="italic">Rp${nominal}</div>
                </div>`);
                portoKeinginan.append(grid);
            });
        }
        $("#keuangan-portofolioPengeluaranKeinginanTotal").text("Rp"+total.toLocaleString());
    });

    $.ajax({
        url:"Controller/uang.php",
        method:"post",
        data:{
            action:"getPengeluaranByEmailKelompok",
            email:$("#emailUser").text(),
            kelompok:"3"
        }
    }).done(d => {
        tabungan = JSON.parse(d,true);
        let total = 0;
        if(tabungan.length == 0){
            portoTabungan.text("Pengeluaran kosong nih!");
        }else{
            tabungan.forEach(el => {
                let namaKategori = el["namaKategori"];
                let nominal = parseInt(el.jumlah).toLocaleString();
                total += parseInt(el.jumlah);
    
                let grid = $(`<div class="grid grid-cols-2">
                <div class="">${namaKategori}</div>
                <div class="italic">Rp${nominal}</div>
                </div>`);
                portoTabungan.append(grid);
            });
        }
        $("#keuangan-portofolioPengeluaranTabunganTotal").text("Rp"+total.toLocaleString());
    });

    $.ajax({
        url:"Controller/uang.php",
        method:"post",
        data:{
            action:"getPengeluaranByEmailKelompok",
            email:$("#emailUser").text(),
            kelompok:"4"
        }
    }).done(d => {
        sedekah = JSON.parse(d,true);
        let total = 0;
        if(sedekah.length == 0){
            portoSedekah.text("Pengeluaran kosong nih!");
        }else{
            sedekah.forEach(el => {
                let namaKategori = el["namaKategori"];
                let nominal = parseInt(el.jumlah).toLocaleString();
                total += parseInt(el.jumlah);
    
                let grid = $(`<div class="grid grid-cols-2">
                <div class="">${namaKategori}</div>
                <div class="italic">Rp${nominal}</div>
                </div>`);
                portoSedekah.append(grid);
            });
        }
        $("#keuangan-portofolioPengeluaranSedekahTotal").text("Rp"+total.toLocaleString());
    });

    $.ajax({
        url:"Controller/uang.php",
        method:"post",
        data:{
            action:"getTotalPengeluaranByEmail",
            email:$("#emailUser").text(),
        }
    }).done(d => {
        let data = JSON.parse(d)["subtotal"];
        portofolioTotal.text("Rp"+parseInt(data).toLocaleString());
    });

}

async function loadSkorKeuanganKeuangan(){
    let skors = await calculateSkorKeuangan();
    let totalSkor = skors.map(function(x) {
        if(parseInt(x) <= 0){
            return 0;
        }else{
            return parseInt(x);
        }
    });
    totalSkor = totalSkor.reduce((a,b) => a+b,0);
    if(totalSkor < 0) {totalSkor = 0};

    $("#keuangan-skorKeuangan").text(totalSkor+"/100");
    skors = skors.map(function (x) { 
        return parseInt(x, 10); 
      });

    $("#keuangan-detailSkorKeuangan").empty();

    let user_subscribe = JSON.parse(await getuserRole(),true)["status"];
    let onclickEvent;
    if(user_subscribe == 1){
        onclickEvent = '';
    }else if(user_subscribe == 2){
        onclickEvent = 'readDetailSkorKeuangan(event)';
    }

    for (let i = 0; i < skors.length; i++) {
        // console.log(skors[i]);
        // console.log(maxSkorArr[i]);
        // console.log(skors[i] - maxSkorArr[i]);
        // console.log("============")
        let judul = i == 0 ? 'Rasio total pengeluaran dengan total pemasukan' : i == 1 ? 'Rasio total pengeluaran kebutuhan dengan total pengeluaran' : i == 2 ? 'Rasio pengeluaran keinginan dengan pengeluaran kebutuhan' : 'Rasio pengeluaran tabungan dengan pengeluaran total';

        let el = $(
        `<div class="bg-slate-600 p-4 rounded-lg mb-3 shadow-lg">
            <div class="flex justify-between items-center">
                <div>
                    <div class="text-sm md:text-base font-bold">${judul}</div>
                        <button idx='${i}' judul='${judul}' skor='${skors[i]}' class="text-white text-xs cursor-pointer inline italic" onclick="${onclickEvent}">Read more</button>
                </div>
                <div class="${skors[i] - maxSkorArr[i] == 0 ? 'text-green-500' : skors[i] < 0 ? 'text-white' : 'text-red-500'} text-2xl font-bold">
                    ${skors[i] - maxSkorArr[i] == 0 ? '+'+maxSkorArr[i] : skors[i] <= -1 ? 0 :skors[i] - maxSkorArr[i]}
                </div>
            </div>
        </div>`);
        $("#keuangan-detailSkorKeuangan").append(el);
    }

}

let modalDetailSkor = new Modal($("#modal-detailSkor")[0]);
async function readDetailSkorKeuangan(e){
    // [pemasukanTotal, pengeluaranTotal, pengeluaranKebutuhan, pengeluaranKeinginan, pengeluaranTabungan, pengeluaranSedekah]
    let dataKeuangan = await getDataKeuangan();
    let btn = $(e.target);
    let idx = parseInt(btn.attr("idx"));
    let skor = btn.attr("skor");
    if(parseInt(skor) < 0) {skor = 0};

    $("#modal-detailSkorJudul").text(btn.attr("judul"));

    let element;
    let saran;

    $("#modalDetailSkor").text(skor+"/"+maxSkorArr[idx]);
    $("#modalDetailSkorContent").empty();
    $("#modalDetailSkorSaran").empty();
    if(idx == 0){
        saran = $(`<div class='italic'>Pengeluaran yang ideal selalu <span class='font-bold'> di bawah total pemasukan.</span> Apabila jumlah pengeluaran mencapai <span class='font-bold'>2x lipat dari total pemasukan</span> maka anda harus mengatur ulang pengeluaran anda</div>`);
        if(skor == -1){
            element = $(`<div>Rasio tidak ditemukan, pengeluaran kosong!</div>`);
        }else{
            let color = "text-white";
            if(dataKeuangan[0] - dataKeuangan[1] > 0){
                color = "text-green-500";
            }else if(dataKeuangan[0] - dataKeuangan[1] < 0){
                color="text-red-500";
            }
            element = $(`
                <div>
                    <div>Pemasukan Total : <span class='italic text-green-500 font-bold'>Rp${dataKeuangan[0].toLocaleString()}</span></div>
                    <div>Pengeluaran Total : <span class='italic text-red-500 font-bold'>Rp${dataKeuangan[1].toLocaleString()}</span></div>
                    <div>Selisih : <span class='${color} italic font-bold'>Rp${(dataKeuangan[0] - dataKeuangan[1]).toLocaleString()}</span></div>
                </div>
            `);
        }
    }else if(idx == 1){
        saran = $(`<div class='italic'>Pengeluaran kebutuhan yang baik selalu <span class='font-bold'>di bawah 60% dari total seluruh pengeluaran.</span> Apabila Anda mendapati bahwa rasio pengeluaran kebutuhan anda diatas 60% maka Anda harus memikirkan kembali mengenai pengeluaran kebutuhan yang <span class='font-bold'> harus dipotong.</span></div>`);
        if(skor == -1){
            element = $(`<div>Rasio tidak ditemukan, pengeluaran kebutuhan kosong!</div>`);
        }else{
            let rasio = parseInt(dataKeuangan[2]/dataKeuangan[1]*100);
            let color = "text-green-500";
            if(rasio > 60){
                color = "text-red-500";
            }

            element = $(`
            <div>
                <div>Pengeluaran Total : <span class='italic text-red-500 font-bold'>Rp${dataKeuangan[1].toLocaleString()}</span></div>
                <div>Pengeluaran Kebutuhan Total : <span class='italic text-red-500 font-bold'>Rp${dataKeuangan[2].toLocaleString()}</span></div>
                <div>Rasio kebutuhan dengan pengeluaran total : <span class='${color} italic font-bold'>${rasio.toLocaleString()}%</span></div>
            </div>
            `);
        }
    }else if(idx == 2){
            saran = $(`<div class='italic'>Pengeluaran keinginan sebaiknya <span class='font-bold'>di bawah pengeluaran kebutuhan.</span> Pengeluaran yang berlebihan sebaiknya <span class='font-bold'>digunakan untuk tabungan.</span></div>`);
        if(skor == -1){
            element = $(`<div>Rasio tidak ditemukan, pengeluaran kebutuhan dan keinginan kosong!</div>`);
        }else{
            let selisih = (dataKeuangan[2] - dataKeuangan[3]);
            let color = "text-green-500";
            if(selisih < 0){
                color = "text-red-500";
            }
            element = $(`
            <div>
                <div>Pengeluaran Kebutuhan : <span class='italic text-green-500 font-bold'>Rp${dataKeuangan[2].toLocaleString()}</span></div>
                <div>Pengeluaran Keinginan : <span class='italic text-red-500 font-bold'>Rp${dataKeuangan[3].toLocaleString()}</span></div>
                <div>Selisih : <span class='${color} italic font-bold'>Rp${selisih.toLocaleString()}</span></div>
            </div>
        `);
        }
    }else if(idx == 3){
            saran = $(`<div class='italic'>Rasio pengeluaran tabungan dengan pengeluaran total yang <span class='font-bold'>ideal yaitu 30%.</span> Apabila rasio anda di bawah 30% maka sebaiknya Anda <span class='font-bold'>memikirkan ulang untuk menambah pengeluaran tabungan Anda.</span></div>`);
        if(skor == -1){
            element = $(`<div>Rasio tidak ditemukan, pengeluaran tabungan kosong!</div>`);
        }else{
            let rasio = parseInt(dataKeuangan[4]/dataKeuangan[1]*100);
            let color = "text-red-500";
            if(rasio >= 30){
                color = "text-green-500";
            }
            element = $(`
            <div>
                <div>Pengeluaran Tabungan : <span class='italic text-green-500 font-bold'>Rp${dataKeuangan[4].toLocaleString()}</span></div>
                <div>Pengeluaran Total : <span class='italic text-red-500 font-bold'>Rp${dataKeuangan[1].toLocaleString()}</span></div>
                <div>Rasio kebutuhan dengan pengeluaran total : <span class='${color} italic font-bold'>${rasio.toLocaleString()}%</span></div>
            </div>`);
        }
    }

    $("#modalDetailSkorSaran").append(saran);
    $("#modalDetailSkorContent").append(element);
    modalDetailSkor.show();
}

function getLimitBar(el, mode = ""){
    let nama = el["nama"];
    let namakelompok = el["namakelompok"];
    let pengeluaran = parseInt(el["pengeluaran"]);
    let jumlah_limit = parseInt(el["jumlah_limit"]);
    let id = el["id"];

    let percent = parseInt((pengeluaran/jumlah_limit)*100   );
    let percentWidth = percent > 100 ? 100 : percent;
    let barColor = "bg-green-500";

    if(percent >= 75){
        barColor = "bg-red-600";
    }else if(percent >= 50){
        barColor = "bg-yellow-400";
    }

    if(percent == 0){
        percent="";
    }else{
        percent = percent+"%";
    }

    let bar;

    if(mode == "noButton"){
        bar = $(`<div class="mb-3">
        <div class="flex items-center gap-3">
            <div class="w-full h-5 rounded-full">
                <div class="${barColor} text-2xs md:text-xs font-medium rounded-full text-blue-100 text-center p-0.5 leading-none rounded-l-full h-5 flex items-center justify-center"
                    style="width: ${percentWidth}%">${percent}</div>
            </div>
        </div>
    <span class="italic text-sm md:text-base">${"Rp"+pengeluaran.toLocaleString()} / ${"Rp"+jumlah_limit.toLocaleString()}</span>
    </div>`);
    }else{
        bar = $(`<div class="mb-3">
        <span class="font-bold">${nama} <span class='italic font-normal'>(${namakelompok})</span></span>
        <div class="flex items-center gap-3">
            <div class="w-full h-5 bg-gray-200 rounded-full">
                <div class="${barColor} text-2xs md:text-xs font-medium rounded-full text-blue-100 text-center p-0.5 leading-none rounded-l-full h-5 flex items-center justify-center"
                    style="width: ${percentWidth}%">${percent}</div>
            </div>
            <form method='post' target='#' onsubmit='editLimit(event)'>
                <input type="hidden" name="input_EditIdLimit" value='${id}'>
                <input type="hidden" name="namaLimit" value='${nama}'>
                <input type="hidden" name="namaKelompokLimit" value='${namakelompok}'>
                <button class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-2 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2 text-center" data-modal-toggle="modal-editLimit">
                    <span class="text-xs md:text-base">Edit</span>
                </button>
            </form>
            <form method='post' target='#' onsubmit='deleteLimit(event)'>
                <input type="hidden" name="input_DeleteIdLimit" value='${id}'>
                <input type="hidden" name="namaLimit" value='${nama}'>
                <input type="hidden" name="namaKelompokLimit" value='${namakelompok}'>

                <button type='submit' class=" text-white bg-red-600 hover:bg-red-700 focus:ring-2 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-3 py-2 text-center" data-modal-toggle="popup-modal-deleteLimit">
                    <span class="text-xs md:text-base">Hapus</span>
                </button>
            </form>
        </div>
    <span class="italic text-sm md:text-base">${"Rp"+pengeluaran.toLocaleString()} / ${"Rp"+jumlah_limit.toLocaleString()}</span>
    </div>`);
    }
    return bar;
}

function loadLimit(){
    let limitBar = $("#limit-limitBar");
    limitBar.empty();

    $.ajax({
        url:"Controller/uang.php",
        method:"post",
        data:{
            action:"getLimitByEmail",
            email:$("#emailUser").text(),
        }
    }).done(d => {
        let data = JSON.parse(d,true);
        data.forEach(el => {
        let bar = getLimitBar(el);

        limitBar.append(bar);
        });
    })
}

function updateLimit(e){
    e.preventDefault();
    let frm = $(e.target).serializeArray();
    $.ajax({
        url:"Controller/uang.php",
        method:"post",
        data:{
            action:"editLimit",
            idLimit:frm[0]["value"],
            nominal:frm[1]["value"]
        }
    }).done(d => {
        closeModalEditLimit();
        loadKeuangan();
    })
}

function removeLimit(e){
    e.preventDefault();
    let frm = $(e.target).serializeArray();
    $.ajax({
        url:"Controller/uang.php",
        method:"post",
        data:{
            action:"deleteLimit",
            idLimit:frm[0]["value"],
        }
    }).done(d => {
        closeModalDeleteLimit();
        loadLimit();
    })
}

let modalEdit = new Modal($("#modal-editLimit")[0]);
function editLimit(e){
    e.preventDefault();
    let frmData = $(e.target).serializeArray();
    
    // Id limit yang mau di edit
    let inp = frmData[0]["value"];
    let namaInp = frmData[1]["value"];
    let namaInpKelompok = frmData[2]["value"];
    $("#modal-editLimit").find(":input[name='keuangan-editLimitId']").val(inp);
    $("#namaModalEditLimit").text(namaInp);
    $("#namaModalEditLimitKelompok").text(" ("+namaInpKelompok+")");

    $.ajax({
        url:"Controller/uang.php",
        method:"post",
        data:{
            action:"getLimitById",
            idLimit:inp,
        }
    }).done(d => {
        let data = JSON.parse(d);
        let jml_limit = parseInt(data["jumlah_limit"]);
        inputModalEditLimit.set(jml_limit);
    })

    modalEdit.show();

}

let modalDelete = new Modal($("#modal-deleteLimit")[0]);
function deleteLimit(e){
    e.preventDefault();
    let frmData = $(e.target).serializeArray();

    // Id limit yang mau di edit
    console.log(frmData);
    let inp = frmData[0]["value"];
    let namaInp = frmData[1]["value"];
    let namaInpKelompok = frmData[2]["value"];
    $("#modal-deleteLimit").find(":input[name='keuangan-deleteLimitId']").val(inp);
    $("#namaModalDeleteLimit").text(namaInp);
    $("#namaModalDeleteLimitKelompok").text(" ("+namaInpKelompok+")");
    modalDelete.show();
}

async function loadKeuanganBulanIni(){
    let month = (new Date().getMonth()+1).toString();
    
    month = month.length == 1 ? "0"+month : month;

    let masuk = await getTotalPemasukanByEmail(new Date().getFullYear().toString()+month);
    masuk = JSON.parse(masuk,true)["subtotal"];
    if(masuk == null){
        masuk = 0;
    }
    masuk = parseInt(masuk).toLocaleString();

    let keluar = await getTotalPengeluaranByEmail(new Date().getFullYear().toString()+month);
    keluar = JSON.parse(keluar,true)["subtotal"];
    if(keluar == null){
        keluar = 0;
    }
    keluar = parseInt(keluar).toLocaleString();

    $("#keuangan-pendapatanBulanIni").text('Rp'+masuk);
    $("#keuangan-pengeluaranBulanIni").text('Rp'+keluar);
}

function loadKeuangan(){
    loadKeuanganBulanIni();
    loadPortofolioPendapatan();
    loadPortofolioPengeluaran();
    loadLimit();
    loadSkorKeuanganKeuangan();
    loadDashboard();
}

function cetakLaporanKesehatan(){
    let win = window.open();
    win.location.href = "./Pages/Application/CetakLaporanKesehatan.php";
}

document.getElementById("cetakLaporanKesehatan").addEventListener("click", cetakLaporanKesehatan);

loadKeuangan();