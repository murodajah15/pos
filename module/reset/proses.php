<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
  <?php
      session_start();
      include "../../timeout.php";
      if($_SESSION['login']==1){
      if(!cek_login()){
        $_SESSION['login']=0;
      }
      }
    if($_SESSION['login']==0){
      header('location:../../logout.php');
    }
    // echo $_GET['so'];
    //require_once "koneksi.php";
    include "../../inc/config.php";
    $cfile = "";
    if (isset($_GET['tbbarang_r']) and $_GET['tbbarang_r']=='true') {
      $query = mysqli_query($connect,'delete from tbbarang');
      if ($query>0){
        $cfile = $cfile.'tbbarang'.'<br>';
      }
    }
    if (isset($_GET['tbgudang_r']) and $_GET['tbgudang_r']=='true') {
      $query = mysqli_query($connect,'delete from tbgudang');
      if ($query>0){
        $cfile = $cfile.'tbgudang'.'<br>';
      }
    }
    if (isset($_GET['tbjntrans_r']) and $_GET['tbjntrans_r']=='true') {
      $query = mysqli_query($connect,'delete from tbjntrans');
      if ($query>0){
        $cfile = $cfile.'tbjntrans'.'<br>';
      }
    }    
    if (isset($_GET['tbjnbrg_r']) and $_GET['tbjnbrg_r']=='true') {
      $query = mysqli_query($connect,'delete from tbjnbrg');
      if ($query>0){
        $cfile = $cfile.'tbjnbrg'.'<br>';
      }
    }        
    if (isset($_GET['tbsatuan_r']) and $_GET['tbsatuan_r']=='true') {
      $query = mysqli_query($connect,'delete from tbsatuan');
      if ($query>0){
        $cfile = $cfile.'tbsatuan'.'<br>';
      }
    }        
    if (isset($_GET['tbnegara_r']) and $_GET['tbnegara_r']=='true') {
      $query = mysqli_query($connect,'delete from tbnegara');
      if ($query>0){
        $cfile = $cfile.'tbnegara'.'<br>';
      }
    }        
    if (isset($_GET['tbmove_r']) and $_GET['tbmove_r']=='true') {
      $query = mysqli_query($connect,'delete from tbmove');
      if ($query>0){
        $cfile = $cfile.'tbmove'.'<br>';
      }
    }        
    if (isset($_GET['tbdiscount_r']) and $_GET['tbdiscount_r']=='true') {
      $query = mysqli_query($connect,'delete from tbdiscount');
      if ($query>0){
        $cfile = $cfile.'tbdiscount'.'<br>';
      }
    }        
    if (isset($_GET['tbcustomer_r']) and $_GET['tbcustomer_r']=='true') {
      $query = mysqli_query($connect,'delete from tbcustomer');
      if ($query>0){
        $cfile = $cfile.'tbcustomer'.'<br>';
      }
    }        
    if (isset($_GET['tbsupplier_r']) and $_GET['tbsupplier_r']=='true') {
      $query = mysqli_query($connect,'delete from tbsupplier');
      if ($query>0){
        $cfile = $cfile.'tbsupplier'.'<br>';
      }
    }        
    if (isset($_GET['tbmultiprc_r']) and $_GET['tbmultiprc_r']=='true') {
      $query = mysqli_query($connect,'delete from tbmultiprc');
      if ($query>0){
        $cfile = $cfile.'tbmultiprc'.'<br>';
      }
    }        
    if (isset($_GET['tbsales_r']) and $_GET['tbsales_r']=='true') {
      $query = mysqli_query($connect,'delete from tbsales');
      if ($query>0){
        $cfile = $cfile.'tbsales'.'<br>';
      }
    }        
    if (isset($_GET['tbbank_r']) and $_GET['tbbank_r']=='true') {
      $query = mysqli_query($connect,'delete from tbbank');
      if ($query>0){
        $cfile = $cfile.'tbbank'.'<br>';
      }
    }        
    if (isset($_GET['tbjnkeluar_r']) and $_GET['tbjnkeluar_r']=='true') {
      $query = mysqli_query($connect,'delete from tbjnkeluar');
      if ($query>0){
        $cfile = $cfile.'tbjnkeluar'.'<br>';
      }
    }        
    if (isset($_GET['so']) and $_GET['so']=='true') {
      $query = mysqli_query($connect,'delete from soh');
      if ($query>0){
        $cfile = $cfile.'SO'.'<br>';
        mysqli_query($connect,'delete from sod');
      }
    }        
    if (isset($_GET['jual']) and $_GET['jual']=='true') {
      $query = mysqli_query($connect,'delete from jualh');
      if ($query>0){
        $cfile = $cfile.'Jual'.'<br>';
        mysqli_query($connect,'delete from juald');
      }
    }        
    if (isset($_GET['po']) and $_GET['po']=='true') {
      $query = mysqli_query($connect,'delete from poh');
      if ($query>0){
        $cfile = $cfile.'PO'.'<br>';
        mysqli_query($connect,'delete from pod');
      }
    }        
    if (isset($_GET['beli']) and $_GET['beli']=='true') {
      $query = mysqli_query($connect,'delete from belih');
      if ($query>0){
        $cfile = $cfile.'Pembelian'.'<br>';
        mysqli_query($connect,'delete from belid');
      }
    }        
    if (isset($_GET['terima']) and $_GET['terima']=='true') {
      $query = mysqli_query($connect,'delete from terimah');
      if ($query>0){
        $cfile = $cfile.'Penerimaan'.'<br>';
        mysqli_query($connect,'delete from terimad');
      }
    }        
    if (isset($_GET['keluar']) and $_GET['keluar']=='true') {
      $query = mysqli_query($connect,'delete from keluarh');
      if ($query>0){
        $cfile = $cfile.'Pengeluaran'.'<br>';
        mysqli_query($connect,'delete from keluard');
      }
    }        
    if (isset($_GET['opname']) and $_GET['opname']=='true') {
      $query = mysqli_query($connect,'delete from opnameh');
      if ($query>0){
        $cfile = $cfile.'Opname'.'<br>';
        mysqli_query($connect,'delete from opnamed');
      }
    }        
    if (isset($_GET['approv']) and $_GET['approv']=='true') {
      $query = mysqli_query($connect,'delete from approv_batas_piutang');
      if ($query>0){
        $cfile = $cfile.'Approv_batas_piutang'.'<br>';
      }
    }        
    if (isset($_GET['kasir_tunai']) and $_GET['kasir_tunai']=='true') {
      $query = mysqli_query($connect,'delete from kasir_tunai');
      if ($query>0){
        $cfile = $cfile.'Kasir_tunai'.'<br>';
      }
    }        
    if (isset($_GET['kasir_tagihan']) and $_GET['kasir_tagihan']=='true') {
      $query = mysqli_query($connect,'delete from kasir_tagihan');
      if ($query>0){
        $cfile = $cfile.'Kasir_tagihan'.'<br>';
      }
    }        
    if (isset($_GET['moh_keluar']) and $_GET['moh_keluar']=='true') {
      $query = mysqli_query($connect,'delete from mohklruangh');
      if ($query>0){
        $cfile = $cfile.'mohklruang'.'<br>';
        mysqli_query($connect,'delete from mohklruangd');
      }
    }        
    if (isset($_GET['keluar_uang']) and $_GET['keluar_uang']=='true') {
      $query = mysqli_query($connect,'delete from kasir_keluarh');
      if ($query>0){
        $cfile = $cfile.'keluar_uang'.'<br>';
        mysqli_query($connect,'delete from kasir_keluard');
      }
    }        
    echo $cfile;
    if ($cfile<>""){
    ?>
      <script>
        swal({title: "Data Berhasil direset ", text: "", icon: 
        "success"}).then(function(){window.location.href='../../dashboard.php?m=reset';
          }
        );
      </script>
    <?php  
    }else{
    ?>
      <script>
        swal({title: "Tidak ada Data yang direset ", text: "", icon: 
        "error"}).then(function(){window.location.href='../../dashboard.php?m=reset';
            }
        );
      </script>
      <?php      
    }
    $cfile ="";
  ?>
</body>