<body>
	<script src="../../js/sweet-alert.min.js" type="text/javascript"></script>
   	<?php
        include "../../inc/config.php";
        $aktif='Y';
        $id = $_GET['id'];
        $cari = $id-1;
        $k=mysqli_fetch_assoc(mysqli_query($connect,"select * from stock_barang where periode='$cari'"));
        if ($k['periode']==$cari){
            $query = $connect->prepare("update saplikasi set closing_hpp=? where aktif=?");
            $query->bind_param('ss',$cari,$aktif);				
            if($query->execute()){ //and mysqli_affected_rows($connect)>0
                // echo "<script>alert('Data berhasil disimpan !');
                // window.location.href='../../dashboard.php?m=wo';
                // </script>";	
                mysqli_query($connect,"update close_hpp set status='N' where periode='$id'");
                ?>
                <script>
                    swal({title: "Unclosing Berhasil ", text: "", icon: 
                    "success"}).then(function(){window.location.href='../../dashboard.php?m=closing_hpp';
                    }
                    );
                </script>
                <?php
            }else{
                // echo "<script>alert('Gagal simpan data !');
                // window.location.href='../../dashboard.php?m=wo';
                // </script>";							
                ?>
                <script>
                    swal({title: "Unclosing Gagal ", text: "", icon: 
                    "error"}).then(function(){window.location.href='../../dashboard.php?m=closing_hpp';
                    }
                    );
                </script>
                <?php
            }		
        }else{
            $cari = "";
            $query = $connect->prepare("update saplikasi set closing_hpp=? where aktif=?");
            $query->bind_param('ss',$cari,$aktif);				
            if($query->execute()){ //and mysqli_affected_rows($connect)>0
                // echo "<script>alert('Data berhasil disimpan !');
                // window.location.href='../../dashboard.php?m=wo';
                // </script>";	
                mysqli_query($connect,"update close_hpp set status='N' where periode='$id'");
                $k=mysqli_fetch_assoc(mysqli_query($connect,"select * from close_hpp where status='Y' order by periode desc"));
                echo $k['periode'];
                $periodesblm = $k['periode'];
                $bulan = substr($k['periode'],-2);
                $tahun = substr($k['periode'],0,-2);
                mysqli_query($connect,"update saplikasi set closing_hpp='$periodesblm',bulan='$bulan',tahun='$tahun' where aktif='Y'" );
                ?>
                <script>
                    swal({title: "Unclosing Berhasil ", text: "", icon: 
                    "success"}).then(function(){window.location.href='../../dashboard.php?m=closing_hpp';
                    }
                    );
                </script>
                <?php
            }else{
                // echo "<script>alert('Gagal simpan data !');
                // window.location.href='../../dashboard.php?m=wo';
                // </script>";							
                ?>
                <script>
                    swal({title: "Unclosing Gagal ", text: "", icon: 
                    "error"}).then(function(){window.location.href='../../dashboard.php?m=closing_hpp';
                    }
                    );
                </script>
                <?php
            }            
        }
	?>
</body>
