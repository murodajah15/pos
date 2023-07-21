<?php
include("./inc/config.php");
date_default_timezone_set('Asia/Jakarta');
echo date('d-m-y h:i:s') . '<br>';
// Approv_batas_piutang
// $text = "ALTER TABLE approv_batas_piutang ALTER COLUMN noapprov SET DEFAULT '',ALTER COLUMN nojual SET DEFAULT ''";
// $text .= ",ALTER COLUMN nmcustomer SET DEFAULT '',ALTER COLUMN total SET DEFAULT 0,ALTER COLUMN keterangan SET DEFAULT ''";
// $text .= ",ALTER COLUMN proses SET DEFAULT 'N',ALTER COLUMN batal SET DEFAULT 'N',ALTER COLUMN user SET DEFAULT ''";
// $text .= ",ALTER COLUMN user_proses SET DEFAULT ''";
// echo $text . '<br>';
// $query = mysqli_query($connect, $text);

$n = 0;
$count = 0;
$dababase = 'pos';
$sqltables = "SHOW TABLES FROM $database";
$result = mysqli_query($connect, $sqltables);
while ($tablerow = mysqli_fetch_row($result)) {
  $n++;
  echo "Table " . ++$count . ": {$tablerow[0]}" . "<br>";
  $table = $tablerow[0];
  $count = 0;
  $sqlfields = "SELECT * FROM information_schema.columns WHERE table_schema = '$database' AND table_name = '$table'"; // Change the table_name your own table name
  $resultfields = mysqli_query($connect, $sqlfields);
  while ($row = mysqli_fetch_row($resultfields)) {
    $nmfield = $row[3];
    $typefeld = $row[7];
    $count++;
    if ($row[7] == "int" or $row[7] == "bigint" or $row[7] == "decimal") {
      $sql = "ALTER TABLE $table ALTER COLUMN $nmfield SET DEFAULT 0";
    }
    if ($row[7] == "varchar" or $row[7] == "char" or $row[7] == "text") {
      $sql = "ALTER TABLE $table ALTER COLUMN $nmfield SET DEFAULT ''";
    }
    if ($row[7] == "enum") {
      $sql = "ALTER TABLE $table ALTER COLUMN $nmfield SET DEFAULT 'N'";
    }
    if ($row[7] == "date") {
      $sql = "ALTER TABLE $table CHANGE COLUMN $nmfield $nmfield DATE NULL DEFAULT NULL"; //'0000-00-00 00:00:00'";
    }
    if ($row[7] == "datetime" or $row[7] == "timestamp") {
      $sql = "ALTER TABLE $table CHANGE COLUMN $nmfield $nmfield TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP"; //'0000-00-00 00:00:00'";
    }
    $query = mysqli_query($connect, $sql);
  }
  echo $count . ' fields updated <br>';
  // if ($n > 3) {
  //   exit();
  // }
}
