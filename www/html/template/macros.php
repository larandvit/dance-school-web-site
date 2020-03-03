<?php
//--------------------Global functions-------------------------------------------//
	function relativePath($isService=false)
	{
		$path="../";
		
		if($isService)
		{
			$path="../../";
		}
		
		return $path;
	}
	
	function miscPictureFolder($isService=false)
	{
		return relativePath($isService) . "img/misc/";
	}
	
	function albumPictureFolder($albumFolder, $isService=false)
	{
		return relativePath($isService) . "album/" . $albumFolder . "/";
	}
	
	function ShowTime($militaryTime,$isAmPm=true)
	{
	    list($hour,$minutes)=explode(":",$militaryTime);
	    
	    $amText="&nbspam";
	    $pmText="&nbsppm";
	    
	    if(!$isAmPm)
	    {
	        $amText="";
	        $pmText="";
	    }
	    
	    $retValue="";
	    
	    if($hour=="12")
	    {
	        $retValue=$militaryTime . $pmText;
	    }
	    else if($hour>"12")
	    {
	        $retValue=strval((int)$hour - 12) . ":" . $minutes . $pmText;
	    }
	    else
	    {
	        $retValue=$militaryTime . $amText;
	    }
	    
	    return $retValue;
	}
//---------------------Macros-----------------------------------------------------//	
	function macro_DeveloperNameWithEmail()
	{
		echo "<a href='mailto:larandvit@hotmail.com?subject=Art%20of%20Soul%20Dance%20School%20Contact'>Vitaly&nbsp;Saversky</a>";
	}

	function macro_ShowMiscPicture($pictureName, $pictureAlt, $isService)
	{
		$path=relativePath($isService) . "img/misc/" . $pictureName;
		
		return
			"<a class='visible-lg visible-md' target='_blank' href='$path'>" .
				"<img class='img-responsive center-block' src='$path' alt='$pictureAlt'></img>" .
			"</a>" .
			"<img class='img-responsive center-block visible-sm visible-xs' src='$path' alt='$pictureAlt'></img>";
	}
	
	function macro_ShowMiscPictureGoWebSite($pictureName, $pictureAlt, $webSiteAddress , $isService)
	{
		$path=relativePath($isService) . "img/misc/" . $pictureName;
	
		return
		"<a target='_blank' href='$webSiteAddress'>" .
		"<img class='img-responsive center-block' src='$path' alt='$pictureAlt'></img>" .
		"</a>";
	}
	
	function macro_ShowEmail($emailAddress, $emailSubject)
	{
		return "<a href='mailto:" . $emailAddress . "?subject=" . $emailSubject . "'>" . $emailAddress . "</a>";
	}
	
	function macro_ContactsMississaugaLocation($isService)
	{
		$locationName="354 Lakeshore Blvd West, Mississauga";
		$path=relativePath($isService) . "view/contact#mississauga-location";
		
		return 
			"<a href='". $path . "'>". $locationName . "</a>";
	}
	
	function macro_ExternalLink($linkAddress, $linkCaption, $isService)
	{
		return 
			"<a target='_blank' href='" . $linkAddress. "'>" . $linkCaption . "</a>";
	}
	
	function macro_ContactsApplicationForm($isService)
	{
		$locationName="Art of Soul Dance School Application Form";
		$path=relativePath($isService) . "view/contact#application-form";
		
		return
		"<a href='". $path . "'>". $locationName . "</a>";
	}
?>