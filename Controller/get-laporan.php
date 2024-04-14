<?php

    require_once("../Config/load.php");
    // include_once("Config/cdn.php");

    use Model\Laporan;

    $total = 0;

    // function getLaporan($bln1, $bln2, $email, $urutan, $kelompok){
    //     $laporan = Laporan::getLaporan($bln1, $bln2, $email, $urutan, $kelompok);
    //     return $laporan;
    // }

    if(isset($_GET["action"])){
        if ($_GET["action"] == "getLaporan"){
            $bln1 = $_GET["bln1"];
            $bln2 = $_GET["bln2"];
            $email = $_GET["email_login"];
            $urutan = $_GET["urutan"];
            $kelompok = $_GET["kelompok"];
            $sub = $_GET["sub"];
            if ($kelompok == -1) {
                $laporan = Laporan::getLaporanAllKelompok($bln1, $bln2, $email, $urutan);
            }
            else{
                $laporan = Laporan::getLaporan($bln1, $bln2, $email, $urutan, $kelompok);
            }
            
            $isiBody = "<div class='card relative h-96 flex justify-center items-center text-center'>";
            if ($sub == 1) {
                $isiBody .= "<div class='blur-sm no-copy'>";
            }
            else{
                $isiBody .= "<div class='w-full h-full'>";
            }
            $isiBody .= "<canvas id='barChart'></canvas>
            </div>";
            if ($sub == 1) {
                $isiBody .= "<div class='absolute w-full h-full flex justify-center items-center'>
                                <span class='font-bold bg-slate-600 shadow-md rounded-md p-1 opacity-75'>Fitur ini hanya tersedia untuk premium</span>
                            </div>";
            }
            $isiBody.= "</div>
            <br>
            <div id='detailContainer' class='card flex flex-col col-span-2'>";
            foreach ($laporan as $key => $l) {
                if ($l["p"] == 0 || $l["p"] == "0") {
                    $isiBody .= "<div class='bg-green-500 w-full rounded-lg p-2 my-1.5 flex justify-between text-lg'>
                                    <div>".$l['TANGGAL']." - ".$l['NOTE']."</div>
                                    <div>Rp. ".number_format($l["JUMLAH"])."</div>
                                </div>";
                    $total += $l["JUMLAH"];
                }
                else{
                    $isiBody .= "<div class='bg-red-500 w-full rounded-lg p-2 my-1.5 flex justify-between text-lg'>
                                    <div>".$l['TANGGAL']." - ".$l['NOTE']."</div>
                                    <div>Rp. ".number_format($l["JUMLAH"])."</div>
                                </div>";
                    $total -= $l["JUMLAH"];
                }
            }
            $isiBody .= "</div>
                            <br>
                            <div class='card flex xl:flex-row lg:flex-row md:flex-row sm:flex-col justify-center items-center text-xl font-bold col-span-2'>
                            <div class='flex'>    
                            <div>Total &nbsp;</div>
                                <div class='text-green-500'>Pemasukan</div>
                                <div>&nbsp;/&nbsp;</div>
                                <div class='text-red-500'>Pengeluaran &nbsp;</div>
                                <div>: &nbsp;</div></div>";
            if ($total > 0) {
                $isiBody .= "<div class='text-green-500'>Rp. ".number_format($total)."</div>";
            }
            else{
                $isiBody .= "<div class='text-red-500'>Rp. ".number_format($total * -1)."</div>";
            }
            $isiBody .= "</div>";
            // $isiBody = "<div>Halooooo</div>";
            // var_dump($laporan);
            // $returnData = [
            //     'isiBody'=> $isiBody,
            //     'laporan'=> $laporan
            // ];
            // array_push($returnData, $isiBody);
            // array_push($returnData, $laporan);
            // echo json_encode($returnData);
            echo $isiBody;
        }
        if ($_GET["action"] == "getDataLaporan"){
            $bln1 = $_GET["bln1"];
            $bln2 = $_GET["bln2"];
            $email = $_GET["email_login"];
            $urutan = $_GET["urutan"];
            $kelompok = $_GET["kelompok"];
            $sub = $_GET["sub"];
            if ($kelompok == -1) {
                $laporan = Laporan::getLaporanAllKelompok($bln1, $bln2, $email, $urutan);
            }
            else{
                $laporan = Laporan::getLaporan($bln1, $bln2, $email, $urutan, $kelompok);
            }
            echo json_encode($laporan);
        }
    }

?>