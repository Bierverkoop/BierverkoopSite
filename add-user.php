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
</head>
<body>
    <header>
        <div class="logout">
            <p><a href='home.php?logout="1"' class="button_text">Logout</a></p> <?php //de loguit knop ?>
        </div>
        <div class="user">
            <p><?php echo $_SESSION['reseller'] . " "; ?>  </p> <?php //hier word de naam van de reseller displayd met de sessie informatie ?>
        </div>
    </header>
    <div class="add_user">
    <?php include('error.php'); //dit is de error feed die de errors laat zien als er iets fout gaat in het registreer systeem ?>
    <form action="add-user.php" method="POST">  <?php //hier word de action omgezet naar deze pagina, dat kan omdat je de server.php heb gelinkt bovenaan ?>
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
</body>
</html>
