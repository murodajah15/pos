<?php
	$user = $_SESSION['username'];
	include "autonumber.php";

  if(isset($_GET['tipe'])){
     if($_GET['tipe']=='detail_proses'){
			cekakses($connect,$user,'Kasir Penerimaan Tagihan');
			$lakses = $_SESSION['aksespakai'];
			if ($lakses == 1) {	
				$query = $connect->prepare("select * from kasir_tagihan where nokwitansi=?");
				$query->bind_param('s',$_GET['nokwitansi']);
				$query->execute();
				$result = $query->get_result();
				$de = $result->fetch_assoc();
				$nokwitansi = strip_tags($de['nokwitansi']);
				$proses = strip_tags($de['proses']);
				$tglkwitansi = strip_tags($de['tglkwitansi']);?>
				<font face='calibri'>
					<h3>DETAIL KASIR TAGIHAN</h3>
					<form method='post' enctype='multipart/form-data'>
						<input type='hidden' name='username' value='<?= $user ?>'>
 						<table class="table table-bordered table-striped table-hover">
						<tr><td>Nomor Kwitansi</td><td>
						<input type='text' class='form-control' id='nokwitansi' name='nokwitansi' placeholder='No. Kwitansi *' style='text-transform:uppercase' value="<?= $nokwitansi ?>" readonly></td>
						<td>Tgl. (M/D/Y)</td><td><input type='date' class='form-control' id='tglkwitansi' name='tglkwitansi' value="<?= $tglkwitansi ?>" size='50' autocomplete='off' readonly></td></tr>
						</table>

						<div class="table-responsive">
						<table class="table table-bordered table-striped table-hover">
						    <tr>
						    <th width='50'>No.</th>
						    <th width='80'>No. Jual</th>
						    <th>Customer</th>
								<th>Piutang</th>
								<th>Bayar</th>
						    </tr>
						<?php
							$tampil = mysqli_query($connect,"select * from kasir_tagihand where nokwitansi='$_GET[nokwitansi]'");
							$query = $connect->prepare("select * from kasir_tagihand where nokwitansi=?");
							$query->bind_param('s',$_GET['nokwitansi']);
							$query->execute();
							$result = $query->get_result();
							$de = $result->fetch_assoc();
			        $no=1;
			        //<td><u><a href='?m=wo&tipe=detail&id=$k[id]'><font color='blue'>$k[kode]</font></a></u></td>
			        //<td><u><a href='#' onclick =lihat_detail('$k[id]');><font color='blue'>$k[kdbarang]</font></a></u></td>
			        while($k=mysqli_fetch_assoc($tampil)){
			        	//$date = date("m/d/Y", strtotime($k['tglwo']));
								$nojual = strip_tags($de['nojual']);
								$customer = strip_tags($de['kdcustomer']).'|'.strip_tags($de['nmcustomer']);
								$piutang = number_format($k['piutang'],0,",",".");
								$bayar = number_format($k['bayar'],0,",",".");
		            echo "<tr><td align='center'>$no</td>
								<td width='100'>$k[nojual]</td>
								<td width='300'>$customer</td>
								<td align='right' width='80'>$piutang</td>
								<td align='right' width='100'>$bayar</td>";
								$no++;
							}
							$tampil = mysqli_query($connect,"select sum(bayar) as total_bayar from kasir_tagihand where nokwitansi='$_GET[nokwitansi]'");
							$jum = mysqli_fetch_assoc($tampil);
							$total_bayar = $jum['total_bayar'];
							$total_bayar = number_format($total_bayar,0,",",".");
							echo "<tr><td colspan='4'></td>
							<td align='right' style='font-weight:bold'>$total_bayar</td>";
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
			cekakses($connect,$user,'Kasir Penerimaan Tagihan');
			$lakses = $_SESSION['aksespakai'];
			if ($lakses == 1) {	
				$query = $connect->prepare("select * from kasir_tagihan where nokwitansi=?");
				$query->bind_param('s',$_GET['nokwitansi']);
				$query->execute();
				$result = $query->get_result();
				$de = $result->fetch_assoc();
				$nokwitansi = strip_tags($de['nokwitansi']);
				$proses = strip_tags($de['proses']);
				$tglkwitansi = strip_tags($de['tglkwitansi']);?>

				<font face='calibri'>
        <div class='panel panel-danger'>
        <div class='panel-heading'><font size="4">TAMBAH DATA DETAIL KASIR TAGIHAN</font></div>
        <div class='panel-body'>
				<form method='post' name='nokwitansi' enctype='multipart/form-data' action='module/kasir_tagihan/proses_tambah_detail.php'>
				<input type='hidden' name='username' value="<?= $user ?>">
				<div class='col-md-10'>
		      <table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
						<tr><td>Nomor SO</td><td>
						<input type='text' class='form-control' id='nokwitansi' name='nokwitansi' placeholder='No. Kwitansi *' style='text-transform:uppercase' value="<?= $nokwitansi ?>" readonly></td>
						<td>Tgl. (M/D/Y)</td><td><input type='date' class='form-control' id='tglkwitansi' name='tglkwitansi' value="<?= $tglkwitansi ?>" size='50' autocomplete='off' readonly></td></tr>
					</table>
				</div>
				<div class='col-md-12'>
					<table style=font-size:12px; class='table table-striped table table-bordered' width='600px'>
				    <tr>
				    <th>Customer <input type="button" class='btn btn-black' value="Clear" onclick="eraseText()"></th>
						<th>Customer</th>
						<th>Piutang</th>
						<th>Bayar</th>
				    <th>Aksi</th>
				    </tr>
						<td><div class='input-group'>  <input type='text' class='form-control'style="text-transform: uppercase; width: 9em;" id='nojual' name='nojual' size='50' autocomplete='off' required>
						<span class='input-group-btn'>
						<button type='button' id='src' class='btn btn-primary' onclick='cari_data_penjualan()'>
							Cari
						</button>
						</span></td>
					<input type='hidden' class='form-control' style='width: 15em' id='kdcustomer' name='kdcustomer' readonly>
						</td><td><input type='text' class='form-control' style='width: 25em' id='nmcustomer' name='nmcustomer' readonly></td>
					</td><td><input type='number' class='form-control' style='width: 15em' id='piutang' name='piutang' readonly></td>
						</td><td><input type="text" class='form-control' id='bayar' name='bayar' style='width: 15em' required onkeyup="validAngka_no_titik(this)" onblur="hit_subtotal()"></td>
			      <td align='center' width='50px'>
		      <button type='submit' class='btn btn-primary'>+</button>
					</table>

				</div>

				<div class='col-md-12'>
					<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
				    <tr>
			    	<th width='50'>No.</th>
		        <th width='170'>No. Jual</th>
		        <th>Customer</th>
						<th width='70'>Piutang</th>
						<th width='70'>Bayar</th>
						<th>Aksi</th>
				    </tr>
						<?php
							$tampil = mysqli_query($connect,"select * from kasir_tagihand where nokwitansi='$_GET[nokwitansi]'");
							$query = $connect->prepare("select * from kasir_tagihand where nokwitansi=?");
							$query->bind_param('s',$_GET['nokwitansi']);
							$query->execute();
							$result = $query->get_result();
							$de = $result->fetch_assoc();
			        $no=1;
			        //<td><u><a href='?m=wo&tipe=detail&id=$k[id]'><font color='blue'>$k[kode]</font></a></u></td>
			        //<td><u><a href='#' onclick =lihat_detail('$k[id]');><font color='blue'>$k[kdbarang]</font></a></u></td>
			        while($k=mysqli_fetch_assoc($tampil)){
								$nojual = strip_tags($k['nojual']);
								$customer = strip_tags($k['kdcustomer']).'|'.strip_tags($k['nmcustomer']);
								$piutang = number_format($k['piutang'],0,",",".");
								$bayar = number_format($k['bayar'],0,",",".");
								//$date = date("m/d/Y", strtotime($k['tglwo']));
		            echo "<tr><td align='center'>$no</td>
								<td width='90'>$k[nojual]</td>
								<td width='250'>$customer</td>
								<td align='right' width='80'>$piutang</td>
								<td align='right' width='80'>$bayar</td>
								<td align='center' width='145px'>";
		            echo "<a class='btn btn-primary' href='?m=kasir_tagihan&tipe=edit_detail&id=$k[id]&nokwitansi=$k[nokwitansi]'>Edit</a> ";
		            echo " <input button type='Button' class='btn btn-danger' value='Hapus' onClick='alert_hapus_detail($k[id])'/>";
								$no++;
							}
							$tampil = mysqli_query($connect,"select sum(bayar) as total_bayar from kasir_tagihand where nokwitansi='$_GET[nokwitansi]'");
							$jum = mysqli_fetch_assoc($tampil);
							$total_bayar = $jum['total_bayar'];
							$total_bayar = number_format($total_bayar,0,",",".");
							echo "<tr><td colspan='4'></td>
							<td align='right' style='font-weight:bold'>$total_bayar</td>";
							?>
							</table>
						</div>
						<div class='col-md-12'>
							<!--<input button type='Button' class='btn btn-danger' value='Close' onClick='history.back()'/>-->
							<input button type='Button' class='btn btn-danger' value='Close' onClick="window.location = 'dashboard.php?m=kasir_tagihan'"/>

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
			cekakses($connect,$user,'EDIT DETAIL KASIR TAGIHAN');
			$lakses = $_SESSION['aksespakai'];
			if ($lakses == 1) {	
				$query = $connect->prepare("select * from kasir_tagihan where nokwitansi=?");
				$query->bind_param('s',$_GET['nokwitansi']);
				$query->execute();
				$result = $query->get_result();
				$de = $result->fetch_assoc();
				$nokwitansi = strip_tags($de['nokwitansi']);
				$tglkwitansi = strip_tags($de['tglkwitansi']);?>

        <font face='calibri'>
	        <div class='panel panel-default'>
	        <div class='panel-heading'><font size="4">EDIT DETAIL DATA KASIR TAGIHAN</font></div>
	        <div class='panel-body'>
					<form method='post' name='so' enctype='multipart/form-data' action='module/kasir_tagihan/proses_edit_detail.php'>
					<input type='hidden' name='username' value="<?= $user ?>">
					<div class='col-md-12'>
					<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
				<!--<font face='calibri'>
					<h3>Edit Detail SALES ORDER</h3>
					<form method='post' enctype='multipart/form-data' action='module/so/proses_edit_detail.php'>
						<input type='hidden' name='username' value='<?= $user ?>'>
 						<table class="table table-bordered table-striped table-hover">-->
						<tr><td>Nomor Order</td><td>
						<input type='text' class='form-control' id='nokwitansi' name='nokwitansi' placeholder='No. KWITANSI *' style='text-transform:uppercase' value="<?= $nokwitansi ?>" readonly></td>
						<td>Tgl. (M/D/Y)</td><td><input type='date' class='form-control' id='tglkwitansi' name='tglkwitansi' value="<?= $tglkwitansi ?>" size='50' autocomplete='off' readonly></td></tr>
					</table>
					</div>

					<div class='col-md-12'>
					<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
					    <tr>
					    <th width='80'>Customer <input type="button" class='btn btn-black' value="Clear" onclick="eraseText()"></th>
							<th width='250'>Customer</th>
							<th width 80>Piutang</th>
							<th width 80>Bayar</th>
					    </tr>
					    <?php
							$query = $connect->prepare("select * from kasir_tagihand where id=?");
							$query->bind_param('s',$_GET['id']);
							$query->execute();
							$result = $query->get_result();
							$de = $result->fetch_assoc();
							$nojual = strip_tags($de['nojual']);
							$nmcustomer = strip_tags($de['nmcustomer']);
							$bayar = $de['bayar'];
							//$bayar = number_format($de['bayar'],0,",",".");
							//$bayar = str_replace(",",".",$bayar); 
							$piutang = number_format($de['piutang'],0,",",".");
						?>
						<input type='hidden' name='id' value='<?= $de['id'] ?>'>
						<input type='hidden' name='nokwitansi' value='<?= $de['nokwitansi'] ?>'>
						<td><div class='input-group'>  <input type='text' class='form-control' style='width: 10em' id='nojual' name='nojual' value='<?= $nojual ?>' size='50' autocomplete='off' required readonly>
							<span class='input-group-btn'>
							<!--<button type='button' id='src' class='btn btn-primary' onclick='cari_data_barang()'>
								Cari
							</button>-->
						</span></td>
						</td><td><input type='text' class='form-control' id='nmcustomer' name='nmcustomer' value='<?= $nmcustomer ?>' readonly></td>
					</td><td align="right"><input type="text" class='form-control' id='piutang' name='piutang' value='<?= $piutang ?>' style='width: 8em' readonly></td>
						</td><td align="right"><input type="text" class='form-control' id='bayar' name='bayar' value='<?= $bayar ?>' style='width: 8em' required onkeyup="validAngka_no_titik(this)" autofocus='autofocus'></td>
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
			cekakses($connect,$user,'Kasir Penerimaan Tagihan');
			$lakses = $_SESSION['aksestambah'];
			date_default_timezone_set("Asia/Jakarta");  
			$de=mysqli_fetch_assoc(mysqli_query($connect,"select * from saplikasi where aktif='Y'"));
			$tgl = $de['tgl_berikutnya']; //date('Y-m-d')
			$year = date('Y');
			$month = date('M');
			if ($lakses == 1) {?>
		    <font face='calibri'>
        <div class='panel panel-danger'>
        <div class='panel-heading'><font size="4">TAMBAH DATA KASIR PENERIMAAN TAGIHAN</font></div>
        <div class='panel-body'>
				<form method='post' name='po' enctype='multipart/form-data' action='module/kasir_tagihan/proses_tambah.php'>
				<input type='hidden' name='username' value="<?= $user ?>">
				<div class='col-md-6'>
		      <table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
						<tr><td>Nomor Kwitansi</td><td>
						<input type='text' class='form-control' id='nokwitansi' name='nokwitansi' placeholder='No. Order *' style='text-transform:uppercase;text-align:left' value="<?php echo autoNumberKWT($connect,'id','kasir_tagihan');?>" readonly></td></tr>
						<tr><td>Tgl. (M/D/Y)</td><td><input type='date' class='form-control' id='tglkwitansi' name='tglkwitansi' value="<?php echo $tgl ?>" size='50' autocomplete='off' required></td></tr>
						<tr><td>Jenis Kwitansi
						<td><select required id='jnskwitansi' name='jnskwitansi' class='form-control' style='width: 200x;' onchange='changeValueDriver(this.value)'>
						<!--<option value=''> - PILIH JENIS KWITANSI - </option>";?>-->
							<option value="UANG-MUKA">UANG-MUKA</option>
							<option value="PELUNASAN">PELUNASAN</option>
							</select>		
						<tr><td>Pembayar</td> <td> <input type="text" class='form-control' id='nmcustomer' name='nmcustomer' size='50'  required></td></tr>													
						<!--<tr><td>No. Penjualan</td> <td><div class='input-group'>  <input type='text' class='form-control' id='nojual' name='nojual' size='50' autocomplete='off' readonly required>
							<span class='input-group-btn'>
							<button type='button' id='src' class='btn btn-primary' onclick='cari_data_penjualan()'>
								Cari
							</button>
						</span></td>
						<tr><td>Customer</td> <td> <input type="text" class='form-control' id='nmcustomer' name='nmcustomer' size='50' readonly required></td></tr>
						<input type="hidden" class='form-control' id='kdcustomer' name='kdcustomer' size='50' readonly required>
						<input type="hidden" class='form-control' id='total' name='total' size='50' readonly required>
						<tr><td>Nilai Piutang</td> <td align='right'> <input type="number" class='form-control' id='piutang' name='piutang' value ='0' size='50' style='text-align:right' readonly required></td></tr>
						<tr><td>Nilai Bayar</td> <td align='right'> <input type="number" class='form-control' id='bayar' name='bayar' value='0' size='50' style='text-align:right' onkeyup="hit_subtotal()" onblur="hit_subtotal()" required></td></tr>
						<tr><td>Uang diterima </td> <td> <input type="number" class='form-control' id='uang' name='uang' value='0' size='65' style='text-align:right' onkeyup="hit_subtotal()" onblur="hit_subtotal()" required></td>
						<tr><td>Kembali </td> <td> <input type="number" class='form-control' id='kembali' name='kembali' value='0' size='35' style='text-align:right' readonly required></td>-->
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
						<tr><td>Bank</td> <td><div class='input-group'>  <input type='text' class='form-control' name='kdbank' id='kdbank' size='20' autocomplete='off' readonly required>
							<span class='input-group-btn'>
							<button type='button' id='src' class='btn btn-primary' onclick='cari_data_bank()'>Cari
							</button>
						</span></td>
						<td> <input type="text" class='form-control' name='nmbank' id='nmbank' size='50' readonly required></td></tr>
						<tr><td>Jenis Kartu</td> <td><div class='input-group'>  <input type='text' class='form-control' name='kdjnskartu' id='kdjnskartu' size='20' autocomplete='off' readonly required>
							<span class='input-group-btn'>
							<button type='button' id='src' class='btn btn-primary' onclick='cari_data_jnskartu()'>Cari
							</button>
						</span></td>
						<td> <input type="text" class='form-control' name='nmjnskartu' id='nmjnskartu' size='50' readonly required></td></tr>
						</table>
						<table style=font-size:13px; class='table table-responsive'>
 						<tr><td>No. Rekening</td> <td> <input type="text" class='form-control' id='norek' name='norek' size='50'></td></tr>
 						<tr><td>No. Giro/Cek</td> <td> <input type="text" class='form-control' id='nocekgiro' name='nocekgiro' size='50'></td></tr>
						<tr><td>Tgl. Terima Cek (M/D/Y)</td><td><input type='date' class='form-control' id='tglterimacekgiro' name='tglterimacekgiro' value="<?php echo $tglterimacekgiro ?>" size='50' autocomplete='off'></td></tr>
						<tr><td>Tgl. Jt.Tempo Cek (M/D/Y)</td><td><input type='date' class='form-control' id='tgljttempocekgiro' name='tgljttempocekgiro' value="<?php echo $tgljttempocekgiro ?>" size='50' autocomplete='off'></td></tr>
						<tr><td>Keterangan</td><td><textarea type='text' class='form-control' id='kerangan' name='keterangan' autocomplete='off'></textarea></td></tr>
					</table>
				</div>
				<div class='col-md-12' style='margin-left:-5px'>
					<label>&nbsp;</label>
					<button type='submit' class='btn btn-primary'>Simpan</button>
					<input button type='Button' class='btn btn-danger' value='Batal' onClick='history.back()'/>
				</div>
			</div></div></form></font>
			<?php
		}else{
			echo "<script>alert('Anda tidak berhak !');history.go(-1) </script>";
		}

    }elseif($_GET['tipe']=='edit'){
			cekakses($connect,$user,'Kasir Penerimaan Tagihan');
			$lakses = $_SESSION['aksesedit'];
			if ($lakses == 1) {	
				// $sql=mysqli_query($connect,"select * FROM kasir_tagihan where id='$_GET[id]'");
				// $de=mysqli_fetch_assoc($sql);
				$query = $connect->prepare("select * from kasir_tagihan where id=?");
				$query->bind_param('i',$_GET['id']);
				$query->execute();
				$result = $query->get_result();
				$de = $result->fetch_assoc();
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
				$subtotal = $de['subtotal'];
				$total = $de['total'];
				?>
				<font face='calibri'>
					<div class="panel panel-default">
					<div class="panel-heading"><font size="4">EDIT DATA KASIR PENERIMAAN TAGIHAN</font></div>
					<div class="panel-body">
					<form method='post' name='beli' enctype='multipart/form-data' action='module/kasir_tagihan/proses_edit.php'>
						<input type='hidden' name='username' value="<?= $user ?>">
						<input type='hidden' name='id' value="<?= $de['id'] ?>"/>
						<div class='col-md-6'>
			        <table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
							<tr><td>Nomor Kwitansi</td><td>
							<input type='text' class='form-control' id='nokwitansi' name='nokwitansi' placeholder='No. Order *' style='text-transform:uppercase;text-align:left' value="<?= $nokwitansi ?>" readonly></td></tr>
							<tr><td>Tgl. (M/D/Y)</td><td><input type='date' class='form-control' id='tglkwitansi' name='tglkwitansi' value="<?php echo $tglkwitansi ?>" size='50' autocomplete='off' required></td></tr>
							<tr><td>JENIS KWITANSI</td><td><select required name="jnskwitansi" id="jnskwitansi" class='form-control'>
							<?php
								$jnskwitansi=array('UANG-MUKA','PELUNASAN');
								$jml_kata=count($jnskwitansi);
								for($c=0; $c<$jml_kata; $c+=1){
									if ($jnskwitansi[$c]==$de['jnskwitansi']){
										echo "<option value=$jnskwitansi[$c] selected>$jnskwitansi[$c] </option>";
									}else{
										echo "<option value=$jnskwitansi[$c]> $jnskwitansi[$c] </option>";
									}
								}						
								echo "</select>";
							?>
							<tr><td>Pembayar</td> <td> <input type="text" class='form-control' id='nmcustomer' name='nmcustomer' value="<?= $nmcustomer ?>" size='50' required></td></tr>													

							<!--<tr><td>No. Penjualan</td> <td><div class='input-group'>  <input type='text' class='form-control' id='nojual' name='nojual' size='50' value="<?= $nojual ?>" autocomplete='off' readonly required>
							<span class='input-group-btn'>
								<button type='button' id='src' class='btn btn-primary' onclick='cari_data_wo()'>Cari</button>
							</span></td>
							<tr><td>Customer</td> <td> <input type="text" class='form-control' id='nmcustomer' name='nmcustomer' size='50' value="<?= $nmcustomer ?>" readonly required></td></tr>
							<input type="hidden" class='form-control' id='kdcustomer' name='kdcustomer' size='50' value="<?= $kdcustomer ?>" readonly required>
							<tr><td>Materai</td> <td align='right'> <input type="number" class='form-control' id='materai' name='materai' size='50' value="<?= $materai ?>" style='text-align:right' onkeyup="hit_subtotal()" onblur="hit_subtotal()" required></td></tr>
							<tr><td>Nilai Bayar</td> <td align='right'> <input type="number" class='form-control' id='subtotal' name='subtotal' size='50' value="<?= $subtotal ?>" style='text-align:right' onkeyup="hit_subtotal()" onblur="hit_subtotal()" required readonly></td></tr>
							<tr><td>Total </td> <td> <input type="number" class='form-control' id='total' name='total' size='65' value="<?= $total ?>" style='text-align:right' onkeyup="hit_subtotal()" onblur="hit_subtotal()" required redonly></td>-->
							</table>
							</div>
  						<div class='col-md-6'>
			        <table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
 							<td>Cara Bayar
        					<td><input type="radio" name="carabayar" value="Cash" <?php echo ($carabayar=='Cash')?'checked':''?>> Cash
        					<td><input type="radio" name="carabayar" value="Transfer" <?php echo ($carabayar=='Transfer')?'checked':''?>> Transfer
        					<td><input type="radio" name="carabayar" value="Cek/Giro" <?php echo ($carabayar=='Cek/Giro')?'checked':''?>> Cek/Giro
        					<td><input type="radio" name="carabayar" value="Debit Card" <?php echo ($carabayar=='Debit Card')?'checked':''?>> Debit Card
        					<td><input type="radio" name="carabayar" value="Credit Card" <?php echo ($carabayar=='Credit Card')?'checked':''?>> Credit Card
        					</table>
							<table style=font-size:13px; class='table table-responsive'>
							<tr><td>Bank</td> <td><div class='input-group'>  <input type='text' class='form-control' id='kdbank' name='kdbank' size='20' autocomplete='off' value="<?= $kdbank ?>" readonly required>
								<span class='input-group-btn'>
								<button type='button' id='src' class='btn btn-primary' onclick='cari_data_bank()'>
									Cari
								</button>
							</span></td>
							<td> <input type="text" class='form-control' id='nmbank' name='nmbank' size='50' value="<?= $nmbank ?>" readonly required></td></tr>
							<tr><td>Jenis Kartu</td> <td><div class='input-group'>  <input type='text' class='form-control' id='kdjnskartu' name='kdjnskartu' size='20'  value="<?= $kdjnskartu ?>" autocomplete='off' readonly required>
								<span class='input-group-btn'>
								<button type='button' id='src' class='btn btn-primary' onclick='cari_data_jnskartu()'>
									Cari
								</button>
							</span></td>
							<td> <input type="text" class='form-control' id='nmjnskartu' name='nmjnskartu' size='50' value="<?= $nmjnskartu ?>" readonly required></td></tr>
							</table>
							<table style=font-size:13px; class='table table-responsive'>
	 						<tr><td>No. Rekening</td> <td> <input type="text" class='form-control' id='norek' name='norek' size='50' value="<?= $norek ?>"></td></tr>
	 						<tr><td>No. Giro/Cek</td> <td> <input type="text" class='form-control' id='nocekgiro' name='nocekgiro' size='50' value="<?= $nocekgiro ?>"></td></tr>
							<tr><td>Tgl. Terima Cek (M/D/Y)</td><td><input type='date' class='form-control' id='tglterimacekgiro' name='tglterimacekgiro' value="<?php echo $tglterimacekgiro ?>" size='50' autocomplete='off'></td></tr>
							<tr><td>Tgl. Jt.Tempo Cek (M/D/Y)</td><td><input type='date' class='form-control' id='tgljttempocekgiro' name='tgljttempocekgiro' value="<?php echo $tgljttempocekgiro ?>" size='50' autocomplete='off'></td></tr>
							<tr><td>Keterangan</td><td><textarea type='text' class='form-control' id='kerangan' name='keterangan' autocomplete='off'><?= $keterangan ?></textarea></td></tr>
							</table>
							</div>
						<div class='col-md-12' style='margin-left:-5px'>
						<label>&nbsp;</label>
						<button type='submit' class='btn btn-primary'>Simpan</button>
						<input button type='Button' class='btn btn-danger' value='Batal' onClick='history.back()'/>
						</div>
					</div></div>
				</form>
			</font>
			<?php
			}else{
				echo "<script>alert('Anda tidak berhak !');history.go(-1) </script>";
			}		
        }
		/*<tr><td>Picture</td> <td>  <input type='file' class='form-control' name='picture' size='100' value='$de[picture]'></td></tr>**/
    }else{
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
    <div class="panel-heading"><font size="4">KASIR PENERIMAAN TAGIHAN</font></div>
    <div class="panel-body">
 		<form method='get'>
			<div class="row">
				<?php
					include('hal_get.php')
				?>
				<div class="col-md-4 bg">
					<input type="hidden" name="m" value="kasir_tagihan">
					<input type='text' id='kata' name='kata' value="<?= $kata ?>" size='50px' class='form-control' placeholder='NO.KWITANSI, CUSTOMER, NO.JUAL' onkeyup='searchTable()'>
				</div>
				<button type='submit' class='btn btn-primary'>
				<span class='glyphicon glyphicon-search'></span> Cari</button>
				<a class="btn btn-danger" href="?m=kasir_tagihan&tipe=tambah">Tambah data</a>
			</div>
		</form>
		</br>
	<div class="box-body table-responsive">
	<table id="example1" class="table table-bordered table-striped">
		<tbody>
    <tr>
    <th width='30'>No.</th>
    <th width='80'>No. Kwitansi</th>
    <th width='60'>Tanggal</th>
	<th width='60'>Cara Bayar</th>
	<th width='80'>Pembayaran</th>
    <th width='350'>Aksi</th>
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
				$tampil = mysqli_query($connect,"SELECT * FROM kasir_tagihan order by nokwitansi desc LIMIT ".$limit_start.",".$limit);
				}
			else{
				$cari = $_GET['kata'];
				$tampil = mysqli_query($connect,"SELECT * FROM kasir_tagihan WHERE (nokwitansi like '%$cari%' or nmcustomer like '%$cari%' or nojual like '%$cari%') order by nokwitansi desc LIMIT ".$limit_start.",".$limit);
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
       	$date = date("m/d/Y", strtotime($k['tglkwitansi']));
       	$total = number_format($k['total'],0,",",".");
        echo "<tr>
        <td align='center'>$no</td>
				<td><u><a href='#' onclick =lihat_detail('$k[nokwitansi]');><font color='blue'>$k[nokwitansi]</font></a></u></td>
				<td>$date</td>
				<td>$k[carabayar]</td>
				<td align='right'>$total</td>
				<td align='center'>";    
        //echo "<a class='btn btn-success' href='?m=kasir_tagihan&tipe=detail&id=$k[id]'>Upd.Dtl</a> ";
        cekakses($connect,$user,'Kasir Penerimaan Tagihan');
				$lakses = $_SESSION['aksesedit'];
        if ($k['proses']=='Y') { 
        	echo "<a class='btn btn-success' href='?m=kasir_tagihan&tipe=detail_proses&nokwitansi=$k[nokwitansi]'>Detail</a> ";
        }else{
        		if (isset($_GET['kata']) and isset($_GET['page'])) {
        			echo "<a class='btn btn-success' href='?m=kasir_tagihan&tipe=detail&nokwitansi=$k[nokwitansi]&kata=$_GET[kata]&page=$_GET[page]'>Detail</a> ";
        		}
        		if (isset($_GET['kata']) and !isset($_GET['page'])) {
        			echo "<a class='btn btn-success' href='?m=kasir_tagihan&tipe=detail&nokwitansi=$k[nokwitansi]&kata=$_GET[kata]'>Detail</a> ";
        		}
        		if (!isset($_GET['kata']) and isset($_GET['page'])) {
        			echo "<a class='btn btn-success' href='?m=kasir_tagihan&tipe=detail&nokwitansi=$k[nokwitansi]&page=$_GET[page]'>Detail</a> ";
        		}
        		if (!isset($_GET['kata']) and !isset($_GET['page'])) { 
        			echo "<a class='btn btn-success' href='?m=kasir_tagihan&tipe=detail&nokwitansi=$k[nokwitansi]'>Detail</a> ";
        		}
         		//echo "<a class='btn btn-success' href='?m=jual&tipe=detail&nojual=$k[nojual]'>Detail</a> ";
        }
				
				if ($lakses == 1) {
	      	if ($k['proses']=='Y') {
	          	echo "<a class='btn btn-info' href='?m=kasir_tagihan&tipe=edit&id=$k[id]' disabled>Edit</a>";
	        }else{
	          	echo "<a class='btn btn-info' href='?m=kasir_tagihan&tipe=edit&id=$k[id]'>Edit</a>";
	        }
	      }else{
	      	echo "<a class='btn btn-info' href='?m=kasir_tagihan&tipe=edit&id=$k[id]' disabled>Edit</a>";
	      }

				include 'tombol-tombol.php';

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
				$query = mysqli_query($connect,"select count(*) as jumrec from kasir_tagihan");
			}else{
				$cari = $_GET['kata'];
				$query = mysqli_query($connect,"select count(*) as jumrec from kasir_tagihan where (nokwitansi like '%$cari%' or nmcustomer like '%$cari%')");
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
			  <li><a href="dashboard.php?m=kasir_tagihan&kata=<?= $kata ?>&page=1">First</a></li>
			  <li><a href="dashboard.php?m=kasir_tagihan&kata=<?= $kata ?>&page=<?php echo $link_prev; ?>">&laquo;</a></li>
			<?php
			}
			?>
			<!-- LINK NUMBER -->
			<?php
			// Buat query untuk menghitung semua jumlah data
			if (empty($_GET['kata'])){
				$tampil = mysqli_query($connect,"SELECT * FROM kasir_tagihan order by nokwitansi desc ");
				}
			else{
				$cari = $_GET['kata'];
				$tampil = mysqli_query($connect,"SELECT * FROM kasir_tagihan WHERE (nokwitansi like '%$cari%' or nmcustomer like '%$cari%' or nojual like '%$cari%') order by nokwitansi desc ");
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
			  <li<?php echo $link_active; ?>><a href="dashboard.php?m=kasir_tagihan&kata=<?= $kata ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
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
			  <li><a href="dashboard.php?m=kasir_tagihan&kata=<?= $kata ?>&page=<?php echo $link_next; ?>">&raquo;</a></li>
			  <li><a href="dashboard.php?m=kasir_tagihan&kata=<?= $kata ?>&page=<?php echo $jumlah_page; ?>">Last</a></li>
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

<script src="js/jquery.min.js" type="text/javascript"></script>

<script type="text/javascript"> 
	$(document).ready(function(){
		$('#nojual').on('blur',function(e){
			let cari = $(this).val();
			$.ajax({
				url: 'repl_penjualan.php',
				type: 'post',
				data: {nojual : cari},
				success: function(response){
					let data_response = JSON.parse(response);
					if (!data_response){
						$('#kdcustomer').val('');
						$('#nmcustomer').val('');
						$('#piutang').val('');					
						$('#bayar').val('0');
						cari_data_penjualan();
						return;
					}
					$('#kdcustomer').val(data_response['kdcustomer']);
					$('#nmcustomer').val(data_response['nmcustomer']);
					$('#piutang').val(data_response['kurangbayar']);
					$('#bayar').val(data_response['kurangbayar']);
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
<script type="text/javascript"> 
	function lihat_detail(id){
		$('#modaldetail').modal('show');
		//$('#modaldetail').find('.modal-body').html(id);
		$.ajax({
			url: './module/kasir_tagihan/lihat_detail.php',
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
          	$href = "module/kasir_tagihan/proses_hapus.php?id=";
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
          	$href = "module/kasir_tagihan/proses_hapus_detail.php?id=";
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
          	$href = "module/kasir_tagihan/proses.php?id=";
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
          	$href = "module/kasir_tagihan/batal_proses.php?id=";
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
	var ltotal = (parseInt(document.getElementById('subtotal').value) - parseInt(document.getElementById('materai').value));
	document.getElementById('total').value = ltotal;
	}
</script>

<script type="text/javascript">
	function lihat_detail(id){
		$('#modaldetail').modal('show');
		//$('#modaldetail').find('.modal-body').html(id);
		$.ajax({
			url: './module/kasir_tagihan/lihat_detail.php',
			type: 'post',
			data: {kode:id},
			success: function(response){
				$('#modaldetail').find('.modal-body').html(response);
			}
		});
	}

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
        	$href = "module/kasir_tagihan/cetak.php?id=";
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

  function eraseText() {
    document.getElementById("nojual").value = "";
    document.getElementById("kdcustomer").value = "";
    document.getElementById("nmcustomer").value = "";
    document.getElementById("piutang").value = "";
    document.getElementById("bayar").value = "";
	}

</script>