<?php 
require_once "./inc/db.php";

function Validate($inputArr)
{
    global $mysqli,$mysqli_response,$mysqli_status;
    $username = $mysqli->real_escape_string($inputArr["username"]);
    $password = $mysqli->real_escape_string($inputArr["password"]);
    $query = "select * from users where username ='$username'";
    $outPut = mysqliQuery($query);

    if(isset($inputArr["username"]) && $outPut)
    {
        $response = false;
        $NumRows = $outPut->num_rows;
        while($row = $outPut->fetch_assoc())
        {
            $outArray[] = $row;
        }
        for($i = 0; $i < count($outArray);$i++)
        {
            if(password_verify($password,$outArray[$i]['password']))
            {
                $response = true;
                $_SESSION['userID'] = $outArray[$i]['userID'];
            }            
        }
        
        if($response)
        {
            $_SESSION['username'] = $inputArr["username"];       
            $inputArr['response'] = "Correct Password";
            $inputArr['status'] = true;
        }
        else
        {
            $inputArr['response'] = "Incorrect password";
            $inputArr['status'] = false;
        }
    }
    else
    {
        $inputArr['response'] = "Failed to find {$inputArr["response"]}";
        $inputArr['status'] = false;
    }

    return $inputArr;
}
