<?php
	if ($_SESSION['level']=='ADMINISTRATOR'){
		$aksesok = 'Y';
	}else{
		$d1=mysqli_fetch_assoc($sql);
		if (mysqli_num_rows($sql)>0 and $d1['pakai']=='1') {
			$kelompok = $_SESSION['level'];
			$aksesok = 'Y';
		}else{
			$aksesok = 'N';
		}
	}
?>
