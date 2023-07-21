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

	$queryh = mysqli_query($connect,"select * from belih where id='$id' and belih.proses='Y' order by nobeli");
	$de = mysqli_fetch_assoc($queryh);
	$nobeli = $de['nobeli'];
	$tanggal = tgl_indo($de['tglbeli']); // $de['tglbeli'];
	$kdsupplier = $de['kdsupplier'];
	$nmsupplier = $de['nmsupplier'];
	$biaya_lain = number_format($de['biaya_lain'],0,",",".");
	$ppn = $de['ppn'];
	$total = $de['total'];
	$supplier = $de['kdsupplier'].'-'.$de['nmsupplier'];
	$queryh = mysqli_query($connect,"select * from tbsupplier where kode='$kdsupplier'");
	$de = mysqli_fetch_assoc($queryh);
	$alamatcust = $de['alamat'].' '.$de['kota'].' '.$de['kodepos'];
	$telpcust = $de['telp1'].' - '.$de['telp2'];

	// $rec = mysqli_num_rows($query);
	// echo 'aaaaa'.$de['nobeli'].$de['harga'];

	// include "../../logo.php";


		// <font size="4" face="comic sans ms">
		// <div class="panel-body">
		// <div class="col-md-6">';
	// $logo = $_SESSION['logo'];
	// if ($logo<>"") {
	// 	//$html .= '<img src="../../img/'."$logo".'" width="50">';
	// 	$html = '<table border="0"><tr><td rowspan="4"><img src="../../img/'."$logo";
	// }
	// $html .= ''."$nm_perusahaan".'
	// 		<font size="2"><br>'."$alamat_perusahaan".'
	// 		<br>'."$telp_perusahaan".'
	// 		<hr size="1"></font>
	// 	</div></div>';
	// $html .= '" width="50"></td><td>'.$nm_perusahaan.'<br><font size="1">'.$alamat_perusahaan.'<br>'.$telp_perusahaan.'</font></td></tr></table>';	

	include "../../logo.php";

	// $html .= '<style>
	// 		td { border: 0.5px solid grey; margin: 5px; height: 20px;}
	//         th { border: 0.5px solid grey; font-weight:normal; height: 30px;}
	//         body { font-family: comic sans ms;}
	// 	</style>';
	$html .= '<p style="margin-top:5px; margin-bottom:5px" align="center"><u>NOTA PENERIMAAN PEMBELIAN</u></p>
		<hr style="width:99%;text-align:left;margin-left:0">';
	$html .= '<table border="0" height="5">
			<tr><td width="30" style="font-size:12px;">NO.</td><td width="280" style="font-size:13px";>: '."$nobeli".'</td>
			<td width="180" style="font-size:12px";>'."$nmsupplier".'</td>
			<tr><td width="30" style="font-size:12px;">Tanggal </td></td><td width="280" style="font-size:13px";>: '."$tanggal".'</td>
			</td><td width="180" style="font-size:10px";>'."$alamatcust".'</td>
			<tr><td></td><td style="font-size:12px;"></td></td><td style="font-size:11px";>'."$telpcust".'</td></tr>
			<hr size=2></font>
		</table>
		<table table border="0.50" table-layout="fixed"; cellpadding="1"; cellspacing="0"; style=font-size:11px; class="table table-striped table table-bordered;">
			<tr>
				<th width="30px" align="left" height="20"><font size="3" color="black">NO.</th>
				<th width="100px" align="left"><font size="3" color="black">KD. BARANG</th>
				<th width="320px" align="left"><font size="3" color="black">NAMA BARANG</th>
				<th width="40px" align="left"><font size="3" color="black">SATUAN</th>
				<th width="50px" align="right"><font size="3" color="black">QTY'."&nbsp;".'</th>
				<th width="70px" align="right"><font size="3" color="black">HARGA'."&nbsp;".'</th>
				<th width="40px" align="right"><font size="3" color="black">DISC.'."&nbsp;".'</th>
				<th width="80px" align="right"><font size="3" color="black">SUBTOTAL'."&nbsp;".'</th>
			</tr>';

	$queryd = mysqli_query($connect,"select belih.nobeli,belih.tglbeli,belih.kdsupplier,belih.nmsupplier,belid.kdbarang,belid.nmbarang,belid.kdsatuan,belid.qty,belid.harga,belid.discount,belid.subtotal,tbsatuan.nama as nmsatuan from belih inner join belid on belih.nobeli=belid.nobeli left join tbsatuan on tbsatuan.kode=belid.kdsatuan where belih.nobeli='$nobeli' and belih.proses='Y' order by nobeli");
	$nsubtotal = 0;
	while ($row = mysqli_fetch_assoc($queryd)){
		$harga = number_format($row['harga'],0,",",".");
		$subtotal = number_format($row['subtotal'],0,",",".");
		$html .= '<tr><td width="30px" align="center">'.$no.'</td>
					<td width="100px" align="left">'.$row["kdbarang"].'</td>
					<td width="320px" align="left"><font size="2">'.$row["nmbarang"].'</font></td>
					<td width="40px" align="left">'.$row["nmsatuan"].'</td>
					<td width="50px" align="right">'.$row["qty"]."&nbsp;".'</td>
					<td width="60px" align="right">'.$harga."&nbsp;".'</td>
					<td width="40px" align="right">'.$row["discount"]."&nbsp;".'</td>
					<td width="80px" align="right">'.$subtotal."&nbsp;".'</td>
				</tr>';
		 $no++;
		 $nsubtotal = $nsubtotal + $row['subtotal'];
	}
	$subtotal = number_format($nsubtotal,0,",",".");
	$ntotal = number_format($total,0,",",".");
	$html .= '<tr><tr>
				<td colspan="7" style="color:black" align="right">&nbsp;Subtotal&nbsp;  </td><td align="right">&nbsp;'.$subtotal.'&nbsp;</td></tr>
				<tr><td colspan="7" style="color:black" align="right">&nbsp;Biaya Lain&nbsp;  </td><td align="right">&nbsp;'.$biaya_lain.'&nbsp;</td></tr>
				<tr><td colspan="7" style="color:black" align="right">&nbsp;PPn (%)&nbsp;  </td><td align="right">&nbsp;'.$ppn.'&nbsp;</td></tr>
				<tr><td colspan="7" style="color:black" align="right">&nbsp;Total&nbsp;  </td><td align="right">&nbsp;<b>'.$ntotal.'&nbsp;</b></td></tr>
				</table>';
	//$html .= '<font size="1"><p><left>Tanggal cetak : '.date('d-m-Y H:i:s a').'</p></font>';
	$terbilang = ucwords(terbilang($total));
	$terbilang = ucwords(terbilang($total));
	$html .= '<font size="1">Jakarta,  '.tgl_indo(date('Y-m-d')).',';

	$html .= '<table border="0">
			<tr>
			<th></th>
			<tr><td></td>
			<tr><td><font size="1" color="black" align="center">(Kabag. Pembelian)</td></tr>';
	$html .= '<font size="1" align="right" width="300">Tanggal cetak : '.date('d-m-Y H:i:s a').'</font><br>';

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
		
	$mpdf = new \Mpdf\Mpdf(['format' => 'Letter-P',
	'margin_left' => 10,
	'margin_right' => 10,
	'margin_top' => 5,
	'margin_bottom' => 5,
	'margin_header' => 5,
	'margin_footer' => 5,]);
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
		  
	
	// $dompdf = new DOMPDF();
	// $dompdf->load_html($html);
	// $dompdf->set_paper('A4', 'potrait');
	// $dompdf->render();
	// $dompdf->stream('laporan_'.$nama.'.pdf', array('Attachment' => false));	
	//$dompdf->stream('laporan_'.$nama.'.pdf'); &&langsung download
