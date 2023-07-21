<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
	include "../../inc/config.php";
	if (!empty($_POST['nojual'])) {
		//proses simpan
		date_default_timezone_set('Asia/Jakarta');
		//Cek Double
		$cek = mysqli_num_rows(mysqli_query($connect, "select * from jualh where nojual='$_POST[nojual]' and id<>'$_POST[id]'"));
		if ($cek > 0) {
			echo "<script>alert('Kode tersebut sudah digunakan');history.go(-1) </script>";
			exit();
		}
		// $user = "Update-".$_POST['username']."-".date('d-m-Y H:i:s');
		// mysqli_query($connect,"update wo set kode='$_POST[kode]',nama='$_POST[nama]',aktif='$_POST[aktif]',user='$user' where id='$_POST[id]'");
		// header("location:../../dashboard.php?m=wo");
		$user_input = "Update-" . $_POST['username'] . "-" . date('d-m-Y H:i:s');
		$nojual = strip_tags($_POST['nojual']);
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
		$ntotal = hit_total($connect, $nojual, $ppn);
		$total_sementara = $_POST['biaya_lain'] + $nsubtotal;
		$ntotal = $total_sementara + ($total_sementara * ($ppn / 100)) + $materai;
		$query = $connect->prepare("update jualh set nojual=?,tgljual=?,noinvoice=?,tglinvoice=?,kdcustomer=?,nmcustomer=?,jenis_order=?,tglkirim=?,biaya_lain=?,ket_biaya_lain=?,carabayar=?,ppn=?,materai=?,keterangan=?,user=?,subtotal=?,total=?,tempo=?,tgl_jt_tempo=?,total_sementara=?,kdsales=?,nmsales=?,kdgudang=?,nmgudang=? where id=?");
		$query->bind_param('sssssssssssssssssssssssss', $nojual, $tgljual, $noinvoice, $tglinvoice, $kdcustomer, $nmcustomer, $jenis_order, $tglkirim, $biaya_lain, $ket_biaya_lain, $carabayar, $ppn, $materai, $keterangan, $user_input, $nsubtotal, $ntotal, $tempo, $tgl_jt_tempo, $total_sementara, $kdsales, $nmsales, $kdgudang, $nmgudang, $_POST['id']);
		if ($query->execute() and mysqli_affected_rows($connect) > 0) {
			// echo "<script>alert('Data berhasil disimpan !');
			// window.location.href='../../dashboard.php?m=wo';
			// </script>";													
	?>
			<script>
				swal({
					title: "Data Berhasil disimpan ",
					text: "",
					icon: "success"
				}).then(function() {
					window.location.href = '../../dashboard.php?m=jual&module=Penjualan';
				});
			</script>
		<?php
			//Create History
			$tanggal = date('Y-m-d');
			$datetime = date('Y-m-d H:i:s');
			$dokumen = $nojual;
			$form = 'Penjualan';
			$status = 'Edit';
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
					window.location.href = '../../dashboard.php?m=jual&module=Penjualan';
				});
			</script>
	<?php
		}
	} else {
		header("location:../../dashboard.php?m=jual");
	}
	?>

	<?php
	//pembuatan fungsi
	function hit_total($connect, $nojual, $ppn)
	{
		global $nsubtotal;
		include "../../inc/config.php";
		$tampil = mysqli_query($connect, "select sum(subtotal) as nsubtotal from juald where nojual='$nojual'");
		$de = mysqli_fetch_assoc($tampil);
		$nsubtotal = $de['nsubtotal'];
		//$nppn = $nsubtotal * ($ppn/100);
		//$ntotal = $nsubtotal - $nppn;
		return $nsubtotal;
	}
	?>

</body>