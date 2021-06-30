<?php
require_once "functions.php";
    if(!isset($_SESSION['username']))
    {
        header("location:login.php");
        die();   //exit call
    }
?>
<style>
#grid1
{
    display: grid;
    grid-template-columns: 12vw 74vw 12vw;
    grid-template-rows: 20vh auto auto auto;
    gap: 10px;
    text-align: center;
    grid-template-areas: 'head head head'
                         '. form .'
                         '. out .'
                         'foot foot foot'
}

#Head
{
    font-weight: bold;
    color:whitesmoke;
    text-shadow:2px 2px 2px black;
    background-color:whitesmoke;
    grid-area: head;
}

#myForm
{
    grid-area: form;
    background-color: lavender;
    display: grid;
    grid-template-columns: auto auto;
    grid-template-rows: auto auto auto;
}

#logout
{
    grid-column: 1/3;
}

#Output
{
    grid-area: out;
}

#footer
{
    grid-area: foot;
}
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index page</title>
</head>
<body id="grid1">
<header id="Head">
        <h1>Raj's Ica05 Authentication admin:<?php
    echo $_SESSION['username'];
    ?></h1>
    </header>
    <section id="myForm">
        <a href="settings.php">Settings</a>
        <a href="messages.php">Messages</a>
        <a href="#">Real Time Monitor</a>
        <a href="#">Tag Admin</a>
    <form action="login.php" method="POST" id="logout" >
    <input type="submit" name = "logout" value="logout">
    </form>
    </section>
<section id="Output">
    <?php
    echo $pageStatus;
    ?>
</section>
<footer id="footer">
        ©2020 by Raj<br>
    
        <section >
        <script >
            var d = new Date();
            document.getElementById("footer").innerHTML = "last Modified On: "+d.toLocaleString();
         </script>
        </section>
    </footer>
</body>
</html>