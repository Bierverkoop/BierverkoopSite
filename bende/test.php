<?php

require_once 'connect.php';

$message = "Invalid Username or Password";

if (isset($_POST))
{
    $username = htmlspecialchars($_POST["Username"]);
    $password = htmlspecialchars($_POST["Password"]);

    $query = "SELECT * FROM tblUser WHERE Username= '$username' AND Passwor= '$password'"; 
    $result = mysqli_query($conn, $query); 

    if (mysqli_num_rows($result)>0) 
   {
        while($row= mysqli_fetch_assoc($result))
        {
        if($row["Rol"] == "Admin")
        }
             $_SESSION['LoginUser'] = $row["Username"];
             header('Location: admin.php');
        }
        else 
        {
            $_SESSION['LoginUser'] = $row["Username"];
            header('Location: admin.php');
        {  
    }
        }
        }
        else
        {
            header('Location:index.php');
        }