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
		<h3>Laporan Kasir Pengeluaran Uang</h3>
		<hr size="10px">
		<form method='post' target='_blank' action='report/rkasir_keluar_xls.php'>
			<!--checked ="checked"-->
			<input type='checkbox' class='form-control' name='check2' value='outstanding'> Outstanding
			<br><input type='checkbox' class='form-control' name='check1' id='checkall_periode' value='semuaperiode'> Semua Periode (M-D-Y)
			<!--<div class="form-group">-->
			<input type="date" class='form-group' name='tanggal1' value="<?= $tanggal ?>">
			<input type="date" class='form-group' name='tanggal2' value="<?= $tanggal ?>">
			<br>KASIR<select name='nmkasir' class='form-control' style="width: 200px;">
				<option width="30" value=''> - PILIH KASIR - </option>";
				<?php
				$data = mysqli_query($connect, 'select * from user order by username');
				while ($row = mysqli_fetch_array($data)) {
					echo '<option name="nmkasir"  value="' . $row['username'] . '">' . $row['username'] . '|' . $row['nama_lengkap'] . '</option>';
				}
				echo '</select>';
				?>
				<!--</div>-->
				<br><button type='submit' class='btn btn-primary'>Cetak</button>
		</form>
	</font>
<?php
} else {
	echo "<font color='red'>Anda tidak punya hak !</font>";
}
?>