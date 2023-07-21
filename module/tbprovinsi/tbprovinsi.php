<?php
	$user = $_SESSION['username'];
	
    if(isset($_GET['tipe'])){
        if($_GET['tipe']=='import'){
			cekakses($connect,$user,'Tabel Provinsi');
			$lakses = $_SESSION['aksestambah'];
			if ($lakses == 1) {
				echo "<font face='calibri'>
                <h3>Import Data Tabel Provinsi</h3>
                <form method='post' enctype='multipart/form-data' action='module/tbprovinsi/proses_import.php'>
				<input type='hidden' name='username' value=$user>
				Pilih File Excel*: 
				<input name='fileexcel' type='file' accept='application/vnd.ms-excel'></br> <!--<input name='upload' type='submit' value='Import'>-->
				<label>&nbsp;</label>
							<button type='submit' class='btn btn-primary' name='upload' value='import'>Import</button>
							<input button type='Button' class='btn btn-danger' value='Selesai' onClick='history.back()'/>
                </form></font>";
			}else{
				echo "<script>alert('Anda tidak berhak !');history.go(-1) </script>";
			}
		}
	}

    if(isset($_GET['tipe'])){
        if($_GET['tipe']=='export'){
			cekakses($connect,$user,'Tabel Provinsi');
			$lakses = $_SESSION['aksescetak'];
			if ($lakses == 1) {
				echo "<font face='calibri'>
                <h3>Export Data Tabel Provinsi</h3>
                <form method='post' enctype='multipart/form-data' action='module/tbprovinsi/proses_export.php'>
				<input type='hidden' name='username' value=$user>
				Type : <select name=typefile class='form-control' required>
													<option value='Excel'> Excel</option>
													<option value='CSV'> CSV</option>
												</select><br>
				<label>&nbsp;</label>
							<button type='submit' class='btn btn-primary' name='upload' value='export'>Export</button>
							<input button type='Button' class='btn btn-danger' value='Selesai' onClick='history.back()'/>
                </form></font>";
			}else{
				echo "<script>alert('Anda tidak berhak !');history.go(-1) </script>";
			}
		}
	}

    if(isset($_GET['tipe'])){
        if($_GET['tipe']=='detail'){
			cekakses($connect,$user,'Tabel Provinsi');
			$lakses = $_SESSION['aksespakai'];
			if ($lakses == 1) {
				$sql=mysqli_query($connect,"select * from tbprovinsi where id='$_GET[id]'");
				$de=mysqli_fetch_assoc($sql);?>
				<font face='calibri'>
					<h3>Detail Data Tabel Provinsi</h3>
					<form method='post' enctype='multipart/form-data'>
						<input type='hidden' name='username' value='<?= $user ?>'>
						<input type='hidden' name='id' value='<?= $de['id'] ?>'/>
						<table style=font-size:13px; class='table table-striped table table-bordered'>
						<tr><td>Kode</td> <td>  <input type=text class='form-control' name='kode' value='<?= $de['kode'] ?>' readonly></td></tr>
						<tr><td>Nama</td> <td>  <input type=text class='form-control' name='nama' value='<?= $de['nama'] ?>' readonly></td></tr>
						<tr><td>Aktif</td> <td>  <input type=text class='form-control' name='aktif' value='<?= $de['aktif'] ?>' readonly></td></tr>
						</table>
						<label>&nbsp;</label>
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
        if($_GET['tipe']=='tambah'){
			cekakses($connect,$user,'Tabel Provinsi');
			$lakses = $_SESSION['aksestambah'];
			if ($lakses == 1) {?>
				<font face='calibri'>
	                <h3>Tambah Data Tabel Provinsi</h3>
	                <form method='post' enctype='multipart/form-data' action='module/tbprovinsi/proses_tambah.php'>
						<input type='hidden' name='username' value='<?= $user ?>'>
						<table style=font-size:13px; class='table table-striped table table-bordered'>
						<tr><td>Kode</td> <td> <input type=text class='form-control' name='kode' size='50' autofocus=autofocus() required></td></tr>
						<tr><td>Nama</td> <td> <input type=text class='form-control' name='nama' size='50' required></td></tr>
						<tr><td>Aktif</td> <td> <input type=radio name='aktif' value='Y' checked> Y   
		                                        <input type=radio name='aktif' value='N'> N </td></tr></table>
						<label>&nbsp;</label>
									<button type='submit' class='btn btn-primary'>Simpan</button>
									<input button type='Button' class='btn btn-danger' value='Batal' onClick='history.back()'/>
					</form>
				</font>
				<?php
			}else{
				echo "<script>alert('Anda tidak berhak !');history.go(-1) </script>";
			}

        }elseif($_GET['tipe']=='edit'){
			cekakses($connect,$user,'Tabel Provinsi');
			$lakses = $_SESSION['aksesedit'];
			if ($lakses == 1) {	
				$sql=mysqli_query($connect,"select * from tbprovinsi where id='$_GET[id]'");
				$de=mysqli_fetch_assoc($sql);?>
				<font face='calibri'>
					<h3>Edit Data Tabel Provinsi</h3>
					<form method='post' enctype='multipart/form-data' action='module/tbprovinsi/proses_edit.php'>
						<input type='hidden' name='username' value='<?= $user ?>'>
						<input type='hidden' name='id' value='<?= $de['id'] ?>'/>
						<table style=font-size:13px; class='table table-striped table table-bordered'>
						<tr><td>Kode</td> <td>  <input type=text class='form-control' name='kode' value='<?= $de['kode'] ?>' readonly></td></tr>
						<tr><td>Nama</td> <td>  <input type=text class='form-control' name='nama' value='<?= $de['nama'] ?>' autofocus=autofocus() required></td></tr>
						<?php
						if ("$de[aktif]"=='N') {
						  echo "<tr><td>Aktif</td>     <td> : <input type=radio name='aktif' value='Y'> Y 
															  <input type=radio name='aktif' value='N' checked> N </td></tr></table>";
						}else{
						  echo "<tr><td>Aktif</td>     <td> : <input type=radio name='aktif' value='Y' checked> Y  
															  <input type=radio name='aktif' value='N'> N </td></tr></table>";
						}					
						echo "<label>&nbsp;</label>
								<button type='submit' class='btn btn-primary'>Simpan</button>
								<input button type='Button' class='btn btn-danger' value='Batal' onClick='history.back()'/>
					</form>
				</font>";
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
		if ($aksesok == 'Y') {
	?>
	
	<font face="calibri">
     <h3>Tabel Provinsi</h3>
	 	<hr size="10px">
	<form method='post'>
	<div class="row">	 
		<div class="col-md-4 bg">
			<input type=text id='kata' name='kata' size='50px' class='form-control' placeholder='Kode, Nama' onkeyup='searchTable()'>
		</div>
		<?php
			include 'hal.php';
		?>		
		<button type='submit' name='kata2' class='btn btn-primary'>
		<span class='glyphicon glyphicon-search'></span> Cari</button>
		<a class="btn btn-danger" href="?m=tbprovinsi&tipe=tambah">Tambah data</a>
		<a class="btn btn-success" href="?m=tbprovinsi&tipe=import">Import data</a>
		<a class="btn btn-warning" href="?m=tbprovinsi&tipe=export">Export data</a>
	</div>
	</form>
	<br>
	<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover">
	    <tr>
            <th width='50'>No.</th>
			<th>Kode</th>
			<th>Nama</th>
			<th>Aktif</th>
			<th>User</th>
            <th>Aksi</th>
        </tr>
        <?php
		// Cek apakah terdapat data page pada URL
			$page = (isset($_GET['page']))? $_GET['page'] : 1;
			if (isset($_POST['record'])){
				$_SESSION['jmlperhalaman']=$_POST['record'];
				$limit = $_POST['record']; //5; // Jumlah data per halamannya**/
			}else{
				$limit = $_SESSION['jmlperhalaman'];
			}
			$limit_start = ($page - 1) * $limit;
			// Untuk menentukan dari data ke berapa yang akan ditampilkan pada tabel yang ada di database
			if (empty($_POST['kata'])){
				$tampil = mysqli_query($connect,"SELECT * FROM tbprovinsi order by kode LIMIT ".$limit_start.",".$limit);
				}
			else{
				$cari = $_POST['kata'];
				$tampil = mysqli_query($connect,"SELECT * FROM tbprovinsi WHERE kode like '%$cari%' or nama like '%$cari%' order by kode LIMIT ".$limit_start.",".$limit);
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
					<td><u><a href='?m=tbprovinsi&tipe=detail&id=$k[id]'><font color='blue'>$k[kode]</font></a></u></td>
					<td>$k[nama]</td>
					<td width='70' align='center'>$k[aktif]</td>
					<td>$k[user]</td>
                    <td align='center' width='140px'>
                        <a class='btn btn-info' href='?m=tbprovinsi&tipe=edit&id=$k[id]'>Edit</a>";
						cekakses($connect,$user,'Tabel Provinsi');
						$lakses = $_SESSION['akseshapus'];
						if ($lakses == 1) {
							/*echo " <a class='btn btn-danger' href='module/tbprovinsi/proses_hapus.php?id=$k[id]&kode=$k[kode]'
							onClick='return confirm(\"Anda yakin akan menghapus ?\")'>Hapus</a>";**/
							echo " <input button type='Button' class='btn btn-danger' value='Hapus' onClick='alert_hapus($k[id])'/>";
						}else{
							echo " <input button type='Button' class='btn btn-danger' value='Hapus' onClick='alert_hapus($k[id])' disabled/>";
						}
            echo "</td>";
				$no++;
			}
        ?>
    </table>
	<?php
		$query = mysqli_query($connect,"select count(*) as jumrec from tbprovinsi");
		$result = mysqli_fetch_array($query);
		echo "Jumlah Record : ".$result['jumrec'];
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
			  <li><a href="dashboard.php?m=tbprovinsi&page=1">First</a></li>
			  <li><a href="dashboard.php?m=tbprovinsi&page=<?php echo $link_prev; ?>">&laquo;</a></li>
			<?php
			}
			?>
			
			<!-- LINK NUMBER -->
			<?php
			// Buat query untuk menghitung semua jumlah data
			include("./inc/config.php");

			if (empty($_POST['kata'])){
				$tampil = mysqli_query($connect,"SELECT * FROM tbprovinsi");
				}
			else{
				$cari = $_POST['kata'];
				$tampil = mysqli_query($connect,"SELECT * FROM tbprovinsi WHERE kode like '%$cari%' or nama like '%$cari%'");
			}
			
			$get_jumlah = mysqli_num_rows($tampil);
			
			/*$jumlah_page = ceil($get_jumlah['jumlah'] / $limit); // Hitung jumlah halamannya**/
			$jumlah_page = ceil($get_jumlah/$limit);
			$jumlah_number = 2; // Tentukan jumlah link number sebelum dan sesudah page yang aktif
			$start_number = ($page > $jumlah_number)? $page - $jumlah_number : 1; // Untuk awal link number
			$end_number = ($page < ($jumlah_page - $jumlah_number))? $page + $jumlah_number : $jumlah_page; // Untuk akhir link number
			
			for($i = $start_number; $i <= $end_number; $i++){
			  $link_active = ($page == $i)? ' class="active"' : '';
			?>
			  <li<?php echo $link_active; ?>><a href="dashboard.php?m=tbprovinsi&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
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
			  <li><a href="dashboard.php?m=tbprovinsi&page=<?php echo $link_next; ?>">&raquo;</a></li>
			  <li><a href="dashboard.php?m=tbprovinsi&page=<?php echo $jumlah_page; ?>">Last</a></li>
			<?php
			}
			?>
		</ul>
    </table>
	</div>
    <?php
    }else{
	echo "<font color='red'>Anda tidak punya hak !</font>";
	}?>
    <?php
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
          	$href = "module/tbprovinsi/proses_hapus.php?id=";
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