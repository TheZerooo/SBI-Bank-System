<?php
session_start();
include "connection.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require "PHPMailer-master/src/Exception.php";
require "PHPMailer-master/src/PHPMailer.php";
require "PHPMailer-master/src/SMTP.php";

if (isset($_POST['send_otp'])) {
    $accountno = $_POST['accountno'];
    $email = $_POST['email'];

    // Check user
    $sql = "SELECT * FROM useraccount WHERE accountno='$accountno' AND email='$email'";
    $result = mysqli_query($db, $sql);

    if (mysqli_num_rows($result) > 0) {
        // Generate OTP
        $otp = rand(100000, 999999);
        $_SESSION['otp'] = $otp;
        $_SESSION['accountno'] = $accountno;
        $_SESSION['email'] = $email;

        // Send OTP mail
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'giritanu91@gmail.com';  // your Gmail
            $mail->Password = 'spxi vmpw izlo jkse';     // Gmail App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('giritanu91@gmail.com', 'Bank App');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = "Password Reset OTP";
            $mail->Body    = "Dear User, <br>Your OTP for password reset is: <b>$otp</b>";

            $mail->send();
            echo "✅ OTP sent to your email. <a href='reset.php'>Click here to reset</a>";
        } catch (Exception $e) {
            echo "❌ Mail Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "❌ Account No or Email not found!";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="POST" action="forgot.php">
    Enter Account No: <input type="text" name="accountno" required><br>
    Enter your Email: <input type="email" name="email" required><br>
    <button type="submit" name="send_otp">Send OTP</button>
</form>

</body>
</html>