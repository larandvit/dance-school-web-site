<?php
	require_once('db-connect.php');
	
	/*
	 Schedules array structure
	 [0] - schedule name
	 [1] - first class
	 [2] - end class
	 [3] - each day schedule array
    	Array elements
    		[0] - week day name
    		[1] - class name
    		[2] - time from
    		[3] - time to
    		[4] - color name
    		[5] - day of week Id
    		[6] - claiss Id
     [4] - coach array
     [5] - no classes array
     [6] - array of week day names
     [7] - IsActive
     [8] - ScheduleOrder
     [9] - Id
	*/
	
	function allActiveSchedules()
	{
		return retrieveSchedules("IsActive=1");
	}
	
	function allSchedules()
	{
	    return retrieveSchedules("1=1", true);
	}
	
	function oneSchedule($Id)
	{
        return retrieveSchedules("Id=" . $Id, true);
	}
        
	function retrieveSchedules($filter, $isService=false)
	{
		$schedules=array();
	
		$errorType=null;
		$errorDesc=null;
		
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
		    $sql = "SELECT ScheduleName" .
		                 ",FirstClass" .
		                 ",LastClass" .
		                 ",NoGroupLessons" .
		                 ",Id " .
		                 ",IsActive " .
		                 ",ScheduleOrder " .
		           "FROM schedule " .
		           "WHERE " . $filter . " " .
		           "ORDER BY ScheduleOrder".
		                   ",ScheduleName";
				
			if ($result=$connection->query($sql)) {

				while ($row = $result->fetch_object()) {
					
				    $schedule=array();
				    
				    $scheduleId=$row->Id;
                    
				    //Main array[0]
                    array_push($schedule, $row->ScheduleName);
                    //Main array[1]
                    array_push($schedule, $row->FirstClass);
                    //Main array[2]
                    array_push($schedule, $row->LastClass);
				    
                    $sql = "SELECT w.Name AS DayOfWeekName " .
                                 ",c.ClassName AS ClassName" .
                                 ",TimeFrom" .
                                 ",TimeTo" .
                                 ",c.ColorName" .
                                 ",d.DayOfWeekId AS DayOfWeekId" .
                                 ",d.ClassId AS ClassId " .
                           "FROM schedule_detail d JOIN dayofweek w ON d.DayOfWeekId=w.Id " .
                                                  "JOIN dance_class c ON d.ClassId=c.Id " .
                           "WHERE ScheduleId=" . $scheduleId . " " .
                           "ORDER BY DayOfWeekId" .
                                    ",TimeFrom;";
                    
                    $scheduleDetails=array();
                    
                    if ($resultDetails=$connection->query($sql)) {
                        while ($rowDetails = $resultDetails->fetch_object()) {
                            $row_array=array($rowDetails->DayOfWeekName,
                                             $rowDetails->ClassName,
                                             $rowDetails->TimeFrom,
                                             $rowDetails->TimeTo,
                                             $rowDetails->ColorName,
                                             $rowDetails->DayOfWeekId,
                                             $rowDetails->ClassId
                            );
                            
                            array_push($scheduleDetails, $row_array);
                            
                        }
                        
                        $resultDetails->free_result();
                    }
                    
                    //Main array[3]
                    array_push($schedule, $scheduleDetails);
                    
                    $sql = "SELECT DayOfWeekId" .
                                 ",GROUP_CONCAT(DISTINCT CoachName ORDER BY CoachName DESC SEPARATOR '|') AS Coaches " .
                           "FROM schedule_detail d LEFT JOIN dance_class c ON d.ClassId=c.Id " .
                           "WHERE d.ScheduleId=" . $scheduleId . " " .
                           "GROUP BY DayOfWeekId";

                    $coaches = Array();
                    
                    if ($resultCoaches=$connection->query($sql)) {
                        while ($rowCoaches = $resultCoaches->fetch_object()) {
                            $daycoaches=array_filter(array_unique(explode("|" ,$rowCoaches->Coaches)));
                            sort($daycoaches);
                            array_push($coaches, $daycoaches);
                            
                            
                        }
                        
                        $resultCoaches->free_result();
                    }
                    
                    //Main array[4]
                    array_push($schedule, $coaches);
                    
                    //Main array[5]
                    array_push($schedule,  explode("|" , $row->NoGroupLessons));
                    
                    $sql = "SELECT w.Name " .
                           "FROM schedule_detail d JOIN dayofweek w ON d.DayOfWeekId=w.Id " .
                           "WHERE d.ScheduleId=" . $scheduleId . " " .
                           "GROUP BY DayOfWeekId " .
                           "ORDER BY DayOfWeekId";
                    
                    $weekdays = Array();
                    
                    if ($resultWeekDays=$connection->query($sql)) {
                        while ($rowWeekDays = $resultWeekDays->fetch_object()) {
                            array_push($weekdays, $rowWeekDays->Name);
                            
                        }
                        
                        $resultWeekDays->free_result();
                    }
                    
                    //Main array[6]
                    array_push($schedule, $weekdays);
                    
                    //main array[7]
                    array_push($schedule, $row->IsActive);
                    
                    //main array[8]
                    array_push($schedule, $row->ScheduleOrder);
                    
                    //main array[9]
                    array_push($schedule, $row->Id);
                    
                    //full schedule
                    array_push($schedules, $schedule);
				}
					
				/* free result set */
				$result->free_result();
			}
				
			/* close connection */
			$connection->close();
		}

		return $schedules;
	}
	
	function writeSchedule($ShowSchedule
			              ,$ScheduleName
						  ,$FirstClass
    					  ,$LastClass
    					  ,$NoClasses
    					  ,$ScheduleOrder
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
			$sql = "UPDATE schedule ".
				   "SET IsActive=?" .
					  ",ScheduleName=?" .
					  ",FirstClass=?" .
					  ",LastClass=?" .
					  ",NoGroupLessons=?" .
					  ",ScheduleOrder=?" .
					  " " .
					"WHERE Id=?" . " ";
			
			$stmt = $connection->prepare($sql);
			
			
			$stmt->bind_param("issssii"
			                 ,$ShowSchedule
			                 ,$ScheduleName
							 ,$FirstClass
							 ,$LastClass
							 ,$NoClasses
							 ,$ScheduleOrder
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
	
	function writeScheduleDays($scheduleId, $weekDays, $isService=true)
	{
	    $errors = array();
	    
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
	        $sql = "DELETE FROM schedule_detail WHERE ScheduleId=?;";
	        
	        $stmt = $connection->prepare($sql);
	        
	        $stmt->bind_param("i"
	                         ,intval($scheduleId));
	        
	        $stmt->execute();
	        
	        if($stmt->errno!=0)
	        {
	            $errorType=$stmt->errno;
	            $errorDesc=$stmt->error;
	            
	            array_push($errors, "Error type: " . $errorType . " Error description: " . $errorDesc);
	        }
	        else
	        {
	            /* closte statemnet */
	            $stmt->close(); 
	            
	            $sql = "INSERT INTO schedule_detail ".
    	   	           "(ScheduleId" .
    	   	           ",DayOfWeekId" .
    	   	           ",ClassId" .
    	   	           ",TimeFrom" .
    	   	           ",TimeTo) " .
    	   	           "VALUES(?,?,?,?,?)";
    	        
    	        $stmt = $connection->prepare($sql);
    	        
    	        foreach($weekDays as $weekDay)
    	        {
        	        
    	            //clean up removing all characters except digits, ";", and "|"
    	            $weekDayRefined = preg_replace('/[^0-9;:|]/', '', $weekDay);
    	            
    	            //remove day of week
    	            $weekDayFinal = substr($weekDayRefined,2);
    	            
    	            $dayOfWeek = substr($weekDayRefined,0,1);
    	            
    	            $classes = explode("|", $weekDayFinal);
    	            
    	            foreach($classes as $class)
    	            {
    	                //array_push($errors, $class);
    	                
    	                list($classId, $timeFrom, $timeTo) = explode(";", $class);
        	            
    	                //validation
    	                $validatedSuccessfully = false;
    	                
    	                if((isset($classId) or $classId==0) and isset($timeFrom) and isset($timeTo))
        	            {
        	                if((!$classId=="" or $classId==0) and !$timeFrom=="" and !$timeTo=="")
        	                {
        	                    $validatedSuccessfully = true;
        	                    
        	                    //array_push($errors, "Good class: " . $classId . " " . $timeFrom . " " . $timeTo . " Day: " . $dayOfWeek);
                	            
            	                $stmt->bind_param("iiiss"
            	                                 ,intval($scheduleId)
            	                                 ,intval($dayOfWeek)
            	                                 ,intval($classId)
                            	                 ,$timeFrom
                            	                 ,$timeTo);
                    	        
                    	        $stmt->execute();
                    	        
                    	        if($stmt->errno!=0)
                    	        {
                    	            $errorType=$stmt->errno;
                    	            $errorDesc=$stmt->error;
                    	            
                    	            array_push($errors, "Error type: " . $errorType . " Error description: " . $errorDesc);
                    	        }
        	                }
        	            }
        	            
        	            if(!$validatedSuccessfully)
        	            {
        	                array_push($errors, "Skipped class: " . $class . " Day: " . $dayOfWeek . " - Class: " . $classId . " From: " . $timeFrom . " To: " . $timeTo);
        	            }
    	            }
    	        }
	        }
	        
	        /* closte statemnet */
	        $stmt->close();
	        
	        /* close connection */
	        $connection->close();
	    }
	    
	    return $errors;
	}
?>