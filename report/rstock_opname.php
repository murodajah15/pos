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
		<h3>Laporan Stock Opanem</h3>
		<hr size="12px">
		<form method='post' target='_blank' action='report/rstock_opname_xls.php'>
			DOKUMEN STOCK OPNAME<select name='noopname' class='form-control' style="width: 250px;">
				<option width="40" value=''> - PILIH NO. DOKUMEN - </option>";
				<?php
				$data = mysqli_query($connect, 'select * from opnameh order by noopname');
				while ($row = mysqli_fetch_array($data)) {
					echo '<option name="noopname"  value="' . $row['noopname'] . '">' . $row['noopname'] . '|' . $row['tglopname'] . '</option>';
				}
				echo '</select>';
				?>
				<!--<br>
				<td><input type="radio" name="harbul" value="Harian"> Harian
				<td><input type="radio" name="harbul" value="Bulanan"> Bulanan
				<br>-->
				<br><button type='submit' class='btn btn-primary'>Cetak</button>
		</form>
	</font>
<?php
} else {
	echo "<font color='red'>Anda tidak punya hak !</font>";
}
?>