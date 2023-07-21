<?php
$user = $_SESSION['username'];
$kunci_harga_jual = $_SESSION['kunci_harga_jual'];
include "autonumber.php";

if (isset($_GET['tipe'])) {
  if ($_GET['tipe'] == 'detail_proses') {
    cekakses($connect, $user, 'Penjualan');
    $lakses = $_SESSION['aksespakai'];
    if ($lakses == 1) { ?>
      <font face='calibri'>
        <h3>Detail Penjualan : <?= $_GET['nojual'] ?></h3><br>
        <form method='post'>
          <div class="row">
            <div class="col-md-4 bg">
              <input type="text" id='kata' name='kata' size='50px' class='form-control' placeholder='Kode, Nama' onkeyup='searchTable()'>
            </div>
            <?php
            include 'hal.php';
            ?>
            <button type='submit' name='kata2' class='btn btn-primary'>
              <span class='glyphicon glyphicon-search'></span> Cari</button>
            <!--<a class="btn btn-danger" href="?m=jual&tipe=tambah_detail">Tambah data</a>
						<a class="btn btn-success" href="?m=jual&tipe=import">Import data</a>-->
          </div>
          <input type='hidden' name='username' value='<?= $user ?>'>
          <table class="table table-bordered table-striped table-hover">
            <!-- 						<tr><td>Nomor Penerimaan</td><td>
					<input type='text' class='form-control' id='nojual' name='nojual' placeholder='No. Penerimaan *' style='text-transform:uppercase' value="<?= $nojual ?>" readonly></td>
					<td>Tgl. (M/D/Y)</td><td><input type='date' class='form-control' id='tgljual' name='tgljual' value="<?= $tgljual ?>" size='50' autocomplete='off' readonly></td></tr> -->
          </table>
          <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
              <tr>
                <th width='50'>No.</th>
                <th width='100'>No. SO</th>
                <th width='170'>Kode Barang</th>
                <th>Nama Barang</th>
                <th width='70'>Satuan</th>
                <th>QTY</th>
                <th>harga</th>
                <th>Disc.(%)</th>
                <th>Subtotal</th>
              </tr>
              <?php
              $tampil = mysqli_query($connect, "select * from juald where nojual='$_GET[nojual]'");
              $query = $connect->prepare("select * from juald where nojual=?");
              $query->bind_param('s', $_GET['nojual']);
              $query->execute();
              $result = $query->get_result();
              $de = $result->fetch_assoc();
              $noso = strip_tags($de['noso']);
              $no = 1;
              //<td><u><a href='#' onclick =lihat_detail('$k[id]');><font color='blue'>$k[noso]</font></a></u></td>
              while ($k = mysqli_fetch_assoc($tampil)) {
                $kdbarang = strip_tags($k['kdbarang']);
                $nmbarang = strip_tags($k['nmbarang']);
                $qty = strip_tags($k['qty']);
                $harga = number_format($k['harga'], 0, ",", ".");
                $discount = strip_tags($k['discount']);
                $subtotal = number_format($k['subtotal'], 0, ",", ".");
                //$date = date("m/d/Y", strtotime($k['tglwo']));
                echo "<tr><td align='center'>$no</td>
							<td width='100'>$k[noso]</td>
							<td width='100'>$k[kdbarang]</td>
							<td width='300'>$k[nmbarang]</td>
							<td width='10'>$k[kdsatuan]</td>
							<td align='right' width='10'>$k[qty]</td>
							<td align='right' width='100'>$harga</td>
							<td align='right' width='70'>$k[discount]</td>
							<td align='right'>$subtotal</td>";
                $no++;
              }
              $tampil = mysqli_query($connect, "select sum(qty) as total_qty,sum(subtotal) as total_subtotal from juald where nojual='$_GET[nojual]'");
              $jum = mysqli_fetch_assoc($tampil);
              $total_qty = $jum['total_qty'];
              $total = number_format($jum['total_subtotal'], 0, ",", ".");
              echo "<tr><td colspan='5'></td>
						<td align='right' style='font-weight:bold'>$total_qty</td>
						<td align='right' colspan='3' style='font-weight:bold'>$total</td>";
              ?>
            </table>
          </div>
          <input button type="Button" class="btn btn-danger" value="Close" onClick="history.back()" />
          <!--<input button type='Button' class='btn btn-danger' value='Close' onClick="window.location = 'dashboard.php?m=jual'" />-->
        </form>
      </font>
    <?php
    } else {
      echo "<script>alert('Anda tidak berhak !');history.go(-1) </script>";
    }
  }
}

if (isset($_GET['tipe'])) {
  if ($_GET['tipe'] == 'detail') {
    cekakses($connect, $user, 'Penjualan');
    $lakses = $_SESSION['aksespakai'];
    $_SESSION['kdcustomer'] = $_GET['kdcustomer'];
    if ($lakses == 1) {
      $kdcustomer = $_GET['kdcustomer']; ?>
      <font face='calibri'>
        <div class='panel panel-danger'>
          <div class='panel-heading'>
            <font size="4">TAMBAH DATA DETAIL PENJUALAN</font>
          </div>
          <div class='panel-body'>
            <form method='post' name='so' enctype='multipart/form-data' action='module/jual/proses_tambah_detail.php'>
              <input type='hidden' name='username' value="<?= $user ?>">
              <input type='hidden' name='kdcustomer' id='kdcustomer' value="<?= $kdcustomer ?>">
              <div class='col-md-4'>
                <table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
                  <form method='post' enctype='multipart/form-data' action='module/jual/proses_tambah_detail.php'>
                    <input type='hidden' name='username' value='<?= $user ?>'>
                    <input type='hidden' name='nojual' value='<?= $_GET['nojual'] ?>'>
                    <input type='hidden' name='kata' value='<?= $_GET['kata'] ?>'>
                    <input type='hidden' name='page' value='<?= $_GET['page'] ?>'>

                    <div class="input-group">
                      <span class="input-group-addon">No. SO</span>
                      <input type="text" class="form-control" name='noso' id='noso' size='50' placeholder="No. SO" readonly>
                      <span class='input-group-btn'></span>
                      <button type='button' id='src' class='btn btn-primary' onclick='cari_data_so()'>Cari</button>
                      <span class='input-group-btn'></span><button type='submit' class='btn btn-success'>+</button>
                    </div>

                    <div class="table-responsive">
                      <table class="table table-bordered table-striped table-hover">
                        <tr>
                          <th>Kode Barang <input type="button" class='btn btn-black' value="Clear" onclick="eraseText()"></th>
                          <th>Barang</th>
                          <th>QTY</th>
                          <th>Harga</th>
                          <th>Disc</th>
                          <th>Subtotal</th>
                          <th>Aksi</th>
                        </tr>
                        <td>
                          <div class='input-group'> <input type='text' class='form-control' id='kdbarang' name='kdbarang' size='50' style="text-transform: uppercase; width: 9em;" autocomplete='off'>
                            <span class='input-group-btn'>
                              <button type='button' id='src' class='btn btn-primary' onclick='cari_data_barang()'>Cari</button>
                            </span>
                        </td>
                        <input type='hidden' class='form-control' style='width: 15em' id='kdsatuan' name='kdsatuan' readonly>
                        </td>
                        <td><input type='text' class='form-control' style='width: 15em' id='nmbarang' name='nmbarang' readonly></td>
                        </td>
                        <td><input type="text" class='form-control' id='qty' name='qty' style='width: 6em' onkeyup="validAngka(this)" onblur="hit_subtotal()" required></td>
                        <?php
                        if ($kunci_harga_jual == 'Y') {
                        ?>
                          </td>
                          <td><input type="text" class='form-control' id='harga' name='harga' style='width: 7em' readonly></td>
                        <?php
                        } else {
                        ?>
                          </td>
                          <td><input type="text" class='form-control' id='harga' name='harga' style='width: 7em' onkeyup="validAngka_no_titik(this)" onblur="hit_subtotal()"></td>
                        <?php
                        }
                        ?>
                        </td>
                        <td><input type="text" class='form-control' id='discount' name='discount' style='width: 6em' onkeyup="validAngka(this)" onblur="hit_subtotal()"></td>
                        </td>
                        <td><input type="number" class='form-control' id='subtotal' name='subtotal' style='width: 10em' readonly></td>
                        <td align='center' width='50px'>
                          <button type='submit' class='btn btn-primary'>+</button>
                      </table>
                      <form>
                    </div>

                    <div class='col-md-12'>
                      <table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
                        <tr>
                          <th width='50'>No.</th>
                          <th width='100'>No. SO</th>
                          <th width='170'>Kode Barang</th>
                          <th>Nama Barang</th>
                          <th width='70'>Satuan</th>
                          <th>QTY</th>
                          <th>harga</th>
                          <th>Disc.(%)</th>
                          <th>Subtotal</th>
                          <th>Aksi</th>
                        </tr>
                        <?php
                        $tampil = mysqli_query($connect, "select * from juald where nojual='$_GET[nojual]'");
                        $query = $connect->prepare("select * from juald where nojual=?");
                        $query->bind_param('s', $_GET['nojual']);
                        $query->execute();
                        $result = $query->get_result();
                        $de = $result->fetch_assoc();
                        $no = 1;
                        //<td><u><a href='#' onclick =lihat_detail('$k[id]');><font color='blue'>$k[noso]</font></a></u></td>
                        // <td><input type='number' name='qty' id='qty' value='$k[qty]' style='text-align: right; width: 6em' onkeyup='hitung_subtotal_jualh()'></td>

                        while ($k = mysqli_fetch_assoc($tampil)) {
                          $noso = strip_tags($k['noso']);
                          $kdbarang = strip_tags($k['kdbarang']);
                          $nmbarang = strip_tags($k['nmbarang']);
                          $qty = number_format($k['qty'], 2, ",", ".");
                          $harga = number_format($k['harga'], 0, ",", ".");
                          $discount = number_format($k['discount'], 2, ",", ".");
                          $subtotal = number_format($k['subtotal'], 0, ",", ".");
                          //$date = date("m/d/Y", strtotime($k['tglwo']));
                          echo "<tr><td align='center'>$no</td>
							<td width='100'>$k[noso]</td>
							<td width='100'>$k[kdbarang]</td>
							<td width='300'>$k[nmbarang]</td>
							<td width='10'>$k[kdsatuan]</td>
							<td align='right'>$qty</td>
							<td align='right'>$harga</td>
							<td align='right'>$discount</td>
							<td align='right'>$subtotal</td>
							<td align='center' width='160px'>";
                          echo "<a class='btn btn-primary' href='?m=jual&tipe=edit_detail&id=$k[id]&kdcustomer=$_GET[kdcustomer]'>Edit</a> ";
                          echo " <input button type='Button' class='btn btn-danger' value='Hapus' onClick='alert_hapus_detail($k[id])'/>";
                          $no++;
                        }
                        $tampil = mysqli_query($connect, "select sum(qty) as total_qty,sum(subtotal) as total_subtotal from juald where nojual='$_GET[nojual]'");
                        $jum = mysqli_fetch_assoc($tampil);
                        $total_qty = $jum['total_qty'];
                        $total_qty = number_format($total_qty, 2, ",", ".");
                        $total =  number_format($jum['total_subtotal'], 0, ",", ".");;
                        echo "<tr><td colspan='5'></td>
						<td align='right' style='font-weight:bold'>$total_qty</td>
						<td align='right' colspan='3' style='font-weight:bold'>$total</td>";
                        ?>
                      </table>
                      <table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
                        <?php
                        if (!empty($_GET['kata']) and !empty($_GET['page'])) {
                        ?>
                          <input button type='Button' class='btn btn-danger' value='Close1 onClick="window.location = ' dashboard.php?m=jual$kata=<?= $_GET['kata'] ?>&page=<?= $_GET['page'] ?>'" />
                        <?php
                        }
                        if (!empty($_GET['page'])) {
                        ?>
                          <input button type='Button' class='btn btn-danger' value='Close' onClick="window.location = 'dashboard.php?m=jual&page=<?= $_GET['page'] ?>'" />
                        <?php
                        }
                        if (empty($_GET['kata']) and empty($_GET['page'])) {
                        ?>
                          <input button type='Button' class='btn btn-danger' value='Close' onClick="window.location = 'dashboard.php?m=jual'" />
                        <?php
                        }
                        ?>
                      </table>
                    </div>
              </div>
          </div>
        </div>
        </form>
      </font>
    <?php
    } else {
      echo "<script>alert('Anda tidak berhak !');history.go(-1) </script>";
    }
  }
}

if (isset($_GET['tipe'])) {
  if ($_GET['tipe'] == 'edit_detail') {
    cekakses($connect, $user, 'Edit Detail Penjualan');
    $lakses = $_SESSION['aksespakai'];
    if ($lakses == 1) {
      $query = $connect->prepare("select * from juald where id=?");
      $query->bind_param('i', $_GET['id']);
      $query->execute();
      $result = $query->get_result();
      $de = $result->fetch_assoc();
      $id = $_GET['id'];
      $noso = strip_tags($de['noso']);
      $nojual = strip_tags($de['nojual']);
      $kdbarang = strip_tags($de['kdbarang']);
      $nmbarang = strip_tags($de['nmbarang']);
      $kdsatuan = strip_tags($de['kdsatuan']);
      $qty = number_format($de['qty'], 2, ",", ".");
      $qty = str_replace(",", ".", $qty);
      $harga = strip_tags($de['harga']);
      $discount = number_format($de['discount'], 2, ",", ".");
      $discount = str_replace(",", ".", $discount);
      $subtotal = strip_tags($de['subtotal']);
      $harga = strip_tags($de['harga']); ?>
      <font face='calibri'>
        <h3>Edit Detail Penjualan</h3>
        <form method='post' enctype='multipart/form-data' action='module/jual/proses_edit_detail.php'>
          <input type='hidden' name='id' value='<?= $id ?>'>
          <input type='hidden' name='username' value='<?= $user ?>'>
          <input type='hidden' name='noso' value='<?= $noso ?>'>
          <input type='hidden' name='nojual' value='<?= $nojual ?>'>
          <table class="table table-bordered table-striped table-hover">
            <tr>
              <td>Nomor Penerimaan</td>
              <td>
                <input type='text' class='form-control' id='nojual' name='nojual' placeholder='No. WO *' style='text-transform:uppercase' value="<?= $nojual ?>" readonly>
              </td>
          </table>
          <table class="table table-bordered table-striped table-hover">
            <tr>
              <th width='170'>Kode Barang</th>
              <th>Nama Barang</th>
              <th width='70'>Satuan</th>
              <th>QTY</th>
              <th>harga</th>
              <th>Disc.(%)</th>
              <th>Subtotal</th>
            </tr>
            <td>
              <div class='input-group'> <input type='text' class='form-control' id='kdbarang' name='kdbarang' value='<?= $kdbarang ?>' size='50' autocomplete='off' readonly required>
                <!--<span class='input-group-btn'>
								<button type='button' id='src' class='btn btn-primary' onclick='cari_data_barang()'>
									Cari
								</button>
							</span></td>-->
            </td>
            <td><input type='text' class='form-control' style='width: 15em' id='nmbarang' name='nmbarang' value='<?= $nmbarang ?>' readonly></td>
            </td>
            <td><input type='text' class='form-control' style='width: 5em' id='kdsatuan' name='kdsatuan' value='<?= $kdsatuan ?>' readonly></td>
            </td>
            <td><input type="text" class='form-control' id='qty' name='qty' value='<?= $qty ?>' style='width: 6em' onkeyup="validAngka(this)" onblur="hit_subtotal()" required></td>
            <?php
            if ($kunci_harga_jual == 'Y') {
            ?>
              </td>
              <td><input type="text" class='form-control' id='harga' name='harga' style='width: 7em' readonly></td>
            <?php
            } else {
            ?>
              </td>
              <td><input type="text" class='form-control' id='harga' name='harga' value='<?= $harga ?>' style='width: 7em' onkeyup="validAngka_no_titik(this)" onblur="hit_subtotal()"></td>
            <?php
            }
            ?>
            </td>
            <td><input type="text" class='form-control' id='discount' name='discount' value='<?= $discount ?>' style='width: 6em' onkeyup="validAngka(this)" onblur="hit_subtotal()"></td>
            </td>
            <td><input type="number" class='form-control' id='subtotal' name='subtotal' value='<?= $subtotal ?>' style='width: 10em' readonly></td>
          </table>
          <button type='submit' class='btn btn-success'>Simpan</button>
          <input button type='Button' class='btn btn-danger' value='Batal' onClick='history.back()' />
        </form>
      </font>
    <?php
    } else {
      echo "<script>alert('Anda tidak berhak !');history.go(-1) </script>";
    }
  }
}

if (isset($_GET['tipe'])) {
  if ($_GET['tipe'] == 'tambah') {
    cekakses($connect, $user, 'Penjualan');
    $lakses = $_SESSION['aksestambah'];
    $de = mysqli_fetch_assoc(mysqli_query($connect, "select * from saplikasi where aktif='Y'"));
    $tgl = $de['tgl_berikutnya']; //date('Y-m-d')
    if ($lakses == 1) { ?>
      <font face='calibri'>
        <div class='panel panel-danger'>
          <div class='panel-heading'>
            <font size="4">TAMBAH DATA PENJUALAN</font>
          </div>
          <div class='panel-body'>
            <form method='post' name='so' enctype='multipart/form-data' action='module/jual/proses_tambah.php'>
              <input type='hidden' name='username' value="<?= $user ?>">
              <div class='col-md-6'>
                <table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
                  <tr>
                    <td>Nomor Penjualan</td>
                    <td>
                      <input type='text' class='form-control' id='nojual' name='nojual' id='nojual' placeholder='No. Jual *' style='text-transform:uppercase' value="<?php echo autoNumberJL($connect, 'id', 'jualh'); ?>" readonly>
                    </td>
                  </tr>
                  <tr>
                    <td>Tgl. (M/D/Y)</td>
                    <td><input type='date' class='form-control' id='tgljual' name='tgljual' value="<?php echo $tgl ?>" size='50' autocomplete='off' required readonly></td>
                  </tr>
                  <tr>
                    <td>No. Invoice</td>
                    <td><input type='text' class='form-control' id='noinvoice' name='noinvoice' size='50' autocomplete='off' required></td>
                  </tr>
                  <tr>
                    <td>Tgl. Invoice (M/D/Y)</td>
                    <td><input type='date' class='form-control' id='tglinvoice' name='tglinvoice' size='50' autocomplete='off' required></td>
                  </tr>
                  <tr>
                    <td>Customer</td>
                    <td>
                      <div class='input-group'> <input type='text' class='form-control' id='kdcustomer' name='kdcustomer' size='50' autocomplete='off' readonly required>
                        <span class='input-group-btn'>
                          <button type='button' id='src' class='btn btn-primary' onclick='cari_data_customer()'>Cari</button>
                        </span>
                    </td>
                  <tr>
                    <td></td>
                    <td> <input type="text" class='form-control' id='nmcustomer' name='nmcustomer' size='50' readonly required></td>
                  </tr>
                  <tr>
                    <td>Jenis Order
                    <td><select required id='jenis_order' name='jenis_order' id='jenis_order' class='form-control' style='width: 200x;'>
                        <option value="URGENT">URGENT</option>
                        <option value="NORMAL">NORMAL</option>
                        <option value="LAIN">LAIN-LAIN</option>
                      </select>
                  <tr>
                    <td>Biaya Lain</td>
                    <td> <input type="text" class='form-control' name='ket_biaya_lain' id='ket_biaya_lain'></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td> <input type="number" class='form-control' name='biaya_lain' id='biaya_lain' size='50' value='0' required onkeyup="validAngka_no_titik(this)" onblur="hit_total()" readonly></td>
                  </tr>
                  <tr>
                    <td>Tanggal Kirim<br>(M/D/Y)</br></td>
                    <td> <input type="date" class='form-control' name='tglkirim' id='tglkirim' size='50' required></td>
                  </tr>
                  <tr>
                    <td>Gudang
                    <td><select id='kdgudang' name='kdgudang' class='form-control' style='width: 200x;' onchange='changeValueGudang(this.value)'>
                        <!--<option value=''> - PILIH SATUAN BARANG - </option>";-->
                        <?php
                        $jsArrayGudang = "var prdNameGudang = new Array();\n";
                        $data = mysqli_query($connect, 'select * from tbgudang order by nama');
                        while ($row = mysqli_fetch_array($data)) {
                          echo '<option name="kdgudang"  value="' . $row['kode'] . '">' . $row['kode'] . '|' . $row['nama'] . '</option>';
                          $jsArraySatuan .= "prdNameGudang['" . $row['kode'] . "'] = {nmgudang:'" . addslashes($row['nama']) . "',kdgudang:'" . addslashes($row['kode']) . "'};\n";
                        }
                        echo '</select>';
                        ?>
                        <input type='hidden' class='form-control' size='50' id='nmgudang' name='nmgudang' readonly>
                  <tr>
                    <td>Sales
                    <td><select id='kdsales' name='kdsales' class='form-control' style='width: 200x;' onchange='changeValueSales(this.value)'>
                        <!--<option value=''> - PILIH SATUAN BARANG - </option>";-->
                        <?php
                        $jsArraySales = "var prdNameSales = new Array();\n";
                        $data = mysqli_query($connect, 'select * from tbsales order by nama');
                        while ($row = mysqli_fetch_array($data)) {
                          echo '<option name="kdsales"  value="' . $row['kode'] . '">' . $row['kode'] . '|' . $row['nama'] . '</option>';
                          $jsArraySales .= "prdNameSales['" . $row['kode'] . "'] = {nmsales:'" . addslashes($row['nama']) . "',kdsales:'" . addslashes($row['kode']) . "'};\n";
                        }
                        echo '</select>';
                        ?>
                        <input type='hidden' class='form-control' size='50' id='nmsales' name='nmsales' readonly>
                </table>
              </div>
              <div class='col-md-6'>
                <table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
                  <tr>
                    <td>Cara Bayar
                    <td><select required id='carabayar' name='carabayar' id='carabayar' class='form-control' style='width: 200x;'>
                        <!--<option value=''> - PILIH CARA BAYAR - </option>";?>-->
                        <option value="TUNAI">TUNAI</option>
                        <option value="TRANSFER">TRANSFER</option>
                        <option value="KREDIT">KREDIT</option>
                        <option value="KARTU-KREDIT">KARTU-KREDIT</option>
                        <option value="GIRO">GIRO</option>
                        <option value="CEK">CEK</option>
                      </select>
                  <tr>
                    <td>Tempo (Hari)</td>
                    <td> <input type="number" class='form-control' name='tempo' id='tempo' size='50'></td>
                  </tr>
                  <tr>
                    <td>Tanggal Jatuh Tempo<br>(M/D/Y)</br></td>
                    <td> <input type="date" class='form-control' name='tgl_jt_tempo' id='tgl_jt_tempo' size='50'></td>
                  </tr>
                  <tr>
                    <td>Subtotal</td>
                    <td> <input type="number" class='form-control' name='subtotal' id='subtotal' value='0' size='50' readonly></td>
                  </tr>
                  <tr>
                    <td>Total Sementara</td>
                    <td> <input type="number" class='form-control' id='total_sementara' name='total_sementara' size='50' value='0' readonly></td>
                  </tr>
                  <tr>
                    <td>PPn (%)</td>
                    <td> <input type="number" class='form-control' name='ppn' id='ppn' size='50' value='0' onkeyup="hit_total()" onblur="hit_total()"></td>
                  </tr>
                  <tr>
                    <td>Materai</td>
                    <td> <input type="number" class='form-control' name='materai' id='materai' size='50' value='0' onkeyup="validAngka_no_titik(this)" onblur="hit_total()"></td>
                  </tr>
                  <tr>
                    <td>Total</td>
                    <td> <input type="number" class='form-control' name='total' id='total' size='50' value='0' readonly></td>
                  </tr>
                  <tr>
                    <td>Keterangan</td>
                    <td><textarea type='text' rows='2' class='form-control' id='kerangan' name='keterangan' autocomplete='off'></textarea></td>
                  </tr>
                </table>
              </div>
              <div class='col-md-12'>
                <button type='submit' class='btn btn-primary'>Simpan</button>
                <input button type='Button' class='btn btn-danger' value='Batal' onClick='history.back()' />
              </div>
          </div>
        </div>
        </form>
      </font>
    <?php
    } else {
      echo "<script>alert('Anda tidak berhak !');history.go(-1) </script>";
    }
  } elseif ($_GET['tipe'] == 'edit') {
    cekakses($connect, $user, 'Penjualan');
    $lakses = $_SESSION['aksesedit'];
    if ($lakses == 1) {
      // $sql=mysqli_query($connect,"select * from soh where id='$_GET[id]'");
      // $de=mysqli_fetch_assoc($sql);
      $query = $connect->prepare("select * from jualh where id=?");
      $query->bind_param('i', $_GET['id']);
      $query->execute();
      $result = $query->get_result();
      $de = $result->fetch_assoc();
      $nojual = strip_tags($de['nojual']);
      $tgljual = strip_tags($de['tgljual']);
      $noinvoice = strip_tags($de['noinvoice']);
      $tglinvoice = strip_tags($de['tglinvoice']);
      $kdcustomer = strip_tags($de['kdcustomer']);
      $nmcustomer = strip_tags($de['nmcustomer']);
      $jenis_order = strip_tags($de['jenis_order']);
      $tglkirim = strip_tags($de['tglkirim']);
      $biaya_lain = strip_tags($de['biaya_lain']);
      $ket_biaya_lain = strip_tags($de['ket_biaya_lain']);
      $carabayar = strip_tags($de['carabayar']);
      $tempo = strip_tags($de['tempo']);
      $tgl_jt_tempo = strip_tags($de['tgl_jt_tempo']);
      $subtotal = strip_tags($de['subtotal']);
      $total_sementara = strip_tags($de['total_sementara']);
      $ppn = strip_tags($de['ppn']);
      $materai = strip_tags($de['materai']);
      $total = strip_tags($de['total']);
      $keterangan = strip_tags($de['keterangan']);
    ?>
      <font face='calibri'>
        <div class="panel panel-default">
          <div class="panel-heading">
            <font size="4">EDIT DATA PENJUALAN</font>
          </div>
          <div class="panel-body">
            <form method='post' name='jual' enctype='multipart/form-data' action='module/jual/proses_edit.php'>
              <input type='hidden' name='username' value="<?= $user ?>">
              <input type='hidden' name='id' value="<?= $de['id'] ?>" />
              <div class='col-md-6'>
                <table style=font-size:13px; class='table table-striped table table-bordered' width='600px'>
                  <tr>
                    <td>Nomor Penjualan</td>
                    <td>
                      <input type='text' class='form-control' id='nojual' name='nojual' placeholder='No. Jual *' style='text-transform:uppercase' value="<?= $nojual ?>" readonly>
                    </td>
                  </tr>
                  <tr>
                    <td>Tgl. Penjualan (M/D/Y)</td>
                    <td><input type='date' class='form-control' id='tgljual' name='tgljual' value="<?php echo $tgljual ?>" size='50' autocomplete='off' required></td>
                  </tr>
                  <tr>
                    <td>No. Invoice</td>
                    <td><input type='text' class='form-control' id='noinvoice' name='noinvoice' value='<?= $noinvoice ?>' size='50' autocomplete='off' required></td>
                  </tr>
                  <tr>
                    <td>Tgl. Invoice (M/D/Y)</td>
                    <td><input type='date' class='form-control' id='tglinvoice' name='tglinvoice' size='50' value='<?= $tglinvoice ?>' autocomplete='off' required></td>
                  </tr>
                  <tr>
                    <td>Customer</td>
                    <td>
                      <div class='input-group'> <input type='text' class='form-control' id='kdcustomer' name='kdcustomer' value="<?= $kdcustomer ?>" size='50' autocomplete='off' readonly required>
                        <span class='input-group-btn'>
                          <button type='button' id='src' class='btn btn-primary' onclick='cari_data_customer()'>Cari</button>
                        </span>
                    </td>
                  <tr>
                    <td></td>
                    <td> <input type="text" class='form-control' id='nmcustomer' name='nmcustomer' value="<?= $nmcustomer ?>" size='50' readonly required></td>
                  </tr>
                  <tr>
                    <td>Jenis Order
                    <td><select required id='jenis_order' name='jenis_order' class='form-control' style='width: 200x;'>
                        <?php
                        $jenis_order = array('URGENT', 'NORMAL', 'LAIN-LAIN');
                        $jml_kata = count($jenis_order);
                        for ($c = 0; $c < $jml_kata; $c += 1) {
                          if ($jenis_order[$c] == $de['jenis_order']) {
                            echo "<option value=$jenis_order[$c] selected>$jenis_order[$c] </option>";
                          } else {
                            echo "<option value=$jenis_order[$c]> $jenis_order[$c] </option>";
                          }
                        }
                        echo "</select>";
                        ?>
                  <tr>
                    <td>Biaya Lain</td>
                    <td> <input type="text" class='form-control' name='ket_biaya_lain' value='<?= $ket_biaya_lain ?>'></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td> <input type="number" class='form-control' name='biaya_lain' id='biaya_lain' size='50' value='<?= $biaya_lain ?>' required onkeyup="validAngka_no_titik(this)" onblur="hit_total()" readonly></td>
                  </tr>
                  <tr>
                    <td>Tanggal Kirim<br>(M/D/Y)</br></td>
                    <td> <input type="date" class='form-control' name='tglkirim' size='50' value='<?= $tglkirim ?>' required></td>
                  </tr>
                  <tr>
                    <td>Gudang
                    <td><select id='kdgudang' name='kdgudang' class='form-control' style='width: 200x;' onchange='changeValueGudang(this.value)'>
                        <!--<option value=''> - PILIH SATUAN BARANG - </option>";-->
                        <?php
                        $jsArrayGudang = "var prdNameGudang = new Array();\n";
                        $data = mysqli_query($connect, 'select * from tbgudang order by nama');
                        while ($row = mysqli_fetch_array($data)) {
                          if ($row['kode'] == $de['kdgudang']) {
                            echo "<option value=$row[kode] selected>$row[kode]|$row[nama] </option>";
                          } else {
                            echo '<option name="kdgudang"  value="' . $row['kode'] . '">' . $row['kode'] . '|' . $row['nama'] . '</option>';
                            $jsArraySatuan .= "prdNameGudang['" . $row['kode'] . "'] = {nmgudang:'" . addslashes($row['nama']) . "',kdgudang:'" . addslashes($row['kode']) . "'};\n";
                          }
                        }
                        echo '</select>';
                        ?>
                        <input type='hidden' class='form-control' size='50' id='nmgudang' name='nmgudang' readonly>
                  <tr>
                    <td>Sales
                    <td><select id='kdsales' name='kdsales' class='form-control' style='width: 200x;' onchange='changeValueSales(this.value)'>
                        <!--<option value=''> - PILIH SATUAN BARANG - </option>";-->
                        <?php
                        $jsArraySales = "var prdNameSales = new Array();\n";
                        $data = mysqli_query($connect, 'select * from tbsales order by nama');
                        while ($row = mysqli_fetch_array($data)) {
                          if ($row['kode'] == $de['kdsales']) {
                            echo "<option value=$row[kode] selected>$row[kode]|$row[nama] </option>";
                          } else {
                            echo '<option name="kdsales"  value="' . $row['kode'] . '">' . $row['kode'] . '|' . $row['nama'] . '</option>';
                            $jsArraySales .= "prdNameSales['" . $row['kode'] . "'] = {nmsales:'" . addslashes($row['nama']) . "',kdsales:'" . addslashes($row['kode']) . "'};\n";
                          }
                        }
                        echo '</select>';
                        ?>
                        <input type='hidden' class='form-control' size='50' id='nmsales' name='nmsales' readonly>
                </table>
              </div>
              <div class='col-md-6'>
                <table style=font-size:12px; class='table table-striped table table-bordered' width='600px'>
                  <tr>
                    <td>CARA BAYAR</td>
                    <td><select required name="carabayar" id="carabayar" class='form-control'>
                        <?php
                        $carabayar = array('TUNAI', 'TRANSFER', 'KREDIT', 'KARTU-KREDIT', 'GIRO', 'CEK');
                        $jml_kata = count($carabayar);
                        for ($c = 0; $c < $jml_kata; $c += 1) {
                          if ($carabayar[$c] == $de['carabayar']) {
                            echo "<option value=$carabayar[$c] selected>$carabayar[$c] </option>";
                          } else {
                            echo "<option value=$carabayar[$c]> $carabayar[$c] </option>";
                          }
                        }
                        echo "</select>";
                        ?>
                    </td>
                  </tr>
                  <tr>
                    <td>Tempo (Hari)</td>
                    <td> <input type="number" class='form-control' name='tempo' value='<?= $tempo ?>' size='50'></td>
                  </tr>
                  <tr>
                    <td>Tanggal Jatuh Tempo<br>(M/D/Y)</br></td>
                    <td> <input type="date" class='form-control' name='tgl_jt_tempo' value='<?= $tgl_jt_tempo ?>' size='50'></td>
                  </tr>
                  <tr>
                    <td>Subtotal</td>
                    <td> <input type="number" class='form-control' name='subtotal' id='subtotal' size='50' value='<?= $subtotal ?>' readonly></td>
                  </tr>
                  <tr>
                    <td>Total Sementara</td>
                    <td> <input type="number" class='form-control' id='total_sementara' name='total_sementara' size='50' value='<?= $total_sementara ?>' readonly></td>
                  </tr>
                  <tr>
                    <td>PPn (%)</td>
                    <td> <input type="number" class='form-control' name='ppn' id='ppn' size='50' value='<?= $ppn ?>' onkeyup="validAngka_no_titik(this)" onblur="hit_total()"></td>
                  </tr>
                  <tr>
                    <td>Materai</td>
                    <td> <input type="number" class='form-control' name='materai' id='materai' size='50' value='<?= $materai ?>' onkeyup="validAngka_no_titik(this)" onblur="hit_total()"></td>
                  </tr>
                  <tr>
                    <td>Total</td>
                    <td> <input type="number" class='form-control' name='total' id='total' size='50' value='<?= $total ?>' readonly></td>
                  </tr>
                  <tr>
                    <td>Keterangan</td>
                    <td><textarea type='text' class='form-control' id='keterangan' name='keterangan' autocomplete='off'><?= $keterangan ?></textarea></td>
                  </tr>
                </table>
              </div>
              <div class='col-md-12'>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <input button type="Button" class="btn btn-danger" value="Batal" onClick="history.back()" />
              </div>
          </div>
        </div>
        </form>
      </font>
  <?php
    } else {
      echo "<script>alert('Anda tidak berhak !');history.go(-1) </script>";
    }
  }
} else {

  ?>

  <?php
  include 'cek_akses.php';
  if ($aksesok == 'Y') {
  ?>

    <font face="calibri">
      <div class="panel panel-info">
        <div class="panel-heading">
          <font size="4">PENJUALAN</font>
        </div>
        <div class="panel-body">
          <form method='get'>
            <div class="row">
              <?php
              include('hal_get.php')
              ?>
              <div class="col-md-4 bg">
                <input type="hidden" name="m" value="jual">
                <input type='text' id='kata' name='kata' value="<?= $kata ?>" size='50px' class='form-control' placeholder='NO.JUAL, CUSTOMER' onkeyup='searchTable()'>
              </div>
              <button type='submit' class='btn btn-primary'>
                <span class='glyphicon glyphicon-search'></span> Cari</button>
              <a class="btn btn-danger" href="?m=jual&tipe=tambah">Tambah data</a>
            </div>
          </form>
          </br>
          <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
              <tbody>
                <tr>
                  <th width='30'>No.</th>
                  <th width='80'>No. Penjualan</th>
                  <th width='60'>Tanggal</th>
                  <th>Customer</th>
                  <th width='80'>Total</th>
                  <th width='470'>Aksi</th>
                </tr>
                <?php
                // Cek apakah terdapat data page pada URL
                $page = (isset($_GET['page']) ? $_GET['page'] : 1);
                if (isset($_GET['record'])) {
                  $_SESSION['jmlperhalaman'] = $_GET['record'];
                  $limit = $_GET['record']; //5; // Jumlah data per halamannya**/
                } else {
                  $limit = $_SESSION['jmlperhalaman'];
                }
                $limit_start = ($page - 1) * $limit;
                // Untuk menentukan dari data ke berapa yang akan ditampilkan pada tabel yang ada di database
                if (empty($_GET['kata'])) {
                  $tampil = mysqli_query($connect, "SELECT * FROM jualh order by nojual desc LIMIT " . $limit_start . "," . $limit);
                } else {
                  $cari = $_GET['kata'];
                  $tampil = mysqli_query($connect, "SELECT * FROM jualh WHERE (nojual like '%$cari%' or nmcustomer like '%$cari%') order by nojual desc LIMIT " . $limit_start . "," . $limit);
                }
                if ($page == 1) {
                  $posisi = 0;
                  $_GET['halaman'] = 1;
                } else {
                  $posisi = ($_GET['page'] - 1) * $limit;
                }
                $no = $posisi + 1;
                /*<td><u><a href='?m=jual&tipe=detail&id=$k[norek]'><font color='blue'>$k[norek]</font></a></u></td>**/
                while ($k = mysqli_fetch_assoc($tampil)) {
                  $date = date("m/d/Y", strtotime($k['tgljual']));
                  $customer = $k['kdcustomer'] . '|' . $k['nmcustomer'];
                  $ppn = number_format($k['ppn'], 2, ",", ".");
                  $total = number_format($k['total'], 0, ",", ".");
                  $kurangbayar = number_format($k['kurangbayar'], 0, ",", ".");
                  echo "<tr>
        <td align='center'>$no</td>
				<td><u><a href='#' onclick =lihat_detail('$k[nojual]');><font color='blue'>$k[nojual]</font></a></u></td>
				<td>$date</td>
				<td>$customer</td>
				<td align='right'>$total</td>
				<td align='center'>";
                  //echo "<a class='btn btn-success' href='?m=jual&tipe=detail&id=$k[id]'>Upd.Dtl</a> ";
                  if ($k['proses'] == 'Y') {
                    echo "<a class='btn btn-success' href='?m=jual&tipe=detail_proses&nojual=$k[nojual]&kdcustomer=$k[kdcustomer]'>Detail</a> ";
                  } else {
                    if (isset($_GET['kata']) and isset($_GET['page'])) {
                      echo "<a class='btn btn-success' href='?m=jual&tipe=detail&nojual=$k[nojual]&kdcustomer=$k[kdcustomer]'&kata=$_GET[kata]&page=$_GET[page]'>Detail</a> ";
                    }
                    if (isset($_GET['kata']) and !isset($_GET['page'])) {
                      echo "<a class='btn btn-success' href='?m=jual&tipe=detail&nojual=$k[nojual]&kdcustomer=$k[kdcustomer]'&kata=$_GET[kata]'>Detail</a> ";
                    }
                    if (!isset($_GET['kata']) and isset($_GET['page'])) {
                      echo "<a class='btn btn-success' href='?m=jual&tipe=detail&nojual=$k[nojual]&kdcustomer=$k[kdcustomer]'&page=$_GET[page]'>Detail</a> ";
                    }
                    if (!isset($_GET['kata']) and !isset($_GET['page'])) {
                      echo "<a class='btn btn-success' href='?m=jual&tipe=detail&nojual=$k[nojual]&kdcustomer=$k[kdcustomer]''>Detail</a> ";
                    }
                    //echo "<a class='btn btn-success' href='?m=jual&tipe=detail&nojual=$k[nojual]'>Detail</a> ";
                  }
                  cekakses($connect, $user, 'Penjualan');
                  $lakses = $_SESSION['aksesedit'];
                  if ($lakses == 1) {
                    if ($k['proses'] == 'Y') {
                      echo "<a class='btn btn-info' href='?m=jual&tipe=edit&id=$k[id]' disabled>Edit</a>";
                    } else {
                      echo "<a class='btn btn-info' href='?m=jual&tipe=edit&id=$k[id]'>Edit</a>";
                    }
                  } else {
                    echo "<a class='btn btn-info' href='?m=jual&tipe=edit&id=$k[id]' disabled>Edit</a>";
                  }

                  include "tombol-tombol.php";

                  $lakses = $_SESSION['aksescetak'];
                  if ($lakses == 1) {
                    if ($k['proses'] == 'N') {
                      echo " <button type='button' class='btn btn-warning' onClick='alert_cetak($k[id])' disabled/>
							<span class='glyphicon glyphicon-print'> S</span>
							</button>";
                    } else {
                      echo " <button type='button' class='btn btn-warning' onClick='alert_cetak($k[id])'/>
							<span class='glyphicon glyphicon-print'> S</span>
							</button>";
                    }
                  } else {
                    echo " <button type='button' class='btn btn-warning' onClick='alert_cetak($k[id])' disabled/>
						<span class='glyphicon glyphicon-print'> S</span>
						</button>";
                  }
                  if ($lakses == 1) {
                    if ($k['proses'] == 'N') {
                      echo " <button type='button' class='btn btn-info' onClick='alert_cetak_fp($k[id])' disabled/>
							<span class='glyphicon glyphicon-print'> F</span>
							</button>";
                    } else {
                      echo " <button type='button' class='btn btn-info' onClick='alert_cetak_fp($k[id])'/>
							<span class='glyphicon glyphicon-print'> F</span>
							</button>";
                    }
                  } else {
                    echo " <button type='button' class='btn btn-info' onClick='alert_cetak_fp($k[id])' disabled/>
						<span class='glyphicon glyphicon-print'> F</span>
						</button>";
                  }
                  if ($lakses == 1) {
                    if ($k['proses'] == 'N') {
                      echo " <button type='button' class='btn btn-default' onClick='alert_cetak_fp_kosong($k[id])' disabled/>
							<span class='glyphicon glyphicon-print'> FK</span>
							</button>";
                    } else {
                      echo " <button type='button' class='btn btn-default' onClick='alert_cetak_fp_kosong($k[id])'/>
							<span class='glyphicon glyphicon-print'> FK</span>
							</button>";
                    }
                  } else {
                    echo " <button type='button' class='btn btn-default' onClick='alert_cetak_fp_kosong($k[id])' disabled/>
						<span class='glyphicon glyphicon-print'> FK</span>
						</button>";
                  }
                  echo "</td>";
                  $no++;
                }
                ?>
              </tbody>
            </table>
            <?php
            if (empty($_GET['kata'])) {
              $query = mysqli_query($connect, "select count(*) as jumrec from jualh");
            } else {
              $cari = $_GET['kata'];
              $query = mysqli_query($connect, "select count(*) as jumrec from jualh where (nojual like '%$cari%' or nmcustomer like '%$cari%')");
            }
            $result = mysqli_fetch_array($query);
            echo "<p style='text-align:left'>Jumlah Record : " . number_format($result['jumrec'], 0, ",", ".");
            ?>
          </div>
          <ul class="pagination">
            <!-- LINK FIRST AND PREV -->
            <?php
            if ($page == 1) { // Jika page adalah page ke 1, maka disable link PREV
            ?>
              <li class="disabled"><a href="#">First</a></li>
              <li class="disabled"><a href="#">&laquo;</a></li>
            <?php
            } else { // Jika page bukan page ke 1
              $link_prev = ($page > 1) ? $page - 1 : 1;
            ?>
              <li><a href="dashboard.php?m=jual&kata=<?= $kata ?>&page=1">First</a></li>
              <li><a href="dashboard.php?m=jual&kata=<?= $kata ?>&page=<?php echo $link_prev; ?>">&laquo;</a></li>
            <?php
            }
            ?>
            <!-- LINK NUMBER -->
            <?php
            // Buat query untuk menghitung semua jumlah data
            if (empty($_GET['kata'])) {
              $tampil = mysqli_query($connect, "SELECT * FROM jualh order by nojual desc ");
            } else {
              $cari = $_GET['kata'];
              $tampil = mysqli_query($connect, "SELECT * FROM jualh WHERE (nojual like '%$cari%' or nmcustomer like '%$cari%') order by nojual desc ");
            }
            $get_jumlah = mysqli_num_rows($tampil);
            //echo $get_jumlah;			
            /*$jumlah_page = ceil($get_jumlah['jumlah'] / $limit); // Hitung jumlah halamannya**/
            $jumlah_page = ceil($get_jumlah / $limit);
            $jumlah_number = 2; // Tentukan jumlah link number sebelum dan sesudah page yang aktif
            $start_number = ($page > $jumlah_number) ? $page - $jumlah_number : 1; // Untuk awal link number
            $end_number = ($page < ($jumlah_page - $jumlah_number)) ? $page + $jumlah_number : $jumlah_page; // Untuk akhir link number

            for ($i = $start_number; $i <= $end_number; $i++) {
              $link_active = ($page == $i) ? ' class="active"' : '';
            ?>
              <li<?php echo $link_active; ?>><a href="dashboard.php?m=jual&kata=<?= $kata ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
              <?php
            }
              ?>

              <!-- LINK NEXT AND LAST -->
              <?php
              // Jika page sama dengan jumlah page, maka disable link NEXT nya
              // Artinya page tersebut adalah page terakhir 
              if ($page == $jumlah_page) { // Jika page terakhir
              ?>
                <li class="disabled"><a href="#">&raquo;</a></li>
                <li class="disabled"><a href="#">Last</a></li>
              <?php
              } else { // Jika Bukan page terakhir
                $link_next = ($page < $jumlah_page) ? $page + 1 : $jumlah_page;
              ?>
                <li><a href="dashboard.php?m=jual&kata=<?= $kata ?>&page=<?php echo $link_next; ?>">&raquo;</a></li>
                <li><a href="dashboard.php?m=jual&kata=<?= $kata ?>&page=<?php echo $jumlah_page; ?>">Last</a></li>
              <?php
              }
              ?>
          </ul>

        </div>
      <?php
    } else {
      echo "<font color='red'>Anda tidak punya hak !</font>";
    } ?>
    <?php
  }
    ?>

    <!-- Modal -->
    <div class="modal fade" id="modaldetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel1">Detail Data</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <script src="js/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript">
      function hit_subtotal() {
        var lharga = (parseInt(document.getElementById('qty').value) * parseInt(document.getElementById('harga').value));
        var lsubtotal = lharga - (lharga * (document.getElementById('discount').value)) / 100;
        //alert(lsubtotal);
        document.getElementById('subtotal').value = lsubtotal;
      }

      // $(document).ready(function(){
      // 	$('#kdbarang').on('blur',function(e){
      // 		let cari = $(this).val();
      // 		let cari1 = $('kdcustomer').val();
      // 		$.ajax({
      // 			url: 'repl_barang.php',
      // 			type: 'post',
      // 			data: {kode_barang:cari,kode_customer:cari1},
      // 			success: function(response){
      // 				let data_response = JSON.parse(response);
      // 				if (!data_response){
      // 					$('#nmbarang').val('');
      // 					$('#kdsatuan').val('');					
      // 					$('#harga').val('');
      // 					cari_data_barang();
      // 					return;
      // 				}
      // 				$('#nmbarang').val(data_response['nama']);
      // 				$('#kdsatuan').val(data_response['kdsatuan']);
      // 				$('#harga').val(data_response['harga_beli']);
      // 				//console.log(data_response['nama']);
      // 				//console.log(data_response['satuan']);
      // 			},
      // 			error:function(){
      // 				console.log('file not fount');
      // 			}
      // 		})
      // 		// console.log(cari);
      // 	})
      // })

      $(document).ready(function() {
        $('#kdbarang').on('blur', function(e) {
          let cari = $(this).val()
          let cari1 = $('#kdcustomer').val()
          $.ajax({
            url: 'repl_barang.php',
            type: 'post',
            data: {
              'kode_barang': cari,
              'kode_customer': cari1
            },
            success: function(response) {
              let data_response = JSON.parse(response);
              if (!data_response) {
                $('#nmbarang').val('');
                $('#kdsatuan').val('');
                $('#harga').val('');
                $('#qty').val('');
                cari_data_barang();
                return;
              }
              $('#nmbarang').val(data_response['nama']);
              $('#kdsatuan').val(data_response['kdsatuan']);
              $('#harga').val(data_response['harga_jual']);
              $('#qty').val('1');
              //console.log(data_response['nama']);
              //console.log(data_response['satuan']);
            },
            error: function() {
              console.log('file not fount');
            }
          })
          // console.log(cari);
        })
      })

      function lihat_detail(id) {
        $('#modaldetail').modal('show');
        //$('#modaldetail').find('.modal-body').html(id);
        $.ajax({
          url: './module/jual/lihat_detail.php',
          type: 'post',
          data: {
            kode: id
          },
          success: function(response) {
            $('#modaldetail').find('.modal-body').html(response);
          }
        });
      }
    </script>

    <script>
      function alert_hapus($id) {
        swal({
            title: "Yakin akan dihapus ?",
            text: "Once deleted, you will not be able to recover this data!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
              $href = "module/jual/proses_hapus.php?id=";
              window.location.href = $href + $id;
              // swal("Poof! Your imaginary file has been deleted!", {
              //   icon: "success",
              // });
            } else {
              //swal("Batal Hapus!");
            }
          });
      };
    </script>

    <script>
      function alert_hapus_detail($id) {
        swal({
            title: "Yakin akan dihapus ?",
            text: "Once deleted, you will not be able to recover this data!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
              $href = "module/jual/proses_hapus_detail.php?id=";
              window.location.href = $href + $id;
              // swal("Poof! Your imaginary file has been deleted!", {
              //   icon: "success",
              // });
            } else {
              //swal("Batal Hapus!");
            }
          });
      };
    </script>

    <script>
      function alert_proses($id) {
        swal({
            title: "Yakin akan diproses ?",
            text: "",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
              $href = "module/jual/proses.php?id=";
              window.location.href = $href + $id;
              // swal("Poof! Your imaginary file has been deleted!", {
              //   icon: "success",
              // });
            } else {
              //swal("Batal Hapus!");
            }
          });
      };
    </script>

    <script>
      function alert_unproses($id) {
        swal({
            title: "Yakin akan di Batal Proses ?",
            text: "",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
              $href = "module/jual/batal_proses.php?id=";
              window.location.href = $href + $id;
              // swal("Poof! Your imaginary file has been deleted!", {
              //   icon: "success",
              // });
            } else {
              //swal("Batal Hapus!");
            }
          });
      };
    </script>

    <script type="text/javascript">
      <?php echo $jsArraySales; ?>

      function changeValueSales(id) {
        document.getElementById('kdsales').value = prdNameSales[id].kdsales;
        document.getElementById('nmsales').value = prdNameSales[id].nmsales;
      };
    </script>

    <script type="text/javascript">
      function eraseText() {
        document.getElementById("kdbarang").value = "";
        document.getElementById("nmbarang").value = "";
        document.getElementById("satuan").value = "";
        document.getElementById("qty").value = "";
        document.getElementById("harga").value = "";
        document.getElementById("discount").value = "";
        document.getElementById("subtotal").value = "";
      }

      function hit_total() {
        var lbiaya_lain = parseInt(document.getElementById('biaya_lain').value);
        var ltotal_sementara = (parseInt(document.getElementById('biaya_lain').value) + parseInt(document.getElementById('subtotal').value));
        var lppn = ltotal_sementara * (parseInt(document.getElementById('ppn').value) / 100);
        var lmaterai = parseInt(document.getElementById('materai').value);
        var ltotal = ltotal_sementara + lmaterai + lppn;
        document.getElementById('total_sementara').value = ltotal_sementara;
        document.getElementById('total').value = ltotal;
      }
    </script>

    <script>
      function alert_cetak($id) {
        swal({
            title: "Yakin akan di Cetak Surat Jalan ?",
            text: "",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((willCetak) => {
            if (willCetak) {
              $href = "module/jual/cetak_sj.php?id=";
              window.open($href + $id, "_blank");
              //window.location.href = $href+$id "_blank";
              // swal("Poof! Your imaginary file has been deleted!", {
              //   icon: "success",
              // });
            } else {
              //swal("Batal Hapus!");
            }
          });
      };
    </script>

    <script>
      function alert_cetak_fp($id) {
        swal({
            title: "Yakin akan di Cetak Faktur Penjualan ?",
            text: "",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((willCetak) => {
            if (willCetak) {
              $href = "module/jual/cetak_fp.php?id=";
              window.open($href + $id, "_blank");
              //window.location.href = $href+$id "_blank";
              // swal("Poof! Your imaginary file has been deleted!", {
              //   icon: "success",
              // });
            } else {
              //swal("Batal Hapus!");
            }
          });
      };
    </script>

    <script>
      function alert_cetak_fp($id) {
        swal({
            title: "Yakin akan di Cetak Faktur Penjualan ?",
            text: "",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((willCetak) => {
            if (willCetak) {
              $href = "module/jual/cetak_fp.php?id=";
              window.open($href + $id, "_blank");
              //window.location.href = $href+$id "_blank";
              // swal("Poof! Your imaginary file has been deleted!", {
              //   icon: "success",
              // });
            } else {
              //swal("Batal Hapus!");
            }
          });
      };
    </script>

    <script>
      function alert_cetak_fp_kosong($id) {
        swal({
            title: "Yakin akan di Cetak Faktur Penjualan ?",
            text: "",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((willCetak) => {
            if (willCetak) {
              $href = "module/jual/cetak_fp_pdf.php?id=";
              window.open($href + $id, "_blank");
              //window.location.href = $href+$id "_blank";
              // swal("Poof! Your imaginary file has been deleted!", {
              //   icon: "success",
              // });
            } else {
              //swal("Batal Hapus!");
            }
          });
      };
    </script>