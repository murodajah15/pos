<body>
	<script src="./js/sweet-alert.min.js" type="text/javascript"></script>
	<?php
        include "./inc/config.php";
        date_default_timezone_set('Asia/Jakarta');
        session_start();
		$username = $_SESSION['username']; //strip_tags($_POST['username']);
        $email = $_SESSION['email']; //strip_tags($_POST['email']);
        $passwordmd5 = $_SESSION['passwordmd5'];
		if (!empty($email)) {
            $ketemu=0;
            $query = mysqli_query($connect,"select * from user where username='$username' and email='$email'");
			if (mysqli_fetch_row($query)>0){
                $ketemu=1;
            }
            if ($ketemu>0){
                $password = trim($_SESSION['password']);
                include ("php_mailer/mail_reset_password.php");                    
                ?>
                <script>
                    swal({title: "Password berhasil direset, Silahkan cek email dan login kembali", text: "", icon: 
                    "success"}).then(function(){window.location.href='index.php';
                       }
                    );
                </script>
                <?php
            }else{
                ?>
                <script>
                    swal({title: "Gagal reset password ", text: "", icon: 
                    "error"}).then(function(){window.location.href='reset_password.php'; //function(){window.history.go(-1); //then(function(){window.location.href='../../dashboard.php?m=order_part';
                    }
                    );
                </script>
                <?php
            }
        }else{
            ?>
            <script>
                swal({title: "Username/Email tidak terdaftar", text: "", icon: 
                "error"}).then(function(){window.history.go(-1); //then(function(){window.location.href='../../dashboard.php?m=order_part';
                   }
                );
            </script>
            <?php
        }
            //header("location:../../dashboard.php?m=jual");
            //header("location:../../dashboard.php?m=jadwal_kerja&tipe=jadwal_kerja_dtl&id=$id");
	?>
</body>