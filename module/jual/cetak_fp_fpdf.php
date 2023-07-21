<?php
// require('../../fpdf/fpdf.php');

// $pdf = new FPDF();
// $pdf->AddPage();
// $pdf->SetFont('Arial','B',16);
// $pdf->Cell(40,10,'Hello World!');
// $pdf->Output();
?>

<?php
 	session_start();
	include "../../timeout.php";
  if($_SESSION['login']==1){
		if(!cek_login()){
			$_SESSION['login']=0;
		}
  }
	if($_SESSION['login']==0){
	  header('location:../../logout.php');
	}
	//require_once "koneksi.php";
	include "../../inc/config.php";
	require_once("../../dompdf/dompdf_config.inc.php");
	include "../../terbilang.php";
	include "../../tgl_indo.php";
	include "../../fpdf/fpdf.php";
	date_default_timezone_set('Asia/Jakarta');
	$id = $_GET['id'];
	$who = "Update-".$_SESSION['username']."-".date('d-m-Y H:i:s');
	$nm_perusahaan = $_SESSION['nm_perusahaan'];
	$alamat_perusahaan = $_SESSION['alamat_perusahaan'];
	$telp_perusahaan = $_SESSION['telp_perusahaan'];
	$tanggal = 'aaaa';
	$no=1;
	
	$queryh = mysqli_query($connect,"select * from jualh where id='$id' and jualh.proses='Y' order by nojual");
	$de = mysqli_fetch_assoc($queryh);
	$nojual = $de['nojual'];
	$tanggal = tgl_indo($de['tgljual']); // $de['tgljual'];
	$kdcustomer = $de['kdcustomer'];
	$nmcustomer = $de['nmcustomer'];
	$biaya_lain = $de['biaya_lain'];
	$total = $de['total'];
	$customer = $de['kdcustomer'].'-'.$de['nmcustomer'];
	$queryh = mysqli_query($connect,"select * from tbcustomer where kode='$kdcustomer'");
	$de = mysqli_fetch_assoc($queryh);
	$alamatcust = $de['alamat'].' '.$de['kota'].' '.$de['kodepos'];
	$telpcust = $de['telp1'].' - '.$de['telp2'];

	$tgl = date('d-M-Y');
	//$pdf = new FPDF();
	$pdf = new FPDF('P','mm','Letter');
	//$pdf = new FPDF('P','mm',array(210,297));
	//$pdf= new FPDF('P','mm',array(100,100));
	//$pdf = new FPDF('P','in',array(5.5,8.5));
	//$this->PageFormats=array('a3'=>array(841.89,1190.55), 'a4'=>array(595.28,841.89), 'a42'=>array(595.28,430.89), 'a5'=>array(420.94,595.28), 'letter'=>array(612,792), 'legal'=>array(612,1008));
	//$pdf->Open();
	$pdf->addPage();
	$pdf->setAutoPageBreak(false);
	$start_awal=$pdf->GetX(); 
	$get_xxx = $pdf->GetX();
	$get_yyy = $pdf->GetY();
	$pdf->setFont('Arial','B',10);
	$pdf->text(10,10,$nm_perusahaan);
	$pdf->setFont('Arial','',7);
	$pdf->text(10,14,$alamat_perusahaan);
	$pdf->text(10,18,$telp_perusahaan);
	$pdf->setFont('Arial','',8);
	$pdf->text(125,10,'Kepada YTH :');
	$pdf->setFont('Arial','',9);
	$pdf->text(125,14,$nmcustomer);
	$pdf->setFont('Arial','',7);
	$pdf->text(125,18,$alamatcust);
	$pdf->text(125,22,$telpcust);
	$pdf->setFont('Arial','BU',11);
	$pdf->Cell(0,31,'FAKTUR PENJUALAN',0,0,'C');
	$pdf->setFont('Arial','',8);
	$pdf->text(10,31,'NO. PENJUALAN');
	$pdf->text(10,35,'TANGGAL');
	$pdf->text(35,31,': '.$nojual);
	$pdf->text(35,35,': '.$tanggal);
	$yi = 44;
	$ya = 38;
	$row = 0;
	$pdf->setFont('Arial','',8);
	//$pdf->setFillColor(222,222,222);
	$pdf->setFillColor(255,255,255);
	$pdf->setXY(10,$ya);
	$pdf->CELL(6,6,'NO',1,0,'C',1);
	$pdf->CELL(25,6,'KODE BARANG',1,0,'C',1);
	$pdf->CELL(70,6,'NAMA BARANG',1,0,'C',1);
	$pdf->CELL(13,6,'SATUAN',1,0,'C',1);
	$pdf->CELL(14,6,'QTY',1,0,'C',1);
	$pdf->CELL(17,6,'HARGA',1,0,'C',1);
	$pdf->CELL(10,6,'DISC.',1,0,'C',1);
	$pdf->CELL(18,6,'SUBTOTAL',1,0,'C',1);
	$ya = $yi + $row;
	$i = 1;
	$no = 1;
	$max = 31;
	$row = 6;
	$sql = mysqli_query($connect,"select * from jualh where id='$id' and jualh.proses='Y' order by nojual");
	while($data = mysqli_fetch_assoc($sql)){
	$pdf->setXY(10,$ya);
	$pdf->setFont('Arial','',7);
	$pdf->setFillColor(255,255,255);
	$pdf->cell(6,6,$no,1,0,'C',1);
	$pdf->cell(25,6,$data['tgljual'],1,0,'L',1);
	$width_cell = 40;  
	$height_cell = 6; 
	// $pdf->Ln();
	// $get_xxx=$start_awal; 
	// $get_yyy+=$height_cell;
	// $pdf->MultiCell($width_cell,$height_cell,'Kolompertama aaaaaaaa aaaaaaaaa aaaaaaaaaaaa',1); 
	// $get_xxx+=$width_cell;                           
	// $pdf->SetXY($get_xxx, $get_yyy);   	
	$pdf->cell(70,6,$data['nmcustomer'],1,0,'L',1);
	$pdf->cell(13,6,$data['tgljual'],1,0,'L',1);
	$pdf->cell(14,6,$data['tgljual'],1,0,'L',1);
	$pdf->cell(17,6,$data['tgljual'],1,0,'L',1);
	$pdf->cell(10,6,$data['tgljual'],1,0,'L',1);
	$pdf->cell(18,6,$data['tgljual'],1,0,'L',1);
	$ya = $ya+$row;
	$no++;
	$i++;
	//$dm[kode] = $data[kdprog];
	}
	// $pdf->text(100,$ya+6,"BENER MERIAH , ".$tgl);
	// $pdf->text(100,$ya+18,"KEPALA SEKOLAH");
	$pdf->output();
?>

<!-- $pdf->AddPage();

$start_awal=$pdf->GetX(); 
$get_xxx = $pdf->GetX();
$get_yyy = $pdf->GetY();

$width_cell = 40;  
$height_cell = 7;    

$pdf->SetFont('Arial','',16);

$pdf->MultiCell($width_cell,$height_cell,'Kolompertama',1); 
$get_xxx+=$width_cell;                           
$pdf->SetXY($get_xxx, $get_yyy);               

$pdf->MultiCell($width_cell,$height_cell,'Kolomkedua',1); 
$get_xxx+=$width_cell;                           
$pdf->SetXY($get_xxx, $get_yyy);               

$pdf->MultiCell($width_cell,$height_cell,'Kolomketiga',1);
$get_xxx+=$width_cell;

$pdf->Ln();
$get_xxx=$start_awal;                      
$get_yyy+=$height_cell;                  

$pdf->SetXY($get_xxx, $get_yyy);

$pdf->MultiCell($width_cell,$height_cell,'Kolomselanjutnya',1);
$get_xxx+=$width_cell;
$pdf->SetXY($get_xxx, $get_yyy);

$pdf->MultiCell($width_cell,$height_cell,'Kolomyangkhusus(extrakali)',1);
$get_xxx+=$width_cell;
$pdf->SetXY($get_xxx, $get_yyy);

$pdf->MultiCell($width_cell,$height_cell,'kolomterakhir(extrakali)',1);
$get_xxx+=$width_cell;
$pdf->SetXY($get_xxx, $get_yyy);

$pdf->Output(); -->