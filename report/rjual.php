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
		<h3>Laporan Penjualan</h3>
		<hr size="10px">
		<form method='post' target='_blank' action='report/rjual_xls.php'>
			<!-- <form method='post' target='_blank' action='report/rjual_pdf.php'> -->
			<input type='checkbox' class='form-control' name='check2' value='outstanding'> Outstanding
			<br><input type='checkbox' class='form-control' name='check1' id='checkall_periode' value='semuaperiode'> Semua Periode (M-D-Y)
			<!--<div class="form-group">-->
			<input type="date" class='form-group' name='tanggal1' value="<?= $tanggal ?>">
			<input type="date" class='form-group' name='tanggal2' value="<?= $tanggal ?>">
			<br><input type='checkbox' class='form-control' name='rincian' value='rincian' checked='checked'> Dengan Rincian
			<br><input type='checkbox' class='form-control' name='semuacustomer' id='checkall_customer' value='semuacutomer'> Semua Customer <!--checked ='checked'> Semua Customer-->
			<!--<input type='checkbox' class='form-control' name='semuacustomer' value='semuacutomer' checked ='checked'> Grouping Customer-->
			<input type='text' class='form-control' id='kdcustomer' name='kdcustomer' size='50' autocomplete='off' readonly required>
			<input type="text" class='form-control' id='nmcustomer' name='nmcustomer' size='50' readonly>
			<button type='button' id='src' class='btn btn-primary' name='btn_customer' onclick='cari_data_customer()'>Cari</button>
			<br><input type='checkbox' class='form-control' name='semuasales' id='checkall_sales' value='semuasales'> Semua Sales</br> <!-- checked ='checked'-->
			<input type='text' class='form-control' id='kdsales' name='kdsales' size='50' autocomplete='off' readonly required>
			<input type="text" class='form-control' id='nmsales' name='nmsales' size='50' readonly>
			<button type='button' id='src' class='btn btn-primary mb-2' name='btn_sales' onclick='cari_data_sales()'>Cari</button>
			<br><br>
			<label class="radio-inline">
				<input type="radio" name="pilihanppn" id="ppnnonppn" value="ppnnonppn" checked> PPN dan Non PPN
			</label>
			<label class="radio-inline">
				<input type="radio" name="pilihanppn" id="ppn" value="ppn"> PPN
			</label>
			<label class="radio-inline">
				<input type="radio" name="pilihanppn" id="nonppn" value="nonppn"> Non PPN
			</label>
			<br><br><button type='submit' class='btn btn-danger'>Proses Cetak</button>
		</form>
	</font>
<?php
} else {
	echo "<font color='red'>Anda tidak punya hak !</font>";
}
?>