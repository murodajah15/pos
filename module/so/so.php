<?php
$user = $_SESSION['username'];
$kunci_harga_jual = $_SESSION['kunci_harga_jual'];

date_default_timezone_set('Asia/Jakarta');

include('autonumber.php');
if (isset($_GET['tipe'])) {
	if ($_GET['tipe'] == 'detail_proses') {
		cekakses($connect, $user, 'Sales Order');
		$lakses = $_SESSION['aksespakai'];
		if ($lakses == 1) {
			// $query = $connect->prepare("select * from soh where id=?");
			// $query->bind_param('s', $_GET['id']);
			// $query->execute();
			// $result = $query->get_result();
			// $de = $result->fetch_assoc();
			$sql = mysqli_query($connect, "select * from soh where id='$_GET[id]'");
			$de = mysqli_fetch_assoc($sql);
			$noso = strip_tags($de['noso']);
			$proses = strip_tags($de['proses']);
			$tglso = strip_tags($de['tglso']);
			$customer = strip_tags($de['kdcustomer'] . ' | ' . $de['nmcustomer']);
			$biaya_lain = number_format($de['biaya_lain'], 0, ",", ".");
			$subtotal = number_format($de['subtotal'], 0, ",", ".");
			$total_sementara = number_format($de['total_sementara'], 0, ",", ".");
			$ppn = number_format($de['ppn'], 2, ",", ".");
			$materai = number_format($de['materai'], 0, ",", ".");
			$total = number_format($de['total'], 0, ",", ".");
?>
			<font face='calibri'>
				<div class='panel panel-default'>
					<div class='panel-heading'>
						<font size="4">DETAIL PENJUALAN : <?= $de['noso'] ?>&nbsp&nbsp<input button type="Button" class="btn btn-danger btn-xs" value="Close" onClick="history.back()" /></font>
					</div>
					<div class='panel-body'>

						<input type='hidden' name='username' value='<?= $user ?>'>
						<div class='col-md-6'>
							<table style=font-size:12px; class='table table-striped table table-bordered' width='600px'>
								<tr>
									<td>Nomor Order</td>
									<td>
										<input type='text' class='form-control' id='noso' name='noso' placeholder='No. SO *' style='text-transform:uppercase' value="<?= $noso ?>" readonly>
									</td>
								</tr>
								<tr>
									<td>Tgl. (M/D/Y)</td>
									<td><input type='date' class='form-control' id='tglso' name='tglso' value="<?= $tglso ?>" size='50' autocomplete='off' readonly></td>
								</tr>
								<tr>
									<td>No. Referensi</td>
									<td><input type="text" class="form-control" value="<?= $de['noreferensi'] ?>" readonly></td>
								</tr>
								<tr>
									<td>No. PO Customer</td>
									<td><input type="text" class="form-control" value="<?= $de['nopo_customer'] ?>" readonly></td>
								</tr>
								<tr>
									<td>Tgl. PO Customer</td>
									<td><input type="text" class="form-control" value="<?= $de['tglpo_customer'] ?>" readonly></td>
								</tr>
								<tr>
									<td>Kode customer</td>
									<td><input type="text" class="form-control" value="<?= $customer ?>" readonly></td>
								</tr>
								<tr>
									<td>Jenis Order</td>
									<td><input type="text" class="form-control" value="<?= $de['jenis_order'] ?>" readonly></td>
								</tr>
								<tr>
									<td>Keterangan Biaya Lain</td>
									<td><input type="text" class="form-control" value="<?= $de['ket_biaya_lain'] ?>" readonly></td>
								</tr>
								<tr>
									<td>Tanggal Kirim<br>(M/D/Y)</br></td>
									<td><input type="date" class="form-control" value="<?= $de['tglkirim'] ?>" readonly></td>
								</tr>
								<tr>
									<td>Cara Bayar</td>
									<td><input type="text" class="form-control" value="<?= $de['carabayar'] ?>" readonly></td>
								</tr>
								<tr>
									<td>Tempo (Hari)</td>
									<td><input type="number" class="form-control" value="<?= $tempo ?>" readonly></td>
								</tr>
								<tr>
									<td>Tanggal Jatuh Tempo<br>(M/D/Y)</br></td>
									<td><input type="date" class="form-control" value="<?= $de['tgl_jt_tempo'] ?>" readonly></td>
								</tr>
							</table>
						</div>
						<div class='col-md-6'>
							<table style=font-size:12px; class='table table-striped table table-bordered' width='600px'>
								<tr>
									<td>Biaya Lain</td>
									<td><input type="textr" class="form-control" style="text-align:right;" value="<?= $biaya_lain ?>" readonly></td>
								</tr>
								<tr>
									<td>Subtotal</td>
									<td align="right"> <input type="text" class="form-control" style="text-align:right;" value="<?= $subtotal ?>" readonly></td>
								</tr>
								<tr>
									<td>Total Sementara</td>
									<td><input type="text" class="form-control" style="text-align:right;" value="<?= $total_sementara ?>" readonly></td>
								</tr>
								<tr>
									<td>PPn (%)</td>
									<td><input type="text" class="form-control" style="text-align:right;" value="<?= $ppn ?>" readonly></td>
								</tr>
								<tr>
									<td>Materai</td>
									<td><input type="text" class="form-control" style="text-align:right;" value="<?= $materai ?>" readonly></td>
								</tr>
								<tr>
									<td>Total</td>
									<td align="right"> <input type="text" class="form-control" style="text-align:right;" value="<?= $total ?>" readonly></td>
								</tr>
								<tr>
									<td>Keterangan</td>
									<td><textarea type='text' rows='2' class="form-control" readonly><?= $de['keterangan'] ?></textarea></td>
								</tr>
								<tr>
									<td>Proses</td>
									<td><input type="text" class="form-control" value="<?= $de['proses'] ?>" readonly></td>
								</tr>
								<tr>
									<td>User Input</td>
									<td><input type="text" class="form-control" value="<?= $de['user'] ?>" readonly></td>
								</tr>
								<tr>
									<td>User Proses</td>
									<td><input type="text" class="form-control" value="<?= $de['user_proses'] ?>" readonly></td>
								</tr>
							</table>
						</div>

						<div class="col-md-12">
							<div class="table-responsive">
								<table class="table table-bordered table-striped table-hover">
									<tr>
										<th width='50'>No.</th>
										<th width='170'>Kode Barang</th>
										<th>Nama Barang</th>
										<th>Satuan</th>
										<th>QTY</th>
										<th>harga</th>
										<th>Discount</th>
										<th>Subtotal</th>
									</tr>
									<?php
									$tampil = mysqli_query($connect, "select * from sod where noso='$noso'");
									// $query = $connect->prepare("select * from sod where noso=?");
									// $query->bind_param('s', $noso);
									// $query->execute();
									// $result = $query->get_result();
									// $de = $result->fetch_assoc();
									$no = 1;
									//<td><u><a href='?m=wo&tipe=detail&id=$k[id]'><font color='blue'>$k[kode]</font></a></u></td>
									//<td><u><a href='#' onclick =lihat_detail('$k[id]');><font color='blue'>$k[kdbarang]</font></a></u></td>
									while ($k = mysqli_fetch_assoc($tampil)) {
										//$date = date("m/d/Y", strtotime($k['tglwo']));
										$kdbarang = strip_tags($de['kdbarang']);
										$nmbarang = strip_tags($de['nmbarang']);
										$qty = number_format($k['qty'], 2, ",", ".");
										$harga = number_format($k['harga'], 0, ",", ".");
										$discount = number_format($k['discount'], 2, ",", ".");
										$subtotal = number_format($k['subtotal'], 0, ",", ".");
										echo "<tr><td align='center'>$no</td>
								<td width='100'>$k[kdbarang]</td>
								<td width='300'>$k[nmbarang]</td>
								<td width='80'>$k[kdsatuan]</td>
								<td align='right' width='70'>$qty</td>
								<td align='right' width='100'>$harga</td>
								<td align='right' width='70'>$discount</td>
								<td align='right'>$subtotal</td>";
										$no++;
									}
									$tampil = mysqli_query($connect, "select sum(qty) as total_qty,sum(subtotal) as total_subtotal from sod where noso='$noso'");
									$jum = mysqli_fetch_assoc($tampil);
									$total_qty = $jum['total_qty'];
									$total_qty = number_format($total_qty, 2, ",", ".");
									$total = $jum['total_subtotal'];
									$total = number_format($total, 0, ",", ".");
									echo "<tr><td colspan='4'></td>
							<td align='right' style='font-weight:bold'>$total_qty</td>
							<td colspan='2' align='right'></td>
							<td align='right' style='font-weight:bold'>$total</td>";
									?>
								</table>
							</div>
							<input button type='Button' class='btn btn-danger' value='Close' onClick='history.back()' />
						</div>
						<div class="row"></div>
					</div>
				</div>
			</font>
		<?php
		} else {
			echo "<script>alert('Anda tidak berhak !');history.go(-1) </script>";
		}
	}
}

if (isset($_GET['tipe'])) {
	if ($_GET['tipe'] == 'detail') {
		cekakses($connect, $user, 'Sales Order');
		$lakses = $_SESSION['aksespakai'];
		if ($lakses == 1) {
			// $kdcustomer = $_GET['kdcustomer'];
			// $query = $connect->prepare("select * from soh where id=?");
			// $query->bind_param('s', $_GET['id']);
			// $query->execute();
			// $result = $query->get_result();
			// $de = $result->fetch_assoc();
			$sql = mysqli_query($connect, "select * from soh where id='$_GET[id]'");
			$de = mysqli_fetch_assoc($sql);
			$noso = strip_tags($de['noso']);
			$kdcustomer = strip_tags($de['kdcustomer']);
			$_SESSION['kdcustomer'] = $kdcustomer;
			$proses = strip_tags($de['proses']);
			$tglso = strip_tags($de['tglso']); ?>
			<font face='calibri'>
				<div class='panel panel-info'>
					<div class='panel-heading'>
						<font size="4">EDIT DETAIL DATA SALES ORDER : <?= $noso ?></font>
					</div>
					<div class='panel-body'>
						<form method='post' name='so' enctype='multipart/form-data' action='module/so/proses_tambah_detail.php'>
							<input type='hidden' name='username' value="<?= $user ?>">
							<input type='hidden' name='kdcustomer' id='kdcustomer' value="<?= $kdcustomer ?>">
							<div class='col-md-10'>
								<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
									<tr>
										<td>Nomor SO</td>
										<td>
											<input type='text' class='form-control' id='noso' name='noso' placeholder='No. SO *' style='text-transform:uppercase' value="<?= $noso ?>" readonly>
										</td>
										<td>Tgl. (M/D/Y)</td>
										<td><input type='date' class='form-control' id='tglso' name='tglso' value="<?= $tglso ?>" size='50' autocomplete='off' readonly></td>
									</tr>
								</table>
							</div>
							<div class='col-md-12'>
								<table style=font-size:12px; class='table table-striped table table-bordered' width='600px'>
									<tr>
										<th>Kode Barang <input type="button" class='btn btn-warning btn-xs' value="Clear" onclick="eraseText()"> <input type="checkbox" class="multiprc" name="multiprc" id="multiprc"> Multi Price</th>
										<th>Barang</th>
										<th>QTY</th>
										<th>Harga</th>
										<th>Disc</th>
										<th>Subtotal</th>
										<th>Aksi</th>
									</tr>
									<td>
										<div class='input-group'> <input type='text' class='form-control' style="text-transform: uppercase; width: 9em;" id='kdbarang' name='kdbarang' size='50' autocomplete='off' required>
											<span class='input-group-btn'>
												&nbsp<button type='button' id='srcmp' class='btn btn-primary btn-sm' onclick='cari_data_barang()' disabled>MP</button>
											</span>
											<span class='input-group-btn'>
												&nbsp<button type='button' id='srctb' class='btn btn-success btn-sm' onclick='cari_data_tbbarang()'>TB</button>
											</span>
									</td>
									</td>
									<td><input type='text' class='form-control' style='width: 15em' id='nmbarang' name='nmbarang' readonly></td>
									</td>
									<td><input type="text" class='form-control' value='1' id='qty' name='qty' style='width: 6em' required onkeyup="validAngka(this)" onblur="hit_subtotal()"></td>
									<?php
									if ($kunci_harga_jual == 'Y') {
									?>
										</td>
										<td><input type="text" class='form-control' value='0' id='harga' name='harga' style='width: 7em' readonly></td>
									<?php
									} else {
									?>
										</td>
										<td><input type="text" class='form-control' value='0' id='harga' name='harga' style='width: 7em' onkeyup="validAngka_no_titik(this)" onblur="hit_subtotal()"></td>
									<?php
									}
									?>
									</td>
									<td><input type="text" class='form-control' value='0' id='discount' name='discount' style='width: 6em' onkeyup="validAngka(this)" onblur="hit_subtotal()"></td>
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
										<th>Discount</th>
										<th>Subtotal</th>
										<th>Aksi</th>
									</tr>
									<?php
									$tampil = mysqli_query($connect, "select * from sod where noso='$noso'");
									// $query = $connect->prepare("select * from sod where noso=?");
									// $query->bind_param('s', $noso);
									// $query->execute();
									// $result = $query->get_result();
									// $de = $result->fetch_assoc();
									$no = 1;
									//<td><u><a href='?m=wo&tipe=detail&id=$k[id]'><font color='blue'>$k[kode]</font></a></u></td>
									//<td><u><a href='#' onclick =lihat_detail('$k[id]');><font color='blue'>$k[kdbarang]</font></a></u></td>
									while ($k = mysqli_fetch_assoc($tampil)) {
										$kdbarang = strip_tags($k['kdbarang']);
										$nmbarang = strip_tags($k['nmbarang']);
										$qty = number_format($k['qty'], 2, ",", ".");
										$harga = number_format($k['harga'], 0, ",", ".");
										$discount = number_format($k['discount'], 2, ",", ".");
										$subtotal = number_format($k['subtotal'], 0, ",", ".");
										//$date = date("m/d/Y", strtotime($k['tglwo']));
										echo "<tr><td align='center'>$no</td>
								<td width='90'>$k[kdbarang]</td>
								<td width='250'>$k[nmbarang]</td>
								<td width='70'>$k[kdsatuan]</td>
								<td align='right' width='70'>$qty</td>
								<td align='right' width='100'>$harga</td>
								<td align='right' width='50'>$discount</td>
								<td align='right'>$subtotal</td>
								<td align='center' width='145px'>";
										echo "<a class='btn btn-primary btn-sm' href='?m=so&tipe=edit_detail&id=$k[id]&noso='$noso'>Edit</a> ";
										echo " <input button type='Button' class='btn btn-danger btn-sm' value='Hapus' onClick='alert_hapus_detail($k[id])'/>";
										$no++;
									}
									$tampil = mysqli_query($connect, "select sum(qty) as total_qty,sum(subtotal) as total_subtotal from sod where noso='$noso'");
									$jum = mysqli_fetch_assoc($tampil);
									$total_qty = $jum['total_qty'];
									$total_qty = number_format($total_qty, 2, ",", ".");
									$total = $jum['total_subtotal'];
									$total = number_format($total, 0, ",", ".");
									echo "<tr><td colspan='4'></td>
							<td align='right' style='font-weight:bold'>$total_qty</td>
							<td colspan='2' align='right'></td>
							<td align='right' style='font-weight:bold'>$total</td>";
									?>
								</table>
							</div>
							<div class='col-md-12'>
								<!--<input button type='Button' class='btn btn-danger' value='Close' onClick='history.back()'/>-->
								<input button type='Button' class='btn btn-danger' value='Close' onClick="window.location = 'dashboard.php?m=so'" />

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
		cekakses($connect, $user, 'Edit Detail SALES ORDER');
		$lakses = $_SESSION['aksespakai'];
		if ($lakses == 1) {
			// $query = $connect->prepare("select * from soh where noso=?");
			// $query->bind_param('s', $_GET['noso']);
			// $query->execute();
			// $result = $query->get_result();
			// $de = $result->fetch_assoc();
			$sql = mysqli_query($connect, "select * from soh where noso='$_GET[noso]'");
			$de = mysqli_fetch_assoc($sql);
			$noso = strip_tags($de['noso']);
			$kdcustomer = strip_tags($de['kdcustomer']);
			$_SESSION['kdcustomer'] = $kdcustomer;
			$tglso = strip_tags($de['tglso']); ?>

			<font face='calibri'>
				<div class='panel panel-default'>
					<div class='panel-heading'>
						<font size="4">EDIT DETAIL DATA SALES ORDER</font>
					</div>
					<div class='panel-body'>
						<form method='post' name='so' enctype='multipart/form-data' action='module/so/proses_edit_detail.php'>
							<input type='hidden' name='username' value="<?= $user ?>">
							<div class='col-md-12'>
								<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
									<!--<font face='calibri'>
					<h3>Edit Detail SALES ORDER</h3>
					<form method='post' enctype='multipart/form-data' action='module/so/proses_edit_detail.php'>
						<input type='hidden' name='username' value='<?= $user ?>'>
 						<table class="table table-bordered table-striped table-hover">-->
									<tr>
										<td>Nomor Order</td>
										<td>
											<input type='text' class='form-control' id='noso' name='noso' placeholder='No. SO *' style='text-transform:uppercase' value="<?= $noso ?>" readonly>
										</td>
										<td>Tgl. (M/D/Y)</td>
										<td><input type='date' class='form-control' id='tglso' name='tglso' value="<?= $tglso ?>" size='50' autocomplete='off' readonly></td>
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
										<th>Disc</th>
										<th>Subtotal</th>
									</tr>
									<?php
									// $query = $connect->prepare("select * from sod where id=?");
									// $query->bind_param('s', $_GET['id']);
									// $query->execute();
									// $result = $query->get_result();
									// $de = $result->fetch_assoc();
									$sql = mysqli_query($connect, "select * from sod where id='$_GET[id]'");
									$de = mysqli_fetch_assoc($sql);
									$kdbarang = strip_tags($de['kdbarang']);
									$nmbarang = strip_tags($de['nmbarang']);
									$kdsatuan = strip_tags($de['kdsatuan']);
									$qty = number_format($de['qty'], 2, ",", ".");
									$qty = str_replace(",", ".", $qty);
									$harga = strip_tags($de['harga']);
									$discount = number_format($de['discount'], 2, ",", ".");
									$discount = str_replace(",", ".", $discount);
									$subtotal = strip_tags($de['subtotal']);
									?>
									<input type='hidden' name='id' value='<?= $de['id'] ?>'>
									<input type='hidden' name='noso' value='<?= $de['noso'] ?>'>
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
									<td><input type="text" class='form-control' id='harga' name='harga' value='<?= $harga ?>' style='width: 8em' onkeyup="validAngka_no_titik(this)" onblur="hit_subtotal()"></td>
									</td>
									<td><input type="text" class='form-control' id='discount' name='discount' value='<?= $discount ?>' style='width: 6em' onkeyup="validAngka(this)" onblur="hit_subtotal()"></td>
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
		cekakses($connect, $user, 'Sales Order');
		$lakses = $_SESSION['aksestambah'];
		$de = mysqli_fetch_assoc(mysqli_query($connect, "select * from saplikasi where aktif='Y'"));
		$tgl = $de['tgl_berikutnya']; //date('Y-m-d')
		$de = mysqli_fetch_assoc(mysqli_query($connect, "select * from saplikasi where aktif='Y'"));
		$tgl = $de['tgl_berikutnya']; //date('Y-m-d')
		echo 'tgl' . $tgl;
		if ($lakses == 1) { ?>
			<font face='calibri'>
				<div class='panel panel-primary'>
					<div class='panel-heading'>
						<font size="4">TAMBAH DATA SALES ORDER</font>
					</div>
					<div class='panel-body'>
						<form method='post' name='so' enctype='multipart/form-data' action='module/so/proses_tambah.php'>
							<input type='hidden' name='username' value="<?= $user ?>">
							<div class='col-md-6'>
								<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
									<tr>
										<td>Nomor Order</td>
										<td>
											<input type='text' class='form-control' id='noso' name='noso' placeholder='No. Order *' style='text-transform:uppercase' value="<?php echo autoNumberSO($connect, 'id', 'soh'); ?>" readonly>
										</td>
									</tr>
									<tr>
										<td>Tanggal (M/D/Y)</td>
										<td><input type='date' class='form-control' id='tglso' name='tglso' value="<?php echo $tgl ?>" size='50' autocomplete='off' required readonly></td>
									</tr>
									<tr>
										<td>No. Referensi</td>
										<td> <input type="text" class='form-control' id='noreferensi' name='noreferensi' size='50' autocomplete='off' autofocus='autofocus'></td>
									</tr>
									<tr>
										<td>No. PO Customer</td>
										<td> <input type="text" class='form-control' id='nopo_customer' name='nopo_customer' size='50' autocomplete='off' autofocus='autofocus'></td>
									</tr>
									<tr>
										<td>Tgl. PO Customer</td>
										<td> <input type="date" class='form-control' id='tglpo_customer' name='tglpo_customer' size='50' autocomplete='off' autofocus='autofocus'></td>
									</tr>
									<tr>
										<td>Customer</td>
										<td>
											<div class='input-group'> <input type='text' class='form-control' id='kdcustomer' name='kdcustomer' size='50' autocomplete='off' readonly required>
												<span class='input-group-btn'>
													<button type='button' id='src' class='btn btn-primary' onclick='cari_data_customer()'>Cari</button>
												</span>
										</td>
									<tr>
										<td></td>
										<td> <input type="text" class='form-control' id='nmcustomer' name='nmcustomer' size='50' readonly required></td>
									</tr>
									<tr>
										<td>Jenis Order
										<td><select required id='jenis_order' name='jenis_order' class='form-control' style='width: 200x;'>
												<option value="URGENT">URGENT</option>
												<option value="NORMAL">NORMAL</option>
												<option value="LAIN">LAIN-LAIN</option>
											</select>
									<tr>
										<td>Biaya Lain</td>
										<td> <input type="text" class='form-control' name='ket_biaya_lain'></td>
									</tr>
									<tr>
										<td></td>
										<td> <input type="number" class='form-control' name='biaya_lain' id='biaya_lain' size='50' value='0' required onblur="hit_total()" onkeyup="validAngka_no_titik(this)"></td>
									</tr>
									<tr>
										<td>Tanggal Kirim<br>(M/D/Y)</br></td>
										<td> <input type="date" class='form-control' name='tglkirim' size='50'></td>
									</tr>
								</table>
							</div>
							<div class='col-md-6'>
								<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
									<tr>
										<td>Cara Bayar
										<td><select required id='carabayar' name='carabayar' class='form-control' style='width: 200x;'>
												<!--<option value=''> - PILIH CARA BAYAR - </option>";?>-->
												<option value="TUNAI">TUNAI</option>
												<option value="KARTU-KREDIT">KARTU-KREDIT</option>
												<option value="GIRO">GIRO</option>
												<option value="CEK">CEK</option>
											</select>
									<tr>
										<td>Tempo (Hari)</td>
										<td> <input type="number" class='form-control' name='tempo' size='50'></td>
									</tr>
									<tr>
										<td>Tanggal Jatuh Tempo<br>(M/D/Y)</br></td>
										<td> <input type="date" class='form-control' name='tgl_jt_tempo' size='50'></td>
									</tr>
									<tr>
										<td>Subtotal</td>
										<td> <input type="number" class='form-control' name='subtotal' id='subtotal' value='0' size='50' readonly></td>
									</tr>
									<tr>
										<td>Total Sementara</td>
										<td> <input type="number" class='form-control' id='total_sementara' name='total_sementara' size='50' value='0' readonly></td>
									</tr>
									<tr>
										<td>PPn (%)</td>
										<td> <input type="number" class='form-control' name='ppn' id='ppn' size='50' value='0' onkeyup="validAngka(this)" onblur="hit_total()"></td>
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
										<td><textarea type='text' rows='2' class='form-control' id='kerangan' name='keterangan' autocomplete='off'></textarea></td>
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
		cekakses($connect, $user, 'Sales Order');
		$lakses = $_SESSION['aksesedit'];
		if ($lakses == 1) {
			// $sql=mysqli_query($connect,"select * from soh where id='$_GET[id]'");
			// $de=mysqli_fetch_assoc($sql);
			// $query = $connect->prepare("select * from soh where id=?");
			// $query->bind_param('i', $_GET['id']);
			// $query->execute();
			// $result = $query->get_result();
			// $de = $result->fetch_assoc();
			$sql = mysqli_query($connect, "select * from soh where id='$_GET[id]'");
			$de = mysqli_fetch_assoc($sql);
			$noso = strip_tags($de['noso']);
			$tglso = strip_tags($de['tglso']);
			$noreferensi = strip_tags($de['noreferensi']);
			$nopo_customer = strip_tags($de['nopo_customer']);
			$tglpo_customer = strip_tags($de['tglpo_customer']);
			$kdcustomer = strip_tags($de['kdcustomer']);
			$nmcustomer = strip_tags($de['nmcustomer']);
			$jenis_order = strip_tags($de['jenis_order']);
			$tglkirim = strip_tags($de['tglkirim']);
			$biaya_lain = strip_tags($de['biaya_lain']);
			$ket_biaya_lain = strip_tags($de['ket_biaya_lain']);
			$carabayar = strip_tags($de['carabayar']);
			$tempo = strip_tags($de['tempo']);
			$tgl_jt_tempo = strip_tags($de['tgl_jt_tempo']);
			$subtotal = strip_tags($de['subtotal']);
			$total_sementara = strip_tags($de['total_sementara']);
			$ppn = strip_tags($de['ppn']);
			$materai = strip_tags($de['materai']);
			$total = strip_tags($de['total']);
			$keterangan = strip_tags($de['keterangan']);
		?>
			<font face='calibri'>
				<div class="panel panel-success">
					<div class="panel-heading">
						<font size="4">EDIT HEADER DATA SALES ORDER</font>
					</div>
					<div class="panel-body">
						<form method='post' name='tbbarang' enctype='multipart/form-data' action='module/so/proses_edit.php'>
							<input type='hidden' name='username' value="<?= $user ?>">
							<input type='hidden' name='id' value="<?= $de['id'] ?>" />
							<div class='col-md-6'>
								<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
									<tr>
										<td>Nomor SO</td>
										<td>
											<input type='text' class='form-control' id='noso' name='noso' placeholder='No. Order *' style='text-transform:uppercase' value="<?= $noso ?>" readonly>
										</td>
									</tr>
									<tr>
										<td>Tgl. SO (M/D/Y)</td>
										<td><input type='date' class='form-control' id='tglso' name='tglso' value="<?php echo $tglso ?>" size='50' autocomplete='off' required readonly></td>
									</tr>
									<tr>
										<td>No. Referensi</td>
										<td> <input type="text" class='form-control' id='noreferensi' name='noreferensi' size='50' value="<?= $noreferensi ?>" autocomplete='off' autofocus='autofocus'></td>
									</tr>
									<tr>
										<td>No. PO Customer</td>
										<td> <input type="text" class='form-control' id='nopo_customer' name='nopo_customer' value="<?= $nopo_customer ?>" size='50' autocomplete='off' autofocus='autofocus'></td>
									</tr>
									<tr>
										<td>Tgl. PO Customer</td>
										<td> <input type="date" class='form-control' id='tglpo_customer' name='tglpo_customer' value="<?= $tglpo_customer ?>" size='50' autocomplete='off' autofocus='autofocus'></td>
									</tr>
									<tr>
										<td>Customer</td>
										<td>
											<div class='input-group'> <input type='text' class='form-control' id='kdcustomer' name='kdcustomer' value="<?= $kdcustomer ?>" size='50' autocomplete='off' readonly required>
												<span class='input-group-btn'>
													<button type='button' id='src' class='btn btn-primary' onclick='cari_data_customer()'>Cari</button>
												</span>
										</td>
									<tr>
										<td></td>
										<td> <input type="text" class='form-control' id='nmcustomer' name='nmcustomer' value="<?= $nmcustomer ?>" size='50' readonly required></td>
									</tr>
									<tr>
										<td>Jenis Order
										<td><select required id='jenis_order' name='jenis_order' class='form-control' style='width: 200x;'>
												<?php
												$jenis_order = array('URGENT', 'NORMAL', 'LAIN-LAIN');
												$jml_kata = count($jenis_order);
												for ($c = 0; $c < $jml_kata; $c += 1) {
													if ($jenis_order[$c] == $de['jenis_order']) {
														echo "<option value=$jenis_order[$c] selected>$jenis_order[$c] </option>";
													} else {
														echo "<option value=$jenis_order[$c]> $jenis_order[$c] </option>";
													}
												}
												echo "</select>";
												?>
									<tr>
										<td>Biaya Lain</td>
										<td> <input type="text" class='form-control' name='ket_biaya_lain' value='<?= $ket_biaya_lain ?>'></td>
									</tr>
									<tr>
										<td></td>
										<td> <input type="number" class='form-control' name='biaya_lain' id='biaya_lain' size='50' value='<?= $biaya_lain ?>' required onkeyup="validAngka_no_titik(this)" onblur="hit_total()"></td>
									</tr>
									<tr>
										<td>Tanggal Kirim<br>(M/D/Y)</br></td>
										<td> <input type="date" class='form-control' name='tglkirim' size='50' value='<?= $tglkirim ?>'></td>
									</tr>
								</table>
							</div>
							<div class='col-md-6'>
								<table style=font-size:12px; class='table table-striped table table-bordered' width='600px'>
									<tr>
										<td>CARA BAYAR</td>
										<td><select required name="carabayar" id="carabayar" class='form-control'>
												<?php
												$carabayar = array('TUNAI', 'KARTU-KREDIT', 'GIRO', 'CEK');
												$jml_kata = count($carabayar);
												for ($c = 0; $c < $jml_kata; $c += 1) {
													if ($carabayar[$c] == $de['carabayar']) {
														echo "<option value=$carabayar[$c] selected>$carabayar[$c] </option>";
													} else {
														echo "<option value=$carabayar[$c]> $carabayar[$c] </option>";
													}
												}
												echo "</select>";
												?>
										</td>
									</tr>
									<tr>
										<td>Tempo (Hari)</td>
										<td> <input type="number" class='form-control' name='tempo' value='<?= $tempo ?>' size='50'></td>
									</tr>
									<tr>
										<td>Tanggal Jatuh Tempo<br>(M/D/Y)</br></td>
										<td> <input type="date" class='form-control' name='tgl_jt_tempo' value='<?= $tgl_jt_tempo ?>' size='50'></td>
									</tr>
									<tr>
										<td>Subtotal</td>
										<td> <input type="number" class='form-control' name='subtotal' id='subtotal' size='50' value='<?= $subtotal ?>' readonly></td>
									</tr>
									<tr>
										<td>Total Sementara</td>
										<td> <input type="number" class='form-control' id='total_sementara' name='total_sementara' size='50' value='<?= $total_sementara ?>' readonly></td>
									</tr>
									<tr>
										<td>PPn (%)</td>
										<td> <input type="text" class='form-control' name='ppn' id='ppn' size='50' value='<?= $ppn ?>' onkeyup="validAngka(this)" onblur="hit_total()"></td>
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
					<font size="4">SALES ORDER</font>
				</div>
				<div class="panel-body">
					<form method='get'>
						<div class="row">
							<div class="col-md-4 bg">
								<a class="btn btn-primary btn-sm" href="?m=so&tipe=tambah"><i class="fa fa-plus"></i> Tambah data</a>
							</div>
						</div>
					</form>
					</br>
					<div class="table-responsive">
						<table id="tbl-soh" class="table table-bordered table-striped table-hover">
							<thead>
								<tr>
									<th width='30'>No.</th>
									<th width='80'>No. SO</th>
									<th width='60'>Tgl. SO</th>
									<th width='300'>Customer</th>
									<th width='80'>Total</th>
									<th width='20'>Proses</th>
									<th width='20'>Batal</th>
									<th width='70'>Aksi</th>
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
				<div class="modal-dialog modal-lg" style="width:80%">
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
				$(document).ready(function(e) {
					$('#kdbarang').on('blur', function(e) {
						var checkBox = document.getElementById("multiprc");
						if (checkBox.checked == true) {
							var multiprc = 1
							var $url = 'repl_barang.php'
						} else {
							var multiprc = 0
							var $url = 'repl_tbbarang.php'
						}
						// console.log($url);
						let cari = $(this).val()
						let cari1 = $('#kdcustomer').val()
						$.ajax({
							url: $url,
							type: 'post',
							data: {
								'kode_barang': cari,
								'kode_customer': cari1
							},
							success: function(response) {
								let data_response = JSON.parse(response);
								if (!data_response) {
									$('#nmbarang').val('');
									$('#kdsatuan').val('');
									$('#harga').val('');
									$('#qty').val('');
									if (multiprc === 1) {
										cari_data_barang();
									} else {
										cari_data_tbbarang();
									}
									return;
								}
								$('#nmbarang').val(data_response['nama']);
								$('#kdsatuan').val(data_response['kdsatuan']);
								$('#harga').val(data_response['harga_jual']);
								$('#qty').val('1');
								//console.log(data_response['nama']);
								//console.log(data_response['satuan']);
							},
							error: function() {
								console.log('file not fount');
							}
						})
					})
					// }
					// console.log(cari);

					$('#multiprc').on('ifChanged', function(event) {
						if (this.checked) // if changed state is "CHECKED"
						{
							document.getElementById('srctb').setAttribute("disabled", "disabled");
							document.getElementById('srcmp').removeAttribute('disabled');
						} else {
							document.getElementById('srcmp').setAttribute("disabled", "disabled");
							document.getElementById('srctb').removeAttribute('disabled');
						}
					})

				})

				function lihat_detail(id) {
					$('#modaldetail').modal('show');
					//$('#modaldetail').find('.modal-body').html(id);
					$.ajax({
						url: './module/so/lihat_detail.php',
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
								$href = "module/so/proses_hapus.php?id=";
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
								$href = "module/so/proses_hapus_detail.php?id=";
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
								$href = "module/so/proses.php?id=";
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
								$href = "module/so/batal_proses.php?id=";
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
					var lharga = (parseFloat(document.getElementById('qty').value) * parseFloat(document.getElementById('harga').value));
					var ldisc = lharga - (lharga * (document.getElementById('discount').value)) / 100;
					var lsubtotal = ldisc;
					document.getElementById('subtotal').value = lsubtotal;
				}
			</script>

			<script type="text/javascript">
				function hit_total() {
					var lbiaya_lain = parseFloat(document.getElementById('biaya_lain').value);
					var ltotal_sementara = (parseFloat(document.getElementById('biaya_lain').value) + parseFloat(document.getElementById('subtotal').value));
					var lppn = ltotal_sementara * (parseFloat(document.getElementById('ppn').value) / 100);
					var lmaterai = parseFloat(document.getElementById('materai').value);
					var ltotal = ltotal_sementara + lmaterai + lppn;
					document.getElementById('total_sementara').value = ltotal_sementara;
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
					document.getElementById("discount").value = "";
					document.getElementById("subtotal").value = "";
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
								$href = "module/so/cetak.php?id=";
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
					$('#tbl-detail-so').DataTable({
						// destroy: true,
						"aLengthMenu": [
							[5, 50, 100, -1],
							[5, 50, 100, "All"]
						],
						"iDisplayLength": 5
					})
					var table = $('#tbl-soh').DataTable({
						destroy: true,
						"aLengthMenu": [
							[5, 50, 100, -1],
							[5, 50, 100, "All"]
						],
						"iDisplayLength": 5,
						"processing": true,
						"serverSide": true,
						"ajax": "datasoh.php",
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
								"targets": 7,
								"data": null,
								"render": function(data, type, row) { // Tampilkan kolom aksi
									var html = "";
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
											html += '<li><a class="dt-cetak"><i class="fa fa-print"></i>Cetak Sales Order</a></li>';
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
					$('#tbl-soh tbody').on('click', '.dt-view', function() {
						var data = table.row($(this).parents('tr')).data();
						window.location.href = "?m=so&tipe=detail_proses&id=" + data[8]
					});
					$('#tbl-soh tbody').on('click', '.tblEdit', function() {
						var data = table.row($(this).parents('tr')).data();
						if (data[9] == "Y") {
							swal({
								title: "Data sudah batal !",
								text: "Aksi tidak bisa dilanjutkan",
								icon: "error"
							})
							exit();
						}
						if (data[7] == "N") {
							window.location.href = "?m=so&tipe=edit&id=" + data[8]
						} else {
							swal({
								title: "Data sudah di proses !",
								text: "Data sudah di proses, aksi tidak bisa dilanjutkan",
								icon: "error"
							})
						}
					});
					$('#tbl-soh tbody').on('click', '.dt-detail', function() {
						var data = table.row($(this).parents('tr')).data();
						if (data[9] == "Y") {
							swal({
								title: "Data sudah batal !",
								text: "Aksi tidak bisa dilanjutkan",
								icon: "error"
							})
							exit();
						}
						if (data[7] == "N") {
							window.location.href = "?m=so&tipe=detail&id=" + data[8]
						} else {
							swal({
								title: "Data sudah di proses !",
								text: "Data sudah di proses, aksi tidak bisa dilanjutkan",
								icon: "error"
							})
						}
					});

					$('#tbl-soh tbody').on('click', '.dt-delete', function() {
						//var data = table.row( $(this).parents('tr') ).data();
						//var id = $(this).attr("id");
						var data = table.row($(this).parents('tr')).data();
						var id = data[8];
						if (data[7] == "Y") {
							swal({
								title: "Data sudah di proses !",
								text: "Data sudah di proses, aksi tidak bisa dilanjutkan",
								icon: "error"
							})
							exit();
						}
						if (data[9] == "Y") {
							swal({
									title: "Data sudah batal !",
									text: "Yakin akan dilanjutkan ?",
									icon: "error"
								})
								.then((willDelete) => {
									if (willDelete) {
										//alert($kode);
										$href = "module/so/proses_hapus.php?id=";
										window.location.href = $href + id;
										// swal("Poof! Your imaginary file has been deleted!", {
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
										$href = "module/so/proses_hapus.php?id=";
										window.location.href = $href + id;
										// swal("Poof! Your imaginary file has been deleted!", {
										//   icon: "success",
										// });
									} else {
										//swal("Batal Hapus!");
									}
								});
						}
					});

					$('#tbl-soh tbody').on('click', '.dt-proses', function() {
						var data = table.row($(this).parents('tr')).data();
						var id = data[8];
						if (data[9] == "Y") {
							swal({
								title: "Data sudah batal !",
								text: "Aksi tidak bisa dilanjutkan",
								icon: "error"
							})
							exit();
						}
						if (data[7] == "Y") {
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
									$href = "module/so/proses.php?id=";
									window.location.href = $href + id;
									// swal("Poof! Your imaginary file has been deleted!", {
									//   icon: "success",
									// });
								} else {
									//swal("Batal Hapus!");
								}
							});
					});

					$('#tbl-soh tbody').on('click', '.dt-unproses', function() {
						var data = table.row($(this).parents('tr')).data();
						var id = data[8];
						if (data[9] == "Y") {
							swal({
								title: "Data sudah batal !",
								text: "Aksi tidak bisa dilanjutkan",
								icon: "error"
							})
							exit();
						}
						if (data[7] == "N") {
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
									$href = "module/so/batal_proses.php?id=";
									window.location.href = $href + id;
									// swal("Poof! Your imaginary file has been deleted!", {
									//   icon: "success",
									// });
								} else {
									//swal("Batal Hapus!");
								}
							});
					});


					$('#tbl-soh tbody').on('click', '.dt-cetak', function() {
						var data = table.row($(this).parents('tr')).data();
						var id = data[8];
						if (data[7] == "N") {
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
									$href = "module/so/cetak.php?id=";
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