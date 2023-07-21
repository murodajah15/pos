<?php
	include 'cek_akses.php';
?>
<?php
	if ($aksesok == 'Y') {
?>
<font face="calibri">
	<h3>Export Data Tunjangan Kinerja (format txt)</h3>
	<hr size="10px">
	<form method='post' action='report/proses_export_txt.php'> <!--target='_blank'-->
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-md-4">
					Bulan
					<select class='form-control id='bulan' name='bulan' required>";
					<?php
						$bulan=array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
						$jlh_bln=count($bulan);
						echo "<option value=''>- PILIH BULAN -</option>";
						for($c=0; $c<$jlh_bln; $c+=1){
							echo "<option value=$bulan[$c]> $bulan[$c] </option>";
						}
						/*?>**/
						echo "</select>";
							
						echo "Tahun";
						$now=date('Y');
						$mundur = $now - 7;
						echo "<td width='100'><select class='form-control' name='tahun' required>";
						echo "<option value=''>- PILIH TAHUN -</option>";
						for ($a=$mundur;$a<=$now;$a++) {
							echo "<option value='$a'>$a</option>";
						}
						echo "<hr size='12px'></hr>";
						echo "</br></select></tr>";	
						
						if (($_SESSION['level']=='ADMINISTRATOR') or ($_SESSION['level']=='ESELON')) {
							echo "<tr><td>Satuan Kerja</td>
								<td><select id='kdsatker' name='kdsatker' class='form-control' style='width: 200x;' onchange='changeValueSatker(this.value)'>
								<option value=''> - PILIH SATUAN KERJA - </option>";
								$jsArraySatker = "var prdNameSatker = new Array();\n";
								$data = mysqli_query($connect,'select * from tbsatker order by kode');
								while ($row=mysqli_fetch_array($data)) {
									if ($row['kode']==$de['kdsatker']) {
										echo "<option value=$row[kode] selected>$row[kode]|$row[nama] </option>";
									}else{
										echo '<option name="kdsatker"  value="'.$row['kode'].'">'.$row['kode'].'|'.$row['nama'].'</option>';
									}
									$jsArraySatker .= "prdNameSatker['" . $row['kode'] . "'] = {kdsatker:'" . addslashes($row['kode']) ."',nmsatker:'".addslashes($row['nama'])."'};\n";
								}
							echo '</select>';
						}
							
						if ($_SESSION['level']=='ADMINISTRATOR') {
							echo "<tr><td>Eselon</td>
							<td><select id='kdeselon' name='kdeselon' class='form-control' style='width: 200x;' onchange='changeValueEselon(this.value)'>
							<option value=''> - PILIH ESELON - </option>";
							$jsArrayEselon = "var prdNameEselon = new Array();\n";
							$data = mysqli_query($connect,'select * from tbeselon order by kode');
							while ($row=mysqli_fetch_array($data))
							{
								echo '<option name="kdeselon"  value="'.$row['kode'].'">'.$row['kode'].'|'.$row['nama'].'</option>';
								$jsArrayEselon .= "prdNameEselon['" . $row['kode'] . "'] = {kdeselon:'" . addslashes($row['kode']) ."',eselon:'".addslashes($row['nama'])."'};\n";
							}
							echo '</select>';
						}
						echo "<br><button type='submit' class='btn btn-success'>Export Data</button>";
					?>
				</div>
				<?php
					if (isset($_GET['bulan'])){
						echo "<script>alert('test')</script>";
					}
				?>
				
				<!--<div class="col-xs-12 col-md-6">
					<button type='submit' name='btntampilkan' class='btn btn-primary' href='dashboard.php?m=export_data'>
					<span class='glyphicon glyphicon-search' ></span> Tampilkan Data</button>
				
					<div class="table-responsive">
						<table class="table table-bordered table-striped table-hover">
							<tr>
								<th width='50'>No.</th>
								<th>No. Urut</th>
								<th>Bulan</th>
								<th>Tahun</th>
								<th>Keterangan</th>
							</tr>
							<?php
								// $no=1;
								// $tampil = mysqli_query($connect,'select * from tunjanganh');
								// while($k=mysqli_fetch_assoc($tampil)){
									// echo "<tr>
										// <td align='center'>$no</td>
										// <td><u><a href='?m=rek_pembayaran&tipe=detailh&id=$k[id]'><font color='blue'>$k[nourut]</font></a></u></td>
										// <td>$k[bulan]</td>
										// <td>$k[tahun]</td>
										// <td>$k[keterangan]</td>";
									// $no++;
								// }
							?>
						</table>
					</div>
				</div>-->
			</div>
		</div>
	</form>
	<br>
</font>
<?php
}else{
	echo "<font color='red'>Anda tidak punya hak !</font>";
}
?>