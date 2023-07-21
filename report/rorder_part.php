<?php
	include 'cek_akses.php';
	$user = $_SESSION['username'];
	require_once 'dompdf/dompdf_config.inc.php';
?>
<?php
	if ($aksesok == 'Y') {
		$tanggal = date('Y-m-d');
		$tgl = getdate();
		$tahun = $tgl['year'];?>
		<font face="calibri">
			<h3>Laporan Order Part</h3>
			<hr size="10px">
			<form method='post' target='_blank' action='report/rorder_part_pdf.php'>
				<input type='checkbox' class='form-control' name='check2' value='outstanding'> Outstanding
				<br><input type='checkbox' class='form-control' name='check1' value='semuaperiode' checked ="checked"> Semua Periode
				<!--<div class="form-group">-->
					<input type="date" class='form-group' size='50' name='tanggal1' value="<?= $tanggal ?>">
					s/d
					<input type="date" class='form-group' size='50' name='tanggal2' value="<?= $tanggal ?>">
				<!--</div>-->
				<br><button type='submit' class='btn btn-primary'>Cetak</button>
			</form>
		</font>
	<?php
	}else{
		echo "<font color='red'>Anda tidak punya hak !</font>";
	}
?>

