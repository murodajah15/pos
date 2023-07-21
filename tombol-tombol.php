<?php
$lakses = $_SESSION['akseshapus'];
// if ($lakses == 1) {
// 	if ($k['proses']=='Y') {
//       	echo " <input button type='Button' class='btn btn-danger' value='Hapus' onClick='alert_hapus($k[id])' disabled/>";
//       }else{
// 			echo " <a class='btn btn-danger' href='module/po/proses_hapus.php?id=$k[id]&kode=$k[kode]'
// 		onClick='return confirm(\"Anda yakin akan menghapus ?\")'>Hapus</a>";*
// 		echo " <input button type='Button' class='btn btn-danger' value='Hapus' onClick='alert_hapus($k[id])'/>";
// 	}
// }
if ($lakses == 1) {
	if ($k['proses'] == 'Y') {
		echo " <button type='Button' class='btn btn-danger btn-sm' value='Hapus' onClick='alert_hapus($k[id])' disabled/><span class='glyphicon glyphicon-trash'></span></button>";
	} else {
		/*echo " <a class='btn btn-danger' href='module/terima/proses_hapus.php?id=$k[id]&kode=$k[kode]'
			onClick='return confirm(\"Anda yakin akan menghapus ?\")'>Hapus</a>";**/
		echo " <button type='Button' class='btn btn-danger btn-sm' onClick='alert_hapus($k[id])'/>
			<span class='glyphicon glyphicon-trash'></span></button>";
	}
} else {
	echo " <button type='Button' class='btn btn-danger btn-sm' value='Hapus' onClick='alert_hapus($k[id])' disabled/><span class='glyphicon glyphicon-trash'></span></button>";
}
// $lakses = $_SESSION['aksesproses'];
// if ($lakses == 1) {
// 	/*echo " <a class='btn btn-danger' href='module/wo/proses_hapus.php?id=$k[id]&kode=$k[kode]'
// 	onClick='return confirm(\"Anda yakin akan menghapus ?\")'>Hapus</a>";**/
// 	if ($k['proses']=='Y') {
// 		echo " <input button type='Button' class='btn btn-danger' value='Proses' onClick='alert_proses($k[id])' disabled/>";
// 	}else{
// 		echo " <input button type='Button' class='btn btn-danger' value='Proses' onClick='alert_proses($k[id])'/>";
// 	}
// }
$lakses = $_SESSION['aksesproses'];
if ($lakses == 1) {
	/*echo " <a class='btn btn-danger' href='module/wo/proses_hapus.php?id=$k[id]&kode=$k[kode]'
		onClick='return confirm(\"Anda yakin akan menghapus ?\")'>Hapus</a>";**/
	if ($k['proses'] == 'Y') {
		echo " <button type='Button' class='btn btn-danger btn-sm' onClick='alert_proses($k[id])' disabled/>
			<span class='glyphicon glyphicon-circle-arrow-right'></span></button>";
	} else {
		echo " <button type='Button' class='btn btn-danger btn-sm' onClick='alert_proses($k[id])'/>
			<span class='glyphicon glyphicon-circle-arrow-right'></span></button>";
	}
} else {
	echo " <button type='Button' class='btn btn-danger btn-sm' onClick='alert_proses($k[id])' disabled/>
		<span class='glyphicon glyphicon-circle-arrow-right'></span></button>";
}
// $lakses = $_SESSION['aksesunproses'];
// if ($lakses == 1) {
// 	/*echo " <a class='btn btn-danger' href='module/po/proses_hapus.php?id=$k[id]&kode=$k[kode]'
// 	onClick='return confirm(\"Anda yakin akan menghapus ?\")'>Hapus</a>";**/
// 	if ($k['proses']=='N') {
// 		echo " <input button type='Button' class='btn btn-danger' value='UnProses' onClick='alert_unproses($k[id])' disabled />";
// 	}else{
// 		echo " <input button type='Button' class='btn btn-danger' value='UnProses' onClick='alert_unproses($k[id])'/>";
// 	}
// }
$lakses = $_SESSION['aksesunproses'];
if ($lakses == 1) {
	/*echo " <a class='btn btn-danger' href='module/terima/proses_hapus.php?id=$k[id]&kode=$k[kode]'
		onClick='return confirm(\"Anda yakin akan menghapus ?\")'>Hapus</a>";**/
	if ($k['proses'] == 'N') {
		echo " <button type='Button' class='btn btn-danger btn-sm' onClick='alert_unproses($k[id])' disabled />
			<span class='glyphicon glyphicon-circle-arrow-left'></span></button>";
	} else {
		echo " <button type='Button' class='btn btn-danger btn-sm' onClick='alert_unproses($k[id])'/>
			<span class='glyphicon glyphicon-circle-arrow-left'></span></button>";
	}
} else {
	echo " <button type='Button' class='btn btn-danger btn-sm' onClick='alert_unproses($k[id])' disabled />
		<span class='glyphicon glyphicon-circle-arrow-left'></span></button>";
}
