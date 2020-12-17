<?php include('server.php'); ?>

<!DOCTYPE html>
<html>
    <head>
        <title>login</title>
        <meta http-equiv="Content-type"
        content="text/html"
        charset="UTF-8">
        <link rel="stylesheet" href="style.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://kit.fontawesome.com/2e1bcef615.js" crossorigin="anonymous"></script>
    </head>
    <body class="index">
        <div class="container">
            <h2>INLOGGEN</h2>
            <?php include('error.php'); ?>
            <form action="index.php" method="POST">
                <div class="textbox">
                    <i class="fas fa-envelope"></i>
                    <input type="text" placeholder="E-mail adres" name="email">
                 </div>
                 <div class="textbox">
                    <i class="fas fa-key"></i>
                    <input type="password" placeholder="wachtwoord" name="password">
                 </div>
                <button type="submit" name="login" class="button">LOGIN</button>
            </form>
        </div>
    </body>
</html>