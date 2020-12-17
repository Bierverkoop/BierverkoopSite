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
            <li><a href="#"><i class="fas fa-home"></i>Home</a></li>
            <li><a href="#"><i class="fas fa-user"></i>Profile</a></li>
            <li><a href="#"><i class="fas fa-address-card"></i>About</a></li>
            <li><a href="#"><i class="fas fa-project-diagram"></i>portfolio</a></li>
            <li><a href="#"><i class="fas fa-blog"></i>Blogs</a></li>
            <li><a href="#"><i class="fas fa-address-book"></i>Contact</a></li>
            <li><a href='home.php?logout="1"'><i class="fas fa-sign-out-alt"></i>Uitloggen</a></li>
        </ul> 
        <div class="social_media">
          <a href="#"><i class="fab fa-facebook-f"></i></a>
          <a href="#"><i class="fab fa-twitter"></i></a>
          <a href="#"><i class="fab fa-instagram"></i></a>
      </div>
     </div>
    </div>
</div>
    <div class="add_user">
    <?php include('error.php'); //dit is de error feed die de errors laat zien als er iets fout gaat in het registreer systeem ?>
    <form action="home-admin.php" method="POST">  <?php //hier word de action omgezet naar deze pagina, dat kan omdat je de server.php heb gelinkt bovenaan ?>
        <div class="textbox">
            <input type="text" placeholder="reseller" name="reseller">
        </div>
        <div class="textbox">
            <input type="password" placeholder="Wachtwoord" name="password_1">
        </div>
        <div class="textbox">
            <input type="password" placeholder="Wachtwoord herhalen" name="password_2">
        </div>
        <div class="textbox">
            <input type="email" placeholder="e-mail adres" name="email">
        </div>
        <div class="textbox">
            <input type="tel" placeholder="06-XXX-XXX" name="phone">
        </div>
        <div class="textbox">
            <input type="text" placeholder="straat" name="street">
        </div>
        <div class="textbox">
            <input type="text" placeholder="huis nummer" name="number">
        </div>
        <div class="textbox">
            <input type="text" placeholder="postcode" name="postal">
        </div>
        <div class="textbox">
            <input type="text" placeholder="stad" name="city">
        </div>
        <button type="submit" name="register" class="button">REGISTER</button>
        </form>
    </div>
    <div class="all_users">
        <p class="reseller">al bestaande gebruikers</p>
        <div class="user_grid">
        <?php
        $sqlG = "SELECT * FROM resellers Where admin='false';";  //hier zorg ik er voor dat het systeem alle users behalve de admin laten zien door admin='false' in te vullen
        //                                                         de admin waarde wanneer er een user word gemaakt is standaart false, dat ik zo gezet in de database
        $allUsers = mysqli_query($db, $sqlG);
        while($users = mysqli_fetch_assoc($allUsers)) { // fetch assoc gebruik ik voor het vinden van informatie foor een assoc te fetchen

            $userData = array('UID' => $users['ID']); //hier maak ik een array met informatie die moet worden doorgestuurd naar de 'delete_user.php', dit bevat de user zij ID
            //hierboven gebruik ik de fetch assoc om speciefieke data uit de database te halen, $(naam van assoc)['specefieke info van een user in de database'];

        ?>
        
        <div class="info">
            <div class="details">
                <p class="reseller">reseller: <?php echo $users['reseller'] ?></p><br>
                <p class="display_info">e-mail adres: <?php echo $users['email'] ?></p><br>
                <p class="display_info">telefoon: <?php echo $users['phone'] ?></p><br>
                <p class="display_info">postcode: <?php echo $users['postal'] ?></p><br>
                <p class="display_info">adres: <?php echo $users['street'] . " " . $users['number'] . ", " . $users['city']; ?></p><br>
            </div>
            <div class="action">
            <a class="W" href="delete-user.php?<?php echo http_build_query($userData); ?>">verwijder<br>gebruiker</a>  
            </div>
        </div>
        <?php //in de href actie hierboven geef ik de informatie mee met de funktie 'echo http_build_query($userData);' "$userData" is de array die ik eerder heb gekmaakt
        }
        ?>
        </div>
    </div>
    <div class="pending">
        <p class="reseller">bestellingen (niet geaccepteerd)</p>
    <?php
    $sqlP = "SELECT * FROM orders;";  //hier selecteer ik een tabel in de database
    $pending = mysqli_query($db, $sqlP); //hier word dat uitgevoerd
    while($record = mysqli_fetch_assoc($pending)) {  //met de while statement word bedoeld dat elke rij in een tabel word gedisplayd

        $reseller = $record['BID'];
        $sqlReseller = "SELECT * FROM resellers WHERE ID='$reseller'";
        $resultReseller = mysqli_query($db, $sqlReseller);
        $resellerRecord = mysqli_fetch_assoc($resultReseller);

        $data = array('OID' => $record['OID'], 'email' => $resellerRecord['email']); //dit is de array info die ik mee geef, niet meer / niet minder
        // de => staan voor: staat voor of betekend

    ?>

    <div class="info">
        <div class="details">
            <p class="reseller">reseller: <?php echo $resellerRecord['reseller'] ?></p><br>
            <p class="display_info">aantal: <?php echo $record['amount'] ?></p><br>
            <p class="display_info">totaal prijs: €<?php echo $record['Oprice'] ?></p><br>
            <p class="display_info">bezorg kosten: €<?php echo $record['Dprice'] ?></p><br>
            <p class="display_info">bezorg adres: <?php echo $record['deliver'] ?></p><br>
            <p class="display_info">datum bestelling gezet: <?php echo $record['Odate'] ?></p><br>
        </div>
        <div class="action">
            <a class="A" href="accept.php?<?php echo http_build_query($data); ?>">accepteer</a>  
            <a class="W" href="decline.php?<?php echo http_build_query($data); ?>">weiger</a>
        </div>
    </div>

    <?php 
    } // in die hierboven geef ik weer info mee in de vorm van een array
    ?>
    </div>
    <div class="accepted">
        <p class="reseller">bestellingen (geaccepteerd)</p><br>
        <p class="reseller">vandaag: <?php echo date('Y-m-d'); ?></p>
        <?php
    $sqlA = "SELECT * FROM ordersaccepted;";
    $pending = mysqli_query($db, $sqlA);
    while($record = mysqli_fetch_assoc($pending)) {

        $reseller = $record['BID'];
        $sqlReseller = "SELECT * FROM resellers WHERE ID='$reseller'";
        $resultReseller = mysqli_query($db, $sqlReseller);
        $resellerRecord = mysqli_fetch_assoc($resultReseller);

        $data = array('OID' => $record['OID'], 'email' => $resellerRecord['email']);
        $timeNow = date("Y-m-d");  //hier word de systeem tijd van je laptop opgevraagd 

        if($timeNow >= $record['Ddate']) {  //heir word gekeken als de datum vandaag of al is geweest is
            $status = "bezorgd";  //$ststus is wat word gedisplayd later in de info van de bestelling
        } else {
            $status = "word bezorg op: " . $record['Ddate'];  //als de datum noch niet is geweest dan word dit gedisplayd
        }

    ?>

    <div class="info">
        <div class="details">
            <p class="reseller">reseller: <?php echo $resellerRecord['reseller'] ?></p><br>
            <p class="display_info">aantal: <?php echo $record['amount'] ?></p><br>
            <p class="display_info">totaal prijs: €<?php echo $record['Oprice'] ?></p><br>
            <p class="display_info">bezorg kosten: €<?php echo $record['Dprice'] ?></p><br>
            <p class="display_info">bezorg adres: <?php echo $record['deliver'] ?></p><br>
            <p class="display_info">datum geaccepteerd: <?php echo $record['Adate'] ?></p><br>
            <p class="display_info status">status: <?php echo $status ?></p><br>   <?php //hier display ik de ststus van de bestelling die ik eerder heb ingestelt ?>
        </div>
        <div class="action">
            <a class="A" href="done.php?<?php echo http_build_query($data); ?>">voltooid?</a>
        </div>
    </div>

    <?php //hierboven word er weer een array doorgestuurd naar de done.php en die verweiderd de order
    }
    ?>
    </div>
</body>
</html>
