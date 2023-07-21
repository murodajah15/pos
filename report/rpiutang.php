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
			<h3>Laporan Piutang</h3>
			<hr size="10px">
			<form method='post' target='_blank' action='report/rpiutang_xls.php'>
				<!--<input type='checkbox' class='form-control' name='check2' value='outstanding'> Outstanding-->
				<input type='checkbox' class='form-control' name='check1' id='checkall_periode' value='semuaperiode' onclik='semua_periode()'> Semua Periode (M-D-Y)
				<input id="tanggal1" type="date" class='form-group' name='tanggal1' value="<?= $tanggal ?>">
				<input id="tanggal2" type="date" class='form-group' name='tanggal2' value="<?= $tanggal ?>">
				<!--style="display:block" -->
				<br><br>
				Bentuk : <input type="radio" name="harbul" value="Harian" <?php echo 'checked' ?>> Harian
				<input type="radio" name="harbul" value="Bulanan"> Bulanan
				<br><br><input type='checkbox' class='form-control' name='semuacustomer' value='semuacutomer' checked='checked'> Semua Customer
				<!--<input type='checkbox' class='form-control' name='semuacustomer' value='semuacutomer' checked ='checked'> Grouping Customer-->
				<input type='text' class='form-control' id='kdcustomer' name='kdcustomer' size='50' autocomplete='off' readonly required>
				<input type="text" class='form-control' id='nmcustomer' name='nmcustomer' size='50' readonly>
				<button type='button' id='src' class='btn btn-primary' onclick='cari_data_customer()'>Cari</button>
				<br><br><input type='checkbox' class='form-control' name='belumlunas' id='belumlunas' value='belumlunas' checked='checked'> Hanya Data Belum Lunas
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