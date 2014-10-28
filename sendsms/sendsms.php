<?php

/**
 * Send SMS helper class -
 * Input $number: format 079*******
 * Input $text:   string "Message text here"
 * Returns 0 - unsuccessful, 1 - send successful
 * 
 * @author Vikeer Jaichand <vikeer at jaichand dot com>
 *       
 */

class SMS
{

    /**
     * Send SMS to user -> Number and text using Clickatell API
     *
     * @param string $number The mobile number to send the SMS to.
     * @param string $text   The text message to be sent to the $number 
     * @return integer Where 1 is success and 0 is failure
     */
    public function send_sms($number, $text)
    {
    
        // Define clickatell REST auth variables with Clickatell.
        // These can be defined as globals or constants in a config file and referenced here if desired.
        
        $username = "Insert Clickatell username here";
        $password = "Insert Clickatell password here";
        $api_id = "Clickatell API id goes here";
        $api_url = "http://api.clickatell.com/http/auth";
        $api_send_url = "http://api.clickatell.com/http/sendmsg";

        // Do cURL initialise

        $ch_auth = curl_init();
        curl_setopt($ch_auth, CURLOPT_URL, $api_url);
        curl_setopt($ch_auth, CURLOPT_POST, 3);
        curl_setopt($ch_auth, CURLOPT_POSTFIELDS,"user=$username&password=$password&api_id=$api_id");
        curl_setopt($ch_auth, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch_auth, CURLOPT_SSL_VERIFYPEER, false);
        
        $result = curl_exec($ch_auth);
        curl_close($ch_auth);
        
        // Get cURL Exec result 
        
        $ret = explode(":", $result);
        
        if (strcmp(trim($ret[0]), 'OK') != 0)
        {
            
            // Authentication Unsuccessful.
            return 0;

        } 
        else 
        {
            
            // Authentication Successful - Assign session ID from Clickatell.
            session_id(trim($ret[1]));
            $api_session_id = trim($ret[1]);

        }
        
        // Proceed with Send at this point - Second cURL call
        
        $number = preg_replace('/^0/', '+27', $number);
        $sendtext = urlencode($text);
        $sendnumber = urlencode($number);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$api_send_url);
        curl_setopt($ch, CURLOPT_POST, 3);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "session_id=$api_session_id&to=$sendnumber&text=$sendtext");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $send = curl_exec($ch);
        curl_close($ch);

        $send_ret = explode(':', $send);
        if (strcmp(trim($send_ret[0]), "ID") != 0)
        {

            // Send Unsuccessful.
            return 0;

        }
        else 
        {

            // Send Successful;
            return 1;

        }
    
    }
    
}

// --- Just a simple use case (Delete for production!) and include class as autoloader instead

$sms = new SMS();

$sendresult = $sms->send_sms('0792393315', "Hello Squeak!");

var_dump($sendresult);