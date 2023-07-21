<body>
  <script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
  <?php
  include "../../inc/config.php";
  session_start();
  date_default_timezone_set('Asia/Jakarta');
  $user = $_SESSION['username'];
  $user_proses = "Proses Salin-" . $user . "-" . date('d-m-Y H:i:s');
  $qrycust = mysqli_query($connect, "select * from tbcustomer order by kode");
  $success = 'Y';
  while ($k = mysqli_fetch_assoc($qrycust)) {
    $kdcustomer = strip_tags($k['kode']);
    $qrybarang = mysqli_query($connect, "select * from tbbarang order by kode");
    $ncust = 1;
    while ($de = mysqli_fetch_assoc($qrybarang)) {
      $kdbarang = strip_tags($de['kode']);
      // if ($kdbarang == 'TEST') {
      $nmbarang = strip_tags($de['nama']);
      $harga = $de['harga_jual'];
      $discount = '0.00';
      $qrymulti = mysqli_query($connect, "select * from tbmultiprc where kdcustomer='$kdcustomer' and kdbarang='$kdbarang'");
      $rec = mysqli_num_rows($qrymulti);
      if ($rec == 0) {
        echo 'Record ' . $ncust . ', Kode Customer ' . $kdcustomer, ', Kode Barang ' . $kdbarang, ', Nama Barang ' . $nmbarang . '<br>';
        $query = $connect->prepare("INSERT INTO tbmultiprc (kdbarang,nmbarang,harga,discount,kdcustomer,user) values (?,?,?,?,?,?)");
        $query->bind_param('ssssss', $kdbarang, $nmbarang, $harga, $discount, $kdcustomer, $user_proses);
        if ($query->execute() and mysqli_affected_rows($connect) > 0) {
        } else {
          $success = 'N';
        }
      }
      $ncust++;
    }
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


  ?>
</body>