<?php

include('server.php');  //weer word de server geincludeerd

$OID = $_GET['OID'];   //hier word de order ID opgehaald
$email = $_GET['email'];   //heir word de email van de UID of tewel user ID opgehaald

$decline = mysqli_query($db, "DELETE from orders WHERE OID='$OID'");  //heir word de OID verwijderd uit de database, without a trace

header("location: orderoverzicht.php");

//hier onder weer een e-mail form zonde fout, maar kan geen email sturen

/*if($decline) {
    $to = $email;
    $subject = "bestelling geweigerd";

    $messgae = "<b>uw bestelling is geweigerd door de leverancier</b>";
    $message .= "<b>probeer later opnieuw een bestelling te plaatsen</b>";
    $message .= "<b>als u niet begrijpt waarom uw betelling is geannuleerd neem dan contact met ons op</b>";

    $header = "From:abe-bier@reseller.com \r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html\r\n";

    $retval = mail ($to, $subject, $message, $header);

    if ($retval == true) {
        header("location: home-admin.php");
    } else {
        echo "bericht kon niet verzonden worden";
    }
    
}*/

?>