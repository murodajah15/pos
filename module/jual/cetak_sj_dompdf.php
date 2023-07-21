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


	$html = '<style>
			td { border: 1px solid grey; margin: 5px; height: 20px;}
	        th { border: 1px solid grey; font-weight:normal; height: 30px;}
	        body { font-family: comic sans ms;}
		</style>		

		<font size="4" face="comic sans ms">
		<div class="panel-body">
		<div class="col-md-6">';
	$logo = $_SESSION['logo'];
	if ($logo<>"") {
		$html .= '<img src="../../img/'."$logo".'" width="50">';
	}
	$html .= ''."<b>$nm_perusahaan".'
			<font size="1"><br>'."$alamat_perusahaan".'
			<br>'."$telp_perusahaan".'</font>
		</div>
		<center><u>SURAT JALAN</u></center>
		<br style="line-height:2px">
		<table cellpadding="0"; cellspacing="0"; border="0"; style=font-size:12px; height="5";>
			<tr><td width="30" height="5" style="font-size:12px;">NO.</td><td width="280" height="5" style="font-size:13px";>: '."$nojual".'</td>
			<td width="180" height="5" style="font-size:12px";>'."<b>$nmcustomer".'</td>
			<tr><td width="30" height="5" style="font-size:12px;">Tanggal </td></td><td width="280" height="5" style="font-size:13px";>: '."$tanggal".'</td>
			</td><td width="180" height="5" style="font-size:11px";>'."$alamatcust".'</td>
			<tr><td height="10" colspan="2"></td><td height="10" style="font-size:12px";>'."$telpcust".'</td></tr>
			<tr>
			</font>
		</table>
		<br style="line-height:5px">
		<table table-layout="fixed"; cellpadding="0"; cellspacing="0"; style=font-size:12px; class="table table-striped table table-bordered;">
			<tr>
				<th width="30px" height="20"><color="black">NO.</th>
				<th width="100px"><color="black">KD. BARANG</th>
				<th width="480px"><color="black">NAMA BARANG</th>
				<th width="55px"><color="black">SATUAN</th>
				<th width="55px"><color="black">QTY</th>
			</tr>';

	$queryd = mysqli_query($connect,"select jualh.nojual,jualh.tgljual,jualh.kdcustomer,jualh.nmcustomer,juald.kdbarang,juald.nmbarang,juald.kdsatuan,juald.qty,juald.harga,juald.discount,juald.subtotal,tbsatuan.nama as nmsatuan from jualh inner join juald on jualh.nojual=juald.nojual left join tbsatuan on tbsatuan.kode=juald.kdsatuan where jualh.nojual='$nojual' and jualh.proses='Y' order by nojual");
	$nsubtotal = 0;
	$jumrecord = mysqli_num_rows($queryd);
	while ($row = mysqli_fetch_assoc($queryd)){
		$harga = number_format($row['harga'],0,",",".");
		$subtotal = number_format($row['subtotal'],0,",",".");
		$html .= '<tr><td width="30px" align="center">'.$no.'</td>
					<td align="left">'."&nbsp;".$row["kdbarang"].'</td>
					<td align="left">'."&nbsp;".$row["nmbarang"].'</td>
					<td align="center">'.$row["nmsatuan"].'</td>
					<td align="right">'.$row["qty"]."&nbsp;".'</td>
				</tr>';
		 $no++;
		 $nsubtotal = $nsubtotal + $row['subtotal'];
	}
	$subtotal = number_format($nsubtotal,0,",",".");
	$ntotal = number_format($total,0,",",".");
	// $html .= '<tr>
	// 			<td colspan="7" style="color:black" align="left">&nbsp;Subtotal ... </td><td align="right">&nbsp;'.$subtotal.'&nbsp;</td></tr>
	// 			<tr><td colspan="7" style="color:black" align="left">&nbsp;Biaya Lain ... </td><td align="right">&nbsp;'.$biaya_lain.'&nbsp;</td></tr>
	// 			<tr><td colspan="7" style="color:black" align="left">&nbsp;Total ... </td><td align="right">&nbsp;'.$ntotal.'&nbsp;</td></tr>
	// 			</table>';
	//$html .= '<font size="1"><p><left>Tanggal cetak : '.date('d-m-Y H:i:s a').'</p></font>';
	//$terbilang = ucwords(terbilang($total));
	//$html .= '<font size="1">Terbilang : # '.$terbilang.' Rupiah #'.'<br>. </font>';

	$html .= '<table table-layout="fixed"; cellpadding="0"; cellspacing="0"; style=font-size:12px; class="table table-striped table table-bordered;">
			<tr>
				<th width="150px"><color="black" align="center">Penerima.</th>
				<th width="140px"><color="black" align="center">Hormat Kami</th>
				<th width="210px"><color="black" align="center">Barang-barang tsb diatas telah diterima/diperiksa dengan baik dan ukuran cukup</th>
				<th width="130px"><color="black" align="center">Pengirim</th>				
			</tr><tr>
			<td></td><td colspan="1"></td><td align="center"><br>KAMI HANYA MELAYANI<br>KOMPLAIN/PENUKARAN BARANG<br>DALAM WAKTU 7 (TUJUH HARI),<br>SETELAH BARANG DITERIMA</td><td></td>
			<tr><td align="center">Nama Terang & Cap Perusahaan</td><td align="center">'.$nm_perusahaan.'</td><td></td><td></td></tr>';

	
	$dompdf = new DOMPDF();
	$dompdf->load_html($html);
	if ($jumrecord > 8) {
		$dompdf->set_paper('Letter', 'potrait');
	}else{
		$dompdf->set_paper('Letter', 'potrait');
		//$custompaper = array(0,-10,550,550); //(left,top,width,height)
		//$dompdf->set_paper($custompaper, 'Potrait');
	}
	$dompdf->render();
	$dompdf->stream('laporan_'.$nama.'.pdf', array('Attachment' => false));	
	// $dompdf->stream('laporan_'.$nama.'.pdf'); &&langsung download

?>