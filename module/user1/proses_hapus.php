<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
		include "../../inc/config.php";
		//proses simpan
	  $sql=mysqli_query($connect,"select * from user where id='$_GET[id]'");
	  $de=mysqli_fetch_assoc($sql);			
		$query = $connect->prepare("delete from user where id=?");
		$query->bind_param('s',$_GET['id']);
		if($query->execute() and mysqli_affected_rows($connect)>0){
			$dir = '../../photo/';
				if (is_dir($dir)){
					$target = '../../photo/'.$de['photo'];
				}else{
					$target = '../photo/'.$de['photo'];
				}
				if (file_exists($target)) {
					unlink($target);
				}			
			?>
			<script>
				swal({title: "Data berhasil dihapus", text: "", icon: 
				"success"}).then(function(){window.history.back(); //window.location.href='../../dashboard.php?m=mst_rekening';
				   }
				);
			</script>
			<?php
		}else{
			?>
			<script>
				swal({title: "Gagal hapus data", text: "", icon: 
				"error"}).then(function(){window.history.back(); //window.location.href='../../dashboard.php?m=mst_rekening';
				   }
				);
			</script>
			<?php
		}
	?>
</body>