<?php
session_start();
$page_title = 'Password Reset - RunForMe';
include 'includes/header.php';
include 'includes/navbar.php';
?>

<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <?php
                if (isset($_SESSION['status'])) {
                ?>
                    <div class="alert alert-successs">
                        <h5><?= $_SESSION['status']; ?></h5>
                    </div>
                <?php
                    unset($_SESSION['status']);
                }
                ?>
                <div class="card">
                    <div class="card-header">
                        <h5>Reset Password</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="pwreset.php" method="POST">
                            <input type="hidden" name="token" value="<?php if (isset($_GET['token'])) {
                                                            echo $_GET['token'];
                                                        } ?>">
                            <div class="form-group mb-3">
                                <label>Email Address</label>
                                <input type="email" name="email" class="form-control" value="<?php if (isset($_GET['email'])) {
                                                                                                    echo $_GET['email'];
                                                                                                } ?>" placeholder="example@email.com" required>
                            </div>
                    </div>
                    <div class="form-group mb-3">
                        <label>New Password</label>
                        <input type="password" name="new_password" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Repeat New Password</label>
                        <input type="password" name="confirm_password" class="form-control" required>

                    </div>
                    <div class="form-group mb-3">
                        <button type="submit" name="password_update" class="btn btn-success w-100">Reset password</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include 'includes/footer.php';
?>