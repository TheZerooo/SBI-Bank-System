<?php
session_start(); // Always at the top before any HTML
include "connection.php";

if(isset($_POST['sbt'])){
    $account = $_POST['accountNumber'];
    $_SESSION['accountNumber'] = $account;
    header("Location: transaction.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Admin Panel</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background: #f4f6f9;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        margin: 0;
    }

    .card {
        background: #fff;
        padding: 40px 30px;
        border-radius: 12px;
        box-shadow: 0 8px 18px rgba(0,0,0,0.1);
        width: 350px;
        text-align: center;
    }

    .card h2 {
        margin-bottom: 20px;
        color: #333;
    }

    input[type="number"] {
        width: 85%;
        padding: 12px;
        margin: 12px 0;
        border: 1px solid #ccc;
        border-radius: 6px;
        outline: none;
        font-size: 15px;
        transition: border-color 0.3s;
    }

    input[type="number"]:focus {
        border-color: #007BFF;
    }

    input[type="submit"] {
        background: #007BFF;
        color: white;
        padding: 12px 25px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 16px;
        margin-top: 10px;
        transition: background 0.3s;
    }

    input[type="submit"]:hover {
        background: #0056b3;
    }
</style>
</head>
<body>
    <div class="card">
        <h2>Enter Account Number</h2>
        <form action="" method="POST">
            <input type="number" name="accountNumber" placeholder="Enter Account Number" required>
            <br>
            <input type="submit" name="sbt" value="Submit">
        </form>
    </div>
</body>
</html>
