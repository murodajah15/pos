<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Reset Password POS</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="croppie/croppie.css" type="text/css" />
  <!--<link rel="stylesheet" href="assets/css/bootstrap-theme.min.css">-->
  <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />

  <script language="javascript">
    function validasi(isi) {
      if (isi.username.value == "") {
        alert("Username tidak boleh dikosongkan!!");
        isi.username.focus();
        return (false);
      }
      if (isi.email.value == "") {
        alert("Email tidak boleh dikosongkan!!");
        isi.email.focus();
        return (false);
      }
      return (true);
    }
  </script>
</head>

<style>
  .panel-default>.panel-heading {
    background-color: red;
  }
</style>

<div class="loginbox">
  <div class="login_msg">
    <?php
    include("./inc/config.php");
    session_start();
    include "timeout.php";
    date_default_timezone_set('Asia/Jakarta');
    $error = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // username dan password didapat dari form
      $username = $_POST['username'];
      $email = $_POST['email'];
      $sql = "SELECT * FROM user WHERE username = '$username' and email = '$email' and aktif='Y'";
      $result = mysqli_query($connect, $sql);
      $row = mysqli_fetch_assoc($result);
      $count = mysqli_num_rows($result);

      // Jika hasil sesuai $myusername dan $mypassword, table row harus 1 
      if ($count > 0) {
        if ($row['aktif'] == 'N') {
          echo "<script>alert('User tidak aktif')</script>";
          echo "<script type='text/javascript'>  window.location='reset_password.php'; </script>";
        }
        $time = time();
        $datetime = date('Y-m-d H:i:s');
        $password = substr(uniqid(), -6);
        $passwordmd5 = md5($password);
        //$sql = "update user set password='$passwordmd5' where username='$username' and email='$email'";
        //$result = mysqli_query($connect,$sql);
        //session_start();
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email;
        $_SESSION['password'] = $password;
        $_SESSION['passwordmd5'] = $passwordmd5;
        //header("location: dashboard.php");
        // echo '<div class="login-container">';
        // echo '<br>';
        // echo '<p style="text-align:center"><font face="calibri" size="5" color="yellow">Your password has been reset, check your email</font></p>';
        // echo '</div>';
        echo "<script type='text/javascript'>  window.location='send_password.php'; </script>";
      } else {
        /*$error = "Your Name or Email is invalid";
        echo $error;**/
        echo '<div class="login-container">';
        echo '<br>';
        echo '<p style="text-align:center"><font face="calibri" color="red">Your Username or Email is invalid</font></p>';
        echo '</div>';
      }
    }
    ?>

    <body onload="document.login.username.focus()" style="background-color:grey;">
      <div class="container">
        <p><br /><br></p>
        <p><br /></p>
        <div class="row">
          <div class="col-md-4"></div>
          <div class="col-md-4">
            <div class="panel panel-default" style="background-color:white;">
              <div class="panel-body" style='color: black'>
                <h5 class='text-center'><img src='img/logo.png' width='110' height='100' style='margin:-50px 0px' class='img-circle'></h5>
                </br></br>
                <h4 style="text-align: center; margin:0px 0px">Reset Password POS</h4>
                <h1></h1>
                <div class="panel panel-default" style="background-color:grey;">
                  <!--style="background-color:#1E90FF;"-->
                  <div class="panel-body" style='color: black'>
                    <!-- <form role="form" name="login"  method="post" action="send_password.php"> -->
                    <form role="form" name="login" method="POST" onsubmit="return validasi(this)" autocomplete="off">
                      <!--action="cek_login.php"-->
                      <div class="form-group">
                        <label for="username">
                          <font color="black"><b>Username</b></font>
                        </label>
                        <div class="input-group">
                          <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                          <input type='text' class='form-control' name='username' size='10' autofocus='autofocus' value="" autocomplete="off" required>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="email">
                          <font color="black"><b>Email</b></font>
                        </label>
                        <div class="input-group">
                          <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                          <input type="email" name="email" class="form-control" id="email" placeholder="Email" required>
                        </div>
                      </div>
                      <h3></h3>
                      <!--<hr/>
                            <!--<button type="button" class="btn btn-success"><span class="glyphicon glyphicon-arrow-left"></span> Back</button> -->
                      <button type="submit" class="btn btn-primary" name="submit"><span class="glyphicon glyphicon-check"></span> Reset</button>
                      <br></br>
                      <a href="index.php">
                        <font color="white">
                          <h5 style="text-align: left; margin:0px 0px">Kembali ke Login</h5>
                        </font>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
    </body>

</html>