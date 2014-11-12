<?php
/**
 *
 * gcm.class.php
 *
 * @author Vikeer Jaichand
 *
 * Send push notification requests to the GCM server.
 *
 */

// -- Include our main config
require_once("config.php");

class GCM {

	public function SendNotification($registration_id, $message)
	{
		// -- Set POST variables, URL and headers to send to GCM
		$url     = 'http://android.googleapis.com/gcm/send';

		$headers = array(
			'Authorization: key=' . GOOGLE_API_TOKEN,
			'Content-Type: application/json'
		); 

		$fields  = array(
			'registration_ids' => $registration_id,
			'data'             => $message
		);

		// -- Use cURL for request
		$ch = curl_init();

		// -- Set cURL request params
		curl_setopt($ch, CURLOPT_URL,  $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		// -- SSL Cert Support, should be temporarily disabled
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

		// -- Add our POST data fields
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

		// -- Execute cURL
		$result = curl_exec($ch);
        if ($result === FALSE)
        {
            die('cURL failed: ' . curl_error($ch));
        }
 
        // -- Close connection
        curl_close($ch);
        echo $result;
	}

}