<?php
include 'authentication.php';

$page_title = "Admin Dashboard";
if (!isset($_SESSION['authenticated_admin'])) {
    $_SESSION['status'] = "ERROR: You are not admin.";
    header('Location: dashboard.php');
    exit(0);
}

include('includes/header.php');
include 'vendor/phpqrcode/qrlib.php';
include 'defcon.php';
include('includes/navbar.php'); ?>
<div class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
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
                        <h4>Admin Dashboard</h4>
                    </div>

                    <div class="card-body">
                        <div class="col-md-6">
                            <video id="preview" width="80%"></video>
                        </div>
                        <label>Scan your attendance for <b></label>
                        <?php switch ($_SESSION['auth_user']['event_admin']) {
                                case '0':
                                    $event_scanned = 'Run the Horizon Marathon';
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
                            echo $event_scanned;
                             ?></b>
                        <form action="attendance.php" method="POST">
                            <input type="text" id="text" name="user" readonly="" placeholder="QR Code" class="form-control">
                            <input type="hidden" name="scanned_by" value="<?= $_SESSION['auth_user']['name'] ?>">
                            <input type="hidden" name="event" value="<?= $_SESSION['auth_user']['event_admin'] ?>">
                            <button type="submit" name="check_in_btn" class="btn btn-primary">Check in</button>
                        </form>
                        <script>
                            let scanner = new Instascan.Scanner({
                                video: document.getElementById('preview')
                            });
                            Instascan.Camera.getCameras().then(function(cameras) {
                                if (cameras.length = 1) {
                                    scanner.start(cameras[0]);
                                } else {
                                    alert('No camera devices are found.');
                                }
                            }).catch(function(e) {
                                console.error(e);
                            });
                            scanner.addListener('scan', function(c) {
                                document.getElementById('text').value = c;
                            })
                        </script>
                    </div>
                </div>
                <br />
                <div class="card">
                    <div class="card-header">
                        <h4>Admin Information</h4>
                    </div>
                    <div class="card-body">
                        <h4>Event Organizer Information::</h4>
                        <hr>
                        <h5>Full name: <?= $_SESSION['auth_user']['name']; ?></h5><br />
                        <h5>Organizer email: <?= $_SESSION['auth_user']['email']; ?></h5><br />
                        <h5>Organizer phone number: <?= $_SESSION['auth_user']['username']; ?></h5><br />
                        <h5>Barcode for attendance:</h5>
                        <?php
                        umask(000);

                        $tempDir = "temp/";
                        $fetched_id = $_SESSION['auth_user']['username'];
                        $data = base64_encode($fetched_id);
                        $fileName = 'qr_' . md5($data) . '.png';
                        $filePath = $tempDir . $fileName;
                        QRcode::png($data, $tempDir . $fileName, QR_ECLEVEL_L, 4);
                        echo "<img src='$filePath' alt='QR Code result' />"; ?>
                    </form>
                </div>
            </div>
            <br />
            <div class="card">
                <div class="card-header">
                    <h4>Attendance records</h4>
                </div>
                <div class="card-body">
                    <h4>Attended events</h4>
                    <?php
                    include 'defcon.php';

                    $username_of_user = $_SESSION['auth_user']['username'];
                    $check_user_query = "SELECT * FROM event_logs WHERE name='$username_of_user'";
                    $check_user_query_run = mysqli_query($con, $check_user_query);
                    $div_count = mysqli_num_rows($check_user_query_run);
                    if (mysqli_num_rows($check_user_query_run) > 0) {

                        while ($row = mysqli_fetch_array($check_user_query_run, MYSQLI_ASSOC)) {
                            $event_scanned = $row['event'];
                            $scanned_by = $row['scanned_by'];
                            $user = $row['name'];
                            $date_scanned = $row['log_date'];

                            switch ($row['event']) {
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

                            echo '<div class="alert alert-success">';
                            echo '<h2>' . $event_scanned . '</h2>' . '<h6>Scanned by: ' . $scanned_by . '</h6>' .  '<h6>' . $date_scanned . '</h6>';
                            echo '</div>';
                        }
                    } else {
                        echo '<div class="alert alert-danger"><h2>Error</h2><h3>No events found</h3></div>';
                    }


                    ?>
                    <hr>
                    <?php

                    ?>
                </div>
            </div>


        </div>
    </div>
</div>
</div>
<?php include('includes/footer.php') ?>