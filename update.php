<?php 
include('dbcon.php');

if(isset($_POST['update_btn'])){
    $section = $_POST['section'];
    $year_level = $_POST['year_level'];
    $student_number = $_POST['phone'];

    $change_section_query = "UPDATE users SET section='$section', year_level='$year_level' WHERE phone='$student_number' LIMIT 1";
    $change_section_run = mysqli_query($con, $change_section_query);
    if ($change_section_run) {
        $_SESSION['status'] = "Infomation updated successfully. Please login again";
        header('Location: logout.php');
        exit(0);
    } else {
        $_SESSION['status'] = "Could not update your information. Please email socdays@haucscsoc.com.";
        header('Location: logout.php');
        exit(0);
    }
}

?>