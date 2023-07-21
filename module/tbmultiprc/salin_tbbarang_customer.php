<body>
  <script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
  <?php
  include "../../inc/config.php";
  $kdcustomer = $_GET['id'];
  $kdcustomersalin = $_GET['kdcustomersalin'];
  $query = $connect->prepare("delete from tbmultiprc where kdcustomer=?");
  $query->bind_param('s', $kdcustomer);
  if ($query->execute()) {
    $data = mysqli_query($connect, "select kdcustomer,kdbarang,nmbarang,harga from tbmultiprc where kdcustomer='$kdcustomersalin'");
    $n = 0;
    while ($row = mysqli_fetch_array($data)) {
      $user_input = "Salin-" . "-" . date('d-m-Y H:i:s');
      $kdbarang = strip_tags($row['kdbarang']);
      $nmbarang = strip_tags($row['nmbarang']);
      $harga = $row['harga'];
      $query = $connect->prepare("INSERT INTO tbmultiprc (kdcustomer,kdbarang,nmbarang,harga,user) values (?,?,?,?,?)");
      $query->bind_param('sssis', $kdcustomer, $kdbarang, $nmbarang, $harga, $user_input);
      if ($query->execute() and mysqli_affected_rows($connect) > 0) {
        $n++;
      }
    }
    echo $n . ' record customer ' . $kdcustomersalin . ' berhasil disalin';
  ?>
    <script>
      swal({
        title: "Data berhasil disalin",
        text: "",
        icon: "success"
      }).then(function() {
        window.history.back(); //window.location.href='../../dashboard.php?m=wo';
      });
    </script>
  <?php
  } else {
    // echo "<script>alert('Gagal hapus data !');
    // window.location.href='../../dashboard.php?m=wo';
    // </script>";				
  ?>
    <script>
      swal({
        title: "Gagal salin data",
        text: "",
        icon: "error"
      }).then(function() {
        window.history.back(); //window.location.href='../../dashboard.php?m=wo';
      });
    </script>
  <?php
  }
  //header("location:../../dashboard.php?m=wo");	
  ?>
</body>