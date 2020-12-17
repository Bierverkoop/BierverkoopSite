<?php

include('server.php');  //in elk bestand word de server.php geincludeerd

$OID = $_GET['OID'];  //dit is info die je in de href in de vorm van een array hebt mee gegeven
$email = $_GET['email'];

$query = "SELECT * FROM orders WHERE OID='$OID'";  //heir word het order ID opgezocht in de database
$accept = mysqli_query($db, $query); //de query word uitgevoerd
$orderInfo = mysqli_fetch_assoc($accept);  //hier word er weer ene assoc van gemaakt

if (mysqli_num_rows($accept) ==1) {  //als er een order is met de juiste OID dan word de onderstaande code uitgevoerd
    $orderID = $orderInfo['OID'];  //hieronder word alle info van die bestelling opgehaald
    $buyerID = $orderInfo['BID'];
    $amount = $orderInfo['amount'];
    $deliver = $orderInfo['deliver'];
    $Oprice = $orderInfo['Oprice'];
    $Dprice = $orderInfo['Dprice'];
    $Adate = date("Y-m-d");  //hier word de datum opgevraagd van de laptop oftewel het systeem (Adate staat voor acceptance date)
    //let wel op want in de databse staat de tijd in de volgende volgorde: jaar-maand-dag, dus andere vormen pakt de database niet

    $date = strtotime("next Monday");  //hier word de datum van de eerstvolgende maandag uitgerekend wand dat is de bezorg dag die ik heb gekozen
    $Ddate = date("Y-m-d", $date);  //hier word de $date samengevoegd met de nu datum en krijgt de naam $Ddate als in delivery date

    $sqlInsert = "INSERT INTO ordersaccepted (OID, BID, amount, deliver, Adate, Ddate, Oprice, Dprice) 
    VALUES ('$orderID', '$buyerID', '$amount', '$deliver', '$Adate', '$Ddate', '$Oprice', '$Dprice')";  //heir worden alle varabelen weer in de database gezt

    mysqli_query($db, $sqlInsert);   //hier word de $sqlInsert uitgevoerd met een query

    $sqlDelete = "DELETE from orders WHERE OID='$OID'";   //hier word de bestelling verwijderd uit de order tabel omdat alles al in de orderaccepted tabel staat

    mysqli_query($db, $sqlDelete);  //hier word de sqlDelete uitgevoerd

    header('location: orderoverzicht.php');   //en de locatie waar d euser heenword gestuurd

    //hieronder is het email systeem zonder fout maar ik kan geen mail sturen van mijn localhost omdat er iets verkeerd is in de localhost code

    /*$to = $email;
    $subject = "bestelling geaccepteerd";

    $messgae = "<b>uw bestelling is geaccepteerd door de leverancier</b>\n";
    $message .= "<b>wu bestelling van " . $amount . " word op " . $$Ddate . " bezorgd</b>\n";
    $message .= "<b>de totaal prijs van de bestelling is: " . $Oprice . " en de verzend kosten: " . $Dprice . "</b>\n";
    $message .= "<b>bedankt voor het bestellen bij ons</b>\n";

    $header = "From:abe-bier@reseller.com \r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html\r\n";

    $retval = mail ($to, $subject, $message, $header);

    if ($retval == true) {
        header("location: home-admin.php");
    } else {
        echo "bericht kon niet verzonden worden";
    }*/

}

?>