<font face="calibri">
<div class="panel panel-info">
<div class="panel-heading"><font size="4">UPDATE PASSWORD</font></div>
<div class="panel-body">
	<?php
    include "./inc/config.php";
	$username = $_SESSION['username'];
    $sql=mysqli_query($connect,"select * from user where username='$username'");
    $de=mysqli_fetch_assoc($sql);

    echo "<font face='calibri'>
          <form method='post' action='module/user/editpass.php'>
          <input type='hidden' name='id' value='$de[username]'/>
          <table style=font-size:13px; class='table table-striped table table-bordered'>
		  <tr><td>User Name</td> <td><input type=text class='form-control' name='username' value='$de[username]' size='50' disabled></td></tr>
		  <tr><td>Password Lama</td> <td><input type=password class='form-control' name='password_lama' size='50' autofocus></td></tr>
		  <tr><td>Password Baru</td> <td><input type=password class='form-control' name='password_baru' size='50'></td></tr>
		  <tr><td>Konfirmasi</td> <td><input type=password class='form-control' name='konfirmasi_password' size='50'></td></tr></table>";
	echo "<label>&nbsp;</label>";
	?>
	<button type='submit' class='btn btn-primary'>Simpan</button>
	<input button type='Button' class='btn btn-danger' value='Batal' onClick="window.location.href='./dashboard.php'"/> 
</div></div></form></font>


<!--'history.back()'/>

