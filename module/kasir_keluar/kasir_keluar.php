<?php
$user = $_SESSION['username'];
include('autonumber.php');
if (isset($_GET['tipe'])) {
	if ($_GET['tipe'] == 'detail_proses') {
		cekakses($connect, $user, 'Kasir Pengeluaran Uang');
		$lakses = $_SESSION['aksespakai'];
		if ($lakses == 1) {
			// $query = $connect->prepare("select * from kasir_keluarh where nokwitansi=?");
			// $query->bind_param('s', $_GET['nokwitansi']);
			// $query->execute();
			// $result = $query->get_result();
			// $de = $result->fetch_assoc();
			$sql = mysqli_query($connect, "select * from kasir_keluarh where nokwitansi='$_GET[nokwitansi]'");
			$de = mysqli_fetch_assoc($sql);
			$nokwitansi = strip_tags($de['nokwitansi']);
			$proses = strip_tags($de['proses']);
			$tglkwitansi = strip_tags($de['tglkwitansi']);
			$kdjnkeluar = strip_tags($de['kdjnkeluar']);
			$nmjnkeluar = strip_tags($de['nmjnkeluar']);
			$subtotal = strip_tags($de['subtotal']);
			$materai = strip_tags($de['materai']);
			$total = strip_tags($de['total']);
			$keterangan = strip_tags($de['keterangan']); ?>
			<font face='calibri'>
				<div class='panel panel-danger'>
					<div class='panel-heading'>
						<font size="4">DETAIL PENGELUARAN UANG</font>
					</div>
					<div class='panel-body'>
						<form method='post' name='kasir_keluar' enctype='multipart/form-data'>
							<input type='hidden' name='username' value="<?= $user ?>">
							<div class='col-md-6'>
								<table class="table table-bordered table-striped table-hover">
									<!--<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>-->
									<tr>
										<td>Nomor Kwitansi</td>
										<td>
											<input type='text' class='form-control' id='nokwitansi' name='nokwitansi' placeholder='No. PO *' style='text-transform:uppercase' value="<?= $nokwitansi ?>" readonly>
										</td>
									</tr>
									<tr>
										<td>Tgl. (M/D/Y)</td>
										<td><input type='date' class='form-control' id='tglkwitansi' name='tglkwitansi' value="<?= $tglkwitansi ?>" size='50' autocomplete='off' readonly></td>
									</tr>
									<tr>
										<td>Jenis Pengeluaran</td>
										<td><input type='text' class='form-control' name='kdjnkeluar' id='kdjnkeluar' size='20' value='<?= $kdjnkeluar ?>' autocomplete='off' readonly required>
									<tr>
										<td></td>
										<td><input type="text" class='form-control' name='nmjnkeluar' id='nmjnkeluar' size='50' value='<?= $nmjnkeluar ?>' readonly required></td>
									</tr>
								</table>
							</div>
							<div class='col-md-6'>
								<table class="table table-bordered table-striped table-hover">
									<tr>
										<td>Subtotal</td>
										<td> <input type="number" class='form-control' name='subtotal' id='subtotal' size='50' value='<?= $subtotal ?>' readonly></td>
									</tr>
									<tr>
										<td>Materai</td>
										<td> <input type="number" class='form-control' name='materai' id='materai' size='50' value='<?= $materai ?>' readonly"></td>
									</tr>
									<tr>
										<td>Total</td>
										<td> <input type="number" class='form-control' name='total' id='total' size='50' value='<?= $total ?>' readonly></td>
									</tr>
									<tr>
										<td>Keterangan</td>
										<td><textarea type='text' class='form-control' id='keterangan' name='keterangan' autocomplete='off' readonly><?= $keterangan ?></textarea></td>
									</tr>
								</table>
							</div>
							<div class='col-md-12'>
								<table class="table table-bordered table-striped table-hover">
									<!--<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>-->
									<tr>
										<th width='20'>No.</th>
										<th width='20'>No. Dokumen</th>
										<th>Tgl. Dokumen</th>
										<th>Supplier</th>
										<th>User</th>
										<th>Bayar</th>
									</tr>
									<?php
									$tampil = mysqli_query($connect, "select * from kasir_keluard where nokwitansi='$_GET[nokwitansi]'");
									// $query = $connect->prepare("select * from kasir_keluard where nokwitansi=?");
									// $query->bind_param('s', $_GET['nokwitansi']);
									// $query->execute();
									// $result = $query->get_result();
									// $de = $result->fetch_assoc();
									$no = 1;
									//<td><u><a href='?m=wo&tipe=detail&id=$k[id]'><font color='blue'>$k[kode]</font></a></u></td>
									//<td><u><a href='#' onclick =lihat_detail('$k[id]');><font color='blue'>$k[kdbarang]</font></a></u></td>
									while ($k = mysqli_fetch_assoc($tampil)) {
										//$date = date("m/d/Y", strtotime($k['tglwo']));
										$uang = number_format($k['uang'], 0, ",", ".");
										$kdsupplier = strip_tags($k['kdsupplier']);
										$nmsupplier = strip_tags($k['nmsupplier']);
										$uang = number_format($k['uang'], 0, ",", ".");
										$supplier = $kdsupplier . '|' . $nmsupplier;
										echo "<tr><td align='center'>$no</td>
								<td width='20'>$k[nodokumen]</td>
								<td width='30'>$k[tgldokumen]</td>
								<td width='150'>$supplier</td>
								<td width='200'>$k[user]</td>
								<td align='right' width='70'>$uang</td>";
										$no++;
									}
									$tampil = mysqli_query($connect, "select sum(uang) as total_subtotal from kasir_keluard where nokwitansi='$_GET[nokwitansi]'");
									$jum = mysqli_fetch_assoc($tampil);
									$total = $jum['total_subtotal'];
									$total = number_format($total, 0, ",", ".");
									echo "<tr><td colspan='5' align='right'></td>
							<td align='right' style='font-weight:bold'>$total</td>";
									?>
								</table>
							</div>
							<div class='col-md-12'>
								<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
									<input button type='Button' class='btn btn-danger' value='Close' onClick='history.back()' />
								</table>
							</div>
					</div>
				</div>
				</form>
			</font>
		<?php
		} else {
			echo "<script>alert('Anda tidak berhak !');history.go(-1) </script>";
		}
	}
}

if (isset($_GET['tipe'])) {
	if ($_GET['tipe'] == 'detail') {
		cekakses($connect, $user, 'Kasir Pengeluaran Uang');
		$lakses = $_SESSION['aksespakai'];
		// $query = $connect->prepare("select * from kasir_keluarh where id=?");
		// $query->bind_param('s', $_GET['id']);
		// $query->execute();
		// $result = $query->get_result();
		// $de = $result->fetch_assoc();
		$sql = mysqli_query($connect, "select * from kasir_keluarh where id='$_GET[id]'");
		$de = mysqli_fetch_assoc($sql);
		$nokwitansi = strip_tags($de['nokwitansi']);
		$proses = strip_tags($de['proses']);
		$tglkwitansi = strip_tags($de['tglkwitansi']);
		$kdjnkeluar = strip_tags($de['kdjnkeluar']);
		$jnkeluar = strip_tags($de['kdjnkeluar']) . '|' . strip_tags($de['nmjnkeluar']);
		if ($lakses == 1) { ?>
			<font face='calibri'>
				<div class='panel panel-info'>
					<div class='panel-heading'>
						<font size="4">DATA DETAIL KASIR PENGELUARAN UANG : <?= $nokwitansi ?></font>
					</div>
					<div class='panel-body'>
						<form method='post' name='so' enctype='multipart/form-data' action='module/kasir_keluar/proses_tambah_detail.php'>
							<input type='hidden' name='username' value="<?= $user ?>">
							<input type='hidden' name='tglkwitansi' value="<?= $tglkwitansi ?>">
							<input type='hidden' name='nokwitansi' value='<?= $nokwitansi ?>'>
							<input type='hidden' name='id' value='<?= $_GET['id'] ?>'>
							<div class='col-md-6'>
								<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
									<form method='post' enctype='multipart/form-data' action='module/kasir_keluar/proses_tambah_detail.php'>
										<input type='hidden' name='username' value='<?= $user ?>'>
										<input type='hidden' name='nokwitansi' value='<?= $nokwitansi ?>'>

										<div class="input-group">
											<span class="input-group-addon">No. Permohonan Keluar</span>
											<input type="text" class="form-control" name='nomohon' id='nomohon' size='50' placeholder="No. Permohonan" readonly>
											<span class='input-group-btn'></span>
											<button type='button' id='src' class='btn btn-primary' onclick='cari_data_permohonan()'>Cari</button>
											<span class='input-group-btn'></span><button type='submit' class='btn btn-success'>+</button>
										</div>

										<?php if ($kdjnkeluar <> 'K-LL') { ?>
											<div class='col-md-12'>
												<table style=font-size:12px; class='table table-striped table table-bordered' width='600px'>
													<tr>
														<th>No. Dokumen <input type="button" class='btn btn-black' value="Clear" onclick="eraseText()"></th>
														<th>Supplier</th>
														<th>Keterangan</th>
														<th>Bayar</th>
														<th>Aksi</th>
													</tr>
													<td>
														<div class='input-group'> <input type='text' class='form-control' style='width: 10em' id='nodokumen' name='nodokumen' size='50' autocomplete='off'>
															<span class='input-group-btn'>
																<?php
																if ($kdjnkeluar == 'K-BE') {
																?>
																	<button type='button' id='src' class='btn btn-primary' onclick='cari_data_hutang()'>
																		Cari
																	</button>
															</span>
													</td>
												<?php
																} else {
												?>
													<button type='button' id='src' class='btn btn-primary' onclick='cari_data_kembali()'>
														Cari
													</button>
													</span></td>
												<?php
																}
												?>
												<input type='hidden' class='form-control' style='width: 6em' id='tgldokumen' name='tgldokumen' readonly>
												<input type='hidden' class='form-control' style='width: 6em' id='kdsupplier' name='kdsupplier' readonly>
												</td>
												<td><input type='text' class='form-control' style='width: 15em' id='nmsupplier' name='nmsupplier'></td>
												</td>
												<td><input type='text' class='form-control' style='width: 20em' id='keterangan' name='keterangan'></td>
												<input type="hidden" class='form-control' id='total' name='total' style='width: 8em' required readonly>
												</td>
												<td><input type="number" class='form-control' id='uang' name='uang' style='width: 8em' onkeyup="hit_subtotal()" onblur="hit_subtotal()"></td>
												<td align='center' width='50px'>
													<button type='submit' class='btn btn-primary'>+</button>
												</table>
											</div>

											<div class='col-md-12'>
												<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
													<tr>
														<th width='50'>No.</th>
														<th>No. Dokumen</th>
														<th>Tanggal</th>
														<th>Supplier</th>
														<th>Keterangan</th>
														<th>Jumlah</th>
														<th>Aksi</th>
													</tr>
													<?php
													$tampil = mysqli_query($connect, "select * from kasir_keluard where nokwitansi='$nokwitansi'");
													// $query = $connect->prepare("select * from kasir_keluard where nokwitansi=?");
													// $query->bind_param('s', $nokwitansi);
													// $query->execute();
													// $result = $query->get_result();
													// $de = $result->fetch_assoc();
													$no = 1;
													//<td><u><a href='?m=wo&tipe=detail&id=$k[id]'><font color='blue'>$k[kode]</font></a></u></td>
													//<td><u><a href='#' onclick =lihat_detail('$k[id]');><font color='blue'>$k[nodokumen]</font></a></u></td>
													while ($k = mysqli_fetch_assoc($tampil)) {
														//$date = date("m/d/Y", strtotime($k['tglwo']));
														$supplier = strip_tags($k['kdsupplier']) . '|' . strip_tags($k['nmsupplier']);
														$uang = number_format($k['uang'], 0, ",", ".");
														echo "<tr><td align='center'>$no</td>
									<td width='50'>$k[nodokumen]</td>
									<td width=70'>$k[tgldokumen]</td>
									<td width='170'>$supplier</td>
									<td width='210'>$k[keterangan]</td>
									<td width='80' align='right'>$uang</td>
									<td align='center' width='100px'>";
														echo "<a class='btn btn-success btn-sm' href='?m=kasir_keluar&tipe=edit_detail&id=$k[id]&nokwitansi=$nokwitansi'>Edit</a> ";
														echo " <input button type='Button' class='btn btn-danger btn-sm' value='Hapus' onClick='alert_hapus_detail($k[id])'/>";
														$no++;
													}
													$tampil = mysqli_query($connect, "select sum(uang) as total_subtotal from kasir_keluard where nokwitansi='$nokwitansi'");
													$jum = mysqli_fetch_assoc($tampil);
													$total = $jum['total_subtotal'];
													$total = number_format($total, 0, ",", ".");
													echo "<tr><td colspan='4'></td>
								<td colspan='1' align='right'></td>
								<td align='right' style='font-weight:bold'>$total</td>";
													?>
												</table>
											</div>
										<?php } ?>
										<?php if ($kdjnkeluar == 'K-LL') { ?>
											<div class='col-md-12'>
												<table style=font-size:12px; class='table table-striped table table-bordered' width='600px'>
													<tr>
														<th>Penerima</th>
														<th>Keterangan</th>
														<th>Bayar</th>
														<th>Aksi</th>
													</tr>
													<input type='hidden' class='form-control' style='width: 6em' id='nodokumen' name='nodokumen' readonly>
													<input type='hidden' class='form-control' style='width: 6em' id='tgldokumen' name='tgldokumen' readonly>
													<input type='hidden' class='form-control' style='width: 6em' id='kdsupplier' name='kdsupplier' readonly>
													</td>
													<td><input type='text' class='form-control' style='width: 20em' id='nmsupplier' name='nmsupplier'></td>
													</td>
													<td><input type='text' class='form-control' style='width: 30em' id='keterangan' name='keterangan'></td>
													<input type="hidden" class='form-control' id='total' name='total' style='width: 8em' required readonly>
													</td>
													<td><input type="number" class='form-control' id='uang' name='uang' style='width: 8em' onkeyup="hit_subtotal()" onblur="hit_subtotal()"></td>
													<td align='center' width='50px'>
														<button type='submit' class='btn btn-primary'>+</button>
												</table>
											</div>

											<div class='col-md-12'>
												<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
													<tr>
														<th width='50'>No.</th>
														<th>Penerima</th>
														<th>Keterangan</th>
														<th>Jumlah</th>
														<th>Aksi</th>
													</tr>
													<?php
													// $tampil = mysqli_query($connect, "select * from kasir_keluard where nokwitansi='$nokwitansi'");
													// $query = $connect->prepare("select * from kasir_keluard where nokwitansi=?");
													// $query->bind_param('s', $nokwitansi);
													// $query->execute();
													// $result = $query->get_result();
													// $de = $result->fetch_assoc();
													$sql = mysqli_query($connect, "select * from kasir_keluard where nokwitansi='$nokwitansi'");
													$de = mysqli_fetch_assoc($sql);
													$tgldokumen = strip_tags($de['nodokumen']);
													$tgldokumen = strip_tags($de['tgldokumen']);
													$supplier = strip_tags($de['kdsupplier']) . '|' . strip_tags($de['nmsupplier']);
													$uang = strip_tags($de['uang']);
													$no = 1;
													//<td><u><a href='?m=wo&tipe=detail&id=$k[id]'><font color='blue'>$k[kode]</font></a></u></td>
													//<td><u><a href='#' onclick =lihat_detail('$k[id]');><font color='blue'>$k[nodokumen]</font></a></u></td>
													while ($k = mysqli_fetch_assoc($tampil)) {
														//$date = date("m/d/Y", strtotime($k['tglwo']));
														$uang = number_format($k['uang'], 0, ",", ".");
														echo "<tr><td align='center'>$no</td>
									<td width=150'>$k[nmsupplier]</td>
									<td width=250'>$k[keterangan]</td>
									<td width='80' align='right'>$uang</td>
									<td align='center' width='100px'>";
														echo "<a class='btn btn-primary' href='?m=kasir_keluar&tipe=edit_detail&id=$k[id]&nokwitansi=$nokwitansi'>Edit</a> ";
														echo " <input button type='Button' class='btn btn-danger' value='Hapus' onClick='alert_hapus_detail($k[id])'/>";
														$no++;
													}
													$tampil = mysqli_query($connect, "select sum(uang) as total_subtotal from kasir_keluard where nokwitansi='$nokwitansi'");
													$jum = mysqli_fetch_assoc($tampil);
													$total = $jum['total_subtotal'];
													$total = number_format($total, 0, ",", ".");
													echo "<tr><td colspan='2'></td>
								<td colspan='1' align='right'></td>
								<td align='right' style='font-weight:bold'>$total</td>";
													?>
												</table>
											</div>
										<?php } ?>

										<div class='col-md-12'>
											<!--<input button type='Button' class='btn btn-danger' value='Close' onClick='history.back()'/>-->
											<input button type='Button' class='btn btn-danger' value='Close' onClick='window.location ="./dashboard.php?m=kasir_keluar"' />
										</div>
							</div>
					</div>
				</div>
				</div>
				</div>
				</div>
				</form>
			</font>
		<?php
		} else {
			echo "<script>alert('Anda tidak berhak !');history.go(-1) </script>";
		}
	}
}

if (isset($_GET['tipe'])) {
	if ($_GET['tipe'] == 'edit_detail') {
		cekakses($connect, $user, 'Kasir Pengeluaran Uang');
		$lakses = $_SESSION['aksespakai'];
		if ($lakses == 1) {
			// $query = $connect->prepare("select * from kasir_keluard where id=?");
			// $query->bind_param('i', $_GET['id']);
			// $query->execute();
			// $result = $query->get_result();
			// $de = $result->fetch_assoc();
			$sql = mysqli_query($connect, "select * from kasir_keluard where id='$_GET[id]'");
			$de = mysqli_fetch_assoc($sql);
			$id = $_GET['id'];
			$nokwitansi = strip_tags($de['nokwitansi']);
			$nodokumen = strip_tags($de['nodokumen']);
			$uang = strip_tags($de['uang']);
			$keterangan = strip_tags($de['keterangan']);
			$nmsupplier = strip_tags($de['nmsupplier']); ?>
			<font face='calibri'>
				<h3>Edit Detail Kasir Pengeluaran Uang</h3>
				<form method='post' enctype='multipart/form-data' action='module/kasir_keluar/proses_edit_detail.php'>
					<input type='hidden' name='id' value='<?= $id ?>'>
					<input type='hidden' name='username' value='<?= $user ?>'>
					<input type='hidden' name='nokwitansi' value='<?= $nokwitansi ?>'>
					Nomor Kwitansi
					<input type='text' class='form-control' style='width: 15em' id='nokwitansi' name='nokwitansi' placeholder='No. Kwitansi *' style='text-transform:uppercase' value="<?= $nokwitansi ?>" readonly>
					<br>
					Supplier <input type='text' class='form-control' style='width: 35em' id='nmsupplier' name='nmsupplier' value='<?= $nmsupplier ?>' readonly required>
					Keterangan<textarea type='text' rows='2' class='form-control' style='width: 35em' id='keterangan' name='keterangan'><?= $keterangan ?></textarea>
					Nilai Bayar<input type="number" class='form-control' id='uang' name='uang' value='<?= $uang ?>' style='width: 10em' onkeyup="validAngka_no_titik(this)">
					<br>
					<button type='submit' class='btn btn-success'>Simpan</button>
					<input button type='Button' class='btn btn-danger' value='Batal' onClick='history.back()' />
				</form>
			</font>
		<?php
		} else {
			echo "<script>alert('Anda tidak berhak !');history.go(-1) </script>";
		}
	}
}

if (isset($_GET['tipe'])) {
	if ($_GET['tipe'] == 'tambah') {
		cekakses($connect, $user, 'Kasir Pengeluaran Uang');
		$lakses = $_SESSION['aksestambah'];
		$de = mysqli_fetch_assoc(mysqli_query($connect, "select * from saplikasi where aktif='Y'"));
		$tgl = $de['tgl_berikutnya']; //date('Y-m-d')
		if ($lakses == 1) { ?>
			<font face='calibri'>
				<div class='panel panel-primary'>
					<div class='panel-heading'>
						<font size="4">TAMBAH DATA HEADER KASIR PENGELUARAN UANG</font>
					</div>
					<div class='panel-body'>
						<form method='post' name='so' enctype='multipart/form-data' action='module/kasir_keluar/proses_tambah.php'>
							<input type='hidden' name='username' value="<?= $user ?>">
							<div class='col-md-6'>
								<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
									<tr>
										<td>Nomor Kwitansi</td>
										<td>
											<input type='text' class='form-control' id='nokwitansi' name='nokwitansi' id='nokwitansi' placeholder='No. Kwitansi *' style='text-transform:uppercase' value="<?php echo autoNumberKK($connect, 'id', 'kasir_keluarh'); ?>" readonly>
										</td>
									</tr>
									<tr>
										<td>Tgl. (M/D/Y)</td>
										<td><input type='date' class='form-control' id='tglkwitansi' name='tglkwitansi' value="<?php echo $tgl ?>" size='50' autocomplete='off' required readonly></td>
									</tr>
									<tr>
										<td>Jenis Pengeluaran</td>
										<td>
											<div class='input-group'> <input type='text' class='form-control' name='kdjnkeluar' id='kdjnkeluar' size='20' autocomplete='off' required>
												<span class='input-group-btn'>
													<button type='button' id='src' class='btn btn-primary' onclick='cari_data_jnkeluar()'>Cari
													</button>
												</span>
										</td>
									</tr>
									<tr>
										<td></td>
										<td><input type="text" class='form-control' name='nmjnkeluar' id='nmjnkeluar' size='50' readonly required></td>
									</tr>
									<tr>
										<td>Subtotal</td>
										<td> <input type="number" class='form-control' name='subtotal' id='subtotal' value='0' size='50' readonly></td>
									</tr>
									<tr>
										<td>Materai</td>
										<td> <input type="number" class='form-control' name='materai' id='materai' size='50' value='0' onkeyup="validAngka_no_titik(this)" onblur="hit_total()"></td>
									</tr>
									<tr>
										<td>Total</td>
										<td> <input type="number" class='form-control' name='total' id='total' size='50' value='0' readonly></td>
									</tr>
									<tr>
										<td>Keterangan</td>
										<td><textarea type='text' rows='3' class='form-control' id='kerangan' name='keterangan' autocomplete='off'></textarea></td>
									</tr>
								</table>
							</div>
							<div class='col-md-6'>
								<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
									<td>Cara Bayar
									<td><input type="radio" name="carabayar" value="Cash"> Cash
									<td><input type="radio" name="carabayar" value="Transfer"> Transfer
									<td><input type="radio" name="carabayar" value="Cek/Giro"> Cek/Giro
									<td><input type="radio" name="carabayar" value="Debit Card"> Debit Card
									<td><input type="radio" name="carabayar" value="Credit Card" required> Credit Card
								</table>
								<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
									<tr>
										<td>Bank</td>
										<td>
											<div class='input-group'> <input type='text' class='form-control' name='kdbank' id='kdbank' size='20' autocomplete='off' readonly required>
												<span class='input-group-btn'>
													<button type='button' id='src' class='btn btn-primary' onclick='cari_data_bank()'>Cari
													</button>
												</span>
										</td>
										<td> <input type="text" class='form-control' name='nmbank' id='nmbank' size='50' readonly required></td>
									</tr>
									<tr>
										<td>Jenis Kartu</td>
										<td>
											<div class='input-group'> <input type='text' class='form-control' name='kdjnskartu' id='kdjnskartu' size='20' autocomplete='off' readonly required>
												<span class='input-group-btn'>
													<button type='button' id='src' class='btn btn-primary' onclick='cari_data_jnskartu()'>Cari
													</button>
												</span>
										</td>
										<td> <input type="text" class='form-control' name='nmjnskartu' id='nmjnskartu' size='50' readonly required></td>
									</tr>
								</table>
								<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
									<tr>
										<td>No. Rekening</td>
										<td> <input type="text" class='form-control' id='norek' name='norek' size='50'></td>
									</tr>
									<tr>
										<td>No. Giro/Cek</td>
										<td> <input type="text" class='form-control' id='nocekgiro' name='nocekgiro' size='50'></td>
									</tr>
									<tr>
										<td>Tgl. Jt.Tempo Cek (M/D/Y)</td>
										<td><input type='date' class='form-control' id='tgljttempocekgiro' name='tgljttempocekgiro' value="<?php echo $tgljttempocekgiro ?>" size='50' autocomplete='off'></td>
									</tr>
								</table>
							</div>
							<div class='col-md-12'>
								<button type='submit' class='btn btn-primary'>Simpan</button>
								<input button type='Button' class='btn btn-danger' value='Batal' onClick='history.back()' />
							</div>
					</div>
				</div>
				</form>
			</font>
		<?php
		} else {
			echo "<script>alert('Anda tidak berhak !');history.go(-1) </script>";
		}
	} elseif ($_GET['tipe'] == 'edit') {
		cekakses($connect, $user, 'Kasir Pengeluaran Uang');
		$lakses = $_SESSION['aksesedit'];
		if ($lakses == 1) {
			// $query = $connect->prepare("select * from kasir_keluarh where id=?");
			// $query->bind_param('i', $_GET['id']);
			// $query->execute();
			// $result = $query->get_result();
			// $de = $result->fetch_assoc();
			$sql = mysqli_query($connect, "select * from kasir_keluarh where id='$_GET[id]'");
			$de = mysqli_fetch_assoc($sql);
			$nokwitansi = strip_tags($de['nokwitansi']);
			$tglkwitansi = strip_tags($de['tglkwitansi']);
			$kdjnkeluar = strip_tags($de['kdjnkeluar']);
			$nmjnkeluar = strip_tags($de['nmjnkeluar']);
			$carabayar = strip_tags($de['carabayar']);
			$subtotal = strip_tags($de['subtotal']);
			$materai = strip_tags($de['materai']);
			$total = strip_tags($de['total']);
			$keterangan = strip_tags($de['keterangan']);
			$carabayar = strip_tags($de['carabayar']);
			$kdbank = strip_tags($de['kdbank']);
			$nmbank = strip_tags($de['nmbank']);
			$kdjnskartu = strip_tags($de['kdjnskartu']);
			$nmjnskartu = strip_tags($de['nmjnskartu']);
			$norek = strip_tags($de['norek']);
			$nocekgiro = strip_tags($de['nocekgiro']);
			$tgljttempocekgiro = strip_tags($de['tgljttempocekgiro']);
		?>
			<font face='calibri'>
				<div class="panel panel-success">
					<div class="panel-heading">
						<font size="4">EDIT DATA HEADER KASIR PENGELUARAN UANG</font>
					</div>
					<div class="panel-body">
						<form method='post' name='kasir_keluar' enctype='multipart/form-data' action='module/kasir_keluar/proses_edit.php'>
							<input type='hidden' name='username' value="<?= $user ?>">
							<input type='hidden' name='id' value="<?= $de['id'] ?>" />
							<div class='col-md-6'>
								<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
									<tr>
										<td>Nomor Kwitansi</td>
										<td>
											<input type='text' class='form-control' id='nokwitansi' name='nokwitansi' placeholder='No. Jual *' style='text-transform:uppercase' value="<?= $nokwitansi ?>" readonly>
										</td>
									</tr>
									<tr>
										<td>Tgl. Penjualan (M/D/Y)</td>
										<td><input type='date' class='form-control' id='tglkwitansi' name='tglkwitansi' value="<?php echo $tglkwitansi ?>" size='50' autocomplete='off' required readonly></td>
									</tr>
									<tr>
										<td>Jenis Pengeluaran</td>
										<td>
											<div class='input-group'> <input type='text' class='form-control' name='kdjnkeluar' id='kdjnkeluar' size='20' value='<?= $kdjnkeluar ?>' autocomplete='off' required>
												<span class='input-group-btn'>
													<button type='button' id='src' class='btn btn-primary' onclick='cari_data_jnkeluar()'>Cari
													</button>
												</span>
										</td>
									</tr>
									<tr>
										<td></td>
										<td><input type="text" class='form-control' name='nmjnkeluar' id='nmjnkeluar' size='50' value='<?= $nmjnkeluar ?>' readonly required></td>
									</tr>
									<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
										<tr>
											<td>Subtotal</td>
											<td> <input type="number" class='form-control' name='subtotal' id='subtotal' size='50' value='<?= $subtotal ?>' readonly></td>
										</tr>
										<tr>
											<td>Materai</td>
											<td> <input type="number" class='form-control' name='materai' id='materai' size='50' value='<?= $materai ?>' onkeyup="validAngka_no_titik(this)" onblur="hit_total()"></td>
										</tr>
										<tr>
											<td>Total</td>
											<td> <input type="number" class='form-control' name='total' id='total' size='50' value='<?= $total ?>' readonly></td>
										</tr>
										<tr>
											<td>Keterangan</td>
											<td><textarea type='text' class='form-control' id='keterangan' name='keterangan' autocomplete='off'><?= $keterangan ?></textarea></td>
										</tr>
									</table>
							</div>
							<div class='col-md-6'>
								<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
									<td>Cara Bayar
									<td><input type="radio" name="carabayar" value="Cash" <?php echo ($carabayar == 'Cash') ? 'checked' : '' ?>> Cash
									<td><input type="radio" name="carabayar" value="Transfer" <?php echo ($carabayar == 'Transfer') ? 'checked' : '' ?>> Transfer
									<td><input type="radio" name="carabayar" value="Cek/Giro" <?php echo ($carabayar == 'Cek/Giro') ? 'checked' : '' ?>> Cek/Giro
									<td><input type="radio" name="carabayar" value="Debit Card" <?php echo ($carabayar == 'Debit Card') ? 'checked' : '' ?>> Debit Card
									<td><input type="radio" name="carabayar" value="Credit Card" <?php echo ($carabayar == 'Credit Card') ? 'checked' : '' ?>> Credit Card
								</table>
								<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
									<tr>
										<td>Bank</td>
										<td>
											<div class='input-group'> <input type='text' class='form-control' id='kdbank' name='kdbank' size='20' autocomplete='off' value="<?= $kdbank ?>" readonly required>
												<span class='input-group-btn'>
													<button type='button' id='src' class='btn btn-primary' onclick='cari_data_bank()'>
														Cari
													</button>
												</span>
										</td>
										<td> <input type="text" class='form-control' id='nmbank' name='nmbank' size='50' value="<?= $nmbank ?>" readonly required></td>
									</tr>
									<tr>
										<td>Jenis Kartu</td>
										<td>
											<div class='input-group'> <input type='text' class='form-control' id='kdjnskartu' name='kdjnskartu' size='20' value="<?= $kdjnskartu ?>" autocomplete='off' readonly required>
												<span class='input-group-btn'>
													<button type='button' id='src' class='btn btn-primary' onclick='cari_data_jnskartu()'>
														Cari
													</button>
												</span>
										</td>
										<td> <input type="text" class='form-control' id='nmjnskartu' name='nmjnskartu' size='50' value="<?= $nmjnskartu ?>" readonly required></td>
									</tr>
								</table>
								<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
									<tr>
										<td>No. Rekening</td>
										<td> <input type="text" class='form-control' id='norek' name='norek' size='50' value="<?= $norek ?>"></td>
									</tr>
									<tr>
										<td>No. Giro/Cek</td>
										<td> <input type="text" class='form-control' id='nocekgiro' name='nocekgiro' size='50' value="<?= $nocekgiro ?>"></td>
									</tr>
									<tr>
										<td>Tgl. Jt.Tempo Cek (M/D/Y)</td>
										<td><input type='date' class='form-control' id='tgljttempocekgiro' name='tgljttempocekgiro' value="<?php echo $tgljttempocekgiro ?>" size='50' autocomplete='off'></td>
									</tr>
									<tr>
										<td>Keterangan</td>
										<td><textarea type='text' class='form-control' id='kerangan' name='keterangan' autocomplete='off'><?= $keterangan ?></textarea></td>
									</tr>
								</table>
							</div>
							<div class='col-md-12'>
								<button type="submit" class="btn btn-primary btn-sm">Simpan</button>
								<input button type="Button" class="btn btn-danger btn-sm" value="Batal" onClick="history.back()" />
							</div>
					</div>
				</div>
				</form>
			</font>
	<?php
		} else {
			echo "<script>alert('Anda tidak berhak !');history.go(-1) </script>";
		}
	}
} else {

	?>

	<?php
	include 'cek_akses.php';
	if ($aksesok == 'Y') {
	?>

		<font face="calibri">
			<div class="panel panel-info">
				<div class="panel-heading">
					<font size="4">KASIR PENGELUARAN UANG</font>
				</div>
				<div class="panel-body">
					<form method='get'>
						<div class="row">
							<?php
							// include('hal_get.php')
							?>
							<div class="col-md-4 bg">
								<!-- <input type="hidden" name="m" value="beli">
								<input type='text' id='kata' name='kata' value="<?= $kata ?>" size='50px' class='form-control' placeholder='NO.BELI, SUPPLIER' onkeyup='searchTable()'>
							</div>
							<button type='submit' class='btn btn-primary'>
								<span class='glyphicon glyphicon-search'></span> Cari</button> -->
								<a class="btn btn-primary btn-sm" href="?m=kasir_keluar&tipe=tambah"><i class="fa fa-plus"></i> Tambah data</a>
							</div>
						</div>
					</form>
					</br>
					<div class="box-body table-responsive">
						<!-- <table id="example1" class="table table-bordered table-striped"> -->
						<table id="tbl-kasir_keluar" class="table table-bordered table-striped table-hover">
							<thead>
								<tr>
									<th width='30'>No.</th>
									<th width='80'>No.Kwitansi</th>
									<th width='60'>Tgl.Kwitansi</th>
									<th width='100'>Jenis</th>
									<th width='90'>Cara Bayar</th>
									<th width='80'>Total</th>
									<th width='20'>Prs</th>
									<th width='20'>Btl</th>
									<th width='330'>Aksi</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>
				<?php
			} else {
				echo "<font color='red'>Anda tidak punya hak !</font>";
			} ?>
			<?php
		}
			?>

			<!-- Modal -->
			<!-- <div class="modal fade" id="modaldetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel1">Detail Data</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						</div>
					</div>
				</div>
			</div> -->

			<script src="js/jquery.min.js" type="text/javascript"></script>
			<script type="text/javascript">
				$(document).ready(function() {
					$('#kdjnkeluar').on('blur', function(e) {
						let cari = $(this).val();
						$.ajax({
							url: 'repl_jnkeluar.php',
							type: 'post',
							data: {
								data_jnkeluar: cari
							},
							success: function(response) {
								let data_response = JSON.parse(response);
								if (!data_response) {
									$('#kdjnkeluar').val('');
									$('#nmjnkeluar').val('');
									cari_data_jnkeluar();
									return;
								}
								$('#kdjnkeluar').val(data_response['kode']);
								$('#nmjnkeluar').val(data_response['nama']);
								//console.log(data_response['nama']);
							},
							error: function() {
								console.log('file not fount');
							}
						})
						// console.log(cari);
					})
				})

				function lihat_detail(id) {
					$('#modaldetail').modal('show');
					//$('#modaldetail').find('.modal-body').html(id);
					$.ajax({
						url: './module/kasir_keluar/lihat_detail.php',
						type: 'post',
						data: {
							kode: id
						},
						success: function(response) {
							$('#modaldetail').find('.modal-body').html(response);
						}
					});
				}
			</script>

			<script>
				function alert_hapus_detail($id) {
					swal({
							title: "Yakin akan dihapus ?",
							text: "Once deleted, you will not be able to recover this data!",
							icon: "warning",
							buttons: true,
							dangerMode: true,
						})
						.then((willDelete) => {
							if (willDelete) {
								$href = "module/kasir_keluar/proses_hapus_detail.php?id=";
								window.location.href = $href + $id;
								// swal("Poof! Your imaginary file has been deleted!", {
								//   icon: "success",
								// });
							} else {
								//swal("Batal Hapus!");
							}
						});
				};
			</script>

			<script>
				function alert_hapus($id) {
					swal({
							title: "Yakin akan dihapus ?",
							text: "Once deleted, you will not be able to recover this data!",
							icon: "warning",
							buttons: true,
							dangerMode: true,
						})
						.then((willDelete) => {
							if (willDelete) {
								$href = "module/kasir_keluar/proses_hapus.php?id=";
								window.location.href = $href + $id;
								// swal("Poof! Your imaginary file has been deleted!", {
								//   icon: "success",
								// });
							} else {
								//swal("Batal Hapus!");
							}
						});
				};
			</script>
			<script>
				$(document).ready(function() {
					$('#tbl-detail-kasir_keluar').DataTable({
						// destroy: true,
						"aLengthMenu": [
							[5, 50, 100, -1],
							[5, 50, 100, "All"]
						],
						"iDisplayLength": 5
					})
					var table = $('#tbl-kasir_keluar').DataTable({
						destroy: true,
						"aLengthMenu": [
							[5, 50, 100, -1],
							[5, 50, 100, "All"]
						],
						"iDisplayLength": 5,
						"processing": true,
						"serverSide": true,
						"ajax": "datakasir_keluar.php",
						"columnDefs": [{
								"targets": 0,
								"data": null,
								"orderable": false,
								"searchable": false,
								"className": "text-center",
								// "render": function(data, type, row, meta) {
								// 	var html = meta.row + meta.settings._iDisplayStart + 1
								// 	return html
								// },
								render: function(data, type, row, meta) {
									return meta.row + meta.settings._iDisplayStart + 1;
								}
							},
							{
								"targets": 8,
								"data": null,
								"render": function(data, type, row) { // Tampilkan kolom aksi
									var html = "";
									// var html = "<a class='btn btn-success btn-xs' href='?m=jual&tipe=detail_proses&nojual=$k[nojual]&kdcustomer=$k[kdcustomer]'>Detail</a> ";
									// var html = '<button type="button" class="btn btn-success btn-xs dt-view" style="margin-right:10px;"><span class="glyphicon glyphicon-eye-open glyphicon-info-sign" aria-hidden="true"></span></button>';
									html += '<button type="button" class="btn btn-success btn-xs tblEdit" style="margin-right:10px;"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>H</button>';
									html += '<button type="button" class="btn btn-info btn-xs dt-detail" style="margin-right:10px;"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>D</button>';
									html += '<button type="button" class="btn btn-danger btn-xs dt-delete" style="margin-right:10px;"><span class="glyphicon glyphicon-remove glyphicon-trash" aria-hidden="true">';
									html += '<button type="button" class="btn btn-warning btn-xs dt-proses" style="margin-right:10px;"><span class="glyphicon glyphicon-circle-arrow-right" aria-hidden="true">';
									html += '<button type="button" class="btn btn-danger btn-xs dt-unproses" style="margin-right:10px;"><span class="glyphicon glyphicon-circle-arrow-left" aria-hidden="true">';
									html += '<button type="button" class="btn btn-default btn-xs dt-cetak" style="margin-right:10px;"><span class="glyphicon glyphicon-print" aria-hidden="true">';
									// html += '<button type="button" class="btn btn-default btn-xs dt-cetak-fp" style="margin-right:10px;"><span class="glyphicon glyphicon-print" aria-hidden="true"> FP';
									return html
								}
							},
						],
						order: [
							[0, 'asc'],
							[1, 'desc'],
							[2, 'asc'],
							[3, 'asc'],
							[4, 'asc'],
						],
					});
					$('#tbl-kasir_keluar tbody').on('click', '.dt-view', function() {
						var data = table.row($(this).parents('tr')).data();
						window.location.href = "?m=kasir_keluar&tipe=detail_proses&id=" + data[9]
					});
					$('#tbl-kasir_keluar tbody').on('click', '.tblEdit', function() {
						var data = table.row($(this).parents('tr')).data();
						if (data[10] == "Y") {
							swal({
								title: "Data sudah batal !",
								text: "Aksi tidak bisa dilanjutkan",
								icon: "error"
							})
							exit();
						}
						if (data[8] == "N") {
							window.location.href = "?m=kasir_keluar&tipe=edit&id=" + data[9]
						} else {
							swal({
								title: "Data sudah di proses !",
								text: "Data sudah di proses, aksi tidak bisa dilanjutkan",
								icon: "error"
							})
						}
					});
					$('#tbl-kasir_keluar tbody').on('click', '.dt-detail', function() {
						var data = table.row($(this).parents('tr')).data();
						if (data[10] == "Y") {
							swal({
								title: "Data sudah batal !",
								text: "Aksi tidak bisa dilanjutkan",
								icon: "error"
							})
							exit();
						}
						if (data[8] == "N") {
							window.location.href = "?m=kasir_keluar&tipe=detail&id=" + data[9]
						} else {
							swal({
								title: "Data sudah di proses !",
								text: "Data sudah di proses, aksi tidak bisa dilanjutkan",
								icon: "error"
							})
						}
					});

					$('#tbl-kasir_keluar tbody').on('click', '.dt-delete', function() {
						//var data = table.row( $(this).parents('tr') ).data();
						//var id = $(this).attr("id");
						var data = table.row($(this).parents('tr')).data();
						var id = data[9];
						if (data[8] == "Y") {
							swal({
								title: "Data sudah di proses !",
								text: "Data sudah di proses, aksi tidak bisa dilanjutkan",
								icon: "error"
							})
							exit();
						}
						if (data[10] == "Y") {
							swal({
									title: "Data sudah batal !",
									text: "Yakin akan dilanjutkan ?",
									icon: "error"
								})
								.then((willDelete) => {
									if (willDelete) {
										//alert($kode);
										$href = "module/kasir_keluar/proses_hapus.php?id=";
										window.location.href = $href + id;
										// swal("kasir_keluarof! Your imaginary file has been deleted!", {
										//   icon: "success",
										// });
									} else {
										//swal("Batal Hapus!");
									}
								});
						} else {
							swal({
									title: "Yakin akan batalkan ?",
									text: "",
									icon: "warning",
									buttons: true,
									dangerMode: true,
								})
								.then((willDelete) => {
									if (willDelete) {
										//alert($kode);
										$href = "module/kasir_keluar/proses_hapus.php?id=";
										window.location.href = $href + id;
										// swal("kasir_keluarof! Your imaginary file has been deleted!", {
										//   icon: "success",
										// });
									} else {
										//swal("Batal Hapus!");
									}
								});
						}
					});

					$('#tbl-kasir_keluar tbody').on('click', '.dt-proses', function() {
						var data = table.row($(this).parents('tr')).data();
						var id = data[9];
						if (data[10] == "Y") {
							swal({
								title: "Data sudah batal !",
								text: "Aksi tidak bisa dilanjutkan",
								icon: "error"
							})
							exit();
						}
						if (data[8] == "Y") {
							swal({
								title: "Data sudah di proses !",
								text: "Data sudah di proses, aksi tidak bisa dilanjutkan",
								icon: "error"
							})
							exit();
						}
						swal({
								title: "Yakin akan diproses ?",
								text: "",
								icon: "warning",
								buttons: true,
								dangerMode: true,
							})
							.then((willDelete) => {
								if (willDelete) {
									$href = "module/kasir_keluar/proses.php?id=";
									window.location.href = $href + id;
									// swal("kasir_keluarof! Your imaginary file has been deleted!", {
									//   icon: "success",
									// });
								} else {
									//swal("Batal Hapus!");
								}
							});
					});

					$('#tbl-kasir_keluar tbody').on('click', '.dt-unproses', function() {
						var data = table.row($(this).parents('tr')).data();
						var id = data[9];
						if (data[10] == "Y") {
							swal({
								title: "Data sudah batal !",
								text: "Aksi tidak bisa dilanjutkan",
								icon: "error"
							})
							exit();
						}
						if (data[8] == "N") {
							swal({
								title: "Data belum diproses !",
								text: "Data belum diproses, aksi tidak bisa dilanjutkan",
								icon: "error"
							})
							exit();
						}
						swal({
								title: "Yakin akan di Batal Proses ?",
								text: "",
								icon: "warning",
								buttons: true,
								dangerMode: true,
							})
							.then((willDelete) => {
								if (willDelete) {
									$href = "module/kasir_keluar/batal_proses.php?id=";
									window.location.href = $href + id;
									// swal("kasir_keluarof! Your imaginary file has been deleted!", {
									//   icon: "success",
									// });
								} else {
									//swal("Batal Hapus!");
								}
							});
					});

					$('#tbl-kasir_keluar tbody').on('click', '.dt-cetak', function() {
						var data = table.row($(this).parents('tr')).data();
						var id = data[9];
						if (data[8] == "N") {
							swal({
								title: "Data belum diproses !",
								text: "Data belum diproses, aksi tidak bisa dilanjutkan",
								icon: "error"
							})
							exit();
						}
						swal({
								title: "Yakin akan di Cetak ?",
								text: "",
								icon: "warning",
								buttons: true,
								dangerMode: true,
							})
							.then((willCetak) => {
								if (willCetak) {
									$href = "module/kasir_keluar/cetak.php?id=";
									window.open($href + id, "_blank");
									// window.location.href = $href + id, "_blank";
									// swal("Poof! Your imaginary file has been deleted!", {
									//   icon: "success",
									// });
								} else {
									//swal("Batal Hapus!");
								}
							});
					});
				});
			</script>