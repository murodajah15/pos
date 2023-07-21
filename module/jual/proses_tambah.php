<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
	if (!empty($_POST['nojual'])) {
		//proses simpan
		include "../../inc/config.php";
		include "../../autonumber.php";
		date_default_timezone_set('Asia/Jakarta');
		$nojual = autoNumberJL($connect, 'id', 'jualh'); //strip_tags($_POST['nojual']);
		//Cek Double
		$cek = mysqli_num_rows(mysqli_query($connect, "select * from jualh where nojual='$nojual'"));
		if ($cek > 0) {
			echo "<script>alert('No sudah ada, data tidak bisa disimpan !');history.go(-1) </script>";
			exit();
		}
		$user_input = "Tambah-" . $_POST['username'] . "-" . date('d-m-Y H:i:s');
		$tgljual = strip_tags($_POST['tgljual']);
		$noinvoice = strip_tags($_POST['noinvoice']);
		$tglinvoice = strip_tags($_POST['tglinvoice']);
		$kdcustomer = strip_tags($_POST['kdcustomer']);
		$nmcustomer = strip_tags($_POST['nmcustomer']);
		$jenis_order = strip_tags($_POST['jenis_order']);
		$tglkirim = strip_tags($_POST['tglkirim']);
		$biaya_lain = strip_tags($_POST['biaya_lain']);
		$ket_biaya_lain = strip_tags($_POST['ket_biaya_lain']);
		$carabayar = strip_tags($_POST['carabayar']);
		$tempo = strip_tags($_POST['tempo']);
		$tgl_jt_tempo = strip_tags($_POST['tgl_jt_tempo']);
		$ppn = strip_tags($_POST['ppn']);
		$materai = strip_tags($_POST['materai']);
		$keterangan = strip_tags($_POST['keterangan']);
		$kdsales = strip_tags($_POST['kdsales']);
		$nmsales = strip_tags($_POST['nmsales']);
		$kdgudang = strip_tags($_POST['kdgudang']);
		$nmgudang = strip_tags($_POST['nmgudang']);
		$query = $connect->prepare("INSERT INTO jualh (noinvoice,tglinvoice,nojual,tgljual,kdcustomer,nmcustomer,jenis_order,tglkirim,biaya_lain,ket_biaya_lain,carabayar,ppn,materai,keterangan,tempo,tgl_jt_tempo,user,kdsales,nmsales,kdgudang,nmgudang) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
		$query->bind_param('sssssssssssssssssssss', $noinvoice, $tglinvoice, $nojual, $tgljual, $kdcustomer, $nmcustomer, $jenis_order, $tglkirim, $biaya_lain, $ket_biaya_lain, $carabayar, $ppn, $materai, $keterangan, $tempo, $tgl_jt_tempo, $user_input, $kdsales, $nmsales, $kdgudang, $nmgudang);
		if ($query->execute() and mysqli_affected_rows($connect) > 0) {
			// echo "<script>alert('Data berhasil disimpan !');
			// window.location.href='../../dashboard.php?m=wo';
			// </script>";	
			$aktif = 'Y';
			$query = $connect->prepare("update saplikasi set nojual=? where aktif=?");
			$query->bind_param('is', $sort_num, $aktif);
			if ($query->execute() and mysqli_affected_rows($connect) > 0) {
			}
	?>
			<script>
				swal({
					title: "Data Berhasil disimpan ",
					text: "",
					icon: "success"
				}).then(function() {
					window.location.href = '../../dashboard.php?m=jual';
				});
			</script>
		<?php
			//Create History
			$tanggal = date('Y-m-d');
			$datetime = date('Y-m-d H:i:s');
			$dokumen = $nojual;
			$form = 'Penjualan';
			$status = 'Tambah';
			$catatan = '';
			$username = $_POST['username'];
			$history = $connect->prepare("insert into hisuser (tanggal,dokumen,form,status,user,catatan,datetime) values (?,?,?,?,?,?,?)");
			$history->bind_param('sssssss', $tanggal, $dokumen, $form, $status, $username, $catatan, $datetime);
			$history->execute();
		} else {
			// echo "<script>alert('Gagal simpan data !');
			// window.location.href='../../dashboard.php?m=wo';
			// </script>";							
		?>
			<script>
				swal({
					title: "Gagal simpan data ",
					text: "",
					icon: "error"
				}).then(function() {
					window.location.href = '../../dashboard.php?m=jual';
				});
			</script>
		<?php
		}
	} else {
		?>
		<script>
			swal({
				title: "No. Penjualan masih kosong !",
				text: "",
				icon: "error"
			}).then(function() {
				window.history.back(); //window.location.href='../../dashboard.php?m=tbsupplier';
			});
		</script>
	<?php
	}
	?>
</body>