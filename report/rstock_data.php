<?php
session_start();
include "../timeout.php";
if ($_SESSION['login'] == 1) {
  if (!cek_login()) {
    $_SESSION['login'] = 0;
  }
}
if ($_SESSION['login'] == 0) {
  header('location:../logout.php');
}
//require_once "koneksi.php";
include "../inc/config.php";
//require_once "koneksi.php";
include "../inc/config.php";
require_once("../dompdf/dompdf_config.inc.php");

date_default_timezone_set('Asia/Jakarta');
$who = "Update-" . $_SESSION['username'] . "-" . date('d-m-Y H:i:s');
// $tanggal1 = date('d-m-Y', strtotime($_POST['tanggal1']));
// $tanggal2 = date('d-m-Y', strtotime($_POST['tanggal2']));
// $tgl1 = date('Y-m-d', strtotime($_POST['tanggal1']));
// $tgl2 = date('Y-m-d', strtotime($_POST['tanggal2']));
$tgl2 = date('Y-m-d');
$bulan = $_POST['bulan'];
$tahun = $_POST['tahun'];
$tgl1 = $bulan;
$tgl2 = $bulan;
include '../konver_namabulan.php';
$nm_perusahaan = $_SESSION['nm_perusahaan'];
$alamat_perusahaan = $_SESSION['alamat_perusahaan'];
$telp_perusahaan = $_SESSION['telp_perusahaan'];
$no = 1;
$bentuk = $_POST['bentuk']; //rincian/rekap
// $pilihan = $_POST['pilihan']; //perbarang/all
$kdbarang = $_POST['kdbarang'];
$nmbarang = $_POST['nmbarang'];
// echo $bentuk,$pilihan;

if ($bentuk == "Rekapitulasi") {
  if (isset($_POST['check1'])) {
    if (isset($_POST['pilihan'])) {
      $tanggal = 'Semua Periode';
      $nmlaporan = "LAPORAN REKAPITULASI STOCK BARANG " . $kdbarang . ' (' . $nmbarang . ')';
      $text = "select tbbarang.kode, tbbarang.nama,tbbarang.stock,tbbarang.hpp,beliawal,pemakaianawal,terimaawal,keluarawal,masuk,terima,keluar,pemakaian from tbbarang 
				left join (select tbbarang.kode, sum(belid.qty) as beliawal from tbbarang, belid where tbbarang.kode=belid.kdbarang and belid.proses='Y' and belid.kdbarang='$kdbarang'
				group by belid.kdbarang asc) as beliawal on tbbarang.kode=beliawal.kode
				left join (select tbbarang.kode, sum(belid.qty) as masuk from tbbarang, belid where tbbarang.kode=belid.kdbarang and belid.proses='Y' 
				 group by belid.kdbarang asc) as masuk on tbbarang.kode=masuk.kode";
      $text = $text . " left join (select tbbarang.kode, sum(juald.qty) as pemakaianawal from tbbarang, juald where tbbarang.kode=juald.kdbarang and juald.proses='Y' and juald.kdbarang='$kdbarang'
				 group by juald.kdbarang asc) as pemakaianawal on tbbarang.kode=pemakaianawal.kode
				left join (select tbbarang.kode, sum(terimad.qty) as terimaawal from tbbarang, terimad where tbbarang.kode=terimad.kdbarang and terimad.proses='Y' and terimad.kdbarang='$kdbarang'
				 group by terimad.kdbarang asc) as terimaawal on tbbarang.kode=terimaawal.kode
				left join (select tbbarang.kode, sum(terimad.qty) as terima from tbbarang, terimad where tbbarang.kode=terimad.kdbarang and terimad.proses='Y' and terimad.kdbarang='$kdbarang'
				 group by terimad.kdbarang asc) as terima on tbbarang.kode=terima.kode";
      $text = $text . " left join (select tbbarang.kode, sum(keluard.qty) as keluarawal from tbbarang, keluard where tbbarang.kode=keluard.kdbarang and keluard.proses='Y' and keluard.kdbarang='$kdbarang'
				 group by keluard.kdbarang asc) as keluarawal on tbbarang.kode=keluarawal.kode
				left join (select tbbarang.kode, sum(keluard.qty) as keluar from tbbarang, keluard where tbbarang.kode=keluard.kdbarang and keluard.proses='Y' and keluard.kdbarang='$kdbarang' 
				 group by keluard.kdbarang asc) as keluar on tbbarang.kode=keluar.kode
				left join (select tbbarang.kode, sum(juald.qty) as pemakaian from tbbarang, juald where tbbarang.kode=juald.kdbarang and juald.proses='Y' and juald.kdbarang='$kdbarang'
				 group by juald.kdbarang asc) as pemakaian on tbbarang.kode=pemakaian.kode where tbbarang.kode='$kdbarang' group by tbbarang.kode asc";
      $queryh = mysqli_query($connect, "$text");
    } else {
      $tanggal = 'Bulan : ' . $bulan . ', Tahun : ' . $tahun;
      $tgl1 = $bulan;
      $nmlaporan = "LAPORAN REKAPITULASI STOCK BARANG (SEMUA BARANG)";
      $text = "select tbbarang.kode, tbbarang.nama,tbbarang.stock,tbbarang.hpp,beliawal,pemakaianawal,terimaawal,keluarawal,masuk,terima,keluar,pemakaian from tbbarang 
				left join (select tbbarang.kode, sum(belid.qty) as beliawal from tbbarang, belid where tbbarang.kode=belid.kdbarang and belid.proses='Y'
				and month(tglbeli)<'$tgl1' group by belid.kdbarang asc) as beliawal on tbbarang.kode=beliawal.kode
				left join (select tbbarang.kode, sum(belid.qty) as masuk from tbbarang, belid where tbbarang.kode=belid.kdbarang and belid.proses='Y' 
				 group by belid.kdbarang asc) as masuk on tbbarang.kode=masuk.kode";
      $text = $text . " left join (select tbbarang.kode, sum(juald.qty) as pemakaianawal from tbbarang, juald where tbbarang.kode=juald.kdbarang and juald.proses='Y' 
				and month(tgljual)<'$tgl1' group by juald.kdbarang asc) as pemakaianawal on tbbarang.kode=pemakaianawal.kode
				left join (select tbbarang.kode, sum(terimad.qty) as terimaawal from tbbarang, terimad where tbbarang.kode=terimad.kdbarang and terimad.proses='Y'
				and month(tglterima)<'$tgl1' group by terimad.kdbarang asc) as terimaawal on tbbarang.kode=terimaawal.kode
				left join (select tbbarang.kode, sum(terimad.qty) as terima from tbbarang, terimad where tbbarang.kode=terimad.kdbarang and terimad.proses='Y'
				 group by terimad.kdbarang asc) as terima on tbbarang.kode=terima.kode";
      $text = $text . " left join (select tbbarang.kode, sum(keluard.qty) as keluarawal from tbbarang, keluard where tbbarang.kode=keluard.kdbarang and keluard.proses='Y' 
				 group by keluard.kdbarang asc) as keluarawal on tbbarang.kode=keluarawal.kode
				left join (select tbbarang.kode, sum(keluard.qty) as keluar from tbbarang, keluard where tbbarang.kode=keluard.kdbarang and keluard.proses='Y'
				 group by keluard.kdbarang asc) as keluar on tbbarang.kode=keluar.kode
				left join (select tbbarang.kode, sum(juald.qty) as pemakaian from tbbarang, juald where tbbarang.kode=juald.kdbarang and juald.proses='Y' 
				 group by juald.kdbarang asc) as pemakaian on tbbarang.kode=pemakaian.kode group by tbbarang.kode asc";
      $queryh = mysqli_query($connect, "$text");
    }
  } else {
    if (isset($_POST['pilihan'])) {
      //Rekapituland perbarang
      $tanggal = 'Bulan : ' . $cbulan . ', Tahun : ' . $tahun;
      $nmlaporan = "LAPORAN REKAPITULASI STOCK BARANG " . $kdbarang . ' (' . $nmbarang . ')';
      $text = "select tbbarang.kode, tbbarang.nama,tbbarang.stock,tbbarang.hpp,beliawal,pemakaianawal,terimaawal,keluarawal,masuk,terima,keluar,pemakaian from tbbarang 
				left join (select tbbarang.kode, sum(belid.qty) as beliawal from tbbarang, belid where tbbarang.kode=belid.kdbarang and belid.proses='Y' and belid.kdbarang='$kdbarang'
				and month(tglbeli)<'$tgl1' and year(tglbeli)='$tahun' group by belid.kdbarang asc) as beliawal on tbbarang.kode=beliawal.kode
				left join (select tbbarang.kode, sum(belid.qty) as masuk from tbbarang, belid where tbbarang.kode=belid.kdbarang and belid.proses='Y' 
				and (month(tglbeli)>='$tgl1' and month(tglbeli)<='$tgl2' and year(tglbeli)='$tahun') group by belid.kdbarang asc) as masuk on tbbarang.kode=masuk.kode";
      $text = $text . " left join (select tbbarang.kode, sum(juald.qty) as pemakaianawal from tbbarang, juald where tbbarang.kode=juald.kdbarang and juald.proses='Y' and juald.kdbarang='$kdbarang'
				and month(tgljual)<'$tgl1' group by juald.kdbarang asc) as pemakaianawal on tbbarang.kode=pemakaianawal.kode
				left join (select tbbarang.kode, sum(terimad.qty) as terimaawal from tbbarang, terimad where tbbarang.kode=terimad.kdbarang and terimad.proses='Y' and terimad.kdbarang='$kdbarang'
				and month(tglterima)<'$tgl1' and year(tglterima)='$tahun' group by terimad.kdbarang asc) as terimaawal on tbbarang.kode=terimaawal.kode
				left join (select tbbarang.kode, sum(terimad.qty) as terima from tbbarang, terimad where tbbarang.kode=terimad.kdbarang and terimad.proses='Y' and terimad.kdbarang='$kdbarang'
				and (month(tglterima)>='$tgl1' and month(tglterima)<='$tgl2' and year(tglterima)='$tahun') group by terimad.kdbarang asc) as terima on tbbarang.kode=terima.kode";
      $text = $text . " left join (select tbbarang.kode, sum(keluard.qty) as keluarawal from tbbarang, keluard where tbbarang.kode=keluard.kdbarang and keluard.proses='Y' and keluard.kdbarang='$kdbarang'
				and (month(tglkeluar)>='$tgl1' and month(tglkeluar)<='$tgl2' and year(tglkeluar)='$tahun') group by keluard.kdbarang asc) as keluarawal on tbbarang.kode=keluarawal.kode
				left join (select tbbarang.kode, sum(keluard.qty) as keluar from tbbarang, keluard where tbbarang.kode=keluard.kdbarang and keluard.proses='Y' and keluard.kdbarang='$kdbarang' 
				and (month(tglkeluar)>='$tgl1' and month(tglkeluar)<='$tgl2' and year(tglkeluar)='$tahun') group by keluard.kdbarang asc) as keluar on tbbarang.kode=keluar.kode
				left join (select tbbarang.kode, sum(juald.qty) as pemakaian from tbbarang, juald where tbbarang.kode=juald.kdbarang and juald.proses='Y' and juald.kdbarang='$kdbarang'
				and (month(tgljual)>='$tgl1' and month(tgljual)<='$tgl2' and year(tgljual)='$tahun') group by juald.kdbarang asc) as pemakaian on tbbarang.kode=pemakaian.kode where tbbarang.kode='$kdbarang' group by tbbarang.kode asc";
      $queryh = mysqli_query($connect, "$text");
    } else {
      //Rekapitulasi semua barang
      //$tanggal = $tanggal1.' s/d '.$tanggal2;
      $tanggal = 'Bulan : ' . $cbulan . ', Tahun : ' . $tahun;
      $nmlaporan = "LAPORAN REKAPITULASI STOCK BARANG (SEMUA BARANG)";
      $text = "select tbbarang.kode, tbbarang.nama,tbbarang.stock,tbbarang.hpp,beliawal,pemakaianawal,terimaawal,keluarawal,masuk,terima,keluar,pemakaian from tbbarang 
				left join (select tbbarang.kode, sum(belid.qty) as beliawal from tbbarang, belid where tbbarang.kode=belid.kdbarang and belid.proses='Y' 
				and month(tglbeli)<'$tgl1' and year(tglbeli)='$tahun' group by belid.kdbarang asc) as beliawal on tbbarang.kode=beliawal.kode
				left join (select tbbarang.kode, sum(belid.qty) as masuk from tbbarang, belid where tbbarang.kode=belid.kdbarang and belid.proses='Y' 
				and (month(tglbeli)>='$tgl1' and month(tglbeli)<='$tgl2' and year(tglbeli)='$tahun') group by belid.kdbarang asc) as masuk on tbbarang.kode=masuk.kode";
      $text = $text . " left join (select tbbarang.kode, sum(juald.qty) as pemakaianawal from tbbarang, juald where tbbarang.kode=juald.kdbarang and juald.proses='Y' 
				and month(tgljual)<'$tgl1' and year(tgljual)='$tahun' group by juald.kdbarang asc) as pemakaianawal on tbbarang.kode=pemakaianawal.kode
				left join (select tbbarang.kode, sum(terimad.qty) as terimaawal from tbbarang, terimad where tbbarang.kode=terimad.kdbarang and terimad.proses='Y' 
				and month(tglterima)<'$tgl1' and year(tglterima)='$tahun' group by terimad.kdbarang asc) as terimaawal on tbbarang.kode=terimaawal.kode
				left join (select tbbarang.kode, sum(terimad.qty) as terima from tbbarang, terimad where tbbarang.kode=terimad.kdbarang and terimad.proses='Y' 
				and (month(tglterima)>='$tgl1' and month(tglterima)<='$tgl2' and year(tglterima)='$tahun') group by terimad.kdbarang asc) as terima on tbbarang.kode=terima.kode";
      $text = $text . " left join (select tbbarang.kode, sum(keluard.qty) as keluarawal from tbbarang, keluard where tbbarang.kode=keluard.kdbarang and keluard.proses='Y' 
				and (month(tglkeluar)>='$tgl1' and month(tglkeluar)<='$tgl2' and year(tglkeluar)='$tahun') group by keluard.kdbarang asc) as keluarawal on tbbarang.kode=keluarawal.kode
				left join (select tbbarang.kode, sum(keluard.qty) as keluar from tbbarang, keluard where tbbarang.kode=keluard.kdbarang and keluard.proses='Y' 
				and (month(tglkeluar)>='$tgl1' and month(tglkeluar)<='$tgl2' and year(tglkeluar)='$tahun') group by keluard.kdbarang asc) as keluar on tbbarang.kode=keluar.kode
				left join (select tbbarang.kode, sum(juald.qty) as pemakaian from tbbarang, juald where tbbarang.kode=juald.kdbarang and juald.proses='Y' 
				and (month(tgljual)>='$tgl1' and month(tgljual)<='$tgl2' and year(tgljual)='$tahun') group by juald.kdbarang asc) as pemakaian on tbbarang.kode=pemakaian.kode group by tbbarang.kode asc";
      $queryh = mysqli_query($connect, "$text");
    }
    //SELECT * FROM `jualh` WHERE (month(tgljual)>=4 and year(tgljual)>=2021) and (month(tgljual)<=4 and year(tgljual)<=2021)
  }
} else {
  if (isset($_POST['check1'])) {
    if (isset($_POST['pilihan'])) {
      $tanggal = 'Semua Periode';
      $nmlaporan = "LAPORAN STOCK BARANG (PERBARANG)";
      $queryh = mysqli_query($connect, "select * from tbbarang where kode='$kdbarang' order by kode");
    } else {
      $tanggal = 'Semua Periode';
      $nmlaporan = "LAPORAN STOCK BARANG (SEMUA BARANG)";
      $queryh = mysqli_query($connect, "select * from tbbarang order by kode");
    }
  } else {
    if (isset($_POST['pilihan'])) {
      $tanggal = 'Bulan : ' . $cbulan . ', Tahun : ' . $tahun;
      $nmlaporan = "LAPORAN STOCK BARANG (PERBARANG)";
      $queryh = mysqli_query($connect, "select * from tbbarang where kode='$kdbarang' order by kode");
    } else {
      $tanggal = 'Bulan : ' . $cbulan . ', Tahun : ' . $tahun;
      $nmlaporan = "LAPORAN STOCK BARANG (SEMUA BARANG)";
      $queryh = mysqli_query($connect, "select * from tbbarang order by kode");
    }
  }
}

if ($bentuk == "Rekapitulasi") {
  echo '<style>
					td { border: 0.5px solid grey; margin: 5px;}
					th { border: 0.5px solid grey; font-weight:normal;}
					body { font-family: comic sans ms;}
		</style>
		<font size="1" face="comic sans ms">
		' . "$nm_perusahaan" . '
		<br>' . "$alamat_perusahaan" . '
		<br>' . "$telp_perusahaan" . '</font><br>
		<font size="2"><br>' . "$nmlaporan" . '
		<br>Tanggal : ' . "$tanggal" . '
		<hr size=2></hr></font>' .
    '<table table-layout="fixed"; cellpadding="0"; cellspacing="0"; style=font-size:11px; class="table table-striped table table-bordered;">
		<tr>
		<th width="30px" height="20"><font size="1" color="black">NO.</th>
		<th width="90px" ><font size="1" color="black">KODE BARANG</th>
		<th width="150px"><font size="1" color="black">NAMA BARANG</th>
		<th width="60px"><font size="1" color="black">STOCK<br>AWAL</th>
		<th width="60px"><font size="1" color="black">MASUK</th>
		<th width="60px"><font size="1" color="black">KELUAR</th>
		<th width="60px"><font size="1" color="black">STOCK<br>AKHIR</th>
		<th width="70px"><font size="1" color="black">HPP</th>
		<th width="80px"><font size="1" color="black">NILAI<br>STOCK</th>';
  $jumawal = 0;
  $jummasuk = 0;
  $jumkeluar = 0;
  $jumakhir = 0;
  $jumnilai = 0;
  while ($row = mysqli_fetch_assoc($queryh)) {
    //$tglkwitansi = date('d-m-Y', strtotime($row['tglkwitansi']));
    //$awal = intval($row['beliawal'])+intval($row['terimaawal'])-intval($row['pemakaianawal'])-intval($row['keluarawal']);
    //$awal1 = number_format($awal,2,",",".");
    $kode = $row['kode'];
    $stock = mysqli_fetch_assoc(mysqli_query($connect, "select qty from opnamed where kdbarang='$kode'"));
    if (isset($stock['qty'])) {
      $awal = $stock['qty'];
    } else {
      $awal = 0;
    }
    $awal1 = number_format($awal, 2, ",", ".");
    $masuk = intval($row['masuk']) + intval($row['terima']);
    $masuk1 = number_format($masuk, 2, ",", ".");
    $keluar = intval($row['pemakaian']) + intval($row['keluar']);
    $keluar1 = number_format($keluar, 2, ",", ".");
    $akhir = $awal + $masuk - $keluar;
    $akhir1 = number_format($akhir, 2, ",", ".");
    $hpp = number_format($row['hpp'], 0, ",", ".");
    $nilai = $akhir * intval($row['hpp']);
    $nilai1 = number_format($nilai, 0, ",", ".");
    //echo $awal1.'  '.$masuk1.'  '.$awal1.'<br>';
    echo '<tr>
				<td width="30px"  align="center">' . $no . '</td>
				<td >&nbsp;' . $row["kode"] . '</td>
				<td >&nbsp;' . $row["nama"] . '</td>
				<td  align="right">&nbsp;' . $awal1 . '&nbsp;</td>
				<td  align="right">&nbsp;' . $masuk1 . '&nbsp;</td>
				<td  align="right">&nbsp;' . $keluar1 . '&nbsp;</td>
				<td  align="right">&nbsp;' . $akhir1 . '&nbsp;</td>
				<td  align="right">&nbsp;' . $hpp . '&nbsp;</td>
				<td  align="right">&nbsp;' . $nilai1 . '&nbsp;</td>
				</tr>';
    $no++;
    $jumawal = $jumawal + $awal;
    $jummasuk = $jummasuk + $masuk;
    $jumkeluar = $jumkeluar + $keluar;
    $jumakhir = $jumakhir + $akhir;
    $jumnilai = $jumnilai + $nilai;
  }
  $jumawal = number_format($jumawal, 2, ",", ".");
  $jummasuk = number_format($jummasuk, 2, ",", ".");
  $jumkeluar = number_format($jumkeluar, 2, ",", ".");
  $jumakhir = number_format($jumakhir, 2, ",", ".");
  $jumnilai = number_format($jumnilai, 0, ",", ".");
  echo '<tr>
		<td width="30px" height="20px" colspan="3">' . '' . '</td>
		<td width="30px" height="20px" align="right">' . $jumawal . '&nbsp;</td>
		<td width="30px" height="20px" align="right">' . $jummasuk . '&nbsp;</td>
		<td width="30px" height="20px" align="right">' . $jumkeluar . '&nbsp;</td>
		<td width="30px" height="20px" align="right">' . $jumakhir . '&nbsp;</td>
		<td width="30px" height="20px" align="right">' . '' . '</td>
		<td width="30px" height="20px" align="right">' . $jumnilai . '&nbsp;</td>
		</tr>';
} else {
  echo '<style>
						td { border: 0.5px solid grey; margin: 5px;}
			            th { border: 0.5px solid grey; font-weight:normal;}
			            body { font-family: comic sans ms;}
			</style>
			<font size="1" face="comic sans ms">
			' . "$nm_perusahaan" . '
			<br>' . "$alamat_perusahaan" . '
			<br>' . "$telp_perusahaan" . '</font><br>
			<font size="2"><br>' . "$nmlaporan" . '
			<br>Tanggal : ' . "$tanggal" . '
			<hr size=2></hr></font>' .
    '<table table-layout="fixed"; cellpadding="0"; cellspacing="0"; style=font-size:11px; class="table table-striped table table-bordered;">
			<tr>
			<th width="30px" height="20"><font size="1" color="black">NO.</th>
			<th width="150px" ><font size="1" color="black">NO. DOKUMEN</th>
			<th width="60px"><font size="1" color="black">TANGGAL</th>
			<th width="60px"><font size="1" color="black">MASUK</th>
			<th width="60px"><font size="1" color="black">KELUAR</th>
			<th width="60px"><font size="1" color="black">SALDO</th>';
  while ($row = mysqli_fetch_assoc($queryh)) {
    $jumqtymasuk = 0;
    $jumqtykeluar = 0;
    $kdbarang = $row['kode'];
    $barang = $row['kode'] . ' (' . $row['nama'] . ')';
    $cari = $tahun . substr('0' . $bulan, -2);
    $qawal = mysqli_fetch_assoc(mysqli_query($connect, "select coalesce(awal,0) from stock_barang where periode='$cari' and kdbarang='$kdbarang'"));
    if (isset($qawal['awal'])) {
      $stockawal = $qawal['awal'];
    } else {
      $stockawal = 0;
    }
    $stockawalf = number_format($stockawal, 2, ",", ".");
    //echo $cari.''.$stockawal;
    echo '<tr>
				<td width="30px" height="20px" align="center">' . $no . '</td>
				<td width="30px" height="20px" colspan="4">&nbsp;' . $barang . '</td>
				<td height="20px" align="right">&nbsp;' . $stockawalf . '&nbsp;</td>
				</tr>';
    //$tglkwitansi = date('d-m-Y', strtotime($row['tglkwitansi']));
    if (isset($_POST['check1'])) {
      $queryd = mysqli_query($connect, "select tbbarang.kode,tbbarang.nama,belid.nobeli as nodokumen,belid.tglbeli tgldokumen,belid.qty as qtymasuk from tbbarang 
					left join belid on tbbarang.kode=belid.kdbarang where tbbarang.kode='$kdbarang'	and belid.proses='Y' 
					order by tbbarang.kode");
    } else {
      $queryd = mysqli_query($connect, "select tbbarang.kode,tbbarang.nama,belid.nobeli as nodokumen,belid.tglbeli tgldokumen,belid.qty as qtymasuk from tbbarang 
					left join belid on tbbarang.kode=belid.kdbarang where tbbarang.kode='$kdbarang'	and belid.proses='Y' and (month(belid.tglbeli)>='$tgl1' and month(belid.tglbeli)<='$tgl2')
					and year(belid.tglbeli)='$tahun' order by tbbarang.kode");
    }
    while ($rowd = mysqli_fetch_assoc($queryd)) {
      $qtymasuk = intval($rowd['qtymasuk']);
      $qtymasuk1 = number_format($qtymasuk, 2, ",", ".");
      $qtykeluar1 = number_format("0", 2, ",", ".");
      $jumqtymasuk = $jumqtymasuk + $qtymasuk;
      echo '<tr>
					<td height="20px">&nbsp;' . '' . '</td>
					<td height="20px">&nbsp;' . $rowd["nodokumen"] . '</td>
					<td height="20px">&nbsp;' . $rowd["tgldokumen"] . '</td>
					<td height="20px" align="right">&nbsp;' . $qtymasuk1 . '&nbsp;</td>
					<td height="20px" align="right">&nbsp;' . $qtykeluar1 . '&nbsp;</td>
					<td></td>
					</tr>';
    }
    if (isset($_POST['check1'])) {
      $queryd = mysqli_query($connect, "select terimad.kdbarang,terimad.nmbarang,terimad.noterima as nodokumen,terimad.tglterima tgldokumen,terimad.qty as qtymasuk from tbbarang 
					left join terimad on tbbarang.kode=terimad.kdbarang where terimad.kdbarang='$kdbarang' and terimad.proses='Y' 
					order by tbbarang.kode");
    } else {
      $queryd = mysqli_query($connect, "select terimad.kdbarang,terimad.nmbarang,terimad.noterima as nodokumen,terimad.tglterima tgldokumen,terimad.qty as qtymasuk from tbbarang 
					left join terimad on tbbarang.kode=terimad.kdbarang where terimad.kdbarang='$kdbarang' and terimad.proses='Y' and (month(terimad.tglterima)='$tgl1' and month(terimad.tglterima)<='$tgl2')
					and year(terimad.tglterima)='$tahun' order by tbbarang.kode");
    }
    while ($rowd = mysqli_fetch_assoc($queryd)) {
      $qtymasuk = intval($rowd['qtymasuk']);
      $qtymasuk1 = number_format($qtymasuk, 2, ",", ".");
      $qtykeluar1 = number_format("0", 2, ",", ".");
      $jumqtymasuk = $jumqtymasuk + $qtymasuk;
      echo '<tr>
					<td height="20px">&nbsp;' . '' . '</td>
					<td height="20px">&nbsp;' . $rowd["nodokumen"] . '</td>
					<td height="20px">&nbsp;' . $rowd["tgldokumen"] . '</td>
					<td height="20px" align="right">&nbsp;' . $qtymasuk1 . '&nbsp;</td>
					<td height="20px" align="right">&nbsp;' . $qtykeluar1 . '&nbsp;</td>
					<td></td>
					</tr>';
    }
    if (isset($_POST['check1'])) {
      $queryd = mysqli_query($connect, "select tbbarang.kode,tbbarang.nama,juald.nojual as nodokumen,juald.tgljual tgldokumen,juald.qty as qtykeluar from tbbarang 
					left join juald on tbbarang.kode=juald.kdbarang where tbbarang.kode='$kdbarang'	and juald.proses='Y' 
					order by tbbarang.kode");
    } else {
      $queryd = mysqli_query($connect, "select tbbarang.kode,tbbarang.nama,juald.nojual as nodokumen,juald.tgljual tgldokumen,juald.qty as qtykeluar from tbbarang 
					left join juald on tbbarang.kode=juald.kdbarang where tbbarang.kode='$kdbarang'	and juald.proses='Y' and (month(juald.tgljual)>='$tgl1' and month(juald.tgljual)<='$tgl2')
					and year(juald.tgljual)='$tahun' order by tbbarang.kode");
    }
    while ($rowd = mysqli_fetch_assoc($queryd)) {
      $qtykeluar = intval($rowd['qtykeluar']);
      $qtykeluar1 = number_format($qtykeluar, 2, ",", ".");
      $qtymasuk1 = number_format("0", 2, ",", ".");
      $jumqtykeluar = $jumqtykeluar + $qtykeluar;
      echo '<tr>
					<td height="20px">&nbsp;' . '' . '</td>
					<td height="20px">&nbsp;' . $rowd["nodokumen"] . '</td>
					<td height="20px">&nbsp;' . $rowd["tgldokumen"] . '</td>
					<td height="20px" align="right">&nbsp;' . $qtymasuk1 . '&nbsp;</td>
					<td height="20px" align="right">&nbsp;' . $qtykeluar1 . '&nbsp;</td>
					<td></td>
					</tr>';
    }
    if (isset($_POST['check1'])) {
      $queryd = mysqli_query($connect, "select tbbarang.kode,tbbarang.nama,keluard.nokeluar as nodokumen,keluard.tglkeluar tgldokumen,keluard.qty as qtykeluar from tbbarang 
					left join keluard on tbbarang.kode=keluard.kdbarang	where tbbarang.kode='$kdbarang' and keluard.proses='Y' 
					order by tbbarang.kode");
    } else {
      $queryd = mysqli_query($connect, "select tbbarang.kode,tbbarang.nama,keluard.nokeluar as nodokumen,keluard.tglkeluar tgldokumen,keluard.qty as qtykeluar from tbbarang 
					left join keluard on tbbarang.kode=keluard.kdbarang	where tbbarang.kode='$kdbarang' and keluard.proses='Y' and (month(keluard.tglkeluar)>='$tgl1' and month(keluard.tglkeluar)<='$tgl2')
					and year(keluard.tglkeluar)='$tahun' order by tbbarang.kode");
    }
    while ($rowd = mysqli_fetch_assoc($queryd)) {
      $qtykeluar = intval($rowd['qtykeluar']);
      $qtykeluar1 = number_format($qtykeluar, 2, ",", ".");
      $qtymasuk1 = number_format("0", 2, ",", ".");
      $jumqtykeluar = $jumqtykeluar + $qtykeluar;
      echo '<tr>
					<td height="20px">&nbsp;' . '' . '</td>
					<td height="20px">&nbsp;' . $rowd["nodokumen"] . '</td>
					<td height="20px">&nbsp;' . $rowd["tgldokumen"] . '</td>
					<td height="20px" align="right">&nbsp;' . $qtymasuk1 . '&nbsp;</td>
					<td height="20px" align="right">&nbsp;' . $qtykeluar1 . '&nbsp;</td>
					<td></td>
					</tr>';
    }
    $no++;
    $jumqtymasuk = number_format($jumqtymasuk, 2, ",", ".");
    $jumqtykeluar = number_format($jumqtykeluar, 2, ",", ".");
    $cari = $tahun . substr('0' . $bulan, -2);
    $qawal = mysqli_fetch_assoc(mysqli_query($connect, "select * from stock_barang where periode='$cari' and kdbarang='$kdbarang'"));
    if (isset($qawal['akhir'])) {
      $stockakhir = $qawal['akhir'];
    } else {
      $stockakhir = 0;
    }
    $stockakhirf = number_format($stockakhir, 2, ",", ".");
    echo '<tr><td colspan="3" height="20px" align="right">&nbsp;' . "Total" . '&nbsp;</td>
				<td height="20px" align="right">&nbsp;' . $jumqtymasuk . '&nbsp;</td>
				<td height="20px" align="right">&nbsp;' . $jumqtykeluar . '&nbsp;</td>
				<td height="20px" align="right">&nbsp;' . $stockakhirf . '&nbsp;</td>
				</tr>';
  }
}
echo '</table><font size="1"><left>Tanggal cetak : ' . date('d-m-Y H:i:s a');
