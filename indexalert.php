<html>
    <head>
        <title>alert</title>
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="js/sweet-alert.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <!-- Note: this file is only intended for development use! -->
        <!--<div class="sweet-overlay"></div>
        <!--<input button type='Button' class='btn btn-danger' value='Hapus' onClick='hapus()'/>
        <!-- SweetAlert box -->
        <script src="js/sweet-alert.min.js" type="text/javascript"></script>
        <script>
            swal("Good job!", "You clicked the button!", "success")
           //swal("Deleted!", "Your imaginary file has been deleted.", "success");
            function hapus(){
                swal({
                  title: "Are you sure?",
                  text: "Once deleted, you will not be able to recover this imaginary file!",
                  icon: "warning",
                  buttons: true,
                  dangerMode: true,
                })
                .then((willDelete) => {
                  if (willDelete) {
                    swal("Poof! Your imaginary file has been deleted!", {
                      icon: "success",
                    });
                  } else {
                    swal("Your imaginary file is safe!");
                  }
                });
            };  
        </script>
    </body>
</html>