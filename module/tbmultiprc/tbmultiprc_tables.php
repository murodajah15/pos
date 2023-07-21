<?php
	$user = $_SESSION['username'];
  if(isset($_GET['tipe'])){
    if($_GET['tipe']=='import'){
			cekakses($connect,$user,'Tabel Multi Price');
			$lakses = $_SESSION['aksestambah'];
			if ($lakses == 1) {?>
				<font face='calibri'>
				<div class="panel panel-success">
				<div class="panel-heading"><font size="4">IMPORT DATA TABEL MULTI PRICE</font></div>
				<div class="panel-body">
				<form method='post' enctype='multipart/form-data' action='module/tbmultiprc/proses_import.php'>
				<input type='hidden' name='username' value='<?= $user ?>'>
				Pilih File Excel*: 
				<input name='fileexcel' type='file' accept='application/vnd.ms-excel'></br> <!--<input name='upload' type='submit' alue='Import'>-->
				<button type='submit' class='btn btn-primary' name='upload' value='import'>Import</button>
				<input button type='Button' class='btn btn-danger' value='Selesai' onClick='history.back()'/>
	       </div></div>
	       </form></font>
		     <?php
			}else{
				echo "<script>alert('Anda tidak berhak !');history.go(-1) </script>";
			}
		}
	}

  if(isset($_GET['tipe'])){
    if($_GET['tipe']=='export'){
			cekakses($connect,$user,'Tabel Multi Price');
			$lakses = $_SESSION['aksescetak'];
			if ($lakses == 1) {?>
				<font face='calibri'>
				<div class="panel panel-default">
				<div class="panel-heading"><font size="4">EXPORT DATA TABEL MULTI PRICE</font></div>
				<div class="panel-body">
				<form method='post' enctype='multipart/form-data' action='module/tbmultiprc/proses_export.php'>
				<input type='hidden' name='username' value='<?= $user ?>'>
				Type : <select name=typefile class='form-control' required>
						<option value='Excel'> Excel</option>
													<option value='CSV'> CSV</option>
													<option value='PDF'> PDF</option>
												</select><br>
				<button type='submit' class='btn btn-primary' name='upload' value='export'>Export</button>
				<input button type='Button' class='btn btn-danger' value='Selesai' onClick='history.back()'/>
				</div></div>
        </form></font>
      <?php
			}else{
				echo "<script>alert('Anda tidak berhak !');history.go(-1) </script>";
			}
		}
	}

	if(isset($_GET['tipe'])){
		if($_GET['tipe']=='edit_detail'){
			cekakses($connect,$user,'Tabel Multi Price');
			$lakses = $_SESSION['aksesedit'];
			if ($lakses == 1) {	
				$query = $connect->prepare("select * from tbmultiprc where id=?");
				$query->bind_param('i',$_GET['id']);
				$query->execute();
				$result = $query->get_result();
				$de = $result->fetch_assoc();
				$kdbarang = htmlspecialchars($de['kdbarang']);
				$nmbarang = htmlspecialchars($de['nmbarang']);
				$harga = htmlspecialchars($de['harga']);
				$discount = htmlspecialchars($de['discount']);
				?>
				<font face="calibri">
					<div class="panel panel-warning">
					<div class="panel-heading"><font size="4">EDIT DATA TABEL MULTI PRICE</font></div>
					<div class="panel-body">
					<form method="post" enctype="multipart/form-data" action="module/tbmultiprc/proses_edit_detail.php">
						<input type="hidden" name="username" value="<?= $user ?>">
						<input type="hidden" name="id" value="<?= $de["id"] ?>">
						<div class='col-md-6'>
							<table style=font-size:13px; class="table table-striped table table-bordered">
							<tr><td>Kode Barang</td> <td>  <input type="text" class="form-control" name="kdbarang" value="<?= $kdbarang ?>" readonly></td></tr>
							<tr><td>Nama Barang</td> <td>  <input type="text" class="form-control" name="nmbarang" id="nmbarang" value="<?= $nmbarang ?>"  readonly></td></tr>
		          <tr><td>Harga</td> <td> <input type='number' class='form-control' name='harga' value="<?= $harga ?>"></td></tr>
		          <tr><td>Discount (%)</td> <td> <input type='number' step='any' onfocus="this.select();" max='100' class='form-control' name='discount' value="<?= $discount ?>" autofocus="autofocus"></td></tr>
							</table>
						</div>
						<div class='col-md-12'>
							<button type="submit" class="btn btn-primary">Simpan</button>
							<input button type='Button' class='btn btn-danger' value='Batal' onClick='history.back()'/>
							<!--<input button type='Button' class='btn btn-danger' value='Close' onClick="window.location = 'dashboard.php?m=tbmultiprc'">-->
						</div>
					</div></div></form></font>
			<?php 
			}else{
				echo "<script>alert('Anda tidak berhak !');history.go(-1) </script>";
			}
	  }
	}

  if(isset($_GET['tipe'])){
    if($_GET['tipe']=='detail_data'){
			cekakses($connect,$user,'Tabel Multi Price');
			$lakses = $_SESSION['aksespakai'];
			if ($lakses == 1) {
				$query = $connect->prepare("select * from tbcustomer where kode=?");
				$query->bind_param('s',$_GET['kdcustomer']);
				$result = $query->execute();
				$query->store_result();
				$query->execute();
				$result = $query->get_result();
				$de = $result->fetch_assoc();
				$kdcustomer = strip_tags($de['kode']);
				$nmcustomer = strip_tags($de['nama']);
				?>
				<font face="calibri">
					<div class="panel panel-warning">
					<div class="panel-heading"><font size="4">DETAIL DATA TABEL MULTI PRICE</font></div>
					<div class="panel-body">
					<form method="post" enctype="multipart/form-data" action='module/tbmultiprc/proses_tambah_detail.php'>
						<input type="hidden" name="username" value="<?= $user ?>">
						<input type="hidden" name="id" value="<?= $de["id"] ?>">
						<div class='col-md-12'>
						<table style=font-size:13px; class="table table-striped table table-bordered">
		          <tr><td>Kode</td> <td> <input type='text' class='form-control' name='kdcustomer' value='<?= $kdcustomer ?>' size='10' required readonly></td>
		          <td>nama</td> <td> <input type='text' class='form-control' name='nmcustomer' value='<?= $nmcustomer ?>' size='80' required readonly></td></tr>
		        </table>
		      	</div>

						<div class='col-md-12'>
							<?php
									cekakses($connect,$user,'Tabel Multi Price');
									$lakses = $_SESSION['aksestambah'];
									if ($lakses==1) {?>
										<input button type='Button' class='btn btn-primary' value='Salin dari Tabel Barang' onClick='salin_tbbarang("<?=$kdcustomer?>")'/>
									<?php
									}else{?>
										<input button type='Button' class='btn btn-primary' value='Salin dari Tabel Barang' onClick='salin_tbbarang("<?=$kdcustomer?>")' disabled/>
									<?php
									}
							?>
							<table style=font-size:13px; class="table table-striped table table-bordered">
						    <tr>
				        <th width='170'>Kode Barang <input type="button" class='btn btn-black' value="Clear" onclick="eraseText()"></th>
								<th width='170'>Barang</th>
								<th>Harga</th>
								<th>Discount (%)</th>
				        <th>Aksi</th>
						    </tr>
								<td><div class='input-group'>  <input type='text' class='form-control' id='kdbarang' name='kdbarang' size='50' autocomplete='off' style='text-transform:uppercase' required >
								<span class='input-group-btn'>
									<button type='button' id='src' class='btn btn-primary' onclick='cari_data_barang()'>Cari</button>
								</span></td>
								</td><td><input type='text' class='form-control' style='width: 15em' id='nmbarang' name='nmbarang' readonly></td>
								</td><td><input type="text" class='form-control' id='harga' name='harga' style='width: 8em'></td>
								</td><td><input type="text" max='100' class='form-control' id='discount' name='discount' style='width: 6em' onkeyup="validAngka(this)"></td>
								<td align='center' width='50px'>
								<?php
									cekakses($connect,$user,'Tabel Multi Price');
									$lakses = $_SESSION['aksestambah'];
									if ($lakses==1) {
						        echo "<button type='submit' class='btn btn-primary'>+</button>";
						      }else{
						      	echo "<button type='submit' class='btn btn-primary' disabled>+</button>";
						    	}
						    ?>
				        <!--<button type='button' id='src' class='btn btn-danger btn-sm' onclick='tambah_detail($k[id])'>+
				        <input button type='Button' class='btn btn-danger btn-sm' value='+' onClick='tambah_detail($k[id])'/>-->
							</table>
						</div>

						<div class='col-md-12'>
							<table style=font-size:13px; class="table table-striped table table-bordered">
						    <tr>
					    	<th width='40'>No.</th>
						    <th width='90'>Kode Barang</th>
						    <th>Nama Barang</th>
								<th>harga</th>
								<th>Discount (%)</th>
								<th>Aksi</th>
						    </tr>
						<?php
							$tampil = mysqli_query($connect,"select * from tbmultiprc where kdcustomer='$_GET[kdcustomer]'");
							$query = $connect->prepare("select * from tbmultiprc where kdcustomer=?");
							$query->bind_param('s',$_GET['kdcustomer']);
							$query->execute();
							$result = $query->get_result();
							$de = $result->fetch_assoc();
							$kdbarang = strip_tags($de['kdbarang']);
							$nmbarang = strip_tags($de['nmbarang']);
							$harga = strip_tags($de['harga']);
							$discount = strip_tags($de['discount']);
			        $no=1;
			        //<td><u><a href='?m=wo&tipe=detail&id=$k[id]'><font color='blue'>$k[kode]</font></a></u></td>
			        //<td><u><a href='#' onclick =lihat_detail('$k[id]');><font color='blue'>$k[kdbarang]</font></a></u></td>
			        while($k=mysqli_fetch_assoc($tampil)){
			        //$date = date("m/d/Y", strtotime($k['tglwo']));
			        $harga = number_format($k['harga'],0,",",".");
			        $discount = number_format($k['discount'],2,",",".");
			        echo "<tr>
			        <td align='center'>$no</td>
							<td width='90'>$k[kdbarang]</td>
							<td width='300'>$k[nmbarang]</td>
							<td align='right' width='100'>$harga</td>
							<td align='right' width='70'>$discount</td>
							<td align='center' width='100px'>";
							cekakses($connect,$user,'Tabel Multi Price');
							$aksesedit = $_SESSION['aksesedit'];
							$akseshapus = $_SESSION['akseshapus'];
							if ($aksesedit==1) {
		          	echo "<a class='btn btn-primary' href='?m=tbmultiprc&tipe=edit_detail&id=$k[id]'>Edit</a> ";
		          }else{
		          	echo "<a class='btn btn-primary' href='?m=tbmultiprc&tipe=edit_detail&id=$k[id]' disabled>Edit</a> ";
		          }
		          if ($akseshapus==1) {
		          	echo "<input button type='Button' class='btn btn-danger' value='Hapus' onClick='alert_hapus_detail($k[id])'/>";
		          }else{
		          	echo "<input button type='Button' class='btn btn-danger' value='Hapus' onClick='alert_hapus_detail($k[id])' disabled/>";
		          }
						$no++;
					}
					?>
					</table>
				</div>
				<div class='col-md-12'>
					<input button type='Button' class='btn btn-danger' value='Close' onClick="window.location.href='?m=tbmultiprc'"/>
				</div>
			</div></div></form></font>
			<?php }else{
				echo "<script>alert('Anda tidak berhak !');history.go(-1) </script>";
			}
		}
	}

  if(isset($_GET['tipe'])){
    if($_GET['tipe']=='detail'){
			cekakses($connect,$user,'Tabel Customer');
			$lakses = $_SESSION['aksespakai'];
			if ($lakses == 1) {	
				$query = $connect->prepare("select * from tbcustomer where id=?");
				$query->bind_param('i',$_GET['id']);
				$result = $query->execute();
				$query->store_result();
				$query->execute();
				$result = $query->get_result();
				$de = $result->fetch_assoc();
				$kode = strip_tags($de['kode']);
				$kelompok = strip_tags($de['kelompok']);
				$nama = strip_tags($de['nama']);
				$alamat = strip_tags($de['alamat']);
				$kota = strip_tags($de['kota']);
				$kodepos = strip_tags($de['kodepos']);
				$telp1 = strip_tags($de['telp1']);
				$telp2 = strip_tags($de['telp2']);
				$agama = strip_tags($de['agama']);
				$tgl_lahir = strip_tags($de['tgl_lahir']);
				$alamat_ktr = strip_tags($de['alamat_ktr']);
				$kota_ktr = strip_tags($de['kota_ktr']);
				$kodepos_ktr = strip_tags($de['kodepos_ktr']);
				$telp1_ktr = strip_tags($de['telp1_ktr']);
				$telp2_ktr = strip_tags($de['telp2_ktr']);
				$npwp = strip_tags($de['npwp']);
				$alamat_npwp = strip_tags($de['alamat_npwp']);
				$nama_npwp = strip_tags($de['nama_npwp']);
				$alamat_ktp = strip_tags($de['alamat_ktp']);
				$kota_ktp = strip_tags($de['kota_ktp']);
				$kodepos_ktp = strip_tags($de['kodepos_ktp']);
				$tgl_register = date('Y-m-d');
				?>
				<font face="calibri">
					<div class="panel panel-warning">
					<div class="panel-heading"><font size="4">DETAIL DATA TABEL CUSTOMER</font></div>
					<div class="panel-body">
					<form method="post" enctype="multipart/form-data">
						<input type="hidden" name="username" value="<?= $user ?>">
						<input type="hidden" name="id" value="<?= $de["id"] ?>">
						<div class='col-md-6'>
						<table style=font-size:13px; class="table table-striped table table-bordered">
	          <tr><td>Kode</td> <td> <input type='text' class='form-control' name='kode' value='<?= $kode ?>' size='10' required readonly></td></tr>
 						<tr><td>Kelompok</td><td>
						<?php
							echo "<select readonly name='kelompok' class='form-control'>";
							$kelompok=array('Mr.','Ms.','Mrs.','Company');
							$jml_kata=count($kelompok);
							for($c=0; $c<$jml_kata; $c+=1){
								if ($kelompok[$c]==$de[kelompok]){
									echo "<option value=$kelompok[$c] selected>$kelompok[$c] </option>";
								}else{
									echo "<option value=$kelompok[$c]> $kelompok[$c] </option>";
								}
							}						
							echo "</select>";
						?>
	          <tr><td>Nama</td> <td> <input type='text' class='form-control' name='nama' id='nama' value='<?= $nama ?>' autofocus='autofocus' required readonly></td></tr>
	          <tr><td>Alamat</td> <td> <textarea rows='3' class='form-control' name='alamat' id='alamat' readonly><?= $alamat ?></textarea></td></tr>
	          <tr><td>Kota</td> <td> <input type='text' class='form-control' name='kota' id='kota' value='<?= $kota ?>' readonly></td></tr>
	          <tr><td>Kode Pos</td> <td> <input type='text' class='form-control' name='kodepos' id='kodepos' value='<?= $kodepos ?>' readonly></td></tr>
	          <tr><td>Telp</td> <td> <input type='text' class='form-control' name='telp1' value='<?= $telp1 ?>' readonly></td></tr>
	          <tr><td><td> <input type='text' class='form-control' name='telp2' value='<?= $telp2 ?>' readonly></td></tr>
 						<tr><td>Agama<td><select readonly id='agama' name='agama' class='form-control' style='width: 200x;'>
						<!--<option value=''> - PILIH AGAMA - </option>";-->
						<?php
						$data = mysqli_query($connect,'select * from tbagama');
						while ($row=mysqli_fetch_array($data))
						{
							if ($row['nama']==$de['agama']) {
								echo "<option value=$row[nama] selected>$row[nama]</option>";
							}else{
								echo '<option name="nama"  value="'.$row['nama'].'">'.$row['nama'].'</option>';
							}
						}
						echo '</select>';
						?>
						<tr><td>Tanggal Lahir (M-D-Y)</td> <td> <input type='date' class='form-control' name='tgl_lahir' value='<?= $tgl_lahir ?>' readonly></td></tr>
						<tr><td>Tanggal Register (M-D-Y)</td> <td> <input type='date' class='form-control' name='tgl_register' value='<?= $tgl_register ?>' readonly></td></tr>
					</table>
				</div>
				<div class='col-md-6'>
	        <table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
	          <tr><td>Alamat KTP</td> <td> <textarea rows='3' class='form-control' name='alamat_ktp' id='alamat_ktp' readonly><?= $alamat_ktp ?></textarea></td></tr>
	          <tr><td>Kota KTP</td> <td> <input type='text' class='form-control' name='kota_ktp' id='kota_ktp' value='<?= $kota_ktp ?>' readonly></td></tr>
	          <tr><td>Kode Pos KPT</td> <td> <input type='text' class='form-control' name='kodepos_ktp' id='kodepos_ktp' value='<?= $kodepos_ktp ?>' readonly></td></tr>
	          <tr><td>Alamat Kantor</td> <td> <textarea rows='3' class='form-control' name='alamat_ktr' id='alamat_ktr' readonly><?= $alamat_ktr ?></textarea></td></tr>
	          <tr><td>Kota Kantor</td> <td> <input type='text' class='form-control' name='kota_ktr' id='kota_ktr' value='<?= $kota_ktr ?>' readonly></td></tr>
	          <tr><td>Kode Pos Kantor</td> <td> <input type='text' class='form-control' name='kodepos_ktr' id='kodepos_ktr' value='<?= $kodepos_ktr ?>' readonly></td></tr>
	          <tr><td>Telp Kantor</td> <td> <input type='text' class='form-control' name='telp1_ktr' value='<?= $telp1_ktr ?>' readonly></td></tr>
	          <tr><td><td> <input type='text' class='form-control' name='telp2_ktr' value='<?= $telp2_ktr ?>' readonly></td></tr>
	          <tr><td>NPWP</td> <td> <input type='text' class='form-control' name='npwp' value='<?= $npwp ?>' readonly></td></tr>
	          <tr><td>Nama NPWP</td> <td> <input type='text' class='form-control' name='nama_npwp' id='nama_npwp' value='<?= $nama_npwp ?>' readonly></td></tr>
	          <tr><td>Alamat NPWP</td> <td> <textarea rows='3' class='form-control' name='alamat_npwp' id='alamat_npwp' readonly><?= $alamat_npwp ?></textarea></td></tr>
					</table>
				</div>
				<div class='col-md-12'>
					<input button type='Button' class='btn btn-danger' value='Close' onClick="window.location.href='?m=tbmultiprc'"/>
				</div>
				</div></div></form></font>
			<?php }else{
				echo "<script>alert('Anda tidak berhak !');history.go(-1) </script>";
			}
		}
	}
	
  if(isset($_GET['tipe'])){
    if($_GET['tipe']=='tambah'){
      cekakses($connect,$user,'Tabel Multi Price');
      $lakses = $_SESSION['aksestambah'];
      if ($lakses == 1) {?>
        <font face='calibri'>
        <div class='panel panel-danger'>
        <div class='panel-heading'><font size="4">TAMBAH DATA TABEL MULTI PRICE</font></div>
        <div class='panel-body'>
        <form method='post' name='tbmultiprc' enctype='multipart/form-data' action='module/tbmultiprc/proses_tambah.php'>
				<input type='hidden' name='username' value="<?= $user ?>">
				<div class='col-md-6'>
	        <table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
	          <tr><td>Kode</td> <td> <input type='text' class='form-control' name='kode' size='10' autofocus='autofocus' required></td></tr>
	          <tr><td width='100px'>Nama</td> <td> <input type='text' class='form-control' name='nama' width='150px' required></td></tr>
	          <tr><td width='100px'>initial</td> <td> <input type='text' class='form-control' name='initial' width='150px'></td></tr>
	          <tr><td width='100px'>Telpon 1</td> <td> <input type='text' class='form-control' name='telp1' width='150px'></td></tr>
	          <tr><td width='100px'>Telpon 2</td> <td> <input type='text' class='form-control' name='telp2' width='150px'></td></tr>
					</table>
				</div>
				<div class='col-md-6'>
	        <table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
	          <tr><td width='100px'>Alamat</td> <td> <textarea rows='3' class='form-control' name='alamat' width='150px'></textarea>
	          <tr><td width='100px'>Kota</td> <td> <input type='text' class='form-control' name='kota' width='150px'></td></tr>
	          <tr><td width='100px'>Kode POS</td> <td> <input type='text' class='form-control' name='kdpos' width='150px'></td></tr>
	          <tr><td width='100px'>Keterangan</td> <td> <input type='text' class='form-control' name='keterangan' width='150px'></td></tr>
					</table>
				</div>
				<div class='col-md-12'>
					<button type='submit' class='btn btn-success'>Simpan</button>
	        <input button type='Button' class='btn btn-danger' value='Batal' onClick='history.back()'/>
	      </div>
        </div></div></form></font>
        <?php 
      }else{
      echo "<script>alert('Anda tidak berhak !');history.go(-1) </script>";
      }

    }elseif($_GET['tipe']=='edit'){
			cekakses($connect,$user,'Tabel Multi Price');
			$lakses = $_SESSION['aksesedit'];
			if ($lakses == 1) {	
				$query = $connect->prepare("select * from tbmultiprc where id=?");
				$query->bind_param('i',$_GET['id']);
				$query->execute();
				$result = $query->get_result();
				$de = $result->fetch_assoc();
				$kode = htmlspecialchars($de['kode']);
				$nama = htmlspecialchars($de['nama']);
				$initial = htmlspecialchars($de['initial']);
				$telp1 = htmlspecialchars($de['telp1']);
				$telp2 = htmlspecialchars($de['telp2']);
				$alamat = htmlspecialchars($de['alamat']);
				$kota = htmlspecialchars($de['kota']);
				$kdpos = htmlspecialchars($de['kdpos']);
				$keterangan = htmlspecialchars($de['keterangan']);
				?>
				<font face="calibri">
					<div class="panel panel-warning">
					<div class="panel-heading"><font size="4">EDIT DATA TABEL MULTI PRICE</font></div>
					<div class="panel-body">
					<form method="post" enctype="multipart/form-data" action="module/tbmultiprc/proses_edit.php">
						<input type="hidden" name="username" value="<?= $user ?>">
						<input type="hidden" name="id" value="<?= $de["id"] ?>">
						<div class='col-md-6'>
							<table style=font-size:13px; class="table table-striped table table-bordered">
							<tr><td>Kode</td> <td>  <input type="text" class="form-control" name="kode" value="<?= $kode ?>" readonly></td></tr>
							<tr><td>Nama</td> <td>  <input type="text" class="form-control" name="nama" id="nama" value="<?= $nama ?>" autofocus="autofocus"></td></tr>
		          <tr><td>initial</td> <td> <input type='text' class='form-control' name='initial' value="<?= $initial ?>"></td></tr>
		          <tr><td>Telpon 1</td> <td> <input type='text' class='form-control' name='telp1' value="<?= $telp1 ?>"></td></tr>
		          <tr><td>Telpon 2</td> <td> <input type='text' class='form-control' name='telp2' value="<?= $telp2 ?>"></td></tr>
							</table>
						</div>
						<div class='col-md-6'>
							<table style=font-size:13px; class="table table-striped table table-bordered">
		          <tr><td width='100px'>Alamat</td> <td> <textarea rows='3' class='form-control' name='alamat'><?= $alamat ?></textarea>
		          <tr><td width='100px'>Kota</td> <td> <input type='text' class='form-control' name='kota' value="<?= $kota ?>"'></td></tr>
		          <tr><td width='100px'>Kode POS</td> <td> <input type='text' class='form-control' name='kdpos' value="<?= $kdpos ?>"'></td></tr>
		          <tr><td width='100px'>Keterangan</td> <td> <input type='text' class='form-control' name='keterangan' value="<?= $keterangan ?>"'></td></tr>
							</table>
						</div>
						<div class='col-md-12'>
							<button type="submit" class="btn btn-primary">Simpan</button>
							<input button type="Button" class="btn btn-danger" value="Batal" onClick="history.back()"/>
						</div>
					</div></div></form></font>
			<?php 
			}else{
				echo "<script>alert('Anda tidak berhak !');history.go(-1) </script>";
			}
  	}
	}else{?>

	<?php
		include 'cek_akses.php';
		if ($aksesok == 'Y') {
	?>

	<img src="loader.gif" width="50px" height="50px" id="imgLoad" style="display:none">

	<font face="calibri">
	  <div class="panel panel-info">
	    <div class="panel-heading"><font size="4">TABEL MULTI PRICE</font></div>
	    <div class="panel-body">
	    	<form method='post'>
				<div class="row">
					<div class="col-md-12 bg">
					<!--<a class="btn btn-danger" href="?m=tbmultiprc&tipe=tambah">Tambah data</a>
					<a class="btn btn-success" href="?m=tbmultiprc&tipe=import">Import data</a>
					<a class="btn btn-warning" href="?m=tbmultiprc&tipe=export">Export data</a>-->
					</div>
				</div>
			</form>
	    </br>
	<!--<div class="table-responsive">
	<table class="table table-bordered table-striped table-hover" cellspacing="0" width="100%">-->
	<div class="box-body table-responsive">
		<table id="example1" class="table table-bordered table-striped">
		<thead>
		<tr>
			<th width='50'>No.</th>
			<th>Kode Customer</th>
			<th>Nama Customer</th>
			<th>User</th>
			<th>Aksi</th>
		</tr>
		</thead>
		<?php
			$tampil = mysqli_query($connect,"SELECT * FROM tbcustomer order by kode");
			$no=1;
			while($k=mysqli_fetch_assoc($tampil)){
				echo "<tr>
					<td align='center'>$no</td>
					<td><u><a href='?m=tbmultiprc&tipe=detail&id=$k[id]'><font color='blue'>$k[kode]</font></a></u></td>
					<td>$k[nama]</td>
					<td>$k[user]</td>
					<td align='center' width='90px'>
						<a class='btn btn-warning' href='?m=tbmultiprc&tipe=detail_data&kdcustomer=$k[kode]'>Detail</a>";
						cekakses($connect,$user,'Tabel Multi Price');
					echo "</td>";
				$no++;
			}
		?>
		</table>
	</div>
	<?php

	}else{
	echo "<font color='red'>Anda tidak punya hak !</font>";
	}?>
	<?php
		}
?>

<?php
	function konversitext($field){
		echo htmlentities($field,ENT_QUOTES);
	}
?>

<script>
    function alert_hapus($id){
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
          	$href = "module/tbmultiprc/proses_hapus.php?id=";
          	window.location.href = $href+$id;
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
    function alert_hapus_detail($id){
        swal({
          title: "Yakin akan dihapus ?",
          text: "Once deleted, you will not be able to recover this data!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
          	$href = "module/tbmultiprc/proses_hapus_detail.php?id=";
          	window.location.href = $href+$id;
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
	    function salin_tbbarang($id){
	    	$("#imgLoad").show("");	
        swal({
          title: "Yakin akan salin tabel barang ?",
          text: "",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
          	$href = "module/tbmultiprc/salin_tbbarang.php?id=";
          	window.location.href = $href+$id;
            // swal("Poof! Your imaginary file has been deleted!", {
            //   icon: "success",
            // });
          } else {
            //swal("Batal Hapus!");
          }
        });
        $("#imgLoad").hide();
    };  
</script>    

<script type="text/javascript">
    function eraseText() {
    document.getElementById("kdbarang").value = "";
    document.getElementById("nmbarang").value = "";
    document.getElementById("harga").value = "";
    document.getElementById("discount").value = "";
	}
</script>

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
	$(document).ready(function(){
		$('#kdbarang').on('blur',function(e){
			let cari = $(this).val();
			$.ajax({
				url: 'repl_barang.php',
				type: 'post',
				data: {kode_barang : cari},
				success: function(response){
					let data_response = JSON.parse(response);
					if (!data_response){
						$('#nmbarang').val('');
						$('#harga').val('');					
						cari_data_barang();
						return;
					}
					$('#nmbarang').val(data_response['nama']);
					$('#harga').val(data_response['harga_jual']);
					//console.log(data_response['nama']);
					//console.log(data_response['satuan']);
				},
				error:function(){
					console.log('file not fount');
				}
			})
			// console.log(cari);
		})
	})
</script>