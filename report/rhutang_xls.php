<form method='post' target='_blank' action='rhutang_export.php'>
  <?php
  date_default_timezone_set('Asia/Jakarta');
  $tanggal1 = date('d-m-Y', strtotime($_POST['tanggal1']));
  $tanggal2 = date('d-m-Y', strtotime($_POST['tanggal2']));
  $tgl1 = date('Y-m-d', strtotime($_POST['tanggal1']));
  $tgl2 = date('Y-m-d', strtotime($_POST['tanggal2']));
  $harbul = $_POST['harbul'];
  $no = 1;
  ?>
  <input type="hidden" name="tanggal1" value="<?= $tanggal1 ?>">
  <input type="hidden" name="tanggal2" value="<?= $tanggal2 ?>">
  <input type="hidden" name="tgl1" value="<?= $tgl1 ?>">
  <input type="hidden" name="tgl2" value="<?= $tgl2 ?>">
  <input type="hidden" name="harbul" value="<?= $harbul ?>">
  <?php
  if (isset($_POST['check1'])) {
  ?>
    <input type='checkbox' style='display:none;' name='check1' value="semuaperiode" checked='checked'>
  <?php
  } else {
  ?>
    <input type='checkbox' style='display:none;' name='check1' value="semuaperiode">
  <?php
  }
  ?>
  <button type='submit' class='btn btn-danger'>Export ke Excel</button>
  <button type='button' class='btn btn-danger' onClick="window.print()">Print</button>
</form>

<?php
include 'rhutang_data.php';
?>