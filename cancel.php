<?php

include('server.php');    //server

$OID = $_GET['OID'];   //order ID

mysqli_query($db, "DELETE from orders WHERE OID='$OID'");   //delete query

header('location: home.php'); //terug naar de admin pagina

//kan ook een automatisch systeem maken die kijkt als er een bestelling klaar is en word dan automatisch verweiderd
//heb niet gedaan maar kan wel

?>