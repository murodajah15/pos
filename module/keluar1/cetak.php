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

	$queryh = mysqli_query($connect,"select * from keluarh where id='$id' and keluarh.proses='Y' order by nokeluar");
	$de = mysqli_fetch_assoc($queryh);
	$nokeluar = $de['nokeluar'];
	$tanggal = tgl_indo($de['tglkeluar']); // $de['tglkeluar'];
	$biaya_lain = number_format($de['biaya_lain'],0,",",".");
	$total = $de['total'];

	include "../../logo.php";
	$html .= '<style>
			td { border: 0.5px solid grey; margin: 5px; height: 20px;}
	        th { border: 0.5px solid grey; font-weight:normal; height: 30px;}
	        body { font-family: comic sans ms;}
		</style>';
	$html .='<center>NOTA PENGELUARAN BARANG</center>
		<hr style="width:99%;height:-1px;text-align:left;margin-left:0">
		<table border="0" height="5">
			<tr><td width="30" style="font-size:12px;">NO.</td><td width="280" style="font-size:13px";>: '."$nokeluar".'</td>
			<tr><td width="30" style="font-size:12px;">Tanggal </td></td><td width="280" style="font-size:13px";>: '."$tanggal".'</td>
			<hr size=2></font>
		</table>
		<table table-layout="fixed"; cellpadding="0"; cellspacing="0"; style=font-size:11px; class="table table-striped table table-bordered;">
			<tr>
				<th width="30px" height="20"><font size="1" color="black">NO.</th>
				<th width="100px"><font size="1" color="black">KD. BARANG</th>
				<th width="230px"><font size="1" color="black">NAMA BARANG</th>
				<th width="60px"><font size="1" color="black">SATUAN</th>
				<th width="50px"><font size="1" color="black">QTY</th>
				<th width="60px"><font size="1" color="black">HARGA</th>
					<th width="80px"><font size="1" color="black">SUBTOTAL</th>
			</tr>';

	$queryd = mysqli_query($connect,"select keluarh.nokeluar,keluarh.tglkeluar,keluard.kdbarang,keluard.nmbarang,keluard.kdsatuan,keluard.qty,keluard.harga,keluard.subtotal,tbsatuan.nama as nmsatuan from keluarh inner join keluard on keluarh.nokeluar=keluard.nokeluar left join tbsatuan on tbsatuan.kode=keluard.kdsatuan where keluarh.nokeluar='$nokeluar' and keluarh.proses='Y' order by nokeluar");
	$nsubtotal = 0;
	while ($row = mysqli_fetch_assoc($queryd)){
		$harga = number_format($row['harga'],0,",",".");
		$subtotal = number_format($row['subtotal'],0,",",".");
		$html .= '<tr><td width="30px" align="center">'.$no.'</td>
					<td width="30px" align="left">'."&nbsp;".$row["kdbarang"].'</td>
					<td width="50px" align="left">'."&nbsp;".$row["nmbarang"].'</td>
					<td width="70px" align="center">'.$row["nmsatuan"].'</td>
					<td width="50px" align="right">'.$row["qty"]."&nbsp;".'</td>
					<td width="70px" align="right">'.$harga."&nbsp;".'</td>
						<td width="70px" align="right">'.$subtotal."&nbsp;".'</td>
				</tr>';
		 $no++;
		 $nsubtotal = $nsubtotal + $row['subtotal'];
	}
	$subtotal = number_format($nsubtotal,0,",",".");
	$ntotal = number_format($total,0,",",".");
	$html .= '<tr>
				<td colspan="6" style="color:black" align="left">&nbsp;Subtotal ... </td><td align="right">&nbsp;'.$subtotal.'&nbsp;</td></tr>
				<tr><td colspan="6" style="color:black" align="left">&nbsp;Biaya Lain ... </td><td align="right">&nbsp;'.$biaya_lain.'&nbsp;</td></tr>
				<tr><td colspan="6" style="color:black" align="left">&nbsp;Total ... </td><td align="right">&nbsp;'.$ntotal.'&nbsp;</td></tr>
				</table>';
	//$html .= '<font size="1"><p><left>Tanggal cetak : '.date('d-m-Y H:i:s a').'</p></font>';
	$terbilang = ucwords(terbilang($total));
	$html .= '<font size="1" align="right" width="300"><p>Tanggal cetak : '.date('d-m-Y H:i:s a').'</p></font>';
	$terbilang = ucwords(terbilang($total));
	$html .= '<font size="1">Jakarta,  '.tgl_indo(date('Y-m-d')).',';

	$html .= '<table border="0">
			<tr>
			<th></th>
			<tr><td></td>
			<tr><td><font size="1" color="black" align="center">(Kabag. Pembelian)</td></tr>';

	
	$dompdf = new DOMPDF();
	$dompdf->load_html($html);
	$dompdf->set_paper('A4', 'potrait');
	$dompdf->render();
	$dompdf->stream('laporan_'.$nama.'.pdf', array('Attachment' => false));	
	//$dompdf->stream('laporan_'.$nama.'.pdf'); &&langsung download


?>