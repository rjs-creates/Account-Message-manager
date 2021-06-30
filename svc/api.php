<?php
// put your required requires here
require_once '../inc/db.php';
require_once 'abstract.php';  // include our base abstract class

class MyAPI extends API {

  // Since we don't allow CORS, we don't need to check Key Tokens
  // We will ensure that the user has logged in using our SESSION authentication
  // Constructor - use to verify our authentication, uses _response
  public function __construct($request, $origin) {
    parent::__construct($request);

    // Uncomment for authentication verification with your session
    //if (!isset($_SESSION["userID"]))
    //  return $this->_response("Get Lost", 403);
  }

  /**
   * Example of an Endpoint/MethodName 
   * - ie tags, messages, whatever sub-service we want
   * - IN this case test will be the endpoint,
   *   can have more than one for different rest calls
   *   should be named something appropriate - /restDir/cars.. etc
   */
  protected function cars() {
    // TEST BLOCK - comment out once validation to here is verified
    $resp["method"] = $this->method;
    $resp["request"] = $this->request;
    $resp["putfile"] = $this->file;
    $resp["verb"] = $this->verb;
    $resp["args"] = $this->args;
    
    // comment out for proper functionality
    // return $resp; // Use this return to validate processing
    if( $this->method == "GET")
    {
      // verb will be filter
     return $resp;
      //return GetCars( $this->verb );
    }
  }

    protected function messages() {
      // TEST BLOCK - comment out once validation to here is verified
      $resp["method"] = $this->method;
      $resp["request"] = $this->request;
      $resp["putfile"] = $this->file;
      $resp["verb"] = $this->verb;
      $resp["args"] = $this->args;
      
      // comment out for proper functionality
      // return $resp; // Use this return to validate processing
      if( $this->method == "GET")
      {
        return GetMessages($this->verb);
      }
      else if($this->method == "POST")
      {
        return PostMessage($this->verb);
      }
      else if($this->method == "DELETE" && count($resp["args"])==1)
      {
        return DeleteMessage($resp["args"][0]);
      }
  }
}

function DeleteMessage($keyid)
{
    $query = "DELETE FROM messages WHERE ";
    $query .= "messageID = $keyid";
    return mysqliNonQuery($query);
}

function PostMessage($data)
{
  $message = $data;
  $userID = $_SESSION['userID'];

  $query = "INSERT INTO messages (userID, messageTime, message)";
  $query .= "VALUES('$userID',SYSDATE(),'$message')";
  return mysqliNonQuery($query);
}

// Add Endpoints for processing here as Methods for CRUD
function GetCars( $filter )
{
  $out = array();
  $out['filter'] = $filter;
  $out[$filter] = array( 'boxter', '911', '944');

  $jsonData = array();
  $jsonData['status'] = "Cars:GetCars:{$filter} - success";
  $jsonData['data'] = $out;

  return $jsonData;
}

// Executable API Call
// The actual functionality block here
try {
  // Construct instance of our derived handler here
  $API = new MyAPI($_REQUEST['request'], $_SERVER['HTTP_ORIGIN']);
  // invoke our dynamic method, should find the endpoint requested.
  echo $API->processAPI();
} catch (Exception $e) { // OOPs - Houston, we have a problem
  echo json_encode(Array('error' => $e->getMessage()));
}

function GetMessages( $filter )
{
  $outArray = array();
  $Status = "Nope";
  $query = "SELECT username,message,messageID,messageTime FROM `users` inner join `messages` on users.userID=messages.userID WHERE username LIKE '%$filter%' OR message LIKE '%$filter%'";
  //$query .= "WHERE username LIKE '%$filter%' OR message LIKE '%$filter%'";
  
  //"SELECT messageID, messages.userID, username, message, messageTime FROM `messages` JOIN `users` ON users.userID = messages.userID WHERE message LIKE '%$verb%' OR username LIKE '%$verb%'";
  if($result = mysqliQuery($query))
    {
        $NumRows = $result->num_rows;
        while($row = $result->fetch_assoc())
        {
            $outArray[] = $row;
        }
        $Status = "Number of Rows Affected: {$NumRows} ";
    }
    else
    {
        $Status = "Fail: Action Failed to match";
    }

  $jsonData = array();
  $jsonData['status'] = $Status;
  $jsonData['data'] = $outArray;

  return $jsonData;
}