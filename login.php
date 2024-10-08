<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: index.php");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$nik = $username = $password = "";
$nik_err = $username_err = $password_err = "";
 
// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Validate NIK or Username
    if (empty(trim($_POST["nik"])) && empty(trim($_POST["username"]))) {
        $nik_err = $username_err = "Please enter username or NIK.";
    } else {
        $nik = trim($_POST["nik"]);
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if (!empty($nik)) {
        $sql = "SELECT id, nik, username, password FROM users WHERE nik = ?";
        $param_value = $nik; // Set parameter for NIK
    } else {
        $sql = "SELECT id, nik, username, password FROM users WHERE username = ?";
        $param_value = $username; // Set parameter for username
    }

    // Prepare the statement
    if ($stmt = mysqli_prepare($con, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_value); // Only one parameter now
        
        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // Store result
            mysqli_stmt_store_result($stmt);
            
            // Check if username or NIK exists, then verify password
            if (mysqli_stmt_num_rows($stmt) == 1) {                    
                // Bind result variables
                mysqli_stmt_bind_result($stmt, $id, $username, $nik, $hashed_password);
                if (mysqli_stmt_fetch($stmt)) {
                    if (password_verify($password, $hashed_password)) {
                        // Password is correct, so start a new session
                        session_start();
                        
                        // Store data in session variables
                        $_SESSION["loggedin"] = true;
                        $_SESSION["id"] = $id;
                        $_SESSION["username"] = $username;
                        $_SESSION["nik"] = $nik; // Tambahkan ini untuk menyimpan NIK                            

                        // Redirect user to welcome page
                        header("location: index.php");
                        exit();
                    } else {
                        // Display an error message if password is not valid
                        $password_err = "The password you entered was not valid.";
                    }
                }
            } else {
                // Display an error message if username/NIK doesn't exist
                $username_err = "No account found with that username or NIK.";
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
        

        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($con);
}
?>


<!--Writing HTML Code here from bootstrap templates-->

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" href="images/favicon.png"/>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Admin Login | Data Siswa</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#" style="font-size:30px;"><strong>Data Siswa SMANDA</strong></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <!-- <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Dropdown
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#">Disabled</a>
                </li> -->
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <a href="register.php" class="btn btn-success my-2 my-sm-0" type="submit">Buat Akun Guru</a>
            </form>
        </div>
    </nav>

    <div class="container my-4">

        <div class="card mx-auto" style="width: 20rem;"><br>
            <img class="card-img-top mx-auto" src="asset/pngegg (1).png" style="width: 60%;" alt="Card image cap">
            <div class="card-body">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                        <label>Nama</label>
                        <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                        <span class="help-block"><?php echo $username_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($nik_err)) ? 'has-error' : ''; ?>">
                        <label>NIK</label>
                        <input type="text" name="nik" class="form-control" value="<?php echo $nik; ?>">
                        <span class="help-block"><?php echo $nik_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control">
                        <span class="help-block"><?php echo $password_err; ?></span>
                    </div>

                    <button type="submit" class="btn btn-warning">
                        <i class="fa fa-lock">&nbsp;</i> Login
                    </button> &nbsp; &nbsp;
                    <button type="reset" class="btn btn-danger">
                        <i class="fa fa-repeat">&nbsp;</i> Reset
                    </button>
                </form>
            </div>
            <div class="card-footer">
                <!-- Link Reset Password yang mengarah ke halaman reset_password_nik.php -->
                <a href="reset_password_nik.php">Lupa Password</a>
            </div>
        </div>
    </div>



    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
