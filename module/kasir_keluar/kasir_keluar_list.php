<?php
$user = $_SESSION['username'];

function autoNumber($connect, $id, $table)
{
	//$query = 'SELECT MAX(RIGHT('.$id.', 4)) as max_id FROM '.$table.' ORDER BY '.$id;
	mysqli_query($connect, 'alter table ' . $table . ' AUTO_INCREMENT=0');
	$query = 'select id as max_id from ' . $table . ' order by id desc';
	$result = mysqli_query($connect, $query);
	$data = mysqli_fetch_array($result);
	$id_max = $data['max_id'];
	$sort_num = $id_max; //(int) substr($id_max, 1, 4);
	$sort_num++;
	date_default_timezone_set("Asia/Jakarta");
	$tgl = date('m-d-Y');
	$year = date('Y');
	$month = date('M');
	$nmonth = date('m');
	$new_code = 'KK' . $year . $nmonth . sprintf("%05s", $sort_num);
	return $new_code;
}

if (isset($_GET['tipe'])) {
	if ($_GET['tipe'] == 'detail_proses') {
		cekakses($connect, $user, 'Kasir Pengeluaran Uang');
		$lakses = $_SESSION['aksespakai'];
		if ($lakses == 1) {
			// $query = $connect->prepare("select * from kasir_keluarh where nokwitansi=?");
			// $query->bind_param('s',$_GET['nokwitansi']);
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
									// $tampil = mysqli_query($connect, "select * from kasir_keluard where nokwitansi='$_GET[nokwitansi]'");
									// $query = $connect->prepare("select * from kasir_keluard where nokwitansi=?");
									// $query->bind_param('s', $_GET['nokwitansi']);
									// $query->execute();
									// $result = $query->get_result();
									// $de = $result->fetch_assoc();
									$sql = mysqli_query($connect, "select * from kasir_keluard where nokwitansi='$_GET[nokwitansi]'");
									$de = mysqli_fetch_assoc($sql);
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
		$jnkeluar = strip_tags($de['kdjnkeluar']) . '|' . strip_tags($de['nmjnkeluar']);
		if ($lakses == 1) { ?>
			<font face='calibri'>
				<div class='panel panel-danger'>
					<div class='panel-heading'>
						<font size="4">TAMBAH DATA DETAIL KASIR PENGELUARAN UANG</font>
					</div>
					<div class='panel-body'>
						<form method='post' name='so' enctype='multipart/form-data' action='module/kasir_keluar/proses_tambah_detail.php'>
							<input type='hidden' name='username' value="<?= $user ?>">
							<input type='hidden' name='tglkwitansi' value="<?= $tglkwitansi ?>">
							<div class='col-md-6'>
								<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
									<form method='post' enctype='multipart/form-data' action='module/kasir_keluar/proses_tambah_detail.php'>
										<input type='hidden' name='username' value='<?= $user ?>'>
										<input type='hidden' name='nokwitansi' value='<?= $_GET['nokwitansi'] ?>'>

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
																<button type='button' id='src' class='btn btn-primary' onclick='cari_data_hutang()'>
																	Cari
																</button>
															</span>
													</td>
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
													// $tampil = mysqli_query($connect, "select * from kasir_keluard where nokwitansi='$_GET[nokwitansi]'");
													// $query = $connect->prepare("select * from kasir_keluard where nokwitansi=?");
													// $query->bind_param('s', $_GET['nokwitansi']);
													// $query->execute();
													// $result = $query->get_result();
													// $de = $result->fetch_assoc();
													$sql = mysqli_query($connect, "select * from kasir_keluard where nokwitansi='$_GET[nokwitansi]'");
													$de = mysqli_fetch_assoc($sql);
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
														echo "<a class='btn btn-primary' href='?m=kasir_keluar&tipe=edit_detail&id=$k[id]&nokwitansi=$k[nokwitansi]'>Edit</a> ";
														echo " <input button type='Button' class='btn btn-danger' value='Hapus' onClick='alert_hapus_detail($k[id])'/>";
														$no++;
													}
													$tampil = mysqli_query($connect, "select sum(uang) as total_subtotal from kasir_keluard where nokwitansi='$_GET[nokwitansi]'");
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
													// $tampil = mysqli_query($connect, "select * from kasir_keluard where nokwitansi='$_GET[nokwitansi]'");
													// $query = $connect->prepare("select * from kasir_keluard where nomohon=?");
													// $query->bind_param('s', $_GET['nomohon']);
													// $query->execute();
													// $result = $query->get_result();
													// $de = $result->fetch_assoc();
													$sql = mysqli_query($connect, "select * from kasir_keluard where nokwitansi='$_GET[nokwitansi]'");
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
														echo "<a class='btn btn-primary' href='?m=kasir_keluar&tipe=edit_detail&id=$k[id]&nomohon=$k[nomohon]'>Edit</a> ";
														echo " <input button type='Button' class='btn btn-danger' value='Hapus' onClick='alert_hapus_detail($k[id])'/>";
														$no++;
													}
													$tampil = mysqli_query($connect, "select sum(uang) as total_subtotal from kasir_keluard where nomohon='$_GET[nomohon]'");
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
					Nilai Bayar<input type="number" class='form-control' id='uang' name='uang' value='<?= $uang ?>' style='width: 10em'>
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
				<div class='panel panel-danger'>
					<div class='panel-heading'>
						<font size="4">TAMBAH DATA KASIR PENGELUARAN UANG</font>
					</div>
					<div class='panel-body'>
						<form method='post' name='so' enctype='multipart/form-data' action='module/kasir_keluar/proses_tambah.php'>
							<input type='hidden' name='username' value="<?= $user ?>">
							<div class='col-md-6'>
								<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
									<tr>
										<td>Nomor Kwitansi</td>
										<td>
											<input type='text' class='form-control' id='nokwitansi' name='nokwitansi' id='nokwitansi' placeholder='No. Kwitansi *' style='text-transform:uppercase' value="<?php echo autoNumber($connect, 'id', 'kasir_keluarh'); ?>" readonly>
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
									<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
										<td>Cara Bayar
										<td><input type="radio" name="carabayar" value="Cash"> Cash
										<td><input type="radio" name="carabayar" value="Transfer"> Transfer
										<td><input type="radio" name="carabayar" value="Cek/Giro"> Cek/Giro
										<td><input type="radio" name="carabayar" value="Debit Card"> Debit Card
										<td><input type="radio" name="carabayar" value="Credit Card" required> Credit Card
									</table>
								</table>
							</div>
							<div class='col-md-6'>
								<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
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
										<td> <input type="number" class='form-control' name='materai' id='materai' size='50' value='0' onkeyup="hit_total()" onblur="hit_total()"></td>
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
		?>
			<font face='calibri'>
				<div class="panel panel-default">
					<div class="panel-heading">
						<font size="4">EDIT DATA KASIR PENGELUARAN UANG</font>
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
									<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
										<td>Cara Bayar
										<td><input type="radio" name="carabayar" value="Cash" <?php echo ($carabayar == 'Cash') ? 'checked' : '' ?>> Cash
										<td><input type="radio" name="carabayar" value="Transfer" <?php echo ($carabayar == 'Transfer') ? 'checked' : '' ?>> Transfer
										<td><input type="radio" name="carabayar" value="Cek/Giro" <?php echo ($carabayar == 'Cek/Giro') ? 'checked' : '' ?>> Cek/Giro
										<td><input type="radio" name="carabayar" value="Debit Card" <?php echo ($carabayar == 'Debit Card') ? 'checked' : '' ?>> Debit Card
										<td><input type="radio" name="carabayar" value="Credit Card" <?php echo ($carabayar == 'Credit Card') ? 'checked' : '' ?>> Credit Card
									</table>
								</table>
							</div>
							<div class='col-md-6'>
								<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
									<tr>
										<td></td>
										<td><input type="text" class='form-control' name='nmjnkeluar' id='nmjnkeluar' size='50' value='<?= $nmjnkeluar ?>' readonly required></td>
									</tr>
									<tr>
										<td>Subtotal</td>
										<td> <input type="number" class='form-control' name='subtotal' id='subtotal' size='50' value='<?= $subtotal ?>' readonly></td>
									</tr>
									<tr>
										<td>Materai</td>
										<td> <input type="number" class='form-control' name='materai' id='materai' size='50' value='<?= $materai ?>' onkeyup="hit_total()" onblur="hit_total()"></td>
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
							<div class='col-md-12'>
								<button type="submit" class="btn btn-primary">Simpan</button>
								<input button type="Button" class="btn btn-danger" value="Batal" onClick="history.back()" />
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
					<form method='post'>
						<div class="row">
							<div class="col-md-12 bg">
								<a class="btn btn-danger" href="?m=kasir_keluar&tipe=tambah">Tambah data</a>
								<!--<a class="btn btn-success" href="?m=kasir_keluar&tipe=import">Import data</a>
				<a class="btn btn-warning" href="?m=kasir_keluar&tipe=export">Export data</a>-->
							</div>
						</div>
					</form>
					</br>
					<div class="box-body table-responsive">
						<table id="example1" class="table table-bordered table-striped">
							<thead>
								<tr>
									<th width='50'>No.</th>
									<th>No. Kwitansi</th>
									<th>Tgl. Kwitansi</th>
									<th>Materai</th>
									<th>Total</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<?php
							$tampil = mysqli_query($connect, "SELECT * FROM kasir_keluarh order by nokwitansi desc");
							$no = 1;
							while ($k = mysqli_fetch_assoc($tampil)) {
								$date = date("m/d/Y", strtotime($k['tglkwitansi']));
								$materai = number_format($k['materai'], 0, ",", ".");
								$total = number_format($k['total'], 0, ",", ".");
								echo "<tr>
	        <td align='center'>$no</td>
					<td width='110'><u><a href='#' onclick =lihat_detail('$k[nokwitansi]');><font color='blue'>$k[nokwitansi]</font></a></u></td>
					<td width='80'>$date</td>
					<td width='6'>$materai</td>
					<td width='110' align='right'>$total</td>
					<td align='center' width='350px'>";
								//echo "<a class='btn btn-success' href='?m=kasir_keluar&tipe=detail&id=$k[id]'>Upd.Dtl</a> ";
								if ($k['proses'] == 'Y') {
									echo "<a class='btn btn-success' href='?m=kasir_keluar&tipe=detail_proses&nokwitansi=$k[nokwitansi]'>Detail</a> ";
								} else {
									echo "<a class='btn btn-success' href='?m=kasir_keluar&tipe=detail&nokwitansi=$k[nokwitansi]'>Detail</a> ";
								}
								if ($k['proses'] == 'Y') {
									echo "<a class='btn btn-info' href='?m=kasir_keluar&tipe=edit&id=$k[id]' disabled>Edit</a>";
								} else {
									echo "<a class='btn btn-info' href='?m=kasir_keluar&tipe=edit&id=$k[id]'>Edit</a>";
								}
								cekakses($connect, $user, 'Kasir Pengeluaran Uang');
								$lakses = $_SESSION['akseshapus'];
								if ($lakses == 1) {
									if ($k['proses'] == 'Y') {
										echo " <input button type='Button' class='btn btn-danger' value='Hapus' onClick='alert_hapus($k[id])' disabled/>";
									} else {
										/*echo " <a class='btn btn-danger' href='module/po/proses_hapus.php?id=$k[id]&kode=$k[kode]'
							onClick='return confirm(\"Anda yakin akan menghapus ?\")'>Hapus</a>";**/
										echo " <input button type='Button' class='btn btn-danger' value='Hapus' onClick='alert_hapus($k[id])'/>";
									}
								}
								cekakses($connect, $user, 'Kasir Pengeluaran Uang');
								$lakses = $_SESSION['aksesproses'];
								if ($lakses == 1) {
									/*echo " <a class='btn btn-danger' href='module/wo/proses_hapus.php?id=$k[id]&kode=$k[kode]'
						onClick='return confirm(\"Anda yakin akan menghapus ?\")'>Hapus</a>";**/
									if ($k['proses'] == 'Y') {
										echo " <input button type='Button' class='btn btn-danger' value='Proses' onClick='alert_proses($k[id])' disabled/>";
									} else {
										echo " <input button type='Button' class='btn btn-danger' value='Proses' onClick='alert_proses($k[id])'/>";
									}
								}
								cekakses($connect, $user, 'Kasir Pengeluaran Uang');
								$lakses = $_SESSION['aksesunproses'];
								if ($lakses == 1) {
									/*echo " <a class='btn btn-danger' href='module/po/proses_hapus.php?id=$k[id]&kode=$k[kode]'
						onClick='return confirm(\"Anda yakin akan menghapus ?\")'>Hapus</a>";**/
									if ($k['proses'] == 'N') {
										echo " <input button type='Button' class='btn btn-danger' value='UnProses' onClick='alert_unproses($k[id])' disabled />";
									} else {
										echo " <input button type='Button' class='btn btn-danger' value='UnProses' onClick='alert_unproses($k[id])'/>";
									}
								}
								cekakses($connect, $user, 'Kasir Pengeluaran Uang');
								$lakses = $_SESSION['aksescetak'];
								if ($lakses == 1) {
									if ($k['proses'] == 'N') {
										echo " <button type='button' class='btn btn-info' onClick='alert_cetak($k[id])' disabled/>
							    <span class='glyphicon glyphicon-print'></span>
							  </button>";
									} else {
										echo " <button type='button' class='btn btn-info' onClick='alert_cetak($k[id])'/>
							    <span class='glyphicon glyphicon-print'></span>
							  </button>";
									}
								}
								echo "</td>";
								$no++;
							}
							?>
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
			<div class="modal fade" id="modaldetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
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
			</div>

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
				function alert_proses($id) {
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
				function alert_unproses($id) {
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

			<script type="text/javascript">
				function hit_subtotal() {
					var lharga = (parseInt(document.getElementById('qty').value) * parseInt(document.getElementById('harga').value));
					var ldisc = lharga - (lharga * (document.getElementById('discount').value)) / 100;
					var lsubtotal = ldisc;
					document.getElementById('subtotal').value = lsubtotal;
				}
			</script>

			<script type="text/javascript">
				function eraseText() {
					document.getElementById("kdbarang").value = "";
					document.getElementById("nmbarang").value = "";
					document.getElementById("satuan").value = "";
					document.getElementById("qty").value = "";
					document.getElementById("harga").value = "";
					document.getElementById("discount").value = "";
					document.getElementById("subtotal").value = "";
				}

				function hit_total() {
					var lmaterai = parseInt(document.getElementById('subtotal').value);
					var lmaterai = parseInt(document.getElementById('materai').value);
					var ltotal = lsubtotal + lmaterai
					document.getElementById('total').value = ltotal;
				}
			</script>

			<script>
				function alert_cetak($id) {
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
								window.open($href + $id, "_blank");
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