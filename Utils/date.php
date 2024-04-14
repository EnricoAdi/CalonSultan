<?php

    function getDateNow(){

        //Contoh format : 
        //Sunday-07-April-04-2022-22-14:35:44
        //dName -d -mName-m -y   -yy-time <- keyName
        $dt = date("D-d-F-m-Y-y-H:i:s");
        $dt = explode('-',$dt);
        $dt_arr = array("dName"=>$dt[0], "d"=>$dt[1], "mName"=>$dt[2], "m"=>$dt[3], "y"=>$dt[4], "yy"=>$dt[5], "time"=>$dt[6]);
        return $dt_arr;
    }

?>