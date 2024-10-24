<?php 
include('dbcon.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function resend_email_verify($name,$email,$verify_token){
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
    $mail->setFrom('no-reply@haucscsoc.com', 'RunForMe Verification');
    $mail->addAddress($email);  
    $mail->isHTML(true);                                        //Set email format to HTML
    $mail->Subject = 'Code Resent!';
    $email_template = "
    <h1>Welcome to Run For Me!</h1>
    <br>
    <p>Verify your registration by clicking this link: 
    <a href='https://localhost/verify-mail.php?token=$verify_token'>Click here to verify</a></p>
    
    ";

    $mail->Body = $email_template;
    $mail->send();
    // echo 'Code has been sent to your email address.';
}

if(isset($_POST['resend_email_verify_btn'])){
    if(!empty(trim($_POST['email']))){
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $checkemail_query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
        $check_email_query_run = mysqli_query($con,$checkemail_query);

        if(mysqli_num_rows($check_email_query_run) > 0){
            $row = mysqli_fetch_array($check_email_query_run);
            if($row['verify_status'] == "0"){
                $name = $row['name'];
                $email = $row['email'];
                $verify_token = $row['verify_token'];
                resend_email_verify($name,$email,$verify_token);

                $_SESSION['status'] = '✅ Email verification code resent.';
                header('Location: login.php');
                session_write_close(); 
            }
            else{
                $_SESSION['status'] = '⚠️ Email already verified, please login';
                header('Location: login.php');
                session_write_close(); 
            }
        }
        else{
            $_SESSION['status'] = '⚠️ Email is not registered. Please register';
            header("Location: register.php");
            session_write_close(); 
        }
    }
    else{
        $_SESSION['status'] = '⚠️ Please enter the email address you used to register.';
        header('Location: resend-verification.php');
        session_write_close(); 
    }
}

?>