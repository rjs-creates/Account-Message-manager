<?php
session_start();
$mysqli = null;
$mysqli_response = array();
$mysqli_status ="";

sqlConnect();

function sqlConnect()
{
    global $mysqli,$mysqli_response,$mysqli_status;

    $mysqli = new mysqli('localhost','r25rrrrr_raj','rajeshwar600','r25rrrrr_user_DB'); 


    if($mysqli -> connect_error)
    {
        $mysqli_response[] = "Connect Error {". $mysqli->connect_errno."}". $mysqli->connect_error;
        echo json_encode($mysqli_response);
        die();
    }
}

function mysqliQuery($q)
{
    global $mysqli,$mysqli_response,$mysqli_status;
    $result = false;
    if($mysqli == null)
    {
        $mysqli_status = "no mysqli";
        return $result;
    }

    if(!($result = $mysqli->query($q)))
    {
        $mysqli_response[] = "mysqliQuery:Error {$mysqli->errno} : {$mysqli->error}";
    }
    return $result;
}

function mysqliNonQuery($q)
{
    global $mysqli, $mysqli_response, $mysqli_status;	// register the globals
	
	$result = 0; // initialize our result, representing number of affected rows = 0
	if ( $mysqli == null )
    {
        $mysql_response[] = "No active database connection!";
        echo json_encode($mysql_response);
        die();
    }
	if (!($result = $mysqli->query($q))) // Execute query, assign result, determine success
	{
		// NOT successful, update response with error message 
		$mysqli_response[] = "mysqliNonQuery:Error {$mysqli->errno} : {$mysqli->error}";
		echo json_encode($mysqli_response);
        die();
	}
	return $mysqli->affected_rows; // OK, return the rows affected
}