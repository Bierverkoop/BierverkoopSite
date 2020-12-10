<?php
session_start();


require_once 'connect.php';

$message = "Invalid Username or Password";

if (isset($_POST))
{
    //echo 'koe';
    $username = htmlspecialchars($_POST["Username"]);
    $password = htmlspecialchars($_POST["Password"]);

    $query = "SELECT * FROM tblUser WHERE Username= '$username' AND Passwor= '$password'"; 
    $result = mysqli_query($conn, $query); 
    if (mysqli_num_rows($result) > 0) 
   {
        while($row= mysqli_fetch_assoc($result))
        {
            if($row["Rol"] == "Admin")
            {
                 $_SESSION= $row;
                header('Location: admin.php');
            }
            else             {
                //echo 'kip';
                $_SESSION= $row;
                header('Location: reseller.php');
            }
            
        }
   }else{
            
       // header('Location: index.php');
    }
}


   
?>