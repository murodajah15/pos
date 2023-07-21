<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
	include "../../inc/config.php";
	include "../../autonumber.php";
	//proses hapus
	session_start();
	date_default_timezone_set('Asia/Jakarta');
	$jamjual = date("Y-m-d H:i:s");
	$user = $_SESSION['username'];
	$kunci_stock = $_SESSION['kunci_stock'];
	$user_proses = "Proses-" . $user . "-" . date('d-m-Y H:i:s');
	$tglselesai = date('Y-m-d H:i:s');
	$proses = 'Y';

	$tampil = mysqli_query($connect, "select * from jualh where id='$_GET[id]'");
	$de = mysqli_fetch_assoc($tampil);
	$nojual = $de['nojual'];
	$tgljual = $de['tgljual'];
	$kurangbayar = $de['total'] - $de['sudahbayar'];
	$nosrtjln = $de['nosrtjln'];
	$tglsrtjln = $de['tglsrtjln'];
	if ($nosrtjln == "") {
		$nosrtjln = autoNumberSJ($connect, 'id', 'jualh');
		$tglsrtjln = date("Y-m-d");
	}
	// echo $nosrtjln . '  ' . $tglsrtjln;
	if ($de['proses'] == 'Y' or $de['total'] == 0) {
		$text = "Dokumen " . $nojual . " Sudah di proses / total masih 0 (nol)!";
	?>
		<script>
			swal({
				title: "Gagal proses data",
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
				title: "Gagal Proses !",
				text: "Sudah Closing Data Bulanan !",
				icon: "success"
			}).then(function() {
				window.history.back(); //then(function(){window.location.href='../../dashboard.php?m=wo';
			});
		</script>
		<?php
		exit();
	}
	$rec = mysqli_num_rows(mysqli_query($connect, "select * from juald where nojual='$nojual'"));
	if ($rec == 0) {
		echo "<script>alert('Tidak ada detail barang, tidak bisa proses !');history.go(-1) </script>";
		exit();
	}
	//cek qty penerimaan ke po
	$tampil = mysqli_query($connect, "select * from juald where nojual='$nojual'");
	while ($k = mysqli_fetch_assoc($tampil)) {
		$qty = $k['qty'];
		$id = $k['id'];
		$kdbarang = $k['kdbarang'];
		$noso = $k['noso'];
		$query = mysqli_query($connect, "select * from sod where noso='$noso' and kdbarang='$kdbarang'");
		$k = mysqli_fetch_assoc($query);
		if (!empty($k['noso'])) {
			if ($k['kurang'] < $qty) {
				$text = "Barang " . $kdbarang . ", QTY Penjualan melebihi QTY SO !";
		?>
				<script>
					swal({
						title: "Gagal proses data",
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
		}
	}
	$lanjut = 1;
	if ($kunci_stock == 'Y') {
		$query = mysqli_query($connect, "select qty,kdbarang from juald where nojual='$nojual'");
		while ($k = mysqli_fetch_assoc($query)) {
			$kdbarang = $k['kdbarang'];
			$qty = $k['qty'];
			$querytbbarang = mysqli_fetch_assoc(mysqli_query($connect, "select stock from tbbarang where kode='$kdbarang'"));
			$stock = $querytbbarang['stock'];
			// echo 'aaa' . $stock;
			if ($qty > $stock) {
			?>
				<script>
					swal({
						title: "Gagal proses data, penjualan melebihin stock",
						text: "<?= $kdbarang ?>",
						icon: "error"
					}).then(function() {
						window.history.back(); //window.location.href='../../dashboard.php?m=jual';
					});
				</script>
		<?php
				$lanjut = 0;
				exit();
			}
		}
	}

	$lanjut = 1;

	$query = mysqli_query($connect, "select * from jualh where id='$_GET[id]'");
	$k = mysqli_fetch_assoc($query);
	$kurangbayar = $k['total'] - $k['sudahbayar'];
	$query = $connect->prepare("update jualh set proses=?,kurangbayar=?,user_proses=?,nosrtjln=?,tglsrtjln=? where id=?");
	$query->bind_param('ssssss', $proses, $kurangbayar, $user_proses, $nosrtjln, $tglsrtjln, $_GET['id']);
	if ($query->execute() and mysqli_affected_rows($connect) > 0) {
		//Update prosed detail
		mysqli_query($connect, "update juald set proses='$proses',tgljual='$tgljual',jamjual='$jamjual' where nojual='$nojual'");
		$tampil = mysqli_query($connect, "select * from juald where nojual='$nojual'");
		while ($k = mysqli_fetch_assoc($tampil)) {
			$qty = $k['qty'];
			$id = $k['id'];
			$kdbarang = $k['kdbarang'];
			$noso = $k['noso'];
			//echo $qty;
			$data = mysqli_query($connect, "select qty,terima from sod where noso='$noso' and kdbarang='$kdbarang'");
			$de = mysqli_fetch_assoc($data);
			$qtypesan = $de['qty'];
			$qtysdhterima = $de['terima'];
			$terima = $qtysdhterima + $qty;
			$kurang = $qtypesan -  $terima;
			$query = $connect->prepare("update sod set terima=?,kurang=? where noso=? and kdbarang=?");
			$query->bind_param('ssss', $terima, $kurang, $noso, $kdbarang);
			if ($query->execute() and mysqli_affected_rows($connect) > 0) {
			}
			mysqli_query($connect, "update tbbarang set stock=stock-$qty where kode='$kdbarang'");
			//update ke stock_barang
			$cek = mysqli_query($connect, "select kdbarang,periode from stock_barang where periode='$periode' and kdbarang='$kdbarang'");
			$ketemu = mysqli_num_rows($cek);
			if ($ketemu == 0) {
				//cek saldo sebelumnya 
				$cariperiodesblm = $periode - 1;
				$cek = mysqli_query($connect, "select kdbarang,periode,akhir,hpp_akhir from stock_barang where periode='$cariperiodesblm' and kdbarang='$kdbarang'");
				$ketemu = mysqli_fetch_assoc($cek);
				$akhir = $ketemu['akhir'];
				$hpp_akhir = $ketemu['hpp_akhir'];
				$nilai_awal = $akhir * $hpp_akhir;
				mysqli_query($connect, "insert into stock_barang (periode,kdbarang,awal,hpp_awal,hpp_akhir,nilai_awal) values ('$periode','$kdbarang','$akhir','$hpp_akhir','$hpp_akhir','$nilai_awal')");
			}
			mysqli_query($connect, "update stock_barang set keluar=keluar+$qty,akhir=awal+masuk-keluar,nilai_akhir=akhir*hpp_akhir where kdbarang='$kdbarang' and periode='$periode'");
			//
			$dtbarang = mysqli_query($connect, "select hpp from tbbarang where kode='$kdbarang'");
			$de = mysqli_fetch_assoc($dtbarang);
			$hpp = $de['hpp'];
			mysqli_query($connect, "update juald set hpp='$hpp' where nojual='$nojual' and kdbarang='$kdbarang'");
		}
		$cek = mysqli_query($connect, "select sum(kurang) as kurang from sod where noso='$noso'");
		$de = mysqli_fetch_assoc($cek);
		if ($de['kurang'] == 0) {
			$query = $connect->prepare("update soh set terima=? where noso=?");
			$query->bind_param('ss', $proses, $noso);
			if ($query->execute() and mysqli_affected_rows($connect) > 0) {
			}
		}
		?>
		<script>
			swal({
				title: "Data berhasil diproses",
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
		$status = 'Proses';
		$catatan = '';
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
				title: "Gagal proses data",
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