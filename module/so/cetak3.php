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
$tanggal = 'aaaa';
$no = 1;
$queryh = mysqli_query($connect, "select * from soh where id='$id' and soh.proses='Y' order by noso");
$de = mysqli_fetch_assoc($queryh);
$noso = $de['noso'];
$tanggal = tgl_indo($de['tglso']); // $de['tglso'];
$kdcustomer = $de['kdcustomer'];
$nmcustomer = $de['nmcustomer'];
$biaya_lain = number_format($de['biaya_lain'], 0, ",", ".");
$ppn = $de['ppn'];
$total = $de['total'];
$customer = $de['kdcustomer'] . '-' . $de['nmcustomer'];
$queryh = mysqli_query($connect, "select * from tbcustomer where kode='$kdcustomer'");
$de = mysqli_fetch_assoc($queryh);
$alamatcust = $de['alamat'] . ' ' . $de['kota'] . ' ' . $de['kodepos'];
$telpcust = $de['telp1'] . ' - ' . $de['telp2'];

// $rec = mysqli_num_rows($query);
// echo 'aaaaa'.$de['noso'].$de['harga'];

$html = '<style>
			td { border: 0.5px solid grey; margin: 5px; height: 20px;}
	        th { border: 0.5px solid grey; font-weight:normal; height: 30px;}
	        body { font-family: comic sans ms;}
		</style>		

		<font size="4" face="comic sans ms">
		<div class="panel-body">
		<div class="col-md-6">';

include '../../logo.php';
// align="center"
$html .= '<hr size="0">' . '
		<p style="margin-bottom:0px;" align="center"><font size="4">NOTA SALES ORDER</font></p>
		<hr />
		<table border="0" height="2" style="border: none;">
			<tr><td width="30" style="font-size:12px;">NO.</td><td width="280" style="font-size:13px";>: ' . "$noso" . '</td>
			<td width="180" style="font-size:12px";>' . "$nmcustomer" . '</td>
			<tr><td width="30" style="font-size:12px;">Tanggal </td></td><td width="280" style="font-size:13px";>: ' . "$tanggal" . '</td>
			</td><td width="180" style="font-size:11px";>' . "$alamatcust" . '</td>
			<tr><td></td><td style="font-size:12px;"></td></td><td style="font-size:11px";>' . "$telpcust" . '</td></tr>
			<hr size=2></font>
		</table>
		<table border="1" table-layout="fixed"; cellpadding="2"; cellspacing="0"; style=font-size:11px; class="table table-striped table table-bordered;">
			<tr>
				<th width="30px" height="20"><font size="1" color="black">NO.</th>
				<th width="100px"><font size="1" color="black">KODE BARANG</th>
				<th width="230px"><font size="1" color="black">NAMA BARANG</th>
				<th width="50px"><font size="1" color="black">SATUAN</th>
				<th width="50px"><font size="1" color="black">QTY</th>
				<th width="60px"><font size="1" color="black">HARGA</th>
				<th width="50px"><font size="1" color="black">DISC.(%)</th>
				<th width="80px"><font size="1" color="black">SUBTOTAL</th>
			</tr>';

$queryd = mysqli_query($connect, "select soh.noso,soh.tglso,soh.kdcustomer,soh.nmcustomer,sod.kdbarang,sod.nmbarang,sod.kdsatuan,sod.qty,sod.harga,sod.discount,sod.subtotal,tbsatuan.nama as nmsatuan from soh inner join sod on soh.noso=sod.noso left join tbsatuan on tbsatuan.kode=sod.kdsatuan where soh.noso='$noso' and soh.proses='Y' order by noso");
$nsubtotal = 0;
$jumrecord = mysqli_num_rows($queryd);
while ($row = mysqli_fetch_assoc($queryd)) {
	$qty = number_format($row['qty'], 2, ",", ".");
	$harga = number_format($row['harga'], 0, ",", ".");
	$discount = number_format($row['discount'], 2, ",", ".");
	$subtotal = number_format($row['subtotal'], 0, ",", ".");
	$html .= '<tr><td width="30px" align="center">' . $no . '</td>
					<td width="30px" align="left">' . "&nbsp;" . $row["kdbarang"] . '</td>
					<td width="50px" align="left">' . "&nbsp;" . $row["nmbarang"] . '</td>
					<td width="40px" align="center">' . $row["nmsatuan"] . '</td>
					<td width="50px" align="right">' . $qty . "&nbsp;" . '</td>
					<td width="70px" align="right">' . $harga . "&nbsp;" . '</td>
					<td width="30px" align="right">' . $discount . "&nbsp;" . '</td>
					<td width="70px" align="right">' . $subtotal . "&nbsp;" . '</td>
				</tr>';
	$no++;
	$nsubtotal = $nsubtotal + $row['subtotal'];
}
$subtotal = number_format($nsubtotal, 0, ",", ".");
$ntotal = number_format($total, 0, ",", ".");
$html .= '<tr>
				<td colspan="7" style="color:black" align="left">&nbsp;Subtotal ... </td><td align="right">&nbsp;' . $subtotal . '&nbsp;</td></tr>
				<tr><td colspan="7" style="color:black" align="left">&nbsp;Biaya Lain ... </td><td align="right">&nbsp;' . $biaya_lain . '&nbsp;</td></tr>
				<tr><td colspan="7" style="color:black" align="left">&nbsp;PPn (%) ... </td><td align="right">&nbsp;' . $ppn . '&nbsp;</td></tr>
				<tr><td colspan="7" style="color:black" align="left">&nbsp;Total ... </td><td align="right">&nbsp;' . $ntotal . '&nbsp;</td></tr></table>';
$html .= '<font size="1"><left>Tanggal cetak : ' . date('d-m-Y H:i:s a') . '<br><br>';
$terbilang = ucwords(terbilang($total));
$html .= '<font size="1">Jakarta,  ' . tgl_indo(date('Y-m-d')) . ',';
$html .= '<table border="0">
			<tr>
			<th></th>
			<br><br><br><br>
			<tr>
			<tr><td><font size="1" color="black" align="center">(Kabag.Penjualan)</td></tr></table>';

$filename = "FP_" . $noso . ".pdf";
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

	// if ($jumrecord > 1) {
	$mpdf = new \Mpdf\Mpdf([
		'format' => 'Letter-P',
		'margin_left' => 5,
		'margin_right' => 5,
		'margin_top' => 5,
		'margin_bottom' => 5,
		'margin_header' => 5,
		'margin_footer' => 5,
		'orientation' => 'P'
	]);
	// } else {
	// 	//$mpdf = new \Mpdf\Mpdf(['format' => [190, 126],
	// 	$mpdf = new \Mpdf\Mpdf([
	// 		'format' => [205, 126],
	// 		'margin_left' => 5,
	// 		'margin_right' => 5,
	// 		'margin_top' => 5,
	// 		'margin_bottom' => 5,
	// 		'margin_header' => 5,
	// 		'margin_footer' => 5,
	// 		'orientation' => 'P'
	// 	]);
	// }
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
// $dompdf->stream('laporan_' . $nama . '.pdf', array('Attachment' => false));
// 	//$dompdf->stream('laporan_'.$nama.'.pdf'); &&langsung download
