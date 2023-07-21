<?php
	session_start();
	include("./inc/config.php");
	//get search term
	$searchTerm = $_GET['term'];
	//get matched data from skills table
	$query = $connect->query("SELECT * FROM mst_pegawai WHERE nip LIKE '%".$searchTerm."%' ORDER BY nip ASC");
	while ($row = $query->fetch_assoc()) {
		$data[] = $row['nip'];
	}
	//return json data
	echo json_encode($data);
?>