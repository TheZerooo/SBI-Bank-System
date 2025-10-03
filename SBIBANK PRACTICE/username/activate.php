<?php
include 'connection.php';

$account=$_REQUEST['id'];

$sql="update useraccount set isactive=1 where accountno='$account'";

if(mysqli_query($db,$sql))
        {
            header('location:approved.php');
        }