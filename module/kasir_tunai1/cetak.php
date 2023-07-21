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
	$no=1;

	$queryh = mysqli_query($connect,"select * from kasir_tunai where id='$id' and kasir_tunai.proses='Y' order by nokwitansi");
	$de = mysqli_fetch_assoc($queryh);
	$nokwitansi = $de['nokwitansi'];
	$tanggal = tgl_indo($de['tglkwitansi']); // $de['tglkwitansi'];
	$nojual = $de['nojual'];
	$kdcustomer = $de['kdcustomer'];
	$nmcustomer = $de['nmcustomer'];
	$carabayar = $de['carabayar'];
	$keterangan = $de['keterangan'];
	$nmjnskartu = $de['nmjnskartu'];
	$norek = $de['norek'];
	$nocekgiro = $de['nocekgiro'];
	$total = $de['bayar'];

	include "../../logo.php";

	$html .='<br><center>TANDA TERIMA PEMBAYARAN</center>
		<hr style="width:99%;height:-1px;text-align:left;margin-left:0">
		<table border="0" height="5">
			<tr><td width="80" style="font-size:12px;">NO.</td><td width="180" style="font-size:12px";>: '."$nokwitansi".'</td>
			<tr><td width="60" style="font-size:12px;">Tanggal </td></td><td width="280" style="font-size:12px";>: '."$tanggal".'</td>
			<tr><td width="60" style="font-size:12px;">No. Penjualan </td></td><td width="280" style="font-size:12px";>: '."$nojual".'</td>
			<tr><td width="60" style="font-size:12px;">Customer </td></td><td width="280" style="font-size:12px";>: '."$nmcustomer".'</td>
			<tr><td width="60" style="font-size:12px;">Cara Bayar </td></td><td width="280" style="font-size:12px";>: '."$carabayar".'</td>
			<tr><td width="60" style="font-size:12px;">Jenis Kartu </td></td><td width="280" style="font-size:12px";>: '."$nmjnskartu".'</td>
			<tr><td width="60" style="font-size:12px;">No. Rekening </td></td><td width="280" style="font-size:12px";>: '."$norek".'</td>
			<tr><td width="60" style="font-size:12px;">No. Cek/Giro </td></td><td width="280" style="font-size:12px";>: '."$nocekgiro".'</td>
		</table>
		</font>';
	$ntotal = number_format($total,0,",",".");
	$html .= '<font size="2">Uang yang diterima : Rp. '.$ntotal.',-<br>';
	$terbilang = ucwords(terbilang($total));
	$html .= '<font size="2">Terbilang : <i># '.$terbilang.' Rupiah #</i></font>';
	$html .= '<table border="1" table-layout="fixed"; cellpadding="1"; cellspacing="1"; style=font-size:11px; class="table table-striped table table-bordered;">
			<tr>
				<th width="390px" height="20"><font size="1" color="black">KETERANGAN :</th>
				<th width="150px"><font size="1" color="black">PEMBAYAR</th>
				<th width="150px"><font size="1" color="black">KASIR</th>
				<tr><td height="80" align="center">'.$keterangan.'</td><td></td><td></td>
				<tr><td height="20"></td><td></td><td align="center">'.$_SESSION['username'].'</td>
			</tr></table>';
	$html .= '<font size="1" align="right" width="300">Tanggal cetak : '.date('d-m-Y H:i:s a').'</font>';
	
	// $dompdf = new DOMPDF();
	// $dompdf->load_html($html);
	// //$dompdf->set_paper('A4', 'Potrait');
	// $customPaper = array(0,-10,600,420);
	// $dompdf->set_paper($customPaper,'Potrait');	
	// $dompdf->render();
	// $dompdf->stream('laporan_'.$nama.'.pdf', array('Attachment' => false));	

	// $dompdf = new DOMPDF();
	// $dompdf->load_html($html);
	// //$dompdf->set_paper('A4', 'potrait');
	// $custompaper = array(0,-10,560,450); //(left,top,width,height)
	// $dompdf->set_paper($custompaper, 'Potrait');
	// $dompdf->render();
	// $dompdf->stream('laporan_'.$nama.'.pdf', array('Attachment' => false));	
	//$dompdf->stream('laporan_'.$nama.'.pdf'); &&langsung download
	$filename = $nokwitansi.".pdf";
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
		
	//$mpdf = new \Mpdf\Mpdf(['format' => [190, 126],
	$mpdf = new \Mpdf\Mpdf(['format' => [126, 205],
	'margin_left' => 5,
	'margin_right' => 5,
	'margin_top' => 5,
	'margin_bottom' => 5,
	'margin_header' => 5,
	'margin_footer' => 5,
	'orientation' => 'P']);
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