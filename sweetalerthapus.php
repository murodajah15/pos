<!-- Include your assets sweetalert -->
<html>
	<head>
		<title>
		</title>
	</head>
	<!-- Masukkan js dan css disini -->
	<link href="css/sweetalert.css" rel="stylesheet" type="text/css" >
	<link href="css/bootstrap.css" rel="stylesheet" type="text/css" >
	<script src="js/jquery-ui-1.10.3.min.js"></script>
	<script src="js/sweetalert.min.js"></script>

<style type="text/css">
.text-center{
  margin-top: 140px;
}
</style>

<div class="text-center">
<p>Click on Delete Button</p>
<button type="button" class="btn btn-danger">
  <i class="glyphicon glyphicon-trash"></i> Delete
</button>
</div>

 
<script>
$('button').click(function(){
  
  swal({
  title: 'Are you sure?',
  text: "It will permanently deleted !",
  type: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
}).then(function() {
  swal(
    'Deleted!',
    'Your file has been deleted.',
    'success'
  );
})
  
})

</srcipt>    
	
	</body>
</html>