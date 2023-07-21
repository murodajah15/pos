<?php
/*if (isset($_GET['m'])){
    if($_GET['m']=='pameran'){
        include "module/pameran/pameran.php";
    }
    else{
        echo "<h3>Module tidak ditemukan</h3><font color='#FF000'<p>Under Development ... !</p></font>";
    }
    }else{
            echo "<h3>Selamat Datang Administrator</h3>
            <p>Anda Login dengan nama : $_SESSION[nama]</p>";

    }**/
if (isset($_GET['m'])) {
	switch ($_GET['m']) {
			//File
		case 'tbbarang':
			include "module/tbbarang/tbbarang.php";
			break;
		case 'tbgudang':
			include "module/tbgudang/tbgudang.php";
			break;
		case 'tbjntrans':
			include "module/tbjntrans/tbjntrans.php";
			break;
		case 'tbjnbrg':
			include "module/tbjnbrg/tbjnbrg.php";
			break;
		case 'tbsatuan':
			include "module/tbsatuan/tbsatuan.php";
			break;
		case 'tbnegara':
			include "module/tbnegara/tbnegara.php";
			break;
		case 'tbmove':
			include "module/tbmove/tbmove.php";
			break;
		case 'tbsatuan':
			include "module/tbsatuan/tbsatuan.php";
			break;
		case 'tbdiscount':
			include "module/tbdiscount/tbdiscount.php";
			break;
		case 'tbcustomer':
			include "module/tbcustomer/tbcustomer.php";
			break;
		case 'tbsupplier':
			include "module/tbsupplier/tbsupplier.php";
			break;
		case 'tbmultiprc':
			include "module/tbmultiprc/tbmultiprc.php";
			break;
		case 'tbsales':
			include "module/tbsales/tbsales.php";
			break;
		case 'tbbank':
			include "module/tbbank/tbbank.php";
			//include "datatables.php";
			break;
		case 'tbkota':
			include "module/tbkota/tbkota.php";
			break;
		case 'tbjnkeluar':
			include "module/tbjnkeluar/tbjnkeluar.php";
			break;

			//Transaksi
		case 'so':
			include "module/so/so.php";
			break;
		case 'jual':
			include "module/jual/jual.php";
			break;
		case 'po':
			include "module/po/po.php";
			break;
		case 'beli':
			include "module/beli/beli.php";
			break;
		case 'terima':
			include "module/terima/terima.php";
			break;
		case 'keluar':
			include "module/keluar/keluar.php";
			break;
		case 'opname':
			include "module/opname/opname.php";
			break;
		case 'approv_batas_piutang':
			include "module/approv_batas_piutang/approv_batas_piutang.php";
			break;
		case 'kasir_tunai':
			include "module/kasir_tunai/kasir_tunai.php";
			break;
		case 'kasir_tagihan':
			include "module/kasir_tagihan/kasir_tagihan.php";
			break;
		case 'permohonan_keluar_uang':
			include "module/permohonan_keluar_uang/permohonan_keluar_uang.php";
			break;
		case 'kasir_keluar':
			include "module/kasir_keluar/kasir_keluar.php";
			break;

			//Report
		case 'rfaktur':
			include "report/rfaktur.php";
			break;
		case 'rso':
			include "report/rso.php";
			break;
		case 'rjual':
			include "report/rjual.php";
			break;
		case 'rpo':
			include "report/rpo.php";
			break;
		case 'rbeli':
			include "report/rbeli.php";
			break;
		case 'rterima':
			include "report/rterima.php";
			break;
		case 'rkeluar':
			include "report/rkeluar.php";
			break;
		case 'rkasir_tunai':
			include "report/rkasir_tunai.php";
			break;
		case 'rkasir_tagihan':
			include "report/rkasir_tagihan.php";
			break;
		case 'rpermohonan_keluar_uang':
			include "report/rpermohonan_keluar_uang.php";
			break;
		case 'rkasir_keluar':
			include "report/rkasir_keluar.php";
			break;
		case 'rpiutang':
			include "report/rpiutang.php";
			break;
		case 'rhutang':
			include "report/rhutang.php";
			break;
		case 'rstock':
			include "report/rstock.php";
			break;
		case 'rstock_opname':
			include "report/rstock_opname.php";
			break;

			//Proses
		case 'closing_harian':
			include "module/closing/closing_harian.php";
			break;
		case 'closing_hpp':
			include "module/closing/closing_hpp.php";
			break;

			//Utility
		case 'saplikasi':
			include "module/saplikasi/saplikasi.php";
			break;
		case 'tbmodule':
			include "module/tbmodule/tbmodule.php";
			break;
		case 'user':
			include "module/user/user.php";
			break;
		case 'rubahpass':
			include "module/user/rubahpass.php";
			break;
		case 'updateprofile':
			include "module/user/updateprofile.php";
			break;
		case 'backup':
			include "module/user/backup.php";
			break;
		case 'reset':
			include "module/reset/reset.php";
			break;
		case 'restore':
			include "module/user/restore.php";
			break;
		case 'user_login':
			include "module/user/user_login.php";
			break;
		case 'hisuser':
			include "module/hisuser/hisuser.php";
			break;
		default:
			echo "<h3>Module tidak ditemukan</h3><font color='#FF000'<p>Under Development ... !</p></font>";
			break;
	}
} else {
	/*echo "<h4>Selamat Datang $_SESSION[nama]</h4>";**/

	/*echo "<span style='black: white'><h4>Selamat Datang $_SESSION[nama]</h4></span>";
	/*echo "<span style='color: white'><h1>di CMS Honda Autoland</h1></span><br>";**/
	/*echo '<marquee direction="right" scrollamount="2" align="center" behavior="alternate"><span style="color: blue"><h1>di CMS Honda Autoland</h1></span></marquee>';**/
	/*include("statistik_view.php");**/
}
