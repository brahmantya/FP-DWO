<?php

//Koneksi Ke Database
$conn = mysqli_connect("localhost", "root", "", "wh_sakila");

//Function Tampil Data
function tampil($query) {
	global $conn;
	$result = mysqli_query($conn, $query);
	$rows = [];
	while($row = mysqli_fetch_assoc($result)){
		$rows[] = $row;
	}
	return $rows;
}


?>

