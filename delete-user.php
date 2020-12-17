<?php

include('server.php');  //server

$UID = $_GET['UID'];  //user ID

$sqlD = "DELETE from resellers WHERE ID='$UID'";  //delete query

$delete = mysqli_query($db, $sqlD);  //query word uitgevoerd

header('location: resellers.php');  //terug naar de admin pagina

?>