<?php
$user = $_SESSION['username'];
?>

<?php
include 'cek_akses.php';
if ($aksesok == 'Y') {
	//$de=mysqli_fetch_assoc(mysqli_query($connect,"select * from saplikasi where aktif='Y'"));
	//$tgl_proses=$de['tgl_berikutnya'];
	$tgl_proses = date('Y-m-d');
	$tgl_berikutnya = strtotime("+1 day");
	$tgl_berikutnya = date('Y-m-d', $tgl_berikutnya);
?>

	<font face="calibri">
		<div class="panel panel-info">
			<div class="panel-heading">
				<font size="4">CLOSING HARIAN</font>
			</div>
			<div class="panel-body">
				<form method='post'>
					<input type='hidden' name='username' id='username' value='<?= $user ?>'>
					<div class="row">
						<div class='col-md-6'>
							<table class="table table-bordered table-striped table-hover">
								<tr>
									<td>Tanggal Closing (M/D/Y)</td>
									<td><input type='date' class='form-control' id='tgl_proses' name='tgl_proses' value="<?= $tgl_proses ?>" size='50' autocomplete='off' readonly></td>
								</tr>
								<tr>
									<td>Tanggal Data Berikutnya (M/D/Y)</td>
									<td><input type='date' class='form-control' id='tgl_berikutnya' name='tgl_berikutnya' value="<?= $tgl_berikutnya ?>" size='50' autocomplete='off'></td>
								</tr>
								<tr>
									<td>
								</tr>
								</td>
								<tr>
									<td><input type='checkbox' class='form-control' name='resetnomor' id='resetnomor'>
										<font color='red'> Reset nomor transaksi untuk awal bulan berikutnya</font>
									</td>
								</tr>
								<tr>
									<td>Bulan </td>
									<td><select name="bulan" id="bulan" class='form-control'>
											<!--<option selected="selected" ></option>-->
											<?php
											$bulan = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
											$jlh_bln = count($bulan);
											$month = date('m');
											for ($c = 0; $c < $jlh_bln; $c++) {
												if (($c - 1) == $month) {
													echo "<option value='$c' selected>$bulan[$c] </option>";
												} else {
													echo "<option value='$c'> $bulan[$c] </option>";
												}
											}
											?>
										</select>
									</td>
								</tr>
								<tr>
									<td>Tahun</td>
									<td>
										<?php
										$now = date('Y');
										echo "<select name='tahun' id='tahun' class='form-control'>";
										for ($a = $now - 3; $a <= $now; $a++) {
											if ($a == $now) {
												echo "<option value='$a' selected>$a </option>";
											} else {
												echo "<option value='$a'>$a</option>";
											}
										}
										echo "</select>";
										?>
									</td>
								</tr>
							</table>
							<?php
							cekakses($connect, $user, 'Closing Harian');
							$lakses = $_SESSION['aksesproses'];
							if ($lakses == 1) {
								echo " <input button type='Button' class='btn btn-danger' value='Proses' onClick='alert_proses()'/><br>";
							} else {
								echo " <input button type='Button' class='btn btn-danger' value='Proses' onClick='alert_proses()' disabled/><br>";
							}
							?>
							<br>
						</div>
						<!--<div class="box-body table-responsive">-->
						<div class='col-md-6'>
							<table id="example1" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th width='30'>No.</th>
										<th>User Login</th>
										<th>Last Login</th>
									</tr>
								</thead>
								<?php
								$tampil = mysqli_query($connect, "SELECT * FROM user where login='Y' order by username");
								$no = 1;
								while ($k = mysqli_fetch_assoc($tampil)) {
									echo "<tr>
				        <td align='center'>$no</td>
								<td>$k[username]</td></td>
								<td>$k[last_login]</td></td>";
									$no++;
								}
								?>
							</table>
						</div>
				</form>
			</div>
		</div>
		</div>
	</font>
<?php
}
?>

<script>
	function alert_proses() {
		swal({
				title: "Yakin akan di Proses Closing ?",
				text: "",
				icon: "warning",
				buttons: true,
				dangerMode: true,
			})
			.then((willCetak) => {
				if (willCetak) {
					//$href = "module/closing/proses_closing_harian.php?id="+document.getElementById("tglberikutnya").value;
					var cek1 = document.getElementById('tgl_berikutnya').value;
					var cek2 = document.getElementById('username').value;
					var cek3 = "&username="
					var nbulan = document.getElementById('bulan').value;
					var ntahun = document.getElementById('tahun').value;
					var nresetnomor = $("#resetnomor:checked").val(); //document.getElementById('resetnomor').value;
					var bulan = "&bulan="
					var tahun = "&tahun="
					var resetnomor = "&resetnomor="
					var cek = cek1 + cek3 + cek2 + bulan + nbulan + tahun + ntahun + resetnomor + nresetnomor;
					$href = "module/closing/proses_closing_harian.php?id=" + cek;
					//$href = "module/closing/proses_closing_harian.php?id="+"2019-09-18&username=$asal";
					window.location.href = $href;
					//window.open($href+$id,"_blank");
					//window.location.href = $href+$id;
					// swal("Poof! Your imaginary file has been deleted!", {
					//   icon: "success",
					// });
				} else {
					//swal("Batal Hapus!");
				}
			});
	};
</script>