<?php
	require_once('db-connect.php');
	
	date_default_timezone_set("America/Toronto");

	/*
	 Array structure
	 There are two arrays. The first one is news list and the second one contains a news:
	 0)show news: true/false
	 1)news date mktime(0,0,0,month,day,year)
	 2)news text
	 3)show news on main page: true/false
	 4)show on main page flag:
	 1 - show main page text
	 2 - show "n" characters from news text
	 5)main page news text
	 6)number of characters from news text on main page
	 */
	
	function newsMainPage()
	{
		return retrieveNews("ShowNewsMainPage=1");
	}
	
	function newsPage()
	{
		return retrieveNews("ShowNews=1");
	}
	
	function newsServicePage($isRawHtml)
	{
		return retrieveNews("1=1",true,$isRawHtml);
	}
	
	function retrieveNews($filter, $isService=false, $isRowHtml=false)
	{
		$newss=array();
		
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
			$sql = "SELECT ShowNews" . 
					     ",NewsDate" .
					     ",NewsText" . 
					     ",ShowNewsMainPage" . 
					     ",ShowNewsMainPageFlag" .
					     ",MainPageNewsText" .
					     ",NewsTextShowCharsMainPage" .
					     ",Id" .
					     " " .
		           "FROM news " .
		           "WHERE " . $filter . " " .
				   "ORDER BY NewsDate DESC";
			
			if ($result=$connection->query($sql)) {
			
				while ($row = $result->fetch_object()) {
					
					$newsText=$row->NewsText;
					$mainPageNewsText=$row->MainPageNewsText;
						
					if($isRowHtml)
					{
						$newsText=htmlspecialchars($newsText);
						$mainPageNewsText=htmlspecialchars($mainPageNewsText);
					}
					else
					{
						//ShowMiscPicture macro
						$macroPattern="/ShowMiscPicture\(([^,]+?),([^,]+?)\)/";
						$newsText=preg_replace_callback($macroPattern,
														function ($matches) use($isService) {return macro_ShowMiscPicture($matches[1],$matches[2],$isService);},
														$newsText);
						$mainPageNewsText=preg_replace_callback($macroPattern,
																function ($matches) use($isService) {return macro_ShowMiscPicture($matches[1],$matches[2],$isService);},
																$mainPageNewsText);
						
						//ShowMiscPictureGoWebSite macro
						$macroPattern="/ShowMiscPictureGoWebSite\(([^,]+?),([^,]+?),([^,]+?)\)/";
						$newsText=preg_replace_callback($macroPattern,
								function ($matches) use($isService) {return macro_ShowMiscPictureGoWebSite($matches[1],$matches[2],$matches[3],$isService);},
								$newsText);
						$mainPageNewsText=preg_replace_callback($macroPattern,
								function ($matches) use($isService) {return macro_ShowMiscPictureGoWebSite($matches[1],$matches[2],$matches[3],$isService);},
								$mainPageNewsText);
						
						//ShowEmail macro
						$macroPattern="/ShowEmail\(([^,]+?),([^,]+?)\)/";
						$newsText=preg_replace_callback($macroPattern,
								function ($matches) use($isService) {return macro_ShowEmail($matches[1],$matches[2],$isService);},
								$newsText);
						$mainPageNewsText=preg_replace_callback($macroPattern,
								function ($matches) use($isService) {return macro_ShowEmail($matches[1],$matches[2],$isService);},
								$mainPageNewsText);
						
						//ContactsMississaugaLocation macro
						$macroPattern="ContactsMississaugaLocation()";
						$newsText=str_replace($macroPattern, macro_ContactsMississaugaLocation($isService), $newsText);
						$mainPageNewsText=str_replace($macroPattern, macro_ContactsMississaugaLocation($isService), $mainPageNewsText);
					
						//ExternalLink macro
						$macroPattern="/ExternalLink\((.+?),(.+?)\)/";
						$newsText=preg_replace_callback($macroPattern,
														function ($matches) use($isService) {return macro_ExternalLink($matches[1],$matches[2],$isService);},
														$newsText);
						$mainPageNewsText=preg_replace_callback($macroPattern,
																function ($matches) use($isService) {return macro_ExternalLink($matches[1],$matches[2],$isService);},
																$mainPageNewsText);
						//ContactsApplicationForm macro
						$macroPattern="ContactsApplicationForm()";
						$newsText=str_replace($macroPattern, macro_ContactsApplicationForm($isService), $newsText);
						$mainPageNewsText=str_replace($macroPattern, macro_ContactsApplicationForm($isService), $mainPageNewsText);
					}
					
					$row_array=array($row->ShowNews,
							         $row->NewsDate,
									 $newsText,
									 $row->ShowNewsMainPage,
									 $row->ShowNewsMainPageFlag,
									 $mainPageNewsText,
									 $row->NewsTextShowCharsMainPage,
									 $row->Id);
					array_push($newss, $row_array);
				}
			
				/* free result set */
				$result->free_result();
			}
			
			
			/* close connection */
			$connection->close();
		}
		
		return $newss;
	}
	
	function writeNews($ShowNews
					  ,$NewsDate
					  ,$NewsText
					  ,$ShowNewsMainPage
					  ,$ShowNewsMainPageFlag
					  ,$MainPageNewsText
					  ,$NewsTextShowCharsMainPage
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
				$sql = "INSERT INTO news (ShowNews" .
										",NewsDate" .
										",NewsText" .
										",ShowNewsMainPage" .
										",ShowNewsMainPageFlag" .
										",MainPageNewsText" .
										",NewsTextShowCharsMainPage)" .
										" " .
						"VALUES (?,?,?,?,?,?,?)";
			}
			else
			{
				$sql = "UPDATE news ".
					   "SET ShowNews=?" .
						  ",NewsDate=?" .
						  ",NewsText=?" .
						  ",ShowNewsMainPage=?" .
						  ",ShowNewsMainPageFlag=?" .
						  ",MainPageNewsText=?" .
						  ",NewsTextShowCharsMainPage=?" .
						  " " .
					   "WHERE Id=?" . " ";
			}
				
			$stmt = $connection->prepare($sql);
				
			if($isInsert)
			{
				$stmt->bind_param("issiisi"
								 ,$ShowNews
								 ,$NewsDate
								 ,$NewsText
								 ,$ShowNewsMainPage
								 ,$ShowNewsMainPageFlag
								 ,$MainPageNewsText
								 ,$NewsTextShowCharsMainPage);
			}
			else
			{
				$stmt->bind_param("issiisii"
								 ,$ShowNews
								 ,$NewsDate
								 ,$NewsText
								 ,$ShowNewsMainPage
								 ,$ShowNewsMainPageFlag
								 ,$MainPageNewsText
								 ,$NewsTextShowCharsMainPage
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