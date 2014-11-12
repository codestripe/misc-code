<?php
/**
 *
 * registration.class.php
 *
 * @author Vikeer Jaichand
 *
 * Receives requests from an android device and stores the user in the database.
 *
 */

// -- Include our main config
require_once("functions.database.class.php");
require_once("gcm.class.php");

// -- Instantiate DB with custom functions and our gcm class
$db  = new CustomDatabaseMethods();
$gcm = new GCM();

// -- JSON from response
$json = array();

// -- Check if required post data is there
if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['regId']))
{
    
    $name = $_POST["name"];
    $email = $_POST["email"];
    $gcm_regid = $_POST["regId"];

    $db_result = $db->StoreUserData($name, $email, $gcm_regid);

    $registration_id = array($gcm_regid);
    $message         = array("key", "value");

    $result = $gcm->SendNotification($registration_id, $message);

    echo $result;
}
else
{
    echo "Error: A required parameter is missing. Please check all fields exist.";
}