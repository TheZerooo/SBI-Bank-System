<?php
session_start();
include "connection.php";

if (isset($_POST['reset'])) {
    $otp = $_POST['otp'];
    $newpassword = $_POST['newpassword'];
    $accountno = $_SESSION['accountno'];
    $email = $_SESSION['email'];

    if ($otp == $_SESSION['otp']) {
        $hashedPassword = password_hash($newpassword, PASSWORD_DEFAULT);

        $sql = "UPDATE useraccount SET password='$hashedPassword' 
                WHERE accountno='$accountno' AND email='$email'";

        if (mysqli_query($db, $sql)) {
            echo "✅ Password reset successful!";
            session_destroy();
        } else {
            echo "❌ Error updating password.";
        }
    } else {
        echo "❌ Invalid OTP!";
    }
}
?>

<form method="POST">
    Enter OTP: <input type="text" name="otp" required><br>
    New Password: <input type="password" name="newpassword" required><br>
    <button type="submit" name="reset">Reset Password</button>
</form>

