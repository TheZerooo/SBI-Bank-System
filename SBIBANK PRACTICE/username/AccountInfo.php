<?php
include "connection.php";
session_start();
include 'nav.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Admin Panel</title>
<style>
  body {
    margin: 0;
    font-family: Arial, sans-serif;
    display: flex; /* make body flex container */
  }

  .sidebar {
    height: 100vh;
    width: 250px;
    background-color: #2c3e50;
    color: white;
    display: flex;
    flex-direction: column;
    align-items: center;
    flex-shrink: 0; /* prevent shrinking */
  }

  /* Upper area for admin */
  .admin-area {
    width: 100%;
    padding: 30px 20px;
    text-align: center;
    border-bottom: 1px solid #34495e;
  }

  .admin-photo {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #3498db;
    margin-bottom: 15px;
  }

  .admin-name {
    font-size: 1.2rem;
    font-weight: bold;
  }

  /* Nav links */
  .nav-links {
    width: 100%;
    margin-top: 20px;
    padding-left: 0;
  }

  .nav-links a {
    display: block;
    padding: 15px 20px;
    color: white;
    text-decoration: none;
    font-size: 1rem;
    border-left: 4px solid transparent;
    transition: background-color 0.3s, border-left-color 0.3s;
  }

  .nav-links a:hover {
    background-color: #34495e;
    border-left-color: #3498db;
  }

  /* Main content area next to sidebar */
  .main-content {
    flex-grow: 1;
    padding: 20px;
    background: #f4f4f4;
    min-height: 100vh;
    overflow-x: auto;
  }

  /* Table styling */
  table {
    width: 100%;
    border-collapse: collapse;
    background: white;
  }

  th, td {
    padding: 12px 15px;
    border: 1px solid #ddd;
    text-align: left;
  }

  th {
    background-color: #3498db;
    color: white;
  }

  tr:nth-child(even) {
    background-color: #f9f9f9;
  }

  /* Action buttons styling */
  .action-btn {
    padding: 6px 12px;
    background-color: #3498db;
    color: white;
    border: none;
    cursor: pointer;
    border-radius: 3px;
  }

  .action-btn:hover {
    background-color: #2980b9;
  }

</style>
</head>
<body>

  

  <div class="main-content">
    <h2 style="text-align:center;">Account Information</h2>
    <table>
      <tr>
        <th>Account Holder</th>
        <th>Account Number</th>
        <th>Balance</th>
        <th>Registration Date</th>
        <th> IsActive or Not</th>
      </tr>

      <?php
    $sql = "SELECT * FROM useraccount where '$_SESSION[accountNumber]' = accountno";
    // $sql=" SELECT * from useraccount where  accountno='$_SESSION[accountNumber]'";
      $result = mysqli_query($db, $sql);

      if(mysqli_num_rows($result) > 0){
         $row = mysqli_fetch_assoc($result);
              echo "<tr>";
              echo "<td>" . htmlspecialchars(ucfirst($row['username'])) . "</td>";
              echo "<td>" . htmlspecialchars($row['accountno']) . "</td>";
              echo "<td>Rs " . number_format($row['balance']) . "</td>";
              echo "<td>". ($row['registerdate'])."</td>";
              echo "<td>". ($row['isactive'])."</td>";
              echo "</tr>";
          //}
      } else {
          echo "<tr><td colspan='4'>No inactive accounts found.</td></tr>";
      }
      ?>
    </table>
  </div>

</body>
</html>