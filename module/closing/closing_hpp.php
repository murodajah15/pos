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
				<font size="4">CLOSING HPP</font>
			</div>
			<div class="panel-body">
				<form method='post'>
					<input type='hidden' name='username' id='username' value='<?= $user ?>'>
					<div class="row">
						<div class='col-md-4'>
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
									<td>Tahun Periode </td>
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
								<tr>
									<td>Bulan Periode Berikutnya </td>
									<td><select name="bulan1" id="bulan1" class='form-control'>
											<!--<option selected="selected" ></option>-->
											<?php
											$bulan1 = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
											$jlh_bln = count($bulan1);
											$month = date('m') + 1;
											if ($month > 12) {
												$month = 1;
											}
											for ($c = 0; $c < $jlh_bln; $c++) {
												if (($c) == $month) {
													echo "<option value='$c' selected>$bulan1[$c] </option>";
												} else {
													echo "<option value='$c'> $bulan1[$c] </option>";
												}
											}
											?>
										</select>
									</td>
								</tr>
								<tr>
									<td>Tahun Periode Berikutnya</td>
									<td>
										<?php
										$month = date('m') + 1;
										$now = date('Y');
										if ($month > 12) {
											$now = date('Y') + 1;
										}
										echo "<select name='tahun1' id='tahun1' class='form-control'>";
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
								echo " <input button type='Button' class='btn btn-primary' value='Proses' onClick='alert_proses()'/><br>";
							} else {
								echo " <input button type='Button' class='btn btn-primary' value='Proses' onClick='alert_proses()' disabled/><br>";
							}
							?>
							<br>
						</div>
						<!--<div class="box-body table-responsive">-->
						<div class='col-md-8'>
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
							<table id="example2" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th width='30'>No.</th>
										<th width='90'>Periode Closing</th>
										<th>Tgl. Closing</th>
										<th>User</th>
										<th width='70'>Aksi</th>
									</tr>
								</thead>
								<?php
								// 	$tampil = mysqli_query($connect,"SELECT * FROM stock_barang group by periode order by periode");
								// 	$no=1;
								// while($k=mysqli_fetch_assoc($tampil)){
								// 	$id = $k['periode'];
								// 	echo "<tr>
								// 	<td align='center'>$no</td>
								// 			<td>$k[periode]</td></td>
								// 			<td>$k[tgl_closing]</td></td>
								// 			<td>$k[user_closing]</td></td>
								// 			<td><button type='button' class='btn btn-danger' onClick='alert_unclosing($id)'/>
								// 			Unclosing</span>
								// 			</button>";    									

								// 		$no++;
								// }
								$tampil = mysqli_query($connect, "SELECT * FROM close_hpp order by periode+tgl_closing desc");
								$no = 1;
								while ($k = mysqli_fetch_assoc($tampil)) {
									$id = $k['periode'];
									echo "<tr>
								<td align='center'>$no</td>
										<td>$k[periode]</td></td>
										<td>$k[tgl_closing]</td></td>
										<td>$k[user_closing]</td></td>";
									if ($k['status'] == 'Y') {
										echo "<td><button type='button' class='btn btn-danger' onClick='alert_unclosing($id)'/>
											Unclosing</span>
											</button>";
									} else {
										echo "<td>Batal Closing</span>";
									}


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
					var cek1 = document.getElementById('bulan').value;
					var cek2 = document.getElementById('tahun').value;
					var nbulan1 = document.getElementById('bulan1').value;
					var ntahun1 = document.getElementById('tahun1').value;
					var cek3 = document.getElementById('username').value;
					var bulan = "&bulan="
					var tahun = "&tahun="
					var bulan1 = "&bulan1="
					var tahun1 = "&tahun1="
					var username = "&username="
					var cek = cek1 + tahun + cek2 + username + cek3 + bulan1 + nbulan1 + tahun1 + ntahun1;
					$href = "module/closing/proses_closing_hpp.php?id=" + cek;
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

	function alert_unclosing($id) {
		swal({
				title: "Yakin akan di Unclosing ?",
				text: "",
				icon: "warning",
				buttons: true,
				dangerMode: true,
			})
			.then((willUnclosing) => {
				if (willUnclosing) {
					$href = "module/closing/proses_unclosing_hpp.php?id=" + $id;
					window.location.href = $href
					// swal("Poof! Your imaginary file has been deleted!", {
					//   icon: "success",
					// });
				} else {
					//swal("Batal Hapus!");
				}
			});
	};
</script>