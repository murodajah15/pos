while ($k = mysqli_fetch_assoc($tampil)) {
$noso = strip_tags($k['noso']);
$kdbarang = strip_tags($k['kdbarang']);
$nmbarang = strip_tags($k['nmbarang']);
$qty = number_format($k['qty'], 2, ",", ".");
$harga = number_format($k['harga'], 0, ",", ".");
$discount = number_format($k['discount'], 2, ",", ".");
$subtotal = number_format($k['subtotal'], 0, ",", ".");
//$date = date("m/d/Y", strtotime($k['tglwo']));
echo "<tbody>
  <td align='center'>$no</td>
  <td width='100'>$k[noso]</td>
  <td width='100'>$k[kdbarang]</td>
  <td width='300'>$k[nmbarang]</td>
  <td width='10'>$k[kdsatuan]</td>
  <td align='right'>$qty</td>
  <td align='right'>$harga</td>
  <td align='right'>$discount</td>
  <td align='right'>$subtotal</td>
  <td align='center' width='160px'>";
    echo "<a class='btn btn-primary btn-sm' href='?m=jual&tipe=edit_detail&id=$k[id]&kdcustomer=$data[kdcustomer]'>Edit</a> ";
    echo " <input button type='button' class='btn btn-danger btn-sm' value='Hapus' onClick='alert_hapus_detail($k[id])' />";
    $no++;
    }
    $tampil = mysqli_query($connect, "select sum(qty) as total_qty,sum(subtotal) as total_subtotal from juald where nojual='$nojual'");
    $jum = mysqli_fetch_assoc($tampil);
    $total_qty = $jum['total_qty'];
    $total_qty = number_format($total_qty, 2, ",", ".");
    $total = number_format($jum['total_subtotal'], 0, ",", ".");;
    echo "<tr>
</tbody>";
echo "<td colspan='5'></td>
<td align='right' style='font-weight:bold'>$total_qty</td>
<td align='right' colspan='3' style='font-weight:bold'>$total</td>";