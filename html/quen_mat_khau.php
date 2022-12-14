<?php
require('../html/modules/connection.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../html/modules/PHPMailer/src/Exception.php';
require '../html/modules/PHPMailer/src/PHPMailer.php';
require '../html/modules/PHPMailer/src/SMTP.php';

if (isset($_COOKIE["username"]) && isset($_COOKIE["password"])) {
    header("location:trangchu.php");
} else {
    if (isset($_POST['submit'])) {
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $email = '';
        $sql = "SELECT * FROM users WHERE username = '$username'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($conn->query($sql)) > 0) {
            $row = mysqli_fetch_assoc($result);
            $email = $row['email'];
            $new_code = rand(100000, 999999);
            $sql_update_code = "UPDATE users SET verify_code = '$new_code' WHERE username = '$username'";
            if ($conn->query($sql_update_code)) {
                $mail = new PHPMailer(true);
                try {
                    $mail->SMTPDebug = 0;                      //Enable verbose debug output
                    $mail->isSMTP();                                            //Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                    $mail->Username   = 'hirashihiro@gmail.com';                     //SMTP username
                    $mail->Password   = 'eecnlnutkfnqvrpj';                               //SMTP password
                    $mail->SMTPSecure = 'tsl';            //Enable implicit TLS encryption
                    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
                    $mail->charSet = "UTF-8";
                    //Recipients
                    $mail->setFrom(
                        'hirashihiro@gmail.com',
                        "Huy"
                    );
                    $mail->addAddress($email, $username);     //Add a recipient
                    $mail->addReplyTo('hirashihiro@gmail.com', "Huy");
                    $content = 'K??nh g???i, ' . $username . '<br>Y??u c???u l???y l???i m???t kh???u ???? ???????c b???n ho???c m???t ai ???? th???c hi???n. Vui l??ng nh???p code ????? th???c hi???n b?????c ti???p theo
                                <br>Code c???a b???n l??:
                                <div class="alert alert-danger" role="alert">
                                ' . $new_code . '    
                                </div>';
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = "Password retrieval request | NiceJob";
                    $mail->Body    = $content;
                    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                    $mail->send();
                    ob_start();
                    setcookie('username_temp', $username, time() + 999999);
                    header("location: verify_forget_pass.php?username=" . $username);
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            } else {
            }
            header("quen_mat_khau.php");
        } else {
            header("quen_mat_khau.php");
        }
    } else {
        header("quen_mat_khau.php");
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Qu??n m???t kh???u | NiceJob</title>
    <link rel="stylesheet" href="../css/bootstrap-5.1.3-dist/css/bootstrap.css" type="text/css">
    <link rel="stylesheet" href="../css/forget_password.css">
</head>

<body>
    <div class="row">
        <a href="../html/trangchu.php">
            <img src="../Images/logoedited-none-background.png" id="a2">
        </a>
    </div>
    <div class="container" id="container">
        <div class="form-container sign-in-container">
            <form action="quen_mat_khau.php" method="post">
                <h2>L???y l???i m???t kh???u</h2>
                <label for="username">T??n ????ng nh???p</label>
                <?php if (isset($username_typed)) { ?>
                    <input name="username" id=" username" type="text" required placeholder="Nh???p t??n ????ng nh???p c???a b???n" <?php echo 'value = "' . $username_typed . '"' ?>>
                <?php } else { ?>
                    <input name="username" id=" username" type="text" required placeholder="Nh???p t??n ????ng nh???p c???a b???n">
                <?php } ?>
                <p>Ho???c b???n mu???n ????ng nh???p? <a href="../html/login_signup_employee.php">????ng nh???p</a></p>
                <button type="submit" name="submit">L???y l???i m???t kh???u</button>
            </form>
        </div>
    </div>
</body>

</html>