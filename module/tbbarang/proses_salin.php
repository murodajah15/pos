<body>
  <script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
  <?php
  include "../../inc/config.php";
  session_start();
  date_default_timezone_set('Asia/Jakarta');
  $user = $_SESSION['username'];
  $user_proses = "Proses Salin-" . $user . "-" . date('d-m-Y H:i:s');
  $qrycust = mysqli_query($connect, "select * from tbcustomer");
  $success = 'Y';
  $ncust = 1;
  $values = "";
  while ($k = mysqli_fetch_assoc($qrycust)) {
    $kdcustomer = strip_tags($k['kode']);
    $qrybarang = mysqli_query($connect, "select kode,nama,harga_jual from tbbarang");
    // while ($de = mysqli_fetch_assoc($qrybarang)) {
    //   $kdbarang = strip_tags($de['kode']);
    //   // if ($kdbarang == 'TEST') {
    //   $nmbarang = strip_tags($de['nama']);
    //   $harga = $de['harga_jual'];
    //   $discount = '0.00';
    //   $qrymulti = mysqli_query($connect, "select * from tbmultiprc where kdcustomer='$kdcustomer' and kdbarang='$kdbarang'");
    //   $rec = mysqli_num_rows($qrymulti);
    //   if ($rec == 0) {
    //     echo $ncust . $kdcustomer, '   Kode ' . $kdbarang, '  Nama ' . $nmbarang . '<br>';
    //     $m = mysqli_query($connect, 'insert into tbmultiprc (kdbarang,nmbarang,harga,discount,kdcustomer,user) values ("$kdbarang","$nmbarang","$harga","$discount","$kdcustomer","$user_proses")');
    //     if ($m > 0) {
    //     } else {
    //       $success = 'N';
    //     }
    //   }
    //   $ncust++;
    // }

    while ($de = mysqli_fetch_assoc($qrybarang)) {
      $kdbarang = str_replace('"', "''", strip_tags($de['kode'])); //ganti kutip ke petik 2
      $nmbarang = str_replace('"', "''", strip_tags($de['nama'])); //ganti kutip ke petik 2
      $harga = $de['harga_jual'];
      $discount = '0.00';
      $qrymulti = mysqli_query($connect, "select * from tbmultiprc where kdcustomer='$kdcustomer' and kdbarang='$kdbarang'");
      $rec = mysqli_num_rows($qrymulti);
      if ($rec == 0) {
        if ($values == "") {
          $values .= '("' . $kdbarang . '"' . ',' . '"' . $nmbarang . '","' . $harga . '","' . $discount . '","' . $kdcustomer . '","' . $user_proses . '")';
        } else {
          $values .= ',("' . $kdbarang . '"' . ',' . '"' . $nmbarang . '","' . $harga . '","' . $discount . '","' . $kdcustomer . '","' . $user_proses . '")';
        }
      }
    }
    // echo $kdcustomer . '<br>';
    // echo $values . '<br>';
    $ncust++;
  }

  // echo $values;
  if ($values <> "") {
    $qry = "insert into tbmultiprc (kdbarang,nmbarang,harga,discount,kdcustomer,user)  values " . $values;
    // echo $qry;
    $hasil = mysqli_query($connect, $qry);
    if ($hasil > 0) {
      $success = 'Y';
    } else {
      $success = 'N';
    }
    if ($success == 'Y') {
  ?>
      <script>
        swal({
          title: "Data berhasil disalin",
          text: "",
          icon: "success"
        }).then(function() {
          window.location.href = '../../dashboard.php?m=tbbarang'; //window.history.back(); //
        });
      </script>
    <?php
    } else {
    ?>
      <script>
        swal({
          title: "Gagal salin data",
          text: "",
          icon: "error"
        }).then(function() {
          window.location.href = '../../dashboard.php?m=tbbarang'; //window.history.back(); //window.location.href='../../dashboard.php?m=opname';
        });
      </script>
    <?php
    }
  } else {
    ?>
    <script>
      swal({
        title: "Tidak ada data yang disalin",
        text: "(Sudah pernal disalin)",
        icon: "error"
      }).then(function() {
        window.location.href = '../../dashboard.php?m=tbbarang'; //window.history.back(); //window.location.href='../../dashboard.php?m=opname';
      });
    </script>
  <?php
  }

  ?>
</body>