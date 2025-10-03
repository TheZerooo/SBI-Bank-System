<?php
include "connection.php";
session_start();

// Ensure user is logged in
if (!isset($_SESSION['accountno'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['deposit'])) {
    $account = $_SESSION['accountno'];   // ✅ Correct session key
    $amount = (float) $_POST['amount'];

    // 1. Check current balance from ledger (latest balance)
    $sql = "SELECT avalbalance FROM ledger 
            WHERE accountno='$account' 
            ORDER BY ttime DESC LIMIT 1";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_assoc($result);
    $currentBalance = $row['avalbalance'] ?? 0;


   
        $newBalance = $currentBalance + $amount;

        // 3. Insert new transaction in ledger

         $tstatement="Credited ".$amount;
        $tid=rand(10000,99999);
        $query = "INSERT INTO ledger (accountno, ttype, tamount, avalbalance, ttime,tstatement,tid) 
                  VALUES ('$account','Credit','$amount','$newBalance', NOW(),'$tstatement','$tid')";
        mysqli_query($db, $query);
       
        $query1="update useraccount set balance='$newBalance' where accountno='$account'";
        mysqli_query($db,$query1);

        

        $message = "😊Deposit successful! New Balance: ₹" . number_format($newBalance, 2);
    } 
?>

<!DOCTYPE html>
<html>
<head>
    <title>Deposit Money</title>
    <style>
        body { font-family: Arial, sans-serif; background:#f4f6f9; padding:40px; }
        .container { background:#fff; padding:25px; border-radius:12px; width:400px; margin:auto;
                     box-shadow:0 6px 15px rgba(0,0,0,0.1); }
        h2 { color:#cc5323dc; }
        input, button { width:100%; padding:10px; margin:10px 0; border-radius:6px; border:1px solid #ccc; }
        button { background:#cc5323dc; color:white; border:none; cursor:pointer; }
        button:hover { background:#28a745; }
        .msg { margin-top:10px; font-weight:bold; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Deposit Money</h2>
        <form method="POST">
            <input type="number" name="amount" placeholder="Enter amount to withdraw" required>
            <button type="submit" name="deposit">DEPOSIT</button>
        </form>
        <?php if (!empty($message)) { echo "<div class='msg'>$message</div>"; } ?>
    </div>
</body>
</html>