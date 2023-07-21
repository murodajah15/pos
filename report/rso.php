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
			<h3>Laporan Sales Order</h3>
			<hr size="10px">
			<!-- <form method='post' target='_blank' action='report/rso_pdf.php'> checked ="checked" -->
			<form method='post' target='_blank' action='report/rso_xls.php'> <!--checked ="checked"-->
				<div class="row">
					<div class="col-md-12 bg">
					<input type='checkbox' class='form-control' name='check2' value='outstanding'> Outstanding
					</div>
					<div class="col-md-12 bg">
						<input type='checkbox' class='form-control' name='check1' id='checkall_periode' value='semuaperiode'> Semua Periode (M-D-Y)
						<input type="date" class='form-group' name='tanggal1' value="<?= $tanggal ?>">
						<input type="date" class='form-group' name='tanggal2' value="<?= $tanggal ?>">
					<!--</div>-->
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 bg">
						<br><button type='submit' class='btn btn-primary'>Cetak</button>
					</div>
				</div>
			</div>
			</form>
		</font>
	<?php
	}else{
		echo "<font color='red'>Anda tidak punya hak !</font>";
	}
?>

