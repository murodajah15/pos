<?php
	include("./inc/config.php");

	$nip=$_POST['nip'];
	$query = mysqli_query($connect,"select * from mst_pegawai where nip='$nip'");
	$de=mysqli_fetch_assoc($query);
?>
<table style=font-size:13px; class='table table-striped table table-bordered'>
<tr><td>NIP</td> <td>  <input type=text class='form-control' name='nip' value=<?php echo "'$de[nip]'"?> readonly></td></tr>
<tr><td>Nama Pegawai</td> <td>  <input type=text class='form-control' name='nama_alias' value=<?php echo "'$de[nama_alias]'"?> readonly></td></tr>
<tr><td>NPWP</td> <td>  <input type=text class='form-control' name='npwp' value=<?php echo "'$de[npwp]'"?> readonly></td></tr>
<tr><td>Status (PNS/CPNS) </td> <td>  <input type=text class='form-control' name='nama' value=<?php echo "'$de[status]'"?> readonly></td></tr>
<tr><td>Kode Satuan Kerja</td> <td>  <input type=text class='form-control' name='kdgrade' value=<?php echo "'$de[kdsatker]'"?> readonly></td></tr>
<tr><td>Nama Satuan Kerja</td> <td>  <input type=text class='form-control' name='nmgrade' value=<?php echo "'$de[nmsatker]'"?> readonly></td></tr>
<tr><td>Kode Eselon</td> <td>  <input type=text class='form-control' name='kdeselon' value=<?php echo "'$de[kdeselon]'"?> readonly></td></tr>
<tr><td>Nama Nama Eselon</td> <td>  <input type=text class='form-control' name='nmgeselon' value=<?php echo "'$de[nmeselon]'"?> readonly></td></tr>						
<tr><td>Golongan</td> <td>  <input type=text class='form-control' name='kdgrade' value=<?php echo "'$de[golongan]'"?> readonly></td></tr>
<tr><td>Kelas Jabatan</td> <td>  <input type=text class='form-control' name='kelas_jabatan' value=<?php echo "'$de[kelas_jabatan]'"?> readonly></td></tr>
<tr><td>Tunjangan Kinerja</td> <td>  <input type=text class='form-control' name='tukin' value=<?php echo "'$de[tukin]'"?> readonly></td></tr>
<tr><td>Pangkat</td> <td>  <input type=text class='form-control' name='nmgrade' value=<?php echo "'$de[pangkat]'"?> readonly></td></tr>						
<tr><td>Jabatan</td> <td>  <input type=text class='form-control' name='nmgrade' value=<?php echo "'$de[jabatan]'"?> readonly></td></tr>	
<tr><td>No. Rekening</td> <td>  <input type=text class='form-control' name='nmgrade' value=<?php echo "'$de[norek]'"?> readonly></td></tr>	
<tr><td>Bank</td> <td>  <input type=text class='form-control' name='nmgrade' value=<?php echo "'$de[bank]'"?> readonly></td></tr>	
<tr><td>Nama Rekening</td> <td>  <input type=text class='form-control' name='nama' value=<?php echo "'$de[nama]'"?> readonly></td></tr>
<tr><td>Aktif</td> <td>  <input type=text class='form-control' name='aktif' value=<?php echo "'$de[aktif]'"?> readonly></td></tr>
<tr><td>User Input</td> <td>  <input type=text class='form-control' name='user_input' value=<?php echo "'$de[user_input]'"?> readonly></td></tr>
</table>