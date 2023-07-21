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

	// $rec = mysqli_num_rows($query);
	// echo 'aaaaa'.$de['nojual'].$de['harga'];

	//echo '<center><p><u>FAKTUR PENJUALAN</u></p></center>';
	// $html = '<style>
	// 		td { border: 0px solid grey; margin: 5px; height: 20px;}
	//         th { border: 0px solid grey; font-weight:normal; height: 30px;}
	//         body { font-family: comic sans ms;}
	// 	</style>		

	include "../../logo.php";

	$html .= '<p align="center"><u>FAKTUR PENJUALAN</u></p>
		<table border="0">
			<tr><td width="30" style="font-size:12px;">NO.</td><td width="280" style="font-size:13px";>: '."$nojual".'</td>
			<td width="380" style="font-size:12px";>'."$nmcustomer".'</td>
			<tr><td width="30" style="font-size:12px;">Tanggal </td></td><td width="280" style="font-size:13px";>: '."$tanggal".'</td>
			</td><td width="180" style="font-size:10px";>'."$alamatcust".'</td>
			<tr><td colspan="2"></td><td style="font-size:12px";>'."$telpcust".'</td></tr></table>';

		$html .= '<table border="1" table-layout="fixed"; cellpadding="0"; cellspacing="0"; style=font-size:17px; class="table table-striped table table-bordered;">
			<tr>
			<td width="30px"><font size="1">NO.</td>
			<td width="95px" align="center"><font size="1">KODE<br>BARANG</td>
			<td width="360px" align="center"><font size="1">NAMA BARANG</td>
			<td width="50px" align="center"><font size="1">&nbsp;SATUAN&nbsp;</td>
			<td width="50px" align="center"><font size="1">QTY</td>
			<td width="65px" align="center"><font size="1">HARGA</td>
			<td width="42px" align="center"><font size="1">DISC.</td>
			<td width="66px" align="center"><font size="1">&nbsp;SUBTOTAL&nbsp;</td>
			</tr></table>';

	$queryd = mysqli_query($connect,"select jualh.nojual,jualh.tgljual,jualh.kdcustomer,jualh.nmcustomer,juald.kdbarang,juald.nmbarang,juald.kdsatuan,juald.qty,juald.harga,juald.discount,juald.subtotal,tbsatuan.nama as nmsatuan from jualh inner join juald on jualh.nojual=juald.nojual left join tbsatuan on tbsatuan.kode=juald.kdsatuan where jualh.nojual='$nojual' and jualh.proses='Y' order by nojual");
	$nsubtotal = 0;
	$jumrecord = mysqli_num_rows($queryd);
	$html .= '<table border="0.5" table-layout="fixed"; cellpadding="0"; cellspacing="0"; style=font-size:17px; class="table table-striped table table-bordered;">';
	while ($row = mysqli_fetch_assoc($queryd)){
		$harga = number_format($row['harga'],0,",",".");
		$subtotal = number_format($row['subtotal'],0,",",".");
		$html .= '<tr><td width="30px" align="center" height="10"><font size="1">'.$no.'</td>
					<td width="95px"><font size="1" align="left">'."&nbsp;".$row["kdbarang"].'</td>
					<td width="375x" style="font-size:11px"; align="left">'."&nbsp;".$row["nmbarang"].'</td>
					<td width="30px" align="center"><font size="1">'.$row["nmsatuan"].'</td>
					<td width="60px" align="right"><font size="1">'.$row["qty"]."&nbsp;".'</td>
					<td width="68px" align="right"><font size="1">'.$harga."&nbsp;".'</td>
					<td width="40px" align="right"><font size="1">'.$row["discount"]."&nbsp;".'</td>
					<td width="75px" align="right"><font size="1">'.$subtotal."&nbsp;".'</td>
				</tr>';
		 $no++;
		 $nsubtotal = $nsubtotal + $row['subtotal'];
	}
	$html .='</table>';

	$subtotal = number_format($nsubtotal,0,",",".");
	$ntotal = number_format($total,0,",",".");

	$html .= '<table border="1" height="15" style="font-size:11px"; table-layout="fixed"; cellpadding="0"; cellspacing="0"; class="table table-striped table table-bordered;">	
			<tr>
				<td width="120px" style="font-size:11px" align="center">Penerima.</td>
				<td width="185px" align="center">Hormat Kami</td>
				<td width="254x" align="center" ro>Barang-barang tsb diatas telah diterima /diperiksa dengan baik dan ukuran cukup</td>
				<td width="75px"><font size="1" align="center" colspan="2"></td><td></td>
			</tr>
			<tr><td rowspan="4"></td><td rowspan="4"></td><td align="center">KAMI HANYA MELAYANI<td width="40" align="left">&nbsp;Subtotal</td><td width="50" align="right">'.$subtotal.'&nbsp;</td></tr>
			<tr><td align="center">KOMPLAIN/PENUKARAN BARANG<td width="40" align="left">&nbsp;Biaya Lain</td><td width="50" align="right">'.$biaya_lain.'&nbsp;</td></tr>
			<tr><td align="center">DALAM WAKTU 7 (TUJUH) HARI,<td width="50" align="left">&nbsp;Total</td><td width="80" align="right">'.$ntotal.'&nbsp;</td></tr>
			<tr><td align="center">SETELAH BARANG DITERIMA</td><td colspan="2"></td></tr>
			<tr><td style="font-size:11px" align="center" width="180">Nama Terang & Cap Perusahaan</td><td style="font-size:11px" align="center" width="170">'.$nm_perusahaan.'&nbsp;</td><td></td><td colspan="2"></td></tr>';	
	$html .='</table>';

	$filename = "FP_".$nojual.".pdf";
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
		
		if ($jumrecord > 10){
			$mpdf = new \Mpdf\Mpdf(['format' => 'Letter-P',
	 		'margin_left' => 5,
	 		'margin_right' => 5,
	 		'margin_top' => 5,
			'margin_bottom' => 5,
			'margin_header' => 5,
			'margin_footer' => 5,]);
		}else{
			//$mpdf = new \Mpdf\Mpdf(['format' => [190, 126],
			$mpdf = new \Mpdf\Mpdf(['format' => [205, 126],
	 		'margin_left' => 5,
	 		'margin_right' => 5,
			'margin_top' => 5,
			'margin_bottom' => 5,
			'margin_header' => 5,
			'margin_footer' => 5,
			'orientation' => 'P']);
		}
	  // 	'mode' => 'c',
	  $mpdf->SetDisplayMode(50);
	  $mpdf->showImageErrors = true;
	  $mpdf->mirrorMargins = 1;
	  $mpdf->SetTitle('Generate PDF file using PHP and MPDF');
	  $mpdf->WriteHTML($html);
	  $mpdf->Output($filename, 'I');
	} catch(\Mpdf\MpdfException $e) {
	  echo $e->getMessage();
	}

?>