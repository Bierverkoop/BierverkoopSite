<?php 

include('server.php');  //server

if (empty($_SESSION['reseller']) or empty($_SESSION['userID'])) { //dit is een beveileging zodat je alleen deze pagina kunt vinden als je bent ingelogd
    header('location: index.php');
}

$db = mysqli_connect('localhost', 'deb85590_verkoop3', 'CrO6NVhO', 'deb85590_verkoop3'); //dit gebruik ik elke keer als ik een query uitvoer zodat ik met de database verbind

?>

<!DOCKTYPE html>
<html>
<head>
<meta http-equiv="Content-Type"
        content="text/html";
        charset="UTF-8">
        <meta name="robots" content="all">
        <meta name="language" content="Dutch">
        <meta name="author" content="Marthijs, Wouter, Toni, Lars">
        <meta name="description" content="resellers">
        <meta name="keywords" content="">
    <title>welkom-admin</title>
    <link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" href="styles.css">
	<script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
</head>
<body>
    <header>
    </header>
    <div class="wrapper">
     <div class="sidebar">
     <h2><li><i class="fas fa-user"></i></li></h2>
     <h2><p><?php echo $_SESSION['reseller'] . " "; ?>  </p></h2> <?php //hier word de naam van de reseller displayd met de sessie informatie ?>
        <ul>
            <li><a href="orderoverzicht.php"><i class="fas fa-list"></i>Orderoverzicht</a></li>
            <li><a href="accepted-orders.php"><i class="fas fa-check"></i>Geaccepteerde Orders</a></li>
            <li><a href="resellers.php"><i class="fas fa-users"></i>Resellers</a></li>
            <li><a href='home.php?logout="1"'><i class="fas fa-sign-out-alt"></i>Uitloggen</a></li>
        </ul> 
     </div>
    </div>
</div>
    </div>
    <div class="accepted">
        <p class="reseller">Geaccepteerde Orders:</p><br>
        <p class="reseller">Vandaag: <?php echo date('Y-m-d'); ?></p>
        <?php
    $sqlA = "SELECT * FROM ordersaccepted;";
    $pending = mysqli_query($db, $sqlA);
    while($record = mysqli_fetch_assoc($pending)) {

        $reseller = $record['BID'];
        $sqlReseller = "SELECT * FROM resellers WHERE ID='$reseller'";
        $resultReseller = mysqli_query($db, $sqlReseller);
        $resellerRecord = mysqli_fetch_assoc($resultReseller);

        $data = array('OID' => $record['OID']); //dit is de array info die ik mee geef, niet meer / niet minder
        $timeNow = date("Y-m-d");  //hier word de systeem tijd van je laptop opgevraagd 

        if($timeNow >= $record['Ddate']) {  //heir word gekeken als de datum vandaag of al is geweest is
            $status = "bezorgd";  //$ststus is wat word gedisplayd later in de info van de bestelling
        } else {
            $status = "word bezorg op: " . $record['Ddate'];  //als de datum noch niet is geweest dan word dit gedisplayd
        }

    ?>

    <div class="info">
        <div class="details">
            <p class="reseller">Reseller: <?php echo $resellerRecord['reseller'] ?></p><br>
            <p class="display_info">Aantal: <?php echo $record['amount'] ?></p><br>
            <p class="display_info">Prijs: €<?php echo $record['Oprice'] ?></p><br>
            <p class="display_info">Bezorgkosten: €<?php echo $record['Dprice'] ?></p><br>
            <p class="display_info">Bezorgadres: <?php echo $record['deliver'] ?></p><br>
            <p class="display_info">Datum Geaccepteerd: <?php echo $record['Adate'] ?></p><br>
            <p class="display_info status">Status: <?php echo $status ?></p><br>   <?php //hier display ik de ststus van de bestelling die ik eerder heb ingestelt ?>
        </div>
        <div class="action">
            <a class="A" href="done.php?<?php echo http_build_query($data); ?>">Afronden</a>
        </div>
    </div>

    <?php //hierboven word er weer een array doorgestuurd naar de done.php en die verweiderd de order
    }
    ?>
    </div>
</body>
</html>
