<form method='post' target='_blank' action='rstock_opname_export.php'>
  <?php
  date_default_timezone_set('Asia/Jakarta');
  $noopname = $_POST['noopname'];
  ?>
  <input type="hidden" name="noopname" value="<?= $noopname ?>">
  <button type='submit' class='btn btn-danger'>Export ke Excel</button>
  <button type='button' class='btn btn-danger' onClick="window.print()">Print</button>
</form>

<?php
include 'rstock_opname_data.php';
?>