<?php

include('server.php');    //server

$OID = $_GET['OID'];   //order ID

mysqli_query($db, "DELETE from ordersaccepted WHERE OID='$OID'");   //delete query

header('location: orderoverzicht.php'); //terug naar de admin pagina

//kan ook een automatisch systeem maken die kijkt als er een bestelling klaar is en word dan automatisch verweiderd
//heb niet gedaan maar kan wel

?>