<?php
include "connection.php";
session_start();

// Ensure user is logged in
if (!isset($_SESSION['accountno'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['transfer'])) {
    $sender   = $_SESSION['accountno'];    // Sender (logged-in user)
    $receiver = trim($_POST['receiver']);  // Receiver account no
    $amount   = (float) $_POST['amount'];  // Transfer amount

    // 1. Basic validation
    if ($amount <= 0) {
        $message = "Please enter a valid amount greater than 0!";
    } elseif ($sender == $receiver) {
        $message = "You cannot transfer to your own account!";
    } else {
        // 2. Check if receiver exists
        $checkReceiver = mysqli_query($db, "SELECT * FROM useraccount WHERE accountno='$receiver'");
        if (mysqli_num_rows($checkReceiver) == 0) {
            $message = "Receiver account not found!";
        } else {
            // 3. Get sender's latest balance from ledger
            $sql = "SELECT avalbalance FROM ledger 
                    WHERE accountno='$sender' 
                    ORDER BY ttime DESC LIMIT 1";
            $result = mysqli_query($db, $sql);
            $row = mysqli_fetch_assoc($result);
            $currentBalance = $row['avalbalance'] ?? 0;

            // 4. Check sufficient balance
            if ($currentBalance >= $amount) {
                $newBalanceSender = $currentBalance - $amount;

                // Receiver ka current balance nikaalo
                $sql2 = "SELECT avalbalance FROM ledger 
                         WHERE accountno='$receiver' 
                         ORDER BY ttime DESC LIMIT 1";
                $result2 = mysqli_query($db, $sql2);
                $row2 = mysqli_fetch_assoc($result2);
                $receiverBalance = $row2['avalbalance'] ?? 0;
                $newBalanceReceiver = $receiverBalance + $amount;

                // Transaction IDs
                $tidSender   = rand(10000,99999);
                $tidReceiver = rand(10000,99999);

                // 5. Insert debit entry for sender
                $tstatementSender = "Transferred ₹".$amount." to A/C ".$receiver;
                $query1 = "INSERT INTO ledger (accountno, ttype, tamount, avalbalance, ttime, tstatement, tid) 
                           VALUES ('$sender','Debit','$amount','$newBalanceSender', NOW(),'$tstatementSender','$tidSender')";
                mysqli_query($db, $query1);

                // 6. Insert credit entry for receiver
                $tstatementReceiver = "Received ₹".$amount." from A/C ".$sender;
                $query2 = "INSERT INTO ledger (accountno, ttype, tamount, avalbalance, ttime, tstatement, tid) 
                           VALUES ('$receiver','Credit','$amount','$newBalanceReceiver', NOW(),'$tstatementReceiver','$tidReceiver')";
                mysqli_query($db, $query2);

                // 7. Update balances in useraccount table
               $query3= mysqli_query($db, "UPDATE useraccount SET balance='$newBalanceSender' WHERE accountno='$sender'");
                $query4=mysqli_query($db, "UPDATE useraccount SET balance='$newBalanceReceiver' WHERE accountno='$receiver'");


                $message = "🙂 Fund Transfer Successful! <br> New Balance: ₹" . number_format($newBalanceSender, 2);
            } else {
                $message = "😶 Insufficient balance!";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Transfer Fund</title>
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
        <h2>💸 Transfer Fund</h2>
        <form method="POST">
            <input type="text" name="receiver" placeholder="Enter Receiver Account Number" required>
            <input type="number" name="amount" placeholder="Enter amount to transfer" required>
            <button type="submit" name="transfer">Transfer</button>
        </form>
        <?php if (!empty($message)) { echo "<div class='msg'>$message</div>"; } ?>
    </div>
</body>
</html>
