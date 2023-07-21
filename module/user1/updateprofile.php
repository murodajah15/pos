<font face="calibri">
<h3>Update Profile User</h3>
<?php
    include "./inc/config.php";
	$username = $_SESSION['username'];
    $sql=mysqli_query($connect,"select * from user where username='$username'");
    $de=mysqli_fetch_assoc($sql);

    
    echo "<font face='calibri'>
          <form method='post' action='module/user/editprofile.php'>
          <input type='hidden' name='username' value='$de[username]'/>
          <div class=col-md-3>
            <img src='./img/profile.png' class='img-circle' alt='User Image'>
          </div>
          <div class=col-md-9>
          <table style=font-size:13px; class='table table-striped table table-bordered'>
		  <tr><td>User Name</td> <td><input type=text class='form-control' name='username' value='$de[username]' size='50' disabled></td></tr>
		  <tr><td>Nama Lengkap</td> <td><input type=text class='form-control' name='nama_lengkap' value='$de[nama_lengkap]' size='50' autofocus></td></tr>
		  <tr><td>Email</td> <td><input type=text class='form-control' name='email' value='$de[email]' size='50'></td></tr>
		  <tr><td>Telp/HP</td> <td><input type=text class='form-control' name='telp' value='$de[telp]' size='50'></td></tr></table></div>";
	echo "<div class=col-md-3></div><label>&nbsp;&nbsp;&nbsp;&nbsp;</label>
        <button type='submit' class='btn btn-primary'>Simpan</button>
		<input button type='Button' class='btn btn-danger' value='Batal' onClick='history.back()'/>
    </form></font><br>";
?>