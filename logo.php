<?php
    $html = '<style>
        table {
        border-collapse: collapse;
        }	
        body { font-family: comic sans ms;}
    </style>';
    $logo = $_SESSION['logo'];
    if ($logo<>"") {
        $filename = "../../img/".$logo;
        if (file_exists($filename)) {
            //$html .= '<table border="0"><tr><td rowspan="4"><img src="../../img/'."$logo".'" width="50"></td><td>'.$nm_perusahaan.'<br><font size="1">'.$alamat_perusahaan.'<br>'.$telp_perusahaan.'</font></td></tr></table>';
            $html .= '<table border="0"><tr><td rowspan="1" width="40"><img src="../../img/'."$logo";
            $html .= '" width="50"></td><td>'.$nm_perusahaan.'<br><font size="1">'.$alamat_perusahaan.'<br>'.$telp_perusahaan.'</font></td></tr></table>';	
        }else{
            $html .= '<table border="0"><tr><td>'.$nm_perusahaan.'<br><font size="1">'.$alamat_perusahaan.'<br>'.$telp_perusahaan.'</font></td></tr></table>';
        }
    }else{
        $html .= '<table border="0"><tr><td>'.$nm_perusahaan.'<br><font size="1">'.$alamat_perusahaan.'<br>'.$telp_perusahaan.'</font></td></tr></table>';
    }
?>