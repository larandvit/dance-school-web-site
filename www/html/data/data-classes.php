<?php
	require_once('db-connect.php');
	
	class DanceClass
	{
	    public $className;
	    public $colorName;
	    public $coachName;
	    public $id;
	}
	
	function retrieveColorNames($isService=true)
	{
		$colors=array();
		
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
			//die("Error type: " . $errorType . " Error description: " . $errorDesc);
		}
		else 
		{
			$sql = "SELECT ColorName" .
					     " " .
		           "FROM color_name " .
				   "ORDER BY Id";
			
			if ($result=$connection->query($sql)) {
			
				while ($row = $result->fetch_object()) {
					
				    array_push($colors, $row->ColorName);
				}
			
				/* free result set */
				$result->free_result();
			}
			
			
			/* close connection */
			$connection->close();
		}
		
		return $colors;
	}
	
	function retrieveClasses($isService=true)
	{
	    $classes=array();
	    
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
	        //die("Error type: " . $errorType . " Error description: " . $errorDesc);
	    }
	    else
	    {
	        $sql = "SELECT ClassName" .
	   	        ",ColorName" .
	   	        ",CoachName" .
	   	        ",Id" .
	   	        " " .
	   	        "FROM dance_class " .
	   	        "ORDER BY Id";
	        
	        if ($result=$connection->query($sql)) {
	            
	            while ($row = $result->fetch_object()) {
	                
	                $class = new DanceClass();
	                
	                $class->className = $row->ClassName;
	                $class->colorName = $row->ColorName;
	                $class->coachName = $row->CoachName;
	                $class->id = $row->Id;
	                
	                array_push($classes, $class);
	            }
	            
	            /* free result set */
	            $result->free_result();
	        }
	        
	        
	        /* close connection */
	        $connection->close();
	    }
	    
	    return $classes;
	}
	
	function writeClass($className
                	   ,$coachName
                	   ,$colorName
                	   ,$Id
					   ,$isService=true)
	{
		$errorType=0;
		$errorDesc="";
	
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
			//die("Error type: " . $errorType . " Error description: " . $errorDesc);
		}
		else
		{
			$sql = "UPDATE dance_class ".
				   "SET ClassName=?" .
					  ",CoachName=?" .
					  ",ColorName=?" .
					  " " .
				   "WHERE Id=?" . " ";
				
			$stmt = $connection->prepare($sql);
				
			$stmt->bind_param("sssi"
            			     ,$className
            			     ,$coachName
            			     ,$colorName
            			     ,$Id);
				
			$stmt->execute();
				
			if($stmt->errno!=0)
			{
				$errorType=$stmt->errno;
				$errorDesc=$stmt->error;
			}
				
			/* closte statemnet */
			$stmt->close();
			/* close connection */
			$connection->close();
		}
	
		$fullError="";
	
		if($errorType!=0)
		{
			$fullError="Error type: " . $errorType . " Error description: " . $errorDesc;
		}
	
		return $fullError;
	}
?>