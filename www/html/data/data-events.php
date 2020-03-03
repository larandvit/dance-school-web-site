<?php
	require_once('db-connect.php');
	
	/*
	 Array structure
	 
	 There are two arrays. The first one is news list and the second one contains an event:
	 
	 0)show event: 1 or 0
	 1)event date: text in yyyy-mm-dd format
	 2)event caption
	 3)event text
	 4)show event on main page: 1 or 0
	 5)show on main page flag: 
	   0 - only event caption
	   1 - show main page text
	   2 - show "n" characters from event text
	 6)main page event text
	 7)number of characters from event text on main page
	 8)event Id
	*/

	function eventsMainPage()
	{
		return retrieveEvents("ShowEventMainPage=1");
	}
	
	function eventsPage()
	{
		return retrieveEvents("ShowEvent=1");
	}
	
	function eventsServicePage($isRowHtml=fasle)
	{
		return retrieveEvents("1=1", true,$isRowHtml);
	}
	
	function retrieveEvents($filter, $isService=false, $isRawHtml=false)
	{
		$events=array();
	
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
			$sql = "SELECT ShowEvent" .
						 ",EventDate" .
						 ",EventCaption" .
						 ",EventText" .
						 ",ShowEventMainPage" .
						 ",ShowEventMainPageFlag" .
						 ",MainPageEventText" .
						 ",EventTextShowCharsMainPage" .
						 ",Id" .
						 " " .
					"FROM events " .
					"WHERE " . $filter . " " .
					"ORDER BY EventDate DESC";
				
			if ($result=$connection->query($sql)) {
					
				while ($row = $result->fetch_object()) {
					
					$eventText=$row->EventText;
					$mainPageEventText=$row->MainPageEventText;
					
					if($isRawHtml)
					{
						$eventText=htmlspecialchars($eventText);
						$mainPageEventText=htmlspecialchars($mainPageEventText);
					}
					else 
					{
						//ShowMiscPicture macro
						$macroPattern="/ShowMiscPicture\(([^,]+?),([^,]+?)\)/";
						$eventText=preg_replace_callback($macroPattern,
								                         function ($matches) use($isService) {return macro_ShowMiscPicture($matches[1],$matches[2],$isService);},
								                         $eventText);
						$mainPageEventText=preg_replace_callback($macroPattern,
																 function ($matches) use($isService) {return macro_ShowMiscPicture($matches[1],$matches[2],$isService);},
																 $mainPageEventText);
						
						//ShowMiscPictureGoWebSite macro
						$macroPattern="/ShowMiscPictureGoWebSite\(([^,]+?),([^,]+?),([^,]+?)\)/";
						$eventText=preg_replace_callback($macroPattern,
						function ($matches) use($isService) {return macro_ShowMiscPictureGoWebSite($matches[1],$matches[2],$matches[3],$isService);},
						$eventText);
						$mainPageEventText=preg_replace_callback($macroPattern,
								function ($matches) use($isService) {return macro_ShowMiscPictureGoWebSite($matches[1],$matches[2],$matches[3],$isService);},
								$mainPageEventText);
						
						//ShowEmail macro
						$macroPattern="/ShowEmail\(([^,]+?),([^,]+?)\)/";
						$eventText=preg_replace_callback($macroPattern,
								function ($matches) use($isService) {return macro_ShowEmail($matches[1],$matches[2],$isService);},
								$eventText);
						$mainPageEventText=preg_replace_callback($macroPattern,
								function ($matches) use($isService) {return macro_ShowEmail($matches[1],$matches[2],$isService);},
								$mainPageEventText);
						
						//ContactsMississaugaLocation macro
						$macroPattern="ContactsMississaugaLocation()";
						$eventText=str_replace($macroPattern, macro_ContactsMississaugaLocation($isService), $eventText);
						$mainPageEventText=str_replace($macroPattern, macro_ContactsMississaugaLocation($isService), $mainPageEventText);
						
						//ExternalLink macro
						$macroPattern="/ExternalLink\((.+?),(.+?)\)/";
						$eventText=preg_replace_callback($macroPattern,
														 function ($matches) use($isService) {return macro_ExternalLink($matches[1],$matches[2],$isService);},
														 $eventText);
						$mainPageEventText=preg_replace_callback($macroPattern,
																 function ($matches) use($isService) {return macro_ExternalLink($matches[1],$matches[2],$isService);},
																 $mainPageEventText);
						//ContactsApplicationForm macro
						$macroPattern="ContactsApplicationForm()";
						$eventText=str_replace($macroPattern, macro_ContactsApplicationForm($isService), $eventText);
						$mainPageEventText=str_replace($macroPattern, macro_ContactsApplicationForm($isService), $mainPageEventText);
					}
					
					$row_array=array($row->ShowEvent,
									 $row->EventDate,
									 $row->EventCaption,
									 $eventText,
									 $row->ShowEventMainPage,
									 $row->ShowEventMainPageFlag,
									 $mainPageEventText,
									 $row->EventTextShowCharsMainPage,
									 $row->Id
					);
					array_push($events, $row_array);
				}
					
				/* free result set */
				$result->free_result();
			}
				
			/* close connection */
			$connection->close();
		}

		return $events;
	}
	
	function writeEvents($ShowEvent
			            ,$EventDate
						,$EventCaption
						,$EventText
						,$ShowEventMainPage
						,$ShowEventMainPageFlag
						,$MainPageEventText
						,$EventTextShowCharsMainPage
						,$Id
			            ,$isInsert=false
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
			$sql="";
			
			if($isInsert)
			{
				$sql = "INSERT INTO events (ShowEvent" .
										  ",EventDate" .
										  ",EventCaption" .
										  ",EventText" .
										  ",ShowEventMainPage" .
										  ",ShowEventMainPageFlag" .
										  ",MainPageEventText" .
										  ",EventTextShowCharsMainPage)" .
										  " " .
						"VALUES (?,?,?,?,?,?,?,?)";
			}
			else 
			{
				$sql = "UPDATE events ". 
					   "SET ShowEvent=?" .
						  ",EventDate=?" .
						  ",EventCaption=?" .
						  ",EventText=?" .
						  ",ShowEventMainPage=?" .
						  ",ShowEventMainPageFlag=?" .
						  ",MainPageEventText=?" .
						  ",EventTextShowCharsMainPage=?" .
						  " " .
						"WHERE Id=?" . " ";
			}
			
			$stmt = $connection->prepare($sql);
			
			if($isInsert)
			{
				$stmt->bind_param("isssiisi"
						         ,$ShowEvent
				                 ,$EventDate
								 ,$EventCaption
								 ,$EventText
								 ,$ShowEventMainPage
								 ,$ShowEventMainPageFlag
								 ,$MainPageEventText
								 ,$EventTextShowCharsMainPage);
			}
			else 
			{
				$stmt->bind_param("isssiisii"
								 ,$ShowEvent
								 ,$EventDate
								 ,$EventCaption
								 ,$EventText
								 ,$ShowEventMainPage
								 ,$ShowEventMainPageFlag
								 ,$MainPageEventText
								 ,$EventTextShowCharsMainPage
								 ,$Id);
			}
			
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