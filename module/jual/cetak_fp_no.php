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
	$finance_mgr = $_SESSION['finance_mgr'];
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
	$nosrtjln = $de['nosrtjln'];
	$tglsrtjln = $de['tglsrtjln'];

	$customer = $de['kdcustomer'].'-'.$de['nmcustomer'];
	$queryh = mysqli_query($connect,"select * from tbcustomer where kode='$kdcustomer'");
	$de = mysqli_fetch_assoc($queryh);
	$alamatcust = $de['alamat'].' '.$de['kota'].' '.$de['kodepos'];
	$telpcust = $de['telp1'].' - '.$de['telp2'];
	$npwp = $de['npwp'];
	// $rec = mysqli_num_rows($query);
	// echo 'aaaaa'.$de['nojual'].$de['harga'];
	//<img src="../../img/logo.png" width="50">


	$html = '<style>
			td { border: 0.5px solid grey; margin: 5px; height: 20px;}
	        th { border: 0.5px solid grey; font-weight:normal; height: 30px;}
	        body { font-family: comic sans ms;}
		</style>		

		<font size="4" face="comic sans ms">
		<div class="panel-body">
		<div class="col-md-6">
			'."$nm_perusahaan".'
			<font size="2"><br>'."$alamat_perusahaan".'
			<br>'."$telp_perusahaan".'
			<hr size="1"></font>
		</div></div>
		<table table-layout="fixed"; cellpadding="0"; cellspacing="0"; style=font-size:11px; class="table table-striped table table-bordered;">
			<tr>
			<th width="200px" height="20" align="left"><font size="1" color="black">&nbsp;<u>Syarat Pembayaran</u><br>&nbsp;<i>Term of Payment</i><br><br><br><br><br><br><br></th>
			<th width="150px" height="20" colspan="2"><font size="3" color="black">&nbsp;<b>FAKTUR<br>PENJUALAN</b></th>
			<th width="350px" height="20" align="left" valign="top" rowspan="3"><font size="2" color="black">&nbsp;Kepada / To :<br>&nbsp;<b>'."$nmcustomer".'</b><br>&nbsp;'."$alamatcust".'<br>&nbsp;'."$telpcust".'</th>
			<tr><th width="100px" height="10"><font size="2" color="black">&nbsp;<b>NPWP</b></th>
			<th width="50px" height="10"><font size="2" color="black"><b>PKP</b></th>
			<th width="70px" height="10"><font size="2" color="black"><b>NON PKP</b></th>
			<tr><td align="center">'.$npwp.'</td><td></td><td></td>
			<tr><td colspan="2">&nbsp;Delivery No : '.$nosrtjln.', Date : '.$tglsrtjln.'</td><td colspan="2">&nbsp;Faktur Penjualan No : '.$nojual.', Date : '.$tanggal.'</td>
			<tr><td colspan="2">&nbsp;We Debited Your for :</td><td colspan="2">&nbsp;<i>Sales Invoice</i></td>
			</tr>
		</table>
		<table table-layout="fixed"; cellpadding="0"; cellspacing="0"; style=font-size:11px; class="table table-striped table table-bordered;">
			<tr>
				<th width="50px" height="20"><font size="1" color="black">No.<br>Urut</th>
				<th width="329px"><font size="1" color="black">Nama Barang</th>
				<th width="90px"><font size="1" color="black">Banyaknya</th>
				<th width="110px"><font size="1" color="black">Harga Satuan</th>
				<th width="120px"><font size="1" color="black">Jumlah Uang</th>
			</tr>';

	$queryd = mysqli_query($connect,"select jualh.nojual,jualh.tgljual,jualh.kdcustomer,jualh.nmcustomer,jualh.ppn,jualh.materai,juald.kdbarang,juald.nmbarang,juald.kdsatuan,juald.qty,juald.harga,juald.discount,juald.subtotal,tbsatuan.nama as nmsatuan from jualh inner join juald on jualh.nojual=juald.nojual left join tbsatuan on tbsatuan.kode=juald.kdsatuan where jualh.nojual='$nojual' and jualh.proses='Y' order by nojual");
	$nsubtotal = 0;
	$ndiscount = 0;
	$nhargajual =0;
	while ($row = mysqli_fetch_assoc($queryd)){
		$harga = number_format($row['harga'],0,",",".");
		$subtotal = number_format($row['subtotal'],0,",",".");
		$html .= '<tr><td width="30px" align="center">'.$no.'</td>
					<td lign="left">'."&nbsp;".$row["nmbarang"].'</td>
					<td align="right">'.$row["qty"]."&nbsp;".$row["nmsatuan"]."&nbsp;".'</td>
					<td align="right">'.$harga."&nbsp;".'</td>
					<td align="right">'.$subtotal."&nbsp;".'</td>
				</tr>';
		 $no++;
		 $ndiscount = $ndiscount + ($row['qty']*$row['harga']) * ($row['discount']/100);
		 $nsubtotal = $nsubtotal + $row['subtotal'];
		 $nhargajual = $nhargajual + $row['qty']*$row['harga'];
		 $nmaterai = $row['materai'];
		 $ppn = $row['ppn'];

	}
	$hargajual = number_format($nhargajual,0,",","."); 
	$subtotal = number_format($nhargajual-$ndiscount,0,",",".");
	$discount = number_format($ndiscount,0,",",".");
	$materai =  number_format($nmaterai,0,",",".");
	$nppn = ($nhargajual-$ndiscount) * ($ppn/100);
	$ppn = number_format($nppn,0,",",".");
	$ntotal = number_format($nsubtotal+$nppn+$nmaterai,0,",",".");
	$html .= '<tr>
				<td colspan="4" style="color:black" align="left">&nbsp;Jumlah Harga Jual / Sales Value </td><td align="right">&nbsp;'.$subtotal.'&nbsp;</td></tr>
				<tr><td colspan="4" style="color:black" align="left">&nbsp;Potongan / Discount </td><td align="right">&nbsp;'.$discount.'&nbsp;</td></tr>
				<tr><td colspan="3" rowspan="4" style="color:black" align="left">&nbsp;Catatan / Note : <br>&nbsp;1. Asli Invoice merangkap sebagai kuitansi Original<br>&nbsp;2. Pembayaran dengan cek giro dan lain-lain yang bukan uang tunai, baru dianggap lunas<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;bila sudah diuangkan<br></td>
				</td><td>&nbsp;Dasar Pengenaan PPN</td></td><td align="right">&nbsp;'.$subtotal.'&nbsp;</td>
				<tr></td><td>&nbsp;PPN 10 %</td></td><td align="right">&nbsp;'.$ppn.'&nbsp;</td>
				<tr></td><td>&nbsp;Materai</td></td><td align="right">&nbsp;'.$materai.'&nbsp;</td>
				<tr></td><td>&nbsp;Total Tagihan</td></td><td align="right">&nbsp;'.$ntotal.'&nbsp;</td>
				</tr>
				</table>';
	//$html .= '<font size="1"><p><left>Tanggal cetak : '.date('d-m-Y H:i:s a').'</p></font>';
	//$terbilang = ucwords(terbilang($total));
	//$html .= '<font size="1">Terbilang : # '.$terbilang.' Rupiah #'.'<br>. </font>';

	$html .= '<br><table table-layout="fixed"; cellpadding="0"; cellspacing="0"; style=font-size:11px; class="table table-striped table table-bordered;">
			<tr>
				<th width="150px"><font size="1" color="black" align="center">Prepared</th>
				<th width="150px"><font size="1" color="black" align="center">Checked</th>
				<th width="150px"><font size="1" color="black" align="center">Entered</th>
				<th width="250px" rowspan=1" valign="top">Jakarta, 01 Januari 2019<br>AUTHORIZED SIGNATURE</th>
				<tr><td height="70"></td><td></td><td></td><td valign="bottom" align="center">'.$finance_mgr.'</td>
				<tr><td align="center">Admin/Sales</td>
				<td align="center"></td><td></td><td align="center">FINANCE MANAGER</td>
			</tr>
			</table>';

	$dompdf = new DOMPDF();
	$dompdf->load_html($html);
	$dompdf->set_paper('A4', 'potrait');
	$dompdf->render();
	$dompdf->stream('laporan_'.$nama.'.pdf', array('Attachment' => false));	
	//$dompdf->stream('laporan_'.$nama.'.pdf'); &&langsung download


?>