<form method='post' target='_blank' action='rstock_export.php'>
  <?php
  date_default_timezone_set('Asia/Jakarta');
  $bulan = $_POST['bulan'];
  $tahun = $_POST['tahun'];
  // $tanggal1 = date('d-m-Y', strtotime($_POST['tanggal1']));
  // $tanggal2 = date('d-m-Y', strtotime($_POST['tanggal2']));
  // $tgl1 = date('Y-m-d', strtotime($_POST['tanggal1']));
  // $tgl2 = date('Y-m-d', strtotime($_POST['tanggal2']));
  $no = 1;
  if (isset($_POST['bentuk'])) {
  ?>
    <input type='checkbox' style='display:none;' name='bentuk' value="bentuk" checked='checked'>
  <?php
  } else {
  ?>
    <input type='checkbox' style='display:none;' name='bentuk' value="bentuk">
  <?php
  }
  if (isset($_POST['pilihan'])) {
  ?>
    <input type='checkbox' style='display:none;' name='pilihan' value="Perbarang" checked='checked'>
  <?php
  } else {
  ?>
    <input type='checkbox' style='display:none;' name='pilihan' value="Perbarang">
  <?php
  }
  ?>
  <!-- <input type="hidden" name="tanggal1" value="<?= $tanggal1 ?>">
  <input type="hidden" name="tanggal2" value="<?= $tanggal2 ?>"> -->
  <input type="hidden" name="bulan" value="<?= $bulan ?>">
  <input type="hidden" name="tahun" value="<?= $tahun ?>">
  <button type='submit' class='btn btn-danger'>Export ke Excel</button>
  <button type='button' class='btn btn-danger' onClick="window.print()">Print</button>
</form>

<?php
include 'rstock_data.php';
?>