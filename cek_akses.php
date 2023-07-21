<?php
$aksesok = 'N';
if (isset($_GET['m'])) {
	$username = $_SESSION['username'];
	switch ($_GET['m']) {
		case 'tbbarang':
			$sql = mysqli_query($connect, "select * from userdtl where cmodule='Tabel Barang' and username='$username'");
			include "hak_akses.php";
			break;
		case 'tbgudang':
			$sql = mysqli_query($connect, "select * from userdtl where cmodule='Tabel Gudang' and username='$username'");
			include "hak_akses.php";
			break;
		case 'tbjntrans':
			$sql = mysqli_query($connect, "select * from userdtl where cmodule='Tabel Jenis Transaksi' and username='$username'");
			include "hak_akses.php";
			break;
		case 'tbjnbrg':
			$sql = mysqli_query($connect, "select * from userdtl where cmodule='Tabel Jenis Barang' and username='$username'");
			include "hak_akses.php";
			break;
		case 'tbsatuan':
			$sql = mysqli_query($connect, "select * from userdtl where cmodule='Tabel Satuan' and username='$username'");
			include "hak_akses.php";
			break;
		case 'tbnegara':
			$sql = mysqli_query($connect, "select * from userdtl where cmodule='Tabel Negara' and username='$username'");
			include "hak_akses.php";
			break;
		case 'tbmove':
			$sql = mysqli_query($connect, "select * from userdtl where cmodule='Tabel Perputaran Barang' and username='$username'");
			include "hak_akses.php";
			break;
		case 'tbdiscount':
			$sql = mysqli_query($connect, "select * from userdtl where cmodule='Tabel Discount' and username='$username'");
			include "hak_akses.php";
			break;
		case 'tbcustomer':
			$sql = mysqli_query($connect, "select * from userdtl where cmodule='Tabel Customer' and username='$username'");
			include "hak_akses.php";
			break;
		case 'tbsupplier':
			$sql = mysqli_query($connect, "select * from userdtl where cmodule='Tabel Supplier' and username='$username'");
			include "hak_akses.php";
			break;
		case 'tbmultiprc':
			$sql = mysqli_query($connect, "select * from userdtl where cmodule='Tabel Multi Price' and username='$username'");
			include "hak_akses.php";
			break;
		case 'tbsales':
			$sql = mysqli_query($connect, "select * from userdtl where cmodule='Tabel Sales' and username='$username'");
			include "hak_akses.php";
			break;
		case 'tbbank':
			$sql = mysqli_query($connect, "select * from userdtl where cmodule='Tabel Bank' and username='$username'");
			include "hak_akses.php";
			break;
		case 'tbjnkeluar':
			$sql = mysqli_query($connect, "select * from userdtl where cmodule='Tabel Jenis Pengeluaran' and username='$username'");
			include "hak_akses.php";
			break;

			// Transaksi
		case 'so':
			$sql = mysqli_query($connect, "select * from userdtl where cmodule='Sales Order' and username='$username'");
			include "hak_akses.php";
			break;
		case 'jual':
			$sql = mysqli_query($connect, "select * from userdtl where cmodule='Penjualan' and username='$username'");
			include "hak_akses.php";
			break;
		case 'po':
			$sql = mysqli_query($connect, "select * from userdtl where cmodule='Purchase Order (PO)' and username='$username'");
			include "hak_akses.php";
			break;
		case 'beli':
			$sql = mysqli_query($connect, "select * from userdtl where cmodule='Penerimaan Pembelian' and username='$username'");
			include "hak_akses.php";
			break;
		case 'opname':
			$sql = mysqli_query($connect, "select * from userdtl where cmodule='Stock Opname' and username='$username'");
			include "hak_akses.php";
			break;
		case 'approv_batas_piutang':
			$sql = mysqli_query($connect, "select * from userdtl where cmodule='Approval Batas Piutang' and username='$username'");
			include "hak_akses.php";
			break;
		case 'terima':
			$sql = mysqli_query($connect, "select * from userdtl where cmodule='Penerimaan Barang' and username='$username'");
			include "hak_akses.php";
			break;
		case 'keluar':
			$sql = mysqli_query($connect, "select * from userdtl where cmodule='Pengeluaran Barang' and username='$username'");
			include "hak_akses.php";
			break;
		case 'kasir_tunai':
			$sql = mysqli_query($connect, "select * from userdtl where cmodule='Kasir Penerimaan Tunai' and username='$username'");
			include "hak_akses.php";
			break;
		case 'kasir_tagihan':
			$sql = mysqli_query($connect, "select * from userdtl where cmodule='Kasir Penerimaan Tagihan' and username='$username'");
			include "hak_akses.php";
			break;
		case 'permohonan_keluar_uang':
			$sql = mysqli_query($connect, "select * from userdtl where cmodule='Permohonan Keluar Uang' and username='$username'");
			include "hak_akses.php";
			break;
		case 'kasir_keluar':
			$sql = mysqli_query($connect, "select * from userdtl where cmodule='Kasir Pengeluaran Uang' and username='$username'");
			include "hak_akses.php";
			break;

			// Report
		case 'rfaktur':
			$sql = mysqli_query($connect, "select * from userdtl where cmodule='Laporan Faktur Harian' and username='$username'");
			include "hak_akses.php";
			break;
		case 'rso':
			$sql = mysqli_query($connect, "select * from userdtl where cmodule='Laporan Sales Order' and username='$username'");
			include "hak_akses.php";
			break;
		case 'rjual':
			$sql = mysqli_query($connect, "select * from userdtl where cmodule='Laporan Penjualan' and username='$username'");
			include "hak_akses.php";
			break;
		case 'rpo':
			$sql = mysqli_query($connect, "select * from userdtl where cmodule='Laporan Purchase Order (PO)' and username='$username'");
			include "hak_akses.php";
			break;
		case 'rbeli':
			$sql = mysqli_query($connect, "select * from userdtl where cmodule='Laporan Penerimaan Pembelian' and username='$username'");
			include "hak_akses.php";
			break;
		case 'rterima':
			$sql = mysqli_query($connect, "select * from userdtl where cmodule='Laporan Penerimaan Barang' and username='$username'");
			include "hak_akses.php";
			break;
		case 'rkeluar':
			$sql = mysqli_query($connect, "select * from userdtl where cmodule='Laporan Pengeluaran' and username='$username'");
			include "hak_akses.php";
			break;
		case 'rkasir_tunai':
			$sql = mysqli_query($connect, "select * from userdtl where cmodule='Laporan Kasir Tunai' and username='$username'");
			include "hak_akses.php";
			break;
		case 'rkasir_tagihan':
			$sql = mysqli_query($connect, "select * from userdtl where cmodule='Laporan Kasir Tagihan' and username='$username'");
			include "hak_akses.php";
			break;
		case 'rpermohonan_keluar_uang':
			$sql = mysqli_query($connect, "select * from userdtl where cmodule='Laporan Permohonan Keluar Uang' and username='$username'");
			include "hak_akses.php";
			break;
		case 'rkasir_keluar':
			$sql = mysqli_query($connect, "select * from userdtl where cmodule='Laporan Kasir Pengeluaran Uang' and username='$username'");
			include "hak_akses.php";
			break;
		case 'rpiutang':
			$sql = mysqli_query($connect, "select * from userdtl where cmodule='Laporan Piutang' and username='$username'");
			include "hak_akses.php";
			break;
		case 'rhutang':
			$sql = mysqli_query($connect, "select * from userdtl where cmodule='Laporan Hutang' and username='$username'");
			include "hak_akses.php";
			break;
		case 'rstock':
			$sql = mysqli_query($connect, "select * from userdtl where cmodule='Laporan Stock Barang' and username='$username'");
			include "hak_akses.php";
			break;
		case 'rstock_opname':
			$sql = mysqli_query($connect, "select * from userdtl where cmodule='Laporan Stock Opname' and username='$username'");
			include "hak_akses.php";
			break;

			// Proses
		case 'closing_harian':
			$sql = mysqli_query($connect, "select * from userdtl where cmodule='Closing Harian' and username='$username'");
			include "hak_akses.php";
			break;
		case 'closing_hpp':
			$sql = mysqli_query($connect, "select * from userdtl where cmodule='Closing HPP' and username='$username'");
			include "hak_akses.php";
			break;

			// Utility
		case 'saplikasi':
			$kelompok = $_SESSION['level'];
			if ($kelompok == 'ADMINISTRATOR') {
				$aksesok = 'Y';
			} else {
				$aksesok = 'N';
			}
			break;
		case 'tbmodule':
			$kelompok = $_SESSION['level'];
			if ($kelompok == 'ADMINISTRATOR') {
				$aksesok = 'Y';
			} else {
				$aksesok = 'N';
			}
			break;
		case 'backup':
			$kelompok = $_SESSION['level'];
			if ($kelompok == 'ADMINISTRATOR') {
				$aksesok = 'Y';
			} else {
				$aksesok = 'N';
			}
			break;
		case 'reset':
			$kelompok = $_SESSION['level'];
			if ($kelompok == 'ADMINISTRATOR') {
				$aksesok = 'Y';
			} else {
				$aksesok = 'N';
			}
			break;
		case 'restore':
			$kelompok = $_SESSION['level'];
			if ($kelompok == 'ADMINISTRATOR') {
				$aksesok = 'Y';
			} else {
				$aksesok = 'N';
			}
			break;
		case 'user':
			$kelompok = $_SESSION['level'];
			if ($kelompok == 'ADMINISTRATOR') {
				$aksesok = 'Y';
			} else {
				$aksesok = 'N';
			}
			break;
		case 'hisuser':
			$kelompok = $_SESSION['level'];
			if ($kelompok == 'ADMINISTRATOR') {
				$aksesok = 'Y';
			} else {
				$aksesok = 'N';
			}
			break;

		default:
			echo "<h3>Module tidak ditemukan</h3><font color='#FF000'<p>Under Development ... !</p></font>";
			break;
	}
}
