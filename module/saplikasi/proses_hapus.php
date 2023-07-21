<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
		include "../../inc/config.php";
		//proses hapus
		// $sql=mysqli_query($connect,"delete from saplikasi where id='$_GET[id]'");
		// if ($sql>0) {
		// 	echo "<script>alert('Berhasil dihapus !');history.go(-1);</script>";
		// }else{
		// 	echo "<script>alert('Gagal hapus data !');history.go(-1);</script>";
		// }
	  $sql=mysqli_query($connect,"select * from saplikasi where id='$_GET[id]'");
	  $de=mysqli_fetch_assoc($sql);		
		$query = $connect->prepare("delete from saplikasi where id=?");
		$query->bind_param('i',$_GET['id']);
		if($query->execute()){
			// echo "<script>alert('Data berhasil dihapus !');
			// window.location.href='../../dashboard.php?m=saplikasi';
			// </script>";				
			/*header("location:../../dashboard.php?m=tbkota");**/
			$dir = '../../img/';
			if (is_dir($dir)){
				$target = '../../img/'.$de['logo'];
			}else{
				$target = '../img/'.$de['logo'];
			}
			if (file_exists($target)) {
				unlink($target);
			}			
			?>
			<script>
				swal({title: "Data berhasil dihapus", text: "", icon: 
				"success"}).then(function(){window.history.back(); //window.location.href='../../dashboard.php?m=tbbank';
				   }
				);
			</script>
			<?php
		}else{
			// echo "<script>alert('Gagal hapus data !');
			// window.location.href='../../dashboard.php?m=saplikasi';
			// </script>";	
									?>
			<script>
				swal({title: "Gagal hapus data", text: "", icon: 
				"error"}).then(function(){window.history.back(); //window.location.href='../../dashboard.php?m=tbbank';
				   }
				);
			</script>
			<?php
		}	
		//header("location:../../dashboard.php?m=tbmodel");
	?>
</body>