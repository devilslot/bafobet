<meta charset="UTF-8">
<?php
error_reporting (E_ALL);

set_time_limit(0);

function curl($url)
{
  $ch = curl_init();
  $timeout = 0;
  curl_setopt($ch,CURLOPT_URL,$url);
  curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
  curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
  $content = curl_exec($ch);
  curl_close($ch);
  return $content;
}

function clean($string) {
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
   $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

   return preg_replace('/-+/', ' ', $string); // Replaces multiple hyphens with single one.
}


$page = curl('http://www.thscore.cc/data/bf_th1.js');


preg_match_all("/[A].\d+]=.(.*)/", $page, $matches);
preg_match_all("/[B].\d+]=.(.*)];/", $page, $league);


include_once('config.php');

$countmatch = count($matches[1]);
// echo "<pre>";
// print_r($league);
// echo "</pre>";
$emptyleague = "TRUNCATE TABLE `league`";
mysqli_query($con, $emptyleague);


// $sqlleaguedel = "DELETE * ,count(*) as n FROM add group by id HAVING n>1   WHERE id = '".$val[0]."' ";
// mysqli_query($con,$sqlleaguedel) or die(mysqli_error($con));


$valplus = "";
$lg= array();
$loop=0;
while (list ($key, $val) = each($league[1])) {

    $valplus = $valplus + 1;
    $loop+=1;
    $val = substr_replace($val, "','$valplus'", -1);
    $val = explode(",", $val);
    $lg[$loop]  = $val[0];

    // if($val[3] == ""){
    //     $val[3] = '';
    // }
    // if($val[4] == ""){
    //     $val[4] ='';
    // }
    // if($val[5] == ""){
    //     $val[5] ='';
    // }
    // if($val[6] == ""){
    //     $val[6] ='';
    // }
    // if($val[7] == ""){
    //     $val[7] = '';
    // }
    $dbug= substr($val[2], -1);
    if($dbug != "'"){
        $dbug =$val[2]."'";
    }else{
       $dbug =$val[2]; 
    }


    $sqlleague = "INSERT INTO `league`(`id`, `name_ss`, `name_en`,`name_th`) VALUES ($val[0],$val[1],$dbug,$val[6])";
    $qrlg = mysqli_query($con, $sqlleague) or die(mysqli_error($con));


    $sqlchk = mysql_query("SELECT * FROM Tem_league WHERE id='".$val[0]."' ");
    $numchk = mysqli_num_rows($sqlchk);
    if($numchk <= 0){
    $sqlleague2 = "INSERT INTO `Tem_league`(`id`, `name_ss`, `name_en`,`name_th`) VALUES ($val[0],$val[1],$dbug,$val[6])";
    $qrlg = mysqli_query($con, $sqlleague2) or die(mysqli_error($con));

    }



    $sqlms = "SELECT * FROM `match_show` WHERE `id_league` = $val[0]";
    $qrms = mysqli_query($con,$sqlms);
    $numms = mysqli_num_rows($qrms);
    if($numms){
        echo "Have";

    }else{
        // $upms = "INSERT INTO `match_show`(`id_league`) VALUES ($val[0])";
        // mysqli_query($con,$upms) or die(mysqli_error($con));
    }

}


foreach ($matches[1] as $valmatch) {
    $ex = explode(",", $valmatch);

    $status_ch = $ex[18];

    $ex[4] = str_replace("'", "", $ex[4]);
    $ex[5] = str_replace("'", "", $ex[5]);
    $ex[6] = str_replace("'", "", $ex[6]);
    $ex[11] = str_replace("'", "", $ex[11]);
    $ex[12] = str_replace("'", "", $ex[12]);
    $ex[17] = str_replace("'", "", $ex[17]);
    $ex[27] = str_replace("'", "", $ex[27]);
    $ex[28] = str_replace("'", "", $ex[28]);
    $ex[30] = str_replace("'", "", $ex[30]);
    $ex[31] = str_replace("'", "", $ex[31]);
    $plus1 = $ex[9] + 7;

    if ($plus1 >= 0 && $plus1 <= 9) {
        $plus1 = "0" . $plus1;
    }

    switch ($plus1) {
        case 24:
        $ex[8] = $ex[8] + 1;
        $plus1 = '00';
        break;
        case 25:
        $ex[8] = $ex[8] + 1;
        $plus1 = '01';
        break;
        case 26:
        $ex[8] = $ex[8] + 1;
        $plus1 = '02';
        break;
        case 27:
        $ex[8] = $ex[8] + 1;
        $plus1 = '03';
        break;
        case 28:
        $ex[8] = $ex[8] + 1;
        $plus1 = '04';
        break;
        case 29:
        $ex[8] = $ex[8] + 1;
        $plus1 = '05';
        break;
        case 30:
        $ex[8] = $ex[8] + 1;
        $plus1 = '06';
        break;
    }
    if ($ex[8] >= 0 && $ex[8] <= 9) {
        $ex[8] = "0" . $ex[8];

    }
    $ex[7] = $ex[7] + 1;
    if ($ex[7] >= 1 && $ex[7] <= 9) {
        $ex[7] = "0" . $ex[7];

    }

    if ($ex[14] >= 0 && $ex[14] <= 9) {
        $ex[14] = "0" . $ex[14];

    }

    $date = $ex[6] . "-" . $ex[7] . "-" . $ex[8];

    $time = $plus1 . ":" . $ex[10] . ":" . $ex[11];

    $date2 = $ex[12] . "-" . $ex[7] . "-" . $ex[14];


    $plus2 = $ex[15] + 7;
    switch ($plus2) {
        case 24:
        $plus2 = '00';
        break;
        case 25:
        $plus2 = '01';
        break;
        case 26:
        $plus2 = '02';
        break;
        case 27:
        $plus2 = '03';
        break;
        case 28:
        $plus2 = '04';
        break;
        case 29:
        $plus2 = '05';
        break;
        case 30:
        $plus2 = '06';
        break;
    }
    $time2 = $plus2 . ":" . $ex[16] . ":" . $ex[17];
    empty($ex[21]) ? $ex[21] = "0" : $ex[21];
    empty($ex[22]) ? $ex[22] = "0" : $ex[22];
    empty($ex[29]) ? $ex[29] = "0" : $ex[29];
    empty($ex[31]) ? $ex[29] = "0" : $ex[31];


    $array_status = array(
        0 => "Move",
        1 => "ขัดจังหวะ",
        2 => "ขัด",
        3 => "Wait Approve",
        4 => "Cancel",
        13 => "FT",
        14 => "&nbsp;",
        15 => "HT",
        16 => "Half",
        17 => "ครึ่งหลัง",
        18 => "ล่วงเวลา",
        );
    $values = $array_status[$status_ch + 14];

    var_dump($values);

    switch ($status_ch) {
        case 0:
        $live = $values;
            // $score = "";
            // $hscore = "";

        break;
        case 1:
        $datenow = strtotime(gmdate("Y-m-d H:i:s", time() + (3600 * 7)));
            $datess = strtotime($date . ' ' . $time);//strtotime("2013-08-20 14:31:00");
            $goTime = floor(abs($datenow - $datess) / 60);
            if ($goTime > 45) {
                $goTime = "45+";
            }
            if ($goTime < 1) {
                $goTime = "1";
            }
            $live = $goTime . "<img src=\'images/in.gif\' />";
            break;
            case 2:
            //tr.cells[3].innerHTML=state_ch[D[1]+14];
            // 16 => "<font color=blue>ครึ่ง</font>",
            $live = "HT";//$array_status[16];
            break;
            case 3:
            case 4:
            $datenow = strtotime(gmdate("Y-m-d H:i:s", time() + (3600 * 7)));
            $datess = strtotime($date . ' ' . $time);//strtotime("2013-08-20 14:31:00");
            $goTime = floor(abs($datenow - $datess) / 60) - 15;
            if ($goTime > 90) {
                $goTime = "90+";
            }
            if ($goTime < 46) {
                $goTime = "46";
            }
            $live = $goTime . "<img src=\'images/in.gif\' />";
            break;
            case -1:
            //tr.cells[3].innerHTML=state_ch[D[1]+14];
            // 13 => "<b>จบ</b>",
            $live = "FT";//$array_status[13];
            break;
            case -10:
            //tr.cells[3].innerHTML=state_ch[D[1]+14];
            // 4 => "ยกเลิก"
            $live = $values;//$array_status[4];
            break;
            default:
            //tr.cells[3].innerHTML=state_ch[D[1]+14];
            //   ไม่รุ้ว่า Default คืออะไร
            // 15 => "ครึ่งแรก"
            $live = $values;//$array_status[15];
            break;
        }


        $sql5 = "SELECT * FROM table_ball WHERE id = $ex[0]";
        $indexl =$ex[1];
        $result = mysqli_query($con, $sql5);
        if (!mysqli_num_rows($result) > 0) {
            $sql = "INSERT INTO table_ball (`ref`,`id`, `col1`, `col2`, `col3`, `team1`, `team2`, `date`, `time`, `dates`, `times`, `status`, `soccer1`, `soccer2`, `hsoccer1`, `hsoccer2`, `col4`, `col5`, `col6`, `col7`, `col8`, `col9`, `col10`, `col11`, `col12`, `col13`,`live`) VALUES($lg[$indexl],$ex[0], $ex[1], $ex[2], $ex[3], '$ex[4]', '$ex[5]', '$date', '$time', '$date2', '$time2', $ex[18], $ex[19], $ex[20], $ex[21], $ex[22], $ex[23], $ex[24], $ex[25], $ex[26], '$ex[27]', '$ex[28]', $ex[29], '$ex[30]', '$ex[31]', '$ex[33]','$live')";
            $qr = mysqli_query($con, $sql) or die(mysqli_error($con));

            // $sqlack = "SELECT * FROM `channel` WHERE `id_match` = $ex[0] ";
            // $qrack = mysqli_query($con, $sqlack);
            // $afa = mysqli_fetch_array($qrack);

        }else{
            // $sqlack = "DELETE FROM `table_ball` WHERE `id` =  $ex[0] ";
            // $qrack = mysqli_query($con, $sqlack);
            $sql = " UPDATE  table_ball SET 
            `ref` = $lg[$indexl], 
            `id` = '$ex[0]', 
            `col1` = '$ex[1]', 
            `col2`= '$ex[2]', 
            `col3`= '$ex[3]', 
            `team1`= '$ex[4]',  
            `team2`= '$ex[5]',  
            `date` = '$date', 
            `time` = '$time', 
            `dates` = '$date2', 
            `times` = '$time2',
            `status` = '$ex[18]', 
            `soccer1` = '$ex[19]', 
            `soccer2` = '$ex[20]', 
            `hsoccer1` = '$ex[21]', 
            `hsoccer2` = '$ex[22]', 
            `col4` = '$ex[23]',
            `col5` = '$ex[24]', 
            `col6` = '$ex[25]',
            `col7` = '$ex[26]',
            `col8` = '$ex[27]',
            `col9` = '$ex[28]',
            `col10` = '$ex[29]', 
            `col11` = '$ex[30]', 
            `col12` = '$ex[31]', 
            `col13` = '$ex[33]', 
            `live` = '$live' WHERE id = '$ex[0]' ";
            //echo $sql.'<br/>';
            $qr = mysqli_query($con, $sql) or die(mysqli_error($con));
        }




        if ($afa['id_match'] == $ex[0]) {
            echo $afa['id_match'] . "มีแวล";
        } else {
            // $upch = "INSERT INTO  `channel` (`id_match`) VALUE ($ex[0])";
            // mysqli_query($con, $upch) or die(mysqli_error($con));

        }
        echo "<pre>";
        echo $ex[4] . " VS " . $ex[5] . " วันที่ " . $date . " เวลา " . $time . " สด " . $live . " => Success";
    // echo "<P>---------------------------------------------------------------</P>";
    //print_r($ex[4]);
        echo "</pre>";

    }
    ?>

<!-- //echo "<pre>";print_r($ex); echo "</pre>";exit;
//echo "<pre>.var_dump($page).</pre>";exit;
var_dump($page).</pre>";exit; -->

