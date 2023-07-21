<?php
	$user = $_SESSION['username'];
    if(isset($_GET['tipe'])){
        if($_GET['tipe']=='urutkan'){?>
			<font face='calibri'>
			<h3>Urutkan Data Tabel Module</h3>
			<form method='post' enctype='multipart/form-data' action='module/tbmodule/proses_urutkan.php'>
			<input type='hidden' name='username' value='<?= $user ?>'>
			<label>&nbsp;</label>
						<button type='submit' class='btn btn-primary' name='urutkan' value='urutkan'>Proses Urutkan</button>
						<input button type='Button' class='btn btn-danger' value='Selesai' onClick='history.back()'/>
			</form></font>
			<?php
		}
	}
	
	$user = $_SESSION['username'];
    if(isset($_GET['tipe'])){
        if($_GET['tipe']=='tambah'){?>
			<font face='calibri'>
			<h3>Tambah Data Tabel Module</h3>
            <form method='post' enctype='multipart/form-data' action='module/tbmodule/proses_tambah.php'>
			<input type='hidden' name='username' value='<?= $user ?>'>
			<table style=font-size:13px; class='table table-striped table table-bordered'>
			<tr><td>No. Urut</td> <td> <input type=number class='form-control' name='nurut' size='50' required></td></tr>
			<tr><td>Module</td> <td> <input type=text class='form-control' name='cmodule' size='50' required></td></tr>
			<tr><td>Menu</td> <td>  <input type=text class='form-control' name='cmenu' required' ></td></tr>
			<tr><td>Main Menu</td> <td> <input type=radio name='cmainmenu' value='Y' checked> Y   
                                    <input type=radio name='cmainmenu' value='N'> N </td></tr>
            <tr><td>Level</td> <td> <input type=number class='form-control' name='nlevel' size='50' required></td></tr>                                    
			<tr><td>Lain-Lain</td> <td> <input type=text class='form-control' name='clain' size='50'></td></tr></table>
			<label>&nbsp;</label>
						<button type='submit' class='btn btn-primary'>Simpan</button>
						<input button type='Button' class='btn btn-danger' value='Batal' onClick='history.back()'/>
            </form></font>
            <?php
		}elseif($_GET['tipe']=='edit'){
			$sql=mysqli_query($connect,"select * from tbmodule where id='$_GET[id]'");
			$de=mysqli_fetch_assoc($sql);?>
			<font face='calibri'>
			<h3>Edit Data Tabel Module</h3>
			<form method='post' action='module/tbmodule/proses_edit.php'>
				<input type='hidden' name='username' value='<?= $user ?>'>
				<input type='hidden' name='id' value='<?= $de['id'] ?>'/>
				<table style=font-size:13px; class='table table-striped table table-bordered'>
				<tr><td>No. Urut</td> <td>  <input type=number class='form-control' name='nurut' value='<?= $de['nurut'] ?>'></td></tr>
				<tr><td>Module</td> <td>  <input type=text class='form-control' name='cmodule' value='<?= $de['cmodule'] ?>' required></td></tr>
				<tr><td>Menu</td> <td>  <input type=text class='form-control' name='cmenu' value='<?= $de['cmenu'] ?>'></td></tr>
				<?php
				if ("$de[cmainmenu]"=='N') {
				  echo "<tr><td>Main Menu</td>     <td> : <input type=radio name='cmainmenu' value='Y'> Y 
													  <input type=radio name='cmainmenu' value='N' checked> N </td></tr>";
				}else{
				  echo "<tr><td>Main Menu</td>     <td> : <input type=radio name='cmainmenu' value='Y' checked> Y  
													  <input type=radio name='cmainmenu' value='N'> N </td></tr>";
				}
				?>
				<tr><td>Level</td> <td>  <input type=text class='form-control' name='nlevel' value='<?= $de['nlevel'] ?>'></td></tr>
				<tr><td>Lain-Lain</td> <td>  <input type=text class='form-control' name='clain' value='<?= $de['clain'] ?>'></td></tr></table>
				<label>&nbsp;</label>
						<button type='submit' class='btn btn-primary'>Simpan</button>
						<input button type='Button' class='btn btn-danger' value='Batal' onClick='history.back()'/>
			</form></font>
			<?php
		}
		/*<tr><td>Picture</td> <td>  <input type='file' class='form-control' name='picture' size='100' value='$de[picture]'></td></tr>**/
    }else{

	
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
  <div class="panel panel-info">
    <div class="panel-heading"><font size="4">TABEL MODULE</font></div>
    <div class="panel-body">
	 	<form method='get'>
			<div class="row">
				<?php
					include('hal_get.php')
				?>
				<div class="col-md-4 bg">
					<input type="hidden" name="m" value="tbmodule">
					<input type='text' id='kata' name='kata' value="<?= $kata ?>" size='50px' class='form-control' placeholder='MODULE, MENU' onkeyup='searchTable()'>
				</div>
				<button type='submit' class='btn btn-primary'>
				<span class='glyphicon glyphicon-search'></span> Cari</button>
				<a class="btn btn-danger" href="?m=tbmodule&tipe=tambah">Tambah data</a>
				<a class="btn btn-success" href="?m=tbmodule&tipe=urutkan">Urutkan</a>
			</div>
		</form>
    </br>
		<div class="box-body table-responsive">
		<table id="example1" class="table table-bordered table-striped">
		<tbody>
    <tr>
    <th width='50'>No.</th>
		<th width='70'>No. Urut</th>
		<th>Module</th>
		<th>Menu</th>
		<th width='100'>Main Menu</th>
		<th width='50'>Level</th>
		<th>Lain-Lain</th>
    <th>Aksi</th>
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
				$tampil = mysqli_query($connect,"SELECT * FROM tbmodule order by nurut LIMIT ".$limit_start.",".$limit);
				}
			else{
				$cari = $_GET['kata'];
				$tampil = mysqli_query($connect,"SELECT * FROM tbmodule WHERE (cmodule like '%$cari%' or cmenu like '%$cari%') order by nurut LIMIT ".$limit_start.",".$limit);
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
        echo "<tr><td align='center'>$no</td>
				<td>$k[nurut]</td>";
				if ($k['cmainmenu']=='Y') {
					echo "<td><b>$k[cmodule]</b></td>";
				}else{
					echo "<td>&nbsp;&nbsp;$k[cmodule]</td>";
				}
				echo "<td>$k[cmenu]</td>";
				echo "<td align='center'>$k[cmainmenu]</td>
				<td>$k[nlevel]</td>
				<td>$k[clain]</td>
     		<td align='center' width='140px'>";
				/*echo "<a class='btn btn-danger' href='module/tbmodule/proses_hapus.php?id=$k[id]'
					onClick='return confirm(\"Anda yakin akan menghapus ?\")'>Hapus</a>**/
         echo "<a class='btn btn-info' href='?m=tbmodule&tipe=edit&id=$k[id]'>Edit</a>";
         echo " <input button type='Button' class='btn btn-danger' value='Hapus' onClick='alert_hapus($k[id])'/>
				</td>";
				$no++;
			}
    ?>
	</tbody>
		</table>
		<?php
			if (empty($_GET['kata'])){
				$query = mysqli_query($connect,"select count(*) as jumrec from tbmodule");
			}else{
				$cari = $_GET['kata'];
				$query = mysqli_query($connect,"select count(*) as jumrec from tbmodule where (cmodule like '%$cari%' or cmenu like '%$cari%')");
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
			  <li><a href="dashboard.php?m=tbmodule&kata=<?= $kata ?>&page=1">First</a></li>
			  <li><a href="dashboard.php?m=tbmodule&kata=<?= $kata ?>&page=<?php echo $link_prev; ?>">&laquo;</a></li>
			<?php
			}
			?>
			<!-- LINK NUMBER -->
			<?php
			// Buat query untuk menghitung semua jumlah data
			if (empty($_GET['kata'])){
				$tampil = mysqli_query($connect,"SELECT * FROM tbmodule order by cmodule desc ");
				}
			else{
				$cari = $_GET['kata'];
				$tampil = mysqli_query($connect,"SELECT * FROM tbmodule WHERE (cmodule like '%$cari%' or cmenu like '%$cari%') order by cmodule desc ");
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
			  <li<?php echo $link_active; ?>><a href="dashboard.php?m=tbmodule&kata=<?= $kata ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
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
			  <li><a href="dashboard.php?m=tbmodule&kata=<?= $kata ?>&page=<?php echo $link_next; ?>">&raquo;</a></li>
			  <li><a href="dashboard.php?m=tbmodule&kata=<?= $kata ?>&page=<?php echo $jumlah_page; ?>">Last</a></li>
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
          	$href = "module/tbmodule/proses_hapus.php?id=";
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