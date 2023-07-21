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


	// echo '<style>
	// 		td { border: 1px solid grey; margin: 5px; height: 20px;}
	//         th { border: 1px solid grey; font-weight:normal; height: 30px;}
	//         body { font-family: comic sans ms;}
	// 	</style>		

	// 	<font size="4" face="comic sans ms">
	// 	<div class="panel-body">
	// 	<div class="col-md-12">';
	$logo = $_SESSION['logo'];
	if ($logo<>"") {
		echo '<img src="../../img/'."$logo".'" width="50">';
	}
	echo "<b><font size='5'>$nm_perusahaan".'
			<font size="3"><br>'."$alamat_perusahaan".'
			<br>'."$telp_perusahaan".'</font>
		<center><u>FAKTUR PENJUALAN</u></center>
		<br style="line-height:5px">
		<table cellpadding="0"; cellspacing="0"; border="0"; style=font-size:20px; height="5";>
			<tr><td width="40" height="5" style="font-size:20px;">NO.</td><td width="580" height="5" style="font-size:20px";>: '."$nojual".'</td>
			<td width="480" height="5" style="font-size:20px";>'."<b>$nmcustomer".'</td>
			<tr><td width="40" height="5" style="font-size:20px;">Tanggal </td></td><td width="280" height="5" style="font-size:20px";>: '."$tanggal".'</td>
			</td><td width="280" height="5" style="font-size:17px";>'."$alamatcust".'</td>
			<tr><td height="10" colspan="2"></td><td height="10" style="font-size:20px";>'."$telpcust".'</td></tr>
			<tr>
			</font>
		</table>
		<br style="line-height:5px">
		<table border="1" table-layout="fixed"; cellpadding="0"; cellspacing="0"; style=font-size:17px; class="table table-striped table table-bordered;">
			<tr>
				<th width="50px" height="7"><font size="3" color="black">NO.</th>
				<th width="150px"><font size="3" color="black">KODE BARANG</th>
				<th width="500px"><font size="3" color="black">NAMA BARANG</th>
				<th width="80px"><font size="3" color="black">SATUAN</th>
				<th width="63px"><font size="3" color="black">QTY</th>
				<th width="90px"><font size="3" color="black">HARGA</th>
				<th width="55px"><font size="3" color="black">DISC.</th>
				<th width="105px"><font size="3" color="black">SUBTOTAL</th>
			</tr>';

	$queryd = mysqli_query($connect,"select jualh.nojual,jualh.tgljual,jualh.kdcustomer,jualh.nmcustomer,juald.kdbarang,juald.nmbarang,juald.kdsatuan,juald.qty,juald.harga,juald.discount,juald.subtotal,tbsatuan.nama as nmsatuan from jualh inner join juald on jualh.nojual=juald.nojual left join tbsatuan on tbsatuan.kode=juald.kdsatuan where jualh.nojual='$nojual' and jualh.proses='Y' order by nojual");
	$nsubtotal = 0;
	$jumrecord = mysqli_num_rows($queryd);
	while ($row = mysqli_fetch_assoc($queryd)){
		$harga = number_format($row['harga'],0,",",".");
		$subtotal = number_format($row['subtotal'],0,",",".");
		echo '<tr><td align="center" height="10" font size="2">'.$no.'</td>
					<td align="left" font size="2">'."&nbsp;".$row["kdbarang"].'</td>
					<td align="left" font size="2">'."&nbsp;".$row["nmbarang"].'</td>
					<td align="center" font size="2">'.$row["nmsatuan"].'</td>
					<td align="right" font size="2">'.$row["qty"]."&nbsp;".'</td>
					<td align="right" font size="2">'.$harga."&nbsp;".'</td>
					<td align="right" font size="2">'.$row["discount"]."&nbsp;".'</td>
					<td align="right" font size="2">'.$subtotal."&nbsp;".'</td>
				</tr>';
		 $no++;
		 $nsubtotal = $nsubtotal + $row['subtotal'];
	}
	$subtotal = number_format($nsubtotal,0,",",".");
	$ntotal = number_format($total,0,",",".");
	echo '<table border="1" table-layout="fixed"; cellpadding="0"; cellspacing="0"; style=font-size:11px; class="table table-striped table table-bordered;">
			<tr>
				<th width="150px"><font size="3" color="black" align="center">Penerima.</th>
				<th width="250px"><font size="3" color="black" align="center">Hormat Kami</th>
				<th width="345px"><font size="3" color="black" align="center">Barang-barang tsb diatas telah diterima/diperiksa dengan baik dan ukuran cukup</th>
				<th width="176px"><font size="3" color="black" align="center" colspan="2"></th><th></th>
			</tr>
			<tr><td rowspan="4"></td><td rowspan="4"></td><td style="font-size:20px"; align="center">KAMI HANYA MELAYANI<td width="42" style="font-size:20px"; align="left">&nbsp;Subtotal</td><td style="font-size:20px"; width="105" align="right">'.$subtotal.'&nbsp;</td></tr>
			<tr><td style="font-size:20px"; align="center">KOMPLAIN/PENUKARAN BARANG<td width="42" style="font-size:20px"; align="left">&nbsp;Biaya Lain</td><td style="font-size:20px"; width="50" align="right">'.$biaya_lain.'&nbsp;</td></tr>
			<tr><td style="font-size:20px"; align="center">DALAM WAKTU 7 (TUJUH) HARI,<td width="42" style="font-size:20px"; align="left">&nbsp;Total</td><td style="font-size:20px"; width="50" align="right">'.$ntotal.'&nbsp;</td></tr>
			<tr><td style="font-size:20px"; align="center">SETELAH BARANG DITERIMA</td><td colspan="2"></td></tr>
			<tr><td style="font-size:17px"; align="center">Nama Terang & Cap Perusahaan</td><td style="font-size:17px"; align="center">'.$nm_perusahaan.'&nbsp;</td><td></td><td colspan="2"></td></tr></table>';

	// $html .= '<tr>
	// 			<td colspan="7" style="color:black" align="left">&nbsp;Subtotal ... </td><td align="right">&nbsp;'.$subtotal.'&nbsp;</td></tr>
	// 			<tr><td colspan="7" style="color:black" align="left">&nbsp;Biaya Lain ... </td><td align="right">&nbsp;'.$biaya_lain.'&nbsp;</td></tr>
	// 			<tr><td colspan="7" style="color:black" align="left">&nbsp;Total ... </td><td align="right">&nbsp;'.$ntotal.'&nbsp;</td></tr>
	// 			';
	//$html .= '<font size="2"><p><left>Tanggal cetak : '.date('d-m-Y H:i:s a').'</p></font>';
	$terbilang = ucwords(terbilang($total));
	echo '<br style="line-height:5px">
	<font size="4">Terbilang : # '.$terbilang.' Rupiah #'.'<br></font>';

	// $dompdf = new DOMPDF();
	// $dompdf->load_html($html);
	// if ($jumrecord > 5) {
	// 	$dompdf->set_paper('letter', 'potrait');
	// 	//$custompaper = array(0,-10,560,850); //(left,top,width,height)
	// 	//$dompdf->set_paper($custompaper, 'Potrait');
	// }else{
	// 	$dompdf->set_paper('Letter', 'potrait');
	// 	//$custompaper = array(0, -10, 800, 550); //array(0,-10,560,550); //(left,top,width,height)
	// 	//$dompdf->set_paper($custompaper, 'potrait');
	// }
	// $dompdf->render();
	// $dompdf->stream('laporan_'.$nama.'.pdf', array('Attachment' => false));	
	// //$dompdf->stream('laporan_'.$nama.'.pdf'); &&langsung download
?>