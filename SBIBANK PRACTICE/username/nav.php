<?php
if(isset($_SESSION['issuperuser'])){
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Vertical Navbar</title>
<style>
  body {
    margin: 0;
    font-family: Arial, sans-serif;
  }

  .sidebar {
    height: 100vh;
    width: 250px;
    background-color: #2c3e50;
    color: white;
    display: flex;
    flex-direction: column;
    align-items: center;
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
</style>
</head>
<body>

<div class="sidebar">
  <div class="admin-area">
    <img src="https://i.pravatar.cc/80" alt="Admin Photo" class="admin-photo" />
    <div class="admin-name"><?php  echo ucfirst($_SESSION['username']);?></div>
    <div style='background-color:red;color:white;width:40%;margin:auto;padding:5px;border-radius:10px;'><a href='logout.php' style="text-decoration:none;color:white;">Logout</a></div>
  </div>

  <nav class="nav-links">
    <a href="approved.php">Approved Account</a>
    <a href="transaction1.php">Transaction History</a>
    <a href="AI.php">Account Active or Inactive</a>
    <a href="AccountInfo1.php">Account Information</a>
  </nav>
</div>

</body>
</html>
<?php
}
else{
  echo "PLEASE LOGIN AS ADMIN";
}
?>
