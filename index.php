<?php
session_start();
include 'config/db.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $level = $_POST['level'];

    // Validate and sanitize user inputs
    $username = mysqli_real_escape_string($con, $username);
    $password = mysqli_real_escape_string($con, $password);

    // Hash the password
    $hashed_password = sha1($password); 

    // Prepare and execute SQL query based on user's level
    switch ($level) {
        case 1: // Guru
            $sql = "SELECT * FROM tb_guru WHERE nip='$username' AND password='$hashed_password' AND status='Y'";
            $redirect_url = './guru/';
            break;
        case 2: // Siswa
            $sql = "SELECT * FROM tb_siswa WHERE nis='$username' AND password='$hashed_password' AND status='1'";
            $redirect_url = './siswa/';
            break;
        default:
            echo "Invalid user level.";
            exit;
    }

    $result = mysqli_query($con, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $user_data = mysqli_fetch_assoc($result);

        // Set appropriate session variable based on user's level
        switch ($level) {
            case 1:
                $_SESSION['guru'] = $user_data['id_guru'];
                $user_name = $user_data['nama_guru'];
                break;
            case 2:
                $_SESSION['siswa'] = $user_data['id_siswa'];
                $user_name = $user_data['nama_siswa'];
                break;
        }

        // Redirect user after successful login
        echo "
            <script>
                setTimeout(function() {
                    swal('$user_name', 'Login berhasil', {
                        icon: 'success',
                        buttons: {
                            confirm: {
                                className: 'btn btn-success'
                            }
                        }
                    });
                }, 10);
                setTimeout(function() {
                    window.location.replace('$redirect_url');
                }, 3000);
            </script>";
    } else {
        echo "
            <script>
                setTimeout(function() {
                    swal('Sorry!', 'Username / Password Salah', {
                        icon: 'error',
                        buttons: {
                            confirm: {
                                className: 'btn btn-danger'
                            }
                        }
                    });
                }, 10);
                setTimeout(function() {
                    window.location.replace('./');
                }, 3000);
            </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login | Absensi</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->	
    <link rel="icon" type="image/png" href="./assets/img/sd.png">
    <!--===============================================================================================-->	
    <link rel="stylesheet" type="text/css" href="assets/_login/vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->	
    <link rel="stylesheet" type="text/css" href="assets/_login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->	
    <link rel="stylesheet" type="text/css" href="assets/_login/fonts/iconic/css/material-design-iconic-font.min.css">
    <!--===============================================================================================-->	
    <link rel="stylesheet" type="text/css" href="assets/_login/vendor/animate/animate.css">
    <!--===============================================================================================-->	
    <link rel="stylesheet" type="text/css" href="assets/_login/vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->	
    <link rel="stylesheet" type="text/css" href="assets/_login/vendor/animsition/css/animsition.min.css">
    <!--===============================================================================================-->	
    <link rel="stylesheet" type="text/css" href="assets/_login/vendor/select2/select2.min.css">
    <!--===============================================================================================-->	
    <link rel="stylesheet" type="text/css" href="assets/_login/vendor/daterangepicker/daterangepicker.css">
    <!--===============================================================================================-->	
    <link rel="stylesheet" type="text/css" href="assets/_login/css/util.css">
    <link rel="stylesheet" type="text/css" href="assets/_login/css/main.css">
    <!--===============================================================================================-->	
</head>

<body>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <form method="post" action="" class="login100-form validate-form">
                    <span class="login100-form-title p-b-48">
                        <img src="./assets/img/sd.png" width="200">
                    </span>
                    <span class="login100-form-title p-b-26">
                        Absensi SD Negeri Ciater 03
                    </span>

                    <div class="wrap-input100 validate-input">
                        <input class="input100" type="text" name="username" required>
                        <span class="focus-input100" data-placeholder="Username"></span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="password">
                        <span class="btn-show-pass">
                            <i class="zmdi zmdi-eye"></i>
                        </span>
                        <input class="input100" type="password" name="password" required>
                        <span class="focus-input100" data-placeholder="Password"></span>
                    </div>

                    <div class="form-group mb-3">
                        <select class="form-control" name="level" required>
                            <option value="1">Guru</option>
                            <option value="2">Siswa</option>
                        </select>
                    </div>

                    <div class="container-login100-form-btn">
                        <div class="wrap-login100-form-btn">
                            <div class="login100-form-bgbtn"></div>
                            <button type="submit" class="login100-form-btn">Login</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript Dependencies -->
    <script src="assets/_login/vendor/jquery/jquery-3.2.1.min.js"></script>
    <script src="assets/_login/vendor/animsition/js/animsition.min.js"></script>
    <script src="assets/_login/vendor/bootstrap/js/popper.js"></script>
    <script src="assets/_login/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/_login/vendor/select2/select2.min.js"></script>
    <script src="assets/_login/vendor/daterangepicker/moment.min.js"></script>
    <script src="assets/_login/vendor/daterangepicker/daterangepicker.js"></script>
    <script src="assets/_login/vendor/countdowntime/countdowntime.js"></script>

    <!-- SweetAlert -->
    <script src="assets/js/plugin/sweetalert/sweetalert.min.js"></script>

    <!-- Custom JavaScript -->
    <script src="assets/_login/js/main.js"></script>
</body>

</html>
