<?php
include "../../inc/config.php";

$id = $_POST['id'];
$query = mysqli_query($connect, "select * from jualh where id='$id'");
$de = mysqli_fetch_assoc($query);
if ($de['sudahbayar'] > 0) {
?>
  <div class="row">
    <div class='col-md-12'>
      <label for="nama" class="form-label mb-1">No. Penjualan</label>
      <input type="text" class='form-control mb-2' name='nojual' value=<?= $de['nojual'] ?> readonly>
      <br>
      <label for="nama" class="form-label mb-1">Unproses tidak dapat dilanjutkan, karena sudah terdapat pembayaran !</label>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
<?php
} else {
?>
  <div class="row">
    <div class='col-md-12'>
      <form method='post' enctype='multipart/form-data' action='module/jual/batal_proses.php'>
        <input type="hidden" class='form-control' name='id' id='id' value=<?= $id ?> readonly>
        <label for="nama" class="form-label mb-1">No. Penjualan</label>
        <input type="text" class='form-control mb-2' name='nojual' value=<?= $de['nojual'] ?> readonly>
        <br>
        <label for="nama" class="form-label mb-1 mt-2">Catatan</label>
        <textarea rows="4" class='form-control' name='catatan' required></textarea>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Simpan</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
<?php
}
