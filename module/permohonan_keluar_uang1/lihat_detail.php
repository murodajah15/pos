<?php
	include "../../inc/config.php";

	$nomohon=$_POST['kode'];
	$query = mysqli_query($connect,"select * from mohklruangh where nomohon='$nomohon'");
	$de=mysqli_fetch_assoc($query);
	$jnkeluar = strip_tags($de['kdjnkeluar'].' | '.$de['nmjnkeluar']);
	$bank = strip_tags($de['kdbank'].' | '.$de['nmbank']);
	$jnskartu = strip_tags($de['kdjnskartu'].' | '.$de['nmjnskartu']);
?>
<table style=font-size:13px; class='table table-striped table table-bordered'>
<tr><td>No. Permohonan</td> <td> <input type=text class='form-control' name='noajukan' value=<?php echo "'$de[nomohon]'"?> readonly></td></tr>
<tr><td>Tgl. Permohonan</td> <td> <input type=text class='form-control' name='tglajukan' value=<?php echo "'$de[tglmohon]'"?> readonly></td></tr>
<tr><td>Jenis Pengeluaran</td> <td> <input type=text class='form-control' name='tglajukan' value=<?php echo "$jnkeluar"?> readonly></td></tr>
<tr><td>Cara Bayar<br>(M/D/Y)</br></td> <td> <input type="text" class='form-control' name='carabayar' size='50' value='<?=$de['carabayar']?>'></td></tr>
<tr><td>Bank<br>(M/D/Y)</br></td> <td> <input type="text" class='form-control' name='carabayar' size='50' value='<?=$bank?>'></td></tr>
<tr><td>Bank<br>(M/D/Y)</br></td> <td> <input type="text" class='form-control' name='carabayar' size='50' value='<?=$jnskartu?>'></td></tr>
<tr><td>Tempo (Hari)</td> <td> <input type="number" class='form-control' name='tempo' value='<?=$tempo?>' size='50'></td></tr>
<tr><td>Tanggal Jatuh Tempo<br>(M/D/Y)</br></td> <td> <input type="date" class='form-control' name='tgl_jt_tempo' value='<?=$de['tgl_jt_tempo']?>' size='50'></td></tr>
<tr><td>Subtotal</td> <td> <input type="number" class='form-control' id='ppn' name='ppn' size='50' value='<?= $de['subtotal'] ?>' readonly></td></tr>
<tr><td>Materai</td> <td> <input type="number" class='form-control' name='materai' size='50' value='<?= $de['materai'] ?>'></td></tr>							
<tr><td>Total</td> <td> <input type="number" class='form-control' name='total' size='50' value='<?= $de['total'] ?>' readonly></td></tr>
<tr><td>Keterangan</td> <td> <textarea type='text' rows='2' class='form-control' name='tahun' readonly><?php echo "$de[keterangan]"?></textarea></td></tr>
<tr><td>Proses</td> <td> <input type=text class='form-control' name='user_input' value=<?php echo "'$de[proses]'"?> readonly></td></tr>
<tr><td>User Input</td> <td> <input type=text class='form-control' name='user_input' value=<?php echo "'$de[user]'"?> readonly></td></tr>
<tr><td>User Proses</td> <td> <input type=text class='form-control' name='user_input' value=<?php echo "'$de[user_proses]'"?> readonly></td></tr>
</table>
