<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
	include "../../inc/config.php";
	date_default_timezone_set("Asia/Jakarta");
	$aktif = 'Y';
	$username = $_GET['username'];
	$bulan = substr('0' . $_GET['id'], -2);
	$tahun = $_GET['tahun'];
	$periode = $tahun . $bulan;
	$tgl_closing = date("Y-m-d H:i:s");
	//echo 'aaaa'.$tgl_closing;
	$tanggal = date('Y-m-d');
	//$array1=explode("-",$tanggal);
	//$tahun=$array1[0];
	//$bulan=$array1[1];			
	//echo $tanggal.'  '.$bulan.'   '.$tahun;

	$de = mysqli_fetch_assoc(mysqli_query($connect, "select * from saplikasi where aktif='Y'"));
	$closing_hpp = $de['closing_hpp'];
	if ($periode < $closing_hpp) {
		echo 'Closing terakhir : ' . $closing_hpp;
	?>
		<script>
			swal({
				title: "Gagal Closing",
				text: "Tidak boleh lebih kecil dari closing terakhir !",
				icon: "error"
			}).then(function() {
				window.history.back(); //then(function(){window.location.href='../../dashboard.php?m=wo';
			});
		</script>
	<?php
		exit();
	}
	mysqli_query($connect, "TRUNCATE TABLE proses_hpp");
	$querytbabrang = mysqli_query($connect, "select * from tbbarang order by kode");
	$jumrec = mysqli_num_rows($querytbabrang);
	$gagal = 0;
	$i = 1;
	?>
	<div id="progress" style="width:500px; border:1px solid #ccc;"></div>
	<div id="information"></div>
	<?php
	echo 'Proses insert stock_barang ...<br>';
	while ($k = mysqli_fetch_assoc($querytbabrang)) {
		$kdbarang = $k['kode'];
		$queryd = mysqli_query($connect, "select * from stock_barang where periode='$periode' and kdbarang='$kdbarang'");
		$rec = mysqli_fetch_row($queryd);
		if ($rec <= 0) {
			$query = $connect->prepare("insert into stock_barang (periode,kdbarang,tgl_closing,user_closing) values (?,?,?,?)");
			$query->bind_param('ssss', $periode, $kdbarang, $tgl_closing, $username);
		} else {
			$query = $connect->prepare("update stock_barang set periode=?,kdbarang=?,tgl_closing=?,user_closing=? where kdbarang=? and periode=?");
			$query->bind_param('ssssss', $periode, $kdbarang, $tgl_closing, $username, $kdbarang, $periode);
		}
		if ($query->execute() and mysqli_affected_rows($connect) > 0) {
		} else {
			$gagal = 1;
			echo 'Insert stock_barang gagal';
			exit();
		}
		$percent = round($i / $jumrec * 100, 0) . "%";
		// Javascript for updating the progress bar and information
		echo '<script language="javascript">
	    document.getElementById("progress").innerHTML="<div style=\"width:' . $percent . ';background-color:#ddd;\">&nbsp;</div>";
	    document.getElementById("information").innerHTML="' . $percent . ' row(s) processed (1/2).";
	    </script>';
		// This is for the buffer achieve the minimum size in order to flush data
		echo str_repeat(' ', 1024 * 64);
		// Send output to browser immediately
		flush();
		// Sleep one second so we can see the delay
		sleep(0);
		$i++;
	}
	echo 'Insert stock_barang selesai<br>';

	echo 'Proses perhitungan stock awal dan akhir ...<br>';
	$i = 1;
	$stock_barang = mysqli_query($connect, "select * from stock_barang where periode='$periode'");
	while ($k = mysqli_fetch_assoc($stock_barang)) {
		$kdbarang = $k['kdbarang'];
		// if ($query->execute() and mysqli_affected_rows($connect) > 0) {
		$queryjum = mysqli_query($connect, "select sum(tbl.qty) as qtymasuk from (select tglbeli as tgldokumen,kdbarang as kode,nobeli as nodokumen,qty,hpp from belid where kdbarang='$kdbarang' and  month(tglbeli)='$bulan' and year(tglbeli)='$tahun' and proses='Y' 
				 union select tglterima as tgldokumen,kdbarang as kode,noterima as nodokumen,qty,hpp from terimad where kdbarang='$kdbarang' and month(tglterima)='$bulan' and year(tglterima)='$tahun' and proses='Y') tbl");
		$de = mysqli_fetch_assoc($queryjum);
		$qtymasuk = $de['qtymasuk'];
		$queryjum = mysqli_query($connect, "select sum(tbl.qty) as qtykeluar from (select tgljual as tgldokumen,kdbarang as kode,nojual as nodokumen,qty,hpp from juald where kdbarang='$kdbarang' and month(tgljual)='$bulan' and year(tgljual)='$tahun' and proses='Y' 
				 union select tglkeluar as tgldokumen,kdbarang as kode,nokeluar as nodokumen,qty,hpp from keluard where kdbarang='$kdbarang' and month(tglkeluar)='$bulan' and year(tglkeluar)='$tahun' and proses='Y') tbl");
		$de = mysqli_fetch_assoc($queryjum);
		$qtykeluar = $de['qtykeluar'];
		$qtyawal = 0;
		$qtyakhir = $qtyawal + $qtymasuk - $qtykeluar;
		//echo $qtyakhir;
		$query = $connect->prepare("update stock_barang set awal=?,masuk=?,keluar=?,akhir=? where kdbarang=? and periode=?");
		$query->bind_param('iiiiss', $qtyawal, $qtymasuk, $qtykeluar, $qtyakhir, $kdbarang, $periode);
		//mysqli_query($connect,"insert into stock_barang (periode,kdbarang) values ('$periode','$kdbarang')");
		if ($query->execute()) {
		} else {
			echo 'Gagal update';
		}
		$querybeli = mysqli_query($connect, "select tglbeli as tgldokumen,kdbarang as kode,nobeli as nodokumen,qty,hpp,harga  from belid where kdbarang='$kdbarang' and  month(tglbeli)='$bulan' and year(tglbeli)='$tahun' and proses='Y' 
				 union select tglterima as tgldokumen,kdbarang as kode,noterima as nodokumen,qty,hpp,harga from terimad where kdbarang='$kdbarang' and month(tglterima)='$bulan' and year(tglterima)='$tahun' and proses='Y' 
				 union select tgljual as tgldokumen,kdbarang as kode,nojual as nodokumen,qty,hpp,harga from juald where kdbarang='$kdbarang' and month(tgljual)='$bulan' and year(tgljual)='$tahun' and proses='Y' 
				 union select tglkeluar as tgldokumen,kdbarang as kode,nokeluar as nodokumen,qty,hpp,harga from keluard where kdbarang='$kdbarang' and month(tglkeluar)='$bulan' and year(tglkeluar)='$tahun' and proses='Y' order by tgldokumen");
		//echo 'aaa'.$record;
		$no = 1;
		while ($db = mysqli_fetch_assoc($querybeli)) {
			mysqli_query($connect, "insert into proses_hpp (kdbarang,nodokumen,tgldokumen,qty,hpp,harga) values ('$db[kode]','$db[nodokumen]','$db[tgldokumen]','$db[qty]','$db[hpp]','$db[harga]')");
		}
		//Ambil Stock sebelumnya dan update ke stock awal bulan proses
		$periode1 = $periode - 1;
		//echo $periode1;
		$querystock_barang = mysqli_query($connect, "select * from stock_barang where periode='$periode1' and kdbarang='$kdbarang'");
		$record = mysqli_num_rows($querystock_barang);
		//echo 'aaa'.$record;
		$de = mysqli_fetch_assoc($querystock_barang);
		$stockblnsebelumnya = $de['akhir'];
		$hppblnsebelumnya = $de['hpp_akhir'];
		$stockakhir = $stockblnsebelumnya;
		//echo 'hpp'.$hppblnsebelumnya;
		if (isset($de['periode'])) {
			$stock_berjalan = $stockblnsebelumnya;
			$hpp_berjalan = $hppblnsebelumnya;
			$stockakhir = $stockblnsebelumnya;
			$hpp_akhir = $hppblnsebelumnya;
			$hpp_awal = $hppblnsebelumnya;
		} else {
			$stock_berjalan = 0;
			$hpp_berjalan = 0;
			$stockakhir = 0;
			$hpp_awal = 0;
		}
		$query_proses_hpp = mysqli_query($connect, "select * from proses_hpp where kdbarang='$kdbarang' order by tgldokumen");
		while ($db = mysqli_fetch_assoc($query_proses_hpp)) {
			$idhpp = $db['id'];
			$nodokumen = $db['nodokumen'];
			$qty = $db['qty'];
			$harga = $db['harga'];
			if (substr($nodokumen, 0, 2) == 'BE' or substr($nodokumen, 0, 2) == 'TB') {
				if (substr($nodokumen, 0, 2) == 'BE') {
					//Hitung HPP
					//echo $kdbarang.' : '.$hpp_berjalan.'*'.$stock_berjalan.'+'.$harga.'*'.$qty.'/'.$stock_berjalan.'+'.$qty;
					$hpp_berjalan = (($hpp_berjalan * $stock_berjalan) + ($harga * $qty)) / ($stock_berjalan + $qty);
					// if ($hpp_berjalan>0) {
					// 	echo $kdbarang.' : '.$hpp_berjalan.'*'.$stock_berjalan.'+'.$harga.'*'.$qty.'/'.$stock_berjalan.'+'.$qty;
					// 	$hpp_berjalan = (($hpp_berjalan*$stock_berjalan) + ($harga*$qty)) / ($stock_berjalan+$qty);
					// }else{
					// 	$hpp_berjalan = $harga;
					// }
				}
				$stock_berjalan = $stock_berjalan + $qty;
				$stockakhir = $stockakhir + $qty;
			} else {
				$stock_berjalan = $stock_berjalan - $qty;
				$stockakhir = $stockakhir - $qty;
				//echo 'b'.$stock_berjalan.'c'.$qty;
			}
			mysqli_query($connect, "update proses_hpp set hpp_berjalan='$hpp_berjalan' where id='$idhpp'");
		}
		$query_hpp_berjalan = mysqli_query($connect, "select hpp_berjalan from proses_hpp where kdbarang='$kdbarang' limit 1");
		$dt = mysqli_fetch_assoc($query_hpp_berjalan);
		if (mysqli_num_rows($query_hpp_berjalan) > 0) {
			$hpp_akhir = $dt['hpp_berjalan'];
		} else {
			$hpp_akhir = $hppblnsebelumnya;
		}
		$query_hpp_berjalan = mysqli_query($connect, "select hpp_berjalan from proses_hpp order by id desc limit 1");
		$dt = mysqli_fetch_assoc($query_hpp_berjalan);
		if (mysqli_num_rows($query_hpp_berjalan) > 0) {
			$hpp_akhir = $dt['hpp_berjalan'];
		} else {
			$hpp_akhir = $hppblnsebelumnya;
		}
		$nilai_akhir = $stockakhir * $hpp_akhir;
		$query = $connect->prepare("update stock_barang set awal=?,akhir=?,hpp_awal=?,hpp_akhir=?,nilai_akhir=? where kdbarang=? and periode=?");
		$query->bind_param('iiiiiss', $stockblnsebelumnya, $stockakhir, $hpp_awal, $hpp_akhir, $nilai_akhir, $kdbarang, $periode);
		if ($query->execute()) {
			mysqli_query($connect, "update stock_barang set nilai_awal=awal*hpp_awal where kdbarang='$kdbarang' and periode='$periode'");
		} else {
			echo 'Gagal update';
		}
		$periode1 = $periode - 1;
		$de = mysqli_fetch_assoc(mysqli_query($connect, "select * from stock_barang where periode='$periode1' and kdbarang='$kdbarang'"));
		if ($record == 0) {
			//echo 'masuk';
			$stockblnsebelumnya = $de['akhir'];
			$stockakhir = $stockakhir; //$stockblnsebelumnya;
			$hpp_awal = 0; //$de['hpp_awal'];
			$hpp_akhir = $hpp_berjalan;
			$nilai_akhir = $stockakhir * $hpp_akhir;
			$query = $connect->prepare("update stock_barang set awal=?,akhir=?,hpp_awal=?,hpp_akhir=?,nilai_akhir=? where kdbarang=? and periode=?");
			$query->bind_param('iiiiiss', $stockblnsebelumnya, $stockakhir, $hpp_awal, $hpp_akhir, $nilai_akhir, $kdbarang, $periode);
			if ($query->execute()) {
				mysqli_query($connect, "update stock_barang set nilai_awal=awal*hpp_awal where kdbarang='$kdbarang' and periode='$periode'");
			} else {
				echo 'Gagal update';
			}
		}

		$percent = round($i / $jumrec * 100, 0) . "%";
		// Javascript for updating the progress bar and information
		echo '<script language="javascript">
	    document.getElementById("progress").innerHTML="<div style=\"width:' . $percent . ';background-color:#ddd;\">&nbsp;</div>";
	    document.getElementById("information").innerHTML="' . $percent . ' row(s) processed (2/2).";
	    </script>';
		// This is for the buffer achieve the minimum size in order to flush data
		echo str_repeat(' ', 1024 * 64);
		// Send output to browser immediately
		flush();
		// Sleep one second so we can see the delay
		sleep(0);
		$i++;
	}
	echo 'Proses Selesaiperhitungan stock awal dan akhir selesai<br>';

	echo 'Proses akhir ...';
	//Bentuk stock bulan berikutnya pada saat transaksi
	$bulan1 = substr('0' . $_GET['bulan1'], -2);
	$tahun1 = $_GET['tahun1'];
	$periodeberikut = $tahun1 . $bulan1;
	$query_stock_barang = mysqli_query($connect, "select * from stock_barang where periode='$periode' order by kdbarang");
	while ($db = mysqli_fetch_assoc($query_stock_barang)) {
		$kdbarang = $db['kdbarang'];
		$akhir = $db['akhir'];
		$hpp_akhir = $db['hpp_akhir'];
		$nilai_akhir = $db['nilai_akhir'];
		$qry = mysqli_query($connect, "select kdbarang from stock_barang where kdbarang='$kdbarang' and periode='$periodeberikut'");
		$rec = mysqli_num_rows($qry);
		if ($rec == 0) {
			mysqli_query($connect, "insert into stock_barang (periode,kdbarang,awal,hpp_awal,hpp_akhir,nilai_awal) values ('$periodeberikut','$kdbarang','$akhir','$hpp_akhir','$hpp_akhir','$nilai_akhir')");
		}
		mysqli_query($connect, "update stock_barang set awal='$akhir',akhir=awal+masuk-keluar,nilai_akhir=akhir*hpp_akhir where kdbarang='$kdbarang' and periode='$periodeberikut'");
	}

	//Update HPP
	$queryupdate = mysqli_query($connect, "select * from proses_hpp");
	while ($db = mysqli_fetch_assoc($queryupdate)) {
		$nodokumen = $db['nodokumen'];
		$hpp = $db['hpp_berjalan'];
		$kdbarang = $db['kdbarang'];
		$dok = substr($nodokumen, 0, 2);
		switch ($dok) {
			case "BE":
				$query = $connect->prepare("update belid set hpp=? where nobeli=? and kdbarang=?");
				break;
			case "TB":
				$query = $connect->prepare("update terimad set hpp=? where noterima=? and kdbarang=?");
				break;
			case "JL":
				$query = $connect->prepare("update juald set hpp=? where nojual=? and kdbarang=?");
				break;
			default:
				$query = $connect->prepare("update keluard set hpp=? where nokeluar=? and kdbarang=?");
		}
		$query->bind_param('iss', $hpp, $nodokumen, $kdbarang);
		if ($query->execute() <= 0) {
			$gagal = 1;
			exit();
		}
	}

	if ($gagal == 0) { //and mysqli_affected_rows($connect)>0
		echo 'Proses closing HPP selesai<br>';
		$bulan1 = substr('0' . $_GET['id'], -2);
		$tahun1 = $_GET['tahun1'];
		$nbulan1 = $_GET['bulan1'];
		$ntahun1 = $_GET['tahun1'];
		mysqli_query($connect, "update saplikasi set closing_hpp='$periode',bulan='$nbulan1',tahun='$ntahun1'  where aktif='Y'");
		// if($query->execute()) {
		// }else{
		// 	echo 'Gagal update';
		// }
		$username = $_GET['username'];
		$bulan = substr('0' . $_GET['id'], -2);
		$tahun = $_GET['tahun'];
		$periode = $tahun . $bulan;
		$user_closing = $_GET['username'];
		$status = "Y";
		mysqli_query($connect, "insert into close_hpp (periode,tgl_closing,user_closing,status,user) values ('$periode','$tgl_closing','$user_closing','$status','$username')")
	?>
		<script>
			swal({
				title: "Closing HPP Berhasil ",
				text: "",
				icon: "success"
			}).then(function() {
				window.location.href = '../../dashboard.php?m=closing_hpp';
			});
		</script>
	<?php
	} else {
		// echo "<script>alert('Gagal simpan data !');
		// window.location.href='../../dashboard.php?m=wo';
		// </script>";							
	?>
		<script>
			swal({
				title: "Closing HPP Gagal ",
				text: "",
				icon: "error"
			}).then(function() {
				window.location.href = '../../dashboard.php?m=closing_hpp';
			});
		</script>
	<?php
	}
	?>
</body>