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
    <div class="all_users">
        <p class="reseller">Resellers</p>
        <div class="add-user">
         <a href="create.php">Reseller Toevoegen<br></a>
        </div>
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
                <p class="reseller">Reseller: <?php echo $users['reseller'] ?></p><br>
                <p class="display_info">E-mail adres: <?php echo $users['Email'] ?></p><br>
                <p class="display_info">Telefoon: <?php echo $users['phone'] ?></p><br>
                <p class="display_info">Postcode: <?php echo $users['postal'] ?></p><br>
                <p class="display_info">Adres: <?php echo $users['street'] . " " . $users['number'] . ", " . $users['city']; ?></p><br>
            </div>
            <div class="action">
            <a class="W" href="delete-user.php?<?php echo http_build_query($userData); ?>">Verwijder<br>Gebruiker</a>  
            </div>
        </div>
        <?php //in de href actie hierboven geef ik de informatie mee met de funktie 'echo http_build_query($userData);' "$userData" is de array die ik eerder heb gekmaakt
        }
        ?>
        </div>
    </div>

</body>
</html>
