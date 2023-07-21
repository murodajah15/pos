<?php
	include "../../inc/config.php";

	$noterima=$_POST['kode'];
	$query = mysqli_query($connect,"select * from terimah where noterima='$noterima'");
	$de=mysqli_fetch_assoc($query);
?>
<table style=font-size:13px; class='table table-striped table table-bordered'>
<tr><td>No. Terima</td> <td> <input type=text class='form-control' name='noajukan' value=<?php echo "'$de[noterima]'"?> readonly></td></tr>
<tr><td>Tgl. Terima</td> <td> <input type=text class='form-control' name='tglajukan' value=<?php echo "'$de[tglterima]'"?> readonly></td></tr>
<tr><td>No. Referensi</td> <td> <input type=text class='form-control' name='nopolisi' value=<?php echo "'$de[noreferensi]'"?> readonly></td></tr>
<tr><td>Tgl. Dokumen</td> <td> <input type=text class='form-control' name='nopolisi' value=<?php echo "'$de[tgldokumen]'"?> readonly></td></tr>
<tr><td>Jenis Transaksi</td> <td> <input type=text class='form-control' name='nopolisi' value=<?php echo "'$de[kdjntrans]'"?> readonly></td></tr>
<tr><td>Penerima</td> <td> <input type=text class='form-control' name='nopolisi' value=<?php echo "'$de[penerima]'"?> readonly></td></tr>
<tr><td>Gudang</td> <td> <input type=text class='form-control' name='jenis_order' value=<?php echo "'$de[kdgudang]'"?> readonly></td></tr>
<tr><td>Biaya Lain</td> <td> <input type=text class='form-control' name='biaya_lain' value=<?php echo "'$de[biaya_lain]'"?> readonly></td></tr>
<tr><td>Keterangan</td> <td> <textarea type='text' rows='2' class='form-control' name='tahun' readonly><?php echo "$de[keterangan]"?></textarea></td></tr>
<tr><td>Proses</td> <td> <input type=text class='form-control' name='user_input' value=<?php echo "'$de[proses]'"?> readonly></td></tr>
<tr><td>User Input</td> <td> <input type=text class='form-control' name='user_input' value=<?php echo "'$de[user]'"?> readonly></td></tr>
<tr><td>User Proses</td> <td> <input type=text class='form-control' name='user_input' value=<?php echo "'$de[user_proses]'"?> readonly></td></tr>
</table>
