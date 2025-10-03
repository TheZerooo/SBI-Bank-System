<?php
include 'connection.php'; // Database connection file
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Register</title>
<style>
  /* CSS for styling the page */
  @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

  body {
    background: linear-gradient(135deg, #667eea, #764ba2);
    font-family: 'Poppins', sans-serif;
    margin: 0;
    display: flex;
    height: 100vh;
    justify-content: center;
    align-items: center;
  }

  .register-container {
    background: white;
    padding: 40px 50px;
    border-radius: 12px;
    box-shadow: 0 12px 25px rgba(102, 126, 234, 0.3);
    width: 350px;
  }

  .register-container h2 {
    text-align: center;
    margin-bottom: 30px;
    color: #4b3b8a;
    font-weight: 600;
    font-size: 28px;
  }

  form {
    display: flex;
    flex-direction: column;
  }

  label {
    margin-bottom: 6px;
    font-weight: 600;
    color: #555;
  }

  input[type="text"],
  input[type="password"],
  input[type="email"],
  input[type="file"] {
    padding: 12px 15px;
    margin-bottom: 20px;
    border-radius: 8px;
    border: 2px solid #ddd;
    font-size: 16px;
    transition: border-color 0.3s ease;
  }

  input:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 8px #667eea55;
  }

  button {
    background: #667eea;
    color: white;
    padding: 14px;
    border: none;
    border-radius: 10px;
    font-size: 18px;
    cursor: pointer;
    font-weight: 600;
    transition: background 0.3s ease;
  }

  button:hover {
    background: #5a67d8;
  }

  .error {
    color: #e53e3e;
    margin-top: -15px;
    margin-bottom: 15px;
    font-size: 14px;
    display: none;
  }
</style>
</head>
<body>
  <div class="register-container">
    <h2>Create Account</h2>
    <!-- enctype="multipart/form-data" is important for file upload -->
    <form action="" method="POST" id="registerForm" 
          onsubmit="return validateForm()" enctype="multipart/form-data">
      
      <label for="username">Username</label>
      <input type="text" id="username" name="username" placeholder="Choose a username" required />
      
      <label for="password">Password</label>
      <input type="password" id="password" name="password" placeholder="Enter password" required />
      
      <label for="repassword">Re-enter Password</label>
      <input type="password" id="repassword" name="repassword" placeholder="Confirm password" required />
      
      <label for="balance">Balance</label>
      <input type="text" id="balance" name="balance" placeholder="Enter The Balance" required />

      <label for="file">Profile Pic</label>
      <input type="file" id="file" name="file" />

      <label for="email">Email</label>
      <input type="email" id="email" name="email" placeholder="Enter Your Email" required />

      <div id="error" class="error">Passwords do not match!</div>

      <button type="submit" name="submit">Register</button>
    </form>
  </div>

<script>
  // ✅ JavaScript function for password match validation
  function validateForm() {
    const password = document.getElementById('password').value;
    const repassword = document.getElementById('repassword').value;
    const errorDiv = document.getElementById('error');

    if (password !== repassword) {
      errorDiv.style.display = 'block'; // Show error message
      return false; // Stop form submission
    }
    errorDiv.style.display = 'none'; // Hide error if matched
    return true;
  }
</script>
</body>
</html>

<?php
if (isset($_POST['submit'])) {
    $name = $_POST['balance'];   
    $user = $_POST['username'];   
    $password = $_POST['password'];   
    $repassword = $_POST['repassword'];  
    $email = $_POST['email'];

    // default photo
    $profilePic = "default.png";

    if ($password == $repassword) {
        // check if file uploaded
        if (!empty($_FILES['file']['name'])) {
            $profilePic = $_FILES['file']['name'];
            move_uploaded_file($_FILES['file']['tmp_name'], "uploads/" . $profilePic);
        }

        $account = rand(1111, 99999);
        $sql = "INSERT INTO useraccount 
                (accountno, balance, username, password, Profile, email) 
                VALUES 
                ('$account', '$name', '$user', '$password', '$profilePic', '$email')";
        
        if (mysqli_query($db, $sql)) {
            header("location:login.php");
        } else {
            echo "❌ Failed: " . mysqli_error($db);
        }
    } else {
        echo "❌ Passwords do not match!";
    }
}
?>

