<?php
	function dbConnect(&$error_type, &$error_desc) 
	{
		return connect($error_type,$error_desc,false);
	}
	
	function dbConnectService(&$error_type, &$error_desc)
	{
		return connect($error_type,$error_desc,true);
	}
	
	function connect(&$error_type, &$error_desc, $isService) {
	
		//track any errors
		// 0 - no error
		// 1 - error in reading config file
		// 2 - connection error
		$error_type=0;
		$error_desc="success";
	
		$connection=false;
	
	
		// Load configuration as an array. Use the actual location of your configuration file
		if($isService)
		{
			$config = parse_ini_file('../../../config.ini');
		}
		else 
		{
			$config = parse_ini_file('../../config.ini');
		}
		if(!$config)
		{
			$error_type=1;
			$error_desc="Error in reading database access config file";
		}
		else
		{
			$connection = mysqli_connect($config['servername'],$config['username'],$config['password'],$config['dbname']);
				
			if(!$connection)
			{
				$error_type=2;
				$error_desc=mysqli_connect_error();
			}
		}
			
		return $connection;
	}

/*
//Sample how to connect to the database

$error_type=null;
$error_desc=null;
$connection = db_connect($error_type, $error_desc);

// Check connection
if (!$connection) {
	die("Connection failed: " . $error_desc);
}
else 
{
	echo "success";
	
	//after retrieving or modifying data. close connection 
	mysql_close($connection);
}
*/

?>