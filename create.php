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
    <div class="add_user">
    <?php include('error.php'); //dit is de error feed die de errors laat zien als er iets fout gaat in het registreer systeem ?>
    <form action="create.php" method="POST">  <?php //hier word de action omgezet naar deze pagina, dat kan omdat je de server.php heb gelinkt bovenaan ?>
        <div class="textbox">
            <input type="text" placeholder="Reseller" name="reseller">
        </div>
        <div class="textbox">
            <input type="password" placeholder="Wachtwoord" name="password_1">
        </div>
        <div class="textbox">
            <input type="password" placeholder="Wachtwoord herhalen" name="password_2">
        </div>
        <div class="textbox">
            <input type="email" placeholder="E-mail adres" name="email">
        </div>
        <div class="textbox">
            <input type="tel" placeholder="06-XXX-XXX" name="phone">
        </div>
        <div class="textbox">
            <input type="text" placeholder="Straat" name="street">
        </div>
        <div class="textbox">
            <input type="text" placeholder="Huisnummer" name="number">
        </div>
        <div class="textbox">
            <input type="text" placeholder="Postcode" name="postal">
        </div>
        <div class="textbox">
            <input type="text" placeholder="Stad" name="city">
        </div>
        <button type="submit" name="register" class="button">Registreren</button>
        </form>
    </div>

</body>
</html>
