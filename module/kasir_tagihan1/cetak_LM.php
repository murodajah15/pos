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

	$queryh = mysqli_query($connect,"select * from kasir_tagihan where id='$id' and kasir_tagihan.proses='Y' order by nokwitansi");
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

	$html = '<style>
			td { border: 0.5px solid grey; margin: 5px; height: 10px;}
	        th { border: 0.5px solid grey; font-weight:normal; height: 30px;}
	        body { font-family: comic sans ms;}
		</style>		

		<font size="4" face="comic sans ms">
		<center>TANDA TERIMA PEMBAYARAN TAGIHAN</center>
		<br></br>
		<table border="0" height="5">
			<tr><td width="30" style="font-size:12px;">NO.</td><td width="280" style="font-size:13px";>: '."$nokwitansi".'</td>
			<tr><td width="30" style="font-size:12px;">Tanggal </td></td><td width="280" style="font-size:13px";>: '."$tanggal".'</td>
			<tr><td width="30" style="font-size:12px;">No. Penjualan </td></td><td width="280" style="font-size:13px";>: '."$nojual".'</td>
			<tr><td width="30" style="font-size:12px;">Customer </td></td><td width="280" style="font-size:13px";>: '."$nmcustomer".'</td>
			<tr><td width="30" style="font-size:12px;">Cara Bayar </td></td><td width="280" style="font-size:13px";>: '."$carabayar".'</td>
			<tr><td width="30" style="font-size:12px;">Jenis Kartu </td></td><td width="280" style="font-size:13px";>: '."$nmjnskartu".'</td>
			<tr><td width="30" style="font-size:12px;">No. Rekening </td></td><td width="280" style="font-size:13px";>: '."$norek".'</td>
			<tr><td width="30" style="font-size:12px;">No. Cek/Giro </td></td><td width="280" style="font-size:13px";>: '."$nocekgiro".'</td>
		</table>
		<hr size=2></font>';
	$ntotal = number_format($total,0,",",".");
	$html .= '<font size="2">Uang yang diterima : Rp. '.$ntotal.',-<br>';
	$terbilang = ucwords(terbilang($total));
	$html .= '<font size="2">Terbilang : <i># '.$terbilang.' Rupiah #</i></font>';
	$html .= '<hr size=1>';
	$html .= '	<table table-layout="fixed"; cellpadding="0"; cellspacing="0"; style=font-size:11px; class="table table-striped table table-bordered;">
			<tr>
				<th width="390px" height="20"><font size="1" color="black">KETERANGAN :</th>
				<th width="150px"><font size="1" color="black">PEMBAYAR</th>
				<th width="150px"><font size="1" color="black">KASIR</th>
				<tr><td height="80" align="center">'.$keterangan.'</td><td></td><td></td>
				<tr><td height="20"></td><td></td><td align="center">'.$_SESSION['username'].'</td>
			</tr>';
	
	
	// $html .= '<font size="1" align="right" width="300"><p>Tanggal cetak : '.date('d-m-Y H:i:s a').'</p></font>';
	// $terbilang = ucwords(terbilang($total));
	// $html .= '<font size="1">Jakarta,  '.tgl_indo(date('Y-m-d')).',';

	// $html .= '<table border="0">
	// 		<tr>
	// 		<th></th>
	// 		<tr><td></td>
	// 		<tr><td><font size="1" color="black" align="center">(Kabag. Pembelian)</td></tr>';

	
	$dompdf = new DOMPDF();
	$dompdf->load_html($html);
	$dompdf->set_paper('A4', 'potrait');
	$dompdf->render();
	$dompdf->stream('laporan_'.$nama.'.pdf', array('Attachment' => false));	
	//$dompdf->stream('laporan_'.$nama.'.pdf'); &&langsung download
?>