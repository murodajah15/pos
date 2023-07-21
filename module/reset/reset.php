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
    <form method='post'>
      <h4><input type='checkbox' id="checkall_resetfile" /> File</h4>
      <div class="col-md-4 bg">
        <input type='checkbox' name='tbbarang_r' id='tbbarang_r'> Tabel Barang<br>
        <input type='checkbox' name='tbgudang_r' id='tbgudang_r'> Tabel Gudang<br>
        <input type='checkbox' name='tbjntrans_r' id='tbjntrans_r'> Tabel Jenis Transaksi<br>
        <input type='checkbox' name='tbjnbrg_r' id='tbjnbrg_r'> Tabel Jenis Barang<br>
        <input type='checkbox' name='tbsatuan_r' id='tbsatuan_r'> Tabel Satuan<br>
      </div>
      <div class="col-md-4 bg">
        <input type='checkbox' name='tbnegara_r' id='tbnegara_r'> Tabel Negara<br>
        <input type='checkbox' name='tbmove_r' id='tbmove_r'> Tabel Perputaran Barang<br>
        <input type='checkbox' name='tbdiscount_r' id='tbdiscount_r'> Tabel Discount<br>
        <input type='checkbox' name='tbcustomer_r' id='tbcustomer_r'> Tabel Customer<br>
        <input type='checkbox' name='tbsupplier_r' id='tbsupplier_r'> Tabel Supplier<br>
      </div>
      <div class="col-md-4 bg">
        <input type='checkbox' name='tbmultiprc_r' id='tbmultiprc_r'> Tabel Multi Price<br>
        <input type='checkbox' name='tbsales_r' id='tbsales_r'> Tabel Sales<br>
        <input type='checkbox' name='tbbank_r' id='tbbank_r'> Tabel Bank<br>
        <input type='checkbox' name='tbjnkeluar_r' id='tbjnkeluar_r'> Tabel Jenis Pengeluaran<br><br><br>
      </div>
      <h4><input type='checkbox' id="checkall_resettransaksi" /> Transaksi</h4>
      <div class="col-md-4 bg">
        <input type='checkbox' name='so' id='so' value='1'> Sales Order<br>
        <input type='checkbox' name='jual' id='jual'> Pejualan<br>
        <input type='checkbox' name='po' id='po'> Purchase Order (PO)<br>
        <input type='checkbox' name='beli' id='beli'> Penerimaan Pembelian<br>
      </div>
      <div class="col-md-4 bg">
        <input type='checkbox' name='terima' id='terima'> Penerimaan Barang<br>
        <input type='checkbox' name='keluar' id='keluar'> Pengeluaran Barang<br>
        <input type='checkbox' name='opname' id='opname'> Stock Opname<br>
        <input type='checkbox' name='approv' id='approv'> Approval Batas Piutang<br>
      </div>
      <div class="col-md-4 bg">
        <input type='checkbox' name='kasir_tunai' id='kasir_tunai'> Kasir Penerimaan Tunai<br>
        <input type='checkbox' name='kasir_tagihan' id='kasir_tagihan'> Kasir Penerimaan Tagihan<br>
        <input type='checkbox' name='moh_keluar' id='moh_keluar'> Permohonan Keluar Uang<br>
        <input type='checkbox' name='keluar_uang' id='keluar_uang'> Kasir Pengeluaran Uang<br><br><br>
      </div>
      <!-- <p align="center"> -->
      <br><button type='button' class='btn btn-danger' onClick='alert_proses()'>Proses Reset</button>
      <button type='button' class='btn btn-warning' onClick='proses_alter()'>Proses Alter Default Value</button>
      <!-- </p> -->
    </form>
  </font>
<?php
} else {
  echo "<font color='red'>Anda tidak punya hak !</font>";
}
?>

<script>
  function alert_proses() {
    swal({
        title: "Yakin akan direset ?",
        text: "Once deleted, you will not be able to recover this data!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          var $tbbarang_r = document.getElementById('tbbarang_r').checked;
          var $tbgudang_r = document.getElementById('tbgudang_r').checked;
          var $tbjntrans_r = document.getElementById('tbjntrans_r').checked;
          var $tbjnbrg_r = document.getElementById('tbjnbrg_r').checked;
          var $tbsatuan_r = document.getElementById('tbsatuan_r').checked;
          var $tbnegara_r = document.getElementById('tbnegara_r').checked;
          var $tbmove_r = document.getElementById('tbmove_r').checked;
          var $tbdiscount_r = document.getElementById('tbdiscount_r').checked;
          var $tbcustomer_r = document.getElementById('tbcustomer_r').checked;
          var $tbsupplier_r = document.getElementById('tbsupplier_r').checked;
          var $tbmultiprc_r = document.getElementById('tbmultiprc_r').checked;
          var $tbsales_r = document.getElementById('tbsales_r').checked;
          var $tbbank_r = document.getElementById('tbbank_r').checked;
          var $tbjnkeluar_r = document.getElementById('tbjnkeluar_r').checked;

          var $so = document.getElementById('so').checked;
          var $jual = document.getElementById('jual').checked;
          var $po = document.getElementById('po').checked;
          var $beli = document.getElementById('beli').checked;
          var $terima = document.getElementById('terima').checked;
          var $keluar = document.getElementById('keluar').checked;
          var $opname = document.getElementById('opname').checked;
          var $approv = document.getElementById('approv').checked;
          var $kasir_tunai = document.getElementById('kasir_tunai').checked;
          var $kasir_tagihan = document.getElementById('kasir_tagihan').checked;
          var $moh_keluar = document.getElementById('moh_keluar').checked;
          var $keluar_uang = document.getElementById('keluar_uang').checked;
          var cek = $tbbarang_r + '&tbgudang_r=' + $tbgudang_r + '&tbjntrans_r=' + $tbjntrans_r + '&tbjnbrg_r=' + $tbjnbrg_r + '&tbsatuan_r=' + $tbsatuan_r +
            '&tbnegara_r=' + $tbnegara_r + '&tbmove_r=' + $tbmove_r + '&tbdiscount_r=' + $tbdiscount_r + '&tbcustomer_r=' + $tbcustomer_r +
            '&tbsupplier_r=' + $tbsupplier_r + '&tbmultiprc_r=' + $tbmultiprc_r + '&tbsales_r=' + $tbsales_r + '&tbbank_r=' + $tbbank_r + '&tbjnkeluar_r=' + $tbjnkeluar_r +
            '&so=' + $so + '&jual=' + $jual + '&po=' + $po + '&beli=' + $beli + '&terima=' + $terima + '&keluar=' + $keluar + '&opname=' + $opname +
            '&approv=' + $approv + '&kasir_tunai=' + $kasir_tunai + '&moh_keluar=' + $moh_keluar + '&keluar_uang=' + $keluar_uang;
          $href = "module/reset/proses.php?tbbarang_r=" + cek;
          window.location.href = $href;
          // swal("Poof! Your imaginary file has been deleted!", {
          //   icon: "success",
          // });
        } else {
          swal("Batal Reset!");
        }
      });
  };

  function proses_alter() {
    swal({
        title: "Yakin akan Alter ?",
        text: "Proses ini akan mengupdate nilai default structure table",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $href = "module/reset/alter_table_default_value.php";
          window.location.href = $href;
          // swal("Poof! Your imaginary file has been deleted!", {
          //   icon: "success",
          // });
        } else {
          swal("Batal!");
        }
      });
  };
</script>