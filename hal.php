<!--<div class="col-md-2 bg">
	<form method='post'>
		<select name="record" class="form-control" title="Tampil data perhalaman" onChange="this.form.submit()">
			<option value="5">          5</option>
			<option value="15">        15</option>
			<option value="25">        25</option>
			<option value="35">        35</option>
			<option value="45">        45</option>
			<option value="55">        55</option>
			<option value="65">        65</option>
			<option value="9999999999999999999">        All</option>
		</select>
	</form>
</div>-->

<div class="col-md-2 bg">
	<form method='post'>
		<select name="record" class="form-control" title="Tampil data perhalaman" onChange="this.form.submit()">
		<?php
			$jumperhal=array('5','15','25','35','45','55','100');
			$jml_kata=count($jumperhal);
			for($c=0; $c<$jml_kata; $c+=1){
				if ($jumperhal[$c]==$_POST['record']){
					echo "<option value=$jumperhal[$c] selected>$jumperhal[$c] </option>";
				}else{
					echo "<option value=$jumperhal[$c]> $jumperhal[$c] </option>";
				}
			}	
		?>
		</select>
	</form>
</div>
