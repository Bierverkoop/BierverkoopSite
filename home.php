<?php include('server.php');

if (empty($_SESSION['reseller']) or empty($_SESSION['userID'])) {
    header('location: index.php');
}

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
    <title>welkom</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body class="body">
    <header>
        <div class="logout">
            <p><a href='home.php?logout="1"' class="button_text">Uitloggen</a></p> <?php //de loguit knop ?>
        </div>
        <div class="user">
            <p><?php echo $_SESSION['reseller'] . " "; ?>  </p> <?php //hier word de naam van de reseller displayd met de sessie informatie ?>
        </div>
    </header>
    <div class="content">
        <div class="order">
            <p class="reseller">Bestel hier</p><br>
            <p class="detail">Op het moment dat u besteld word het naar de leverancier 
                gestuurd en die accepteerd of weigerd uw bestelling</p>
                <p>1 flesje is 1,75 euro en u moet minimaal 10 bestellen</p>
                <p>per 50 flesjes zijn de verzend kosten 7,50 euro en boven de 250 euro in 1 bestelling zijn de verzend kosten vast 50 euro</p>
                <?php include('error.php'); ?>
            <form action="home.php" method="POST">
                <div class="textbox amount">
                    <input type="number" id="amount" min="10" name="amount" placeholder="10">
                 </div>
                <button type="submit" name="order" class="order_button">Bestellen</button>
            </form>
        </div>
    </div>
    <div class="pending-t">
        <p class="reseller-t">Bestellingen (In Behandeling)</p><br>
        <?php
        $ID = $_SESSION['userID'];
    $sqlP = "SELECT * FROM orders WHERE BID='$ID';";
    $pending = mysqli_query($db, $sqlP);
    while($record = mysqli_fetch_assoc($pending)) {

        $data = array('OID' => $record['OID']);

    ?>

    <div class="info">
        <div class="details">
            <p class="display_info">aantal: <?php echo $record['amount'] ?></p><br>
            <p class="display_info">totaal prijs: €<?php echo $record['Oprice'] ?></p><br>
            <p class="display_info">bezorg kosten: €<?php echo $record['Dprice'] ?></p><br>
            <p class="display_info">bezorg adres: <?php echo $record['deliver'] ?></p><br>
        </div>
        <div class="action">
            <a class="W" href="cancel.php?<?php echo http_build_query($data); ?>">annuleren?</a>
        </div>
    </div>
    <?php //hierboven word er weer een array doorgestuurd naar de done.php en die verweiderd de order
    } if(mysqli_num_rows($pending) == 0) {
    ?>

    <div class="info">
        <div class="details">
        <p class="display_info">U heeft geen bestellingen geplaatst.</p>
        </div>
    </div>
    <?php
    }
    ?>
    </div>
    <div class="pending-t">
        <p class="reseller-t">Geaccepteerde Bestellingen</p><br>
        <p class="reseller-t">Vandaag: <?php echo date('Y-m-d'); ?></p>
        <?php
        $userID = $_SESSION['userID'];
    $sqlA = "SELECT * FROM ordersaccepted WHERE BID='$userID';";
    $accepted = mysqli_query($db, $sqlA);
    while($record = mysqli_fetch_assoc($accepted)) {

        $timeNow = date("Y-m-d");  //hier word de systeem tijd van je laptop opgevraagd 

        if($timeNow >= $record['Ddate']) {  //heir word gekeken als de datum vandaag of al is geweest is
            $status = "bezorgd";  //$ststus is wat word gedisplayd later in de info van de bestelling
        } else {
            $status = "word bezorg op: " . $record['Ddate'];  //als de datum noch niet is geweest dan word dit gedisplayd
        }

    ?>

    <div class="info">
        <div class="details">
            <p class="display_info">Aantal: <?php echo $record['amount'] ?></p><br>
            <p class="display_info">Prijs: €<?php echo $record['Oprice'] ?></p><br>
            <p class="display_info">Bezorgkosten: €<?php echo $record['Dprice'] ?></p><br>
            <p class="display_info">Bezorgadres: <?php echo $record['deliver'] ?></p><br>
            <p class="display_info status">Status: <?php echo $status ?></p><br>   <?php //hier display ik de status van de bestelling die ik eerder heb ingestelt ?>
        </div>
    </div>


    <?php //hierboven word er weer een array doorgestuurd naar de done.php en die verweiderd de order
    } if(mysqli_num_rows($accepted) == 0) {
    ?>

    <div class="info">
        <div class="details">
        <p class="display_info">Er zijn geen bestellingen onderweg.</p>
        </div>
    </div>
    <?php
    }
    ?>
    </div>
</body>
</html>