<?php
$user = $_SESSION['username'];
include "autonumber.php";

if (isset($_GET['tipe'])) {
	if ($_GET['tipe'] == 'detail_proses') {
		cekakses($connect, $user, 'Penerimaan Barang');
		$lakses = $_SESSION['aksespakai'];
		if ($lakses == 1) {
			// $query = $connect->prepare("select * from terimah where noterima=?");
			// $query->bind_param('s', $_GET['noterima']);
			// $query->execute();
			// $result = $query->get_result();
			// $de = $result->fetch_assoc();
			$sql = mysqli_query($connect, "select * from terimah where id='$_GET[id]'");
			$de = mysqli_fetch_assoc($sql);
			$noterima = strip_tags($de['noterima']);
			$proses = strip_tags($de['proses']);
			$tglterima = strip_tags($de['tglterima']); ?>
			<font face='calibri'>
				<h3>DETAIL PENERIMAAN BARANG</h3>
				<form method='post' enctype='multipart/form-data' action='module/terima/proses_tambah_detail.php'>
					<input type='hidden' name='username' value='<?= $user ?>'>
					<table class="table table-bordered table-striped table-hover">
						<tr>
							<td>Nomor Order</td>
							<td>
								<input type='text' class='form-control' id='noterima' name='noterima' placeholder='No.  Penerimaan*' style='text-transform:uppercase' value="<?= $noterima ?>" readonly>
							</td>
							<td>Tgl. (M/D/Y)</td>
							<td><input type='date' class='form-control' id='tglterima' name='tglterima' value="<?= $tglterima ?>" size='50' autocomplete='off' readonly></td>
						</tr>
					</table>

					<div class="table-responsive">
						<table class="table table-bordered table-striped table-hover">
							<tr>
								<th width='50'>No.</th>
								<th width='170'>Kode Barang</th>
								<th>Nama Barang</th>
								<th>Satuan</th>
								<th>QTY</th>
								<th>harga</th>
								<th>Subtotal</th>
							</tr>
							<?php
							// $tampil = mysqli_query($connect, "select * from terimad where noterima='$_GET[noterima]'");
							// $query = $connect->prepare("select * from terimad where noterima=?");
							// $query->bind_param('s', $_GET['noterima']);
							// $query->execute();
							// $result = $query->get_result();
							// $de = $result->fetch_assoc();
							$sql = mysqli_query($connect, "select * from terimad where noterima='$_GET[noterima]'");
							$de = mysqli_fetch_assoc($sql);
							$kdbarang = strip_tags($de['kdbarang']);
							$nmbarang = strip_tags($de['nmbarang']);
							$no = 1;
							//<td><u><a href='?m=wo&tipe=detail&id=$k[id]'><font color='blue'>$k[kode]</font></a></u></td>
							//<td><u><a href='#' onclick =lihat_detail('$k[id]');><font color='blue'>$k[kdbarang]</font></a></u></td>
							while ($k = mysqli_fetch_assoc($tampil)) {
								//$date = date("m/d/Y", strtotime($k['tglwo']));
								$qty = number_format($de['qty'], 2, ",", ".");
								$harga = number_format($de['harga'], 0, ",", ".");
								$subtotal = number_format($de['subtotal'], 0, ",", ".");
								echo "<tr><td align='center'>$no</td>
									<td width='100'>$k[kdbarang]</td>
									<td width='300'>$k[nmbarang]</td>
									<td width='80'>$k[kdsatuan]</td>
									<td align='right' width='70'>$qty</td>
									<td align='right' width='100'>$harga</td>
									<td align='right'>$subtotal</td>";
								$no++;
							}
							$tampil = mysqli_query($connect, "select sum(qty) as total_qty,sum(subtotal) as total_subtotal from terimad where noterima='$_GET[noterima]'");
							$jum = mysqli_fetch_assoc($tampil);
							$total_qty = $jum['total_qty'];
							$total = $jum['total_subtotal'];
							$total = number_format($total, 0, ",", ".");
							echo "<tr><td colspan='4'></td>
							<td align='right' style='font-weight:bold'>$total_qty</td>
							<td colspan='1' align='right'></td>
							<td align='right' style='font-weight:bold'>$total</td>";
							?>
						</table>
					</div>
					<input button type='Button' class='btn btn-danger' value='Close' onClick='history.back()' />
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
		cekakses($connect, $user, 'Penerimaan Barang');
		$lakses = $_SESSION['aksespakai'];
		if ($lakses == 1) {
			// $query = $connect->prepare("select * from terimah where id=?");
			// $query->bind_param('s', $_GET['id']);
			// $query->execute();
			// $result = $query->get_result();
			// $de = $result->fetch_assoc();
			$sql = mysqli_query($connect, "select * from terimah where id='$_GET[id]'");
			$de = mysqli_fetch_assoc($sql);
			$noterima = strip_tags($de['noterima']);
			$proses = strip_tags($de['proses']);
			$tglterima = strip_tags($de['tglterima']); ?>

			<font face='calibri'>
				<div class='panel panel-info'>
					<div class='panel-heading'>
						<font size="4">DATA DETAIL PENERIMAAN BARANG</font>
					</div>
					<div class='panel-body'>
						<form method='post' name='so' enctype='multipart/form-data' action='module/terima/proses_tambah_detail.php'>
							<input type='hidden' name='username' value="<?= $user ?>">
							<div class='col-md-10'>
								<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
									<tr>
										<td>Nomor Terima</td>
										<td>
											<input type='text' class='form-control' id='noterima' name='noterima' placeholder='No. SO *' style='text-transform:uppercase' value="<?= $noterima ?>" readonly>
										</td>
										<td>Tgl. (M/D/Y)</td>
										<td><input type='date' class='form-control' id='tglterima' name='tglterima' value="<?= $tglterima ?>" size='50' autocomplete='off' readonly></td>
									</tr>
								</table>
							</div>
							<div class='col-md-12'>
								<table style=font-size:12px; class='table table-striped table table-bordered' width='600px'>
									<tr>
										<th>Kode Barang <input type="button" class='btn btn-black' value="Clear" onclick="eraseText()"></th>
										<th>Barang</th>
										<th>QTY</th>
										<th>Harga</th>
										<th>Subtotal</th>
										<th>Aksi</th>
									</tr>
									<td>
										<div class='input-group'> <input type='text' class='form-control' style='width: 9em' id='kdbarang' name='kdbarang' size='50' autocomplete='off' required>
											<span class='input-group-btn'>
												<button type='button' id='src' class='btn btn-primary' onclick='cari_data_barang_beli()'>
													Cari
												</button>
											</span>
									</td>
									</td>
									<td><input type='text' class='form-control' style='width: 15em' id='nmbarang' name='nmbarang' readonly></td>
									</td>
									<td><input type="text" class='form-control' id='qty' name='qty' value="0.00" style='width: 6em' required onkeyup="validAngka(this)" onblur="hit_subtotal()"></td>
									</td>
									<td><input type="text" class='form-control' value='0' id='harga' name='harga' style='width: 7em' onkeyup="validAngka_no_titik(this)" onblur="hit_subtotal()"></td>
									</td>
									<td><input type="number" class='form-control' value='0' id='subtotal' name='subtotal' style='width: 10em' readonly></td>
									<td align='center' width='50px'>
										<button type='submit' class='btn btn-primary'>+</button>
								</table>

							</div>

							<div class='col-md-12'>
								<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
									<tr>
										<th width='50'>No.</th>
										<th width='170'>Kode Barang</th>
										<th>Nama Barang</th>
										<th>Satuan</th>
										<th>QTY</th>
										<th>harga</th>
										<th>Subtotal</th>
										<th>Aksi</th>
									</tr>
									<?php
									$tampil = mysqli_query($connect, "select * from terimad where noterima='$noterima'");
									// $query = $connect->prepare("select * from terimad where noterima=?");
									// $query->bind_param('s', $noterima);
									// $query->execute();
									// $result = $query->get_result();
									// $de = $result->fetch_assoc();
									$no = 1;
									//<td><u><a href='?m=wo&tipe=detail&id=$k[id]'><font color='blue'>$k[kode]</font></a></u></td>
									while ($k = mysqli_fetch_assoc($tampil)) {
										$kdbarang = strip_tags($k['kdbarang']);
										$nmbarang = strip_tags($k['nmbarang']);
										$qty = number_format($k['qty'], 2, ",", ".");
										$harga = number_format($k['harga'], 0, ",", ".");
										$subtotal = number_format($k['subtotal'], 0, ",", ".");
										//$date = date("m/d/Y", strtotime($k['tglwo']));
										echo "<tr><td align='center'>$no</td>
								<td><u><a href='#' onclick =lihat_detail('$k[id]');><font color='blue'>$k[kdbarang]</font></a></u></td>
								<td width='300'>$k[nmbarang]</td>
								<td width='80'>$k[kdsatuan]</td>
								<td align='right' width='70'>$qty</td>
								<td align='right' width='100'>$harga</td>
								<td align='right' width='100'>$subtotal</td>
								<td align='center' width='145px'>";
										echo "<a class='btn btn-success btn-sm' href='?m=terima&tipe=edit_detail&id=$k[id]&noterima=$k[noterima]'>Edit</a> ";
										echo " <input button type='Button' class='btn btn-danger btn-sm' value='Hapus' onClick='alert_hapus_detail($k[id])'/>";
										$no++;
									}
									$tampil = mysqli_query($connect, "select sum(qty) as total_qty,sum(subtotal) as total_subtotal from terimad where noterima='$noterima'");
									$jum = mysqli_fetch_assoc($tampil);
									$total_qty = $jum['total_qty'];
									$total_qty = number_format($total_qty, 2, ",", ".");
									$total = $jum['total_subtotal'];
									$total = number_format($total, 0, ",", ".");
									echo "<tr><td colspan='4'></td>
							<td align='right' style='font-weight:bold'>$total_qty</td>
							<td colspan='1' align='right'></td>
							<td align='right' style='font-weight:bold'>$total</td>";
									?>
								</table>
							</div>
							<div class='col-md-12'>
								<!--<input button type='Button' class='btn btn-danger' value='Close' onClick='history.back()'/>-->
								<input button type='Button' class='btn btn-danger' value='Close' onClick="window.location = 'dashboard.php?m=terima'" />
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
		cekakses($connect, $user, 'Penerimaan Barang');
		$lakses = $_SESSION['aksespakai'];
		if ($lakses == 1) {
			// $query = $connect->prepare("select * from terimah where noterima=?");
			// $query->bind_param('s', $_GET['noterima']);
			// $query->execute();
			// $result = $query->get_result();
			// $de = $result->fetch_assoc();
			$sql = mysqli_query($connect, "select * from terimah where noterima='$_GET[noterima]'");
			$de = mysqli_fetch_assoc($sql);
			$noterima = strip_tags($de['noterima']);
			$tglterima = strip_tags($de['tglterima']); ?>

			<font face='calibri'>
				<div class='panel panel-default'>
					<div class='panel-heading'>
						<font size="4">EDIT DETAIL DATA PENERIMAAN BARANG</font>
					</div>
					<div class='panel-body'>
						<form method='post' name='terima' enctype='multipart/form-data' action='module/terima/proses_edit_detail.php'>
							<input type='hidden' name='username' value="<?= $user ?>">
							<div class='col-md-12'>
								<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
									<!--<font face='calibri'>
					<h3>Edit Detail PENERIMAAN BARANG</h3>
					<form method='post' enctype='multipart/form-data' action='module/terima/proses_edit_detail.php'>
						<input type='hidden' name='username' value='<?= $user ?>'>
 						<table class="table table-bordered table-striped table-hover">-->
									<tr>
										<td>Nomor Order</td>
										<td>
											<input type='text' class='form-control' id='noterima' name='noterima' placeholder='No. Terima *' style='text-transform:uppercase' value="<?= $noterima ?>" readonly>
										</td>
										<td>Tgl. (M/D/Y)</td>
										<td><input type='date' class='form-control' id='tglterima' name='tglterima' value="<?= $tglterima ?>" size='50' autocomplete='off' readonly></td>
									</tr>
								</table>
							</div>

							<div class='col-md-12'>
								<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
									<tr>
										<th width='170'>Kode Barang <input type="button" class='btn btn-black' value="Clear" onclick="eraseText()"></th>
										<th width='170'>Barang</th>
										<th>Satuan</th>
										<th>QTY</th>
										<th>Harga</th>
										<th>Subtotal</th>
									</tr>
									<?php
									// $query = $connect->prepare("select * from terimad where id=?");
									// $query->bind_param('s', $_GET['id']);
									// $query->execute();
									// $result = $query->get_result();
									// $de = $result->fetch_assoc();
									$sql = mysqli_query($connect, "select * from terimad where id='$_GET[id]'");
									$de = mysqli_fetch_assoc($sql);
									$kdbarang = strip_tags($de['kdbarang']);
									$nmbarang = strip_tags($de['nmbarang']);
									$kdsatuan = strip_tags($de['kdsatuan']);
									$qty = number_format($de['qty'], 2, ",", ",");
									$qty = str_replace(",", ".", $qty);
									$harga = strip_tags($de['harga']);
									$subtotal = strip_tags($de['subtotal']);
									?>
									<input type='hidden' name='id' value='<?= $de['id'] ?>'>
									<input type='hidden' name='noterima' value='<?= $de['noterima'] ?>'>
									<td>
										<div class='input-group'> <input type='text' class='form-control' style='width: 10em' id='kdbarang' name='kdbarang' value='<?= $kdbarang ?>' size='50' autocomplete='off' required readonly>
											<span class='input-group-btn'>
												<!--<button type='button' id='src' class='btn btn-primary' onclick='cari_data_barang()'>
								Cari
							</button>-->
											</span>
									</td>
									</td>
									<td><input type='text' class='form-control' style='width: 16em' id='nmbarang' name='nmbarang' value='<?= $nmbarang ?>' readonly></td>
									</td>
									<td><input type='text' class='form-control' style='width: 4em' id='kdsatuan' name='kdsatuan' value='<?= $kdsatuan ?>' readonly></td>
									</td>
									<td><input type="text" class='form-control' id='qty' name='qty' value='<?= $qty ?>' style='width: 6em' required onkeyup="validAngka(this)" onblur="hit_subtotal()" autofocus='autofocus'></td>
									</td>
									<td align='right'><input type="text" class='form-control' id='harga' name='harga' value='<?= $harga ?>' style='width: 8em' style='align: left' onkeyup="validAngka_no_titik(this)" onblur="hit_subtotal()"></td>
									</td>
									<td><input type="number" class='form-control' id='subtotal' name='subtotal' value='<?= $subtotal ?>' style='width: 9em' readonly></td>
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
	}
}

if (isset($_GET['tipe'])) {
	if ($_GET['tipe'] == 'tambah') {
		cekakses($connect, $user, 'Penerimaan Barang');
		$lakses = $_SESSION['aksestambah'];
		$de = mysqli_fetch_assoc(mysqli_query($connect, "select * from saplikasi where aktif='Y'"));
		$tgl = $de['tgl_berikutnya']; //date('Y-m-d')
		if ($lakses == 1) { ?>
			<font face='calibri'>
				<div class='panel panel-danger'>
					<div class='panel-heading'>
						<font size="4">TAMBAH DATA PENERIMAAN BARANG</font>
					</div>
					<div class='panel-body'>
						<form method='post' name='terima' enctype='multipart/form-data' action='module/terima/proses_tambah.php'>
							<input type='hidden' name='username' value="<?= $user ?>">
							<div class='col-md-6'>
								<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
									<tr>
										<td>Nomor Penerimaan</td>
										<td>
											<input type='text' class='form-control' id='noterima' name='noterima' placeholder='No. Order *' style='text-transform:uppercase' value="<?php echo autoNumberTB($connect, 'id', 'terimah'); ?>" readonly>
										</td>
									</tr>
									<tr>
										<td>Tanggal (M/D/Y)</td>
										<td><input type='date' class='form-control' id='tglterima' name='tglterima' value="<?php echo $tgl ?>" size='50' autocomplete='off' required readonly></td>
									</tr>
									<tr>
										<td>No. Referensi</td>
										<td> <input type="text" class='form-control' id='noreferensi' name='noreferensi' size='50' autocomplete='off' autofocus='autofocus'></td>
									</tr>
									<tr>
										<td>Tgl. Referensi</td>
										<td> <input type="date" class='form-control' id='tgldokumen' name='tgldokumen' size='50' autocomplete='off' autofocus='autofocus'></td>
									</tr>
									<tr>
										<td>Jenis Transaksi
										<td><select id='kdjntrans' name='kdjntrans' class='form-control' style='width: 200x;' onchange='changeValueJntrans(this.value)'>
												<!--<option value=''> - PILIH SATUAN BARANG - </option>";-->
												<?php
												$jsArrayJntrans = "var prdNameJntrans = new Array();\n";
												$data = mysqli_query($connect, "select * from tbjntrans where keterangan='IN' order by nama");
												while ($row = mysqli_fetch_array($data)) {
													echo '<option name="kdjntrans"  value="' . $row['kode'] . '">' . $row['kode'] . '|' . $row['nama'] . '</option>';
													$jsArrayJntrans .= "prdNameJntrans['" . $row['kode'] . "'] = {nmjntrans:'" . addslashes($row['nama']) . "',kdjntrans:'" . addslashes($row['kode']) . "'};\n";
												}
												echo '</select>';
												?>
									<tr>
										<td>Penerima</td>
										<td> <input type="text" class='form-control' name='penerima'></td>
									</tr>
									<tr>
										<td>Gudang
										<td><select id='kdgudang' name='kdgudang' class='form-control' style='width: 200x;' onchange='changeValueGudang(this.value)'>
												<!--<option value=''> - PILIH SATUAN BARANG - </option>";-->
												<?php
												$jsArrayGudang = "var prdNameGudang = new Array();\n";
												$data = mysqli_query($connect, 'select * from tbgudang order by nama');
												while ($row = mysqli_fetch_array($data)) {
													echo '<option name="kdgudang"  value="' . $row['kode'] . '">' . $row['kode'] . '|' . $row['nama'] . '</option>';
													$jsArraySatuan .= "prdNameGudang['" . $row['kode'] . "'] = {nmgudang:'" . addslashes($row['nama']) . "',kdgudang:'" . addslashes($row['kode']) . "'};\n";
												}
												echo '</select>';
												?>
												<input type='hidden' class='form-control' size='50' id='nmgudang' name='nmgudang' readonly>
								</table>
							</div>
							<div class='col-md-6'>
								<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
									<tr>
										<td>Biaya Lain</td>
										<td> <input type="number" class='form-control' name='biaya_lain' id='biaya_lain' value='0' onkeyup="validAngka_no_titik(this)" onblur="hit_total()"></td>
									</tr>
									<tr>
										<td>Subtotal</td>
										<td> <input type="number" class='form-control' name='subtotal' id='subtotal' value='0' size='50' readonly`></td>
									</tr>
									<tr>
										<td>Total</td>
										<td> <input type="number" class='form-control' name='total' id='total' value='0' size='50' readonly></td>
									</tr>
									<tr>
										<td>Keterangan</td>
										<td><textarea type='text' rows='2' class='form-control' id='keterangan' name='keterangan' autocomplete='off'></textarea></td>
									</tr>
								</table>
							</div>
							<div class='col-md-12'>
								<button type='submit' class='btn btn-primary btn-sm'>Simpan</button>
								<input button type='Button' class='btn btn-danger btn-sm' value='Batal' onClick='history.back()' />
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
		cekakses($connect, $user, 'Penerimaan Barang');
		$lakses = $_SESSION['aksesedit'];
		if ($lakses == 1) {
			$sql = mysqli_query($connect, "select * from terimah where id='$_GET[id]'");
			$de = mysqli_fetch_assoc($sql);
			// $query = $connect->prepare("select * from terimah where id=?");
			// $query->bind_param('i', $_GET['id']);
			// $query->execute();
			// $result = $query->get_result();
			// $de = $result->fetch_assoc();
			$noterima = strip_tags($de['noterima']);
			$tglterima = strip_tags($de['tglterima']);
			$noreferensi = strip_tags($de['noreferensi']);
			$tgldokumen = strip_tags($de['tgldokumen']);
			$kdjntrans = strip_tags($de['kdjntrans']);
			$penerima = strip_tags($de['penerima']);
			$kdgudang = strip_tags($de['kdgudang']);
			$biaya_lain = strip_tags($de['biaya_lain']);
			$subtotal = strip_tags($de['subtotal']);
			$total = strip_tags($de['total']);
			$keterangan = strip_tags($de['keterangan']);
		?>
			<font face='calibri'>
				<div class="panel panel-success">
					<div class="panel-heading">
						<font size="4">EDIT HEADER DATA PENERIMAAN BARANG</font>
					</div>
					<div class="panel-body">
						<form method='post' name='tbbarang' enctype='multipart/form-data' action='module/terima/proses_edit.php'>
							<input type='hidden' name='username' value="<?= $user ?>">
							<input type='hidden' name='id' value="<?= $de['id'] ?>" />
							<div class='col-md-6'>
								<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
									<tr>
										<td>Nomor Penerimaan</td>
										<td>
											<input type='text' class='form-control' id='noterima' name='noterima' placeholder='No. Penerimaan *' style='text-transform:uppercase' value="<?= $noterima ?>" readonly>
										</td>
									</tr>
									<tr>
										<td>Tgl. Penerimaan (M/D/Y)</td>
										<td><input type='date' class='form-control' id='tglterima' name='tglterima' value="<?php echo $tglterima ?>" size='50' autocomplete='off' required readonly></td>
									</tr>
									<tr>
										<td>No. Referensi</td>
										<td> <input type="text" class='form-control' id='noreferensi' name='noreferensi' size='50' value="<?= $noreferensi ?>" autocomplete='off' autofocus='autofocus'></td>
									</tr>
									<tr>
										<td>Tgl. Referensi</td>
										<td> <input type="date" class='form-control' id='tgldokumen' name='tgldokumen' value="<?= $tgldokumen ?>" size='50' autocomplete='off' autofocus='autofocus'></td>
									</tr>

									<tr>
										<td>Jenis Transaksi
										<td><select id='kdjntrans' name='kdjntrans' class='form-control' style='width: 200x;' onchange='changeValueJnstrans(this.value)'>
												<!--<option value=''> - PILIH SATUAN BARANG - </option>";-->
												<?php
												$jsArrayJntrans = "var prdNameJntrans = new Array();\n";
												$data = mysqli_query($connect, "select * from tbjntrans where keterangan='IN' order by nama");
												while ($row = mysqli_fetch_array($data)) {
													if ($row['kode'] == $de['kdjntrans']) {
														echo "<option value=$row[kode] selected>$row[kode]|$row[nama] </option>";
													} else {
														echo '<option name="kdjntrans"  value="' . $row['kode'] . '">' . $row['kode'] . '|' . $row['nama'] . '</option>';
														$jsArrayJnstrans .= "prdNameSatuan['" . $row['kode'] . "'] = {nmjntrans:'" . addslashes($row['nama']) . "',kdjntrans:'" . addslashes($row['kode']) . "'};\n";
													}
												}
												echo '</select>';
												?>
												<!-- <tr><td>Tanggal Kirim<br>(M/D/Y)</br></td> <td> <input type="date" class='form-control' name='tglkirim' size='50' value='<?= $tglkirim ?>'></td></tr> -->
									<tr>
										<td>Penerima</td>
										<td> <input type="text" class='form-control' name='penerima' valu='<?= $penerima ?>'></td>
									</tr>
									<tr>
										<td>Gudang
										<td><select id='kdgudang' name='kdgudang' class='form-control' style='width: 200x;' onchange='changeValueGudang(this.value)'>
												<!--<option value=''> - PILIH SATUAN BARANG - </option>";-->
												<?php
												$jsArrayGudang = "var prdNameGudang = new Array();\n";
												$data = mysqli_query($connect, 'select * from tbgudang order by nama');
												while ($row = mysqli_fetch_array($data)) {
													if ($row['kode'] == $de['kdgudang']) {
														echo "<option value=$row[kode] selected>$row[kode]|$row[nama] </option>";
													} else {
														echo '<option name="kdgudang"  value="' . $row['kode'] . '">' . $row['kode'] . '|' . $row['nama'] . '</option>';
														$jsArrayGudang .= "prdNameSatuan['" . $row['kode'] . "'] = {nmgudang:'" . addslashes($row['nama']) . "',kdgudang:'" . addslashes($row['kode']) . "'};\n";
													}
												}
												echo '</select>';
												?>
								</table>
							</div>
							<div class='col-md-6'>
								<table style=font-size:12px; class='table table-striped table table-bordered' width='600px'>
									<tr>
										<td>Biaya Lain</td>
										<td> <input type="number" class='form-control' name='biaya_lain' id='biaya_lain' size='50' value='<?= $biaya_lain ?>' onkeyup="validAngka_no_titik(this)" onblur="hit_total()" required></td>
									</tr>
									<tr>
										<td>Subtotal</td>
										<td> <input type="number" class='form-control' name='subtotal' id='subtotal' size='50' value='<?= $subtotal ?>' readonly></td>
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
					<font size="4">PENERIMAAN BARANG</font>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-4 bg">
							<a class="btn btn-primary btn-sm" href="?m=terima&tipe=tambah"><i class="fa fa-plus"></i> Tambah data</a>
						</div>
					</div>
					</br>
					<div class="box-body table-responsive">
						<!-- <table id="example1" class="table table-bordered table-striped"> -->
						<table id="tbl-terimah" class="table table-bordered table-striped table-hover">
							<thead>
								<tr>
									<th width='40'>No.</th>
									<th>No. Terima</th>
									<th>Tgl. Terima</th>
									<th>Jenis</th>
									<th>No. Referensi</th>
									<th width='70'>Total</th>
									<th width='20'>Proses</th>
									<th width='20'>Batal</th>
									<th width='70'>Aksi</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>
				</div>
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




		function lihat_detail(id) {
			$('#modaldetail').modal('show');
			//$('#modaldetail').find('.modal-body').html(id);
			$.ajax({
				url: './module/terima/lihat_detail.php',
				type: 'post',
				data: {
					kode: id
				},
				success: function(response) {
					$('#modaldetail').find('.modal-body').html(response);
				}
			});
		}


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
						$href = "module/terima/proses_hapus.php?id=";
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
						$href = "module/terima/proses_hapus_detail.php?id=";
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
						$href = "module/terima/proses.php?id=";
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
						$href = "module/terima/batal_proses.php?id=";
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
			var lqty = document.getElementById('qty').value;
			var lharga = document.getElementById('harga').value;
			//var lsubtotal = (parseInt(document.getElementById('qty').value) * parseInt(document.getElementById('harga').value));
			var lsubtotal = lqty * lharga;
			document.getElementById('subtotal').value = lsubtotal;
		}
	</script>

	<script type="text/javascript">
		function hit_total() {
			var lbiaya_lain = parseInt(document.getElementById('biaya_lain').value);
			var lsubtotal = parseInt(document.getElementById('subtotal').value);
			var ltotal = lbiaya_lain + lsubtotal;
			document.getElementById('total').value = ltotal;
		}
	</script>

	<script type="text/javascript">
		function eraseText() {
			document.getElementById("kdbarang").value = "";
			document.getElementById("nmbarang").value = "";
			document.getElementById("kdsatuan").value = "";
			document.getElementById("qty").value = "";
			document.getElementById("harga").value = "";
			document.getElementById("subtotal").value = "";
		}
	</script>

	<script type="text/javascript">
		<?php //echo $jsArrayJntrans; 
		?>

		function changeValueJntrans(id) {
			document.getElementById('kdjntrans').value = prdNameJntrans[id].kdjntrans;
			document.getElementById('nmjntrans').value = prdNameJntrans[id].nmjntrans;
		};
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
						$href = "module/terima/cetak.php?id=";
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

	<script>
		$(document).ready(function() {
			$('#tbl-detail-terima').DataTable({
				// destroy: true,
				"aLengthMenu": [
					[5, 50, 100, -1],
					[5, 50, 100, "All"]
				],
				"iDisplayLength": 5
			})
			var table = $('#tbl-terimah').DataTable({
				destroy: true,
				"aLengthMenu": [
					[5, 50, 100, -1],
					[5, 50, 100, "All"]
				],
				"iDisplayLength": 5,
				"processing": true,
				"serverSide": true,
				"ajax": "dataterimah.php",
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
							// var html = "";
							// // var html = "<a class='btn btn-success btn-xs' href='?m=jual&tipe=detail_proses&nojual=$k[nojual]&kdcustomer=$k[kdcustomer]'>Detail</a> ";
							// // var html = '<button type="button" class="btn btn-success btn-xs dt-view" style="margin-right:10px;"><span class="glyphicon glyphicon-eye-open glyphicon-info-sign" aria-hidden="true"></span></button>';
							// html += '<button type="button" class="btn btn-success btn-xs tblEdit" style="margin-right:10px;"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>H</button>';
							// html += '<button type="button" class="btn btn-info btn-xs dt-detail" style="margin-right:10px;"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>D</button>';
							// html += '<button type="button" class="btn btn-danger btn-xs dt-delete" style="margin-right:10px;"><span class="glyphicon glyphicon-remove glyphicon-trash" aria-hidden="true">';
							// html += '<button type="button" class="btn btn-warning btn-xs dt-proses" style="margin-right:10px;"><span class="glyphicon glyphicon-circle-arrow-right" aria-hidden="true">';
							// html += '<button type="button" class="btn btn-danger btn-xs dt-unproses" style="margin-right:10px;"><span class="glyphicon glyphicon-circle-arrow-left" aria-hidden="true">';
							// html += '<button type="button" class="btn btn-default btn-xs dt-cetak" style="margin-right:10px;"><span class="glyphicon glyphicon-print" aria-hidden="true">';
							// // html += '<button type="button" class="btn btn-default btn-xs dt-cetak-fp" style="margin-right:10px;"><span class="glyphicon glyphicon-print" aria-hidden="true"> FP';
							var html = "";
							html += '<div class="dropdown"> <button class="btn btn-primary btn-sm dropdown-toggle"	type="button"	data-toggle="dropdown"> Pilih Aksi <span class="caret"> </span></button>';
							html += '<ul class = "dropdown-menu">';
							if (data[9] == "Y") { //batal
								html += '<li> <a class="dt-delete"><i class="fa fa-arrow-left"></i>Kembalikan </a></li>';
							} else {
								if (data[7] == "Y") { //proses
									html += '<li><a class="dt-unproses"><i class="fa fa-arrow-left"></i>Unproses </a></li>';
									html += '<li><a class="dt-cetak"><i class="fa fa-print"></i>Cetak Penerimaan Barang</a></li>';
								} else {
									html += '<li><a class="tblEdit"><i class="fa fa-edit"></i>Edit Header</a></li>';
									html += '<li><a class="dt-detail"><i class="fa fa-edit"></i>Edit Detail</a></li>';
									html += '<li><a class="dt-delete"><i class="fa fa-times"></i>Hapus</a></li>';
									html += '<li><a class="dt-proses"><i class="fa fa-arrow-right"></i>Proses </a></li>';
								}
							}
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
			$('#tbl-terimah tbody').on('click', '.dt-view', function() {
				var data = table.row($(this).parents('tr')).data();
				window.location.href = "?m=terima&tipe=detail_proses&id=" + data[9]
			});
			$('#tbl-terimah tbody').on('click', '.tblEdit', function() {
				var data = table.row($(this).parents('tr')).data();
				if (data[9] == "Y") {
					swal({
						title: "Data sudah batal !",
						text: "Aksi tidak bisa dilanjutkan",
						icon: "error"
					})
					exit();
				}
				if (data[8] == "N") {
					window.location.href = "?m=terima&tipe=edit&id=" + data[9]
				} else {
					swal({
						title: "Data sudah di proses !",
						text: "Aksi tidak bisa dilanjutkan",
						icon: "error"
					})
				}
			});
			$('#tbl-terimah tbody').on('click', '.dt-detail', function() {
				var data = table.row($(this).parents('tr')).data();
				if (data[9] == "Y") {
					swal({
						title: "Data sudah batal !",
						text: "Aksi tidak bisa dilanjutkan",
						icon: "error"
					})
					exit();
				}
				if (data[8] == "N") {
					window.location.href = "?m=terima&tipe=detail&id=" + data[9]
				} else {
					swal({
						title: "Data sudah di proses !",
						text: "Aksi tidak bisa dilanjutkan",
						icon: "error"
					})
				}
			});

			$('#tbl-terimah tbody').on('click', '.dt-delete', function() {
				//var data = table.row( $(this).parents('tr') ).data();
				//var id = $(this).attr("id");
				var data = table.row($(this).parents('tr')).data();
				var id = data[9];
				if (data[8] == "Y") {
					swal({
						title: "Data sudah di proses",
						text: "Aksi tidak bisa dilanjutkan",
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
								$href = "module/terima/proses_hapus.php?id=";
								window.location.href = $href + id;
								// swal("terimaof! Your imaginary file has been deleted!", {
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
								$href = "module/terima/proses_hapus.php?id=";
								window.location.href = $href + id;
								// swal("terimaof! Your imaginary file has been deleted!", {
								//   icon: "success",
								// });
							} else {
								//swal("Batal Hapus!");
							}
						});
				}
			});

			$('#tbl-terimah tbody').on('click', '.dt-proses', function() {
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
						text: "Aksi tidak bisa dilanjutkan",
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
							$href = "module/terima/proses.php?id=";
							window.location.href = $href + id;
							// swal("terimaof! Your imaginary file has been deleted!", {
							//   icon: "success",
							// });
						} else {
							//swal("Batal Hapus!");
						}
					});
			});

			$('#tbl-terimah tbody').on('click', '.dt-unproses', function() {
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
						text: "Aksi tidak bisa dilanjutkan",
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
							$href = "module/terima/batal_proses.php?id=";
							window.location.href = $href + id;
							// swal("terimaof! Your imaginary file has been deleted!", {
							//   icon: "success",
							// });
						} else {
							//swal("Batal Hapus!");
						}
					});
			});


			$('#tbl-terimah tbody').on('click', '.dt-cetak', function() {
				var data = table.row($(this).parents('tr')).data();
				var id = data[9];
				if (data[8] == "N") {
					swal({
						title: "Data belum diproses !",
						text: "Aksi tidak bisa dilanjutkan",
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
							$href = "module/terima/cetak.php?id=";
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