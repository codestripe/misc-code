<?php
/**
 *
 * sendmessage.class.php
 *
 * @author Vikeer Jaichand
 *
 * Send push notification to the Android Device via GCM Server
 *
 */

// -- Include our gcm class
require_once("gcm.class.php");

// -- Instantiate gcm class
$gcm = new GCM();

if (isset($_GET["reg_id"]) && isset($_GET["message"]))
{
    $reg_id = $_GET["reg_id"];
    $message = $_GET["message"];

    $registration_id  = array($reg_id);
    $message          = array("message_to_send" => $message);

    $result = $gcm->SendNotification($registration_id, $message);

    echo $result;
}