<?php
	$user = $_SESSION['username'];
  if(isset($_GET['tipe'])){
    if($_GET['tipe']=='import'){
			cekakses($connect,$user,'Tabel Barang');
			$lakses = $_SESSION['aksestambah'];
			if ($lakses == 1) {?>
				<font face='calibri'>
				<div class="panel panel-success">
				<div class="panel-heading"><font size="4">IMPORT DATA TABEL BARANG</font></div>
				<div class="panel-body">
				<form method='post' enctype='multipart/form-data' action='module/tbbarang/proses_import.php'>
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
			cekakses($connect,$user,'Tabel Barang');
			$lakses = $_SESSION['aksescetak'];
			if ($lakses == 1) {?>
				<font face='calibri'>
				<div class="panel panel-default">
				<div class="panel-heading"><font size="4">EXPORT DATA TABEL BARANG</font></div>
				<div class="panel-body">
				<form method='post' enctype='multipart/form-data' action='module/tbbarang/proses_export.php'>
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
    if($_GET['tipe']=='detail'){
			cekakses($connect,$user,'Tabel Barang');
			$lakses = $_SESSION['aksespakai'];
			if ($lakses == 1) {	
				$query = $connect->prepare("select * from tbbarang where id=?");
				$query->bind_param('i',$_GET['id']);
				$result = $query->execute();
				$query->store_result();
				$query->execute();
				$result = $query->get_result();
				$de = $result->fetch_assoc();
				$kode = strip_tags($de['kode']);
				$nama = strip_tags($de['nama']);
				$merek = strip_tags($de['merek']);
				$harga_jual = strip_tags($de['harga_jual']);
				$harga_beli = strip_tags($de['harga_beli']);
				$stock = strip_tags($de['stock']);
				$stock_min = strip_tags($de['stock_min']);
				$stock_mak = strip_tags($de['stock_mak']);
				$kdjnbrg = strip_tags($de['kdjnbrg']);
				$kdsatuan = strip_tags($de['kdsatuan']);
				$lokasi = strip_tags($de['lokasi']);
				$kdnegara = strip_tags($de['kdnegara']);
				$kdmove = strip_tags($de['kdmove']);
				$kddiscount  = strip_tags($de['kddiscount']);
				$user = $de['user'];
				?>
				<font face='calibri'>
					<div class="panel panel-default">
					<div class="panel-heading"><font size="4">DETAIL DATA TABEL BARANG</font></div>
					<div class="panel-body">
					<form method='post' enctype='multipart/form-data'>
						<input type='hidden' name='username' value="<?= $user ?>">
						<input type='hidden' name='id' value="<?= $de['id'] ?>"/>
						<div class='col-md-6'>
			        <table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
			          <tr><td>Kode</td> <td> <input type='text' class='form-control' name='kode' value='<?= $kode ?>' readonly></td></tr>
			          <tr><td>Nama</td> <td> <input type='text' class='form-control' name='nama' value='<?= $nama ?>' readonly></td></tr>
			          <tr><td>Merek</td> <td> <input type='text' class='form-control' name='merek' value='<?= $merek ?>' readonly></td></tr>
			          <tr><td>Lokasi</td><td><input type='text' class='form-control' size='50' id='lokasi' name='lokasi' value='<?=$lokasi?>'></tr></td>
								<!--<tr><td>Kd. Satuan</td> <td><div class='input-group'>  <input type='text' class='form-control' id='kdsatuan' name='kdsatuan' size='50' autocomplete='off' readonly required>
									<span class='input-group-btn'>
									<button type='button' id='src' class='btn btn-primary' onclick='cari_data_satuan()'>
										Cari
									</button>
								</span></td>
								<tr><td width='100px'>Satuan</td> <td> <input type='text' class='form-control' name='nmsatuan' id='nmsatuan' readonly></td></tr>-->
								<tr><td>Satuan<td><select readonly id='kdsatuan' name='kdsatuan' class='form-control' style='width: 200x;' onchange='changeValueSatuan(this.value)'>
								<!--<option value=''> - PILIH SATUAN BARANG - </option>";-->
								<?php
								$jsArraySatuan = "var prdNameSatuan = new Array();\n";
								$data = mysqli_query($connect,'select * from tbsatuan order by nama');
								while ($row=mysqli_fetch_array($data))
								{
									if ($row['kode']==$de['kdsatuan']) {
										echo "<option value=$row[kode] selected>$row[kode]|$row[nama] </option>";
									}else{
										echo '<option name="kdsatuan"  value="'.$row['kode'].'">'.$row['kode'].'|'.$row['nama'].'</option>';
										$jsArraySatuan .= "prdNameSatuan['" . $row['kode'] . "'] = {nmsatuan:'" . addslashes($row['nama']) ."',kdsatuan:'".addslashes($row['kode'])."'};\n";
									}
								}
								echo '</select>';
								?>
								<input type='hidden' class='form-control' size='50' id='nmsatuan' name='nmsatuan' readonly>
								<tr><td>Jenis Barang<td><select readonly id='kdjnbrg' name='kdjnbrg' class='form-control' style='width: 200x;' onchange='changeValuejnbrg(this.value)'>
								<!--<option value=''> - PILIH JENIS BARANG - </option>";-->
								<?php
								$jsArrayjnbrg = "var prdNamejnbrg = new Array();\n";
								$data = mysqli_query($connect,'select * from tbjnbrg order by nama');
								while ($row=mysqli_fetch_array($data))
								{
									if ($row['kode']==$de['kdjnbrg']) {
										echo "<option value=$row[kode] selected>$row[kode]|$row[nama] </option>";
									}else{									
										echo '<option name="kdjnbrg"  value="'.$row['kode'].'">'.$row['kode'].'|'.$row['nama'].'</option>';
										$jsArrayjnbrg .= "prdNamejnbrg['" . $row['kode'] . "'] = {nmjnbrg:'" . addslashes($row['nama']) ."',kdjnbrg:'".addslashes($row['kode'])."'};\n";
									}
								}
								echo '</select>';
								?>
								<input type='hidden' class='form-control' size='50' id='nmjnbrg' name='nmjnbrg' readonly>
								<tr><td>Buatan<td><select readonly id='kdnegara' name='kdnegara' class='form-control' style='width: 200x;' onchange='changeValuenegara(this.value)'>
								<!--<option value=''> - PILIH NEGARA - </option>";-->
								<?php
								$jsArraynegara = "var prdNamenegara = new Array();\n";
								$data = mysqli_query($connect,'select * from tbnegara order by nama');
								while ($row=mysqli_fetch_array($data))
								{
									if ($row['kode']==$de['kdnegara']) {
										echo "<option value=$row[kode] selected>$row[kode]|$row[nama] </option>";
									}else{									
										echo '<option name="kdnegara"  value="'.$row['kode'].'">'.$row['kode'].'|'.$row['nama'].'</option>';
										$jsArraynegara .= "prdNamenegara['" . $row['kode'] . "'] = {nmnegara:'" . addslashes($row['nama']) ."',kdnegara:'".addslashes($row['kode'])."'};\n";
									}
								}
								echo '</select>';
								?>
								<input type='hidden' class='form-control' size='50' id='nmnegara' name='nmnegara' readonly>						
								<tr><td>Perputaran<td><select readonly id='kdmove' name='kdmove' class='form-control' style='width: 200x;' onchange='changeValuemove(this.value)'>
								<!--<option value=''> - PILIH PERPUTARAN - </option>";-->
								<?php
								$jsArraymove = "var prdNamemove = new Array();\n";
								$data = mysqli_query($connect,'select * from tbmove order by nama');
								while ($row=mysqli_fetch_array($data))
								{
									if ($row['kode']==$de['kdmove']) {
										echo "<option value=$row[kode] selected>$row[kode]|$row[nama] </option>";
									}else{									
										echo '<option name="kdmove"  value="'.$row['kode'].'">'.$row['kode'].'|'.$row['nama'].'</option>';
										$jsArraymove .= "prdNamemove['" . $row['kode'] . "'] = {nmmove:'" . addslashes($row['nama']) ."',kdmove:'".addslashes($row['kode'])."'};\n";
									}
								}
								echo '</select>';
								?>
								<input type='hidden' class='form-control' size='50' id='nmmove' name='nmmove' readonly>						
								<tr><td>Discount<td><select readonly id='kddiscount' name='kddiscount' class='form-control' style='width: 200x;' onchange='changeValuediscount(this.value)'>
								<!--<option value=''> - PILIH DISCOUNT - </option>";-->
								<?php
								$jsArraydiscount = "var prdNamediscount = new Array();\n";
								$data = mysqli_query($connect,'select * from tbdiscount order by nama');
								while ($row=mysqli_fetch_array($data))
								{
									if ($row['kode']==$de['kddiscount']) {
										echo "<option value=$row[kode] selected>$row[kode]|$row[nama] </option>";
									}else{
										echo '<option name="kddiscount"  value="'.$row['kode'].'">'.$row['kode'].'|'.$row['nama'].'</option>';
										$jsArraydiscount .= "prdNamediscount['" . $row['kode'] . "'] = {nmdiscount:'" . addslashes($row['nama']) ."',kddiscount:'".addslashes($row['kode'])."'};\n";
									}
								}
								echo '</select>';
								?>
								<input type='hidden' class='form-control' size='50' id='nmdiscount' name='nmdiscount' readonly>						
							</table>
						</div>

						<div class='col-md-6'>
			        <table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
			          <tr><td>Harga Jual</td> <td> <input type='number' class='form-control' name='harga_jual' value='<?= $harga_jual ?>' readonly></td></tr>
			          <tr><td>Harga Beli</td> <td> <input type='number' class='form-control' name='harga_beli' value='<?= $harga_beli ?>' readonly></td></tr>
			          <tr><td>Stock</td> <td> <input type='number' class='form-control' name='stock' value='<?= $stock ?>' readonly></td></tr>
			          <tr><td>Stock Min</td> <td> <input type='number' class='form-control' name='stock_min' value='<?= $stock_min ?>' readonly></td></tr>
			          <tr><td>Stock Mak</td> <td> <input type='number' class='form-control' name='stock_mak' value='<?= $stock_mak ?>' readonly></td></tr>
			          <!--<input type="text" id="fname" onkeyup="myFunction()">-->
							</table>
						</div>
						<div class='col-md-12'>
							<input button type='Button' class='btn btn-danger' value='Close' onClick='history.back()'/>
							<!--<input button type='Button' class='btn btn-danger' value='Close' onClick="window.location.href='?m=tbbarang'"/>-->
						</div>
					</div></div></form></font>
			<?php }else{
				echo "<script>alert('Anda tidak berhak !');history.go(-1) </script>";
			}
		}
	}
	
  if(isset($_GET['tipe'])){
    if($_GET['tipe']=='tambah'){
      cekakses($connect,$user,'Tabel Barang');
      $lakses = $_SESSION['aksestambah'];
      if ($lakses == 1) {?>
        <font face='calibri'>
        <div class='panel panel-danger'>
        <div class='panel-heading'><font size="4">TAMBAH DATA TABEL BARANG</font></div>
        <div class='panel-body'>
        <form method='post' name='tbbarang' enctype='multipart/form-data' action='module/tbbarang/proses_tambah.php'>
				<input type='hidden' name='username' value="<?= $user ?>">
				<div class='col-md-6'>
	        <table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
	          <tr><td>Kode</td> <td> <input type='text' class='form-control' name='kode' size='10' autofocus='autofocus' required></td></tr>
	          <tr><td width='100px'>Nama</td> <td> <input type='text' class='form-control' name='nama' required></td></tr>
	          <tr><td width='100px'>Merek</td> <td> <input type='text' class='form-control' name='merek'></td></tr>
	          <tr><td>Lokasi</td><td><input type='text' class='form-control' size='50' id='lokasi' name='lokasi'></tr></td>
						<!--<tr><td>Kd. Satuan</td> <td><div class='input-group'>  <input type='text' class='form-control' id='kdsatuan' name='kdsatuan' size='50' autocomplete='off' readonly required>
							<span class='input-group-btn'>
							<button type='button' id='src' class='btn btn-primary' onclick='cari_data_satuan()'>
								Cari
							</button>
						</span></td>
						<tr><td width='100px'>Satuan</td> <td> <input type='text' class='form-control' name='nmsatuan' id='nmsatuan' readonly></td></tr>-->
						<tr><td>Satuan<td><select id='kdsatuan' name='kdsatuan' class='form-control' style='width: 200x;' onchange='changeValueSatuan(this.value)'>
						<!--<option value=''> - PILIH SATUAN BARANG - </option>";-->
						<?php
						$jsArraySatuan = "var prdNameSatuan = new Array();\n";
						$data = mysqli_query($connect,'select * from tbsatuan order by nama');
						while ($row=mysqli_fetch_array($data))
						{
							echo '<option name="kdsatuan"  value="'.$row['kode'].'">'.$row['kode'].'|'.$row['nama'].'</option>';
							$jsArraySatuan .= "prdNameSatuan['" . $row['kode'] . "'] = {nmsatuan:'" . addslashes($row['nama']) ."',kdsatuan:'".addslashes($row['kode'])."'};\n";
						}
						echo '</select>';
						?>
						<input type='hidden' class='form-control' size='50' id='nmsatuan' name='nmsatuan' readonly>
						<tr><td>Jenis Barang<td><select id='kdjnbrg' name='kdjnbrg' class='form-control' style='width: 200x;' onchange='changeValuejnbrg(this.value)'>
						<!--<option value=''> - PILIH JENIS BARANG - </option>";-->
						<?php
						$jsArrayjnbrg = "var prdNamejnbrg = new Array();\n";
						$data = mysqli_query($connect,'select * from tbjnbrg order by nama');
						while ($row=mysqli_fetch_array($data))
						{
							echo '<option name="kdjnbrg"  value="'.$row['kode'].'">'.$row['kode'].'|'.$row['nama'].'</option>';
							$jsArrayjnbrg .= "prdNamejnbrg['" . $row['kode'] . "'] = {nmjnbrg:'" . addslashes($row['nama']) ."',kdjnbrg:'".addslashes($row['kode'])."'};\n";
						}
						echo '</select>';
						?>
						<input type='hidden' class='form-control' size='50' id='nmjnbrg' name='nmjnbrg' readonly>
						<tr><td>Buatan<td><select id='kdnegara' name='kdnegara' class='form-control' style='width: 200x;' onchange='changeValuenegara(this.value)'>
						<!--<option value=''> - PILIH NEGARA - </option>";-->
						<?php
						$jsArraynegara = "var prdNamenegara = new Array();\n";
						$data = mysqli_query($connect,'select * from tbnegara order by nama');
						while ($row=mysqli_fetch_array($data))
						{
							echo '<option name="kdnegara"  value="'.$row['kode'].'">'.$row['kode'].'|'.$row['nama'].'</option>';
							$jsArraynegara .= "prdNamenegara['" . $row['kode'] . "'] = {nmnegara:'" . addslashes($row['nama']) ."',kdnegara:'".addslashes($row['kode'])."'};\n";
						}
						echo '</select>';
						?>
						<input type='hidden' class='form-control' size='50' id='nmnegara' name='nmnegara' readonly>						
						<tr><td>Perputaran<td><select id='kdmove' name='kdmove' class='form-control' style='width: 200x;' onchange='changeValuemove(this.value)'>
						<!--<option value=''> - PILIH PERPUTARAN - </option>";-->
						<?php
						$jsArraymove = "var prdNamemove = new Array();\n";
						$data = mysqli_query($connect,'select * from tbmove order by nama');
						while ($row=mysqli_fetch_array($data))
						{
							echo '<option name="kdmove"  value="'.$row['kode'].'">'.$row['kode'].'|'.$row['nama'].'</option>';
							$jsArraymove .= "prdNamemove['" . $row['kode'] . "'] = {nmmove:'" . addslashes($row['nama']) ."',kdmove:'".addslashes($row['kode'])."'};\n";
						}
						echo '</select>';
						?>
						<input type='hidden' class='form-control' size='50' id='nmmove' name='nmmove' readonly>						
						<tr><td>Discount<td><select id='kddiscount' name='kddiscount' class='form-control' style='width: 200x;' onchange='changeValuediscount(this.value)'>
						<!--<option value=''> - PILIH DISCOUNT - </option>";-->
						<?php
						$jsArraydiscount = "var prdNamediscount = new Array();\n";
						$data = mysqli_query($connect,'select * from tbdiscount order by nama');
						while ($row=mysqli_fetch_array($data))
						{
							echo '<option name="kddiscount"  value="'.$row['kode'].'">'.$row['kode'].'|'.$row['nama'].'</option>';
							$jsArraydiscount .= "prdNamediscount['" . $row['kode'] . "'] = {nmdiscount:'" . addslashes($row['nama']) ."',kddiscount:'".addslashes($row['kode'])."'};\n";
						}
						echo '</select>';
						?>
						<input type='hidden' class='form-control' size='50' id='nmdiscount' name='nmdiscount' readonly>						
					</table>
				</div>
				<div class='col-md-6'>
	        <table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
	          <tr><td>Harga Jual</td> <td> <input type='number' class='form-control' id='harga_jual' name='harga_jual' onkeyup="validAngka_no_titik(this)"></td></tr>
	          <tr><td>Harga Beli</td> <td> <input type='number' class='form-control' name='harga_beli' readonly></td></tr>
	          <tr><td>HPP</td> <td> <input type='number' class='form-control' name='hpp' readonly></td></tr>
	          <tr><td>Stock</td> <td> <input type='number' class='form-control' name='stock' onkeyup="validAngka(this)" readonly></td></tr>
	          <tr><td>Stock Min</td> <td> <input type='text' class='form-control' name='stock_min' onkeyup="validAngka(this)"></td></tr>
	          <tr><td>Stock Mak</td> <td> <input type='text' class='form-control' name='stock_mak' onkeyup="validAngka(this)"></td></tr>
	          <!--<input type="text" id="fname" onkeyup="myFunction()">-->
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
			cekakses($connect,$user,'Tabel Barang');
			$lakses = $_SESSION['aksesedit'];
			if ($lakses == 1) {	
				$query = $connect->prepare("select * from tbbarang where id=?");
				$query->bind_param('i',$_GET['id']);
				$result = $query->execute();
				$query->store_result();
				$query->execute();
				$result = $query->get_result();
				$de = $result->fetch_assoc();
				$kode = strip_tags($de['kode']);
				$nama = strip_tags($de['nama']);
				$merek = strip_tags($de['merek']);
				$harga_jual = strip_tags($de['harga_jual']);
				$harga_beli = strip_tags($de['harga_beli']);
				$hpp = strip_tags($de['hpp']);
				$stock = strip_tags($de['stock']);
				$stock_min = strip_tags($de['stock_min']);
				$stock_mak = strip_tags($de['stock_mak']);
				$kdjnbrg = strip_tags($de['kdjnbrg']);
				$kdsatuan = strip_tags($de['kdsatuan']);
				$lokasi = strip_tags($de['lokasi']);
				$kdnegara = strip_tags($de['kdnegara']);
				$kdmove = strip_tags($de['kdmove']);
				$kddiscount  = strip_tags($de['kddiscount']);
				?>
				<font face='calibri'>
					<div class="panel panel-default">
					<div class="panel-heading"><font size="4">EDIT DATA TABEL BARANG</font></div>
					<div class="panel-body">
					<form method='post' name='tbbarang' enctype='multipart/form-data' action='module/tbbarang/proses_edit.php'>
						<input type='hidden' name='username' value="<?= $user ?>">
						<input type='hidden' name='id' value="<?= $de['id'] ?>"/>
						<div class='col-md-6'>
			        <table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
			          <tr><td>Kode</td> <td> <input type='text' class='form-control' name='kode' value='<?= $kode ?>' readonly></td></tr>
			          <tr><td>Nama</td> <td> <input type='text' class='form-control' name='nama' value='<?= $nama ?>'></td></tr>
			          <tr><td>Merek</td> <td> <input type='text' class='form-control' name='merek' value='<?= $merek ?>'></td></tr>
			          <tr><td>Lokasi</td><td><input type='text' class='form-control' size='50' id='lokasi' name='lokasi' value='<?=$lokasi?>'></tr></td>
								<!--<tr><td>Kd. Satuan</td> <td><div class='input-group'>  <input type='text' class='form-control' id='kdsatuan' name='kdsatuan' size='50' autocomplete='off' readonly required>
									<span class='input-group-btn'>
									<button type='button' id='src' class='btn btn-primary' onclick='cari_data_satuan()'>
										Cari
									</button>
								</span></td>
								<tr><td width='100px'>Satuan</td> <td> <input type='text' class='form-control' name='nmsatuan' id='nmsatuan' readonly></td></tr>-->
								<tr><td>Satuan<td><select id='kdsatuan' name='kdsatuan' class='form-control' style='width: 200x;' onchange='changeValueSatuan(this.value)'>
								<!--<option value=''> - PILIH SATUAN BARANG - </option>";-->
								<?php
								$jsArraySatuan = "var prdNameSatuan = new Array();\n";
								$data = mysqli_query($connect,'select * from tbsatuan order by nama');
								while ($row=mysqli_fetch_array($data))
								{
									if ($row['kode']==$de['kdsatuan']) {
										echo "<option value=$row[kode] selected>$row[kode]|$row[nama] </option>";
									}else{
										echo '<option name="kdsatuan"  value="'.$row['kode'].'">'.$row['kode'].'|'.$row['nama'].'</option>';
										$jsArraySatuan .= "prdNameSatuan['" . $row['kode'] . "'] = {nmsatuan:'" . addslashes($row['nama']) ."',kdsatuan:'".addslashes($row['kode'])."'};\n";
									}
								}
								echo '</select>';
								?>
								<input type='hidden' class='form-control' size='50' id='nmsatuan' name='nmsatuan' readonly>
								<tr><td>Jenis Barang<td><select id='kdjnbrg' name='kdjnbrg' class='form-control' style='width: 200x;' onchange='changeValuejnbrg(this.value)'>
								<!--<option value=''> - PILIH JENIS BARANG - </option>";-->
								<?php
								$jsArrayjnbrg = "var prdNamejnbrg = new Array();\n";
								$data = mysqli_query($connect,'select * from tbjnbrg order by nama');
								while ($row=mysqli_fetch_array($data))
								{
									if ($row['kode']==$de['kdjnbrg']) {
										echo "<option value=$row[kode] selected>$row[kode]|$row[nama] </option>";
									}else{									
										echo '<option name="kdjnbrg"  value="'.$row['kode'].'">'.$row['kode'].'|'.$row['nama'].'</option>';
										$jsArrayjnbrg .= "prdNamejnbrg['" . $row['kode'] . "'] = {nmjnbrg:'" . addslashes($row['nama']) ."',kdjnbrg:'".addslashes($row['kode'])."'};\n";
									}
								}
								echo '</select>';
								?>
								<input type='hidden' class='form-control' size='50' id='nmjnbrg' name='nmjnbrg' readonly>
								<tr><td>Buatan<td><select id='kdnegara' name='kdnegara' class='form-control' style='width: 200x;' onchange='changeValuenegara(this.value)'>
								<!--<option value=''> - PILIH NEGARA - </option>";-->
								<?php
								$jsArraynegara = "var prdNamenegara = new Array();\n";
								$data = mysqli_query($connect,'select * from tbnegara order by nama');
								while ($row=mysqli_fetch_array($data))
								{
									if ($row['kode']==$de['kdnegara']) {
										echo "<option value=$row[kode] selected>$row[kode]|$row[nama] </option>";
									}else{									
										echo '<option name="kdnegara"  value="'.$row['kode'].'">'.$row['kode'].'|'.$row['nama'].'</option>';
										$jsArraynegara .= "prdNamenegara['" . $row['kode'] . "'] = {nmnegara:'" . addslashes($row['nama']) ."',kdnegara:'".addslashes($row['kode'])."'};\n";
									}
								}
								echo '</select>';
								?>
								<input type='hidden' class='form-control' size='50' id='nmnegara' name='nmnegara' readonly>						
								<tr><td>Perputaran<td><select id='kdmove' name='kdmove' class='form-control' style='width: 200x;' onchange='changeValuemove(this.value)'>
								<!--<option value=''> - PILIH PERPUTARAN - </option>";-->
								<?php
								$jsArraymove = "var prdNamemove = new Array();\n";
								$data = mysqli_query($connect,'select * from tbmove order by nama');
								while ($row=mysqli_fetch_array($data))
								{
									if ($row['kode']==$de['kdmove']) {
										echo "<option value=$row[kode] selected>$row[kode]|$row[nama] </option>";
									}else{									
										echo '<option name="kdmove"  value="'.$row['kode'].'">'.$row['kode'].'|'.$row['nama'].'</option>';
										$jsArraymove .= "prdNamemove['" . $row['kode'] . "'] = {nmmove:'" . addslashes($row['nama']) ."',kdmove:'".addslashes($row['kode'])."'};\n";
									}
								}
								echo '</select>';
								?>
								<input type='hidden' class='form-control' size='50' id='nmmove' name='nmmove' readonly>						
								<tr><td>Discount<td><select id='kddiscount' name='kddiscount' class='form-control' style='width: 200x;' onchange='changeValuediscount(this.value)'>
								<!--<option value=''> - PILIH DISCOUNT - </option>";-->
								<?php
								$jsArraydiscount = "var prdNamediscount = new Array();\n";
								$data = mysqli_query($connect,'select * from tbdiscount order by nama');
								while ($row=mysqli_fetch_array($data))
								{
									if ($row['kode']==$de['kddiscount']) {
										echo "<option value=$row[kode] selected>$row[kode]|$row[nama] </option>";
									}else{
										echo '<option name="kddiscount"  value="'.$row['kode'].'">'.$row['kode'].'|'.$row['nama'].'</option>';
										$jsArraydiscount .= "prdNamediscount['" . $row['kode'] . "'] = {nmdiscount:'" . addslashes($row['nama']) ."',kddiscount:'".addslashes($row['kode'])."'};\n";
									}
								}
								echo '</select>';
								?>
								<input type='hidden' class='form-control' size='50' id='nmdiscount' name='nmdiscount' readonly>						
							</table>
						</div>

						<div class='col-md-6'>
			        <table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
			          <tr><td>Harga Jual</td> <td> <input type='number' class='form-control' name='harga_jual' value='<?= $harga_jual ?>' onkeyup="validAngka_no_titik(this)"></td></tr>
			          <tr><td>Harga Beli</td> <td> <input type='number' class='form-control' name='harga_beli' value='<?= $harga_beli ?>' readonly></td></tr>
			          <tr><td>HPP</td> <td> <input type='number' class='form-control' name='hpp' value='<?= $hpp ?>' readonly></td></tr>
			          <tr><td>Stock</td> <td> <input type='text' class='form-control' name='stock' value='<?= $stock ?>' onkeyup="validAngka(this)" readonly></td></tr>
			          <tr><td>Stock Min</td> <td> <input type='text' class='form-control' name='stock_min' value='<?= $stock_min ?>' onkeyup="validAngka(this)"></td></tr>
			          <tr><td>Stock Mak</td> <td> <input type='text' class='form-control' name='stock_mak' value='<?= $stock_mak ?>' onkeyup="validAngka(this)"></td></tr>
			          <!--<input type="text" id="fname" onkeyup="myFunction()">-->
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
	}else{

	?>
	<?php
		include 'cek_akses.php';
		if ($aksesok == 'Y') {
	?>

	<script type="text/javascript"> 
	function lihat_detail_tbbarang(id){
		$('#modaldetail').modal('show');
		//$('#modaldetail').find('.modal-body').html(id);
		
		$.ajax({
			url: 'lihat_detail_tbbarang.php',
			type: 'post',
			data: {kode:id},
			
			success: function(response){
			
				$('#modaldetail').find('.modal-body').html(response);
			}
	});
		
	}
	</script>

	<font face="calibri">
	  <div class="panel panel-info">
	  	<div class="panel-heading"><font size="4">TABEL BARANG</font></div>
	    <div class="panel-body">
		 	<form method='get'>
				<div class="row">
					<?php
						include('hal_get.php')
					?>
					<div class="col-md-4 bg">
						<input type="hidden" name="m" value="tbbarang">
						<input type='text' id='kata' name='kata' value="<?= $kata ?>" size='50px' class='form-control' placeholder='KODE,NAMA'  onkeyup='searchTable()'>
					</div>
					<button type='submit' class='btn btn-primary'>
					<span class='glyphicon glyphicon-search'></span> Cari</button>
					<a class="btn btn-danger" href="?m=tbbarang&tipe=tambah">Tambah data</a>
					<a class="btn btn-success" href="?m=tbbarang&tipe=import">Import data</a>
					<a class="btn btn-warning" href="?m=tbbarang&tipe=export">Export data</a>
				</div>
			</form>
	    </br>
		<!--<div class="table-responsive">
		<table class="table table-bordered table-striped table-hover" cellspacing="0" width="100%">-->
		<div class="box-body table-responsive">
			<table id="example1" class="table table-bordered table-striped">
			<tbody>
			<tr>
				<th width='30'>No.</th>
				<th width='80'>Kode</th>
				<th width='150'>Nama</th>
				<th width='60'>Stock</th>
				<th width='70'>Harga Jual</th>
				<th width='70'>Harga Beli</th>
				<th width='120'>Aksi</th>
			</tr>
			<?php
			// Cek apakah terdapat data page pada URL
			$page = (isset($_GET['page']) ? $_GET['page'] : 1);
			if (isset($_GET['record'])){
				$_SESSION['jmlperhalaman']=$_GET['record'];
				$limit = $_GET['record']; //5; // Jumlah data per halamannya**/
			}else{
				$limit = $_SESSION['jmlperhalaman'];
			}
			$limit_start = ($page - 1) * $limit;
			// Untuk menentukan dari data ke berapa yang akan ditampilkan pada tabel yang ada di database
			if (empty($_GET['kata'])){
				$tampil = mysqli_query($connect,"SELECT * FROM tbbarang order by kode desc LIMIT ".$limit_start.",".$limit);
				}
			else{
				$cari = $_GET['kata'];
				$tampil = mysqli_query($connect,"SELECT * FROM tbbarang WHERE (kode like '%$cari%' or nama like '%$cari%' ) order by kode  desc LIMIT ".$limit_start.",".$limit);
			}
			if ($page==1) {
				$posisi=0;
				$_GET['halaman']=1;
			}
			else{
				$posisi = ($_GET['page']-1) * $limit;
			}
			$no=$posisi+1;
			//<td><u><a href='?m=tbbarang&tipe=detail&id=$k[id]'><font color='blue'>$k[kode]</font></a></u></td>
			while($k=mysqli_fetch_assoc($tampil)){
				$stock = number_format($k['stock'],0,",",".");
				$harga_jual = number_format($k['harga_jual'],0,",",".");
				$harga_beli = number_format($k['harga_beli'],0,",",".");
				$hpp = number_format($k['hpp'],0,",",".");
				$kode = htmlspecialchars($k['kode']);
				echo "<tr>
					<td align='center'>$no</td>
					<td><u><a href='#' onclick=lihat_detail_tbbarang('$k[id]');><font color='blue'>$kode</font></a></u></td>
					<td>$k[nama]</td>
					<td align='right'>$stock</td>
					<td align='right'>$harga_jual</td>
					<td align='right'>$harga_beli</td>
					<td align='center'>
					<a class='btn btn-info' href='?m=tbbarang&tipe=edit&id=$k[id]'>Edit</a>";
						cekakses($connect,$user,'Tabel Barang');
						$lakses = $_SESSION['akseshapus'];
						if ($lakses == 1) {
							//echo " <a class='btn btn-danger' href='module/tbbarang/proses_hapus.php?id=$k[id]&kode=$k[kode]'
							//onClick='return confirm(\"Anda yakin akan menghapus ?\")'>Hapus</a>";
							echo " <input button type='Button' class='btn btn-danger' value='Hapus' onClick='alert_hapus($k[id])'/>";
						}else{
							echo " <input button type='Button' class='btn btn-danger' value='Hapus' onClick='alert_hapus($k[id])' disabled/>";
						}
					echo "</td>";
				$no++;
			}
		?>
	</tbody>
		</table>
		<?php
			if (empty($_GET['kata'])){
				$query = mysqli_query($connect,"select count(*) as jumrec from tbbarang");
			}else{
				$cari = $_GET['kata'];
				$query = mysqli_query($connect,"select count(*) as jumrec from tbbarang where (kode like '%$cari%' or nama like '%$cari%')");
			}
			$result = mysqli_fetch_array($query);
			echo "<p style='text-align:left'>Jumlah Record : ".number_format($result['jumrec'],0,",",".");
		?>
		</div>
		<ul class="pagination">
			<!-- LINK FIRST AND PREV -->
			<?php
				if($page == 1){ // Jika page adalah page ke 1, maka disable link PREV
			?>
			<li class="disabled"><a href="#">First</a></li>
			<li class="disabled"><a href="#">&laquo;</a></li>
			<?php
			}else{ // Jika page bukan page ke 1
			  $link_prev = ($page > 1)? $page - 1 : 1;
			?>
			  <li><a href="dashboard.php?m=tbbarang&kata=<?= $kata ?>&page=1">First</a></li>
			  <li><a href="dashboard.php?m=tbbarang&kata=<?= $kata ?>&page=<?php echo $link_prev; ?>">&laquo;</a></li>
			<?php
			}
			?>
			<!-- LINK NUMBER -->
			<?php
			// Buat query untuk menghitung semua jumlah data
			if (empty($_GET['kata'])){
				$tampil = mysqli_query($connect,"SELECT * FROM tbbarang order by kode desc ");
				}
			else{
				$cari = $_GET['kata'];
				$tampil = mysqli_query($connect,"SELECT * FROM tbbarang WHERE (kode like '%$cari%' or nama like '%$cari%') order by kode desc ");
			}
			$get_jumlah = mysqli_num_rows($tampil);
			//echo $get_jumlah;			
			/*$jumlah_page = ceil($get_jumlah['jumlah'] / $limit); // Hitung jumlah halamannya**/
			$jumlah_page = ceil($get_jumlah/$limit);
			$jumlah_number = 2; // Tentukan jumlah link number sebelum dan sesudah page yang aktif
			$start_number = ($page > $jumlah_number)? $page - $jumlah_number : 1; // Untuk awal link number
			$end_number = ($page < ($jumlah_page - $jumlah_number))? $page + $jumlah_number : $jumlah_page; // Untuk akhir link number
			
			for($i = $start_number; $i <= $end_number; $i++){
			  $link_active = ($page == $i)? ' class="active"' : '';
			?>
			  <li<?php echo $link_active; ?>><a href="dashboard.php?m=tbbarang&kata=<?= $kata ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
			<?php
			}
			?>
			
			<!-- LINK NEXT AND LAST -->
			<?php
			// Jika page sama dengan jumlah page, maka disable link NEXT nya
			// Artinya page tersebut adalah page terakhir 
			if($page == $jumlah_page){ // Jika page terakhir
				?>
				  <li class="disabled"><a href="#">&raquo;</a></li>
				  <li class="disabled"><a href="#">Last</a></li>
				<?php
			}else{ // Jika Bukan page terakhir
			  $link_next = ($page < $jumlah_page)? $page + 1 : $jumlah_page;
				?>
			  <li><a href="dashboard.php?m=tbbarang&kata=<?= $kata ?>&page=<?php echo $link_next; ?>">&raquo;</a></li>
			  <li><a href="dashboard.php?m=tbbarang&kata=<?= $kata ?>&page=<?php echo $jumlah_page; ?>">Last</a></li>
			<?php
			}
			?>
		</ul>
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
        	$href = "module/tbbarang/proses_hapus.php?id=";
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

<script type="text/javascript"> 
	<?php echo $jsArraySatuan; ?>
	function changeValueSatuan(id){
		document.getElementById('kdsatuan').value = prdNameSatuan[id].kdsatuan;
		document.getElementById('nmsatuan').value = prdNameSatuan[id].nmsatuan;
	};
	<?php echo $jsArrayjnbrg; ?>
	function changeValuejnbrg(id){
		document.getElementById('kdjnbrg').value = prdNamejnbrg[id].kdjnbrg;
		document.getElementById('nmjnbrg').value = prdNamejnbrg[id].nmjnbrg;
	};	
	<?php echo $jsArraynegara; ?>
	function changeValuenegara(id){
		document.getElementById('kdnegara').value = prdNamenegara[id].kdnegara;
		document.getElementById('nmnegara').value = prdNamenegara[id].nmnegara;
	};
	<?php echo $jsArraymove; ?>
	function changeValuemove(id){
		document.getElementById('kdmove').value = prdNamemove[id].kdmove;
		document.getElementById('nmmove').value = prdNamemove[id].nmmove;
	};	
	<?php echo $jsArraydiscount; ?>
	function changeValuediscount(id){
		document.getElementById('kddiscount').value = prdNamediscount[id].kddiscount;
		document.getElementById('nmdiscount').value = prdNamediscount[id].nmdiscount;
	};	

	function addCommas(nStr)
	{
	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
	x1 = x1.replace(rgx, '$1' + ',' + '$2');
	}
	return x1 + x2;
	}


	function myFunction() {
	  var x = document.getElementById("fname");
	  x.value = x.value.toUpperCase();
	}

</script>

<!-- Modal -->
<div class="modal fade" id="modaldetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
  <div class="modal-dialog" role="document">
	<div class="modal-content">
	  <div class="modal-header">
		<h5 class="modal-title" id="exampleModalLabel1">Detail Tabel Barang</h5>
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