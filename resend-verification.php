<?php
session_start();
$page_title = "Resend Verification Email";
include('includes/header.php');
include('includes/navbar.php');
?>

<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-y">
            <div class="alert alert-secondary">
                    <?php
                    if (isset($_SESSION['status'])) {
                        echo '<h4>' . $_SESSION['status'] . '</h4>';
                        unset($_SESSION['status']);
                    }
                    ?>
                    </div>
                <div class="card">
                    <div class="card-header">
                        <h5>Resend Email Verification</h5>
                    </div>
                    <div class="card-body">
                        <form action="resend-code.php" method="POST">
                            <div class="form-group mb-3">
                                <label>Email Address</label>
                                <input type="email" name="email" class="form-control" placeholder="example@email.com" required>
                            </div>
                            <div class="form-group mb-3">
                                <button type="submit" name="resend_email_verify_btn" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>