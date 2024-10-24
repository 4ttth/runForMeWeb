<?php
include 'dbcon.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function send_password_reset($get_name, $get_email, $get_token)
{
    $mail = new PHPMailer(true);
    //Server settings
    // $mail->SMTPDebug = 2;                                    //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP

    $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'council@haucscsoc.com';                //SMTP username
    $mail->Password   = 'rbjvhqliutzerzkr';                     //SMTP password
    $mail->SMTPSecure =  "ssl";                                 //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('no-reply@haucscsoc.com', 'RunForMe no-reply');
    $mail->addAddress($get_email);
    $mail->isHTML(true);                                        //Set email format to HTML
    $mail->Subject = 'Reset Password Notification';
    $email_template = "
    <h1>Reset Password for RunForMe</h1>
    <br>
    <p>Reset your RunForMe Password using this link: 
    <a href='localhost/change-password.php?token=$get_token&email=$get_email'>Click here to reset</a></p>
    
    ";

    $mail->Body = $email_template;
    $mail->send();
}
if (isset($_POST['pwreset_link'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $token = md5(rand());

    $check_email = "SELECT email FROM users WHERE email='$email' LIMIT 1";
    $check_email_run = mysqli_query($con, $check_email);
    if (mysqli_num_rows($check_email_run) > 0) {
        $row = mysqli_fetch_array($check_email_run);
        $get_name = $row['name'];
        $get_email = $row['email'];

        $update_token = "UPDATE users SET verify_token='$token' WHERE email='$email'";
        $update_token_run = mysqli_query($con, $update_token);

        if ($update_token_run) {
            send_password_reset($get_name, $get_email, $token);
            $_SESSION['status'] = "We have emailed you a link to reset your password.";
            header('Location: login.php');
            exit(0);
        } else {
            $_SESSION['status'] = "Something went wrong.";
            header('Location: password-reset.php');
            exit(0);
        }
    } else {
        $_SESSION['status'] = "No email address found.";
        header('Location: password-reset.php');
        exit();
    }
}
if (isset($_POST['password_update'])) {
    $email = mysqli_escape_string($con, $_POST['email']);
    $new_password = mysqli_escape_string($con, $_POST['new_password']);
    $confirm_password = mysqli_escape_string($con, $_POST['confirm_password']);
    $token = mysqli_escape_string($con, $_POST['token']);

    if (!empty($token)) {
        if (!empty($token) && !empty($new_password) && !empty($confirm_password)) {
            $check_token = "SELECT verify_token FROM users WHERE verify_token='$token' LIMIT 1";
            $check_token_run = mysqli_query($con, $check_token);

            if (mysqli_num_rows($check_token_run) > 0) {
                if ($new_password == $confirm_password) {
                    $update_password = "UPDATE users SET password='$new_password' WHERE verify_token='$token' LIMIT 1";
                    $update_password_run = mysqli_query($con, $update_password);

                    if ($update_password_run) {
                        $new_token = md5(rand());
                        $update_new_token = "UPDATE users SET verify_token='$new_token' WHERE verify_token='$token' LIMIT 1";
                        $update_new_token_run = mysqli_query($con, $update_new_token);
                        $_SESSION['status'] = "Password successfully updated.";
                        header('Location: login.php');
                        exit(0);
                    } else {
                        $_SESSION['status'] = "Could not update password. Something went wrong.";
                        header('Location: password-reset.php');
                        exit(0);
                    }
                }
            } else {
                $_SESSION['status'] = "Invalid Token";
                header('Location: password-reset.php');
                exit(0);
            }
        } else {
            $_SESSION['status'] = "All fields are mandatory.";
            header('Location: change-password.php?token=' . $token . '&email=' . $email);
            exit(0);
        }
    } else {
        $_SESSION['status'] = "No token found.";
        header('Location: password-reset.php');
        exit(0);
    }
}
