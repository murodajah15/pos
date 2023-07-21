<?php
	include 'cek_akses.php';
	$user = $_SESSION['username'];
?>
<?php
	if ($aksesok == 'Y') {
    ?>
		<font face="calibri">
			<h3>Reset Database / Menghapus Record / Menghapus Data</h3>
			<hr size="10px">
			<form method='post' action='module/reset/proses.php'> <!--checked ="checked"-->
        <h4><input type='checkbox' id="checkall_resetfile"/> File</h4>
        <div class="col-md-4 bg">
				  <input type='checkbox' name='tbbarang'> Tabel Barang<br>
          <input type='checkbox' name='tbgudang'> Tabel Gudang<br>
          <input type='checkbox' name='tbjntrans'> Tabel Jenis Transaksi<br>
          <input type='checkbox' name='tbjnbrg'> Tabel Jenis Barang<br>
          <input type='checkbox' name='tbsatuan'> Tabel Satuan<br>
        </div>
        <div class="col-md-4 bg">
          <input type='checkbox' name='tbnegara'> Tabel Negara<br>
          <input type='checkbox' name='tbmove'> Tabel Perputaran Barang<br>
          <input type='checkbox' name='tbdiscount'> Tabel Discount<br>
          <input type='checkbox' name='tbcustomer'> Tabel Customer<br>
          <input type='checkbox' name='tbsupplier'> Tabel Supplier<br>
        </div>
        <div class="col-md-4 bg">
        <input type='checkbox' name='tbmultiprc'> Tabel Multi Price<br>
          <input type='checkbox' name='tbsales'> Tabel Sales<br>
          <input type='checkbox' name='tbbank'> Tabel Bank<br>
          <input type='checkbox' name='tbjnkeluar'> Tabel Jenis Pengeluaran<br><br><br>
        </div>
        <h4><input type='checkbox' id="checkall_resettransaksi"/> Transaksi</h4>
        <div class="col-md-4 bg">
				  <input type='checkbox' name='so'> Sales Order<br>
          <input type='checkbox' name='jual'> Pejualan<br>
          <input type='checkbox' name='po'> Purchase Order (PO)<br>
          <input type='checkbox' name='beli'> Penerimaan Pembelian<br>
        </div>
        <div class="col-md-4 bg">
          <input type='checkbox' name='terima'> Penerimaan Barang<br>
          <input type='checkbox' name='keluar'> Pengeluaran Barang<br>
          <input type='checkbox' name='opname'> Stock Opname<br>
          <input type='checkbox' name='approv'> Approval Batas Piutang<br>
        </div>
        <div class="col-md-4 bg">
        <input type='checkbox' name='kasir_tunai'> Kasir Penerimaan Tunai<br>
          <input type='checkbox' name='kasir_tagihan'> Kasir Penerimaan Tagihan<br>
          <input type='checkbox' name='moh_keluar'> Permohonan Keluar Uang<br>
          <input type='checkbox' name='keluar_uang'> Kasir Pengeluaran Uang<br><br><br>
        </div>
        <!-- <p align="center"> -->
				<br><button type='submit' class='btn btn-danger'>Proses Reset</button>
        <!-- </p> -->
			</form>
		</font>
	<?php
	}else{
		echo "<font color='red'>Anda tidak punya hak !</font>";
	}
?>

