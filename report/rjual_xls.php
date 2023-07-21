<form method='post' target='_blank' action='rjual_export.php'>
  <?php
  date_default_timezone_set('Asia/Jakarta');
  $tanggal1 = date('d-m-Y', strtotime($_POST['tanggal1']));
  $tanggal2 = date('d-m-Y', strtotime($_POST['tanggal2']));
  $tgl1 = date('Y-m-d', strtotime($_POST['tanggal1']));
  $tgl2 = date('Y-m-d', strtotime($_POST['tanggal2']));
  $kdcustomer = $_POST['kdcustomer'];
  $kdsales = $_POST['kdsales'];
  $no = 1;
  ?>
  <input type="hidden" name="tanggal1" value="<?= $tanggal1 ?>">
  <input type="hidden" name="tanggal2" value="<?= $tanggal2 ?>">
  <input type="hidden" name="tgl1" value="<?= $tgl1 ?>">
  <input type="hidden" name="tgl2" value="<?= $tgl2 ?>">
  <input type="hidden" name="kdcustomer" value="<?= $kdcustomer ?>">
  <input type="hidden" name="nmcustomer" value="<?= $nmcustomer ?>">
  <input type="hidden" name="kdsales" value="<?= $kdsales ?>">
  <input type="hidden" name="nmsales" value="<?= $nmsales ?>">
  <input type="hidden" name="tgl2" value="<?= $tgl2 ?>">

  <input type='text' style='display:none;' name='pilihanppn' value="<?= $_POST['pilihanppn'] ?>">
  <?php
  if (isset($_POST['check2'])) {
  ?>
    <input type='checkbox' style='display:none;' name='check2' value="outstanding" checked='checked'>
  <?php
  } else {
  ?>
    <input type='checkbox' style='display:none;' name='check2' value="outstanding">
  <?php
  }
  if (isset($_POST['check1'])) {
  ?>
    <input type='checkbox' style='display:none;' name='check1' value="semuaperiode" checked='checked'>
  <?php
  } else {
  ?>
    <input type='checkbox' style='display:none;' name='check1' value="semuaperiode">
  <?php
  }
  if (isset($_POST['semuacustomer'])) {
  ?>
    <input type='checkbox' style='display:none;' name='semuacustomer' value="semuacustomer" checked='checked'>
  <?php
  } else {
  ?>
    <input type='checkbox' style='display:none;' name='semuacustomer' value="semuaperiode">
  <?php
  }
  if (isset($_POST['rincian'])) {
  ?>
    <input type='checkbox' style='display:none;' name='rincian' value="rincian" checked='checked'>
  <?php
  } else {
  ?>
    <input type='checkbox' style='display:none;' name='rincian' value="rincian">
  <?php
  }
  if (isset($_POST['semuasales'])) {
  ?>
    <input type='checkbox' style='display:none;' name='semuasales' value="semuasales" checked='checked'>
  <?php
  } else {
  ?>
    <input type='checkbox' style='display:none;' name='semuasales' value="semuasales">
  <?php
  }
  ?>
  <button type='submit' class='btn btn-danger'>Export ke Excel</button>
  <button type='button' class='btn btn-danger' onClick="window.print()">Print</button>
</form>

<?php
include 'rjual_data.php';
?>