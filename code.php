<?php

if (isset($_POST["btnLogin"]))
{
    $username = htmlspecialchars($_POST["Username"]);
    $password = htmlspecialchars($_POST["Password"]);

    echo $username;

}
else
{
    echo "paard";
}


?>