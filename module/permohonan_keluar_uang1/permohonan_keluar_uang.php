<?php
	$user = $_SESSION['username'];
	include "autonumber.php";

  if(isset($_GET['tipe'])){
     if($_GET['tipe']=='detail_proses'){
			cekakses($connect,$user,'Permohonan Keluar Uang');
			$lakses = $_SESSION['aksespakai'];
			if ($lakses == 1) {	
				$query = $connect->prepare("select * from mohklruangh where nomohon=?");
				$query->bind_param('s',$_GET['nomohon']);
				$query->execute();
				$result = $query->get_result();
				$de = $result->fetch_assoc();
				$nomohon = strip_tags($de['nomohon']);
				$proses = strip_tags($de['proses']);
				$tglmohon = strip_tags($de['tglmohon']);?>
				<font face='calibri'>
        <div class='panel panel-danger'>
        <div class='panel-heading'><font size="4">DETAIL PERMOHONAN KELUAR UANG</font></div>
        <div class='panel-body'>
				<form method='post' name='permohonan_keluar_uang' enctype='multipart/form-data' action='module/permohonan_keluar_uang/proses_tambah_detail.php'>
				<input type='hidden' name='username' value="<?= $user ?>">
				<div class='col-md-12'>
					<table class="table table-bordered table-striped table-hover">
		      <!--<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>-->
						<tr><td>Nomor Permohonan</td><td>
						<input type='text' class='form-control' id='nomohon' name='nomohon' placeholder='No. PO *' style='text-transform:uppercase' value="<?= $nomohon ?>" readonly></td>
						<td>Tgl. (M/D/Y)</td><td><input type='date' class='form-control' id='tglmohon' name='tglmohon' value="<?= $tglmohon ?>" size='50' autocomplete='off' readonly></td></tr>
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
							$tampil = mysqli_query($connect,"select * from mohklruangd where nomohon='$_GET[nomohon]'");
							$query = $connect->prepare("select * from mohklruangd where nomohon=?");
							$query->bind_param('s',$_GET['nomohon']);
							$query->execute();
							$result = $query->get_result();
							$de = $result->fetch_assoc();
			        $no=1;
			        //<td><u><a href='?m=wo&tipe=detail&id=$k[id]'><font color='blue'>$k[kode]</font></a></u></td>
			        //<td><u><a href='#' onclick =lihat_detail('$k[id]');><font color='blue'>$k[kdbarang]</font></a></u></td>
			        while($k=mysqli_fetch_assoc($tampil)){
				        	//$date = date("m/d/Y", strtotime($k['tglwo']));
								$nodokumen = strip_tags($k['nodokumen']);
								$tgldokumen = strip_tags($k['tgldokumen']);
								$kdsupplier = strip_tags($k['kdsupplier']);
								$nmsupplier = strip_tags($k['nmsupplier']);
			        	$uang = number_format($k['uang'],0,",",".");
			        	$supplier = $kdsupplier.'|'.$nmsupplier;
								echo "<tr><td align='center'>$no</td>
								<td width='20'>$k[nodokumen]</td>
								<td width='30'>$k[tgldokumen]</td>
								<td width='150'>$supplier</td>
								<td width='200'>$k[user]</td>
								<td align='right' width='70'>$uang</td>";
								$no++;
							}
							$tampil = mysqli_query($connect,"select sum(uang) as total_subtotal from mohklruangd where nomohon='$_GET[nomohon]'");
							$jum = mysqli_fetch_assoc($tampil);
							$total = $jum['total_subtotal'];
							$total = number_format($total,0,",",".");
							echo "<tr><td colspan='5' align='right'></td>
							<td align='right' style='font-weight:bold'>$total</td>";
							?>
							</table>
						</div>
					<div class='col-md-12'>
			      <table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
						<input button type='Button' class='btn btn-danger' value='Close' onClick='history.back()'/>
					</table></div></div></div>
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
			cekakses($connect,$user,'Permohonan Keluar Uang');
			$lakses = $_SESSION['aksespakai'];
			if ($lakses == 1) {	
				$query = $connect->prepare("select * from mohklruangh where nomohon=?");
				$query->bind_param('s',$_GET['nomohon']);
				$query->execute();
				$result = $query->get_result();
				$de = $result->fetch_assoc();
				$nomohon = strip_tags($de['nomohon']);
				$proses = strip_tags($de['proses']);
				$tglmohon = strip_tags($de['tglmohon']);
				$kdjnkeluar = strip_tags($de['kdjnkeluar']);
				$jnkeluar = strip_tags($de['kdjnkeluar']).'|'.strip_tags($de['nmjnkeluar']);?>

				<font face='calibri'>
        <div class='panel panel-danger'>
        <div class='panel-heading'><font size="4">TAMBAH DATA DETAIL PERMOHONAN KELUAR UANG</font></div>
        <div class='panel-body'>
				<form method='post' name='po' enctype='multipart/form-data' action='module/permohonan_keluar_uang/proses_tambah_detail.php'>
				<input type='hidden' name='username' value="<?= $user ?>">
				<input type='hidden' name='tglmohon' value="<?= $tglmohon ?>">
				<div class='col-md-10'>
		      <table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
						<tr><td>Nomor Permohonnan</td><td>
						<input type='text' class='form-control' id='nomohon' name='nomohon' placeholder='No. Permohonan *' style='text-transform:uppercase' value="<?= $nomohon ?>" readonly></td>
						<td>Tgl. (M/D/Y)</td><td><input type='date' class='form-control' id='tglmohon' name='tglmohon' value="<?= $tglmohon ?>" size='50' autocomplete='off' readonly></td>
						<td>Jenis</td><td><input type='text' class='form-control' id='jnkeluar' name='jnkeluar' value="<?= $jnkeluar ?>" size='50' autocomplete='off' readonly></td></tr>
					</table>
				</div>
				<?php if ($kdjnkeluar<>'K-LL') {?>
					<div class='col-md-12'>
						<table style=font-size:12px; class='table table-striped table table-bordered' width='600px'>
					    <tr>
					    <th>No. Dokumen <input type="button" class='btn btn-black' value="Clear" onclick="eraseText()"></th>
							<th>Supplier</th>
							<th>Keterangan</th>
							<th>Bayar</th>
					    <th>Aksi</th>
					    </tr>
							<td><div class='input-group'>  <input type='text' class='form-control' style='width: 10em' id='nodokumen' name='nodokumen' size='50' autocomplete='off'>
							<span class='input-group-btn'>
							<?php
							if ($kdjnkeluar=='K-BE'){
								?>
									<button type='button' id='src' class='btn btn-primary' onclick='cari_data_hutang()'>
										Cari
									</button>
									</span></td>
								<?php
								}else{
								?>
									<button type='button' id='src' class='btn btn-primary' onclick='cari_data_kembali()'>
										Cari
									</button>
									</span></td>
								<?php
								}
							?>
							<input type='hidden' class='form-control' style='width: 6em' id='tgldokumen' name='tgldokumen' readonly>
							<input type='hidden' class='form-control' style='width: 6em' id='kdsupplier' name='kdsupplier' readonly>
							</td><td><input type='text' class='form-control' style='width: 15em' id='nmsupplier' name='nmsupplier' readonly></td>
						</td><td><input type='text' class='form-control' style='width: 20em' id='keterangan' name='keterangan'></td>						
							<input type="hidden" class='form-control' id='total' name='total' style='width: 8em' required readonly>
							</td><td><input type="number" class='form-control' id='uang' name='uang' style='width: 8em' onkeyup="validAngka_no_titik(this)"" onblur="hit_subtotal()"></td>
				      <td align='center' width='50px'>
				      <button type='submit' class='btn btn-primary'>+</button>
						</table>
					</div>

					<div class='col-md-12'>
						<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
					    <tr>
				    	<th width='50'>No.</th>
			        <th width='100'>No. Dokumen</th>
			        <th>Tanggal</th>
			        <th>Supplier</th>
							<th>Jumlah</th>
							<th>Aksi</th>
					    </tr>
							<?php
								$tampil = mysqli_query($connect,"select * from mohklruangd where nomohon='$_GET[nomohon]'");
								$query = $connect->prepare("select * from mohklruangd where nomohon=?");
								$query->bind_param('s',$_GET['nomohon']);
								$query->execute();
								$result = $query->get_result();
								$de = $result->fetch_assoc();
				        $no=1;
				        //<td><u><a href='?m=wo&tipe=detail&id=$k[id]'><font color='blue'>$k[kode]</font></a></u></td>
				        //<td><u><a href='#' onclick =lihat_detail('$k[id]');><font color='blue'>$k[nodokumen]</font></a></u></td>
				        while($k=mysqli_fetch_assoc($tampil)){
				        	//$date = date("m/d/Y", strtotime($k['tglwo']));
									$tgldokumen = strip_tags($k['nodokumen']);
									$tgldokumen = strip_tags($k['tgldokumen']);
									$supplier = strip_tags($k['kdsupplier']).'|'.strip_tags($de['nmsupplier']);
				        	$uang = number_format($k['uang'],0,",",".");
			            echo "<tr><td align='center'>$no</td>
									<td width=100'>$k[nodokumen]</td>
									<td width=70'>$k[tgldokumen]</td>
									<td width='300'>$supplier</td>
									<td width='80' align='right'>$uang</td>
									<td align='center' width='145px'>";
			            echo "<a class='btn btn-primary' href='?m=permohonan_keluar_uang&tipe=edit_detail&id=$k[id]&nomohon=$k[nomohon]'>Edit</a> ";
			            echo " <input button type='Button' class='btn btn-danger' value='Hapus' onClick='alert_hapus_detail($k[id])'/>";
									$no++;
								}
								$tampil = mysqli_query($connect,"select sum(uang) as total_subtotal from mohklruangd where nomohon='$_GET[nomohon]'");
								$jum = mysqli_fetch_assoc($tampil);
								$total = $jum['total_subtotal'];
								$total = number_format($total,0,",",".");
								echo "<tr><td colspan='3'></td>
								<td colspan='1' align='right'></td>
								<td align='right' style='font-weight:bold'>$total</td>";
								?>
								</table>
							</div>
						<?php } ?>
				<?php if ($kdjnkeluar=='K-LL') {?>
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
							</td><td><input type='text' class='form-control' style='width: 20em' id='nmsupplier' name='nmsupplier'></td>
							</td><td><input type='text' class='form-control' style='width: 30em' id='keterangan' name='keterangan'></td>						
							<input type="hidden" class='form-control' id='total' name='total' style='width: 8em' required readonly>
							</td><td><input type="number" class='form-control' id='uang' name='uang' style='width: 8em' onkeyup="validAngka_no_titik(this)" onblur="hit_subtotal()"></td>
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
								$tampil = mysqli_query($connect,"select * from mohklruangd where nomohon='$_GET[nomohon]'");
								$query = $connect->prepare("select * from mohklruangd where nomohon=?");
								$query->bind_param('s',$_GET['nomohon']);
								$query->execute();
								$result = $query->get_result();
								$de = $result->fetch_assoc();
				        $no=1;
				        //<td><u><a href='?m=wo&tipe=detail&id=$k[id]'><font color='blue'>$k[kode]</font></a></u></td>
				        //<td><u><a href='#' onclick =lihat_detail('$k[id]');><font color='blue'>$k[nodokumen]</font></a></u></td>
				        while($k=mysqli_fetch_assoc($tampil)){
				        	//$date = date("m/d/Y", strtotime($k['tglwo']));
									$tgldokumen = strip_tags($k['nodokumen']);
									$tgldokumen = strip_tags($k['tgldokumen']);
									$supplier = strip_tags($k['kdsupplier']).'|'.strip_tags($de['nmsupplier']);
				        	$uang = number_format($k['uang'],0,",",".");
			            echo "<tr><td align='center'>$no</td>
									<td width=150'>$k[nmsupplier]</td>
									<td width=250'>$k[keterangan]</td>
									<td width='80' align='right'>$uang</td>
									<td align='center' width='100px'>";
			            echo "<a class='btn btn-primary' href='?m=permohonan_keluar_uang&tipe=edit_detail&id=$k[id]&nomohon=$k[nomohon]'>Edit</a> ";
			            echo " <input button type='Button' class='btn btn-danger' value='Hapus' onClick='alert_hapus_detail($k[id])'/>";
									$no++;
								}
								$tampil = mysqli_query($connect,"select sum(uang) as total_subtotal from mohklruangd where nomohon='$_GET[nomohon]'");
								$jum = mysqli_fetch_assoc($tampil);
								$total = $jum['total_subtotal'];
								$total = number_format($total,0,",",".");
								echo "<tr><td colspan='2'></td>
								<td colspan='1' align='right'></td>
								<td align='right' style='font-weight:bold'>$total</td>";
								?>
								</table>
							</div>
						<?php } ?>

						<div class='col-md-12'>
							<!--<input button type='Button' class='btn btn-danger' value='Close' onClick='history.back()'/>-->
							<input button type='Button' class='btn btn-danger' value='Close' onClick="window.location = 'dashboard.php?m=permohonan_keluar_uang'"/>
						</div></div></div>
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
			cekakses($connect,$user,'EDIT DETAIL PERMOHONAN KELUAR UANG');
			$lakses = $_SESSION['aksespakai'];
			if ($lakses == 1) {	
				$query = $connect->prepare("select * from mohklruangh where nomohon=?");
				$query->bind_param('s',$_GET['nomohon']);
				$query->execute();
				$result = $query->get_result();
				$de = $result->fetch_assoc();
				$nomohon = strip_tags($de['nomohon']);
				$tglmohon = strip_tags($de['tglmohon']);
				$kdjnkeluar = strip_tags($de['kdjnkeluar']);?>

        <font face='calibri'>
	        <div class='panel panel-default'>
	        <div class='panel-heading'><font size="4">EDIT DETAIL DATA PERMOHONAN KELUAR UANG</font></div>
	        <div class='panel-body'>
					<form method='post' name='po' enctype='multipart/form-data' action='module/permohonan_keluar_uang/proses_edit_detail.php'>
					<input type='hidden' name='username' value="<?= $user ?>">
					<div class='col-md-10'>
					<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
						<tr><td>Nomor Permohonan</td><td>
						<input type='text' class='form-control' id='nomohon' name='nomohon' placeholder='No. PO *' style='text-transform:uppercase' value="<?= $nomohon ?>" readonly></td>
						<td>Tgl. (M/D/Y)</td><td><input type='date' class='form-control' id='tglmohon' name='tglmohon' value="<?= $tglmohon ?>" size='50' autocomplete='off' readonly></td></tr>
					</table>
					</div>

					<div class='col-md-12'>
					<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
					    <tr>
					    <th>No. Dokumen</th>
							<th>Supplier</th>
							<th>Keterangan</th>
							<th>Bayar</th>
					    </tr>
					    <?php
							$query = $connect->prepare("select * from mohklruangd where id=?");
							$query->bind_param('s',$_GET['id']);
							$query->execute();
							$result = $query->get_result();
							$de = $result->fetch_assoc();
							$nodokumen = strip_tags($de['nodokumen']);
							$tgldokumen = strip_tags($de['tgldokumen']);
							$kdsupplier = strip_tags($de['kdsupplier']);
							$nmsupplier = strip_tags($de['nmsupplier']);
							$keterangan = strip_tags($de['keterangan']);
							$uang = strip_tags($de['uang']);
						?>
						<input type='hidden' name='id' value='<?= $de['id'] ?>'>
						<input type='hidden' name='nomohon' value='<?= $de['nomohon'] ?>'>
						</td><td><input type='text' class='form-control' style='width: 10em' id='nodokumen' name='nodokumen' value='<?= $nodokumen ?>' readonly></td>
						<input type='hidden' class='form-control' style='width: 7em' id='tgldokumen' name='tgldokumen' value='<?= $tgldokumen ?>' readonly>
						<?php if($kdjnkeluar=='K-LL') {?>
								</td><td><input type='text' class='form-control'  style='width: 20em' id='nmsupplier' name='nmsupplier' value='<?= $nmsupplier ?>'></td>
						<?php }else{?>
								</td><td><input type='text' class='form-control'  style='width: 20em' id='nmsupplier' name='nmsupplier' value='<?= $nmsupplier ?>' readonly></td>
						<?php }?>
						</td><td><input type='text' class='form-control'  style='width: 25em' id='keterangan' name='keterangan' value='<?= $keterangan ?>'></td>
						</td><td><input type="number" class='form-control' id='total' name='total' value='<?= $uang ?>' onkeyup="validAngka_no_titik(this)" style='width: 8em'></td>
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
			cekakses($connect,$user,'permohonan keluar uang');
			$lakses = $_SESSION['aksestambah'];
			date_default_timezone_set("Asia/Jakarta");  
			$de=mysqli_fetch_assoc(mysqli_query($connect,"select * from saplikasi where aktif='Y'"));
			$tgl = $de['tgl_berikutnya']; //date('Y-m-d')
			$year = date('Y');
			$month = date('M');
			
			if ($lakses == 1) {?>
		    <font face='calibri'>
        <div class='panel panel-danger'>
        <div class='panel-heading'><font size="4">TAMBAH DATA PERMOHONAN KELUAR UANG</font></div>
        <div class='panel-body'>
				<form method='post' name='permohonan_keluar_uang' enctype='multipart/form-data' action='module/permohonan_keluar_uang/proses_tambah.php'>
				<input type='hidden' name='username' value="<?= $user ?>">
				<div class='col-md-6'>
		      <table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
						<tr><td>Nomor Permohonan</td><td>
						<input type='text' class='form-control' id='nomohon' name='nomohon' placeholder='No. Order *' style='text-transform:uppercase;text-align:left' value="<?php echo autoNumberPK($connect,'id','mohklruangh');?>"  readonly></td></tr>
						<tr><td>Tgl. (M/D/Y)</td><td><input type='date' class='form-control' id='tglmohon' name='tglmohon' value="<?php echo $tgl ?>" size='50' autocomplete='off' required readonly></td></tr>
						<tr><td>Jenis Pengeluaran</td> <td><div class='input-group'>  <input type='text' class='form-control' name='kdjnkeluar' id='kdjnkeluar' size='20' autocomplete='off' required>
							<span class='input-group-btn'>
							<button type='button' id='src' class='btn btn-primary' onclick='cari_data_jnkeluar()'>Cari
							</button>
						</span></td></tr>
						<tr><td></td><td><input type="text" class='form-control' name='nmjnkeluar' id='nmjnkeluar' size='50' readonly required></td></tr>
						<tr><td>Subtotal</td> <td> <input type="number" class='form-control' id='subtotal' name='subtotal' size='50' value='0' readonly></td></tr>
						<tr><td>Materai</td> <td> <input type="number" class='form-control' id='materai' name='materai' size='50' onkeyup="validAngka_no_titik(this)" onblur="hit_subtotal()"></td></tr>
						<tr><td>Total</td> <td> <input type="number" class='form-control' id='total' name='total' size='50' readonly></td></tr>
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
		      <table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
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
						<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
 						<tr><td>No. Rekening</td> <td> <input type="text" class='form-control' id='norek' name='norek' size='50'></td></tr>
 						<tr><td>No. Giro/Cek</td> <td> <input type="text" class='form-control' id='nocekgiro' name='nocekgiro' size='50'></td></tr>
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
			cekakses($connect,$user,'permohonan keluar uang');
			$lakses = $_SESSION['aksesedit'];
			if ($lakses == 1) {	
				// $sql=mysqli_query($connect,"select * FROM permohonan_keluar_uang where id='$_GET[id]'");
				// $de=mysqli_fetch_assoc($sql);
				$query = $connect->prepare("select * from mohklruangh where id=?");
				$query->bind_param('i',$_GET['id']);
				$query->execute();
				$result = $query->get_result();
				$de = $result->fetch_assoc();
				$nomohon = strip_tags($de['nomohon']);
				$tglmohon = strip_tags($de['tglmohon']);
				$kdjnkeluar = strip_tags($de['kdjnkeluar']);
				$nmjnkeluar = strip_tags($de['nmjnkeluar']);
				$carabayar = strip_tags($de['carabayar']);
				$kdbank = strip_tags($de['kdbank']);
				$nmbank = strip_tags($de['nmbank']);
				$kdjnskartu = strip_tags($de['kdjnskartu']);
				$nmjnskartu = strip_tags($de['nmjnskartu']);
				$norek = strip_tags($de['norek']);
				$nocekgiro = strip_tags($de['nocekgiro']);
				$tgljttempocekgiro = strip_tags($de['tgljttempocekgiro']);
				$subtotal = strip_tags($de['subtotal']);
				$materai = strip_tags($de['materai']);
				$total = strip_tags($de['total']);
				$keterangan = strip_tags($de['keterangan']);
				?>
				<font face='calibri'>
					<div class="panel panel-default">
					<div class="panel-heading"><font size="4">EDIT DATA PERMOHONAN KELUAR UANG</font></div>
					<div class="panel-body">
					<form method='post' name='permohonan_keluar_uang' enctype='multipart/form-data' action='module/permohonan_keluar_uang/proses_edit.php'>
						<input type='hidden' name='username' value="<?= $user ?>">
						<input type='hidden' name='id' value="<?= $de['id'] ?>"/>
						<div class='col-md-6'>
			        <table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
							<tr><td>Nomor Permohonan</td><td>
							<input type='text' class='form-control' id='nomohon' name='nomohon' placeholder='No. Order *' style='text-transform:uppercase;text-align:left' value="<?= $nomohon ?>" readonly></td></tr>
							<tr><td>Tgl. (M/D/Y)</td><td><input type='date' class='form-control' id='tglmohon' name='tglmohon' value="<?php echo $tglmohon ?>" size='50' autocomplete='off' required readonly></td></tr>
							<tr><td>Jenis Pengeluaran</td> <td><div class='input-group'>  <input type='text' class='form-control' name='kdjnkeluar' id='kdjnkeluar' size='20' value='<?=$kdjnkeluar?>' autocomplete='off' required>
								<span class='input-group-btn'>
								<button type='button' id='src' class='btn btn-primary' onclick='cari_data_jnkeluar()'>Cari
								</button>
							</span></td></tr>
							<tr><td></td><td><input type="text" class='form-control' name='nmjnkeluar' id='nmjnkeluar' size='50' value='<?=$nmjnkeluar?>' readonly required></td></tr>
			      	<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
								<tr><td>Subtotal</td> <td> <input type="number" class='form-control' id='subtotal' name='subtotal' size='50' value='<?=$subtotal?>' readonly></td></tr>
										<tr><td>Materai</td> <td> <input type="number" class='form-control' id='materai' name='materai' size='50' value='<?=$materai?>' onkeyup="validAngka_no_titik(this)" onblur="hit_subtotal()"></td></tr>
										<tr><td>Total</td> <td> <input type="number" class='form-control' id='total' name='total' value='<?=$total?>' size='50' readonly></td></tr>
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
			        <table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
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
							<table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
	 						<tr><td>No. Rekening</td> <td> <input type="text" class='form-control' id='norek' name='norek' size='50' value="<?= $norek ?>"></td></tr>
	 						<tr><td>No. Giro/Cek</td> <td> <input type="text" class='form-control' id='nocekgiro' name='nocekgiro' size='50' value="<?= $nocekgiro ?>"></td></tr>
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
	}else{

	?>

<?php
	include 'cek_akses.php';
	if ($aksesok == 'Y') {
?>

<font face="calibri">
  <div class="panel panel-info">
    <div class="panel-heading"><font size="4">PERMOHONAN KELUAR UANG</font></div>
    <div class="panel-body">
	 	<form method='get'>
			<div class="row">
				<?php
					include('hal_get.php')
				?>
				<div class="col-md-4 bg">
					<input type="hidden" name="m" value="permohonan_keluar_uang">
					<input type='text' id='kata' name='kata' value="<?= $kata ?>" size='50px' class='form-control' placeholder='NO.PERMOHONAN' onkeyup='searchTable()'>
				</div>
				<button type='submit' class='btn btn-primary'>
				<span class='glyphicon glyphicon-search'></span> Cari</button>
				<a class="btn btn-danger" href="?m=permohonan_keluar_uang&tipe=tambah">Tambah data</a>
			</div>
		</form>
    </br>
	<div class="box-body table-responsive">
    </br>
		<div class="box-body table-responsive">
		<table id="example1" class="table table-bordered table-striped">
			<tbody>
			<tr>
	    <th width='30'>No.</th>
	    <th width='80'>No. Permohonan</th>
	    <th width='70'>Tanggal</th>
			<th width='180'>Jenis</th>
			<th width='80'>Total</th>
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
					$tampil = mysqli_query($connect,"SELECT * FROM mohklruangh order by nomohon desc LIMIT ".$limit_start.",".$limit);
					}
				else{
					$cari = $_GET['kata'];
					$tampil = mysqli_query($connect,"SELECT * FROM mohklruangh WHERE (nomohon like '%$cari%') order by nomohon desc LIMIT ".$limit_start.",".$limit);
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
	       	$date = date("m/d/Y", strtotime($k['tglmohon']));
	       	$jnkeluar = $k['kdjnkeluar'].'|'.$k['nmjnkeluar'];
	       	$total = number_format($k['total'],0,",",".");
	        echo "<tr>
	        <td align='center'>$no</td>
					<td><u><a href='#' onclick =lihat_detail('$k[nomohon]');><font color='blue'>$k[nomohon]</font></a></u></td>
					<td>$date</td>
					<td>$jnkeluar</td>
					<td align='right'>$total</td>
					<td align='center'>";
	        //echo "<a class='btn btn-success' href='?m=permohonan_keluar_uang&tipe=detail&id=$k[id]'>Upd.Dtl</a> ";
	        if ($k['proses']=='Y') {
	        	echo "<a class='btn btn-success' href='?m=permohonan_keluar_uang&tipe=detail_proses&nomohon=$k[nomohon]'>Detail</a> ";
          }else{
           	echo "<a class='btn btn-success' href='?m=permohonan_keluar_uang&tipe=detail&nomohon=$k[nomohon]'>Detail</a> ";
          }
          cekakses($connect,$user,'Permohonan Keluar Uang');
          $lakses = $_SESSION['aksesedit'];
          if ($lakses == 1) {
	        	if ($k['proses']=='Y') {
	            echo "<a class='btn btn-info' href='?m=permohonan_keluar_uang&tipe=edit&id=$k[id]' disabled>Edit</a>";
	          }else{
	            echo "<a class='btn btn-info' href='?m=permohonan_keluar_uang&tipe=edit&id=$k[id]'>Edit</a>";
	          }
					}else{
						echo "<a class='btn btn-info' href='?m=permohonan_keluar_uang&tipe=edit&id=$k[id]' disabled>Edit</a>";
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
				$query = mysqli_query($connect,"select count(*) as jumrec from mohklruangh");
			}else{
				$cari = $_GET['kata'];
				$query = mysqli_query($connect,"select count(*) as jumrec from mohklruangh where (nomohon like '%$cari%')");
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
			  <li><a href="dashboard.php?m=permohonan_keluar_uang&kata=<?= $kata ?>&page=1">First</a></li>
			  <li><a href="dashboard.php?m=permohonan_keluar_uang&kata=<?= $kata ?>&page=<?php echo $link_prev; ?>">&laquo;</a></li>
			<?php
			}
			?>
			<!-- LINK NUMBER -->
			<?php
			// Buat query untuk menghitung semua jumlah data
			if (empty($_GET['kata'])){
				$tampil = mysqli_query($connect,"SELECT * FROM mohklruangh order by nomohon desc ");
				}
			else{
				$cari = $_GET['kata'];
				$tampil = mysqli_query($connect,"SELECT * FROM mohklruangh WHERE (nomohon like '%$cari%') order by nomohon desc ");
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
			  <li<?php echo $link_active; ?>><a href="dashboard.php?m=permohonan_keluar_uang&kata=<?= $kata ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
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
			  <li><a href="dashboard.php?m=permohonan_keluar_uang&kata=<?= $kata ?>&page=<?php echo $link_next; ?>">&raquo;</a></li>
			  <li><a href="dashboard.php?m=permohonan_keluar_uang&kata=<?= $kata ?>&page=<?php echo $jumlah_page; ?>">Last</a></li>
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
	$(document).ready(function(){
		$('#kdjnkeluar').on('blur',function(e){
			let cari = $(this).val();
			$.ajax({
				url: 'repl_jnkeluar.php',
				type: 'post',
				data: {data_jnkeluar : cari},
				success: function(response){
					let data_response = JSON.parse(response);
					if (!data_response){
						$('#kdjnkeluar').val('');					
						$('#nmjnkeluar').val('');
						cari_data_jnkeluar();
						return;
					}
					$('#kdjnkeluar').val(data_response['kode']);
					$('#nmjnkeluar').val(data_response['nama']);
					//console.log(data_response['nama']);
				},
				error:function(){
					console.log('file not fount');
				}
			})
			// console.log(cari);
		})
	})

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
						$('#kdsatuan').val('');					
						cari_data_barang();
						return;
					}
					$('#nmbarang').val(data_response['nama']);
					$('#kdsatuan').val(data_response['kdsatuan']);
					$('#harga').val(data_response['harga']);
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
			url: './module/permohonan_keluar_uang/lihat_detail.php',
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
      	$href = "module/permohonan_keluar_uang/proses_hapus.php?id=";
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
      	$href = "module/permohonan_keluar_uang/proses_hapus_detail.php?id=";
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
      	$href = "module/permohonan_keluar_uang/proses.php?id=";
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
      	$href = "module/permohonan_keluar_uang/batal_proses.php?id=";
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
	var ltotal = (parseInt(document.getElementById('subtotal').value) + parseInt(document.getElementById('materai').value));
	document.getElementById('total').value = ltotal;
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
    document.getElementById("nodokumen").value = "";
    document.getElementById("kdsupplier").value = "";
    document.getElementById("nmsupplier").value = "";
    document.getElementById("total").value = "";
    document.getElementById("uang").value = "";
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
      	$href = "module/permohonan_keluar_uang/cetak.php?id=";
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