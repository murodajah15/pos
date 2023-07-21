<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
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

	$queryh = mysqli_query($connect, "select * from jualh where id='$id' and jualh.proses='Y' order by nojual");
	$rec = mysqli_num_rows($queryh);
	if ($rec == 0) {
	?>
		<script>
			swal({
				title: "Gagal Cetak (data belum diproses) ",
				text: "",
				icon: "error"
			}).then(function() {
				open(location, '_self').close();
				// window.location.href = '../../dashboard.php?m=jual';
			});
		</script>
	<?php
		exit();
	}
	$de = mysqli_fetch_assoc($queryh);
	$nojual = $de['nojual'];
	$tanggal = tgl_indo($de['tgljual']); // $de['tgljual'];
	$kdcustomer = $de['kdcustomer'];
	$nmcustomer = $de['nmcustomer'];
	$biaya_lain = $de['biaya_lain'];
	$ppn = $de['ppn'];
	$total = $de['total'];
	$customer = $de['kdcustomer'] . '-' . $de['nmcustomer'];
	$queryh = mysqli_query($connect, "select * from tbcustomer where kode='$kdcustomer'");
	$de = mysqli_fetch_assoc($queryh);
	$alamatcust = $de['alamat'];
	$kotacust = '.'; //$de['kota'].' '.$de['kodepos'].'.';
	$telpcust = $de['telp1'] . ' - ' . $de['telp2'];

	$queryd = mysqli_query($connect, "select jualh.nojual,jualh.tgljual,jualh.kdcustomer,jualh.nmcustomer,juald.kdbarang,juald.nmbarang,juald.kdsatuan,juald.qty,juald.harga,juald.discount,juald.subtotal,tbsatuan.nama as nmsatuan from jualh inner join juald on jualh.nojual=juald.nojual left join tbsatuan on tbsatuan.kode=juald.kdsatuan where jualh.nojual='$nojual' and jualh.proses='Y' order by nojual");
	$jumrecord = mysqli_num_rows($queryd);
	if ($jumrecord > 12) {
		echo '<script>alert("Melebihi maksimum row (12) !")</script>';
		echo  "<script type='text/javascript'>";
		echo "window.close();";
		echo "</script>";
		exit();
	}
	// $rec = mysqli_num_rows($query);
	// echo 'aaaaa'.$de['nojual'].$de['harga'];

	//echo '<center><p><u>FAKTUR PENJUALAN</u></p></center>';
	// $html = '<style>
	// 		td { border: 0px solid grey; margin: 5px; height: 20px;}
	//         th { border: 0px solid grey; font-weight:normal; height: 30px;}
	//         body { font-family: comic sans ms;}
	// 	</style>		

	//include "../../logo.php";
	// $html .= '<p align="center"><u>FAKTUR PENJUALAN</u></p>
	$html .= '<br><br><br><table border="0">
			<tr><td width="245" style="font-size:14px;"></td><td width="250" style="font-size:12px";>' . "$nmcustomer" . '</td>
      <td width="50"></td><td width="200" style="font-size:12px";>NO. ' . "$nojual" . '</td>
			<tr><td width="10" style="font-size:12px;"></td></td><td width="250" style="font-size:10px";>' . "$alamatcust" . '</td>
			<td width="50"><td width="200" style="font-size:13px";>' . "$tanggal" . '</td>
			<tr><td width="245" style="font-size:10px;"></td><td width="250" style="font-size:10px";>' . "$kotacust" . '</td></tr>
      <tr><td width="245" style="font-size:10px;"></td><td width="250" style="font-size:10px";>Telp.' . "$telpcust" . '</td></tr>
      <tr><td></td></tr></table>';

	$html .= '<br><table border="0" table-layout="fixed"; cellpadding="0"; cellspacing="0"; style=font-size:17px; class="table table-striped table table-bordered;">
			<tr>
			<td width="10px"><font size="2"></td>
			<td width="40px"><font size="2"></td>
			<td width="95px" align="center"><font size="2"></td>
			<td width="360px" align="center"><font size="2"></td>
			<td width="50px" align="center"><font size="2"></td>
			<td width="50px" align="center"><font size="2"></td>
			<td width="65px" align="center"><font size="2"></td>
			<td width="42px" align="center"><font size="2"></td>
			<td width="66px" align="center"><font size="2"></td>
			</tr></table>';

	$queryd = mysqli_query($connect, "select jualh.nojual,jualh.tgljual,jualh.kdcustomer,jualh.nmcustomer,juald.kdbarang,juald.nmbarang,juald.kdsatuan,juald.qty,juald.harga,juald.discount,juald.subtotal,tbsatuan.nama as nmsatuan from jualh inner join juald on jualh.nojual=juald.nojual left join tbsatuan on tbsatuan.kode=juald.kdsatuan where jualh.nojual='$nojual' and jualh.proses='Y' order by nojual");
	$nsubtotal = 0;
	$jumrecord = mysqli_num_rows($queryd);
	$html .= '<br><br><table border="0.5" table-layout="fixed"; cellpadding="0"; cellspacing="0"; style=font-size:17px; class="table table-striped table table-bordered;">';
	while ($row = mysqli_fetch_assoc($queryd)) {
		$harga = number_format($row['harga'], 0, ",", ".");
		$subtotal = number_format($row['subtotal'], 0, ",", ".");
		$qty = number_format($row['qty'], 0, ",", ".");
		$html .= '<tr>
					<td width="20px"><font size="2"></td>
					<td width="40px" align="right" height="10"><font size="2">' . $no . '&nbsp;</td>
					<td width="5px"><font size="2" align="left" height="10">' . "&nbsp;" . "" . '</td>
					<td width="310x" style="font-size:11px"; align="left" height="20">' . "&nbsp;" . $row["nmbarang"] . '</td>
					<td width="30px" align="center" height="10"><font size="2">' . $row["nmsatuan"] . '</td>
					<td width="64px" align="right" height="10"><font size="2">' . $qty . "&nbsp;" . '</td>
					<td width="93px" align="right" height="10"><font size="2">' . $harga . "&nbsp;" . '</td>
					<td width="45px" align="right" height="10"><font size="2">' . $row["discount"] . "&nbsp;" . '</td>
					<td width="135px" align="right" height="10"><font size="2">' . $subtotal . "&nbsp;" . '</td>
				</tr>';
		$no++;
		$nsubtotal = $nsubtotal + $row['subtotal'];
	}
	$html .= '</table>';

	$subtotal = number_format($nsubtotal, 0, ",", ".");
	$ppn = $nsubtotal * ($ppn / 100);
	$ppn = number_format($ppn, 0, ",", ".");
	$ntotal = number_format($total, 0, ",", ".");
	while ($no <= 12) {
		$html .= '<br>';
		$no++;
	}
	$html .= '<div style="line-height:170%;"><br></div>';
	$html .= '<table border="0" table-layout="fixed"; cellpadding="0"; cellspacing="0"; style=font-size:17px; class="table table-striped table table-bordered;">
  <tr>
  <td width="40px" height="0"><font size="1"></td>
  <td width="5px" align="center" height="0"><font size="1"></td>
  <td width="310px" align="center" height="0"><font size="1"></td>
  <td width="30px" align="center" height="0"><font size="1"></td>
  <td width="63px" align="center" height="0"><font size="1"></td>
  <td width="94px" align="center" height="0"><font size="1"></td>
  <td width="40px" align="center" height="0"><font size="1"></td>
  <td width="120px" align="center"><font size="1"></td></tr>';
	$html .= '<tr><td colspan="7"></td><td width="160" align="right"><font size="2">' . $subtotal . '&nbsp;</td></tr>
            <tr><td colspan="7"></td><td width="120" align="right"><font size="1"><div style="line-height:50%;"><br></div>' . "<br>" . '</td></tr>
            <tr><td colspan="7"></td><td width="160" align="right"><font size="2">' . $ppn . '&nbsp;</td></tr>
            <tr><td colspan="7"></td><td width="120" align="right"><font size="1"><div style="line-height:50%;"><br></div>' . "<br>" . '</td></tr>
            <tr><td colspan="7"></td><td width="160" align="right"><font size="2">' . $ntotal . '&nbsp;</td></tr>';
	$html .= '</table>';

	$filename = "FP_" . $nojual . ".pdf";
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

		if ($jumrecord > 10) {
			$mpdf = new \Mpdf\Mpdf([
				'format' => 'Letter-P',
				'margin_left' => 5,
				'margin_right' => 5,
				'margin_top' => 5,
				'margin_bottom' => 5,
				'margin_header' => 5,
				'margin_footer' => 5,
			]);
		} else {
			//$mpdf = new \Mpdf\Mpdf(['format' => [190, 126],
			// $mpdf = new \Mpdf\Mpdf(['format' => [205, 126],
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
		}
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
	?>
</body>