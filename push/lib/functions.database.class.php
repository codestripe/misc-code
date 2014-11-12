<?php

/**
 *
 * functions.database.class.php
 *
 * @author Vikeer Jaichand
 *
 * Custom database methods for this push project
 *
 */

// -- Include main database class
require_once("database.class.php");

Class CustomDatabaseMethods {

    // -- Construct
	public function __construct()
	{
		// -- Instantiate PDO for our purposes
		$this->db = new Database();
	}


	
	// -- Insert user into the table
	public function StoreUserData($name, $email, $gcm_id)
	{

		// -- Step 1 - Prepare the Query
		$this->db->Query(
			"INSERT INTO google_cloud_users (name, email, gcm_regid)
			 VALUES (:name, :email, :gcm_id)"
		);

		// -- Step 2 - Bind input values to be inserted
		$this->db->Bind(":name",   $name);
		$this->db->Bind(":email",  $email);
		$this->db->Bind(":gcm_id", $gcm_id);

		// -- Step 3 - Execute the PDO
		$this->db->Execute();
	}


	// -- Return all users in the table
	public function GetAllUsers()
	{

		// -- Step 1 - Prepare the Query
		$this->db->Query(
			"SELECT * FROM google_cloud_users"
		);

		// -- Step 2 - Get results
		$result = $this->db->ResultSet();

		// -- Step 3 - Return
		return $result;

	}

}