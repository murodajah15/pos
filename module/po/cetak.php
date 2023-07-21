<?php
session_start();
include "../../timeout.php";
if ($_SESSION['login'] == 1) {
	if (!cek_login()) {
		$_SESSION['login'] = 0;
	}
}
if ($_SESSION['login'] == 0) {
	header('location:../../logout.php');
}
//require_once "koneksi.php";
include "../../inc/config.php";
require_once("../../dompdf/dompdf_config.inc.php");
include "../../terbilang.php";
include "../../tgl_indo.php";
date_default_timezone_set('Asia/Jakarta');
$id = $_GET['id'];
$who = "Update-" . $_SESSION['username'] . "-" . date('d-m-Y H:i:s');
$nm_perusahaan = $_SESSION['nm_perusahaan'];
$alamat_perusahaan = $_SESSION['alamat_perusahaan'];
$telp_perusahaan = $_SESSION['telp_perusahaan'];
$no = 1;

$queryh = mysqli_query($connect, "select * from poh where id='$id' and poh.proses='Y' order by nopo");
$de = mysqli_fetch_assoc($queryh);
$nopo = $de['nopo'];
$tanggal = tgl_indo($de['tglpo']); // $de['tglpo'];
$kdsupplier = $de['kdsupplier'];
$nmsupplier = $de['nmsupplier'];
$biaya_lain = number_format($de['biaya_lain'], 0, ",", ".");
$ppn = $de['ppn'];
$total = $de['total'];
$supplier = $de['kdsupplier'] . '-' . $de['nmsupplier'];
$keterangan = $de['keterangan'];
$queryh = mysqli_query($connect, "select * from tbsupplier where kode='$kdsupplier'");
$de = mysqli_fetch_assoc($queryh);
$alamatcust = $de['alamat'] . ' ' . $de['kota'] . ' ' . $de['kodepos'];
$telpcust = $de['telp1'] . ' - ' . $de['telp2'];

// $rec = mysqli_num_rows($query);
// echo 'aaaaa'.$de['nopo'].$de['harga'];


// $html = '<style>
// 		td { border: 0.5px solid grey; margin: 5px; height: 20px;}
//         th { border: 0.5px solid grey; font-weight:normal; height: 30px;}
//         body { font-family: comic sans ms;}
// 	</style>		

// 	<font size="4" face="comic sans ms">
// 	<div class="panel-body">
// 		<div class="col-md-6">';
$logo = $_SESSION['logo'];

include "../../logo.php";

// if ($logo<>"") {
// 	$html .= '<img src="../../img/'."$logo".'" width="50">';
// }
// $html .= ''."$nm_perusahaan".'
// 		<font size="2"><br>'."$alamat_perusahaan".'
// 		<br>'."$telp_perusahaan".'
// 		<hr size="1"></font>
// 	</div></div>
$html .= '<p style="margin-top:5px; margin-bottom:5px" align="center"><u>PURCHASE ORDER</u></p>
	<hr style="width:99%;text-align:left;margin-left:0">';

$html .= '<table border="0" height="5">
			<tr><td width="50" style="font-size:12px;">Kepada Yth :</td><td width="150" style="font-size:13px";>.' . "" . '</td>
			<td width="180" style="font-size:12px";>' . "Pemesan :" . '</td><td width="150" style="font-size:13px";>' . "" . '</td>
			<tr><td width="150" style="font-size:12px";>' . "$nmsupplier" . '</td><td width="150"></td><td width="200" style="font-size:13px";>' . "$nm_perusahaan" . '</td>
			<tr><td width="150" style="font-size:10px";>' . "$alamatcust" . '</td><td width="150"></td><td width="200" style="font-size:10px";>' . "$alamat_perusahaan" . '</td>
			<tr><td width="150" style="font-size:11px";>' . "$telpcust" . '</td><td width="150"></td><td width="200" style="font-size:10px";>' . "$telp_perusahaan" . '</td>
			<tr><td width="150" style="font-size:10px";>' . "" . '</td><td width="150"></td><td width="200" style="font-size:13px";>No. PO : ' . "$nopo" . '</td>
			<tr><td width="150" style="font-size:10px";>' . "" . '</td><td width="150"></td><td width="200" style="font-size:13px";>Tanggal: ' . "$tanggal" . '</td>
			<hr size=2></font>
		</table>
		<table border="0" table-layout="fixed"; cellpadding="0"; cellspacing="0"; style=font-size:11px; class="table table-striped table table-bordered;">
			<tr>
				<th width="50px" height="20"  align="center"><font size="1" color="black">NO.</th>
				<th width="150px" align="left"><font size="1" color="black">&nbsp;KD. BARANG</th>
				<th width="400px" align="left"><font size="1" color="black">&nbsp;NAMA BARANG</th>
				<th width="90px"  align="right"><font size="1" color="black">&nbsp;QTY&nbsp;</th>
			</tr>';

$queryd = mysqli_query($connect, "select poh.nopo,poh.tglpo,poh.kdsupplier,poh.nmsupplier,pod.kdbarang,pod.nmbarang,pod.kdsatuan,pod.qty,pod.harga,pod.discount,pod.subtotal,tbsatuan.nama as nmsatuan from poh inner join pod on poh.nopo=pod.nopo left join tbsatuan on tbsatuan.kode=pod.kdsatuan where poh.nopo='$nopo' and poh.proses='Y' order by nopo");
$nsubtotal = 0;
while ($row = mysqli_fetch_assoc($queryd)) {
	$harga = number_format($row['harga'], 0, ",", ".");
	$subtotal = number_format($row['subtotal'], 0, ",", ".");
	$html .= '<tr><td align="center">' . $no . '</td>
					<td align="left">' . "&nbsp;" . $row["kdbarang"] . '</td>
					<td align="left">' . "&nbsp;" . $row["nmbarang"] . '</td>
					<td align="right">' . $row["qty"] . "&nbsp;" . '</td>
					</tr>';
	$no++;
	$nsubtotal = $nsubtotal + $row['subtotal'];
}
$subtotal = number_format($nsubtotal, 0, ",", ".");
$ntotal = number_format($total, 0, ",", ".");
$html .= '</table><font size="1"><left><br>Catatan : <br>' . $keterangan . '<br>';
$terbilang = ucwords(terbilang($total));
//$html .= '</table><font size="1" align="right" width="300"><p>Tanggal cetak : '.date('d-m-Y H:i:s a').'</p></font>';
$terbilang = ucwords(terbilang($total));
$html .= '<font size="1">Jakarta,  ' . tgl_indo(date('Y-m-d')) . ',';

$html .= '<table border="0">
			<tr><td width="50" style="font-size:12px;">Yang Mengajukan,</td><td width="350" style="font-size:13px";>' . "" . '</td>
			<td width="180" style="font-size:12px";>&nbsp;&nbsp;&nbsp;&nbsp;Mengetahui</td><td width="150" style="font-size:13px";> ' . "" . '</td>	
			<tr>
			<th></th>
			<tr><td></td>
			<tr><td width="50" style="font-size:12px;">(______________)</td><td width="350" style="font-size:10px";> ' . "" . '</td>
			<td width="180" style="font-size:12px";>(______________)</td><td width="150" style="font-size:13px";> ' . "" . '</td>	
			';


try {
	require_once("../../vendor/autoload.php");

	//$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'utf-8', [190, 236]]);
	//  $mpdf = new mPDF('',    // mode - default ''
	// '',    // format - A4, for example, default ''
	// 0,     // font size - default 0
	// '',    // default font family
	// 15,    // margin_left
	// 15,    // margin right
	// 16,     // margin top
	// 16,    // margin bottom
	// 9,     // margin header
	// 9,     // margin footer
	// 'L');  // L - landscape, P - portrait

	$mpdf = new \Mpdf\Mpdf([
		'format' => 'Letter-P',
		'margin_left' => 10,
		'margin_right' => 10,
		'margin_top' => 5,
		'margin_bottom' => 5,
		'margin_header' => 5,
		'margin_footer' => 5,
	]);
	// 	'mode' => 'c',
	$mpdf->SetDisplayMode(50);
	$mpdf->showImageErrors = true;
	$mpdf->mirrorMargins = 1;
	$mpdf->SetTitle('Generate PDF file using PHP and MPDF');
	$mpdf->WriteHTML($html);
	$mpdf->Output($filename, 'I');
} catch (\Mpdf\MpdfException $e) {
	echo $e->getMessage();
}
					  
				
				// $dompdf = new DOMPDF();
				// $dompdf->load_html($html);
				// $dompdf->set_paper('A4', 'potrait');
				// $dompdf->render();
				// $dompdf->stream('laporan_'.$nama.'.pdf', array('Attachment' => false));	
				//$dompdf->stream('laporan_'.$nama.'.pdf'); &&langsung download
