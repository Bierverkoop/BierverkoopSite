<?php
$con = mysqli_connect('localhost', 'root', '', 'bier');

$txtName = $_POST['txtName'];
$txtLastName = $_POST['txtLastName'];
$txtEmail = $_POST['txtEmail'];
$txtPlaats = $_POST['txtPlaats'];
$txtPostcode = $_POST['txtPostcode'];
$txtAdres = $_POST['txtAdres'];
$txtAantal = $_POST['txtAantal'];

$sql = "INSERT INTO `bestelling_open`(`Naam`, `Achternaam`, `E-mail`, `Plaats`, `Postcode`, `Adres`, `Aantal`) VALUES ('$txtName', '$txtLastName', '$txtEmail', '$txtPlaats', '$txtPostcode', '$txtAdres', '$txtAantal')";
$rs = mysqli_query($con, $sql);

if  ($rs)
{
    echo "bestelling opgeslagen en wordt verwerkt";
}else{
    echo "Bestelling niet opgeslagen, probeer het opnieuw";
}
?>