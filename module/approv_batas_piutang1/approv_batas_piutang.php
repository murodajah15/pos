<?php
	$user = $_SESSION['username'];
	include "autonumber.php";

  if(isset($_GET['tipe'])){
    if($_GET['tipe']=='import'){
			cekakses($connect,$user,'Approv Batas Piutang');
			$lakses = $_SESSION['aksestambah'];
			if ($lakses == 1) {?>
				<font face='calibri'>
				<div class="panel panel-success">
				<div class="panel-heading"><font size="4">IMPORT DATA APPROV BATAS PIUTANG</font></div>
				<div class="panel-body">
				<form method='post' enctype='multipart/form-data' action='module/approv_batas_piutang/proses_import.php'>
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
			cekakses($connect,$user,'Approv Batas Piutang');
			$lakses = $_SESSION['aksescetak'];
			if ($lakses == 1) {?>
				<font face='calibri'>
				<div class="panel panel-default">
				<div class="panel-heading"><font size="4">EXPORT DATA APPROV BATAS PIUTANG</font></div>
				<div class="panel-body">
				<form method='post' enctype='multipart/form-data' action='module/approv_batas_piutang/proses_export.php'>
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
			cekakses($connect,$user,'Approv Batas Piutang');
			$lakses = $_SESSION['aksespakai'];
			if ($lakses == 1) {	
				$query = $connect->prepare("select * from approv_batas_piutang where id=?");
				$query->bind_param('i',$_GET['id']);
				$result = $query->execute();
				$query->store_result();
				$query->execute();
				$result = $query->get_result();
				$de = $result->fetch_assoc();
				$noapprov = strip_tags($de['noapprov']);
				$noapprov = strip_tags($de['noapprov']);
				$tglapprov = strip_tags($de['tglapprov']);
				$nojual = strip_tags($de['nojual']);
				$tgljual = strip_tags($de['tgljual']);
				$nmcustomer = strip_tags($de['nmcustomer']);
				$total = strip_tags($de['total']);
				$keterangan = strip_tags($de['keterangan']);
				?>
				<font face="calibri">
					<div class="panel panel-warning">
					<div class="panel-heading"><font size="4">DETAIL DATA APPROV BATAS PIUTANG</font></div>
					<div class="panel-body">
					<form method="post" enctype="multipart/form-data">
						<input type="hidden" name="username" value="<?= $user ?>">
						<input type="hidden" name="id" value="<?= $de["id"] ?>">
						<div class='col-md-6'>
						<table style=font-size:13px; class="table table-striped table table-bordered">
						<tr><td>Nomor Approv</td><td>
						<input type='text' class='form-control' id='noapprov' name='noapprov' placeholder='No. Approv *' style='text-transform:uppercase' value="<?= $noapprov ?>" readonly></td></tr>
						<tr><td>Tgl. Approv (M/D/Y)</td><td><input type='date' class='form-control' id='tglapprov' name='tglapprov' value="<?= $tglapprov ?>" autocomplete='off' required></td></tr>
						<tr><td>Nomor Penjualan</td> <td><div class='input-group'>  <input type='text' class='form-control' id='nojual' name='nojual' size='50' value='<?= $nojual ?>' autocomplete='off' readonly required>
						<tr><td></td> <td> <input type="date" class='form-control' id='tgljual' name='tgljual' value="<?= $tgljual ?>" readonly required></td></tr>
						<tr><td></td> <td> <input type="text" class='form-control' id='nmcustomer' name='nmcustomer' value="<?= $nmcustomer ?>" readonly required></td></tr>
						<tr><td></td> <td> <input type="number" class='form-control' id='total' name='total' value="<?= $total ?>" readonly required></td></tr>
	          <tr><td>Keterangan</td> <td> <textarea rows='3' class='form-control' name='keterangan' id='keterangan' readonly><?= $keterangan ?></textarea></td></tr>
						</table>
				</div>
				<div class='col-md-12'>
					<input button type='Button' class='btn btn-danger' value='Close' onClick='history.back()'/>
					<!--<input button type='Button' class='btn btn-danger' value='Close' onClick="window.location.href='?m=approv_batas_piutang'"/>-->
				</div>
				</div></div></form></font>
			<?php }else{
				echo "<script>alert('Anda tidak berhak !');history.go(-1) </script>";
			}
		}
	}
	
  if(isset($_GET['tipe'])){
    if($_GET['tipe']=='tambah'){
      cekakses($connect,$user,'Approv Batas Piutang');
      $lakses = $_SESSION['aksestambah'];
      $tgl=date('Y-m-d');
      if ($lakses == 1) {?>
        <font face='calibri'>
        <div class='panel panel-danger'>
        <div class='panel-heading'><font size="4">TAMBAH DATA APPROV BATAS PIUTANG</font></div>
        <div class='panel-body'>
        <form method='post' name='approv_batas_piutang' enctype='multipart/form-data' action='module/approv_batas_piutang/proses_tambah.php'>
				<input type='hidden' name='username' value="<?= $user ?>">
				<div class='col-md-6'>
	        <table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
						<tr><td>Nomor Approv</td><td>
						<input type='text' class='form-control' id='noapprov' name='noapprov' placeholder='No. Approv *' style='text-transform:uppercase' value="<?php echo autoNumberAP($connect,'id','approv_batas_piutang');?>" readonly></td></tr>
					<tr><td>Tgl. Approv (M/D/Y)</td><td><input type='date' class='form-control' id='tglapprov' name='tglapprov' value="<?php echo $tgl ?>" size='50' autocomplete='off' required readonly></td></tr>
						<tr><td>Nomor Penjualan</td> <td><div class='input-group'>  <input type='text' class='form-control' id='nojual' name='nojual' size='50' autocomplete='off' readonly required>
						<span class='input-group-btn'>
						<button type='button' id='src' class='btn btn-primary' onclick='cari_data_penjualan()'>Cari</button>
						</span></td>
						<tr><td></td> <td> <input type="text" class='form-control' id='tgljual' name='tgljual' readonly required></td></tr>
						<tr><td></td> <td> <input type="text" class='form-control' id='nmcustomer' name='nmcustomer' readonly required></td></tr>
						<tr><td></td> <td> <input type="number" class='form-control' id='total' name='total' readonly required></td></tr>
	          <tr><td>Keterangan</td> <td> <textarea rows='3' class='form-control' name='keterangan' id='keterangan'></textarea></td></tr>
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
			cekakses($connect,$user,'Approv Batas Piutang');
			$lakses = $_SESSION['aksesedit'];
			if ($lakses == 1) {	
				$proses='N';
				$query = $connect->prepare("select * from approv_batas_piutang where proses=? and id=?");
				$query->bind_param('si',$proses,$_GET['id']);
				$query->execute();
				$result = $query->get_result();
				$de = $result->fetch_assoc();
				$noapprov = strip_tags($de['noapprov']);
				$noapprov = strip_tags($de['noapprov']);
				$tglapprov = strip_tags($de['tglapprov']);
				$nojual = strip_tags($de['nojual']);
				$tgljual = strip_tags($de['tgljual']);
				$nmcustomer = strip_tags($de['nmcustomer']);
				$total = strip_tags($de['total']);
				$keterangan = strip_tags($de['keterangan']);
				?>
				<font face="calibri">
					<div class="panel panel-warning">
					<div class="panel-heading"><font size="4">EDIT DATA APPROV BATAS PIUTANG</font></div>
					<div class="panel-body">
					<form method="post" enctype="multipart/form-data" action="module/approv_batas_piutang/proses_edit.php">
						<input type="hidden" name="username" value="<?= $user ?>">
						<input type="hidden" name="id" value="<?= $de["id"] ?>">
						<div class='col-md-6'>
						<table style=font-size:13px; class="table table-striped table table-bordered">
						<tr><td>Nomor Approv</td><td>
						<input type='text' class='form-control' id='noapprov' name='noapprov' placeholder='No. Approv *' style='text-transform:uppercase' value="<?= $noapprov ?>" readonly></td></tr>
						<tr><td>Tgl. Approv (M/D/Y)</td><td><input type='date' class='form-control' id='tglapprov' name='tglapprov' value="<?= $tglapprov ?>" autocomplete='off' required readonly></td></tr>
						<tr><td>Nomor Penjualan</td> <td><div class='input-group'>  <input type='text' class='form-control' id='nojual' name='nojual' size='50' value='<?= $nojual ?>' autocomplete='off' readonly required>
						<span class='input-group-btn'>
						<button type='button' id='src' class='btn btn-primary' onclick='cari_data_penjualan()'>Cari</button>
						</span></td>							
						<tr><td></td> <td> <input type="date" class='form-control' id='tgljual' name='tgljual' value="<?= $tgljual ?>" readonly required></td></tr>
						<tr><td></td> <td> <input type="text" class='form-control' id='nmcustomer' name='nmcustomer' value="<?= $nmcustomer ?>" readonly required></td></tr>
						<tr><td></td> <td> <input type="number" class='form-control' id='total' name='total' value="<?= $total ?>" readonly required></td></tr>
	          <tr><td>Keterangan</td> <td> <textarea rows='3' class='form-control' name='keterangan' id='keterangan'><?= $keterangan ?></textarea></td></tr>
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
    <div class="panel-heading"><font size="4">APPROV BATAS PIUTANG</font></div>
    <div class="panel-body">
	 	<form method='get'>
			<div class="row">
				<?php
					include('hal_get.php')
				?>
				<div class="col-md-4 bg">
					<input type="hidden" name="m" value="approv_batas_piutang">
					<input type='text' id='kata' name='kata' value="<?= $kata ?>" size='50px' class='form-control' placeholder='NO.APPROV, NO. PENJUALAN' onkeyup='searchTable()'>
				</div>
				<button type='submit' class='btn btn-primary'>
				<span class='glyphicon glyphicon-search'></span> Cari</button>
				<a class="btn btn-danger" href="?m=approv_batas_piutang&tipe=tambah">Tambah data</a>
			</div>
		</form>
    </br>
		<div class="box-body table-responsive">
		<table id="example1" class="table table-bordered table-striped">
		<tbody>
		<tr>
			<th width='50'>No.</th>
			<th width='80'>No. Approv</th>
			<th width='80'>Tgl. Approv</th>
			<th width='80'>No. Penjualan</th>
			<th width='70'>Tgl. Penjualan</th>
			<th width='300'>User</th>
			<th width='200'>Aksi</th>
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
				$tampil = mysqli_query($connect,"SELECT * FROM approv_batas_piutang order by noapprov desc LIMIT ".$limit_start.",".$limit);
				}
			else{
				$cari = $_GET['kata'];
				$tampil = mysqli_query($connect,"SELECT * FROM approv_batas_piutang WHERE (noapprov like '%$cari%' or nojual like '%$cari%') order by noapprov desc LIMIT ".$limit_start.",".$limit);
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
				echo "<tr>
					<td align='center'>$no</td>
					<td><u><a href='?m=approv_batas_piutang&tipe=detail&id=$k[id]'><font color='blue'>$k[noapprov]</font></a></u></td>
					<td>$k[tglapprov]</td>
					<td>$k[nojual]</td>
					<td>$k[tgljual]</td>
					<td>$k[user]</td>
					<td align='center'>";
					
					cekakses($connect,$user,'Approv Batas Piutang');
					$lakses = $_SESSION['aksesedit'];
					if ($lakses == 1) {
						if ($k['proses']=='Y') {
							echo "<a class='btn btn-info' href='?m=approv_batas_piutang&tipe=edit&id=$k[id]' disabled>Edit</a>";
						}else{
							echo "<a class='btn btn-info' href='?m=approv_batas_piutang&tipe=edit&id=$k[id]'>Edit</a>";
						}	
					}else{
						echo "<a class='btn btn-info' href='?m=approv_batas_piutang&tipe=edit&id=$k[id]' disabled>Edit</a>";
					}

					include "tombol-tombol.php";

				echo "</td>";
				$no++;
			}
		?>
		</tbody>
		</table>
		<?php
			if (empty($_GET['kata'])){
				$query = mysqli_query($connect,"select count(*) as jumrec from approv_batas_piutang");
			}else{
				$cari = $_GET['kata'];
				$query = mysqli_query($connect,"select count(*) as jumrec from approv_batas_piutang where (noapprov like '%$cari%' or nojual like '%$cari%')");
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
			  <li><a href="dashboard.php?m=approv_batas_piutang&kata=<?= $kata ?>&page=1">First</a></li>
			  <li><a href="dashboard.php?m=approv_batas_piutang&kata=<?= $kata ?>&page=<?php echo $link_prev; ?>">&laquo;</a></li>
			<?php
			}
			?>
			<!-- LINK NUMBER -->
			<?php
			// Buat query untuk menghitung semua jumlah data
			if (empty($_GET['kata'])){
				$tampil = mysqli_query($connect,"SELECT * FROM approv_batas_piutang order by noapprov desc ");
				}
			else{
				$cari = $_GET['kata'];
				$tampil = mysqli_query($connect,"SELECT * FROM approv_batas_piutang WHERE (noapprov like '%$cari%' or nojual like '%$cari%') order by noapprov desc ");
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
			  <li<?php echo $link_active; ?>><a href="dashboard.php?m=approv_batas_piutang&kata=<?= $kata ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
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
			  <li><a href="dashboard.php?m=approv_batas_piutang&kata=<?= $kata ?>&page=<?php echo $link_next; ?>">&raquo;</a></li>
			  <li><a href="dashboard.php?m=approv_batas_piutang&kata=<?= $kata ?>&page=<?php echo $jumlah_page; ?>">Last</a></li>
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
          	//alert($noapprov);
          	$href = "module/approv_batas_piutang/proses_hapus.php?id=";
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
          	$href = "module/approv_batas_piutang/proses.php?id=";
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
          	$href = "module/approv_batas_piutang/batal_proses.php?id=";
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
