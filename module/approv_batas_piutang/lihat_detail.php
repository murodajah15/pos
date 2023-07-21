<?php
include "../../inc/config.php";

$noapprov = $_POST['kode'];
$query = mysqli_query($connect, "select * from approv_batas_piutang where noapprov='$noapprov'");
$de = mysqli_fetch_assoc($query);
$noapprov = strip_tags($de['noapprov']);
$tglapprov = strip_tags($de['tglapprov']);
$nojual = strip_tags($de['nojual']);
$tgljual = strip_tags($de['tgljual']);
$nmcustomer = strip_tags($de['nmcustomer']);
$total = strip_tags($de['total']);
$keterangan = strip_tags($de['keterangan']);
?>
<div class='col-md-6'>
  <table style=font-size:13px; class="table table-striped table table-bordered">
    <tr>
      <td>Nomor Approv</td>
      <td>
        <input type='text' class='form-control' id='noapprov' name='noapprov' placeholder='No. Approv *' style='text-transform:uppercase' value="<?= $noapprov ?>" readonly>
      </td>
    </tr>
    <tr>
      <td>Tgl. Approv (M/D/Y)</td>
      <td><input type='date' class='form-control' id='tglapprov' name='tglapprov' value="<?= $tglapprov ?>" autocomplete='off' required></td>
    </tr>
    <tr>
      <td>Nomor Penjualan</td>
      <td>
        <div class='input-group'> <input type='text' class='form-control' id='nojual' name='nojual' size='50' value='<?= $nojual ?>' autocomplete='off' readonly required>
    <tr>
      <td></td>
      <td> <input type="date" class='form-control' id='tgljual' name='tgljual' value="<?= $tgljual ?>" readonly required></td>
    </tr>
    <tr>
      <td></td>
      <td> <input type="text" class='form-control' id='nmcustomer' name='nmcustomer' value="<?= $nmcustomer ?>" readonly required></td>
    </tr>
    <tr>
      <td></td>
      <td> <input type="number" class='form-control' id='total' name='total' value="<?= $total ?>" readonly required></td>
    </tr>
    <tr>
      <td>Keterangan</td>
      <td> <textarea rows='3' class='form-control' name='keterangan' id='keterangan' readonly><?= $keterangan ?></textarea></td>
    </tr>
  </table>
</div>