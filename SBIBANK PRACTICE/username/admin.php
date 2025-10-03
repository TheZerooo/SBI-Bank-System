<?php
session_start();
if(isset($_SESSION['username'])and isset($_SESSION['issuperuser']))
    {
  include 'nav.php';
        echo 'Welcome  '.ucfirst($_SESSION['username']);
}
else{
        header('location:login.php');
}