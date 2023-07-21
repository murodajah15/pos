<?php
include 'cek_akses.php';
$user = $_SESSION['username'];
require_once 'dompdf/dompdf_config.inc.php';
?>
<?php
if ($aksesok == 'Y') {
	$tanggal = date('Y-m-d');
	$tgl = getdate();
	$tahun = $tgl['year']; ?>
	<font face="calibri">
		<h3>Laporan Faktur Harian</h3>
		<hr size="10px">
		<!-- <form method='post' target='_blank' action='report/rfaktur_pdf.php'> -->
		<form method='post' target='_blank' action='report/rfaktur_xls.php'>
			<!--<input type='checkbox' class='form-control' name='check2' value='outstanding'> Outstanding-->
			<!--<br><input type='checkbox' class='form-control' name='check1' value='semuaperiode' checked ="checked"> Semua Periode (M-D-Y)
				<!--<div class="form-group">-->
			Tanggal (M-D-Y) : <input type="date" class='form-group' name='tanggal1' value="<?= $tanggal ?>">
			s/d
			<input type="date" class='form-group' name='tanggal2' value="<?= $tanggal ?>">
			<!--</div>-->
			<br><button type='submit' class='btn btn-primary'>Cetak</button>
		</form>
	</font>
<?php
} else {
	echo "<font color='red'>Anda tidak punya hak !</font>";
}
?>