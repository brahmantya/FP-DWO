<?php
	
session_start();

if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}

require 'function.php';

$tampil = mysqli_query($conn, "SELECT * FROM customer");
$tampil2 = mysqli_query($conn, "SELECT SUM(amount) FROM fakta_pendapatan");
$tampil3 = mysqli_query($conn, "SELECT * FROM film");
$tampil4 = mysqli_query($conn, "SELECT * FROM store");

$jumlah = mysqli_num_rows($tampil);
$jumlah2 = mysqli_fetch_array($tampil2);
$jumlah3 = mysqli_num_rows($tampil3);
$jumlah4 = mysqli_num_rows($tampil4);

$label = ["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">
    <title>SAKILA</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <script type="text/javascript" src="assets/Chart.js"></script>
    
</head>
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
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <div class="dash-widget">
                            <div class="dash-widget-info text-center">
                                <h3><?= $jumlah; ?></h3>
                                <span class="widget-title1">Customer <i class="fa fa-check" aria-hidden="true"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <div class="dash-widget">
                            <div class="dash-widget-info text-center">
                                <h3><?php echo "$ ".number_format($jumlah2['SUM(amount)']); ?></h3>
                                <span class="widget-title1">Pendapatan <i class="fa fa-check" aria-hidden="true"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <div class="dash-widget">
                            <div class="dash-widget-info text-center">
                                <h3><?= $jumlah3; ?></h3>
                                <span class="widget-title1">Film <i class="fa fa-check" aria-hidden="true"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <div class="dash-widget">
                            <div class="dash-widget-info text-center">
                                <h3><?= $jumlah4; ?></h3>
                                <span class="widget-title1">Store <i class="fa fa-check" aria-hidden="true"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="chart-title">
                                    <h4>Total Customer</h4>
                                </div style="width: 800px;height: 800px">  
                                <canvas id="myChart"></canvas>
                            </div>
                            <script>
                            var ctx = document.getElementById("myChart").getContext('2d');
                            var myChart = new Chart(ctx, {
                                type: 'line',
                                data: {
                                    labels: <?php echo json_encode($label); ?>,
                                    datasets: [{
                                    label: 'Total Customer',
                                        data: [
                                        <?php 
                                        $jumlah_1 = mysqli_query($conn,"SELECT DISTINCT fp.customer_id FROM fakta_pendapatan fp JOIN WAKTU t ON (t.time_id = fp.time_id) WHERE t.`bulan` = 1");
                                        echo mysqli_num_rows($jumlah_1);
                                        ?>, 
                                        <?php 
                                        $jumlah_2 = mysqli_query($conn,"SELECT DISTINCT fp.customer_id FROM fakta_pendapatan fp JOIN WAKTU t ON (t.time_id = fp.time_id) WHERE t.`bulan` = 2");
                                        echo mysqli_num_rows($jumlah_2);
                                        ?>, 
                                        <?php 
                                        $jumlah_3 = mysqli_query($conn,"SELECT DISTINCT fp.customer_id FROM fakta_pendapatan fp JOIN WAKTU t ON (t.time_id = fp.time_id) WHERE t.`bulan` = 3");
                                        echo mysqli_num_rows($jumlah_3);
                                        ?>, 
                                        <?php 
                                        $jumlah_3 = mysqli_query($conn,"SELECT DISTINCT fp.customer_id FROM fakta_pendapatan fp JOIN WAKTU t ON (t.time_id = fp.time_id) WHERE t.`bulan` = 4");
                                        echo mysqli_num_rows($jumlah_3);
                                        ?>,
                                        <?php 
                                        $jumlah_3 = mysqli_query($conn,"SELECT DISTINCT fp.customer_id FROM fakta_pendapatan fp JOIN WAKTU t ON (t.time_id = fp.time_id) WHERE t.`bulan` = 5");
                                        echo mysqli_num_rows($jumlah_3);
                                        ?>,
                                        <?php 
                                        $jumlah_3 = mysqli_query($conn,"SELECT DISTINCT fp.customer_id FROM fakta_pendapatan fp JOIN WAKTU t ON (t.time_id = fp.time_id) WHERE t.`bulan` = 6");
                                        echo mysqli_num_rows($jumlah_3);
                                        ?>,
                                        <?php 
                                        $jumlah_3 = mysqli_query($conn,"SELECT DISTINCT fp.customer_id FROM fakta_pendapatan fp JOIN WAKTU t ON (t.time_id = fp.time_id) WHERE t.`bulan` = 7");
                                        echo mysqli_num_rows($jumlah_3);
                                        ?>,
                                        <?php 
                                        $jumlah_3 = mysqli_query($conn,"SELECT DISTINCT fp.customer_id FROM fakta_pendapatan fp JOIN WAKTU t ON (t.time_id = fp.time_id) WHERE t.`bulan` = 8");
                                        echo mysqli_num_rows($jumlah_3);
                                        ?>,
                                        <?php 
                                        $jumlah_3 = mysqli_query($conn,"SELECT DISTINCT fp.customer_id FROM fakta_pendapatan fp JOIN WAKTU t ON (t.time_id = fp.time_id) WHERE t.`bulan` = 9");
                                        echo mysqli_num_rows($jumlah_3);
                                        ?>,
                                        <?php 
                                        $jumlah_3 = mysqli_query($conn,"SELECT DISTINCT fp.customer_id FROM fakta_pendapatan fp JOIN WAKTU t ON (t.time_id = fp.time_id) WHERE t.`bulan` = 10");
                                        echo mysqli_num_rows($jumlah_3);
                                        ?>,
                                        <?php 
                                        $jumlah_3 = mysqli_query($conn,"SELECT DISTINCT fp.customer_id FROM fakta_pendapatan fp JOIN WAKTU t ON (t.time_id = fp.time_id) WHERE t.`bulan` = 11");
                                        echo mysqli_num_rows($jumlah_3);
                                        ?>,
                                        <?php 
                                        $jumlah_4 = mysqli_query($conn,"SELECT DISTINCT fp.customer_id FROM fakta_pendapatan fp JOIN WAKTU t ON (t.time_id = fp.time_id) WHERE t.`bulan` = 12");
                                        echo mysqli_num_rows($jumlah_4);
                                        ?>
                                        ],
                                        backgroundColor: [
                                        'rgba(0, 255, 255, 0.1)',
                                        'rgba(0, 255, 255, 0.3)',
                                        'rgba(255, 255, 0, 0.3)',
                                        'rgba(255, 0, 0, 0.3)',
                                        'rgba(255, 0, 255, 0.3)',
                                        'rgba(2, 99, 95, 0.3)',
                                        'rgba(128, 0, 128, 0.3)',
                                        'rgba(0, 128, 128, 0.3)',
                                        'rgba(255, 6, 6, 0.3)',
                                        'rgba(2, 206, 86, 0.3)',
                                        'rgba(255, 2, 86, 0.3)',
                                        'rgba(255, 206, 8, 0.3)'
                                        ],
                                        borderColor: [
                                        'rgba(0, 0, 255, 1)',
                                        'rgba(0, 255, 255, 1)',
                                        'rgba(255, 255, 0, 1)',
                                        'rgba(255, 0, 0, 1)',
                                        'rgba(255, 0, 255, 1)',
                                        'rgba(2, 99, 95, 1)',
                                        'rgba(128, 0, 128, 1)',
                                        'rgba(0, 128, 128, 1)',
                                        'rgba(255, 6, 6, 1)',
                                        'rgba(2, 206, 86, 1)',
                                        'rgba(255, 2, 86, 1)',
                                        'rgba(255, 206, 8, 1)'
                                        ],
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    scales: {
                                        yAxes: [{
                                            ticks: {
                                                beginAtZero:true
                                            }
                                        }]
                                    }
                                }
                            });
                        </script>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="chart-title">
                                    <h4>Jumlah Peminjaman Film</h4>
                                </div>  
                                <canvas id="myChart2"></canvas>
                            </div>
                            <script>
                            var ctx = document.getElementById("myChart2").getContext('2d');
                            var myChart2 = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: <?php echo json_encode($label); ?>,
                                    datasets: [{
                                    label: 'Total peminjaman',
                                        data: [
                                        <?php 
                                        $jumlah_1 = mysqli_query($conn,"SELECT fp.customer_id FROM fakta_pendapatan fp JOIN WAKTU t ON (t.time_id = fp.time_id) WHERE t.`bulan` = 1");
                                        echo mysqli_num_rows($jumlah_1);
                                        ?>, 
                                        <?php 
                                        $jumlah_2 = mysqli_query($conn,"SELECT fp.customer_id FROM fakta_pendapatan fp JOIN WAKTU t ON (t.time_id = fp.time_id) WHERE t.`bulan` = 2");
                                        echo mysqli_num_rows($jumlah_2);
                                        ?>, 
                                        <?php 
                                        $jumlah_3 = mysqli_query($conn,"SELECT fp.customer_id FROM fakta_pendapatan fp JOIN WAKTU t ON (t.time_id = fp.time_id) WHERE t.`bulan` = 3");
                                        echo mysqli_num_rows($jumlah_3);
                                        ?>, 
                                        <?php 
                                        $jumlah_3 = mysqli_query($conn,"SELECT fp.customer_id FROM fakta_pendapatan fp JOIN WAKTU t ON (t.time_id = fp.time_id) WHERE t.`bulan` = 4");
                                        echo mysqli_num_rows($jumlah_3);
                                        ?>,
                                        <?php 
                                        $jumlah_3 = mysqli_query($conn,"SELECT fp.customer_id FROM fakta_pendapatan fp JOIN WAKTU t ON (t.time_id = fp.time_id) WHERE t.`bulan` = 5");
                                        echo mysqli_num_rows($jumlah_3);
                                        ?>,
                                        <?php 
                                        $jumlah_3 = mysqli_query($conn,"SELECT fp.customer_id FROM fakta_pendapatan fp JOIN WAKTU t ON (t.time_id = fp.time_id) WHERE t.`bulan` = 6");
                                        echo mysqli_num_rows($jumlah_3);
                                        ?>,
                                        <?php 
                                        $jumlah_3 = mysqli_query($conn,"SELECT fp.customer_id FROM fakta_pendapatan fp JOIN WAKTU t ON (t.time_id = fp.time_id) WHERE t.`bulan` = 7");
                                        echo mysqli_num_rows($jumlah_3);
                                        ?>,
                                        <?php 
                                        $jumlah_3 = mysqli_query($conn,"SELECT fp.customer_id FROM fakta_pendapatan fp JOIN WAKTU t ON (t.time_id = fp.time_id) WHERE t.`bulan` = 8");
                                        echo mysqli_num_rows($jumlah_3);
                                        ?>,
                                        <?php 
                                        $jumlah_3 = mysqli_query($conn,"SELECT fp.customer_id FROM fakta_pendapatan fp JOIN WAKTU t ON (t.time_id = fp.time_id) WHERE t.`bulan` = 9");
                                        echo mysqli_num_rows($jumlah_3);
                                        ?>,
                                        <?php 
                                        $jumlah_3 = mysqli_query($conn,"SELECT fp.customer_id FROM fakta_pendapatan fp JOIN WAKTU t ON (t.time_id = fp.time_id) WHERE t.`bulan` = 10");
                                        echo mysqli_num_rows($jumlah_3);
                                        ?>,
                                        <?php 
                                        $jumlah_3 = mysqli_query($conn,"SELECT fp.customer_id FROM fakta_pendapatan fp JOIN WAKTU t ON (t.time_id = fp.time_id) WHERE t.`bulan` = 11");
                                        echo mysqli_num_rows($jumlah_3);
                                        ?>,
                                        <?php 
                                        $jumlah_4 = mysqli_query($conn,"SELECT fp.customer_id FROM fakta_pendapatan fp JOIN WAKTU t ON (t.time_id = fp.time_id) WHERE t.`bulan` = 12");
                                        echo mysqli_num_rows($jumlah_4);
                                        ?>
                                        ],
                                        backgroundColor: [
                                        'rgba(0, 0, 255, 0.3)',
                                        'rgba(0, 255, 255, 0.3)',
                                        'rgba(255, 255, 0, 0.3)',
                                        'rgba(255, 0, 0, 0.3)',
                                        'rgba(255, 0, 255, 0.3)',
                                        'rgba(2, 99, 95, 0.3)',
                                        'rgba(128, 0, 128, 0.3)',
                                        'rgba(0, 128, 128, 0.3)',
                                        'rgba(255, 6, 6, 0.3)',
                                        'rgba(2, 206, 86, 0.3)',
                                        'rgba(255, 2, 86, 0.3)',
                                        'rgba(255, 206, 8, 0.3)'
                                        ],
                                        borderColor: [
                                        'rgba(0, 0, 255, 1)',
                                        'rgba(0, 255, 255, 1)',
                                        'rgba(255, 255, 0, 1)',
                                        'rgba(255, 0, 0, 1)',
                                        'rgba(255, 0, 255, 1)',
                                        'rgba(2, 99, 95, 1)',
                                        'rgba(128, 0, 128, 1)',
                                        'rgba(0, 128, 128, 1)',
                                        'rgba(255, 6, 6, 1)',
                                        'rgba(2, 206, 86, 1)',
                                        'rgba(255, 2, 86, 1)',
                                        'rgba(255, 206, 8, 1)'
                                        ],
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    scales: {
                                        yAxes: [{
                                            ticks: {
                                                beginAtZero:true
                                            }
                                        }]
                                    }
                                }
                            });
                        </script>
                        </div>
                    </div>
                </div>    
            </div>
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