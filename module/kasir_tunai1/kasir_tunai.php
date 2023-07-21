<?php
	$user = $_SESSION['username'];
	include "autonumber.php";

  if(isset($_GET['tipe'])){
    if($_GET['tipe']=='tambah'){
			cekakses($connect,$user,'Kasir Penerimaan Tunai');
			$lakses = $_SESSION['aksestambah'];
			date_default_timezone_set("Asia/Jakarta");  
			$de=mysqli_fetch_assoc(mysqli_query($connect,"select * from saplikasi where aktif='Y'"));
			$tgl = $de['tgl_berikutnya']; //date('Y-m-d')
			$year = date('Y');
			$month = date('M');
			
			if ($lakses == 1) {?>
		    <font face='calibri'>
        <div class='panel panel-danger'>
        <div class='panel-heading'><font size="4">TAMBAH DATA KASIR PENERIMAAN TUNAI</font></div>
        <div class='panel-body'>
				<form method='post' name='po' enctype='multipart/form-data' action='module/kasir_tunai/proses_tambah.php'>
				<input type='hidden' name='username' value="<?= $user ?>">
				<div class='col-md-6'>
		      <table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
						<tr><td>Nomor Kwitansi</td><td>
						<input type='text' class='form-control' id='nokwitansi' name='nokwitansi' placeholder='No. Order *' style='text-transform:uppercase;text-align:left' value="<?php echo autoNumberKW($connect,'id','kasir_tunai');?>"  readonly></td></tr>
						<tr><td>Tgl. (M/D/Y)</td><td><input type='date' class='form-control' id='tglkwitansi' name='tglkwitansi' value="<?php echo $tgl ?>" size='50' autocomplete='off' required readonly></td></tr>
						<tr><td>Jenis Kwitansi
						<td><select required id='jnskwitansi' name='jnskwitansi' class='form-control' style='width: 200x;' onchange='changeValueDriver(this.value)'>
						<!--<option value=''> - PILIH JENIS KWITANSI - </option>";?>-->
							<option value="UANG-MUKA">UANG-MUKA</option>
							<option value="PELUNASAN">PELUNASAN</option>
							</select>															
						<tr><td>No. Penjualan</td> <td><div class='input-group'>  <input type='text' class='form-control' id='nojual' name='nojual' size='50' autocomplete='off' readonly required>
							<span class='input-group-btn'>
							<button type='button' id='src' class='btn btn-primary' onclick='cari_data_penjualan()'>
								Cari
							</button>
						</span></td>
						<tr><td>Customer</td> <td> <input type="text" class='form-control' id='nmcustomer' name='nmcustomer' size='50' readonly required></td></tr>
						<input type="hidden" class='form-control' id='kdcustomer' name='kdcustomer' size='50' readonly required>
						<input type="hidden" class='form-control' id='total' name='total' size='50' readonly required>
						<tr><td>Nilai Piutang</td> <td align='right'> <input type="number" class='form-control' id='piutang' name='piutang' value ='0' size='50' style='text-align:right' readonly required></td></tr>
						<tr><td>Nilai Bayar</td> <td align='right'> <input type="number" class='form-control' id='bayar' name='bayar' value='0' size='50' style='text-align:right' onkeyup="validAngka_no_titik(this)" onblur="hit_subtotal()" required></td></tr>
						<tr><td>Uang diterima </td> <td> <input type="number" class='form-control' id='uang' name='uang' value='0' size='65' style='text-align:right' onkeyup="validAngka_no_titik(this)" onblur="hit_subtotal()" required></td>
						<tr><td>Kembali </td> <td> <input type="number" class='form-control' id='kembali' name='kembali' value='0' size='35' style='text-align:right' readonly required></td>
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
							<button type='button' id='src' class='btn btn-primary' onclick='cari_data_bank()'>Cari</button>
						</span></td>
						<td> <input type="text" class='form-control' name='nmbank' id='nmbank' size='50' readonly required></td></tr>
						<tr><td>Jenis Kartu</td> <td><div class='input-group'>  <input type='text' class='form-control' name='kdjnskartu' id='kdjnskartu' size='20' autocomplete='off' readonly required>
							<span class='input-group-btn'>
							<button type='button' id='src' class='btn btn-primary' onclick='cari_data_jnskartu()'>Cari</button>
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
			cekakses($connect,$user,'Kasir Penerimaan Tunai');
			$lakses = $_SESSION['aksesedit'];
			if ($lakses == 1) {	
				// $sql=mysqli_query($connect,"select * FROM kasir_tunai where id='$_GET[id]'");
				// $de=mysqli_fetch_assoc($sql);
				$query = $connect->prepare("select * from kasir_tunai where id=?");
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
				?>
				<font face='calibri'>
					<div class="panel panel-default">
					<div class="panel-heading"><font size="4">EDIT DATA KASIR PENERIMAAN TUNAI</font></div>
					<div class="panel-body">
					<form method='post' name='beli' enctype='multipart/form-data' action='module/kasir_tunai/proses_edit.php'>
						<input type='hidden' name='username' value="<?= $user ?>">
						<input type='hidden' name='id' value="<?= $de['id'] ?>"/>
						<div class='col-md-6'>
			        <table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
							<tr><td>Nomor Kwitansi</td><td>
							<input type='text' class='form-control' id='nokwitansi' name='nokwitansi' placeholder='No. Order *' style='text-transform:uppercase;text-align:left' value="<?= $nokwitansi ?>" readonly></td></tr>
							<tr><td>Tgl. (M/D/Y)</td><td><input type='date' class='form-control' id='tglkwitansi' name='tglkwitansi' value="<?php echo $tglkwitansi ?>" size='50' autocomplete='off' required readonly></td></tr>
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
							<tr><td>No. Penjualan</td> <td><div class='input-group'>  <input type='text' class='form-control' id='nojual' name='nojual' size='50' value="<?= $nojual ?>" autocomplete='off' readonly required>
							<span class='input-group-btn'>
								<button type='button' id='src' class='btn btn-primary' onclick='cari_data_penjualan()'>Cari</button>
							</span></td>
							<tr><td>Customer</td> <td> <input type="text" class='form-control' id='nmcustomer' name='nmcustomer' size='50' value="<?= $nmcustomer ?>" readonly required></td></tr>
							<input type="hidden" class='form-control' id='kdcustomer' name='kdcustomer' size='50' value="<?= $kdcustomer ?>" readonly required>
							<tr><td>Nilai Piutang</td> <td align='right'> <input type="number" class='form-control' id='piutang' name='piutang' size='50' value="<?= $piutang ?>" style='text-align:right' readonly required></td></tr>
							<tr><td>Nilai Bayar</td> <td align='right'> <input type="number" class='form-control' id='bayar' name='bayar' size='50' value="<?= $bayar ?>" style='text-align:right' onkeyup="validAngka_no_titik(this)" onblur="hit_subtotal()" required></td></tr>
							<tr><td>Uang diterima </td> <td> <input type="number" class='form-control' id='uang' name='uang' size='65' value="<?= $uang ?>" style='text-align:right' onkeyup="validAngka_no_titik(this)" onblur="hit_subtotal()" required></td>
							<tr><td>Kembali </td> <td> <input type="number" class='form-control' id='kembali' name='kembali' size='35' value="<?= $kembali ?>" style='text-align:right' readonly required></td>
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
    <div class="panel-heading"><font size="4">KASIR PENERIMAAN TUNAI</font></div>
    <div class="panel-body">
	 	<form method='get'>
			<div class="row">
				<?php
					include('hal_get.php')
				?>
				<div class="col-md-4 bg">
					<input type="hidden" name="m" value="kasir_tunai">
					<input type='text' id='kata' name='kata' value="<?= $kata ?>" size='50px' class='form-control' placeholder='NO.KWITANSI, CUSTOMER, NO. JUAL' onkeyup='searchTable()'>
				</div>
				<button type='submit' class='btn btn-primary'>
				<span class='glyphicon glyphicon-search'></span> Cari</button>
				<a class="btn btn-danger" href="?m=kasir_tunai&tipe=tambah">Tambah data</a>
			</div>
		</form>
    </br>
	<div class="box-body table-responsive">
	<table id="example1" class="table table-bordered table-striped">
	</body>
    <tr>
    <th width='30'>No.</th>
    <th width='80'>No. Kwitansi</th>
    <th width='60'>Tanggal</th>
		<th width='90'>No. Penjualan</th>
		<th>Customer</th>
		<th width='70'>Pembayaran</th>
    <th width='250'>Aksi</th>
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
				$tampil = mysqli_query($connect,"SELECT * FROM kasir_tunai order by nokwitansi desc LIMIT ".$limit_start.",".$limit);
				}
			else{
				$cari = $_GET['kata'];
				$tampil = mysqli_query($connect,"SELECT * FROM kasir_tunai WHERE (nokwitansi like '%$cari%' or nmcustomer like '%$cari%' or nojual like '%$cari%') order by nokwitansi desc LIMIT ".$limit_start.",".$limit);
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
       	$bayar = number_format($k['bayar'],0,",",".");
        echo "<tr>
        <td align='center'>$no</td>
				<td><u><a href='#' onclick =lihat_detail('$k[nokwitansi]');><font color='blue'>$k[nokwitansi]</font></a></u></td>
				<td>$date</td>
				<td>$k[nojual]</td>
				<td>$k[nmcustomer]</td>
				<td align='right'>$bayar</td>
				<td align='center'>";    
        //echo "<a class='btn btn-success' href='?m=kasir_tunai&tipe=detail&id=$k[id]'>Upd.Dtl</a> ";
 				cekakses($connect,$user,'Kasir Penerimaan Tunai');
				$lakses = $_SESSION['aksesedit'];
				if ($lakses == 1) {
	      	if ($k['proses']=='Y') {
	          	echo "<a class='btn btn-info' href='?m=kasir_tunai&tipe=edit&id=$k[id]' disabled>Edit</a>";
	        }else{
	          	echo "<a class='btn btn-info' href='?m=kasir_tunai&tipe=edit&id=$k[id]'>Edit</a>";
	        }
	      }else{
	      	echo "<a class='btn btn-info' href='?m=kasir_tunai&tipe=edit&id=$k[id]' disabled>Edit</a>";
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
				$query = mysqli_query($connect,"select count(*) as jumrec from kasir_tunai");
			}else{
				$cari = $_GET['kata'];
				$query = mysqli_query($connect,"select count(*) as jumrec from kasir_tunai where (nokwitansi like '%$cari%' or nmcustomer like '%$cari%')");
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
			  <li><a href="dashboard.php?m=kasir_tunai&kata=<?= $kata ?>&page=1">First</a></li>
			  <li><a href="dashboard.php?m=kasir_tunai&kata=<?= $kata ?>&page=<?php echo $link_prev; ?>">&laquo;</a></li>
			<?php
			}
			?>
			<!-- LINK NUMBER -->
			<?php
			// Buat query untuk menghitung semua jumlah data
			if (empty($_GET['kata'])){
				$tampil = mysqli_query($connect,"SELECT * FROM kasir_tunai order by nokwitansi desc ");
				}
			else{
				$cari = $_GET['kata'];
				$tampil = mysqli_query($connect,"SELECT * FROM kasir_tunai WHERE (nokwitansi like '%$cari%' or nmcustomer like '%$cari%' or nojual like '%$cari%') order by nokwitansi desc ");
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
			  <li<?php echo $link_active; ?>><a href="dashboard.php?m=kasir_tunai&kata=<?= $kata ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
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
			  <li><a href="dashboard.php?m=kasir_tunai&kata=<?= $kata ?>&page=<?php echo $link_next; ?>">&raquo;</a></li>
			  <li><a href="dashboard.php?m=kasir_tunai&kata=<?= $kata ?>&page=<?php echo $jumlah_page; ?>">Last</a></li>
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
	function lihat_detail(id){
		$('#modaldetail').modal('show');
		//$('#modaldetail').find('.modal-body').html(id);
		$.ajax({
			url: './module/kasir_tunai/lihat_detail.php',
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
          	$href = "module/kasir_tunai/proses_hapus.php?id=";
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
          	$href = "module/kasir_tunai/proses_hapus_detail.php?id=";
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
          	$href = "module/kasir_tunai/proses.php?id=";
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
          	$href = "module/kasir_tunai/batal_proses.php?id=";
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

	function lihat_detail(id){
		$('#modaldetail').modal('show');
		//$('#modaldetail').find('.modal-body').html(id);
		$.ajax({
			url: './module/kasir_tunai/lihat_detail.php',
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
        	$href = "module/kasir_tunai/cetak.php?id=";
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