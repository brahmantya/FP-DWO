<?php 
$dbHost = "localhost";
$dbDatabase = "wh_sakila";
$dbUser = "root";
$dbPassword = "";

$mysqli = mysqli_connect($dbHost, $dbUser, $dbPassword, $dbDatabase);

//QUERY CHART PERTAMA
$sql = "SELECT sum(amount) as tot from fakta_pendapatan";
$tot = mysqli_query($mysqli,$sql);
$tot_amount = mysqli_fetch_row($tot);

$sql = "SELECT concat('name:',f.kategori) as name, concat('y:', sum(fp.amount)*100/" . $tot_amount[0] . ") as y, concat('drilldown:' , f.kategori) as drilldown
        FROM film f
        JOIN fakta_pendapatan fp ON (f.film_id = fp.film_id)
    WHERE fp.`store_id` = '2'    
    GROUP BY name
    ORDER BY y DESC";

$all_kat = mysqli_query($mysqli,$sql);

while($row = mysqli_fetch_all($all_kat)){
    $data[] = $row;
}

$json_all_kat = json_encode($data);

//CHART KEDUA

$sql = "SELECT f.kategori kategori, sum(fp.amount) as tot_kat
        FROM fakta_pendapatan fp
        JOIN film f ON (f.film_id = fp.film_id)
        GROUP BY kategori";
$hasil_kat = mysqli_query($mysqli,$sql);

while($row = mysqli_fetch_all($hasil_kat)){
    $tot_all_kat[] = $row;
}

function cari_tot_kat($kat_dicari, $tot_all_kat){
    $counter = 0;
    while($counter < count($tot_all_kat[0])){
        if($kat_dicari == $tot_all_kat[0][$counter][0]){
            $tot_kat = $tot_all_kat[0][$counter][1];
            return $tot_kat;
        }
        $counter++;
    }
}

$sql = "SELECT f.kategori kategori, 
        t.bulan as bulan,
        sum(fp.amount) as pendapatan_kat
        FROM film f
        JOIN fakta_pendapatan fp ON (f.film_id = fp.film_id)
        JOIN waktu t ON (t.time_id = fp.time_id)
        GROUP BY kategori, bulan";
$det_kat = mysqli_query($mysqli, $sql);
$i = 0;
while($row = mysqli_fetch_all($det_kat)) {
    $data_det[] = $row;
}

//DRILLDOWN TEKNIK CLEAN

$i = 0;

$string_data = "";
$string_data = '{name:"'. $data_det[0][$i][0] . '", id:"'. $data_det[0][$i][0]. '", data: [';

foreach ($data_det[0] as $a) {
    if($i < count($data_det[0])-1){
        if($a[0] != $data_det[0][$i+1][0]){
            $string_data .= '[' . $a[1].', '.
                $a[2]*100/cari_tot_kat($a[0], $tot_all_kat) . ']]},';
            $string_data .= '{name:"' .$a[0] . '", id:"' . $a[0] . '", data: [';
        } else {
            $string_data .= '[' . $a[1] . ', '.
                $a[2]*100/cari_tot_kat($a[0], $tot_all_kat) . '], ';
        }
        
    } else {
        $string_data .= '[' . $a[1] . ', '.
            $a[2]*100/cari_tot_kat($a[0], $tot_all_kat). ']]}';
    }
    $i = $i+1;
}

?>

<!DOCTYPE html>
<html>
<head>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/data.js"></script>
    <script src="https://code.highcharts.com/modules/drilldown.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <link rel="stylesheet" href="/drilldown.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.js"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">
    <title>SAKILA</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <script type="text/javascript" src="assets/Chart.js"></script>
<body>
    <div class="main-wrapper">
        <div class="header">
            <div class="header-left">
                <a href="index.php" class="logo">
                    <img src="assets/img/logo1.png" width="35" height="35" alt=""> <span><h4>SAKILA</h4></span>
                </a>
            </div>
            <a id="toggle_btn" href="javascript:void(0);"><i class="fa fa-bars"></i></a>
            <a id="mobile_btn" class="mobile_btn float-left" href="#sidebar"><i class="fa fa-bars"></i></a>
            <ul class="nav user-menu float-right">
                <li class="nav-item dropdown has-arrow">
                    <a href="#" class="dropdown-toggle nav-link user-link" data-toggle="dropdown">
                        <span class="user-img">
                            <img class="rounded-circle" src="assets/img/user.jpg" width="24" alt="Admin">
                        </span>
                        <span>Admin</span>
                    </a>    
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="logout.php">Logout</a>
                    </div>
                </li>
            </ul>
            <div class="dropdown mobile-user-menu float-right">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="logout.php">Logout</a>
                </div>
            </div>      
        </div>
        <div class="sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
                <div id="sidebar-menu" class="sidebar-menu">
                    <ul>
                        <li class="menu-title">Main</li>
                        <li class="submenu">
                            <a href="#"><i class="fa fa-home"></i> <span> Dashboard </span> <span class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                <li><a href="chart1.php"> Chart 1 </a></li>
                                <li><a href="chart2.php"> Chart 2 </a></li>
                                <li><a href="chart3.php"> Chart 3 </a></li>
                                <li><a href="chart4.php"> Chart 4 </a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="http://localhost:8080/mondrian/testpage.jsp?query=whsakila"><i class="fa fa-check"></i> <span>OLAP</span></a>
                        </li>
                        <li>
                            <a href="customer.php"><i class="fa fa-check"></i> <span>Customer</span></a>
                        </li>
                        <li>
                            <a href="film.php"><i class="fa fa-check"></i> <span>Film</span></a>
                        </li>
                        <li>
                            <a href="store.php"><i class="fa fa-check"></i> <span>Store</span></a>
                        </li>
                        <li>
                            <a href="time.php"><i class="fa fa-check"></i> <span>Time</span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="page-wrapper">
            <div class="content">
<figure class="highcharts-figure">
    <div id="container"></div>
    <p class="highcharts-description"></p>
</figure>

<script type="text/javascript">
    Highcharts.chart('container',{
        chart: {
            type: 'column'
        },
        title: {
            text: 'Presentase Nilai Penjualan (WH Sakila) Di Kota Woodridge - Semua Kategori'
        },
        subtitle: {
            text: 'Klik di potongan grafik untuk melihat detail nilai penjualan kategori berdasarkan bulan'
        },
        accessibility: {
            announceNewData: {
                enabled: true
            },
            point: {
                valueSuffix: '%'
            }
        },
        plotOptions: {
            series: {
                dataLabels: {
                    enabled: true,
                    format: '{point.name}: {point.y:.1f}%'
                }
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
        },
        series: [
            {
                name: "Pendapatan By Kategori",
                colorByPoint: true,
                data:
                    <?php 
                        $datanya = $json_all_kat;
                        $data1 = str_replace('["', '{"', $datanya);
                        $data2 = str_replace('"]','"}',$data1);
                        $data3 = str_replace('[[', '[', $data2);
                        $data4 = str_replace(']]', ']', $data3);
                        $data5 = str_replace(':', '" : "', $data4);
                        $data6 = str_replace('"name"', 'name', $data5);
                        $data7 = str_replace('"drilldown"', 'drilldown', $data6);
                        $data8 = str_replace('"y"','y', $data7);
                        $data9 = str_replace('",', ',', $data8);
                        $data10 = str_replace(',y', '",y', $data9);
                        $data11 = str_replace(',y : "', ',y : ', $data10);
                        echo $data11;
                    ?>
            }
        ],
        drilldown: {
            series: [
                <?php
                    echo $string_data;
                ?>
            ]
        }
    });
</script>
</div>
</div>
<div class="sidebar-overlay" data-reff=""></div>
    <script src="assets/js/jquery-3.2.1.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.slimscroll.js"></script>
    <!-- <script src="assets/js/Chart.bundle.js"></script> -->
    <script src="assets/js/app.js"></script>
</body>
</html>