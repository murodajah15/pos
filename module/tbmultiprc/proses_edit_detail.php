<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
		include "../../inc/config.php";
		if(!empty($_POST['kdbarang'])){
		//proses simpan
			date_default_timezone_set('Asia/Jakarta');
			//Cek Double
			$user_input = "Update-".$_POST['username']."-".date('d-m-Y H:i:s');
			$harga = strip_tags($_POST['harga']);
			$discount = strip_tags($_POST['discount']);
			$query = $connect->prepare("update tbmultiprc set harga=?,discount=?,user=? where id=?");
			$query->bind_param('sssi',$harga,$discount,$user_input,$_POST['id']);
			if($query->execute() and mysqli_affected_rows($connect)>0){
				?>
				<script>
					swal({title: "Data Berhasil disimpan ", text: "", icon: 
					"success"}).then(function(){window.history.go(-2); //then(function(){window.location.href='../../dashboard.php?m=order_part';
					   }
					);
				</script>
				<?php
			}else{
				// echo "<script>alert('Gagal simpan data !');
				// window.location.href='../../dashboard.php?m=wo';
				// </script>";							
				?>
				<script>
					swal({title: "Gagal simpan data ", text: "", icon: 
					"error"}).then(function(){window.history.go(-2); //then(function(){window.location.href='../../dashboard.php?m=order_part';
					   }
					);
				</script>
				<?php
			}		
		}else{
			?>
			<script>
				swal({title: "Gagal simpan data ", text: "", icon: 
				"error"}).then(function(){window.history.go(-2); //then(function(){window.location.href='../../dashboard.php?m=order_part';
				   }
				);
			</script>
			<?php		
		}
	?>

	<script>
	<?php
	//pembuatan fungsi
	function hit_total($connect,$noorder,$ppn)
	{
		global $nsubtotal;
		include "../../inc/config.php";
		$tampil = mysqli_query($connect,"select sum(subtotal) as nsubtotal from order_partd where noorder='$noorder'");
		$de = mysqli_fetch_assoc($tampil);
		$nsubtotal = $de['nsubtotal'];
		$nppn = $nsubtotal * ($ppn/100);
		$ntotal = $nsubtotal - $nppn;
		return $ntotal;
	}
	?>
	</script>
	
</body>
