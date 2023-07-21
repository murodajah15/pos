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
  //require_once "koneksi.php";
  include "../../inc/config.php";
  include "../../terbilang.php";
  include "../../tgl_indo.php";
  date_default_timezone_set('Asia/Jakarta');
  $id = $_GET['id'];
  $who = "Update-".$_SESSION['username']."-".date('d-m-Y H:i:s');
  $nm_perusahaan = $_SESSION['nm_perusahaan'];
  $alamat_perusahaan = $_SESSION['alamat_perusahaan'];
  $telp_perusahaan = $_SESSION['telp_perusahaan'];
  $no=1;

  $queryh = mysqli_query($connect,"select * from jualh where id='$id' and jualh.proses='Y' order by nojual");
  $de = mysqli_fetch_assoc($queryh);
  $nojual = $de['nojual'];
  $tanggal = tgl_indo($de['tgljual']); // $de['tgljual'];
  $kdcustomer = $de['kdcustomer'];
  $nmcustomer = $de['nmcustomer'];
  $biaya_lain = $de['biaya_lain'];
  $total = $de['total'];
  $customer = $de['kdcustomer'].'-'.$de['nmcustomer'];
  $queryh = mysqli_query($connect,"select * from tbcustomer where kode='$kdcustomer'");
  $de = mysqli_fetch_assoc($queryh);
  $alamatcust = $de['alamat'].' '.$de['kota'].' '.$de['kodepos'];
  $telpcust = $de['telp1'].' - '.$de['telp2'];

  $tmpdir = sys_get_temp_dir();   # ambil direktori temporary untuk simpan file.
  $file =  tempnam($tmpdir, 'ctk');  # nama file temporary yang akan dicetak
  $handle = fopen($file, 'w');
  $condensed = Chr(27) . Chr(33) . Chr(4);
  $bold1 = Chr(27) . Chr(69);
  $bold0 = Chr(27) . Chr(70);
  $initialized = chr(27).chr(64);
  $condensed1 = chr(15);
  $condensed0 = chr(18);
  $Data  = $initialized;
  $Data .= $condensed1;
  $Data .= "                          "."No. : ".$bold1.$nojual.$bold0."          ".$kdcustomer." | ".$cnmcustomer."\n";
  $Data .= "                          "."Tanggal : ".$tanggal."         ".$de['alamat']."      \n";
  $Data .= "                          "."                               ".$de['kota']." ".$de['kodepos']."\n";
  $Data .= "                          "."                               ".$de['telp1']." ".$de['telp2']."\n";
  $Data .= "==========================\n";
  $Data .= "Ofidz Majezty is here\n";
  $Data .= "We Love PHP Indonesia\n";
  $Data .= "We Love PHP Indonesia\n";
  $Data .= "We Love PHP Indonesia\n";
  $Data .= "We Love PHP Indonesia\n";
  $Data .= "We Love PHP Indonesia\n";
  $Data .= "--------------------------\n";
  $Data .= "\n";
  $Data .= "\n";
  $Data .= "\n";
  $Data .= "\n";
  $Data .= "\n";
  $Data .= "\n";
  $Data .= "\n";
  $Data .= "\n";
  $Data .= "\n";
  $Data .= "\n";
  $Data .= "\n";
  fwrite($handle, $Data);
  fclose($handle);
  copy($file, "//192.168.20.3/EPSON L120 Series");  # Lakukan cetak
  unlink($file);

    // $tmpdir = sys_get_temp_dir();   # ambil direktori temporary untuk simpan file.
    // $file =  tempnam($tmpdir, 'ctk');  # nama file temporary yang akan dicetak
    // $handle = fopen($file, 'w');
    // $condensed = Chr(27) . Chr(33) . Chr(4);
    // $bold1 = Chr(27) . Chr(69);
    // $bold0 = Chr(27) . Chr(70);
    // $initialized = chr(27).chr(64);
    // $condensed1 = chr(15);
    // $condensed0 = chr(18);
    // $Data  = $initialized;
    // $Data .= $condensed1;
    // $Data .= "==========================\n";
    // $Data .= "|     ".$bold1."OFIDZ MAJEZTY".$bold0."      |\n";
    // $Data .= "==========================\n";
    // $Data .= "Ofidz Majezty is here\n";
    // $Data .= "We Love PHP Indonesia\n";
    // $Data .= "We Love PHP Indonesia\n";
    // $Data .= "We Love PHP Indonesia\n";
    // $Data .= "We Love PHP Indonesia\n";
    // $Data .= "We Love PHP Indonesia\n";
    // $Data .= "--------------------------\n";
    // $Data .= "\n";
    // $Data .= "\n";
    // $Data .= "\n";
    // $Data .= "\n";
    // $Data .= "\n";
    // $Data .= "\n";
    // $Data .= "\n";
    // $Data .= "\n";
    // $Data .= "\n";
    // $Data .= "\n";
    // $Data .= "\n";
    // fwrite($handle, $Data);
    // fclose($handle);
    // copy($file, "//192.168.20.3/EPSON L120 Series");  # Lakukan cetak
    // unlink($file);
