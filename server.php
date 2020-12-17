<?php

session_start();

$errors = array();  //dit maakt van de erros ene arrsy
$orderErrors = array();

$db = mysqli_connect('localhost', 'deb85590_verkoop3', 'CrO6NVhO', 'deb85590_verkoop3');

//register
if(isset($_POST['register'])) { //dit leest als ik de button heb gebruikt of niet, zo wel dan voert hij het onderstaande script uit
    $reseller = mysqli_real_escape_string($db, $_POST['reseller']);
    $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
    $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $phone = mysqli_real_escape_string($db, $_POST['phone']);
    $street = mysqli_real_escape_string($db, $_POST['street']);
    $number = mysqli_real_escape_string($db, $_POST['number']);
    $postal = mysqli_real_escape_string($db, $_POST['postal']);
    $city = mysqli_real_escape_string($db, $_POST['city']); //hier haal ik alle info van het formulier


    if(empty($reseller)) { //dit gebruik ik om te zien als er een veld leeg is
        array_push($errors, "Vul reseller in"); //als het veld leeg is word er een array push gedaan met de error info, dat word gestuurd naar error.php
    }

    if(empty($password_1)) {
        array_push($errors, "Wachtwoord is verplicht");
    }
    if($password_1 != $password_2) {
        array_push($errors, "De wachtwoorden komen niet overeen");
    }

    if(empty($email)) {  //hier kijk ik weer als hij leeg is
        array_push($errors, "E-mail adresis verplicht");
    } else {  //als hij niet leeg is word er naar de ingevulde email gezocht in de database
        $query = "SELECT * FROM resellers WHERE email='$email'";
        $result = mysqli_query($db, $query);
        if (mysqli_num_rows($result) ==1) { //als die word gevonden dan word er weer een array push gedaan en het formulier word geannuleerd
            array_push($errors, "Dit E-mail adres is al in gebruik");
        }
    }

    if(empty($phone)) {  //hier word het zelfde gedaan als bij de email
        array_push($errors, "Telefoon is verplicht");
    } else {
        $query = "SELECT * FROM resellers WHERE phone='$phone'";
        $result = mysqli_query($db, $query);
        if (mysqli_num_rows($result) ==1) { 
            array_push($errors, "Dit telefoon nummer is al geregistreerd");
        }
    }

    if(empty($street and $number and $city)) {  //hier gebruik ik 'and' omdat deze drie een compleet adres vormen
        array_push($errors, "Vul adres in");
    }
    if(empty($postal)) {
        array_push($errors, "Vul postcode in");
    }

    if (count($errors) == 0) {  //hier word er gekeken als er geen errors in de error array staan, zoniet dan word het uitgevoerd
        $password = md5($password_1);  //hier word er een encriptie over het wachtwoord gegooid door er md5 voor te zetten en de value tusen de haakjes
        $sql = "INSERT INTO resellers (reseller, password, email, phone, street, number, postal, city) 
        VALUES ('$reseller', '$password', '$email', '$phone', '$street', '$number', '$postal', '$city')";  //de query voor het toevoegen van de user

        mysqli_query($db, $sql);  //het uivoeren van de query

        header('location: resellers.php');  //hier word je weer terug gestuurd naar de pagina
    }

}

//login
if (isset($_POST['login'])) {  //zelfde verhaal maar iets anders
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = mysqli_real_escape_string($db, $_POST['password']);  //informatie word opgehaald
    //bija vergeten, de gele text hierboven checkt als er een mysqli string word ingevoerd, dit voorkomt inbraak op de login code en het hacken van de databse

    if(empty($email)) {
        array_push($errors, "E-mail adres invullen");  //array push als ze leeg zijn
    }
    if(empty($password)) {
        array_push($errors, "Wachtwoord invullen");
    }

    if (count($errors) == 0) {  //geen errors, dan word het onderstaande script uitgevoerd
        $password = md5($password); //wachtwoord encripty er opzetten (die word vergeleken met de encrypties in de database)
        $query = "SELECT * FROM resellers WHERE password='$password' AND email='$email'"; //hier word de database doorzocht voor de combinatie van wachtwoord en email
        $result = mysqli_query($db, $query);
        if (mysqli_num_rows($result) ==1) {  //hier word er gekeken als er ene combinatie is
            $sqlAdmin = "SELECT * FROM resellers WHERE password='$password' AND email='$email' AND admin='true'"; //hie gaat het kijken als admin true is voor die probeert inteloggen
            $resultAdmin = mysqli_query($db, $sqlAdmin);
            $resultCheck = mysqli_num_rows($resultAdmin);  //dit is het zelfde als in de home pagina van de admin
            if ($resultCheck == 1) { //als de admin true is word er een waarde van 1 gegeven en word de onderstaande code uitgevoerd
                $user = mysqli_fetch_assoc($resultAdmin); //hier word er een assoc gemaakt van de adminCheck
                $_SESSION['reseller'] = $user['reseller'];  //hier word de naam van de reseller in de sessie gezet
                $_SESSION['userID'] = $user['ID']; //hier word het ID van de reseller in de sessie gezet
                header('location: orderoverzicht.php');
            } else { //ald die gene die inlogd niet een admin is word het volgende uitgevoerd
                $user = mysqli_fetch_assoc($result);  //hier word een assoc gemaakt van het eerste resultaat en niet van de admin check code
                $_SESSION['deliver'] = $user['street'] ." ". $user['number'] .", ". $user['postal'] ." - ". $user['city'];
                //hier boven word er een sessie variabele 'deliver' gemaakt met de adres gegevend van de reseller, admin gaad niet bestellen en heeft dit niet nodig
                //het word in deze volgorde gedaan met text stukjes er tussen zodat het tijdens de bestelling zo de database kan worden in gezet
                $_SESSION['reseller'] = $user['reseller'];  //hier weer de naam van de reseller
                $_SESSION['userID'] = $user['ID'];  //en het ID van de reseller
                header('location: home.php');  //maar de resellers worden naar een andere pagina gestuurd dan de admin
            }
        } else {
            array_push($errors, "Wachtwoord en E-mail adres zijn verkeerd of bestaan niet"); //als er geen resultaat is van de email en wachtwoord combinatie
            //word er weer ene array push gedaan met d efout informatie
        }
    }
}

//logout

if (isset($_GET['logout'])) { //dit is het loguit systeem, heel simpel, gewoon de session info unsetten
    session_destroy();  //sessie vernietigen
    unset($_SESSION['reseller']);  //de reseller en ID van de reseller unsetten
    unset($_SESSION['userID']);
    header('location: index.php');  //heir word de user terug gestuurd naar de inog pagina
}

//order

if (isset($_POST['order'])) {
    $amount = mysqli_real_escape_string($db, $_POST['amount']);
    $BID = $_SESSION['userID'];
    $deliver = $_SESSION['deliver'];
    $Odate = date("Y-m-d");

    if($amount < 10 or empty($amount)) {
        array_push($orderErrors, "minimaal 10 bestellen");
    }

    if ($amount >= 10 ) {
        $Oprice = $amount * 1.75;
        if ($Oprice >= 250) {
            $Dprice = 50.00;
        } else {
            $Dprice = $amount * 1.50;
        }
    }

    if (count($orderErrors) == 0) {
        $sqlOrder = "INSERT INTO orders (BID, amount, deliver, Odate, Oprice, Dprice) 
        VALUES ('$BID', '$amount', '$deliver', '$Odate', '$Oprice', '$Dprice')";

        mysqli_query($db, $sqlOrder);



        header('location: home.php');
    }
}

?>