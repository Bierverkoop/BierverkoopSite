<?php

require_once 'connect.php';
include 'index.php';
// print_r($_POST);

//$message = "";

if (isset($_POST))
{
    $username = htmlspecialchars($_POST["Username"]);
    $password = htmlspecialchars($_POST["Password"]);

   // echo $username;
    
}
else
{
    //echo "paard";
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bier";


if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
$query = "SELECT * FROM tbluser WHERE Username= '$username' AND Passwor= '$password'";  
$sql = "SELECT Id,Username,Rol FROM MyGuests";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result)>0) { 
  // output data of each row
  while($row=mysqli_fetch_assoc($result)) { 
    echo "Username: " . $username["Username"]. " - Password: " . $password["Password"]. "<br>";
  }
} else {
  echo "0 results";
}

        $role = $row["Role"];
echo $role;


mysqli_close($conn); 



?>