<?php
session_start();
if (isset($_SESSION['authenticated_regular']) && isset($_SESSION['authenticated_admin'])) {
    $_SESSION['status'] = "You are already logged in as admin.";
    header('Location: admin.php');
    exit(0);
} else if (isset($_SESSION['authenticated_regular'])) {
    $_SESSION['status'] = "You are already logged in.";
    header('Location: dashboard.php');
    exit(0);
}
$page_title = "Login Form";
include('includes/header.php');
include('includes/navbar.php'); ?>

<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="alert alert-secondary">
                    <?php
                    if (isset($_SESSION['status'])) {
                        echo '<h4>' . $_SESSION['status'] . '</h4>';
                        unset($_SESSION['status']);
                    }
                    ?>
                </div>
                <div class="card shadow">
                    <div class="card-header">
                        <h5>Login Form</h5>
                    </div>
                    <div class="card-body">
                        <form action="logincode.php" method="POST">
                            <div class="form-group mb-3">
                                <label for="">Email Address</label>
                                <input type="email" name="email" class="form-control" placeholder="example@email.com">
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Password</label>
                                <input type="password" name="password" class="form-control">
                            </div>
                            <div class="form-group">
                                <button type="submit" name="login_now_btn" class="btn btn-primary">Login</button>
                                <a href="password-reset.php" class="float-end">Forgot your password?</a>
                            </div>
                        </form>
                        <hr>
                        <h5>
                            Did not receive your verification email?
                            <a href="resend-verification.php">Resend</a>
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<br />
<br />
<br />
<br />
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<?php include('includes/footer.php') ?>