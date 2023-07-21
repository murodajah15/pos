<?php
include "../../inc/config.php";

$kode = $_POST['kode'];
$query = mysqli_query($connect, "select * from user where username='$kode'");
$de = mysqli_fetch_assoc($query);
echo $kode;
?>

<table style=font-size:13px; class='table table-striped table table-bordered'>
	<tr>
		<td>User Name</td>
		<td> <input type=text class='form-control' value=<?php echo "'$de[username]'" ?> readonly></td>
	</tr>
	<tr>
		<td>Nama Lengkap</td>
		<td> <input type=text class='form-control' value=<?php echo "'$de[nama_lengkap]'" ?> readonly></td>
	</tr>
	<tr>
		<td>email</td>
		<td> <input type=text class='form-control' value=<?php echo "'$de[email]'" ?> readonly></td>
	</tr>
	<tr>
		<td>Telpon</td>
		<td> <input type=text class='form-control' value=<?php echo "'$de[telp]'" ?> readonly></td>
	</tr>
	<tr>
		<td>Photo</td>
		<td> <input type=text class='form-control' value=<?php echo "'$de[photo]'" ?> readonly></td>
	</tr>
	<tr>
		<td>Level</td>
		<td> <input type=text class='form-control' value=<?php echo "'$de[level]'" ?> readonly></td>
	</tr>
	<tr>
		<td>Aktif</td>
		<td> <input type=text class='form-control' value=<?php echo "'$de[aktif]'" ?> readonly></td>
	</tr>
	<tr>
		<td>Last Login</td>
		<td> <input type=text class='form-control' value=<?php echo "'$de[last_login]'" ?> readonly></td>
	</tr>
	<tr>
		<td>User</td>
		<td> <input type=text class='form-control' value=<?php echo "'$de[user_input]'" ?> readonly></td>
	</tr>
</table>