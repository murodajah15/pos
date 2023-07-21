<?php
    session_start();
     // if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
      // echo "<link href='style.css' rel='stylesheet' type='text/css'>
     // <center>Untuk mengakses modul, Anda harus login <br>";
      // echo "<a href=../../index.php><b>LOGIN</b></a></center>";
    // }
    // else{

	include "../timeout.php";
	
    if($_SESSION['login']==1){
		if(!cek_login()){
			$_SESSION['login']=0;
		}
    }
	
	if($_SESSION['login']==0){
	  header('location:../logout.php');
	}
	
	//require_once "koneksi.php";
	include "../inc/config.php";

	// $tgl1 = $_GET['tgl1'];
	// $tgl2 = $_GET['tgl2'];
	// $query = "SELECT (@rn := @rn + 1) as nourut,nomor,tanggal,norangka,nama_tipe,nama_warna,status from spk cross join
	// (select @rn := 0) const where tanggal between '$tgl1' and '$tgl2' order by tanggal desc";
	 
	#ambil data di tabel dan masukkan ke array
	$query = "select @curRow := @curRow + 1 nourut,kode,nama from tbbank, (SELECT @curRow := 0 ) as curRow where aktif='Y' order by kode";
	$sql = mysqli_query ($connect,$query);
	$data = array();
	while ($row = mysqli_fetch_assoc($sql)) {
		array_push($data, $row);
	}
	 
	#setting judul laporan dan header tabel
	date_default_timezone_set('Asia/Jakarta');
	$date=date('d-m-Y H:i:s');
	$judul = "DAFTAR TABEL BANK "; //.$tgl1." s/d ".$tgl2;
	$header = array(
			array("label"=>"NO.", "length"=>10, "align"=>"C", "alignd"=>"C"), //C alignd belum berfungsi
			array("label"=>"KODE", "length"=>25, "align"=>"C", "alignd"=>"L"),
			array("label"=>"NAMA", "length"=>100, "align"=>"C", "alignd"=>"L"));
	
	#sertakan library FPDF dan bentuk objek
	require_once ("../fpdf/fpdf.php");
	$pdf = new FPDF('P','mm',array(297,210)); //L For Landscape / P For Portrait
	/*$pdf = new FPDF();**/
	$pdf->AddPage();
	 
	#tampilkan judul laporan
	$pdf->SetFont('Arial','B','16');
	$pdf->Cell(0,20, $judul, '0', 1, 'L'); //Header
	 
	#buat header tabel
	$pdf->SetFont('Arial','','10');
	$pdf->SetFillColor(224,235,255);
	$pdf->SetTextColor(0);
	$pdf->SetDrawColor(0,0,0);
	foreach ($header as $kolom) {
		$pdf->Cell($kolom['length'], 5, $kolom['label'], 1, '0', $kolom['align'], true);
	}
	$pdf->Ln();
	 
	#tampilkan data tabelnya
	$pdf->SetFont('Arial','','8');
	$pdf->SetFillColor(255);
	$pdf->SetTextColor(0);
	$pdf->SetFont('');
	$fill=false;
	foreach ($data as $baris) {
		$i = 0;
		foreach ($baris as $cell) {
			$pdf->Cell($header[$i]['length'], 5, $cell, 1, '0', $header[$i]['alignd'], $fill);
			//$pdf->Cell($header[$i]['length'], 5, $cell, 1, '0', $kolom['align'], $fill);
			$i++;
		}
		$fill = !$fill;
		$pdf->Ln();
	}
	#output file PDF
	$pdf->Output();
?>