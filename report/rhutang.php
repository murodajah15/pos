<body>
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
			<h3>Laporan Hutang</h3>
			<hr size="10px">
			<form method='post' target='_blank' action='report/rhutang_xls.php'>
				<!--<input type='checkbox' class='form-control' name='check2' value='outstanding'> Outstanding-->
				<input type='checkbox' class='form-control' name='check1' id='checkall_periode' value='semuaperiode' onclik='semua_periode()'> Semua Periode (M-D-Y)
				<input id="tanggal1" type="date" class='form-group' name='tanggal1' value="<?= $tanggal ?>">
				<input id="tanggal2" type="date" class='form-group' name='tanggal2' value="<?= $tanggal ?>">
				<!--style="display:block" -->
				<br><br>
				Bentuk : <td><input type="radio" name="harbul" value="Harian" <?php echo 'checked' ?>> Harian
				<td><input type="radio" name="harbul" value="Bulanan"> Bulanan
					<br>
					<br><button type='submit' class='btn btn-primary'>Cetak</button>
			</form>
		</font>
	<?php
	} else {
		echo "<font color='red'>Anda tidak punya hak !</font>";
	}
	?>

	<script>
		function semua_periode() {
			var checkBox = document.getElementById("check1");
			var tanggal1 = document.getElementById("tanggal1");
			var tanggal2 = document.getElementById("tanggal2");
			if (checkBox.checked == true) {
				tanggal1.style.display = "block";
				tanggal2.style.display = "block";
			} else {
				tanggal1.style.display = "none";
				tanggal2.style.display = "none";
			}
		}
	</script>