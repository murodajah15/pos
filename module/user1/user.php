<?php
		$user = $_SESSION['username'];
    if(isset($_GET['tipe'])){
        if($_GET['tipe']=='detailh'){
            $sql=mysqli_query($connect,"select * from user where id='$_GET[id]'");
            $de=mysqli_fetch_assoc($sql);?>
            <font face='calibri'>
                <h3>Detail Data User</h3>
                <form method='POST' enctype='multipart/form-data'>
					<table style=font-size:13px; class='table table-striped table table-bordered'>
					<tr><td>User Name</td> <td>  <input type='text' class='form-control' name='username' size='100' value='<?= $de['username'] ?>' readonly></td></tr>
					<tr><td>Nama Lengkap</td> <td>  <input type='text' class='form-control' name='nama_lengkap' size='100' value='<?= $de['nama_lengkap'] ?>' readonly></td></tr>
					<tr><td>Email</td> <td>  <input type='text' class='form-control' name='email' size='100' value='<?= $de['email'] ?>' readonly></td></tr>
					<tr><td>Telpon</td> <td>  <input type='text' class='form-control' name='telp' size='100' value='<?= $de['telp'] ?>' readonly></td></tr>
					<tr><td>Terakhir Login</td> <td>  <input type='text' class='form-control' name='telp' size='100' value='<?= $de['last_login'] ?>' readonly></td></tr>
					<?php
					echo "<td><img src='photo/$de[photo]' width='50></td></tr>
					<input type='hidden' name='x' id='x' value='$de[photo]'>";
					echo "<tr><td>Level</td> <td> ";					
					echo "<select name=level class='form-control' disabled>";
					/*<?php**/
					$level=array("ADMINISTRATOR","USER","GUEST");
					$jlh_bln=count($level);
					for($c=0; $c<$jlh_bln; $c+=1){
						if ($level[$c]==$de[level]){
							echo "<option value=$level[$c] selected>$level[$c] </option>";
						}else{
							echo "<option value=$level[$c]> $level[$c] </option>";
						}
					}
					/*?>**/
					echo "</select>";
					if ("$de[aktif]"=='N') {
					  echo "<tr><td>Aktif</td>     <td> : <input type=radio name='aktif' value='Y' disabled='disabled'> Y 
														  <input type=radio name='aktif' value='N' checked disabled='disabled'> N </td></tr></table>";
					}else{
					  echo "<tr><td>Aktif</td>     <td> : <input type=radio name='aktif' value='Y' checked disabled='disabled'> Y  
														  <input type=radio name='aktif' value='N' disabled='disabled'> N </td></tr></table>";
					}					
					//<button type='submit' class='btn btn-primary'>Simpan</button>
          echo "<label>&nbsp;</label>
					<input button type='Button' class='btn btn-danger' value='Close' onClick='history.back()'/>
            </form></font>";

        }
    }

    if(isset($_GET['tipe'])){
        if($_GET['tipe']=='detail'){
			$sql=mysqli_query($connect,"select * from user where id='$_GET[id]'");
			$de=mysqli_fetch_assoc($sql);
			$username = $de['username'];
			$userid = $de['id'];
			
			$sql=mysqli_query($connect,"select * from tbmodule order by nurut");
            while($de=mysqli_fetch_assoc($sql)){
				$lcsql=mysqli_query($connect,"select * from userdtl where idmodule='$de[id]' and iduser='$_GET[id]'");
				$d1=mysqli_fetch_assoc($lcsql);
				if (mysqli_num_rows($lcsql)==0) {
					$cek=mysqli_query($connect,"insert into userdtl (iduser,username,idmodule,cmodule,cmainmenu,nlevel,clain,nurut) values 
					('$userid','$username','$de[id]','$de[cmodule]','$de[cmainmenu]','$de[nlevel]','$de[clain]','$de[nurut]')");
					if ($cek < 1){
						echo "<script>alert('Tidak bisa insert data !');history.go(-1) </script>";
						exit();
					}
				}else{
					$cek=mysqli_query($connect,"update userdtl set cmodule='$de[cmodule]',cmainmenu='$de[cmainmenu]',nlevel='$de[nlevel]',
					clain='$de[clain]',nurut='$de[nurut]' where idmodule='$de[id]' and iduser='$_GET[id]'");
					if ($cek < 1){
						echo "<script>alert('Tidak bisa update data !');history.go(-1) </script>";
						exit();
					}					
				}
			}

            $sql=mysqli_query($connect,"select * from user where id='$_GET[id]'");
            $de=mysqli_fetch_assoc($sql);			
			echo "<font face='calibri'>
			<h3>Detail Data User :
			$username</h3></font>";?>

            <form method='post' enctype='multipart/form-data' action='module/user/proses_edit_detail.php'>
	            <input type='hidden' name='id' id='id' value='<?= $de['id'] ?>'/>
	            <input type='hidden' name='username' id='username' value='<?= $username ?>'/>
           	<table style=font-size:13px; class='table table-striped table table-bordered'>
				<tr>
					<th width='190'>Module</th>
					<th width='10'>Pakai <br>
					<input type='checkbox' id="checkall_pakai"/> Pilih Semua<br></th>
					<th width='10'>Tambah <br>
					<input type='checkbox' id="checkall_tambah" /> Pilih Semua<br></th>
					<th width='10'>Edit <br>
					<input type='checkbox' id="checkall_edit"' /> Pilih Semua<br></th>
					<th width='10'>Hapus <br>
					<input type='checkbox' id="checkall_hapus" /> Pilih Semua<br></th>
					<th width='10'>Proses <br>
					<input type='checkbox' id="checkall_proses" /> Pilih Semua<br></th>
					<th width='80'>Batal Proses <br>
					<input type='checkbox' id="checkall_unproses" /> Pilih Semua<br></th>
					<th width='10'>Print <br>
					<input type='checkbox' id="checkall_cetak" /> Pilih Semua<br></th>
				</tr>
				<?php
				$sql=mysqli_query($connect,"select * from userdtl where iduser='$userid' order by nurut");
				while($k=mysqli_fetch_assoc($sql)){
					if ($k['pakai'] == 1) $pakai = 'checked'; else $pakai = '';
					if ($k['tambah'] == 1) $tambah = 'checked'; else $tambah = '';
					if ($k['edit'] == 1) $edit = 'checked'; else $edit = '';
					if ($k['hapus'] == 1) $hapus = 'checked'; else $hapus = '';
					if ($k['proses'] == 1) $proses = 'checked'; else $proses = '';
					if ($k['unproses'] == 1) $unproses = 'checked'; else $unproses = '';
					if ($k['cetak'] == 1) $cetak = 'checked'; else $cetak = '';
					if ($k['cmainmenu']=='Y') {
						echo "<tr><td><b>$k[cmodule]</b></td>";
					}else{
						echo "<tr><td>&nbsp;&nbsp;$k[cmodule]</td>";
					}
					$idmodule = $k['idmodule'];
					$checkboxpakai = 'checkboxpakai'.$idmodule;
					$checkboxtambah = 'checkboxtambah'.$idmodule;
					$checkboxedit = 'checkboxedit'.$idmodule;
					$checkboxhapus = 'checkboxhapus'.$idmodule;
					$checkboxproses = 'checkboxproses'.$idmodule;
					$checkboxunproses = 'checkboxunproses'.$idmodule;
					$checkboxcetak = 'checkboxcetak'.$idmodule;
					
					echo "<td width='100px'> <input type='checkbox' id=$checkboxpakai name=$checkboxpakai value='".$k['pakai']."'".$pakai."></td>";
					echo "<td width='100px'> <input type='checkbox' id=$checkboxtambah name=$checkboxtambah value='".$k['tambah']."'".$tambah."></td>";
					echo "<td width='100px'> <input type='checkbox' id=$checkboxedit name=$checkboxedit value='".$k['edit']."'".$edit."></td>";
					echo "<td width='100px'> <input type='checkbox' id=$checkboxhapus name=$checkboxhapus value='".$k['hapus']."'".$hapus."></td>";
					echo "<td width='100px'> <input type='checkbox' id=$checkboxproses name=$checkboxproses value='".$k['proses']."'".$proses."></td>";
					echo "<td width='100px'> <input type='checkbox' id=$checkboxunproses name=$checkboxunproses value='".$k['unproses']."'".$unproses."></td>";
					echo "<td width='100px'> <input type='checkbox' id=$checkboxunproses name=$checkboxcetak value='".$k['cetak']."'".$cetak."></td>";
					
				}
				echo "</table>";
				
				echo "<label>&nbsp;</label>
						<button type='submit' class='btn btn-primary'>Simpan</button>
						<input button type='Button' class='btn btn-danger' value='Batal' onClick='history.back()'/>					
			</form>";
		}
		if($_GET['tipe']=='tambah'){
			echo "<font face='calibri'>
			<h3>Tambah Data User</h3>
        <form method='post' enctype='multipart/form-data' action='module/user/proses_tambah.php'>
				<table style=font-size:13px; class='table table-striped table table-bordered'>
				<tr><td>User Name</td> <td>  <input type='text' class='form-control' name='username' size='100' autofocus required></td></tr>
				<tr><td>Nama Lengkap</td> <td>  <input type='text' class='form-control' name='nama_lengkap' size='100' required></td></tr>
				<tr><td>Password</td> <td>  <input type=password class='form-control' name='password' size='100'></td></tr>
				<tr><td>Email</td> <td>  <input type='text' class='form-control' name='email' size='100'></td></tr>
				<tr><td>Telp</td> <td>  <input type='text' class='form-control' name='telp' size='100'></td></tr>
				<tr><td>Level</td> <td>  <select name=level class='form-control' required>
      		<option value='ADMINISTRATOR'> ADMINISTRATOR</option>
          <option value='ADMIN'> ADMIN</option>
					<option value='GUEST'> GUEST</option>
          </select></td></tr>
        <tr><td>Photo</td><td><input type='file' name='photo' id='photo'>";
				echo "<tr><td>Aktif</td> <td> <input type=radio name='aktif' value='Y' checked> Y   
                                        <input type=radio name='aktif' value='N'> N </td></tr></table>
				<label>&nbsp;</label>
				<button type='submit' class='btn btn-primary'>Simpan</button>
				<input button type='Button' class='btn btn-danger' value='Batal' onClick='history.back()'/>
        </form></font>";

    }elseif($_GET['tipe']=='edit'){
      $sql=mysqli_query($connect,"select * from user where id='$_GET[id]'");
      $de=mysqli_fetch_assoc($sql);?>
      <font face='calibri'>
	      <h3>Edit Data User</h3>
        <form method='POST' enctype='multipart/form-data' action='module/user/proses_edit.php'>
        <input type='hidden' name='id' value='<?= $de['id'] ?>'/>
        <input type='hidden' name='photolama' value='<?= $de['photo']?>'/>
				<table style=font-size:13px; class='table table-striped table table-bordered'>
				<tr><td>User Name</td> <td>  <input type='text' class='form-control' name='username' size='100' value='<?= $de['username'] ?>' readonly></td></tr>
				<tr><td>Password</td> <td>   <input type=password class='form-control' name='password' size='100'></td></tr>
				<tr><td>Nama Lengkap</td> <td>  <input type='text' class='form-control' name='nama_lengkap' size='100' value='<?= $de['nama_lengkap'] ?>' autofocus></td></tr>
				<tr><td>Email</td> <td>  <input type='text' class='form-control' name='email' size='100' value='<?= $de['email'] ?>'></td></tr>
				<tr><td>Telpon</td> <td>  <input type='text' class='form-control' name='telp' size='100' value='<?= $de['telp'] ?>'></td></tr>
				<tr><td>Photo</td> <td>  <input type='file' class='form-control' name='photo'></td></tr>
				<?php
				echo "<td><img src='photo/$de[photo]' width='50></td></tr>
				<input type='hidden' name='x' id='x' value='$de[photo]'>";
				echo "<tr><td>Level</td> <td> ";					
				echo "<select name=level class='form-control'>";
				/*<?php**/
				$level=array("ADMINISTRATOR","USER","GUEST");
				$jlh_bln=count($level);
				for($c=0; $c<$jlh_bln; $c+=1){
					if ($level[$c]==$de[level]){
						echo "<option value=$level[$c] selected>$level[$c] </option>";
					}else{
						echo "<option value=$level[$c]> $level[$c] </option>";
					}
				}
				/*?>**/
				echo "</select>";
				
				if ("$de[aktif]"=='N') {
				  echo "<tr><td>Aktif</td><td> : <input type=radio name='aktif' value='Y'> Y 
				  <input type=radio name='aktif' value='N' checked> N </td></tr>";
				}else{
				  echo "<tr><td>Aktif</td><td> : <input type=radio name='aktif' value='Y' checked> Y  
					<input type=radio name='aktif' value='N'> N </td></tr>";
				}	
				if ("$de[login]"=='N') {
				  echo "<tr><td>Login</td><td> : <input type=radio name='login' value='Y'> Y 
				  <input type=radio name='login' value='N' checked> N </td></tr>";
				}else{
				  echo "<tr><td>Login</td><td> : <input type=radio name='login' value='Y' checked> Y  
					<input type=radio name='login' value='N'> N </td></tr>";
				}	

				echo "<tr><td>Salin detail dari User</td> <td>
				<select id='usersalin' name='usersalin' class='form-control'>";
				echo "<option value=''> - PILIH USER - </option>";
				$data = mysqli_query($connect,'select * from user order by username');
				while ($row=mysqli_fetch_array($data))
				{
					echo '<option name="usersalin"  value="'.$row['username'].'">'.$row['username'].'|'.$row['nama_lengkap'].'</option>';
				}
				echo '</select></table>';
				
				echo "<label>&nbsp;</label>
				<button type='submit' class='btn btn-primary'>Simpan</button>
				<input button type='Button' class='btn btn-danger' value='Batal' onClick='history.back()'/>
	    </form></font>";
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
    <div class="panel-heading"><font size="4">MANAJEMEN USER</font></div>
    <div class="panel-body">
	 	<form method='get'>
			<div class="row">
				<?php
					include('hal_get.php')
				?>
				<div class="col-md-4 bg">
					<input type="hidden" name="m" value="user">
					<input type='text' id='kata' name='kata' value="<?= $kata ?>" size='50px' class='form-control' placeholder='USER,NAMA LENGKAP,EMAIL' onkeyup='searchTable()'>
				</div>
				<button type='submit' class='btn btn-primary'>
				<span class='glyphicon glyphicon-search'></span> Cari</button>
				<a class="btn btn-danger" href="?m=user&tipe=tambah">Tambah data</a>
			</div>
		</form>
    </br>
		<div class="box-body table-responsive">
		<table id="example1" class="table table-bordered table-striped">
		<tbody>
      <tr>
      <th width='50'>No.</th>
			<th>User Name</th>
			<th>Nama Lengkap</th>
			<th>Email</th>
			<th>Telp</th>
			<th>Photo</th>
			<th>Level</th>
			<th>Aktif</th>
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
					$tampil = mysqli_query($connect,"SELECT * FROM user order by username desc LIMIT ".$limit_start.",".$limit);
					}
				else{
					$cari = $_GET['kata'];
					$tampil = mysqli_query($connect,"SELECT * FROM user WHERE username like '%$cari%' or nama_lengkap or email  like '%$cari%' LIMIT ".$limit_start.",".$limit);
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
					<td><u><a href='?m=user&tipe=detailh&id=$k[id]'><font color='blue'>$k[username]</font></a></u></td>
					<td>$k[nama_lengkap]</td>
					<td>$k[email]</td>
					<td>$k[telp]</td>
					<td><img src=photo/$k[photo] width='30'></td>
					<td>$k[level]</td>
					<td align='center'>$k[aktif]</td>
          <td align='center' width='200px'>
					<a class='btn btn-primary' href='?m=user&tipe=detail&id=$k[id]'>Detail</a>
          <a class='btn btn-info' href='?m=user&tipe=edit&id=$k[id]'>Edit</a>
          <!--<a class='btn btn-danger' href='module/user/proses_hapus.php?id=$k[id]'
          onClick='return confirm(\"Anda yakin akan menghapus ?\")'>Hapus</a>-->
          <input button type='Button' class='btn btn-danger' value='Hapus' onClick='alert_hapus($k[id])'/>
        </td>
        ";
        $no++;
			}
        ?>
   	</tbody>
		</table>
		<?php
			if (empty($_GET['kata'])){
				$query = mysqli_query($connect,"select count(*) as jumrec from user");
			}else{
				$cari = $_GET['kata'];
				$query = mysqli_query($connect,"select count(*) as jumrec from user WHERE username like '%$cari%' or nama_lengkap or email  like '%$cari%'");
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
			  <li><a href="dashboard.php?m=tbuser&kata=<?= $kata ?>&page=1">First</a></li>
			  <li><a href="dashboard.php?m=tbuser&kata=<?= $kata ?>&page=<?php echo $link_prev; ?>">&laquo;</a></li>
			<?php
			}
			?>
			<!-- LINK NUMBER -->
			<?php
			// Buat query untuk menghitung semua jumlah data
			if (empty($_GET['kata'])){
				$tampil = mysqli_query($connect,"SELECT * FROM user order by username desc ");
				}
			else{
				$cari = $_GET['kata'];
				$tampil = mysqli_query($connect,"SELECT * FROM user WHERE username like '%$cari%' or nama_lengkap or email  like '%$cari%' order by username");
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
			  <li<?php echo $link_active; ?>><a href="dashboard.php?m=tbuser&kata=<?= $kata ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
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
			  <li><a href="dashboard.php?m=tbuser&kata=<?= $kata ?>&page=<?php echo $link_next; ?>">&raquo;</a></li>
			  <li><a href="dashboard.php?m=tbuser&kata=<?= $kata ?>&page=<?php echo $jumlah_page; ?>">Last</a></li>
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
	/*<td><a href='tampil_photo.php?wahyu.jpg' target='blank'>$k[picture]</a></td>
	/*<td><img src='.images/promo/".$k['picture']."' width='100' height='100'></td>**/
    }
    ?>
	<!-- <script src="js/jquery.min.js" type="text/javascript"></script> -->

		<script type="text/javascript"> 
			
			// // Detail User
			// $checkbox=50;
			// function toggledeh(pilih) {
			// 	alert("Hello!");
			// 	for(jumlah=1;jumlah<=$checkbox;jumlah++){
			// 		$checkboxpakai='checkboxpakai'+jumlah;
			// 		checkboxes = document.getElementsByName($checkboxpakai); 
			// 		for(var i=0, n=checkboxes.length;i<n;i++) { checkboxes[i].checked = pilih.checked; } 
			// 	}
			// }
			// function toggle_t(pilih) {
			// 	for(jumlah=1;jumlah<=$checkbox;jumlah++){
			// 		$checkboxtambah='checkboxtambah'+jumlah;
			// 		checkboxes = document.getElementsByName($checkboxtambah); 
			// 		for(var i=0, n=checkboxes.length;i<n;i++) { checkboxes[i].checked = pilih.checked; } 
			// 	}			
			// } 
			// function toggle_e(pilih) {
			// 	for(jumlah=1;jumlah<=$checkbox;jumlah++){
			// 		$checkboxedit='checkboxedit'+jumlah;
			// 		checkboxes = document.getElementsByName($checkboxedit); 
			// 		for(var i=0, n=checkboxes.length;i<n;i++) { checkboxes[i].checked = pilih.checked; } 
			// 	}
			// }
			// function toggle_h(pilih) {
			// 	for(jumlah=1;jumlah<=$checkbox;jumlah++){
			// 		$checkboxhapus='checkboxhapus'+jumlah;
			// 		checkboxes = document.getElementsByName($checkboxhapus); 
			// 		for(var i=0, n=checkboxes.length;i<n;i++) { checkboxes[i].checked = pilih.checked; } 
			// 	}			
			// } 
			// function toggle_p(pilih) {
			// 	for(jumlah=1;jumlah<=$checkbox;jumlah++){
			// 		$checkboxproses='checkboxproses'+jumlah;
			// 		checkboxes = document.getElementsByName($checkboxproses); 
			// 		for(var i=0, n=checkboxes.length;i<n;i++) { checkboxes[i].checked = pilih.checked; } 
			// 	}
			// } 
			// function toggle_u (pilih) {
			// 	for(jumlah=1;jumlah<=$checkbox;jumlah++){
			// 		$checkboxunproses='checkboxunproses'+jumlah;
			// 		checkboxes = document.getElementsByName($checkboxunproses); 
			// 		for(var i=0, n=checkboxes.length;i<n;i++) { checkboxes[i].checked = pilih.checked; } 
			// 	}
			// } 
			// function toggle_c(pilih) {
			// 	for(jumlah=1;jumlah<=$checkbox;jumlah++){
			// 		$checkboxcetak='checkboxcetak'+jumlah;
			// 		checkboxes = document.getElementsByName($checkboxcetak); 
			// 		for(var i=0, n=checkboxes.length;i<n;i++) { checkboxes[i].checked = pilih.checked; } 
			// 	}			
			// } 
		</script>

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
          	$href = "module/user/proses_hapus.php?id=";
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