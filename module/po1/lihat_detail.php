<?php
	include "../../inc/config.php";

	$nopo=$_POST['kode'];
	$query = mysqli_query($connect,"select * from poh where nopo='$nopo'");
	$de=mysqli_fetch_assoc($query);
	$supplier = strip_tags($de['kdsupplier'].' | '.$de['nmsupplier']);
?>
<table style=font-size:13px; class='table table-striped table table-bordered'>
<tr><td>No. PO</td> <td> <input type=text class='form-control' name='noajukan' value=<?php echo "'$de[nopo]'"?> readonly></td></tr>
<tr><td>Tgl. PO</td> <td> <input type=text class='form-control' name='tglajukan' value=<?php echo "'$de[tglpo]'"?> readonly></td></tr>
<tr><td>No. Referensi</td> <td> <input type=text class='form-control' name='nopolisi' value=<?php echo "'$de[noreferensi]'"?> readonly></td></tr>
<tr><td>Kode Supplier</td> <td> <input type=text class='form-control' name='norangka' value=<?php echo "'$supplier'"?> readonly></td></tr>
<tr><td>Jenis Order</td> <td> <input type=text class='form-control' name='jenis_order' value=<?php echo "'$de[jenis_order]'"?> readonly></td></tr>
<tr><td>Biaya Lain</td> <td> <input type=text class='form-control' name='biaya_lain' value=<?php echo "'$de[biaya_lain]'"?> readonly></td></tr>
<tr><td>Keterangan Biaya Lain</td> <td> <input type=text class='form-control' name='ket_biaya_lain' value=<?php echo "'$de[ket_biaya_lain]'"?> readonly></td></tr>
<tr><td>Tanggal Kirim<br>(M/D/Y)</br></td> <td> <input type="date" class='form-control' name='tglkirim' size='50' value='<?=$de['tglkirim']?>'></td></tr>
<tr><td>Cara Bayar<br>(M/D/Y)</br></td> <td> <input type="date" class='form-control' name='carabayar' size='50' value='<?=$de['carabayar']?>'></td></tr>
<tr><td>Tempo (Hari)</td> <td> <input type="number" class='form-control' name='tempo' value='<?=$tempo?>' size='50'></td></tr>	
<tr><td>Tanggal Jatuh Tempo<br>(M/D/Y)</br></td> <td> <input type="date" class='form-control' name='tgl_jt_tempo' value='<?=$de['tgl_jt_tempo']?>' size='50'></td></tr>
<tr><td>Subtotal</td> <td> <input type="number" class='form-control' id='ppn' name='ppn' size='50' value='<?= $de['subtotal'] ?>' readonly></td></tr>
<tr><td>Total Sementara</td> <td> <input type="number" class='form-control' id='ppn' name='ppn' size='50' value='<?= $de['total_sementara'] ?>' readonly></td></tr>
<tr><td>PPn</td> <td> <input type="number" class='form-control' name='ppn' size='50' value='<?= $de['ppn'] ?>'></td></tr>
<tr><td>Materai</td> <td> <input type="number" class='form-control' name='materai' size='50' value='<?= $de['materai'] ?>'></td></tr>							
<tr><td>Total</td> <td> <input type="number" class='form-control' name='total' size='50' value='<?= $de['total'] ?>' readonly></td></tr>
<tr><td>Keterangan</td> <td> <textarea type='text' rows='2' class='form-control' name='tahun' readonly><?php echo "$de[keterangan]"?></textarea></td></tr>
<tr><td>Proses</td> <td> <input type=text class='form-control' name='user_input' value=<?php echo "'$de[proses]'"?> readonly></td></tr>
<tr><td>User Input</td> <td> <input type=text class='form-control' name='user_input' value=<?php echo "'$de[user]'"?> readonly></td></tr>
<tr><td>User Proses</td> <td> <input type=text class='form-control' name='user_input' value=<?php echo "'$de[user_proses]'"?> readonly></td></tr>
</table>
