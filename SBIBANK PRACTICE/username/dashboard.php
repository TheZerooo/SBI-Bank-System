<?php
session_start();
include "connection.php";

if (!isset($_SESSION['accountno'])) {
    die("Session not set. Please login again.");
}

if (isset($_SESSION['username'])) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Bank Dashboard</title>
<style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: #f4f6f9;
    }
    .navbar {
        background: #cc5323dc;
        color: white;
        padding: 15px 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .navbar h1 {
        margin: 0;
        font-size: 22px;
    }
    .nav-links {
        display: flex;
        gap: 15px;
        align-items: center;
    }
    .nav-links a {
        color: white;
        text-decoration: none;
        padding: 8px 14px;
        border-radius: 6px;
        transition: background 0.3s;
    }
    .nav-links a:hover {
        background: #28a745;
    }
    .logout-btn {
        background: transparent;
        border: 1px solid white;
        padding: 8px 14px;
        border-radius: 6px;
        color: white;
        cursor: pointer;
        transition: 0.3s;
        margin-left: 10px;
    }
    .logout-btn:hover {
        background: red;
        border-color: red;
    }
    .user-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .user-info img {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid white;
    }
    .main-content {
        padding: 30px;
    }
    .cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }
    .card {
        background: #fff;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 6px 15px rgba(0,0,0,0.1);
        text-align: center;
        transition: transform 0.2s;
    }
    .card:hover {
        transform: translateY(-5px);
    }
    .card h2 {
        margin: 0;
        font-size: 22px;
        color: #cc5323dc;
    }
    .card p {
        margin: 10px 0 0;
        font-size: 18px;
        color: #333;
    }
    .date {
        font-size: 14px;
        color: gray;
    }
</style>
</head>
<body>

 <!-- Navbar -->
<div class="navbar">
    <h1>Bank Dashboard</h1>
    <div class="nav-links">
        <a href="dashboard.php">Dashboard</a>
        <a href="withdraw.php">Withdraw</a>
        <a href="deposit.php">Deposit</a>
        <a href="transfer.php">Transfer Fund</a>
        <a href="mini_statement.php">Mini Statement</a>

        <!-- User Info -->
        <div class="user-info">
            <?php
            // Agar user ki profile pic available hai to wo, warna default.png
            $profilePic = (!empty($_SESSION['Profile']) && file_exists("uploads/" . $_SESSION['Profile'])) 
                          ? $_SESSION['Profile'] 
                          : "default.png";
            ?>
            <img src="uploads/<?php echo htmlspecialchars($profilePic); ?>" 
                 alt="User" style="width:40px; height:40px; border-radius:50%;">
            
            <span><?php echo htmlspecialchars($_SESSION['username']); ?></span>
            
            <form method="post" action="logout.php" style="display:inline;">
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>
    </div>
</div>


    <marquee behavior="scroll" direction="left" scrollamount="5" style="color:teal; font-size:18px; border-radius:5px;">
        👋 Hello <strong><?php echo ucfirst($_SESSION['username'])?> </strong> your account number is <strong><?php echo ($_SESSION['accountno']) ?></strong>| Last login: <?php echo date("d-M-Y h:i A"); ?>
    </marquee>

    <?php
    $accountno = $_SESSION['accountno'];

    // 🔹 1. Current Balance
    $sqlBalance = "SELECT avalbalance FROM ledger 
                   WHERE accountno='$accountno' 
                   ORDER BY ttime DESC LIMIT 1";
    $resBalance = mysqli_query($db, $sqlBalance);
    $rowBalance = mysqli_fetch_assoc($resBalance);
    $currentBalance = $rowBalance['avalbalance'] ?? 0;

    // 🔹 2. Last Credit
    $sqlCredit = "SELECT tamount, ttime FROM ledger 
                  WHERE accountno='$accountno' AND ttype='Credit' 
                  ORDER BY ttime DESC LIMIT 1";
    $resCredit = mysqli_query($db, $sqlCredit);
    $rowCredit = mysqli_fetch_assoc($resCredit);
    $lastCredit = $rowCredit['tamount'] ?? 'No Credit Yet';
    $lastCreditDate = $rowCredit['ttime'] ?? '-';

    // 🔹 3. Last Debit
    $sqlDebit = "SELECT tamount, ttime FROM ledger 
                 WHERE accountno='$accountno' AND ttype='Debit' 
                 ORDER BY ttime DESC LIMIT 1";
    $resDebit = mysqli_query($db, $sqlDebit);
    $rowDebit = mysqli_fetch_assoc($resDebit);
    $lastDebit = $rowDebit['tamount'] ?? 'No Debit Yet';
    $lastDebitDate = $rowDebit['ttime'] ?? '-';
    ?>

    <!-- Main Content -->
    <div class="main-content">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?> </h2>
        <div class="cards">
            <!-- Current Balance -->
            <div class="card">
                <h2>Current Balance</h2>
                <p><?php echo "₹ " . number_format($currentBalance, 2); ?></p>
            </div>

            <!-- Last Credit -->
            <div class="card">
                <h2>Last Credit</h2>
                <p><?php echo is_numeric($lastCredit) ? "₹ " . number_format($lastCredit, 2) : $lastCredit; ?></p>
                <p class="date">Date: <?php echo $lastCreditDate; ?></p>
            </div>

            <!-- Last Debit -->
            <div class="card">
                <h2>Last Debit</h2>
                <p><?php echo is_numeric($lastDebit) ? "₹ " . number_format($lastDebit, 2) : $lastDebit; ?></p>
                <p class="date">Date: <?php echo $lastDebitDate; ?></p>
            </div>
        </div>
    </div>
</body>
</html>
<?php
} else {
    header("Location: login.php");
    exit();
}
?>
