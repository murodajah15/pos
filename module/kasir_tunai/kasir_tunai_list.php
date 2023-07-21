<?php
$user = $_SESSION['username'];

function autoNumber($connect, $id, $table)
{
	//$query = 'SELECT MAX(RIGHT('.$id.', 4)) as max_id FROM '.$table.' ORDER BY '.$id;
	mysqli_query($connect, 'alter table' . $table . ' AUTO_INCREMENT=0');
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
	$new_code = 'KW' . $year . $nmonth . sprintf("%05s", $sort_num);
	return $new_code;
}

if (isset($_GET['tipe'])) {
	if ($_GET['tipe'] == 'tambah') {
		cekakses($connect, $user, 'Kasir Penerimaan Tunai');
		$lakses = $_SESSION['aksestambah'];
		date_default_timezone_set("Asia/Jakarta");
		$de = mysqli_fetch_assoc(mysqli_query($connect, "select * from saplikasi where aktif='Y'"));
		$tgl = $de['tgl_berikutnya']; //date('Y-m-d')
		$year = date('Y');
		$month = date('M');
		//<?php echo autoNumber($connect,'id','kasir_tunai');
		if ($lakses == 1) { ?>
			<font face='calibri'>
				<div class='panel panel-danger'>
					<div class='panel-heading'>
						<font size="4">TAMBAH DATA KASIR PENERIMAAN TUNAI</font>
					</div>
					<div class='panel-body'>
						<form method='post' name='po' enctype='multipart/form-data' action='module/kasir_tunai/proses_tambah.php'>
							<input type='hidden' name='username' value="<?= $user ?>">
							<div class='col-md-6'>
								<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
									<tr>
										<td>Nomor Kwitansi</td>
										<td>
											<input type='text' class='form-control' id='nokwitansi' name='nokwitansi' placeholder='No. Order *' style='text-transform:uppercase;text-align:left' value="<?php echo autoNumber($connect, 'id', 'kasir_tunai'); ?>" readonly>
										</td>
									</tr>
									<tr>
										<td>Tgl. (M/D/Y)</td>
										<td><input type='date' class='form-control' id='tglkwitansi' name='tglkwitansi' value="<?php echo $tgl ?>" size='50' autocomplete='off' required readonly></td>
									</tr>
									<tr>
										<td>Jenis Kwitansi
										<td><select required id='jnskwitansi' name='jnskwitansi' class='form-control' style='width: 200x;' onchange='changeValueDriver(this.value)'>
												<!--<option value=''> - PILIH JENIS KWITANSI - </option>";?>-->
												<option value="UANG-MUKA">UANG-MUKA</option>
												<option value="PELUNASAN">PELUNASAN</option>
											</select>
									<tr>
										<td>No. Penjualan</td>
										<td>
											<div class='input-group'> <input type='text' class='form-control' id='nojual' name='nojual' size='50' autocomplete='off' readonly required>
												<span class='input-group-btn'>
													<button type='button' id='src' class='btn btn-primary' onclick='cari_data_penjualan()'>
														Cari
													</button>
												</span>
										</td>
									<tr>
										<td>Customer</td>
										<td> <input type="text" class='form-control' id='nmcustomer' name='nmcustomer' size='50' readonly required></td>
									</tr>
									<input type="hidden" class='form-control' id='kdcustomer' name='kdcustomer' size='50' readonly required>
									<input type="hidden" class='form-control' id='total' name='total' size='50' readonly required>
									<tr>
										<td>Nilai Piutang</td>
										<td align='right'> <input type="number" class='form-control' id='piutang' name='piutang' value='0' size='50' style='text-align:right' readonly required></td>
									</tr>
									<tr>
										<td>Nilai Bayar</td>
										<td align='right'> <input type="number" class='form-control' id='bayar' name='bayar' value='0' size='50' style='text-align:right' onkeyup="hit_subtotal()" onblur="hit_subtotal()" required></td>
									</tr>
									<tr>
										<td>Uang diterima </td>
										<td> <input type="number" class='form-control' id='uang' name='uang' value='0' size='65' style='text-align:right' onkeyup="hit_subtotal()" onblur="hit_subtotal()" required></td>
									<tr>
										<td>Kembali </td>
										<td> <input type="number" class='form-control' id='kembali' name='kembali' value='0' size='35' style='text-align:right' readonly required></td>
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
								<table style=font-size:13px; class='table table-responsive'>
									<tr>
										<td>Bank</td>
										<td>
											<div class='input-group'> <input type='text' class='form-control' name='kdbank' id='kdbank' size='20' autocomplete='off' readonly required>
												<span class='input-group-btn'>
													<button type='button' id='src' class='btn btn-primary' onclick='cari_data_bank()'>Cari</button>
												</span>
										</td>
										<td> <input type="text" class='form-control' name='nmbank' id='nmbank' size='50' readonly required></td>
									</tr>
									<tr>
										<td>Jenis Kartu</td>
										<td>
											<div class='input-group'> <input type='text' class='form-control' name='kdjnskartu' id='kdjnskartu' size='20' autocomplete='off' readonly required>
												<span class='input-group-btn'>
													<button type='button' id='src' class='btn btn-primary' onclick='cari_data_jnskartu()'>Cari</button>
												</span>
										</td>
										<td> <input type="text" class='form-control' name='nmjnskartu' id='nmjnskartu' size='50' readonly required></td>
									</tr>
								</table>
								<table style=font-size:13px; class='table table-responsive'>
									<tr>
										<td>No. Rekening</td>
										<td> <input type="text" class='form-control' id='norek' name='norek' size='50'></td>
									</tr>
									<tr>
										<td>No. Giro/Cek</td>
										<td> <input type="text" class='form-control' id='nocekgiro' name='nocekgiro' size='50'></td>
									</tr>
									<tr>
										<td>Tgl. Terima Cek (M/D/Y)</td>
										<td><input type='date' class='form-control' id='tglterimacekgiro' name='tglterimacekgiro' value="<?php echo $tglterimacekgiro ?>" size='50' autocomplete='off'></td>
									</tr>
									<tr>
										<td>Tgl. Jt.Tempo Cek (M/D/Y)</td>
										<td><input type='date' class='form-control' id='tgljttempocekgiro' name='tgljttempocekgiro' value="<?php echo $tgljttempocekgiro ?>" size='50' autocomplete='off'></td>
									</tr>
									<tr>
										<td>Keterangan</td>
										<td><textarea type='text' class='form-control' id='kerangan' name='keterangan' autocomplete='off'></textarea></td>
									</tr>
								</table>
							</div>
							<div class='col-md-12' style='margin-left:-5px'>
								<label>&nbsp;</label>
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
		cekakses($connect, $user, 'Kasir Penerimaan Tunai');
		$lakses = $_SESSION['aksesedit'];
		if ($lakses == 1) {
			// $sql=mysqli_query($connect,"select * FROM kasir_tunai where id='$_GET[id]'");
			// $de=mysqli_fetch_assoc($sql);
			// $query = $connect->prepare("select * from kasir_tunai where id=?");
			// $query->bind_param('i',$_GET['id']);
			// $query->execute();
			// $result = $query->get_result();
			// $de = $result->fetch_assoc();
			$sql = mysqli_query($connect, "select * from kasir_tunai where id='$_GET[id]'");
			$de = mysqli_fetch_assoc($sql);
			$nokwitansi = strip_tags($de['nokwitansi']);
			$tglkwitansi = strip_tags($de['tglkwitansi']);
			$jnskwitansi = strip_tags($de['jnskwitansi']);
			$nojual = strip_tags($de['nojual']);
			$kdcustomer = strip_tags($de['kdcustomer']);
			$nmcustomer = strip_tags($de['nmcustomer']);
			$piutang = $de['piutang'];
			$bayar = $de['bayar'];
			$uang = $de['uang'];
			$kembali = $de['kembali'];
			$carabayar = strip_tags($de['carabayar']);
			$kdbank = strip_tags($de['kdbank']);
			$nmbank = strip_tags($de['nmbank']);
			$kdjnskartu = strip_tags($de['kdjnskartu']);
			$nmjnskartu = strip_tags($de['nmjnskartu']);
			$norek = strip_tags($de['norek']);
			$nocekgiro = strip_tags($de['nocekgiro']);
			$tglterimacekgiro = strip_tags($de['tglterimacekgiro']);
			$tgljttempocekgiro = strip_tags($de['tgljttempocekgiro']);
			$keterangan = strip_tags($de['keterangan']);
		?>
			<font face='calibri'>
				<div class="panel panel-default">
					<div class="panel-heading">
						<font size="4">EDIT DATA KASIR PENERIMAAN TUNAI</font>
					</div>
					<div class="panel-body">
						<form method='post' name='beli' enctype='multipart/form-data' action='module/kasir_tunai/proses_edit.php'>
							<input type='hidden' name='username' value="<?= $user ?>">
							<input type='hidden' name='id' value="<?= $de['id'] ?>" />
							<div class='col-md-6'>
								<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
									<tr>
										<td>Nomor Kwitansi</td>
										<td>
											<input type='text' class='form-control' id='nokwitansi' name='nokwitansi' placeholder='No. Order *' style='text-transform:uppercase;text-align:left' value="<?= $nokwitansi ?>" readonly>
										</td>
									</tr>
									<tr>
										<td>Tgl. (M/D/Y)</td>
										<td><input type='date' class='form-control' id='tglkwitansi' name='tglkwitansi' value="<?php echo $tglkwitansi ?>" size='50' autocomplete='off' required readonly></td>
									</tr>
									<tr>
										<td>JENIS KWITANSI</td>
										<td><select required name="jnskwitansi" id="jnskwitansi" class='form-control'>
												<?php
												$jnskwitansi = array('UANG-MUKA', 'PELUNASAN');
												$jml_kata = count($jnskwitansi);
												for ($c = 0; $c < $jml_kata; $c += 1) {
													if ($jnskwitansi[$c] == $de['jnskwitansi']) {
														echo "<option value=$jnskwitansi[$c] selected>$jnskwitansi[$c] </option>";
													} else {
														echo "<option value=$jnskwitansi[$c]> $jnskwitansi[$c] </option>";
													}
												}
												echo "</select>";
												?>
									<tr>
										<td>No. Penjualan</td>
										<td>
											<div class='input-group'> <input type='text' class='form-control' id='nojual' name='nojual' size='50' value="<?= $nojual ?>" autocomplete='off' readonly required>
												<span class='input-group-btn'>
													<button type='button' id='src' class='btn btn-primary' onclick='cari_data_penjualan()'>Cari</button>
												</span>
										</td>
									<tr>
										<td>Customer</td>
										<td> <input type="text" class='form-control' id='nmcustomer' name='nmcustomer' size='50' value="<?= $nmcustomer ?>" readonly required></td>
									</tr>
									<input type="hidden" class='form-control' id='kdcustomer' name='kdcustomer' size='50' value="<?= $kdcustomer ?>" readonly required>
									<tr>
										<td>Nilai Piutang</td>
										<td align='right'> <input type="number" class='form-control' id='piutang' name='piutang' size='50' value="<?= $piutang ?>" style='text-align:right' readonly required></td>
									</tr>
									<tr>
										<td>Nilai Bayar</td>
										<td align='right'> <input type="number" class='form-control' id='bayar' name='bayar' size='50' value="<?= $bayar ?>" style='text-align:right' onkeyup="hit_subtotal()" onblur="hit_subtotal()" required></td>
									</tr>
									<tr>
										<td>Uang diterima </td>
										<td> <input type="number" class='form-control' id='uang' name='uang' size='65' value="<?= $uang ?>" style='text-align:right' onkeyup="hit_subtotal()" onblur="hit_subtotal()" required></td>
									<tr>
										<td>Kembali </td>
										<td> <input type="number" class='form-control' id='kembali' name='kembali' size='35' value="<?= $kembali ?>" style='text-align:right' readonly required></td>
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
								<table style=font-size:13px; class='table table-responsive'>
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
								<table style=font-size:13px; class='table table-responsive'>
									<tr>
										<td>No. Rekening</td>
										<td> <input type="text" class='form-control' id='norek' name='norek' size='50' value="<?= $norek ?>"></td>
									</tr>
									<tr>
										<td>No. Giro/Cek</td>
										<td> <input type="text" class='form-control' id='nocekgiro' name='nocekgiro' size='50' value="<?= $nocekgiro ?>"></td>
									</tr>
									<tr>
										<td>Tgl. Terima Cek (M/D/Y)</td>
										<td><input type='date' class='form-control' id='tglterimacekgiro' name='tglterimacekgiro' value="<?php echo $tglterimacekgiro ?>" size='50' autocomplete='off'></td>
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
							<div class='col-md-12' style='margin-left:-5px'>
								<label>&nbsp;</label>
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
	/*<tr><td>Picture</td> <td>  <input type='file' class='form-control' name='picture' size='100' value='$de[picture]'></td></tr>**/
} else {
	?>

	<?php
	include 'cek_akses.php';
	?>

	<?php
	include 'cek_akses.php';
	if ($aksesok == 'Y') {
	?>

		<font face="calibri">
			<div class="panel panel-info">
				<div class="panel-heading">
					<font size="4">KASIR PENERIMAAN TUNAI</font>
				</div>
				<div class="panel-body">
					<form method='post'>
						<div class="row">
							<div class="col-md-12 bg">
								<a class="btn btn-danger" href="?m=kasir_tunai&tipe=tambah">Tambah data</a>
								<!--<a class="btn btn-success" href="?m=kasir_tunai&tipe=import">Import data</a>
				<a class="btn btn-warning" href="?m=kasir_tunai&tipe=export">Export data</a>-->
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
									<th>Tanggal</th>
									<th>No. Penjualan</th>
									<th>Customer</th>
									<th>Pembayaran</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<?php
							// Cek apakah terdapat data page pada URL
							$tampil = mysqli_query($connect, "SELECT * FROM kasir_tunai order by nokwitansi desc");
							$no = 1;
							while ($k = mysqli_fetch_assoc($tampil)) {
								$date = date("m/d/Y", strtotime($k['tglkwitansi']));
								$bayar = number_format($k['bayar'], 0, ",", ".");
								echo "<tr>
        <td align='center'>$no</td>
				<td width='110'><u><a href='#' onclick =lihat_detail('$k[nokwitansi]');><font color='blue'>$k[nokwitansi]</font></a></u></td>
				<td width='60'>$date</td>
				<td width='110'>$k[nojual]</td>
				<td width='150'>$k[nmcustomer]</td>
				<td width='90' align='right'>$bayar</td>
				<td align='center' width='350px'>";
								//echo "<a class='btn btn-success' href='?m=kasir_tunai&tipe=detail&id=$k[id]'>Upd.Dtl</a> ";
								if ($k['proses'] == 'Y') {
									echo "<a class='btn btn-info' href='?m=kasir_tunai&tipe=edit&id=$k[id]' disabled>Edit</a>";
								} else {
									echo "<a class='btn btn-info' href='?m=kasir_tunai&tipe=edit&id=$k[id]'>Edit</a>";
								}
								cekakses($connect, $user, 'Penerimaan Pembelian');
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
								cekakses($connect, $user, 'Penerimaan Pembelian');
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
								cekakses($connect, $user, 'Penerimaan Pembelian');
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
								cekakses($connect, $user, 'Pengeluaran Barang');
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
				function lihat_detail(id) {
					$('#modaldetail').modal('show');
					//$('#modaldetail').find('.modal-body').html(id);
					$.ajax({
						url: './module/kasir_tunai/lihat_detail.php',
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
								$href = "module/kasir_tunai/proses_hapus.php?id=";
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
								$href = "module/kasir_tunai/proses_hapus_detail.php?id=";
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
								$href = "module/kasir_tunai/proses.php?id=";
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
								$href = "module/kasir_tunai/batal_proses.php?id=";
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
					var lkembali = (parseInt(document.getElementById('uang').value) - parseInt(document.getElementById('bayar').value));
					document.getElementById('kembali').value = lkembali;
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

				function lihat_detail(id) {
					$('#modaldetail').modal('show');
					//$('#modaldetail').find('.modal-body').html(id);
					$.ajax({
						url: './module/kasir_tunai/lihat_detail.php',
						type: 'post',
						data: {
							kode: id
						},
						success: function(response) {
							$('#modaldetail').find('.modal-body').html(response);
						}
					});
				}

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
								$href = "module/kasir_tunai/cetak.php?id=";
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