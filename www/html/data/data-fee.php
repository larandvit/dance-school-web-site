<?php
	require_once('db-connect.php');
	
	/*
	 Fees array structure
	 [0] - period name
	 [1] - first class
	 [2] - end class
	 [3] - Post dated cheques
    	Array elements
    		[0] - checque date
     [4] - Deadline full session payment
     [5] - Session duration
     [6] - Makeup lessons
        Array elements
    		[0] - cheque date
     [7] - Id
     [8] - Merged periods
     [9] - Merged periods header text
     [10] - Fee periods
        Array elements
            [0] - 3 letters of month name
     [11] - group lessons fee
        Array elements
            [0] - FeeId
            [1] - Duration
            [2] - Payments
            [3] - ShowFee
            [4] - FeeOrder
            [5] - Id
     [12] - private lessons fee
        Array elements
            [0] - FeeId
            [1] - Level
            [2] - Payments
            [3] - ShowFee
            [4] - FeeOrder
            [5] - Id
     [13] - special instructions
        Array elements
            [0] - FeeId
            [1] - LineText
            [2] - ShowFee
            [3] - FeeOrder
            [4] - Id
	*/
	
	function showFees()
	{
	    $filter = " and ShowFee=1" . " ";
	    return retrieveFees(false, $filter);
	}
	
	function serviceFees()
	{
	    $filter = " ";
	    
	    return retrieveFees(true, $filter);
	}
        
	function retrieveFees($isService=false, $filter)
	{
		$fees=array();
	
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
		    $sql = "SELECT PeriodName" .
		                 ",FirstClass" .
		                 ",LastClass" .
		                 ",PostDatedCheques" .
		                 ",DeadlineFullSessionPayment " .
		                 ",SessionDuration " .
		                 ",MakeupLessons " .
		                 ",MergedPeriods " .
		                 ",Id " .
		           "FROM fee ";
				
			if ($result=$connection->query($sql)) {

				while ($row = $result->fetch_object()) {
					
				    $fee = array();
				    
				    $feeId=$row->Id;
				    $postDatedCheques = explode(";" ,$row->PostDatedCheques);
                    
				    //Main array[0]
                    array_push($fee, $row->PeriodName);
                    //Main array[1]
                    array_push($fee, $row->FirstClass);
                    //Main array[2]
                    array_push($fee, $row->LastClass);
                    //Main array[3]
                    array_push($fee, $postDatedCheques);
                    //Main array[4]
                    array_push($fee, $row->DeadlineFullSessionPayment);
                    //Main array[5]
                    array_push($fee, $row->SessionDuration);
                    //Main array[6]
                    array_push($fee, explode(";" ,$row->MakeupLessons));
                    //Main array[7]
                    array_push($fee, $feeId);
                    //Main array[8]
                    $mergedPeriods = explode(";" ,$row->MergedPeriods);
                    array_push($fee, $mergedPeriods);
                    
                    $mergedPeriodsHeaderText = "";
                    $space = "";
                    $mergedPeriodsCount = sizeof($mergedPeriods);
                    if($mergedPeriodsCount>0){
                        foreach($mergedPeriods as $mergedPeriod){
                            $mergedPeriodsHeaderText = $mergedPeriodsHeaderText . $space . substr(trim($mergedPeriod),0,3);
                            $space = " & ";
                        }
                    }
                    //Main array[9]
                    array_push($fee, $mergedPeriodsHeaderText);
                    
                    $checqueCount = sizeof($postDatedCheques);
                    $feePeriods = array();
                    if($mergedPeriodsHeaderText=="") {
                        for($i=0; $i<$checqueCount; $i++ ){
                            array_push($feePeriods, substr(trim($postDatedCheques[$i]),0,3));
                        }
                    }
                    else {
                        for($i=0; $i<$checqueCount; $i++ ){
                            $headerText = substr(trim($postDatedCheques[$i]),0,3);
                            
                            if($headerText==substr($mergedPeriodsHeaderText, 0, 3))
                            {
                                $headerText = $mergedPeriodsHeaderText;
                            }
                            array_push($feePeriods, $headerText);
                        }
                    }
                    //Main array[10]
                    array_push($fee, $feePeriods);
				    
                    $sql = "SELECT FeeId" .
                                 ",Duration" .
                                 ",Payments" .
                                 ",ShowFee" .
                                 ",FeeOrder" .
                                 ",Id " .
                           "FROM fee_group_lessons " .
                           "WHERE FeeId=" . $feeId .
                                  $filter .
                           "ORDER BY FeeOrder" .
                                    ",Id;";
                    
                    $feeGroupLessons = array();
                    
                    if ($resultFeeGroupLessons=$connection->query($sql)) {
                        while ($rowFeeGroupLessons = $resultFeeGroupLessons->fetch_object()) {
                            $row_array=array($rowFeeGroupLessons->FeeId,
                                             $rowFeeGroupLessons->Duration,
                                             $rowFeeGroupLessons->Payments,
                                             $rowFeeGroupLessons->ShowFee,
                                             $rowFeeGroupLessons->FeeOrder,
                                             $rowFeeGroupLessons->Id
                            );
                            //Main array[9]
                            array_push($feeGroupLessons, $row_array);
                            
                        }
                        $resultFeeGroupLessons->free_result();
                    }
                    
                    //Main array[11]
                    array_push($fee, $feeGroupLessons);
                    
                    $sql = "SELECT FeeId" .
                                 ",Level" .
                                 ",Payment" .
                                 ",ShowFee" .
                                 ",FeeOrder" .
                                 ",Id" . " " .
                           "FROM fee_private_lessons " .
                           "WHERE FeeId=" . $feeId .
                                  $filter .
                           "ORDER BY FeeOrder" .
                                   ",Id;";

                    $privateLessons = Array();
                    
                    if ($resultPrivateLessons=$connection->query($sql)) {
                        while ($rowPrivateLessons = $resultPrivateLessons->fetch_object()) {
                            $row_array=array($rowPrivateLessons->FeeId,
                                             $rowPrivateLessons->Level,
                                             $rowPrivateLessons->Payment,
                                             $rowPrivateLessons->ShowFee,
                                             $rowPrivateLessons->FeeOrder,
                                             $rowPrivateLessons->Id);
                                array_push($privateLessons, $row_array);
                            
                            
                        }
                        $resultPrivateLessons->free_result();
                    }
                    //Main array[12]
                    array_push($fee, $privateLessons);
                    
                    $sql = "SELECT FeeId" .
                                 ",LineText" .
                                 ",ShowFee" .
                                 ",FeeOrder" .
                                 ",Id" . " " .
                            "FROM fee_special_instructions " .
                            "WHERE FeeId=" . $feeId .
                                   $filter .
                            "ORDER BY FeeOrder" .
                                    ",Id;";
                    
                    $specialInstructions = Array();
                    
                    if ($resultSpecialInstructions=$connection->query($sql)) {
                        while ($rowSpecialInstructions = $resultSpecialInstructions->fetch_object()) {
                            $row_array=array($rowSpecialInstructions->FeeId,
                                             $rowSpecialInstructions->LineText,
                                             $rowSpecialInstructions->ShowFee,
                                             $rowSpecialInstructions->FeeOrder,
                                             $rowSpecialInstructions->Id);
                            array_push($specialInstructions, $row_array);
                            
                            
                        }
                        $resultSpecialInstructions->free_result();
                    }
                    //Main array[13]
                    array_push($fee, $specialInstructions);
                    
                    array_push($fees, $fee);
 				}
					
				/* free result set */
				$result->free_result();
			}
				
			/* close connection */
			$connection->close();
		}

		return $fees;
	}
	
	function writePaymentInformation($periodName,
                            	     $firstClass,
                            	     $lastClass,
                            	     $postDatedCheques,
                            	     $deadlineFullSessionPayment,
                            	     $sessionDuration,
                            	     $mergedPaymentPeriods,
                            	     $makeupLessons,
                            	     $Id,
    			                     $isService=true)
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
			$sql = "UPDATE fee ".
				   "SET PeriodName=?" .
					  ",FirstClass=?" .
					  ",LastClass=?" .
					  ",PostDatedCheques=?" .
					  ",DeadlineFullSessionPayment=?" .
					  ",SessionDuration=?" .
					  ",MakeupLessons=?" .
					  ",MergedPeriods=?" .
					  " " .
					"WHERE Id=?" . " ";
			
			$stmt = $connection->prepare($sql);
			
			$stmt->bind_param("ssssssssi"
            			    ,$periodName
            			    ,$firstClass
            			    ,$lastClass
            			    ,$postDatedCheques
            			    ,$deadlineFullSessionPayment
            			    ,$sessionDuration
            			    ,$makeupLessons
			                ,$mergedPaymentPeriods
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
	
	function writeGroupLessons($feeId, $feeGroupLessons, $isService=true)
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
	            
            $sql = "UPDATE fee_group_lessons ".
                   "SET FeeId=?" .
    	   	          ",Duration=?" .
    	   	          ",Payments=?" .
    	   	          ",ShowFee=?" .
    	   	          ",FeeOrder=? " . 
                   "WHERE Id=?";
	        
	        $stmt = $connection->prepare($sql);
	        
	        foreach($feeGroupLessons as $feeGroupLesson)
	        {
    	        
                $stmt->bind_param("issiii"
                                 ,$feeId
                                 ,$feeGroupLesson[0]
                                 ,$feeGroupLesson[1]
                                 ,$feeGroupLesson[2]
                                 ,$feeGroupLesson[3]
                                 ,$feeGroupLesson[4]);
    	        
    	        $stmt->execute();
    	        
    	        if($stmt->errno!=0)
    	        {
    	            $errorType=$stmt->errno;
    	            $errorDesc=$stmt->error;
    	            
    	            array_push($errors, "Error type: " . $errorType . " Error description: " . $errorDesc);
    	        }
	        }
	        
	        /* closte statemnet */
	        $stmt->close();
	        
	        /* close connection */
	        $connection->close();
	    }
	    
	    return $errors;
	}
	
	function writePrivateLessons($feeId, $feePrivateLessons, $isService=true)
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
	        
	        $sql = "UPDATE fee_private_lessons ".
	   	        "SET FeeId=?" .
	   	        ",Level=?" .
	   	        ",Payment=?" .
	   	        ",ShowFee=?" .
	   	        ",FeeOrder=? " .
	   	        "WHERE Id=?";
	        
	        $stmt = $connection->prepare($sql);
	        
	        foreach($feePrivateLessons as $feePrivateLesson)
	        {
	            
	            $stmt->bind_param("issiii"
            	                 ,$feeId
            	                 ,$feePrivateLesson[0]
            	                 ,$feePrivateLesson[1]
            	                 ,$feePrivateLesson[2]
            	                 ,$feePrivateLesson[3]
            	                 ,$feePrivateLesson[4]);
	            
	            $stmt->execute();
	            
	            if($stmt->errno!=0)
	            {
	                $errorType=$stmt->errno;
	                $errorDesc=$stmt->error;
	                
	                array_push($errors, "Error type: " . $errorType . " Error description: " . $errorDesc);
	            }
	        }
	        
	        /* closte statemnet */
	        $stmt->close();
	        
	        /* close connection */
	        $connection->close();
	    }
	    
	    return $errors;
	}
	
	function writeSpecialInstructions($feeId, $specialInstructions, $isService=true)
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
	        
	        $sql = "UPDATE fee_special_instructions ".
	   	        "SET FeeId=?" .
	   	        ",LineText=?" .
	   	        ",ShowFee=?" .
	   	        ",FeeOrder=? " .
	   	        "WHERE Id=?";
	        
	        $stmt = $connection->prepare($sql);
	        
	        foreach($specialInstructions as $specialInstruction)
	        {
	            
	            $stmt->bind_param("isiii"
	                ,$feeId
	                ,$specialInstruction[0]
	                ,$specialInstruction[1]
	                ,$specialInstruction[2]
	                ,$specialInstruction[3]);
	            
	            $stmt->execute();
	            
	            if($stmt->errno!=0)
	            {
	                $errorType=$stmt->errno;
	                $errorDesc=$stmt->error;
	                
	                array_push($errors, "Error type: " . $errorType . " Error description: " . $errorDesc);
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