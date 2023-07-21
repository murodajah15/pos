<?php

    if(isset($_GET['tipe'])){
        if($_GET['tipe']=='export'){
			echo $_GET['bulan'];?>
					<font face='calibri'>
					<h3>Export Data Tunjangan Kinerja </h3>
					<form method='post' enctype='multipart/form-data' action='module/tunjangan/proses_import.php'>
					<input type='hidden' name='username' value=$user>
					<input type='hidden' name='nourut' value=$_SESSION[nourut]>
					Pilih File Excel*: <input name='fileexcel' type='file' accept='application/vnd.ms-excel'></br> <!--<input name='upload' type='submit' value='Import'>-->
					<label>&nbsp;</label>
								<button type='submit' class='btn btn-primary' name='upload' value='import'>Import</button>
								<input button type='Button' class='btn btn-danger' value='Selesai' onClick='history.back()'/>
					</form></font><?php
		}else{
			echo "<script>alert('Anda tidak berhak !');history.go(-1) </script>";
		}
    }else{
?>
	
	<font face="calibri">
		<h3>Export Data Tunjangan Kinerja (format txt)</h3>
		<hr size="10px">
		<form method='POST'> <!--action="$_SERVER[PHP_SELF]"-->
			<input type="submit" value="Tampilkan Data" name="cari">
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-md-4">
						Bulan
						<!--<select name="bulan" id="bulan" class="form-control" required="required">
							<option value="">PILIH BULAN</option>
							<option value="Januari">Januari</option>
							<option value="Februari">Februari</option>
							<option value="Maret">Maret</option>
							<option value="April">April</option>
							<option value="Mei">Mei</option>
							<option value="Juni">Juni</option>
							<option value="Juli">Juli</option>
							<option value="Agustus">Agustus</option>
							<option value="September">September</option>
							<option value="Oktober">Oktober</option>
							<option value="November">November</option>
							<option value="Desember">Desember</option>
					   </select>									-->
						
						<?php
							echo "<select name='bulan' id='bulan' class='form-control' required='required'>
							<option value=''>PILIH BULAN</option>
							<option value='Januari'>Januari</option>
							<option value='Februari'>Februari</option>
							<option value='Maret'>Maret</option>
							<option value='April'>April</option>
							<option value='Mei'>Mei</option>
							<option value='Juni'>Juni</option>
							<option value='Juli'>Juli</option>
							<option value='Agustus'>Agustus</option>
							<option value='September'>September</option>
							<option value='Oktober'>Oktober</option>
							<option value='November'>November</option>
							<option value='Desember'>Desember</option>
							</select>";														
							
							if(isset($_POST['cari'])){
								$bulan=$_POST['bulan'];
								echo "<script> alert($bulan) </script>";
							}
							
						?>
					</div>
				</div>
			</div>
		</form>
		<br>
	</font>
<?php
    }
?>

