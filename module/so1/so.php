<?php
	$user = $_SESSION['username'];
	$kunci_harga_jual = $_SESSION['kunci_harga_jual'];
	
	include('autonumber.php');
  if(isset($_GET['tipe'])){
     if($_GET['tipe']=='detail_proses'){
			cekakses($connect,$user,'Sales Order');
			$lakses = $_SESSION['aksespakai'];
			if ($lakses == 1) {	
				$query = $connect->prepare("select * from soh where noso=?");
				$query->bind_param('s',$_GET['noso']);
				$query->execute();
				$result = $query->get_result();
				$de = $result->fetch_assoc();
				$noso = strip_tags($de['noso']);
				$proses = strip_tags($de['proses']);
				$tglso = strip_tags($de['tglso']);?>
				<font face='calibri'>
					<h3>DETAIL SALES ORDER</h3>
					<form method='post' enctype='multipart/form-data' action='module/so/proses_tambah_detail.php'>
						<input type='hidden' name='username' value='<?= $user ?>'>
 						<table class="table table-bordered table-striped table-hover">
						<tr><td>Nomor Order</td><td>
						<input type='text' class='form-control' id='noso' name='noso' placeholder='No. SO *' style='text-transform:uppercase' value="<?= $noso ?>" readonly></td>
						<td>Tgl. (M/D/Y)</td><td><input type='date' class='form-control' id='tglso' name='tglso' value="<?= $tglso ?>" size='50' autocomplete='off' readonly></td></tr>
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
								<th>Discount</th>
								<th>Subtotal</th>
						    </tr>
						<?php
							$tampil = mysqli_query($connect,"select * from sod where noso='$_GET[noso]'");
							$query = $connect->prepare("select * from sod where noso=?");
							$query->bind_param('s',$_GET['noso']);
							$query->execute();
							$result = $query->get_result();
							$de = $result->fetch_assoc();
			        $no=1;
			        //<td><u><a href='?m=wo&tipe=detail&id=$k[id]'><font color='blue'>$k[kode]</font></a></u></td>
			        //<td><u><a href='#' onclick =lihat_detail('$k[id]');><font color='blue'>$k[kdbarang]</font></a></u></td>
			        while($k=mysqli_fetch_assoc($tampil)){
			        	//$date = date("m/d/Y", strtotime($k['tglwo']));
								$kdbarang = strip_tags($de['kdbarang']);
								$nmbarang = strip_tags($de['nmbarang']);
								$qty = number_format($k['qty'],2,",",".");
								$harga = number_format($k['harga'],0,",",".");
								$discount = number_format($k['discount'],2,",",".");
								$subtotal = number_format($k['subtotal'],0,",",".");
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
							$tampil = mysqli_query($connect,"select sum(qty) as total_qty,sum(subtotal) as total_subtotal from sod where noso='$_GET[noso]'");
							$jum = mysqli_fetch_assoc($tampil);
							$total_qty = $jum['total_qty'];
							$total_qty = number_format($total_qty,2,",",".");
							$total = $jum['total_subtotal'];
							$total = number_format($total,0,",",".");
							echo "<tr><td colspan='4'></td>
							<td align='right' style='font-weight:bold'>$total_qty</td>
							<td colspan='2' align='right'></td>
							<td align='right' style='font-weight:bold'>$total</td>";
							?>
							</table>
						</div>
						<input button type='Button' class='btn btn-danger' value='Close' onClick='history.back()'/>
					</form>
				</font>
				<?php
			}else{
				echo "<script>alert('Anda tidak berhak !');history.go(-1) </script>";
			}
		}
	}

  if(isset($_GET['tipe'])){
    if($_GET['tipe']=='detail'){
			cekakses($connect,$user,'Sales Order');
			$lakses = $_SESSION['aksespakai'];
			$_SESSION['kdcustomer'] = $_GET['kdcustomer'];
			if ($lakses == 1) {	
				$kdcustomer = $_GET['kdcustomer'];
				$query = $connect->prepare("select * from soh where noso=?");
				$query->bind_param('s',$_GET['noso']);
				$query->execute();
				$result = $query->get_result();
				$de = $result->fetch_assoc();
				$noso = strip_tags($de['noso']);
				$proses = strip_tags($de['proses']);
				$tglso = strip_tags($de['tglso']);?>
				<font face='calibri'>
        <div class='panel panel-danger'>
        <div class='panel-heading'><font size="4">TAMBAH DATA DETAIL SALES ORDER</font></div>
        <div class='panel-body'>
				<form method='post' name='so' enctype='multipart/form-data' action='module/so/proses_tambah_detail.php'>
				<input type='hidden' name='username' value="<?= $user ?>">
				<input type='hidden' name='kdcustomer' id='kdcustomer' value="<?= $kdcustomer ?>">
				<div class='col-md-10'>
		      <table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
						<tr><td>Nomor SO</td><td>
						<input type='text' class='form-control' id='noso' name='noso' placeholder='No. SO *' style='text-transform:uppercase' value="<?= $noso ?>" readonly></td>
						<td>Tgl. (M/D/Y)</td><td><input type='date' class='form-control' id='tglso' name='tglso' value="<?= $tglso ?>" size='50' autocomplete='off' readonly></td></tr>
					</table>
				</div>
				<div class='col-md-12'>
					<table style=font-size:12px; class='table table-striped table table-bordered' width='600px'>
				    <tr>
				    <th>Kode Barang <input type="button" class='btn btn-black' value="Clear" onclick="eraseText()"></th>
						<th>Barang</th>
						<th>QTY</th>
						<th>Harga</th>
						<th>Disc</th>
						<th>Subtotal</th>
				    <th>Aksi</th>
				    </tr>
						<td><div class='input-group'>  <input type='text' class='form-control'style="text-transform: uppercase; width: 9em;" id='kdbarang' name='kdbarang' size='50' autocomplete='off' required>
						<span class='input-group-btn'>
						<button type='button' id='src' class='btn btn-primary' onclick='cari_data_barang()'>
							Cari
						</button>
						</span></td>
						</td><td><input type='text' class='form-control' style='width: 15em' id='nmbarang' name='nmbarang' readonly></td>
						</td><td><input type="text" class='form-control' id='qty' name='qty' style='width: 6em' required onkeyup="validAngka(this)" onblur="hit_subtotal()"></td>
						<?php
							if ($kunci_harga_jual=='Y'){
								?>
								</td><td><input type="text" class='form-control' id='harga' name='harga' style='width: 7em' readonly></td>
								<?php		
							}else{
								?>
								</td><td><input type="text" class='form-control' id='harga' name='harga' style='width: 7em' onkeyup="validAngka_no_titik(this)" onblur="hit_subtotal()"></td>
								<?php		
							}
						?>
						</td><td><input type="text" class='form-control' id='discount' name='discount' style='width: 6em' onkeyup="validAngka(this)" onblur="hit_subtotal()"></td>
						</td><td><input type="number" class='form-control' id='subtotal' name='subtotal' style='width: 10em' readonly></td>
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
							$tampil = mysqli_query($connect,"select * from sod where noso='$_GET[noso]'");
							$query = $connect->prepare("select * from sod where noso=?");
							$query->bind_param('s',$_GET['noso']);
							$query->execute();
							$result = $query->get_result();
							$de = $result->fetch_assoc();
			        $no=1;
			        //<td><u><a href='?m=wo&tipe=detail&id=$k[id]'><font color='blue'>$k[kode]</font></a></u></td>
			        //<td><u><a href='#' onclick =lihat_detail('$k[id]');><font color='blue'>$k[kdbarang]</font></a></u></td>
			        while($k=mysqli_fetch_assoc($tampil)){
								$kdbarang = strip_tags($k['kdbarang']);
								$nmbarang = strip_tags($k['nmbarang']);
								$qty = number_format($k['qty'],2,",",".");
								$harga = number_format($k['harga'],0,",",".");
								$discount = number_format($k['discount'],2,",",".");
								$subtotal = number_format($k['subtotal'],0,",",".");
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
		            echo "<a class='btn btn-primary' href='?m=so&tipe=edit_detail&id=$k[id]&noso=$k[noso]&kdcustomer=$_GET[kdcustomer]'>Edit</a> ";
		            echo " <input button type='Button' class='btn btn-danger' value='Hapus' onClick='alert_hapus_detail($k[id])'/>";
								$no++;
							}
							$tampil = mysqli_query($connect,"select sum(qty) as total_qty,sum(subtotal) as total_subtotal from sod where noso='$_GET[noso]'");
							$jum = mysqli_fetch_assoc($tampil);
							$total_qty = $jum['total_qty'];
							$total_qty = number_format($total_qty,2,",",".");
							$total = $jum['total_subtotal'];
							$total = number_format($total,0,",",".");
							echo "<tr><td colspan='4'></td>
							<td align='right' style='font-weight:bold'>$total_qty</td>
							<td colspan='2' align='right'></td>
							<td align='right' style='font-weight:bold'>$total</td>";
							?>
							</table>
						</div>
						<div class='col-md-12'>
							<!--<input button type='Button' class='btn btn-danger' value='Close' onClick='history.back()'/>-->
							<input button type='Button' class='btn btn-danger' value='Close' onClick="window.location = 'dashboard.php?m=so'"/>

						</div>
					</div></div>
					</form>
				</font>
				<?php
			}else{
				echo "<script>alert('Anda tidak berhak !');history.go(-1) </script>";
			}
		}
	}

  if(isset($_GET['tipe'])){
      if($_GET['tipe']=='edit_detail'){
			cekakses($connect,$user,'Edit Detail SALES ORDER');
			$lakses = $_SESSION['aksespakai'];
			if ($lakses == 1) {	
				$query = $connect->prepare("select * from soh where noso=?");
				$query->bind_param('s',$_GET['noso']);
				$query->execute();
				$result = $query->get_result();
				$de = $result->fetch_assoc();
				$noso = strip_tags($de['noso']);
				$tglso = strip_tags($de['tglso']);?>

        <font face='calibri'>
	        <div class='panel panel-default'>
	        <div class='panel-heading'><font size="4">EDIT DETAIL DATA SALES ORDER</font></div>
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
						<tr><td>Nomor Order</td><td>
						<input type='text' class='form-control' id='noso' name='noso' placeholder='No. SO *' style='text-transform:uppercase' value="<?= $noso ?>" readonly></td>
						<td>Tgl. (M/D/Y)</td><td><input type='date' class='form-control' id='tglso' name='tglso' value="<?= $tglso ?>" size='50' autocomplete='off' readonly></td></tr>
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
							$query = $connect->prepare("select * from sod where id=?");
							$query->bind_param('s',$_GET['id']);
							$query->execute();
							$result = $query->get_result();
							$de = $result->fetch_assoc();
							$kdbarang = strip_tags($de['kdbarang']);
							$nmbarang = strip_tags($de['nmbarang']);
							$kdsatuan = strip_tags($de['kdsatuan']);
							$qty = number_format($de['qty'],2,",",".");
							$qty = str_replace(",",".",$qty); 
							$harga = strip_tags($de['harga']);
							$discount = number_format($de['discount'],2,",",".");
							$discount = str_replace(",",".",$discount); 
							$subtotal = strip_tags($de['subtotal']);
						?>
						<input type='hidden' name='id' value='<?= $de['id'] ?>'>
						<input type='hidden' name='noso' value='<?= $de['noso'] ?>'>
						<td><div class='input-group'>  <input type='text' class='form-control' style='width: 10em' id='kdbarang' name='kdbarang' value='<?= $kdbarang ?>' size='50' autocomplete='off' required readonly>
							<span class='input-group-btn'>
							<!--<button type='button' id='src' class='btn btn-primary' onclick='cari_data_barang()'>
								Cari
							</button>-->
						</span></td>
						</td><td><input type='text' class='form-control' style='width: 16em' id='nmbarang' name='nmbarang' value='<?= $nmbarang ?>' readonly></td>
						</td><td><input type='text' class='form-control' style='width: 4em' id='kdsatuan' name='kdsatuan' value='<?= $kdsatuan ?>' readonly></td>
						</td><td><input type="text" class='form-control' id='qty' name='qty' value='<?= $qty ?>' style='width: 6em' required onkeyup="validAngka(this)" onblur="hit_subtotal()" autofocus='autofocus'></td>
						</td><td><input type="text" class='form-control' id='harga' name='harga' value='<?= $harga ?>' style='width: 8em' onkeyup="validAngka_no_titik(this)" onblur="hit_subtotal()"></td>
						</td><td><input type="text" class='form-control' id='discount' name='discount' value='<?= $discount ?>' style='width: 6em' onkeyup="validAngka(this)" onblur="hit_subtotal()"></td>
						</td><td><input type="number" class='form-control' id='subtotal' name='subtotal' value='<?= $subtotal ?>' style='width: 9em' readonly></td>
						</table>
					</div>
					<div class='col-md-12'>
						<button type='submit' class='btn btn-primary'>Simpan</button>
						<input button type='Button' class='btn btn-danger' value='Batal' onClick='history.back()'/>
					</div>
					</div></div></form></font>
				<?php
			}else{
				echo "<script>alert('Anda tidak berhak !');history.go(-1) </script>";
			}
		}
	}

  if(isset($_GET['tipe'])){
    if($_GET['tipe']=='tambah'){
      cekakses($connect,$user,'Sales Order');
      $lakses = $_SESSION['aksestambah'];
 			$de=mysqli_fetch_assoc(mysqli_query($connect,"select * from saplikasi where aktif='Y'"));
			$tgl = $de['tgl_berikutnya']; //date('Y-m-d')
 			$de=mysqli_fetch_assoc(mysqli_query($connect,"select * from saplikasi where aktif='Y'"));
			$tgl = $de['tgl_berikutnya']; //date('Y-m-d')
      if ($lakses == 1) {?>
        <font face='calibri'>
        <div class='panel panel-danger'>
        <div class='panel-heading'><font size="4">TAMBAH DATA SALES ORDER</font></div>
        <div class='panel-body'>
				<form method='post' name='so' enctype='multipart/form-data' action='module/so/proses_tambah.php'>
				<input type='hidden' name='username' value="<?= $user ?>">
				<div class='col-md-6'>
		      <table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
						<tr><td>Nomor Order</td><td>
						<input type='text' class='form-control' id='noso' name='noso' placeholder='No. Order *' style='text-transform:uppercase' value="<?php echo autoNumberSO($connect,'id','soh');?>" readonly></td></tr>
						<tr><td>Tanggal (M/D/Y)</td><td><input type='date' class='form-control' id='tglso' name='tglso' value="<?php echo $tgl ?>" size='50' autocomplete='off' required readonly></td></tr>
						<tr><td>No. Referensi</td> <td> <input type="text" class='form-control' id='noreferensi' name='noreferensi' size='50' autocomplete='off' autofocus='autofocus'></td></tr>
						<tr><td>No. PO Customer</td> <td> <input type="text" class='form-control' id='nopo_customer' name='nopo_customer' size='50' autocomplete='off' autofocus='autofocus'></td></tr>
						<tr><td>Tgl. PO Customer</td> <td> <input type="date" class='form-control' id='tglpo_customer' name='tglpo_customer' size='50' autocomplete='off' autofocus='autofocus'></td></tr>
						<tr><td>Customer</td> <td><div class='input-group'>  <input type='text' class='form-control' id='kdcustomer' name='kdcustomer' size='50' autocomplete='off' readonly required>
						<span class='input-group-btn'>
						<button type='button' id='src' class='btn btn-primary' onclick='cari_data_customer()'>Cari</button>
						</span></td>
						<tr><td></td> <td> <input type="text" class='form-control' id='nmcustomer' name='nmcustomer' size='50' readonly required></td></tr>
						<tr><td>Jenis Order
						<td><select required id='jenis_order' name='jenis_order' class='form-control' style='width: 200x;'>
							<option value="URGENT">URGENT</option>
							<option value="NORMAL">NORMAL</option>
							<option value="LAIN">LAIN-LAIN</option>
							</select>															
						<tr><td>Biaya Lain</td> <td> <input type="text" class='form-control' name='ket_biaya_lain'></td></tr>
						<tr><td></td> <td> <input type="number" class='form-control' name='biaya_lain' id='biaya_lain' size='50' value='0' required onblur="hit_total()" onkeyup="validAngka_no_titik(this)"></td></tr>
						<tr><td>Tanggal Kirim<br>(M/D/Y)</br></td> <td> <input type="date" class='form-control' name='tglkirim' size='50'></td></tr>
					</table>
				</div>
				<div class='col-md-6'>
	        <table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
						<tr><td>Cara Bayar
						<td><select required id='carabayar' name='carabayar' class='form-control' style='width: 200x;'>
						<!--<option value=''> - PILIH CARA BAYAR - </option>";?>-->
							<option value="TUNAI">TUNAI</option>
							<option value="KARTU-KREDIT">KARTU-KREDIT</option>
							<option value="GIRO">GIRO</option>
							<option value="CEK">CEK</option>
						</select>
						<tr><td>Tempo (Hari)</td> <td> <input type="number" class='form-control' name='tempo' size='50'></td></tr>	
						<tr><td>Tanggal Jatuh Tempo<br>(M/D/Y)</br></td> <td> <input type="date" class='form-control' name='tgl_jt_tempo' size='50'></td></tr>
						<tr><td>Subtotal</td> <td> <input type="number" class='form-control' name='subtotal' id='subtotal' value='0' size='50' readonly></td></tr>
						<tr><td>Total Sementara</td> <td> <input type="number" class='form-control' id='total_sementara' name='total_sementara' size='50' value='0' readonly></td></tr>
	        	<tr><td>PPn (%)</td> <td> <input type="number" class='form-control' name='ppn' id='ppn' size='50' value='0' onkeyup="validAngka(this)" onblur="hit_total()"></td></tr>
						<tr><td>Materai</td> <td> <input type="number" class='form-control' name='materai' id='materai' size='50' value='0' onkeyup="validAngka_no_titik(this)" onblur="hit_total()"></td></tr>			
						<tr><td>Total</td> <td> <input type="number" class='form-control' name='total' id='total' size='50' value='0' readonly></td></tr>
						<tr><td>Keterangan</td><td><textarea type='text' rows='2' class='form-control' id='kerangan' name='keterangan' autocomplete='off'></textarea></td></tr>
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
			cekakses($connect,$user,'Sales Order');
			$lakses = $_SESSION['aksesedit'];
			if ($lakses == 1) {	
				// $sql=mysqli_query($connect,"select * from soh where id='$_GET[id]'");
				// $de=mysqli_fetch_assoc($sql);
				$query = $connect->prepare("select * from soh where id=?");
				$query->bind_param('i',$_GET['id']);
				$query->execute();
				$result = $query->get_result();
				$de = $result->fetch_assoc();
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
					<div class="panel panel-default">
					<div class="panel-heading"><font size="4">EDIT DATA SALES ORDER</font></div>
					<div class="panel-body">
					<form method='post' name='tbbarang' enctype='multipart/form-data' action='module/so/proses_edit.php'>
						<input type='hidden' name='username' value="<?= $user ?>">
						<input type='hidden' name='id' value="<?= $de['id'] ?>"/>
						<div class='col-md-6'>
			        <table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
							<tr><td>Nomor SO</td><td>
							<input type='text' class='form-control' id='noso' name='noso' placeholder='No. Order *' style='text-transform:uppercase' value="<?= $noso ?>" readonly></td></tr>
							<tr><td>Tgl. SO (M/D/Y)</td><td><input type='date' class='form-control' id='tglso' name='tglso' value="<?php echo $tglso ?>" size='50' autocomplete='off' required readonly></td></tr>
							<tr><td>No. Referensi</td> <td> <input type="text" class='form-control' id='noreferensi' name='noreferensi' size='50' value="<?= $noreferensi ?>" autocomplete='off' autofocus='autofocus'></td></tr>
							<tr><td>No. PO Customer</td> <td> <input type="text" class='form-control' id='nopo_customer' name='nopo_customer' value="<?= $nopo_customer ?>" size='50' autocomplete='off' autofocus='autofocus'></td></tr>
							<tr><td>Tgl. PO Customer</td> <td> <input type="date" class='form-control' id='tglpo_customer' name='tglpo_customer' value="<?= $tglpo_customer ?>" size='50' autocomplete='off' autofocus='autofocus'></td></tr>
							<tr><td>Customer</td> <td><div class='input-group'>  <input type='text' class='form-control' id='kdcustomer' name='kdcustomer' value="<?= $kdcustomer ?>" size='50' autocomplete='off' readonly required>
							<span class='input-group-btn'>
							<button type='button' id='src' class='btn btn-primary' onclick='cari_data_customer()'>Cari</button>
							</span></td>
							<tr><td></td> <td> <input type="text" class='form-control' id='nmcustomer' name='nmcustomer' value="<?= $nmcustomer ?>" size='50' readonly required></td></tr>
							<tr><td>Jenis Order
							<td><select required id='jenis_order' name='jenis_order' class='form-control' style='width: 200x;'>
							<?php
								$jenis_order=array('URGENT','NORMAL','LAIN-LAIN');
								$jml_kata=count($jenis_order);
								for($c=0; $c<$jml_kata; $c+=1){
									if ($jenis_order[$c]==$de['jenis_order']){
										echo "<option value=$jenis_order[$c] selected>$jenis_order[$c] </option>";
									}else{
										echo "<option value=$jenis_order[$c]> $jenis_order[$c] </option>";
									}
								}						
								echo "</select>";
							?>											
							<tr><td>Biaya Lain</td> <td> <input type="text" class='form-control' name='ket_biaya_lain' value='<?= $ket_biaya_lain ?>'></td></tr>
							<tr><td></td> <td> <input type="number" class='form-control' name='biaya_lain' id='biaya_lain' size='50' value='<?= $biaya_lain ?>' required onkeyup="validAngka_no_titik(this)" onblur="hit_total()"></td></tr>
		        	<tr><td>Tanggal Kirim<br>(M/D/Y)</br></td> <td> <input type="date" class='form-control' name='tglkirim' size='50' value='<?=$tglkirim?>'></td></tr>
		        	</table>
						</div>
						<div class='col-md-6'>
		 					<table style=font-size:12px; class='table table-striped table table-bordered' width='600px'>
								<tr><td>CARA BAYAR</td><td><select required name="carabayar" id="carabayar" class='form-control'>
								<?php
									$carabayar=array('TUNAI','KARTU-KREDIT','GIRO','CEK');
									$jml_kata=count($carabayar);
									for($c=0; $c<$jml_kata; $c+=1){
										if ($carabayar[$c]==$de['carabayar']){
											echo "<option value=$carabayar[$c] selected>$carabayar[$c] </option>";
										}else{
											echo "<option value=$carabayar[$c]> $carabayar[$c] </option>";
										}
									}	
									echo "</select>";
								?>
								</td></tr>
								<tr><td>Tempo (Hari)</td> <td> <input type="number" class='form-control' name='tempo' value='<?=$tempo?>' size='50'></td></tr>	
								<tr><td>Tanggal Jatuh Tempo<br>(M/D/Y)</br></td> <td> <input type="date" class='form-control' name='tgl_jt_tempo' value='<?=$tgl_jt_tempo?>' size='50'></td></tr>
								<tr><td>Subtotal</td> <td> <input type="number" class='form-control' name='subtotal' id='subtotal' size='50' value='<?= $subtotal ?>' readonly></td></tr>
								<tr><td>Total Sementara</td> <td> <input type="number" class='form-control' id='total_sementara' name='total_sementara' size='50' value='<?= $total_sementara ?>' readonly></td></tr>
								<tr><td>PPn (%)</td> <td> <input type="text" class='form-control' name='ppn' id='ppn' size='50' value='<?= $ppn ?>' onkeyup="validAngka(this)" onblur="hit_total()"></td></tr>
			 					<tr><td>Materai</td> <td> <input type="number" class='form-control' name='materai' id='materai' size='50' value='<?= $materai ?>' onkeyup="validAngka_no_titik(this)" onblur="hit_total()"></td></tr>							
			 					<tr><td>Total</td> <td> <input type="number" class='form-control' name='total' id='total' size='50' value='<?= $total ?>' readonly></td></tr>
								<tr><td>Keterangan</td><td><textarea type='text' class='form-control' id='keterangan' name='keterangan' autocomplete='off'><?= $keterangan ?></textarea></td></tr>
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

<font face="calibri">
  <div class="panel panel-info">
    <div class="panel-heading"><font size="4">SALES ORDER</font></div>
    <div class="panel-body">
	 	<form method='get'>
			<div class="row">
				<?php
					include('hal_get.php')
				?>
				<div class="col-md-4 bg">
					<input type="hidden" name="m" value="so">
					<input type='text' id='kata' name='kata' value="<?= $kata ?>" size='50px' class='form-control' placeholder='NO.SO, CUSTOMER' onkeyup='searchTable()'>
				</div>
				<button type='submit' class='btn btn-primary'>
				<span class='glyphicon glyphicon-search'></span> Cari</button>
				<a class="btn btn-danger" href="?m=so&tipe=tambah">Tambah data</a>
			</div>
		</form>
    </br>
		<div class="box-body table-responsive">
		<table id="example1" class="table table-bordered table-striped">
		<!--<table id="example1" class="table table-bordered table-striped">-->
			<tbody>
			<tr>
	    <th width='30'>No.</th>
	    <th width='80'>No. SO</th>
	    <th width='60'>Tgl. SO</th>
			<th width='80'>No. Referensi</th>
			<th>Customer</th>
	    <th width='300'>Aksi</th>
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
					$tampil = mysqli_query($connect,"SELECT * FROM soh order by noso desc LIMIT ".$limit_start.",".$limit);
					}
				else{
					$cari = $_GET['kata'];
					$tampil = mysqli_query($connect,"SELECT * FROM soh WHERE (noso like '%$cari%' or nmcustomer like '%$cari%') order by noso desc LIMIT ".$limit_start.",".$limit);
				}
				if ($page==1) {
					$posisi=0;
					$_GET['halaman']=1;
				}
				else{
					$posisi = ($_GET['page']-1) * $limit;
				}
				$no=$posisi+1;
		    while($k=mysqli_fetch_assoc($tampil)){
	       	$date = date("m/d/Y", strtotime($k['tglso']));
	       	$customer = $k['kdcustomer'].'|'.$k['nmcustomer'];
	        echo "<tr>
	        <td align='center'>$no</td>
					<td><u><a href='#' onclick =lihat_detail('$k[noso]');><font color='blue'>$k[noso]</font></a></u></td>
					<td>$date</td>
					<td>$k[noreferensi]</td>
					<td>$customer</td>
					<td align='center'>";
	        //echo "<a class='btn btn-success' href='?m=so&tipe=detail&id=$k[id]'>Upd.Dtl</a> ";
	        if ($k['proses']=='Y') {
	        	echo "<a class='btn btn-success' href='?m=so&tipe=detail_proses&noso=$k[noso]&kdcustomer=$k[kdcustomer]'>Detail</a> ";
          }else{
           		echo "<a class='btn btn-success' href='?m=so&tipe=detail&noso=$k[noso]&kdcustomer=$k[kdcustomer]'>Detail</a> ";
          }
          cekakses($connect,$user,'Sales Order');
					$lakses = $_SESSION['aksesedit'];
					if ($lakses == 1) {
	        	if ($k['proses']=='Y' or $k['batal']=='Y') {
	            	echo "<a class='btn btn-info' href='?m=so&tipe=edit&id=$k[id]' disabled>Edit</a>";
	          }else{
	            	echo "<a class='btn btn-info' href='?m=so&tipe=edit&id=$k[id]'>Edit</a>";
	          }
	        }else{
	        	echo "<a class='btn btn-info' href='?m=so&tipe=edit&id=$k[id]' disabled>Edit</a>";
	        }

	        include "tombol-tombol.php";

					$lakses = $_SESSION['aksescetak'];
					if ($lakses == 1) {
						if ($k['proses']=='N') {
							echo " <button type='button' class='btn btn-info' onClick='alert_cetak($k[id])' disabled/>
							    <span class='glyphicon glyphicon-print'></span>
							  </button>";
						}else{
							echo " <button type='button' class='btn btn-info' onClick='alert_cetak($k[id])'/>
							    <span class='glyphicon glyphicon-print'></span>
							  </button>";    									
						}
					}else{
						echo " <button type='button' class='btn btn-info' onClick='alert_cetak($k[id])' disabled/>
						    <span class='glyphicon glyphicon-print'></span>
						  </button>";
    			}    			
	        echo "</td>";
				$no++;
				}
			?>
				</tbody>
		</table>
		<?php
			if (empty($_GET['kata'])){
				$query = mysqli_query($connect,"select count(*) as jumrec from soh");
			}else{
				$cari = $_GET['kata'];
				$query = mysqli_query($connect,"select count(*) as jumrec from soh where (noso like '%$cari%' or nmcustomer like '%$cari%')");
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
			  <li><a href="dashboard.php?m=so&kata=<?= $kata ?>&page=1">First</a></li>
			  <li><a href="dashboard.php?m=so&kata=<?= $kata ?>&page=<?php echo $link_prev; ?>">&laquo;</a></li>
			<?php
			}
			?>
			<!-- LINK NUMBER -->
			<?php
			// Buat query untuk menghitung semua jumlah data
			if (empty($_GET['kata'])){
				$tampil = mysqli_query($connect,"SELECT * FROM soh order by noso desc ");
				}
			else{
				$cari = $_GET['kata'];
				$tampil = mysqli_query($connect,"SELECT * FROM soh WHERE (noso like '%$cari%' or nmcustomer like '%$cari%') order by noso desc ");
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
			  <li<?php echo $link_active; ?>><a href="dashboard.php?m=so&kata=<?= $kata ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
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
			  <li><a href="dashboard.php?m=so&kata=<?= $kata ?>&page=<?php echo $link_next; ?>">&raquo;</a></li>
			  <li><a href="dashboard.php?m=so&kata=<?= $kata ?>&page=<?php echo $jumlah_page; ?>">Last</a></li>
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
	// $(document).ready(function(){
	// 	$('#kdbarang').on('blur',function(e){
	// 		let cari = $(this).val();
	// 		$.ajax({
	// 			url: 'repl_barang.php',
	// 			type: 'post',
	// 			data: {kode_barang : cari},
	// 			success: function(response){
	// 				let data_response = JSON.parse(response);
	// 				if (!data_response){
	// 					$('#nmbarang').val('');
	// 					$('#kdsatuan').val('');					
	// 					$('#kdsatuan').val('0');
	// 					$('#qty').val('0');
	// 					cari_data_barang();
	// 					return;
	// 				}
	// 				$('#nmbarang').val(data_response['nama']);
	// 				$('#kdsatuan').val(data_response['kdsatuan']);
	// 				$('#harga').val(data_response['harga_jual']);
	// 				$('#qty').val('1');
	// 				$('#subtotal').val(data_response['harga_jual']);
	// 				//console.log(data_response['nama']);
	// 				//console.log(data_response['satuan']);
	// 			},
	// 			error:function(){
	// 				console.log('file not fount');
	// 			}
	// 		})
	// 		// console.log(cari);
	// 	})
	// })

	$(document).ready(function(){
		$('#kdbarang').on('blur',function(e){
			let cari = $(this).val()
			let cari1 = $('#kdcustomer').val()
			$.ajax({
				url: 'repl_barang.php',
				type: 'post',
				data: {'kode_barang':cari,'kode_customer':cari1},
				success: function(response){
					let data_response = JSON.parse(response);
					if (!data_response){
						$('#nmbarang').val('');
						$('#kdsatuan').val('');					
						$('#harga').val('');
						$('#qty').val('');
						cari_data_barang();
						return;
					}
					$('#nmbarang').val(data_response['nama']);
					$('#kdsatuan').val(data_response['kdsatuan']);
					$('#harga').val(data_response['harga_jual']);
					$('#qty').val('1');
					$('#subtotal').val(data_response['harga_jual']);
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

	function lihat_detail(id){
		$('#modaldetail').modal('show');
		//$('#modaldetail').find('.modal-body').html(id);
		$.ajax({
			url: './module/so/lihat_detail.php',
			type: 'post',
			data: {kode:id},
			success: function(response){
				$('#modaldetail').find('.modal-body').html(response);
			}
		});
	}


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
      	$href = "module/so/proses_hapus.php?id=";
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
          	$href = "module/so/proses_hapus_detail.php?id=";
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
    function alert_proses($id){
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
    function alert_unproses($id){
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
	function hit_subtotal() {
	var lharga = (parseInt(document.getElementById('qty').value) * parseInt(document.getElementById('harga').value));
	var ldisc = lharga - (lharga * (document.getElementById('discount').value))/100;
	var lsubtotal = ldisc;
	document.getElementById('subtotal').value = lsubtotal;
	}
</script>

<script type="text/javascript">
	function hit_total() {
	var lbiaya_lain = parseInt(document.getElementById('biaya_lain').value);
	var ltotal_sementara = (parseInt(document.getElementById('biaya_lain').value) + parseInt(document.getElementById('subtotal').value));
	var lppn = ltotal_sementara * (parseInt(document.getElementById('ppn').value)/100);
	var lmaterai = parseInt(document.getElementById('materai').value);
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
    function alert_cetak($id){
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
          	window.open($href+$id,"_blank");
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