<?php

/**
 *
 * database.class.php
 *
 * @author Vikeer Jaichand
 *
 * Very basic class for PDO CRUD functions
 *
 */

// -- Pull in configurations from config.php
include_once("config.php");

class Database {

	// -- DB connection variables
	private $db_host = DB_HOST;
	private $db_name = DB_NAME;
	private $db_user = DB_USER;
	private $db_pass = DB_PASS;

	// -- Database handler and potential errors
	private $dbh;
	private $error;

	// -- Handler for statements
	private $statement;

	public function __construct() 
	{

		// -- Set Database Source Name (DSN)
		$dsn = 'mysql:host=' . $this->db_host . ';dbname=' . $this->db_name;

		// -- Set options
		$options = array(
    		PDO::ATTR_PERSISTENT => true, 
    		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
		);

		// -- Try connect to create PDO instance
		try
		{
    		$this->dbh = new PDO($dsn, $this->db_user, $this->db_pass, $options);
		}
		// -- Catch errors
		catch (PDOException $e) 
		{
    		$this->error = $e->getMessage();
		}

	}

	// -- Create the query method
	public function Query($query)
	{
		$this->statement = $this->dbh->prepare($query);
	}

	// -- Bind input with placeholders that were put in place
	public function Bind($param, $value, $type = null)
	{
		if (is_null($type))
		{
			switch (true)
			{
		    	case is_int($value):
		      		$type = PDO::PARAM_INT;
		      		break;
		    	case is_bool($value):
		      		$type = PDO::PARAM_BOOL;
		      		break;
		    	case is_null($value):
		      		$type = PDO::PARAM_NULL;
		      		break;
		    	default:
		      		$type = PDO::PARAM_STR;
		  	}
		}

		$this->statement->bindValue($param, $value, $type);
	}

	// -- Execute prepared statement
	public function Execute()
	{
    	return $this->statement->execute();
	}

	// -- Return array of resultset rows.	
	public function ResultSet()
	{
 	   	$this->execute();
    	return $this->statement->fetchAll(PDO::FETCH_ASSOC);
	}

	// -- Return a single record from the DB
	public function Single()
	{
 		$this->execute();
    	return $this->statement->fetch(PDO::FETCH_ASSOC);
	}

	// -- Return number of affected rows from last delete 
	public function RowCount()
	{
 		return $this->statement->rowCount();
	}

	// -- Return last insert ID as a string
	public function LastInsertId()
	{
 		return $this->dbh->lastInsertId();
	}

	// -- Run multiple changes to a db in a single batch
	public function BeginTransaction()
	{
 		return $this->dbh->beginTransaction();
	}

	public function EndTransaction()
	{
    	return $this->dbh->commit();
	}

	public function CancelTransaction()
	{
 		return $this->dbh->rollBack();
	}

	// -- Dump info contained in the prepared statement
	public function DebugDumpParams()
	{
 		return $this->statement->debugDumpParams();
	}

}