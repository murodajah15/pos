<?php
$user = $_SESSION['username'];

if (isset($_GET['tipe'])) {
	if ($_GET['tipe'] == 'detail') {
		cekakses($connect, $user, 'Setup Aplikasi');
		$lakses = $_SESSION['aksespakai'];
		if ($lakses == 1) {
			$sql = mysqli_query($connect, "select * from saplikasi where id='$_GET[id]'");
			if (mysqli_num_rows($sql) >= "1") {
				$de = mysqli_fetch_assoc($sql);
				// $query = $connect->prepare("select * from saplikasi where id=?");
				// $query->bind_param('i', $_GET['id']);
				// $result = $query->execute();
				// $query->store_result();
				// if ($query->num_rows >= "1") {
				// 	$query->execute();
				// 	$result = $query->get_result();
				// 	$de = $result->fetch_assoc();
				$user = $de['user'];
				$kd_perusahaan = $de['kd_perusahaan'];
				$nm_perusahaan = $de['nm_perusahaan'];
				$alamat = $de['alamat'];
				$telp = $de['telp'];
				$npwp = $de['npwp'];
				$aktif = $de['aktif'];
				$user = $de['user'];
				$tgl_closing = $de['tgl_closing'];
				$tgl_berikutnya = $de['tgl_berikutnya'];
				$user_closing = $de['user_closing'];
				$direktur = $de['direktur'];
				$finance_mgr = $de['finance_mgr'];
				$norek1 = $de['norek1'];
				$norek2 = $de['norek2'];
				$closing_hpp = $de['closing_hpp'];
				$bulan = $de['bulan'];
				$tahun = $de['tahun'];
				$noso = $de['noso'];
				$nojual = $de['nojual'];
				$nopo = $de['nopo'];
				$nobeli = $de['nobeli'];
				$nokeluar = $de['nokeluar'];
				$noterima = $de['noterima'];
				$noopname = $de['noopname'];
				$noapprov = $de['noapprov'];
				$nokwtunai = $de['nokwtunai'];
				$nokwtagihan = $de['nokwtagihan'];
				$nomohon = $de['nomohon'];
				$nokwkeluar = $de['nokwkeluar'];
				$dirbackup = $de['dirbackup'];
				$kunci_harga_jual = $de['kunci_harga_jual'];
				$kunci_stock = $de['kunci_stock'];
?>
				<font face='calibri'>
					<div class="panel panel-warning">
						<div class="panel-heading">
							<font size="4">DETAIL DATA SETUP APLIKASI</font>
						</div>
						<div class="panel-body">
							<form method="post" enctype="multipart/form-data" action="module/saplikasi/proses_edit.php">
								<input type="hidden" name="username" value="<?= $user ?>">
								<input type="hidden" name="id" value="<?= $de["id"] ?>">
								<div class='col-md-6'>
									<table style=font-size:13px; class='table table-striped table table-bordered'>
										<tr>
											<td width="150">Perusahaan</td>
											<td> <input type='text' class='form-control' name='kd_perusahaan' value="<?= $kd_perusahaan ?>" readonly></td>
										</tr>
										<tr>
											<td>Perusahaan</td>
											<td> <input type='text' class='form-control' name='nm_perusahaan' value="<?= $nm_perusahaan ?>" readonly></td>
										</tr>
										<tr>
											<td>Alamat</td>
											<td> <textarea rows='3' class='form-control' name='alamat' id='alamat' readonlyz><?= $alamat ?></textarea></td>
										</tr>
										<tr>
											<td>Telpon</td>
											<td> <input type='text' class='form-control' name='telp' value="<?= $telp ?>" readonly></td>
										</tr>
										<tr>
											<td>NPWP</td>
											<td> <input type='text' class='form-control' name='npwp' value="<?= $npwp ?>" readonly></td>
										</tr>
										<tr>
											<td>Direktur</td>
											<td><input type='text' class='form-control' name='direktur' value="<?= $direktur ?>" readonly></td>
										</tr>
										<tr>
											<td>Finance Manager</td>
											<td><input type='text' class='form-control' name='finance_mgr' value="<?= $finance_mgr ?>" readonly></td>
										</tr>
										<tr>
											<td>Nomor Rekening 1</td>
											<td><input type='text' class='form-control' name='norek1' value="<?= $norek1 ?>" readonly></td>
										</tr>
										<tr>
											<td>Nomor Rekening 2</td>
											<td><input type='text' class='form-control' name='norek2' value="<?= $norek2 ?>" readonly></td>
										</tr>
										<tr>
											<td>Jenis HPP</td>
											<td>
												<select name=jenis_hpp class='form-control' disabled>
													<?php
													$jenis_hpp = array("FIFO", "LIFO", "AVERAGE");
													$jlh_bln = count($jenis_hpp);
													for ($c = 0; $c < $jlh_bln; $c += 1) {
														if ($jenis_hpp[$c] == $de['jenis_hpp']) {
															echo "<option value=$jenis_hpp[$c] selected>$jenis_hpp[$c] </option>";
														} else {
															echo "<option value=$jenis_hpp[$c]> $jenis_hpp[$c] </option>";
														}
													}
													/*?>**/
													echo "</select>"; ?>
										<tr>
											<td>Tanggal Closing</td>
											<td> <input type='text' class='form-control' value="<?= $tgl_closing ?>" readonly></td>
										</tr>
										<tr>
											<td>Tanggal Transaksi Berikutnya</td>
											<td> <input type='text' class='form-control' value="<?= $tgl_berikutnya ?>" readonly></td>
										</tr>
										<tr>
											<td>User Closing</td>
											<td> <input type='text' class='form-control' value="<?= $user_closing ?>" readonly></td>
										</tr>
										<tr>
											<td>Closing HPP</td>
											<td> <input type='text' class='form-control' value="<?= $closing_hpp ?>" readonly></td>
										</tr>
										<tr>
											<td>User</td>
											<td> <input type='text' class='form-control' name='user' value="<?= $user ?>" size='100' readonly></td>
										<tr>
											<td>Kunci Harga Jual</td>
											<td> <input type='text' class='form-control' value="<?= $kunci_harga_jual ?>" readonly></td>
										</tr>
										<tr>
											<td>Kunci Stock</td>
											<td> <input type='text' class='form-control' value="<?= $kunci_stock ?>" readonly></td>
										</tr>
										<tr>
											<td>Aktif</td>
											<td> <input type='text' class='form-control' name='aktif' value="<?= $aktif ?>" readonly></td>
										</tr>
									</table>
								</div>
								<div class='col-md-3'>
									<table style=font-size:13px; class='table table-striped table table-bordered'>
										<tr>
											<td>Logo</td>
											<?php
											echo "<td><img src='img/$de[logo]' width='50></td></tr>
									<input type='hidden' name='x' id='x' value='$de[logo]'>"; ?>
										<tr>
											<td>Bulan Closing</td>
											<td><input type='text' class='form-control' name='closing_hpp' value="<?= $closing_hpp ?>" readonly></td>
										</tr>
										<tr>
											<td>Bulan Berjalan</td>
											<td><input type='text' class='form-control' name='bulan' value="<?= $bulan ?>" readonly></td>
										</tr>
										<tr>
											<td>Tahun Berjalan</td>
											<td><input type='text' class='form-control' name='tahun' value="<?= $tahun ?>" readonly></td>
										</tr>
										<tr>
											<td>Nomor SO</td>
											<td><input type='text' class='form-control' name='noso' value="<?= $noso ?>" readonly></td>
										</tr>
										<tr>
											<td>Nomor Jual</td>
											<td><input type='text' class='form-control' name='nojual' value="<?= $nojual ?>" readonly></td>
										</tr>
										<tr>
											<td>Nomor PO</td>
											<td><input type='text' class='form-control' name='nopo' value="<?= $nopo ?>" readonly></td>
										</tr>
										<tr>
											<td>Nomor Pembelian</td>
											<td><input type='text' class='form-control' name='nobeli' value="<?= $nobeli ?>" readonly></td>
										</tr>
										<tr>
											<td>Nomor Penerimaan</td>
											<td><input type='text' class='form-control' name='noterima' value="<?= $noterima ?>" readonly></td>
										</tr>
									</table>
								</div>
								<div class='col-md-3'>
									<table style=font-size:13px; class='table table-striped table table-bordered'>
										<tr>
											<td>Nomor Pengeluaran</td>
											<td><input type='text' class='form-control' name='nokeluar' value="<?= $nokeluar ?>" readonly></td>
										</tr>
										<tr>
											<td>Nomor Stock Opname</td>
											<td><input type='text' class='form-control' name='noopname' value="<?= $noopname ?>" readonly></td>
										</tr>
										<tr>
											<td>Nomor Approval Piutang</td>
											<td><input type='text' class='form-control' name='noapprov' value="<?= $noapprov ?>" readonly></td>
										</tr>
										<tr>
											<td>Nomor Kasir Tunai</td>
											<td><input type='text' class='form-control' name='nokwtunai' value="<?= $nokwtunai ?>" readonly></td>
										</tr>
										<tr>
											<td>Nomor Kasir Tagihan</td>
											<td><input type='text' class='form-control' name='nokwtagihan' value="<?= $nokwtagihan ?>" readonly></td>
										</tr>
										<tr>
											<td>Nomor Permohonan Keluar</td>
											<td><input type='text' class='form-control' name='nomohon' value="<?= $nomohon ?>" readonly></td>
										</tr>
										<tr>
											<td>Nomor Kasir Keluar</td>
											<td><input type='text' class='form-control' name='nokwkeluar' value="<?= $nokwkeluar ?>" readonly></td>
										</tr>
									</table>
								</div>
								<div class='col-md-12'>
									<label>&nbsp;</label>
									<input button type='Button' class='btn btn-danger' value='Close' onClick='history.back()' />
								</div>

						</div>
					</div>
					</form>
				</font>
			<?php }
		} else {
			echo "<script>alert('Anda tidak berhak !');history.go(-1) </script>";
		}
	}
}

if (isset($_GET['tipe'])) {
	if ($_GET['tipe'] == 'tambah') {
		cekakses($connect, $user, 'Setup Aplikasi');
		$lakses = $_SESSION['aksestambah'];
		if ($lakses == 1) { ?>
			<font face='calibri'>
				<div class='panel panel-danger'>
					<div class='panel-heading'>
						<font size="4">TAMBAH DATA SETUP APLIKASI</font>
					</div>
					<div class='panel-body'>
						<form method='post' name='saplikasi' enctype='multipart/form-data' action='module/saplikasi/proses_tambah.php'>
							<input type='hidden' name='username' value="<?= $user ?>">
							<div class='col-md-6'>
								<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
									<tr>
										<td>Kode</td>
										<td> <input type='text' class='form-control' name='kd_perusahaan' size='20' autofocus='autofocus' required></td>
									<tr>
										<td>Perusahaan</td>
										<td> <input type='text' class='form-control' name='nm_perusahaan' size='100' required></td>
									<tr>
										<td>Alamat</td>
										<td> <textarea rows='3' class='form-control' name='alamat' id='alamat'></textarea></td>
									</tr>
									<tr>
										<td>Telpon</td>
										<td> <input type='text' class='form-control' name='telp'></td>
									</tr>
									<tr>
										<td>NPWP</td>
										<td> <input type='text' class='form-control' name='npwp' size='100'></td>

									<tr>
										<td>Nomor Rekening 1</td>
										<td><input type='text' class='form-control' name='norek1' value=""></td>
									</tr>
									<tr>
										<td>Nomor Rekening 2</td>
										<td><input type='text' class='form-control' name='norek2' value=""></td>
									</tr>
								</table>
							</div>
							<div class='col-md-6'>
								<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
									<tr>
										<td>Jenis HPP</td>
										<td>
											<select name=jenis_hpp class='form-control' required>
												<option value='FIFO'> FIFO</option>
												<option value='LIFO'> LIFO</option>
												<option value='AVERAGE'> AVERAGE</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Direktur</td>
										<td><input type='text' class='form-control' name='direktur'></td>
									</tr>
									<tr>
										<td>Finance Manager</td>
										<td><input type='text' class='form-control' name='finance_mgr'></td>
									</tr>
									<tr>
										<td>Directory Backup</td>
										<td><input type='text' class='form-control' name='dirbackup'></td>
									</tr>
									<tr>
										<td>Logo</td>
										<td><input type='file' name='logo' id='logo'>
									<tr>
										<td>Kunci Harga Jual</td>
										<td>
											<input type=radio name='kunci_harga_jual' value='Y' checked> Y
											<input type=radio name='kunci_harga_jual' value='N'> N
										</td>
									</tr>
									<tr>
										<td>Kunci Stock</td>
										<td>
											<input type=radio name='kunci_stock' value='Y' checked> Y
											<input type=radio name='kunci_stock' value='N'> N
										</td>
									</tr>
									<tr>
										<td>Aktif</td>
										<td> <input type=radio name='aktif' value='Y' checked> Y
											<input type=radio name='aktif' value='N'> N
										</td>
									</tr>
								</table>
								</table>
							</div>
							<div class='col-md-12'>
								<button type='submit' class='btn btn-success'>Simpan</button>
								<input button type='Button' class='btn btn-danger' value='Batal' onClick='history.back()' />
							</div>
					</div>
					</form>
			</font>
			</div>
			<?php } else {
			echo "<script>alert('Anda tidak berhak !');history.go(-1) </script>";
		}
	} elseif ($_GET['tipe'] == 'edit') {
		cekakses($connect, $user, 'Setup Aplikasi');
		$lakses = $_SESSION['aksesedit'];
		if ($lakses == 1) {
			$sql = mysqli_query($connect, "select * from saplikasi where id='$_GET[id]'");
			if (mysqli_num_rows($sql) >= "1") {
				$de = mysqli_fetch_assoc($sql);
				// $query = $connect->prepare("select * from saplikasi where id=?");
				// $query->bind_param('i', $_GET['id']);
				// $result = $query->execute();
				// $query->store_result();
				// if ($query->num_rows >= "1") {
				// 	$query->execute();
				// 	$result = $query->get_result();
				// 	$de = $result->fetch_assoc();
				$kd_perusahaan = $de['kd_perusahaan'];
				$nm_perusahaan = $de['nm_perusahaan'];
				$alamat = $de['alamat'];
				$telp = $de['telp'];
				$npwp = $de['npwp'];
				$direktur = $de['direktur'];
				$finance_mgr = $de['finance_mgr'];
				$norek1 = $de['norek1'];
				$norek2 = $de['norek2'];
				$closing_hpp = $de['closing_hpp'];
				$bulan = $de['bulan'];
				$tahun = $de['tahun'];
				$noso = $de['noso'];
				$nojual = $de['nojual'];
				$nopo = $de['nopo'];
				$nobeli = $de['nobeli'];
				$nokeluar = $de['nokeluar'];
				$noterima = $de['noterima'];
				$noopname = $de['noopname'];
				$noapprov = $de['noapprov'];
				$nokwtunai = $de['nokwtunai'];
				$nokwtagihan = $de['nokwtagihan'];
				$nomohon = $de['nomohon'];
				$nokwkeluar = $de['nokwkeluar'];
				$dirbackup = $de['dirbackup'];
				$kunci_harga_jual = $de['kunci_harga_jual'];
				$kunci_stock = $de['kunci_stock'];
			?>
				<font face='calibri'>
					<div class="panel panel-warning">
						<div class="panel-heading">
							<font size="4">EDIT DATA SETUP APLIKASI</font>
						</div>
						<div class="panel-body">
							<form method="post" enctype="multipart/form-data" action="module/saplikasi/proses_edit.php">
								<input type="hidden" name="username" value="<?= $user ?>">
								<input type="hidden" name="id" value="<?= $de["id"] ?>">
								<input type='hidden' name='logolama' id='logolama' value='<?= $de['logo'] ?>' />
								<div class='col-md-6'>
									<table style=font-size:13px; class='table table-striped table table-bordered'>
										<tr>
											<td>Kode Perusahaan</td>
											<td> <input type="text" class='form-control' name='kd_perusahaan' value="<?= $kd_perusahaan ?>" readonly></td>
										</tr>
										<tr>
											<td>Nama Perusahaan</td>
											<td> <input type="text" class='form-control' name='nm_perusahaan' value="<?= $nm_perusahaan ?>" autofocus='autofocus'></td>
										</tr>
										<tr>
											<td>Alamat</td>
											<td> <textarea rows='3' class='form-control' name='alamat' id='alamat'><?= $alamat ?></textarea></td>
										</tr>
										<tr>
											<td>Telpon</td>
											<td> <input type='text' class='form-control' name='telp' value="<?= $telp ?>"></td>
										</tr>
										<tr>
											<td>NPWP</td>
											<td> <input type='text' class='form-control' name='npwp' value="<?= $npwp ?>"></td>
										</tr>
										<tr>
											<td>Direktur</td>
											<td><input type='text' class='form-control' name='direktur' value="<?= $direktur ?>"></td>
										</tr>
										<tr>
											<td>Finance Manager</td>
											<td><input type='text' class='form-control' name='finance_mgr' value="<?= $finance_mgr ?>"></td>
										</tr>
										<tr>
											<td>Nomor Rekening 1</td>
											<td><input type='text' class='form-control' name='norek1' value="<?= $norek1 ?>"></td>
										</tr>
										<tr>
											<td>Nomor Rekening 2</td>
											<td><input type='text' class='form-control' name='norek2' value="<?= $norek2 ?>"></td>
										</tr>
										<tr>
											<td>Directory Backup</td>
											<td><input type='text' class='form-control' name='dirbackup' value="<?= $dirbackup ?>"></td>
										</tr>
										<tr>
											<td>Jenis HPP</td>
											<td>
												<select name=jenis_hpp class='form-control'>
													<?php
													$jenis_hpp = array("FIFO", "LIFO", "AVERAGE");
													$jlh_bln = count($jenis_hpp);
													for ($c = 0; $c < $jlh_bln; $c += 1) {
														if ($jenis_hpp[$c] == $de['jenis_hpp']) {
															echo "<option value=$jenis_hpp[$c] selected>$jenis_hpp[$c] </option>";
														} else {
															echo "<option value=$jenis_hpp[$c]> $jenis_hpp[$c] </option>";
														}
													}
													/*?>**/
													/*?>**/
													echo "</select>"; ?>
													<?php
													if ("$de[kunci_harga_jual]" == 'N') {
														echo "<tr><td>Kunci Harga Jual</td>     <td> : <input type=radio name='kunci_harga_jual' value='Y'> Y 
																		  <input type=radio name='kunci_harga_jual' value='N' checked> N </td></tr>";
													} else {
														echo "<tr><td>Kunci Harga Jual</td>     <td> : <input type=radio name='kunci_harga_jual' value='Y' checked> Y  
																		  <input type=radio name='kunci_harga_jual' value='N'> N </td></tr>";
													}
													if ("$de[kunci_stock]" == 'N') {
														echo "<tr><td>Kunci Stock</td>     <td> : <input type=radio name='kunci_stock' value='Y'> Y 
																		  <input type=radio name='kunci_stock' value='N' checked> N </td></tr>";
													} else {
														echo "<tr><td>Kunci Stock</td>     <td> : <input type=radio name='kunci_stock' value='Y' checked> Y  
																		  <input type=radio name='kunci_stock' value='N'> N </td></tr>";
													}
													?>
												</select>
												<?php
												if ("$de[aktif]" == 'N') {
													echo "<tr><td>Aktif</td>     <td> : <input type=radio name='aktif' value='Y'> Y 
																		  <input type=radio name='aktif' value='N' checked> N </td></tr></table>";
												} else {
													echo "<tr><td>Aktif</td>     <td> : <input type=radio name='aktif' value='Y' checked> Y  
																		  <input type=radio name='aktif' value='N'> N </td></tr></table>";
												}
												?>
									</table>
								</div>
								<div class='col-md-3'>
									<table style=font-size:13px; class='table table-striped table table-bordered'>
										<tr>
											<td>Logo <input type='checkbox' class='form-control' name='llogo' value='llogo' checked='checked'></td>
											<td> <input type='file' class='form-control' name='logo'></td>
										</tr>

										<?php
										echo "<td><img src='img/$de[logo]' width='50></td></tr>
									<input type='hidden' name='x' id='x' value='$de[logo]'>"; ?>
										<tr>
											<td>Bulan Closing</td>
											<td><input type='text' class='form-control' name='closing_hpp' value="<?= $closing_hpp ?>" readonly></td>
										</tr>
										<tr>
											<td>Bulan Berjalan</td>
											<td><input type='text' class='form-control' name='bulan' value="<?= $bulan ?>"></td>
										</tr>
										<tr>
											<td>Tahun Berjalan</td>
											<td><input type='text' class='form-control' name='tahun' value="<?= $tahun ?>"></td>
										</tr>
										<tr>
											<td>Nomor SO</td>
											<td><input type='text' class='form-control' name='noso' value="<?= $noso ?>"></td>
										</tr>
										<tr>
											<td>Nomor Jual</td>
											<td><input type='text' class='form-control' name='nojual' value="<?= $nojual ?>"></td>
										</tr>
										<tr>
											<td>Nomor PO</td>
											<td><input type='text' class='form-control' name='nopo' value="<?= $nopo ?>"></td>
										</tr>
										<tr>
											<td>Nomor Pembelian</td>
											<td><input type='text' class='form-control' name='nobeli' value="<?= $nobeli ?>"></td>
										</tr>
										<tr>
											<td>Nomor Penerimaan</td>
											<td><input type='text' class='form-control' name='noterima' value="<?= $noterima ?>"></td>
										</tr>
									</table>
								</div>
								<div class='col-md-3'>
									<table style=font-size:13px; class='table table-striped table table-bordered'>
										<tr>
											<td>Nomor Pengeluaran</td>
											<td><input type='text' class='form-control' name='nokeluar' value="<?= $nokeluar ?>"></td>
										</tr>
										<tr>
											<td>Nomor Stock Opname</td>
											<td><input type='text' class='form-control' name='noopname' value="<?= $noopname ?>"></td>
										</tr>
										<tr>
											<td>Nomor Approval Piutang</td>
											<td><input type='text' class='form-control' name='noapprov' value="<?= $noapprov ?>"></td>
										</tr>
										<tr>
											<td>Nomor Kasir Tunai</td>
											<td><input type='text' class='form-control' name='nokwtunai' value="<?= $nokwtunai ?>"></td>
										</tr>
										<tr>
											<td>Nomor Kasir Tagihan</td>
											<td><input type='text' class='form-control' name='nokwtagihan' value="<?= $nokwtagihan ?>"></td>
										</tr>
										<tr>
											<td>Nomor Permohonan Keluar</td>
											<td><input type='text' class='form-control' name='nomohon' value="<?= $nomohon ?>"></td>
										</tr>
										<tr>
											<td>Nomor Kasir Keluar</td>
											<td><input type='text' class='form-control' name='nokwkeluar' value="<?= $nokwkeluar ?>"></td>
										</tr>
									</table>
								</div>
								<div class='col-md-12'>
									<button type='submit' class='btn btn-primary'>Simpan</button>
									<input button type='Button' class='btn btn-danger' value='Batal' onClick='history.back()' />
								</div>
						</div>
						</form>
				</font>
	<?php
			}
		} else {
			echo "<script>alert('Anda tidak berhak !');history.go(-1) </script>";
		}
	}
	/*<tr><td>Picture</td> <td>  <input type='file' class='form-control' name='picture' size='100' value='$de[picture]'></td></tr>**/
} else {
	?>
	<?php
	include 'cek_akses.php';
	?>

	<?php
	if ($aksesok == 'Y') {
	?>

		<font face="calibri">
			<div class="panel panel-info">
				<div class="panel-heading">
					<font size="4">PENERIMAAN BARANG</font>
				</div>
				<div class="panel-body">
					<form method='get'>
						<div class="row">
							<?php
							include('hal_get.php')
							?>
							<div class="col-md-4 bg">
								<input type="hidden" name="m" value="saplikasi">
								<input type='text' id='kata' name='kata' value="<?= $kata ?>" size='50px' class='form-control' placeholder='KODE, PERUSAHAAN' onkeyup='searchTable()'>
							</div>
							<button type='submit' class='btn btn-primary'>
								<span class='glyphicon glyphicon-search'></span> Cari</button>
							<a class="btn btn-danger" href="?m=saplikasi&tipe=tambah">Tambah data</a>
						</div>
					</form>
					</br>
					<div class="box-body table-responsive">
						<table id="example1" class="table table-bordered table-striped">
							<tbody>
								<tr>
									<th width='50'>No.</th>
									<th>Kode</th>
									<th>Perusahaan</th>
									<th>Aktif</th>
									<th>User</th>
									<th>Aksi</th>
								</tr>
								<?php
								// Cek apakah terdapat data page pada URL
								$page = (isset($_GET['page']) ? $_GET['page'] : 1);
								if (isset($_GET['record'])) {
									$_SESSION['jmlperhalaman'] = $_GET['record'];
									$limit = $_GET['record']; //5; // Jumlah data per halamannya**/
								} else {
									$limit = $_SESSION['jmlperhalaman'];
								}
								$limit_start = ($page - 1) * $limit;
								// Untuk menentukan dari data ke berapa yang akan ditampilkan pada tabel yang ada di database
								if (empty($_GET['kata'])) {
									$tampil = mysqli_query($connect, "SELECT * FROM saplikasi order by nm_perusahaan desc LIMIT " . $limit_start . "," . $limit);
								} else {
									$cari = $_GET['kata'];
									$tampil = mysqli_query($connect, "SELECT * FROM saplikasi WHERE (nm_perusahaan like '%$cari%' or kd_perusahaan like '%$cari%') order by nm_perusahaan desc LIMIT " . $limit_start . "," . $limit);
								}
								if ($page == 1) {
									$posisi = 0;
									$_GET['halaman'] = 1;
								} else {
									$posisi = ($_GET['page'] - 1) * $limit;
								}
								$no = $posisi + 1;
								while ($k = mysqli_fetch_assoc($tampil)) {
									echo "<tr>
      <td align='center'>$no</td>
			<td><u><a href='?m=saplikasi&tipe=detail&id=$k[id]'><font color='blue'>$k[kd_perusahaan]</font></a></u></td>
			<td>$k[nm_perusahaan]</td>
			<td width='70' align='center'>$k[aktif]</td>
			<td>$k[user]</td>
      <td align='center' width='150px'>
      <a class='btn btn-info' href='?m=saplikasi&tipe=edit&id=$k[id]'>Edit</a>";
									cekakses($connect, $user, 'Setup Aplikasi');
									$lakses = $_SESSION['akseshapus'];
									$lakses = 1;
									if ($lakses == 1) {
										// echo " <a class='btn btn-danger' href='module/saplikasi/proses_hapus.php?id=$k[id]&kd_perusahaan=$k[kd_perusahaan]'
										// onClick='return confirm(\"Anda yakin akan menghapus ?\")'>Hapus</a>";
										echo " <input button type='Button' class='btn btn-danger' value='Hapus' onClick='alert_hapus($k[id])'/>";
									}
									echo "</td>";
									$no++;
								}
								?>
							</tbody>
						</table>
						<?php
						if (empty($_GET['kata'])) {
							$query = mysqli_query($connect, "select count(*) as jumrec from saplikasi");
						} else {
							$cari = $_GET['kata'];
							$query = mysqli_query($connect, "select count(*) as jumrec from saplikasi where (nm_perusahaan like '%$cari%' or kd_perusahaan like '%$cari%')");
						}
						$result = mysqli_fetch_array($query);
						echo "<p style='text-align:left'>Jumlah Record : " . number_format($result['jumrec'], 0, ",", ".");
						?>
					</div>
					<ul class="pagination">
						<!-- LINK FIRST AND PREV -->
						<?php
						if ($page == 1) { // Jika page adalah page ke 1, maka disable link PREV
						?>
							<li class="disabled"><a href="#">First</a></li>
							<li class="disabled"><a href="#">&laquo;</a></li>
						<?php
						} else { // Jika page bukan page ke 1
							$link_prev = ($page > 1) ? $page - 1 : 1;
						?>
							<li><a href="dashboard.php?m=saplikasi&kata=<?= $kata ?>&page=1">First</a></li>
							<li><a href="dashboard.php?m=saplikasi&kata=<?= $kata ?>&page=<?php echo $link_prev; ?>">&laquo;</a></li>
						<?php
						}
						?>
						<!-- LINK NUMBER -->
						<?php
						// Buat query untuk menghitung semua jumlah data
						if (empty($_GET['kata'])) {
							$tampil = mysqli_query($connect, "SELECT * FROM saplikasi order by nm_perusahaan desc ");
						} else {
							$cari = $_GET['kata'];
							$tampil = mysqli_query($connect, "SELECT * FROM saplikasi WHERE (nm_perusahaan like '%$cari%' or kd_perusahaan like '%$cari%') order by nm_perusahaan desc ");
						}
						$get_jumlah = mysqli_num_rows($tampil);
						//echo $get_jumlah;			
						/*$jumlah_page = ceil($get_jumlah['jumlah'] / $limit); // Hitung jumlah halamannya**/
						$jumlah_page = ceil($get_jumlah / $limit);
						$jumlah_number = 2; // Tentukan jumlah link number sebelum dan sesudah page yang aktif
						$start_number = ($page > $jumlah_number) ? $page - $jumlah_number : 1; // Untuk awal link number
						$end_number = ($page < ($jumlah_page - $jumlah_number)) ? $page + $jumlah_number : $jumlah_page; // Untuk akhir link number

						for ($i = $start_number; $i <= $end_number; $i++) {
							$link_active = ($page == $i) ? ' class="active"' : '';
						?>
							<li<?php echo $link_active; ?>><a href="dashboard.php?m=saplikasi&kata=<?= $kata ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
							<?php
						}
							?>

							<!-- LINK NEXT AND LAST -->
							<?php
							// Jika page sama dengan jumlah page, maka disable link NEXT nya
							// Artinya page tersebut adalah page terakhir 
							if ($page == $jumlah_page) { // Jika page terakhir
							?>
								<li class="disabled"><a href="#">&raquo;</a></li>
								<li class="disabled"><a href="#">Last</a></li>
							<?php
							} else { // Jika Bukan page terakhir
								$link_next = ($page < $jumlah_page) ? $page + 1 : $jumlah_page;
							?>
								<li><a href="dashboard.php?m=saplikasi&kata=<?= $kata ?>&page=<?php echo $link_next; ?>">&raquo;</a></li>
								<li><a href="dashboard.php?m=saplikasi&kata=<?= $kata ?>&page=<?php echo $jumlah_page; ?>">Last</a></li>
							<?php
							}
							?>
					</ul>
				</div>
			<?php
		} else {
			echo "<font color='red'>Anda tidak punya hak !</font>";
		} ?>
		<?php
	}
		?>

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
							//alert($kode);
							$href = "module/saplikasi/proses_hapus.php?id=";
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