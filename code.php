<?php
include('dbcon.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function sendemail_verify($name, $email, $verify_token) {
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
    $mail->setFrom('no-reply@haucscsoc.com', 'RunForMe Registration');
    $mail->addAddress($email);  
    $mail->isHTML(true);                                        //Set email format to HTML
    $mail->Subject = 'Verify your RunForMe Registration!';
    $email_template = "
    <h1>Verify your RunForMe Registration</h1>
    <br>
    <p>Verify your registration by clicking this link: 
    <a href='https://localhost/verify-mail.php?token=$verify_token'>Click here to verify</a></p>
    
    ";

    $mail->Body = $email_template;
    $mail->send();
    // echo 'Code has been sent to your email address.';
}

if(isset($_POST['register_btn']))
{
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['studeno'];
    $password = $_POST['password'];
    $verify_token = md5(rand());
    $is_admin = 0;
    
    // Email Exists or not
    $check_email_query = "SELECT email FROM users WHERE email='$email' LIMIT 1";
    $check_email_query_run = mysqli_query($con, $check_email_query);
    $check_id_query = "SELECT id FROM users WHERE ";


    if(mysqli_num_rows($check_email_query_run) > 0){
            $_SESSION['status'] = "⚠️ ERROR: Email address already exists.";
            header("Location: register.php");
    }
    else{
            // Insert User / Registered User Data
        $query = "INSERT INTO users (name,phone,email,password,verify_token,is_admin,event_admin) VALUES ('$name','$phone','$email','$password','$verify_token','$is_admin','0')";
        $query_run = mysqli_query($con, $query);
        
        if($query_run){
            sendemail_verify("$name","$email","$verify_token");
            $_SESSION['status'] = "✅ Registration successful. Please verify email address. <i>Make sure to check your <b>Junk</b> Folder!</i>";
            header("Location: register.php");
            session_write_close(); 
        }
        else{
            $_SESSION['status'] = "⚠️ ERROR: Registration failed, please try again.";
            session_write_close(); 
            header("Location: register.php");

        }
    }
}



?>