<?php
include "connection.php";
session_start();

// Ensure user is logged in
if (!isset($_SESSION['accountno'])) {
    header("Location: login.php");
    exit();
}

$account = $_SESSION['accountno'];
$transactions = [];

if (isset($_POST['filter'])) {
    $type = $_POST['type']; // Debit / Credit / All
    $from = $_POST['from'];
    $to   = $_POST['to'];

    // Base query
    $sql = "SELECT * FROM ledger WHERE accountno='$account'";

    // Date filter
    if (!empty($from) && !empty($to)) {
        $sql .= " AND DATE(ttime) BETWEEN '$from' AND '$to'";
    }

    // Type filter
    if ($type != "All") {
        $sql .= " AND ttype='$type'";
    }

    $sql .= " ORDER BY ttime DESC LIMIT 20"; // last 20 transactions
    $result = mysqli_query($db, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        $transactions[] = $row;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mini Statement</title>
    <style>
        body { font-family: Arial, sans-serif; background:#f4f6f9; padding:40px; }
        .container { background:#fff; padding:25px; border-radius:12px; width:700px; margin:auto;
                     box-shadow:0 6px 15px rgba(0,0,0,0.1);}
        h2 { color:#cc5323dc; }
        form { margin-bottom:20px; }
        input, select, button { padding:8px; margin:8px; border-radius:6px; border:1px solid #ccc; }
        button { background:#cc5323dc; color:white; border:none; cursor:pointer; }
        button:hover { background:#28a745; }
        table { width:100%; border-collapse: collapse; margin-top:15px; }
        table, th, td { border:1px solid #ddd; padding:10px; text-align:center; }
        th { background:#cc5323dc; color:white; }
    </style>
</head>
<body>
    <div class="container">
        <h2>📄 Mini Statement</h2>
        <form method="POST">
            <label>From: </label>
            <input type="date" name="from" required>
            <label>To: </label>
            <input type="date" name="to" required>

            <label>Type: </label>
            <select name="type">
                <option value="All">All</option>
                <option value="Debit">Debit</option>
                <option value="Credit">Credit</option>
            </select>

            <button type="submit" name="filter">Show</button>
        </form>

        <?php if (!empty($transactions)) { ?>
            <table>
                <tr>
                    <th>Date & Time</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Balance</th>
                    <th>Statement</th>
                    <th>Txn ID</th>
                </tr>
                <?php foreach ($transactions as $txn) { ?>
                    <tr>
                        <td><?php echo $txn['ttime']; ?></td>
                        <td><?php echo $txn['ttype']; ?></td>
                        <td><?php echo $txn['tamount']; ?></td>
                        <td><?php echo $txn['avalbalance']; ?></td>
                        <td><?php echo $txn['tstatement']; ?></td>
                        <td><?php echo $txn['tid']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        <?php } else if(isset($_POST['filter'])) {
            echo "<p>No transactions found for given filter.</p>";
        } ?>
    </div>
</body>
</html>
