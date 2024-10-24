<?php
session_start();

$page_title = 'Password Reset';
include'includes/header.php';
include'includes/navbar.php';
?>

<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">

            <?php 
                if(isset($_SESSION['status'])){
                    ?>
                    <div class="alert alert-success">
                    <h5><?= $_SESSION['status']; ?> </h5>
                    </div>
                    <?php
                    unset($_SESSION['status']);
                }
            ?>

            <div class="card">
                <div class="card-header">
                    <h5>Reset Password</h5>
                    <div class="card-body p-4"></div>

                    <form action="pwreset.php" method="POST">
                    <div class="form-group mb-3">
                        <label>Email Address</label>
                        <input type="email" name="email" class="form-control" placeholder="example@email.com" required>
                    </div>
                    <div class="form-group mb-3">
                        <button type="submit" name="pwreset_link" class="btn btn-primary">Request Password Reset</button>
                    </div>
                    </form>
                </div>
            </div>
            </div>

        </div>
    </div>
</div>

<?php
include'includes/footer.php';
?>