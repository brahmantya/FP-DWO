<?php

session_start();

if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}

require 'function.php';

$data = tampil("SELECT * FROM waktu ORDER BY time_id ASC");

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
                    <div class="col-sm-4 col-3">
                        <h4 class="page-title">Time</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-border table-striped custom-table datatable mb-0">
                                <thead>
                                    <tr>
                                        <th>NO.</th>
                                        <th>Time Id</th>
                                        <th>Tahun</th>
                                        <th>Bulan</th>
                                        <th>Tanggal</th>
                                        <th>Tanggal Lengkap</th>
                                        <th>Hari</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($data as $mts) : ?>
                                        <tr>
                                            <td><?= $no; ?></td>
                                            <td> <?= $mts['time_id']; ?></td>
                                            <td><?= $mts['tahun']; ?></td>
                                            <td><?= $mts['bulan']; ?></td>
                                            <td> <?= $mts['tanggal']; ?></td>
                                            <td><?= $mts['tanggallengkap']; ?></td>
                                            <td><?= $mts['namahari']; ?></td>
                                        </tr>
                                <?php $no++; ?>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
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
    <script src="assets/js/select2.min.js"></script>
    <script src="assets/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/dataTables.bootstrap4.min.js"></script>
    <script src="assets/js/moment.min.js"></script>
    <script src="assets/js/bootstrap-datetimepicker.min.js"></script>
    <script src="assets/js/app.js"></script>

</body>
</html>