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
    grid-template-rows: 20vh auto auto auto auto;
    gap: 10px;
    text-align: center;
    grid-template-areas: 'head head head'
                         '. form .'
                         '. out .'
                         '. status .'
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
}

#status 
{
    grid-area: status;
}

#userTable
{
    grid-area: out;
}
table
{
    margin-left: auto;
    margin-right: auto;
}
td
{
    text-align: center;
    background-color: mediumspringgreen;
    width: 100px;
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/ajax.js" type="text/javascript"></script>
    <script src="js/settings.js" type="text/javascript"></script>
    <title>Login</title>
</head>
<body id="grid1">
    <header id="Head">
        <h1>Raj's Ica06 Settings:<?php
    echo $_SESSION['username'];
    ?></h1>
    </header>  
    
    <form action="settings.php" id="myForm" method="POST">
    <label for="user">Username:</label>
        <input type="text" name="user" id="userId"><br>
        <label for="pass">Password:</label>
        <input type="text" name="pass" id="passId"><br>
        <input type="button" name="submit" id="submit" value="Add Users">
</form>
    
    <table id="userTable">
        <thead>
            <td style="width: 20px">OP</td>
            <td style="width: 20px">userID</td>
            <td style="width: 80px">UserName</td>
            <td style="width: 200px">Encrypted Password</td>
        </thead>
        <tbody>

        </tbody>
    </table>

    <section id="status">
    <?php
    echo "Status". $mysqli_status;
    ?>
    </section>
    
    <footer id="footer">
        ©2020 by Raj<br>
     <div id="output">No content yet</div>
        <section >
        <script >
            var d = new Date();
            document.getElementById("footer").innerHTML = "last Modified On: "+d.toLocaleString();
         </script>
        </section>
    </footer>
</body>
</html>