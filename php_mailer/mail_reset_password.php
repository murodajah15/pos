<?php
require 'php_mailer/PHPMailer_5.2.4/class.phpmailer.php';

date_default_timezone_set('Asia/Jakarta');
$alm_mail = $email; //'murod@gpa.co.id';
$alm_mailcc = 'murod@honda-autoland.com';
$alm_mailcc1 = '';
$alm_mailcc2 = '';
$alm_mailfrom = 'murod@honda-autoland.com';
$subjek = 'Reset Password POS';
$pass = '@Mrd150372@'; //'Mrd15037222';
$tgl = date('d-m-Y');
$wkt = date('H:i:s');


$mail = new PHPMailer;

$mail->IsSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'srv113.niagahoster.com'; //'srv17.niagahoster.com'; //'localhost';  // Specify main and backup server
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = $alm_mailfrom;                            // SMTP username
$mail->Password = $pass;                           // SMTP password
$mail->SMTPSecure = 'ssl';                            // Enable encryption, 'ssl' also accepted

//$mail->SMTPDebug = 1;
$mail->Port = 465; //587; //467; //587**/

$mail->From = $alm_mailfrom;
$mail->FromName = 'POS System';

$mail->AddAddress($alm_mail);               // Name is optional

$mail->AddCC($alm_mailcc);
//$mail->AddCC($alm_mailcc1);
//$mail->AddCC($alm_mailcc2);

//$mail->AddBCC('bcc@example.com');

$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
//$mail->AddAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->AddAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->IsHTML(true);                                  // Set email format to HTML

$mail->Subject = $subjek;
//$mail->Body    = 'isi pesannya ini lho';
$link = "<a href='http://localhost:8090/pos/click_reset_password.php?email=" . $alm_mail . "&password=" . $password . "&userid=" . $username . "'>Click To Reset Password</a>";
$mail->Body    = '<b>Reset Password</b><br><br> ' . 'User ID : <b>' . $username . '</b><br>Password baru anda : ' . '<b>' . $password . '</b>' . '<br><br>' . $link; //'<b>Reset Password E-HRMS Autoland </b><br><br>'.'Password anda : '.'<b>'.$password.'</b>';
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if (!$mail->Send()) {
  echo 'Gagal mengirim email, Silahkan click '; ?><a href="<?php $_SERVER['PHP_SELF']; ?>">Refresh</a><?php echo ', atau coba lagi ';
                                                                                                      echo '<br>Mailer Error: ' . $mail->ErrorInfo;
                                                                                                      exit;
                                                                                                    }

                                                                                                    //echo 'Message has been sent';
                                                                                                    //header('location:e-brochures');

                                                                                                      ?>
<!-- Modal -->
<!--<div class="modal fade" id="reset_password" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">-->
<!--  <div class="modal-dialog" role="document">-->
<!--    <div class="modal-content">-->
<!--      <div class="modal-header">-->
<!--        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
<!--        <h4 class="modal-title" id="myModalLabel">Information</h4>-->
<!--      </div>-->
<!--      <div class="modal-body">-->
<!--        Password anda sudah di reset, silahkan cek email-->
<!--      </div>-->
<!--      <div class="modal-footer">-->
<!--        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>-->
<!--<button type="button" class="btn btn-primary">Save changes</button>-->
<!--      </div>-->
<!--    </div>-->
<!--  </div>-->
<!--</div>-->
<?php
?>