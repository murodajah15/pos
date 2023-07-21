<?php
	include "../../inc/config.php";

	$noopname=$_POST['kode'];
	$query = mysqli_query($connect,"select * from opnameh where noopname='$noopname'");
	$de=mysqli_fetch_assoc($query);
?>
<table style=font-size:13px; class='table table-striped table table-bordered'>
<tr><td>No. Opname</td> <td> <input type=text class='form-control' name='noajukan' value=<?php echo "'$de[noopname]'"?> readonly></td></tr>
<tr><td>Tgl. Opname</td> <td> <input type=text class='form-control' name='tglajukan' value=<?php echo "'$de[tglopname]'"?> readonly></td></tr>
<tr><td>No. Pelaksana</td> <td> <input type=text class='form-control' name='pelaksana' value=<?php echo "'$de[pelaksana]'"?> readonly></td></tr>
<tr><td>Keterangan</td> <td> <textarea type='text' rows='2' class='form-control' name='tahun' readonly><?php echo "$de[keterangan]"?></textarea></td></tr>
<tr><td>Proses</td> <td> <input type=text class='form-control' name='user_input' value=<?php echo "'$de[proses]'"?> readonly></td></tr>
<tr><td>User Input</td> <td> <input type=text class='form-control' name='user_input' value=<?php echo "'$de[user]'"?> readonly></td></tr>
<tr><td>User Proses</td> <td> <input type=text class='form-control' name='user_input' value=<?php echo "'$de[user_proses]'"?> readonly></td></tr>
</table>
