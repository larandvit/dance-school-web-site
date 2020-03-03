<?php
	require_once('db-connect.php');
	
	class user
	{
		public $loginName;
		public $hashedPassword;
		public $firstName;
		public $lastName;
		public $id;
		
		public function Verify($password)
		{
			$isVerified=false;
			
			if(isset($this->loginName) and isset($this->hashedPassword))
			{
				$isVerified=password_verify($password, $this->hashedPassword);
			}
			
			return $isVerified;
		}
	}
	
	function retrieveUser($loginName, $isService=false)
	{
		$user=new user();
	
		$errorType=null;
		$errorDesc=null;
		$connection=null;
	
		if($isService)
		{
			$connection = dbConnectService($errorType, $errorDesc);
		}
		else
		{
			$connection = dbConnect($errorType, $errorDesc);
		}
	
		if (!$connection)
		{
			//it can be shown an error message for troubleshooting
			die("Error type: " . $errorType . " Error description: " . $errorDesc);
		}
		else
		{
			$sql = "SELECT LoginName" .
						 ",Password" .
						 ",FirstName" .
						 ",LastName" .
						 ",Id" .
						 " " .
					"FROM users " .
					"WHERE LoginName=\"" . $loginName . "\" " .
					"LIMIT 1";
				
			if ($result=$connection->query($sql)) {
					
				while ($row = $result->fetch_object()) {
						
					$user->loginName=$row->LoginName;
					$user->hashedPassword=$row->Password;
					$user->firstName=$row->FirstName;
					$user->lastName=$row->LastName;
					$user->id=$row->Id;
				}
					
				/* free result set */
				$result->free_result();
			}
				
				
			/* close connection */
			$connection->close();
		}
	
		return $user;
	}
?>