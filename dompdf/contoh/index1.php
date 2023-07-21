<html>
	<head>
		<title>Membuat Laporan PDF dengan DomPDF</title>
		<style type="text/css">
			label{
				display:inline-block;
				width:100px;
			}
			
			#topdf{
				margin:0 0 0 100px;
			}
			
		</style>
	</head>
	<body>
		<h1>Form Pendaftaran Member</h1>
		<p>Silahkan masukkan nama dan alamat Anda, untuk mencetak laporan PDF menggunakan dompdf</p>
		<form action="topdf.php" method="POST">
		<label>Nama</label><input type="text" name="nama" /><br />
		<label>Alamat</label><textarea name="alamat"></textarea><br />
		<input type="submit" name="kirim" id="topdf" value="Ambil Laporan!" />
		</form>
	</body>
</html>