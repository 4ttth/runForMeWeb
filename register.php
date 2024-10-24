<?php
session_start();
if (isset($_SESSION['authenticated_regular']) && isset($_SESSION['authenticated_admin'])) {
    $_SESSION['status'] = "ERROR: You are already logged in as admin.";
    header('Location: admin.php');
    exit(0);
} else if (isset($_SESSION['authenticated_regular'])) {
    $_SESSION['status'] = "ERROR: You are already logged in.";
    header('Location: dashboard.php');
    exit(0);
}

$page_title = "Registration Form";
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
                        <h5>Registration Form</h5>
                    </div>
                    <div class="card-body">
                        <form action="code.php" method="POST">
                            <div class="form-group mb-3">
                                <label for="">Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Juan Dela Cruz">
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Phone Number</label>
                                <input type="number" name="studeno" class="form-control" placeholder="639123456789">
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Email Address</label>
                                <input type="email" name="email" class="form-control" id="email" placeholder="example@email.com">
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Password</label>
                                <input type="password" name="password" class="form-control" id="initialPassword">
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Confirm Password</label>
                                <input type="password" name="confirm_password" class="form-control" id="confirmPassword">
                                <p id="incorrectPassword"></p>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" name="register_btn" id="register_btn">Register Now</button>
                            </div>
                            <script>
                                function myFunction() {
                                    var x = document.getElementById("initialPassword");
                                    if (x.type === "password") {
                                        x.type = "text";
                                    } else {
                                        x.type = "password";
                                    }
                                }

                                document.getElementById('confirmPassword').addEventListener('input', function() {
                                    var password = document.getElementById('initialPassword').value;
                                    var confirmPassword = this.value;
                                    var message = document.getElementById('incorrectPassword');
                                    const button = document.getElementById('register_btn');
                                    var password_length = (document.getElementById('initialPassword').value).length;
                                    if (password === confirmPassword && password_length > 8) {

                                        message.className = 'match';
                                        button.disabled = false;
                                    } else {
                                        if (password_length < 7) {
                                            message.textContent = 'Password must have 8 or more characters.';
                                            message.className = 'mismatch';
                                            button.disabled = true;
                                        } else {
                                            message.textContent = 'Passwords do not match.';
                                            message.className = 'mismatch'
                                            button.disabled = true;
                                        };
                                    }
                                });

    
                            </script>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<br/>
<br/>
<br/>
<?php include('includes/footer.php') ?>