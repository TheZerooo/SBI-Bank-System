
<?php
include 'connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login Page</title>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      font-family: Arial, sans-serif;
      background: #f0f2f5;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .login-container {
      background: white;
      padding: 2rem;
      border-radius: 8px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      width: 320px;
    }

    .login-container h2 {
      text-align: center;
      margin-bottom: 1.5rem;
      color: #333;
    }

    .login-container label {
      display: block;
      margin-bottom: 0.5rem;
      color: #555;
      font-weight: 600; 
    }

    .login-container input[type="text"],
    .login-container input[type="password"] {
      width: 100%;
      padding: 0.6rem;
      margin-bottom: 1rem;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-size: 1rem;
      transition: border-color 0.3s;
    }

    .login-container input[type="text"]:focus,
    .login-container input[type="password"]:focus {
      border-color: #007bff;
      outline: none;
    }

    .login-container button {
      width: 100%;
      padding: 0.7rem;
      background-color: #007bff;
      border: none;
      color: white;
      font-size: 1.1rem;
      border-radius: 4px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .login-container button:hover {
      background-color: #0056b3;
    }

    .login-container .forgot-password {
      text-align: right;
      margin-top: 0.5rem;
      font-size: 0.9rem;
    }

    .login-container .forgot-password a {
      color: #007bff;
      text-decoration: none;
    }

    .login-container .forgot-password a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="login-container">
    
    <h2>Login</h2>
    <form action=""  method="POST">
      <label for="username">Username/AccountNo</label>
      <input type="text" id="username" name="username" placeholder="Enter username" required />

      <label for="password">Password</label>
      <input type="password" id="password" name="password" placeholder="Enter password" required />

      <button type="submit" name='sbt'>Login</button>
      <div class="forgot-password">
        <a href="forgot.php">Forgot password?</a>
      </div>
    </form>
  </div>
</body>
</html>
<?php
if(isset($_REQUEST['sbt']))
        {
        
            $user=$_REQUEST['username'];
            $pass=$_REQUEST['password'];
            $sql="select * from useraccount where username='$user' or accountno='$user' and password='$pass'";
            $output=mysqli_query($db,$sql);
            $data=mysqli_fetch_assoc($output);
          if(mysqli_num_rows($output)>0 and $data['isactive']==1)
              {
                // $data=mysqli_fetch_assoc($output);
                if($data['issuperuser']==1)
                    {
                      session_start();
                      $_SESSION['issuperuser']=$data['issuperuser'];
                      $_SESSION['username']=$data['username'];
                    
                      header('location:admin.php');
                    }
                  else{
                     session_start();
                      $_SESSION['username']=$data['username'];
                      $_SESSION['accountno']=$data['accountno'];
                      $_SESSION['Profile']=$data['Profile'];
                      header('location:dashboard.php');
                    
                  }
              }
            else{
              echo 'failed';
            }

        }