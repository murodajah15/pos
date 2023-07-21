<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
	include "../../inc/config.php";
	//proses hapus
	session_start();
	date_default_timezone_set('Asia/Jakarta');
	$id = $_POST['id'];
	$user = $_SESSION['username'];
	$user_proses = "Batal Proses-" . $user . "-" . date('d-m-Y H:i:s');
	$tglselesai = date('');
	$proses = 'N';
	$tampil = mysqli_query($connect, "select * from jualh where id='$id'");
	$de = mysqli_fetch_assoc($tampil);
	$nojual = $de['nojual'];
	$tgljual = $de['tgljual']; //'00-00-0000';
	$kurangbayar = '0'; //$de['total'] - $de['sudahbayar'];

	if ($de['proses'] == 'N' or $de['sudahbayar'] > 0) {
		if ($de['sudahbayar'] > 0) {
			$text = "Dokumen " . $nojual . " Sudah ada pembayaran !";
		}
		if ($de['proses'] == 'N') {
			$text = "Dokumen " . $nojual . " Sudah di batal proses !";
		}
	?>
		<script>
			swal({
				title: "Gagal batal proses data",
				text: "<?= $text ?>",
				icon: "error"
			}).then(function() {
				window.history.back(); //window.location.href='../../dashboard.php?m=jual';
			});
		</script>
	<?php
		$lanjut = 0;
		exit();
	}

	$cek = mysqli_fetch_assoc(mysqli_query($connect, "select * from saplikasi where aktif='Y'"));
	$closing_hpp = $cek['closing_hpp'];
	$bulan = substr($tgljual, 5, 2);
	$tahun = substr($tgljual, 0, 4);
	$periode = $tahun . $bulan;
	//echo $periode;
	if ($periode <= $closing_hpp) {
		echo 'Closing terakhir : ' . $closing_hpp;
	?>
		<script>
			swal({
				title: "Gagal Batal Proses !",
				text: "Sudah Closing Data Bulanan !",
				icon: "success"
			}).then(function() {
				window.history.back(); //then(function(){window.location.href='../../dashboard.php?m=wo';
			});
		</script>
	<?php
		exit();
	}
	$query = $connect->prepare("update jualh set kurangbayar=?,proses=?,user_proses=? where id=?");
	$query->bind_param('issi', $kurangbayar, $proses, $user_proses, $id);
	if ($query->execute() and mysqli_affected_rows($connect) > 0) {
		//Update prosed detail
		mysqli_query($connect, "update juald set proses='$proses',tgljual='$tgljual' where nojual='$nojual'");
		$tampil = mysqli_query($connect, "select * from jualh where id=$id");
		$de = mysqli_fetch_assoc($tampil);
		$nojual = $de['nojual'];
		$tampil = mysqli_query($connect, "select * from juald where nojual='$nojual'");
		while ($k = mysqli_fetch_assoc($tampil)) {
			$qty = $k['qty'];
			$id = $k['id'];
			$kdbarang = $k['kdbarang'];
			$noso = $k['noso'];
			$query = mysqli_query($connect, "select qty,terima from sod where noso='$noso' and kdbarang='$kdbarang'");
			$de = mysqli_fetch_assoc($query);
			$qtypesan = $de['qty'];
			$qtysdhterima = $de['terima'];
			$terima = $qtysdhterima - $qty;
			$kurang = $qtypesan -  $terima;
			$query = $connect->prepare("update sod set terima=?,kurang=? where noso=? and kdbarang=?");
			$query->bind_param('ssss', $terima, $kurang, $noso, $kdbarang);
			if ($query->execute() and mysqli_affected_rows($connect) > 0) {
				$query = $connect->prepare("update soh set terima=? where noso=?");
				$query->bind_param('ss', $proses, $noso);
				if ($query->execute() and mysqli_affected_rows($connect) > 0) {
				}
			}
			mysqli_query($connect, "update tbbarang set stock=stock+$qty where kode='$kdbarang'");
			mysqli_query($connect, "update stock_barang set keluar=keluar-$qty,akhir=awal+masuk-keluar,nilai_akhir=akhir*hpp_akhir where kdbarang='$kdbarang' and periode='$periode'");
		}
		$cek = mysqli_query($connect, "select sum(kurang) as kurang from sod where noso='$noso'");
		$de = mysqli_fetch_assoc($cek);
		if ($de['kurang'] > 0) {
			$query = $connect->prepare("update soh set terima=? where noso=?");
			$query->bind_param('ss', $proses, $noso);
			if ($query->execute() and mysqli_affected_rows($connect) > 0) {
			}
		}
	?>
		<script>
			swal({
				title: "Data berhasil di Batal Proses",
				text: "",
				icon: "success"
			}).then(function() {
				window.history.back(); //window.location.href='../../dashboard.php?m=jual';
			});
		</script>
	<?php
		//Create History
		$tanggal = date('Y-m-d');
		$datetime = date('Y-m-d H:i:s');
		$dokumen = $nojual;
		$form = 'Penjualan';
		$status = 'Batal Proses';
		$catatan = $_POST['catatan'];
		$username = $_SESSION['username'];
		$history = $connect->prepare("insert into hisuser (tanggal,dokumen,form,status,user,catatan,datetime) values (?,?,?,?,?,?,?)");
		$history->bind_param('sssssss', $tanggal, $dokumen, $form, $status, $username, $catatan, $datetime);
		$history->execute();
	} else {
		// echo "<script>alert('Gagal hapus data !');
		// window.location.href='../../dashboard.php?m=tbbank';
		// </script>";				
	?>
		<script>
			swal({
				title: "Gagal Batal Proses data",
				text: "",
				icon: "error"
			}).then(function() {
				window.history.back(); //window.location.href='../../dashboard.php?m=jual';
			});
		</script>
	<?php
	}
	?>
</body>