<?php
include("./inc/config.php");

if (count($_POST)) {
  $kdcustomer = $_POST['kode'];
  $query = mysqli_query($connect, "select tbcustomer.kode,tbcustomer.nama from tbcustomer where kode='$kdcustomer'");
  $de = mysqli_fetch_assoc($query);
  echo json_encode($de);
}
