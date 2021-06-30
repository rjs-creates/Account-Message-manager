<?php

require_once "./inc/db.php";
require_once "functions.php";

if(!isset($_SESSION['username']))
{
    header("location:login.php");
    die();
}

header("Cache-Control: no-cache, must re-validate");
header("Expires: Sat,26 Jul 1997 05:00:00 GMT");

$ajaxData = array();
$Status = "";

if( isset($_GET['action'] ) && $_GET['action'] == 'GetUsers')
{
    Done();
}

if(isset($_POST['action']) && $_POST['action'] == 'AddUser'&&
isset($_POST["user"] ) && isset($_POST["pass"] ))
{
    $user = strip_tags($_POST['user']);
    $password = password_hash(strip_tags($_POST['pass']),PASSWORD_DEFAULT);
    $rowsAffected = Add($user,$password);
    echo "<br/>$rowsAffected rows affected!";
}

if(isset($_POST['action']) && $_POST['action'] == 'DeleteUser' && isset($_POST["userID"]))
{
    $userID = intval($_POST["userID"]);
    if($_SESSION['userID'] == $_POST["userID"])
    $mysqli_status = "Dont delete yourself";
    else
    $rowsAffected = Delete($userID);
    echo "<br/>$rowsAffected rows affected!";
}


if(isset($rowsAffected))
{
    echo "<br/>$rowsAffected rows affected!";
}
else
{
    echo Done();
}

function Delete($userID)
{
    $query = "DELETE FROM users WHERE ";
    $query .= "userID = $userID";
    return mysqliNonQuery($query);
}

function Add($name,$pass)
{
    $query = "INSERT INTO users (username, password)";
    $query .= " VALUES('$name', '$pass')";
    return mysqliNonQuery($query);
}

function Done()
{
    global $ajaxData,$Status;
    $outArray = array();
       
    $query = "SELECT *";
    $query .= " FROM users";

    if($result = mysqliQuery($query))
    {
        $NumRows = $result->num_rows;
        while($row = $result->fetch_assoc())
        {
            $outArray[] = $row;
        }
        $Status = "Number of users: {$NumRows}";
    }
    else
    {
        $Status = "Fail: Action Failed to match";
    }
    $ajaxData['data'] = $outArray;
    $ajaxData['status'] = $Status;

    echo json_encode($ajaxData);
    die();
}


