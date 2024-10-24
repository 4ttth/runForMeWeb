<?php
include('dbcon.php');

if(isset($_POST["login_now_btn"])){
    if(!empty(trim($_POST['email'])) && !empty(trim($_POST['password'])))
    {
        $email = mysqli_real_escape_string($con,$_POST['email']);
        $password = mysqli_real_escape_string($con,$_POST['password']);

        $login_query = "SELECT * FROM users WHERE email='$email' AND password='$password' ";
        $login_query_run = mysqli_query($con,$login_query);

        if(mysqli_num_rows($login_query_run) > 0){
            $row = mysqli_fetch_array($login_query_run);
            if($row['verify_status'] == "1" && $row['is_admin'] == "0"){
                $_SESSION['authenticated_regular'] = TRUE;
                $_SESSION['authenticated_admin'] = FALSE;
                unset($_SESSION['authenticated_admin']);
                $_SESSION['auth_user'] = [
                    'id' => $row['id'],
                    'username' => $row['phone'],
                    'email' => $row['email'],
                    'name' => $row['name'],  
                    'is_admin' => $row['is_admin'],
                    'event' => $row['event_admin']
                ];
                $ip_address = $_SERVER['REMOTE_ADDR'];

                $_SESSION['status'] = "✅ You are logged in successfully.";
                header('Location: dashboard.php');
            }
            else if($row['verify_status'] == "1" && $row['is_admin'] == "1"){
                $_SESSION['authenticated_regular'] = TRUE;
                $_SESSION['authenticated_admin'] = TRUE;
                $_SESSION['auth_user'] = [
                    'id' => $row['id'],
                    'username' => $row['phone'],
                    'email' => $row['email'],
                    'name' => $row['name'],  
                    'is_admin' => $row['is_admin'],
                    'event_admin' => $row['event_admin']
                ];
                $_SESSION['status'] = "✅ ADMIN: You are logged in successfully.";
                header('Location: admin.php');
            }
            else{
                $_SESSION['status'] = "⚠️ ERROR: Email address not verified.";
                header('Location: login.php');
                exit(0);
            }
        }
        else{
            $_SESSION['status'] = "⚠️ ERROR: Invalid email or password.";
            header('Location: login.php');
            exit(0);
        }
    }
    else{
        $_SESSION['status'] = "⚠️ ERROR: All fields are mandatory";
        header('Location: login.php');
        exit(0);
    }
    $email = $_POST['email'];
    $password = $_POST['password'];
}

?>