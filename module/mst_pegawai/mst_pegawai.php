<?php
$user = $_SESSION['username'];
$kdese_kdsat = $_SESSION['kdese_kdsat'];

if (isset($_GET['tipe'])) {
	if ($_GET['tipe'] == 'import') {
		cekakses($connect, $user, 'Master Pegawai');
		$lakses = $_SESSION['aksestambah'];
		if ($lakses == 1) { ?>
			<font face='calibri'>
				<h3>Import Data Master Pegawai</h3>
				<h5>Proses ini akan menghapus seluruh data dulu, baru memasukan data ...</h5>
				<form method='post' enctype='multipart/form-data' action='module/mst_pegawai/proses_import.php'>
					<input type='hidden' name='username' value=<?php echo $user; ?>>
					Pilih File Excel*: (NIP yang sama tidak akan di import ke Master Pegawai)
					<input name='fileexcel' type='file' accept='application/vnd.ms-excel'></br> <!--<input name='upload' type='submit' value='Import'>-->
					<label>&nbsp;</label>
					<button type='submit' class='btn btn-primary' name='upload' value='import'>Import</button>
					<input button type='Button' class='btn btn-danger' value='Selesai' onClick='history.back()' />
				</form>
			</font><?php
						} else {
							echo "<script>alert('Anda tidak berhak !');history.go(-1) </script>";
						}
					}
				}

				if (isset($_GET['tipe'])) {
					if ($_GET['tipe'] == 'export') {
						cekakses($connect, $user, 'Master Pegawai');
						$lakses = $_SESSION['aksescetak'];
						if ($lakses == 1) { ?>
			<font face='calibri'>
				<h3>Export Data Master Pegawai</h3>
				<form method='post' enctype='multipart/form-data' action='module/mst_pegawai/proses_export.php'>
					<input type='hidden' name='username' value=<?php echo $user; ?>>
					Type : <select name=typefile class='form-control' required>
						<option value='Excel'> Excel</option>
						<option value='CSV'> CSV</option>
					</select><br>
					<label>&nbsp;</label>
					<button type='submit' class='btn btn-primary' name='upload' value='export'>Export</button>
					<input button type='Button' class='btn btn-danger' value='Selesai' onClick='history.back()' />
				</form>
			</font><?php
						} else {
							echo "<script>alert('Anda tidak berhak !');history.go(-1) </script>";
						}
					}
				}

				if (isset($_GET['tipe'])) {
					if ($_GET['tipe'] == 'detail') {
						cekakses($connect, $user, 'Master Pegawai');
						$lakses = $_SESSION['aksespakai'];
						if ($lakses == 1) {
							$sql = mysqli_query($connect, "select * from mst_pegawai where id='$_GET[id]'");
							$de = mysqli_fetch_assoc($sql); ?>
			<font face='calibri'>
				<h3>Detail Data Master Pegawai</h3>
				<form method='post' enctype='multipart/form-data'>
					<input type='hidden' name='username' value=$user>
					<input type='hidden' name='id' value='$de[id]' />
					<table style=font-size:13px; class='table table-striped table table-bordered'>
						<tr>
							<td>NIP</td>
							<td> <input type=text class='form-control' name='nip' value=<?php echo "'$de[nip]'" ?> readonly></td>
						</tr>
						<tr>
							<td>Nama Pegawai</td>
							<td> <input type=text class='form-control' name='nama_alias' value=<?php echo "'$de[nama_alias]'" ?> readonly></td>
						</tr>
						<tr>
							<td>NPWP</td>
							<td> <input type=text class='form-control' name='npwp' value=<?php echo "'$de[npwp]'" ?> readonly></td>
						</tr>
						<tr>
							<td>Status (PNS/CPNS) </td>
							<td> <input type=text class='form-control' name='nama' value=<?php echo "'$de[status]'" ?> readonly></td>
						</tr>
						<tr>
							<td>Kode Satuan Kerja</td>
							<td> <input type=text class='form-control' name='kdgrade' value=<?php echo "'$de[kdsatker]'" ?> readonly></td>
						</tr>
						<tr>
							<td>Nama Satuan Kerja</td>
							<td> <input type=text class='form-control' name='nmgrade' value=<?php echo "'$de[nmsatker]'" ?> readonly></td>
						</tr>
						<tr>
							<td>Kode Eselon</td>
							<td> <input type=text class='form-control' name='kdeselon' value=<?php echo "'$de[kdeselon]'" ?> readonly></td>
						</tr>
						<tr>
							<td>Nama Nama Eselon</td>
							<td> <input type=text class='form-control' name='nmgeselon' value=<?php echo "'$de[nmeselon]'" ?> readonly></td>
						</tr>
						<tr>
							<td>Golongan</td>
							<td> <input type=text class='form-control' name='kdgrade' value=<?php echo "'$de[golongan]'" ?> readonly></td>
						</tr>
						<tr>
							<td>Kelas Jabatan</td>
							<td> <input type=text class='form-control' name='kelas_jabatan' value=<?php echo "'$de[kelas_jabatan]'" ?> readonly></td>
						</tr>
						<tr>
							<td>Tunjangan Kinerja</td>
							<td> <input type=text class='form-control' name='tukin' value=<?php echo "'$de[tukin]'" ?> readonly></td>
						</tr>
						<tr>
							<td>Pangkat</td>
							<td> <input type=text class='form-control' name='nmgrade' value=<?php echo "'$de[pangkat]'" ?> readonly></td>
						</tr>
						<tr>
							<td>Jabatan</td>
							<td> <input type=text class='form-control' name='nmgrade' value=<?php echo "'$de[jabatan]'" ?> readonly></td>
						</tr>
						<tr>
							<td>No. Rekening</td>
							<td> <input type=text class='form-control' name='nmgrade' value=<?php echo "'$de[norek]'" ?> readonly></td>
						</tr>
						<tr>
							<td>Bank</td>
							<td> <input type=text class='form-control' name='nmgrade' value=<?php echo "'$de[bank]'" ?> readonly></td>
						</tr>
						<tr>
							<td>Nama Rekening</td>
							<td> <input type=text class='form-control' name='nama' value=<?php echo "'$de[nama]'" ?> readonly></td>
						</tr>
						<tr>
							<td>Aktif</td>
							<td> <input type=text class='form-control' name='aktif' value=<?php echo "'$de[aktif]'" ?> readonly></td>
						</tr>
						<tr>
							<td>User Input</td>
							<td> <input type=text class='form-control' name='user_input' value=<?php echo "'$de[user_input]'" ?> readonly></td>
						</tr>
					</table>
					<label>&nbsp;</label>
					<!--<input button type='Button' class='btn btn-danger' value='Close' onClick='history.back()'/>-->
					<input button type='Button' class='btn btn-danger' value='Batal' onclick="window.location.href='./dashboard.php?m=mst_pegawai'" />
				</form>
			</font><?php
						} else {
							echo "<script>alert('Anda tidak berhak !');history.go(-1) </script>";
						}
					}
				}

				if (isset($_GET['tipe'])) {
					if ($_GET['tipe'] == 'tambah') {
						cekakses($connect, $user, 'Master Pegawai');
						$lakses = $_SESSION['aksestambah'];
						if ($lakses == 1) { ?>
			<font face='calibri'>
				<h3>Tambah Data Master Pegawai</h3>
				<form method='post' enctype='multipart/form-data' action='module/mst_pegawai/proses_tambah.php'>
					<input type='hidden' name='username' value='<?= $user ?>'>
					<input type='hidden' name='kdese_kdsat' value='<?= $kdese_kdsat ?>'>
					<table style=font-size:13px; class='table table-striped table table-bordered'>
						<tr>
							<td>NIP</td>
							<td> <input type=text class='form-control' id='nip' name='nip' autofocus required></td>
						</tr>
						<tr>
							<td>Nama Pegawai</td>
							<td> <input type=text class='form-control' name='nama_alias' required></td>
						</tr>
						<tr>
							<td>NPWP</td>
							<td> <input type=text class='form-control' name='npwp'></td>
						</tr>
						<tr>
							<td>Status</td>
							<td> <select name=status class='form-control' required>
									<option value='PNS'> PNS</option>
									<option value='CPNS'> CPNS</option>
									<option value='PNS YANG BELUM DIANGKAT FUNGSIONAL'> PNS YANG BELUM DIANGKAT FUNGSIONAL</option>
								</select></td>
						</tr>
						<?php
							$data = mysqli_query($connect, "select * from tbsatker where kdese_kdsat='$kdese_kdsat'");
							$de = mysqli_fetch_assoc($data);
							$kdsatker = $de['kode'];
							$nmsatker = $de['nama'];
							$kdeselon = $de['kdeselon'];
							$nmeselon = $de['nmeselon'];
							echo "<tr><td>Satuan Kerja</td><td><input type='text' class='form-control' size='50' value='$kdsatker' id='kdsatker' name='kdsatker' readonly></td>
				<tr><td><td><input type='text' class='form-control' size='50' value='$nmsatker' id='nmsatker' name='nmsatker' readonly></td></tr>
				<tr><td>Eselon</td><td><input type='text' class='form-control' size='50' value='$kdeselon' id='kdeselon' name='kdeselon' readonly></td>			
				<tr><td><td><input type='text' class='form-control' size='50' value='$nmeselon' id='nmeselon' name='nmeselon' readonly></td></tr>";

							echo "<tr><td>Golongan</td>
				<td><select id='golongan' name='golongan' class='form-control' style='width: 200x;' onchange='changeValueGol(this.value)'>
				<option value=''> - PILIH GOLONGAN - </option>";
							$jsArray1 = "var prdName1 = new Array();\n";
							$data = mysqli_query($connect, 'select * from tbgolongan WHERE aktif="Y" order by golongan');
							while ($row = mysqli_fetch_array($data)) {
								echo '<option name="golongan"  value="' . $row['golongan'] . '">' . $row['golongan'] . '|' . $row['pangkat'] . '</option>';
								$jsArray1 .= "prdName1['" . $row['golongan'] . "'] = {pangkat:'" . addslashes($row['pangkat']) . "',golongan:'" . addslashes($row['golongan']) . "'};\n";
							}
							echo '</select>';
							echo "<input type='hidden' class='form-control' size='50' id='pangkat' name='pangkat' readonly>";

							echo "<tr><td>Kelas Jabatan</td>
				<td><select id='kelas_jabatan' name='kelas_jabatan' class='form-control' style='width: 200x;' onchange='changeValueGol(this.value)'>
				<option value=''> - PILIH KELAS JABATAN - </option>";
							$jsArrayKelasjabatan = "var prdNameKelasjabatan = new Array();\n";
							$data = mysqli_query($connect, 'select * from tbkelas_jabatan WHERE aktif="Y" order by kelas');
							while ($row = mysqli_fetch_array($data)) {
								echo '<option name="kelas_jabatan"  value="' . $row['kelas'] . '|' . $row['tukin'] . '">' . $row['kelas'] . '|' . $row['tukin'] . '</option>';
								$jsArrayKelasjabatan .= "prdNameKelasjabatan['" . $row['kelas'] . "'] = {kelas:'" . addslashes($row['kelas']) . "',tukin:'" . addslashes($row['tukin']) . "'};\n";
							}
							echo '</select>';
							echo "<input type='hidden' class='form-control' size='50' id='tukin' name='tukin' readonly>";

							echo "<tr><td>Jabatan</td> <td>  <input type=text class='form-control' name='jabatan' ></td></tr>";
							echo "<tr><td>Rekening Bank</td> <td><div class='input-group'>  <input type='text' class='form-control' id='norek' name='norek' size='50' autocomplete='off' required>
					<span class='input-group-btn'>
					<button type='button' id='src' class='btn btn-primary' onclick='cari_data_rekening();'>
						Cari
					</button>
				</span></td></tr></div>";
							echo "<tr><td>Nama di Rekening</td><td><input type='text' class='form-control' id='nama' name='nama' required></td></tr>
				<tr><td>Bank</td>
				<td><select required id='kdbank' name='kdbank' class='form-control' style='width: 200x;' onchange='changeValueBank(this.value)'>
				<option value=''> - PILIH BANK - </option>";
							$jsArrayBank = "var prdNameBank = new Array();\n";
							$data = mysqli_query($connect, 'select * from tbbank WHERE aktif="Y" order by kode');
							while ($row = mysqli_fetch_array($data)) {
								echo '<option name="kdbank"  value="' . $row['kode'] . '">' . $row['kode'] . '|' . $row['nama'] . '</option>';
								$jsArrayBank .= "prdNameBank['" . $row['kode'] . "'] = {kdbank:'" . addslashes($row['kode']) . "',bank:'" . addslashes($row['nama']) . "'};\n";
							}
							echo '</select>';
							echo "<input type='text' class='form-control' size='50' id='bank' name='bank' readonly>";

							echo "</div>";

							echo "<tr><td>Aktif</td> <td> <input type=radio name='aktif' value='Y' checked> Y   
                                        <input type=radio name='aktif' value='N'> N </td></tr></table>
				<label>&nbsp;</label>
							<button type='submit' class='btn btn-primary'>Simpan</button>
							<input button type='Button' class='btn btn-danger' value='Batal' onClick='history.back()'/>
				</form></font>";
						} else {
							echo "<script>alert('Anda tidak berhak !');history.go(-1) </script>";
						}
					} elseif ($_GET['tipe'] == 'edit') {
						cekakses($connect, $user, 'Master Pegawai');
						$lakses = $_SESSION['aksesedit'];
						if ($lakses == 1) {
							/*$sql=mysqli_query($connect,"select * from mst_pegawai where id='$_GET[id]'");
				$de=mysqli_fetch_assoc($sql);?>**/
							// $query = $connect->prepare("select * from mst_pegawai where id=?");
							// $query->bind_param('i',$_GET['id']);
							// $query->execute();
							// $result = $query->get_result();
							// $de = $result->fetch_assoc();
							$sql = mysqli_query($connect, "select * from mst_pegawai where id='$_GET[id]'");
							$de = mysqli_fetch_assoc($sql);
							$nip = htmlspecialchars($de["nip"]);
							$nama_alias = htmlspecialchars($de["nama_alias"]);
							$npwp = htmlspecialchars($de["npwp"]);
							$aktif = $de["aktif"]; ?>
						<font face='calibri'>
							<h3>Edit Data Master Pegawai</h3>
							<form method='post' enctype='multipart/form-data' action='module/mst_pegawai/proses_edit.php'>
								<input type='hidden' name='username' value='<?= $user ?>'>
								<input type='hidden' name='id' value='<?= $de['id'] ?>' />
								<input type='hidden' name='kdese_kdsat' value='<?= $kdese_kdsat ?>'>
								<table style=font-size:13px; class='table table-striped table table-bordered'>
									<tr>
										<td>NIP</td>
										<td> <input type=text class='form-control' name='nip' value='<?= $nip ?>' readonly></td>
									</tr>
									<tr>
										<td>Nama Pegawai</td>
										<td> <input type=text class='form-control' name='nama_alias' value='<?= $nama_alias ?>'></td>
									</tr>
									<tr>
										<td>NPWP</td>
										<td> <input type=text class='form-control' name='npwp' value='<?= $npwp ?>'></td>
									</tr>
									<tr>
										<td>Status</td>
										<td>
											<select name=status class='form-control'>
												<?php
												$status = array("PNS", "CPNS", "PNS YANG BELUM DIANGKAT FUNGSIONAL");
												$jlh_bln = count($status);
												for ($c = 0; $c < $jlh_bln; $c += 1) {
													if ($status[$c] == $de['status']) {
														echo "<option value=$status[$c] selected>$status[$c] </option>";
													} else {
														echo "<option value=$status[$c]> $status[$c] </option>";
													}
												}
												echo "</select>";

												echo "<tr><td>Satuan Kerja</td>
						<td><select id='kdsatker' name='kdsatker' class='form-control' style='width: 200x;' onchange='changeValueSatker(this.value)'>
						<option value=''> - PILIH SATUAN KERJA - </option>";
												$jsArraySatker = "var prdNameSatker = new Array();\n";
												$data = mysqli_query($connect, 'select * from tbsatker order by kode');
												while ($row = mysqli_fetch_array($data)) {
													if ($row['kode'] == $de['kdsatker']) {
														echo "<option value=$row[kode] selected>$row[kode]|$row[nama] </option>";
													} else {
														echo '<option name="kdsatker"  value="' . $row['kode'] . '">' . $row['kode'] . '|' . $row['nama'] . '</option>';
													}
													$jsArraySatker .= "prdNameSatker['" . $row['kode'] . "'] = {kdsatker:'" . addslashes($row['kode']) . "',nmsatker:'" . addslashes($row['nama']) . "'};\n";
												}
												echo '</select>';
												echo "<input type='hidden' class='form-control' size='50' id='nmsatker' name='nmsatker' readonly>";

												echo "<tr><td>Eselon</td>
						<td><select id='kdeselon' name='kdeselon' class='form-control' style='width: 200x;' onchange='changeValueEselon(this.value)'>
						<option value=''> - PILIH ESELON - </option>";
												$jsArrayEselon = "var prdNameEselon = new Array();\n";
												$data = mysqli_query($connect, 'select * from tbeselon order by kode');
												while ($row = mysqli_fetch_array($data)) {
													if ($row['kode'] == $de['kdeselon']) {
														echo "<option value=$row[kode] selected>$row[kode]|$row[nama] </option>";
													} else {
														echo '<option name="kdeselon"  value="' . $row['kode'] . '">' . $row['kode'] . '|' . $row['nama'] . '</option>';
													}
													$jsArrayEselon .= "prdNameEselon['" . $row['kode'] . "'] = {kdeselon:'" . addslashes($row['kode']) . "',nmeselon:'" . addslashes($row['nama']) . "'};\n";
												}
												echo '</select>';
												echo "<input type='hidden' class='form-control' size='50' id='nmeselon' name='nmeselon' readonly>";
												echo "<input type='hidden' class='form-control' size='50' id='group_eselon' name='group_eselon' readonly>";

												echo "<tr><td>Golongan/Pangkat</td> <td>
						<select id='golongan' name='golongan' class='form-control' onchange='changeValueGolongan(this.value)'>";
												echo "<option value=''> - PILIH GOLONGAN/PANGKAT - </option>";
												$jsArrayGolongan = "var prdNameGolongan = new Array();\n";
												$data = mysqli_query($connect, 'select * from tbgolongan WHERE aktif="Y"');
												while ($row = mysqli_fetch_array($data)) {
													if ($row['golongan'] == $de['golongan']) {
														echo "<option value=$row[golongan] selected>$row[golongan]|$row[pangkat] </option>";
													} else {
														echo '<option name="golongan"  value="' . $row['golongan'] . '">' . $row['golongan'] . '|' . $row['pangkat'] . '</option>';
													}
													$jsArrayGolongan .= "prdNameGolongan['" . $row['golongan'] . "'] = {golongan:'" . addslashes($row['golongan']) . "',pangkat:'" . addslashes($row['pangkat']) . "'};\n";
												}
												echo "</select>";
												echo "<input type='hidden' class='form-control' size='50' id='pangkat' name='pangkat' value='$de[pangkat]' readonly>";

												echo "<tr><td>Kelas Jabatan</td> <td>
						<select id='kelas_jabatan' name='kelas_jabatan' class='form-control' onchange='changeValueGolongan(this.value)'>";
												echo "<option value=''> - PILIH KELAS JABATAN - </option>";
												$jsArrayKelasjabatan = "var prdNameKelasjabatan = new Array();\n";
												$data = mysqli_query($connect, 'select * from tbkelas_jabatan WHERE aktif="Y"');
												while ($row = mysqli_fetch_array($data)) {
													if ($row['kelas'] == $de['kelas_jabatan']) {
														echo "<option value=$row[kelas] selected>$row[kelas]|$row[tukin] </option>";
													} else {
														echo '<option name="kelas_jabatan"  value="' . $row['kelas'] . '">' . $row['kelas'] . '|' . $row['tukin'] . '</option>';
													}
													$jsArrayKelasjabatan .= "prdNameKelasjabatan['" . $row['kelas'] . "'] = {kelas:'" . addslashes($row['kelas']) . "',tukin:'" . addslashes($row['tukin']) . "'};\n";
												}
												echo "</select>";
												echo "<input type='hidden' class='form-control' size='50' id='tukin' name='tukin' value='$de[tukin]' readonly>";

												echo "<tr><td>Jabatan</td> <td>  <input type=text class='form-control' name='jabatan' value='$de[jabatan]' ></td></tr>";

												echo "<tr><td>Rekening Bank</td> <td><div class='input-group'>  <input type='text' class='form-control' id='norek' name='norek' size='50' value='$de[norek]' autocomplete='off' required>
							<span class='input-group-btn'>
							<button type='button' id='src' class='btn btn-primary' onclick='cari_data_rekening();'>
								Cari
							</button>
						</span></td></tr></div>";


												echo "<tr><td>Nama di Rekening</td><td><input type='text' class='form-control' id='nama' name='nama' value='$de[nama]'></td></tr>
						<tr><td>Bank</td>
						<td><select id='kdbank' name='kdbank' class='form-control' style='width: 200x;' onchange='changeValueBank(this.value)'>
						<option value=''> - PILIH BANK - </option>";
												$jsArrayBank = "var prdNameBank = new Array();\n";
												$data = mysqli_query($connect, 'select * from tbbank WHERE aktif="Y" order by kode');
												while ($row = mysqli_fetch_array($data)) {
													if ($row['kode'] == $de['kdbank']) {
														echo "<option value=$row[kode] selected>$row[kode]|$row[nama]</option>";
													} else {
														echo '<option name="kdbank"  value="' . $row['kode'] . '">' . $row['kode'] . '|' . $row['nama'] . '</option>';
													}
													$jsArrayBank .= "prdNameBank['" . $row['kode'] . "'] = {kdbank:'" . addslashes($row['kode']) . "',bank:'" . addslashes($row['nama']) . "'};\n";
												}
												echo '</select>';
												echo "<input type='hidden' class='form-control' size='50' id='bank' name='bank' readonly>";

												if ("$de[aktif]" == 'N') {
													echo "<tr><td>Aktif</td>     <td> : <input type=radio name='aktif' value='Y'> Y 
															  <input type=radio name='aktif' value='N' checked> N </td></tr></table>";
												} else {
													echo "<tr><td>Aktif</td>     <td> : <input type=radio name='aktif' value='Y' checked> Y  
															  <input type=radio name='aktif' value='N'> N </td></tr></table>";
												}
												echo "<label>&nbsp;</label>
								<button type='submit' class='btn btn-primary'>Simpan</button>";
												/*<input button type='Button' class='btn btn-danger' value='Batal' onClick='history.back()'/>-->**/
												?> <input button type='Button' class='btn btn-danger' value='Batal' onclick="window.location.href='./dashboard.php?m=mst_pegawai'" /><?php
																																																																															echo "</form></font>";
																																																																														} else {
																																																																															echo "<script>alert('Anda tidak berhak !');history.go(-1) </script>";
																																																																														}
																																																																													}
																																																																													/*<tr><td>Picture</td> <td>  <input type='file' class='form-control' name='picture' size='100' value='$de[picture]'></td></tr>**/
																																																																												} else {


																																																																															?>

										<?php

																																																																													/*if(file_exists("images/service/used-1.jpg")){
        echo 'used-1.jpg&nbsp<a href="hapus_used.php?id=used-1.jpg">Hapus</a><br>';
        echo '<img width=250 height=150 src="images/service/used-1.jpg"><br>';
    }**/
										?>

										<?php
																																																																													include 'cek_akses.php';
										?>

										<?php
																																																																													if ($aksesok == 'Y') {
										?>

											<font face="calibri">
												<h3>Master Pegawai</h3>
												<hr size="10px">
												<form method='post'>
													<div class="row">
														<div class="col-md-4 bg">
															<input type=text name='kata' id='kata' size='50px' class='form-control' placeholder='NIP, Nama, Norek' onkeyup='searchTable()'>
														</div>
														<?php
																																																																														include 'hal.php';
														?>

														<button type='submit' name='kata2' class='btn btn-primary'>
															<span class='glyphicon glyphicon-search'></span> Cari</button>
														<a class="btn btn-danger" href="?m=mst_pegawai&tipe=tambah">Tambah data</a>
														<a class="btn btn-success" href="?m=mst_pegawai&tipe=import">Import data</a>
														<a class="btn btn-warning" href="?m=mst_pegawai&tipe=export">Export data</a>

													</div>
												</form>

												<script type="text/javascript">
													function lihat_detail_pegawai(id) {
														$('#modaldetailpegawai').modal('show');
														//$('#modaldetail').find('.modal-body').html(id);

														$.ajax({
															url: 'lihat_detail_pegawai.php',
															type: 'post',
															data: {
																nip: id
															},

															success: function(response) {

																$('#modaldetailpegawai').find('.modal-body').html(response);
															}

														});

													}
												</script>

												<br>
												<div class="table-responsive">
													<table class="table table-bordered table-striped table-hover">
														<tr>
															<th width='50'>No.</th>
															<th>NIP</th>
															<th>Nama</th>
															<th>No. Rekening</th>
															<th>Bank</th>
															<th>Aktif</th>
															<th>Aksi</th>
														</tr>
														<?php
																																																																														// Cek apakah terdapat data page pada URL
																																																																														$page = (isset($_GET['page'])) ? $_GET['page'] : 1;
																																																																														if (isset($_POST['record'])) {
																																																																															$_SESSION['jmlperhalaman'] = $_POST['record'];
																																																																															$limit = $_POST['record']; //5; // Jumlah data per halamannya**/
																																																																														} else {
																																																																															$limit = $_SESSION['jmlperhalaman'];
																																																																														}
																																																																														$limit_start = ($page - 1) * $limit;
																																																																														// Untuk menentukan dari data ke berapa yang akan ditampilkan pada tabel yang ada di database
																																																																														if ($_SESSION['level'] == 'ADMINISTRATOR') {
																																																																															if (empty($_POST['kata'])) {
																																																																																$tampil = mysqli_query($connect, "SELECT * FROM mst_pegawai LIMIT " . $limit_start . "," . $limit);
																																																																															} else {
																																																																																$cari = $_POST['kata'];
																																																																																$tampil = mysqli_query($connect, "SELECT * FROM mst_pegawai WHERE (norek like '%$cari%' or nip like '%$cari%' or nama like '%$cari%') LIMIT " . $limit_start . "," . $limit);
																																																																															}
																																																																														} else {
																																																																															if (empty($_POST['kata'])) {
																																																																																$tampil = mysqli_query($connect, "SELECT * FROM mst_pegawai where user_input='$kdese_kdsat' LIMIT " . $limit_start . "," . $limit);
																																																																															} else {
																																																																																$cari = $_POST['kata'];
																																																																																$tampil = mysqli_query($connect, "SELECT * FROM mst_pegawai WHERE user_input='$kdese_kdsat' and (norek like '%$cari%' or nip like '%$cari%' or nama like '%$cari%') LIMIT " . $limit_start . "," . $limit);
																																																																															}
																																																																														}
																																																																														if ($page == 1) {
																																																																															$posisi = 0;
																																																																															$_GET['halaman'] = 1;
																																																																														} else {
																																																																															$posisi = ($_GET['page'] - 1) * $limit;
																																																																														}
																																																																														$no = $posisi + 1;
																																																																														/*<td><u><a href='?m=mst_pegawai&tipe=detail&id=$k[id]'><font color='blue'>$k[nip]</font></a></u></td>**/
																																																																														while ($k = mysqli_fetch_assoc($tampil)) {
																																																																															echo "<tr>
                <td align='center'>$no</td>
				<td><u><a href='#' onclick =lihat_detail_pegawai('$k[nip]');><font color='blue'>$k[nip]</font></a></u></td>
				<td>$k[nama_alias]</td>
				<td>$k[norek]</td>
				<td>$k[bank]</td>
				<td width='70' align='center'>$k[aktif]</td>
                <td align='center' width='140px'>
                    <a class='btn btn-info' href='?m=mst_pegawai&tipe=edit&id=$k[id]'>Edit</a>";
																																																																															cekakses($connect, $user, 'Master Pegawai');
																																																																															$lakses = $_SESSION['akseshapus'];
																																																																															if ($lakses == 1) {
																																																																																/*echo " <a class='btn btn-danger' href='module/mst_pegawai/proses_hapus.php?id=$k[id]&nip=$k[nip]'
						onClick='return confirm(\"Anda yakin akan menghapus ?\")'>Hapus</a>";**/
																																																																																echo " <input button type='Button' class='btn btn-danger' value='Hapus' onClick='alert_hapus($k[id])'/>";
																																																																															}
																																																																															echo "</td>";
																																																																															$no++;
																																																																														}
														?>
													</table>
													<?php
																																																																														$query = mysqli_query($connect, "select count(*) as jumrec from mst_pegawai");
																																																																														$result = mysqli_fetch_array($query);
																																																																														echo "Jumlah Record : " . $result['jumrec'];
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
														<li><a href="dashboard.php?m=mst_pegawai&page=1">First</a></li>
														<li><a href="dashboard.php?m=mst_pegawai&page=<?php echo $link_prev; ?>">&laquo;</a></li>
													<?php
																																																																														}
													?>

													<!-- LINK NUMBER -->
													<?php
																																																																														// Buat query untuk menghitung semua jumlah data
																																																																														include("./inc/config.php");
																																																																														if ($_SESSION['level'] == 'ADMINISTRATOR') {
																																																																															if (empty($_POST['kata'])) {
																																																																																$tampil = mysqli_query($connect, "SELECT * FROM mst_pegawai");
																																																																															} else {
																																																																																$cari = $_POST['kata'];
																																																																																$tampil = mysqli_query($connect, "SELECT * FROM mst_pegawai WHERE (norek like '%$cari%' or nip like '%$cari%' or nama like '%$cari%')");
																																																																															}
																																																																														} else {
																																																																															if (empty($_POST['kata'])) {
																																																																																$tampil = mysqli_query($connect, "SELECT * FROM mst_pegawai where user_input='$kdese_kdsat'");
																																																																															} else {
																																																																																$cari = $_POST['kata'];
																																																																																$tampil = mysqli_query($connect, "SELECT * FROM mst_pegawai WHERE user_input='$kdese_kdsat' and (norek like '%$cari%' or nip like '%$cari%' or nama like '%$cari%')");
																																																																															}
																																																																														}
																																																																														$get_jumlah = mysqli_num_rows($tampil);

																																																																														/*$jumlah_page = ceil($get_jumlah['jumlah'] / $limit); // Hitung jumlah halamannya**/
																																																																														$jumlah_page = ceil($get_jumlah / $limit);
																																																																														$jumlah_number = 2; // Tentukan jumlah link number sebelum dan sesudah page yang aktif
																																																																														$start_number = ($page > $jumlah_number) ? $page - $jumlah_number : 1; // Untuk awal link number
																																																																														$end_number = ($page < ($jumlah_page - $jumlah_number)) ? $page + $jumlah_number : $jumlah_page; // Untuk akhir link number

																																																																														for ($i = $start_number; $i <= $end_number; $i++) {
																																																																															$link_active = ($page == $i) ? ' class="active"' : '';
													?>
														<li<?php echo $link_active; ?>><a href="dashboard.php?m=mst_pegawai&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
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
															<li><a href="dashboard.php?m=mst_pegawai&page=<?php echo $link_next; ?>">&raquo;</a></li>
															<li><a href="dashboard.php?m=mst_pegawai&page=<?php echo $jumlah_page; ?>">Last</a></li>
														<?php
																																																																														}
														?>
												</ul>
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
						<div class="modal fade" id="modaldetailpegawai" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="exampleModalLabel1">Detail Master Pegawai</h5>
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

						<script type="text/javascript">
							<?php echo $jsArray2; ?>

							function changeValueNorek(id) {
								document.getElementById('kdbank').value = prdName2[id].kdbank;
								document.getElementById('bank').value = prdName2[id].bank;
								document.getElementById('nama').value = prdName2[id].nama;
							};
						</script>
						<script type="text/javascript">
							<?php echo $jsArray; ?>

							function changeValue(id) {
								document.getElementById('kdgrade').value = prdName[id].kdgrade;
								document.getElementById('nmgrade').value = prdName[id].nmgrade;
								document.getElementById('nilai').value = prdName[id].nilai;
							};
						</script>
						<script type="text/javascript">
							<?php echo $jsArray1; ?>

							function changeValueGol(id) {
								document.getElementById('golongan').value = prdName1[id].golongan;
								document.getElementById('pangkat').value = prdName1[id].pangkat;
							};
						</script>
						<script type="text/javascript">
							<?php echo $jsArrayGrade; ?>

							function changeValueGrade(id) {
								document.getElementById('kdgrade').value = prdNameGrade[id].kdgrade;
								document.getElementById('nmgrade').value = prdNameGrade[id].nmgrade;
							};
						</script>
						<script type="text/javascript">
							<?php echo $jsArrayGolongan; ?>

							function changeValueGolongan(id) {
								document.getElementById('golongan').value = prdNameGolongan[id].golongan;
								document.getElementById('pangkat').value = prdNameGolongan[id].pangkat;
							};
						</script>
						<script type="text/javascript">
							<?php echo $jsArrayKelasjabatan; ?>

							function changeValueKelasjabatan(id) {
								document.getElementById('kelas_jabatan').value = prdNameKelasjabatan[id].kelas;
								document.getElementById('tukin').value = prdNameKelasjabatan[id].tukin;
							};
						</script>
						<script type="text/javascript">
							<?php echo $jsArrayNorek; ?>

							function changeValueNorek(id) {
								document.getElementById('norek').value = prdNameNorek[id].norek;
								document.getElementById('kdbank').value = prdNameNorek[id].kdbank;
								document.getElementById('bank').value = prdNameNorek[id].bank;
								document.getElementById('nama').value = prdNameNorek[id].nama;
							};
						</script>
						<script type="text/javascript">
							<?php echo $jsArraySatker; ?>

							function changeValueSatker(id) {
								document.getElementById('kdsatker').value = prdNameSatker[id].kdsatker;
								document.getElementById('nmsatker').value = prdNameSatker[id].nmsatker;
							};
						</script>
						<script type="text/javascript">
							<?php echo $jsArrayEselon; ?>

							function changeValueEselon(id) {
								document.getElementById('kdeselon').value = prdNameEselon[id].kdeselon;
								document.getElementById('nmeselon').value = prdNameEselon[id].nmeselon;
								document.getElementById('group_eselon').value = prdNameEselon[id].group_eselon;
							};
						</script>
						<script type="text/javascript">
							<?php echo $jsArrayBank; ?>

							function changeValueBank(id) {
								document.getElementById('kdbank').value = prdNameBank[id].kdbank;
								document.getElementById('bank').value = prdNameBank[id].bank;
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
											//alert($kode);
											$href = "module/mst_pegawai/proses_hapus.php?id=";
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