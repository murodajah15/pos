<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="css/bootstrap.min.css">
	<?php include ('config.php'); ?>
	<div class="container" style='padding-top:20px'>
		<div class="row">
			<div class="col-md-6">
				<div class="progress">
					<?php $o =  mysqli_query($connect, "SELECT count(*) AS jumlah FROM tbbarang"); ?>
					<?php while($isi = mysqli_fetch_array($o)){ ?>
					<div class="progress-bar" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:40%">
				  <!--<div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em;">-->
				    <?php echo $isi['jumlah'] . "%"; ?>
				  </div>
					<?php } ?>
				</div>
			</div>
			<!--<div class="col-md-6">
				<div class="progress">
				  <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:70%">
				    <span class="sr-only">70% Complete</span>
				  </div>
				</div>
			</div>	-->
		</div>
	</div>

<div class="container" style='padding-top:20px'>
  <h2>Basic Progress Bar</h2>
		<div class="row">
			<div class="col-md-6">
				<div class="progress">
					<?php
					$sql = "SELECT * FROM tbbarang";
					$query = mysqli_query($connect,$sql);
					$jumrec = mysqli_num_rows($query);
					$data  = array();
					while(($row = mysqli_fetch_array($query)) != null){
					  $data[]=$row;
					  $recn = count($data);
					  $record = (($recn/$jumrec) * 100);
					  ?>
						  <div class="progress-bar" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:50%">
						  </div>
						<?php
					}
					// $count =count($data);
					// echo 'jumlah'.$jumrec;
					// echo "Jumlah data dari array PHP: $count";
					//wait wind 'Proses ... '+alias()+' Record '+allt(str(recno()))+' '+str((recn()/recc() * 100),8,2)+' %' nowa
					?>
				</div>
			</div>
		</div>
	</div>

	<div class="container" style='padding-top:20px'>
		<div class="row">
			<div class="col-md-6">
					<div class="progress">
					<?php $o =  mysqli_query($connect, "SELECT count(*) AS jumlah FROM tbbarang");
						$d = mysqli_fetch_assoc($o);
						echo $d['jumlah'];
					?>
					<?php while($isi = mysqli_fetch_array($o)){ 
						$data[]=$isi;
				  	$recn = count($data);
					  $record = 50; //(($recn/$jumrec) * 100);						
						?>
						<div class="progress-bar" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:<?=$record?>%">
				    <?php echo $isi['jumlah'] . "%"; ?>
				  </div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>

</head>
</html>