<div class="col-md-2 bg">
	<select name="record" class="form-control" title="Tampil data perhalaman" onChange="this.form.submit()">
	<?php
		$kata = (isset($_GET['kata']) ? $_GET['kata'] : "");
		$jumperhal=array('5','15','25','35','45','55','100');
		$jml_kata=count($jumperhal);
		for($c=0; $c<$jml_kata; $c+=1){
			if ($jumperhal[$c]==$_GET['record']){
				echo "<option value=$jumperhal[$c] selected>$jumperhal[$c] </option>";
			}else{
				echo "<option value=$jumperhal[$c]> $jumperhal[$c] </option>";
			}
		}	
	?>
	</select>
</div>