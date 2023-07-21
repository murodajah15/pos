<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
   	<?php
		include "../../inc/config.php";
		$query = $connect->prepare("delete from tbmultiprc where kdcustomer=?");
		$query->bind_param('s',$_GET['id']);
		if($query->execute()){
			$data = mysqli_query($connect,"select kode,nama,harga_jual from tbbarang");
			while ($row=mysqli_fetch_array($data)) {
				$user_input = "Salin-"."-".date('d-m-Y H:i:s');
				$kdcustomer = $_GET['id'];
				$kdbarang = strip_tags($row['kode']);
				$nmbarang = strip_tags($row['nama']);
				$harga = $row['harga_jual'];
				$query = $connect->prepare("INSERT INTO tbmultiprc (kdcustomer,kdbarang,nmbarang,harga,user) values (?,?,?,?,?)");
				$query->bind_param('sssis',$kdcustomer,$kdbarang,$nmbarang,$harga,$user_input);
				if($query->execute() and mysqli_affected_rows($connect)>0){
				}
			}
			?>
			<script>
				swal({title: "Data berhasil disalin", text: "", icon: 
				"success"}).then(function(){window.history.back(); //window.location.href='../../dashboard.php?m=wo';
				   }
				);
			</script>
			<?php
		}else{
			// echo "<script>alert('Gagal hapus data !');
			// window.location.href='../../dashboard.php?m=wo';
			// </script>";				
			?>
			<script>
				swal({title: "Gagal salin data", text: "", icon: 
				"error"}).then(function(){window.history.back(); //window.location.href='../../dashboard.php?m=wo';
				   }
				);
			</script>
			<?php
		}		
		//header("location:../../dashboard.php?m=wo");	
	?>
</body>
