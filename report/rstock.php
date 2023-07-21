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
		<div class='col-md-12'>
			<h3>Laporan Stock Barang</h3>
			<hr size="10px">
		</div>
		<form method='post' target='_blank' action='report/rstock_xls.php'>
			<div class='col-md-6'>
				<!-- <div class='input-group'> <input type='text' class='form-control' style="text-transform: uppercase; width: 9em;" id='noopname' name='noopname' size='50' autocomplete='off' readonly >
					<input type='text' class='form-control' style='width: 24em' id='tglopname' name='tglopname' readonly>
					<button type='button' id='src' class='btn btn-primary' onclick='cari_data_opname()'>Cari</button>
				</div><br>
				<input type='checkbox' class='form-control' name='check1' id='check1' value='semuaperiode' onclik='semua_periode()'> Semua Periode (M-D-Y)  -->
				<table class="table table-bordered table-striped table-hover">
					<tr>
						<td>Bulan Periode </td>
						<td><select name="bulan" id="bulan" class='form-control'>
								<!--<option selected="selected" ></option>-->
								<?php
								$bulan = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
								$jlh_bln = count($bulan);
								$month = date('m');
								for ($c = 0; $c < $jlh_bln; $c++) {
									if (($c) == $month) {
										echo "<option value='$c' selected>$bulan[$c] </option> required='required'";
									} else {
										echo "<option value='$c'> $bulan[$c] </option>";
									}
								}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td>Tahun Periode </td>
						<td>
							<?php
							$now = date('Y');
							$now1 = date('Y') + 5;
							echo "<select name='tahun' id='tahun' class='form-control'>";
							for ($a = $now1 - 20; $a <= $now1; $a++) {
								if ($a == $now) {
									echo "<option value='$a' selected>$a </option>";
								} else {
									echo "<option value='$a'>$a</option>";
								}
							}
							echo "</select>";
							?>
				</table>
				<div class="row">
					<div class='col-md-12'>
						Bentuk : <td><input type="radio" name="bentuk" value="Rincian" <?php echo 'checked' ?>> Rincian
							<input type="radio" name="bentuk" value="Rekapitulasi"> Rekapitulasi
							<br>
							<input type="checkbox" name="pilihan" id='checkall_barang' value="Perbarang" checked> Perbarang
							<br><br>
							<div class='input-group'> <input type='text' class='form-control' style="text-transform: uppercase; width: 9em;" id='kdbarang' name='kdbarang' size='50' autocomplete='off'>
								<input type='text' class='form-control' style='width: 24em' id='nmbarang' name='nmbarang' readonly>
								<button type='button' id='src' name='src' class='btn btn-primary' onclick='cari_data_tbbarang()'>Cari</button>

							</div>
							<br><button type='submit' class='btn btn-danger'>Cetak</button>
					</div>
				</div>
			</div>
		</form>
	</font>
<?php
} else {
	echo "<font color='red'>Anda tidak punya hak !</font>";
}
?>

<script>
	var rad = document.myForm.myRadios;
	var prev = null;
	for (var i = 0; i < rad.length; i++) {
		rad[i].addEventListener('change', function() {
			(prev) ? console.log(prev.value): null;
			if (this !== prev) {
				prev = this;
			}
			console.log(this.value)
		});
	}
</script>

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


<script src="js/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#kdbarang').on('blur', function(e) {
			let cari = $(this).val();
			$.ajax({
				url: 'repl_tbbarang.php',
				type: 'post',
				data: {
					kode_barang: cari
				},
				success: function(response) {
					let data_response = JSON.parse(response);
					if (!data_response) {
						$('#nmbarang').val('');
						$('#kdsatuan').val('');
						$('#harga').val('');
						cari_data_barang_beli();
						return;
					}
					$('#nmbarang').val(data_response['nama']);
					$('#kdsatuan').val(data_response['kdsatuan']);
					$('#harga').val(data_response['harga_beli']);
					//console.log(data_response['nama']);
					//console.log(data_response['satuan']);
				},
				error: function() {
					console.log('file not fount');
				}
			})
			// console.log(cari);
		})
	})

	$(document).ready(function() {
		$('#noopname').on('blur', function(e) {
			let cari = $(this).val();
			$.ajax({
				url: 'repl_noopname.php',
				type: 'post',
				data: {
					kode_barang: cari
				},
				success: function(response) {
					let data_response = JSON.parse(response);
					if (!data_response) {
						$('#tglopname').val('');
						cari_data_opname();
						return;
					}
					$('#tglopname').val(data_response['tglopname']);
					//console.log(data_response['nama']);
					//console.log(data_response['satuan']);
				},
				error: function() {
					console.log('file not fount');
				}
			})
			// console.log(cari);
		})
	})
</script>