<?php
    require_once "functions.php";
    $pageStatus;
    if (isset($_POST["submit"]) && $_POST["submit"] == "logout" )
    {
        session_unset();
        session_destroy();
        header("Location:index.php");
        die();
    }

    if ( isset($_POST["submit"]) && $_POST["submit"] == "login" 
        && isset($_POST["user"])&& strlen($_POST["user"]) > 0
        && isset($_POST["pass"])&& strlen($_POST["pass"]) > 0 )
        {
            $myuser = array();
            $myuser["username"] = strip_tags($_POST["user"]);
            $myuser["password"] = strip_tags($_POST["pass"]);
            $myuser["response"] = "";
            $myuser["status"] = false;

            $myuser = Validate($myuser);

            if($myuser["status"] == true)
            {
                $_SESSION["user"] = $myuser["username"];
                header("Location:index.php");
                die();
            }
            else
            {
                global $pageStatus;
                $pageStatus = "Login failed :". $myuser["response"];
            }
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
    <title>Login</title>
</head>
<body id="grid1">
    <header id="Head">
        <h1>Raj's Ica06 Login</h1>
    </header>  
    
    <form action="login.php" id="myForm" method="POST">
        <label for="user">Username:</label>
        <input type="text" name="user" id="userId"><br>
        <label for="pass">Password:</label>
        <input type="text" name="pass" id="passId"><br>
        <input type="submit" name="submit" value="login">
    </form>
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