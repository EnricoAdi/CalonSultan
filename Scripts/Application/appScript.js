function getTotalPemasukanByEmail(inpMonth = -1){
    if(inpMonth == -1){
        return $.ajax({
            url:"Controller/uang.php",
            method:"post",
            data:{
                action:"getTotalPemasukanByEmail",
                email:$("#emailUser").text()
            }
        });
    }else{
        return $.ajax({
            url:"Controller/uang.php",
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
            url:"Controller/uang.php",
            method:"post",
            data:{
                action:"getTotalPengeluaranByEmail",
                email:$("#emailUser").text()
            }
        });
    }else{
        return $.ajax({
            url:"Controller/uang.php",
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
        url:"Controller/uang.php",
        method:"post",
        data:{
            action:"getTotalPengeluaranByEmailKelompok",
            email:$("#emailUser").text(),
            kelompok:kelompok
        }
    })
}

function getMonthlyPemasukanByEmailKelompok(inpMonth){
    return $.ajax({
        url:"Controller/uang.php",
        method:"post",
        data:{
            action:"getMonthlyPemasukanByEmailKelompok",
            email:$("#emailUser").text(),
            month:inpMonth,
        }
    });
}

function getMonthlyPengeluaranByEmailKelompok(inpMonth, inpKelompok){
    return $.ajax({
        url:"Controller/uang.php",
        method:"post",
        data:{
            action:"getMonthlyPengeluaranByEmailKelompok",
            email:$("#emailUser").text(),
            month:inpMonth,
            kelompok:inpKelompok
        }
    });
}

function getuserRole(){
    return $.ajax({
        url:"Controller/auth-user.php",
        method:"post",
        data:{
            userRole:'1',
            email:$("#emailUser").text(),
        }
    })
}

var maxSkor1 = 40;
var maxSkor2 = 20;
var maxSkor3 = 20;
var maxSkor4 = 20;

var maxSkorArr = [maxSkor1,maxSkor2,maxSkor3,maxSkor4];

async function getDataKeuangan(){
    let pemasukanTotal = parseInt(JSON.parse(await getTotalPemasukanByEmail(), true)["subtotal"]);
    let pengeluaranTotal = parseInt(JSON.parse(await getTotalPengeluaranByEmail(),true)["subtotal"]);
    
    let pengeluaranKebutuhan = parseInt(JSON.parse(await getTotalPengeluaranByEmailKelompok(1),true)["subtotal"]);
    let pengeluaranKeinginan = parseInt(JSON.parse(await getTotalPengeluaranByEmailKelompok(2),true)["subtotal"]);
    let pengeluaranTabungan = parseInt(JSON.parse(await getTotalPengeluaranByEmailKelompok(3),true)["subtotal"]);
    let pengeluaranSedekah = parseInt(JSON.parse(await getTotalPengeluaranByEmailKelompok(4),true)["subtotal"]);

    return([pemasukanTotal, pengeluaranTotal, pengeluaranKebutuhan, pengeluaranKeinginan, pengeluaranTabungan, pengeluaranSedekah]);
}

async function calculateSkorKeuangan(){
    let dataKeuangan = await getDataKeuangan();
    
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
