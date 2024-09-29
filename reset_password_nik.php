<?php
// Initialize the session
session_start();

// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$nik = $nik_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Validate NIK
    if (empty(trim($_POST["nik"]))) {
        $nik_err = "Please enter your NIK.";
    } else {
        $nik = trim($_POST["nik"]);
    }

    // If no errors, process form
    if (empty($nik_err)) {
        // Check if the NIK exists in the database
        $sql = "SELECT id FROM users WHERE nik = ?";
        
        if ($stmt = mysqli_prepare($con, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_nik);
            $param_nik = $nik;

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    // Jika NIK ditemukan, simpan NIK ke session dan arahkan ke halaman reset password
                    $_SESSION['nik'] = $nik;
                    header("location: reset_pass.php");
                    exit(); // Pastikan script berhenti setelah redirect
                } else {
                    $nik_err = "No account found with that NIK.";
                }
            } else {
                $nik_err = "Oops! Something went wrong. Please try again later.";
            }
            mysqli_stmt_close($stmt);
        } else {
            $nik_err = "Database query failed.";
        }
    }

    // Close connection
    mysqli_close($con);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style type="text/css">
        body { 
            font: 14px sans-serif; 
            display: flex;               
            justify-content: center;     
            align-items: center;         
            height: 100vh;              
            margin: 0;                  
            background-color: #f8f9fa;  
        }
        .wrapper { 
            width: 350px; 
            padding: 20px; 
            border: 1px solid #ddd;      
            border-radius: 5px;          
            background-color: #ffffff;    
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Reset Password</h2>
        <p>Masukkan Nomor Induk Kepegawaian (NIK).</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($nik_err)) ? 'has-error' : ''; ?>">
                <label>NIK</label>
                <input type="text" name="nik" class="form-control" value="<?php echo $nik; ?>">
                <span class="help-block"><?php echo $nik_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <button type="button" class="btn btn-danger" onclick="window.location.href='login.php'" style="margin-left: 165px;">
                    Batal
                </button>
            </div>
    </div>    
</body>
</html>
