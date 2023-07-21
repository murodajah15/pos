<form method='post' target='_blank' action='rfaktur_export.php'>
  <?php
  date_default_timezone_set('Asia/Jakarta');
  $tanggal1 = date('d-m-Y', strtotime($_POST['tanggal1']));
  $tanggal2 = date('d-m-Y', strtotime($_POST['tanggal2']));
  $tgl1 = date('Y-m-d', strtotime($_POST['tanggal1']));
  $tgl2 = date('Y-m-d', strtotime($_POST['tanggal2']));
  $no = 1;
  ?>
  <input type="hidden" name="tanggal1" value="<?= $tanggal1 ?>">
  <input type="hidden" name="tanggal2" value="<?= $tanggal2 ?>">
  <button type='submit' class='btn btn-danger'>Export ke Excel</button>
  <button type='button' class='btn btn-danger' onClick="window.print()">Print</button>
</form>

<?php
include 'rfaktur_data.php';
?>