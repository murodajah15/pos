<body>
    <script src="./js/sweet-alert.min.js" type="text/javascript"></script>
    <?php
        date_default_timezone_set('Asia/Jakarta');
        $datetime = date('Y-m-d H:i:s');
        if($_GET['email'] && $_GET['password']){
            $user_update = 'Update '.strtoupper($_GET['userid']).' '.$datetime;
            $userid = $_GET['userid'];
            $email = $_GET['email'];
            $password = $_GET['password'];
            $passwordmd5 = md5($password);
            include("./inc/config.php");
            $query = $connect->prepare("update user set password=?,user_input=? where username=? and email=?");
            $query->bind_param('ssss',$passwordmd5,$user_update,$userid,$email);
            if($query->execute() and mysqli_affected_rows($connect)>0){
                ?>
                <script>
                    swal({title: "Password berhasil direset, Silahkan login kembali", text: "", icon: 
                    "success"}).then(function(){window.location.href='index.php';
                       }
                    );
                </script>
                <?php
            }else{
                //echo $user_update.', '.$userid.', '.$email.', '.$passwordmd5;
                ?>
                <script>
                    swal({title: "Gagal reset password", text: "", icon: 
                    "error"}).then(function(){window.location.href='index.php';
                      }
                    );
                </script>
                <?php
            }
        }
    ?>
</body>