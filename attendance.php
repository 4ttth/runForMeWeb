<?php
include('dbcon.php');

require 'vendor/autoload.php';

if(isset($_POST['check_in_btn'])){
    $user_encoded = $_POST['user'];
    $scanned_by = $_POST['scanned_by'];
    $event = $_POST['event'];
    $ip_address = $_SERVER['REMOTE_ADDR'];
    $dateTime = new DateTime();
    $dateTime->setTimezone(new DateTimeZone('Asia/Singapore'));
    $currentDateTime = $dateTime->format('Y-m-d H:i:s');
    // user decode
    $user_decoded = base64_decode($user_encoded);
    $check_user_query = "SELECT phone FROM users WHERE phone='$user_decoded' LIMIT 1";
    $check_user_query_run = mysqli_query($con, $check_user_query);
    if(mysqli_num_rows($check_user_query_run) > 0){
        $query = "INSERT INTO event_logs (name,scanned_by,event,log_date) VALUES ('$user_decoded','$scanned_by','$event','$currentDateTime')";
        $query_run = mysqli_query($con, $query);
        switch ($event) {
            case '0':
                $event_scanned = 'Run the Horizon Marathon';
                break;
            case '1':
                $event_scanned = 'Run the Horizon Marathon';
                break;
            case '2':
                $event_scanned = 'The Great City Challenge';
                break;
            case '3':
                $event_scanned = 'Nature’s Path Marathon';
                break;
            case '4':
                $event_scanned = 'Midnight Sun Marathon';
                break;
            case '5':
                $event_scanned = 'Coastal Breeze Run';
                break;
            case '6':
                $event_scanned = 'Desert Dash Marathon';
                break;
            case '7':
                $event_scanned = 'Mountain Peak Challenge';
                break;
            case '8':
                $event_scanned = 'Urban Trailblazer Marathon';
                break;
            case '9':
                $event_scanned = 'Harvest Run Extravaganza';
                break;
            case '10':
                $event_scanned = 'Riverside Relays Marathon';
                break;
            case '11':
                $event_scanned = 'Starlight Stride Marathon';
                break;
            case '12':
                $event_scanned = 'Windy City Run';
                break;
            case '13':
                $event_scanned = 'Serenity Sands Marathon';
                break;
            case '14':
                $event_scanned = 'Adrenaline Rush Run';
                break;
            case '15':
                $event_scanned = 'Legacy of Legends Marathon';
                break;
            case '16':
                $event_scanned = 'Trail of Triumph Marathon';
                break;
            case '17':
                $event_scanned = 'Freedom Run Fest';
                break;
            case '18':
                $event_scanned = 'Adventure Awaits Marathon';
                break;
            case '19':
                $event_scanned = 'The Epic Journey Run';
                break;
            case '20':
                $event_scanned = 'Heart of the Forest Marathon';
                break;
            case '21':
                $event_scanned = 'Unity Through Miles Marathon';
                break;
        }
        if($query_run){
            $_SESSION['status'] = "✅ $user_decoded logged in successfully for $event_scanned";
            header("Location: admin.php");
        }
        else{
            $_SESSION['status'] = "⚠️ ERROR: Attendance log failed, please try again.";
            header("Location: admin.php");

        }
      
    }else{
        $_SESSION['status'] = "⚠️ ERROR: User does not exists.";
            header("Location: admin.php");
    }
}

?>