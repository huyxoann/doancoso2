<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../html/modules/PHPMailer/src/Exception.php';
require '../html/modules/PHPMailer/src/PHPMailer.php';
require '../html/modules/PHPMailer/src/SMTP.php';
//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $code = $_POST['verify_code'];
    try {
        //Server settings
        $mail->SMTPDebug = 0;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'hirashihiro@gmail.com';                     //SMTP username
        $mail->Password   = 'gduaovijcmpjpaem';                               //SMTP password
        $mail->SMTPSecure = 'tsl';            //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        $mail->charSet = "UTF-8";
        //Recipients
        $mail->setFrom('hirashihiro@gmail.com', "Huy");
        $mail->addAddress($_POST['email'], 'User');     //Add a recipient
        // $mail->addAddress('ellen@example.com');               //Name is optional
        $mail->addReplyTo('hirashihiro@gmail.com', "Huy");
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');

        //Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $content = 'K??nh g???i, ' . $username . '<br>T??i kho???n email c???a b???n ???? ???????c ????ng k?? t???i NiceJob, ????y l?? m???t m?? x??c nh???n c???a b???n. Vui l??ng nh???p ????? ho??n t???t vi???c ????ng k??.
        <br>Code c???a b???n l??:
        <div class="alert alert-danger" role="alert">
        ' . $code . '    
        </div>';
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = "M?? OTP x??c nh???n t??i kho???n | NiceJob";
        $mail->Body    = $content;
        // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        ob_start();
        header("location:", 'request_active.php');
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
