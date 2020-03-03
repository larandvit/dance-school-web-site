<?php
	require_once('db-connect.php');
	
	date_default_timezone_set("America/Toronto");

	class album
	{
		public $albumDate;
		public $albumCaption;
		public $albumFolder;
		public $albumId;
		public $ShowAlbum;
		public $ShowAlbumMainPage;
		
		public function picturePath($pictureName)
		{
			return "../album/" . $this->albumFolder . "/"  . $pictureName;
		}
		
		public function picturePathService($pictureName)
		{
			return "../../album/" . $this->albumFolder . "/"  . $pictureName;
		}
	}
	
	/*
	 Parameters:
	 	$mode
	 		0 - only albums with ShowAlbum=1
	 		1 - all albums
	 		2 - albums for main page
	 	$isService
	 		true - run it from Service web site
	 		false - run it from main web site
	 */
	function retrieveAlbums($mode, $isService=false)
	{
		$albums=array();
	
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
			$filter="1=0";
			
			switch ($mode) {
				case 0:
					$filter="ShowAlbum=1";
					break;
				case 1:
					$filter="1=1";
					break;
				case 2:
					$filter="ShowAlbumMainPage=1";
					break;
			}
			
			$sql = "SELECT AlbumDate" .
						 ",AlbumCaption" .
						 ",AlbumFolder" .
						 ",Id" .
						 ",ShowAlbum" .
						 ",ShowAlbumMainPage" . 
						 " " .
					"FROM album " .
					"WHERE " . $filter . " " .
					"ORDER BY AlbumDate DESC";
			
			if ($result=$connection->query($sql))
			{
				while ($row = $result->fetch_object()) 
				{
					$album=new album();
					$album->albumDate=$row->AlbumDate;
					$album->albumCaption=$row->AlbumCaption;
					$album->albumFolder=$row->AlbumFolder;
					$album->albumId=$row->Id;
					$album->ShowAlbum=$row->ShowAlbum;
					$album->ShowAlbumMainPage=$row->ShowAlbumMainPage;
					
					array_push($albums, $album);
				}
			}
				
			/* free result set */
			$result->free_result();
				
			/* close connection */
			$connection->close();
		}
		
		return $albums;
	}
	
	
	function retrievePictures($albumId,$isService=false)
	{
		$albums=array();
	
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
			$pictures=array();
			$sqlPictures="SELECT PictureName" .
					            " " .
					     "FROM album_pictures " .
					     "WHERE AlbumId=" . $albumId;
			
			if ($resultPicture=$connection->query($sqlPictures)) {
				while ($rowPicture = $resultPicture->fetch_object())
				{
					array_push($pictures, $rowPicture->PictureName);
				}
					
				$resultPicture->free_result();
			}
						
			/* close connection */
			$connection->close();
		}
	
		return $pictures;
	}
	
	function writeAlbum($showAlbum
					   ,$albumDate
					   ,$albumCaption
					   ,$showAlbumMainPage
					   ,$albumFolder
					   ,$albumId
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
				$sql = "INSERT INTO album (ShowAlbum" .
										 ",AlbumDate" .
										 ",AlbumCaption" .
										 ",ShowAlbumMainPage" .
										 ",AlbumFolder)" .
										 " " .
						"VALUES (?,?,?,?,?)";
			}
			else
			{
				$sql = "UPDATE album ".
					   "SET ShowAlbum=?" .
						  ",AlbumDate=?" .
						  ",AlbumCaption=?" .
						  ",ShowAlbumMainPage=?" .
						  ",AlbumFolder=?" .
						  " " .
					   "WHERE Id=?" . " ";
			}
	
			$stmt = $connection->prepare($sql);
	
			if($isInsert)
			{
				$stmt->bind_param("issis"
								 ,$showAlbum
								 ,$albumDate
								 ,$albumCaption
								 ,$showAlbumMainPage
								 ,$albumFolder);
			}
			else
			{
				$stmt->bind_param("issisi"
								 ,$showAlbum
								 ,$albumDate
								 ,$albumCaption
								 ,$showAlbumMainPage
								 ,$albumFolder
								 ,$albumId);
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
	
	function writePicture($albumId
			             ,$fileNameOriginal
						 ,$isService=true)
	{
		$errorType=0;
		$errorDesc="";
		$fileExtension="." . explode(".", $fileNameOriginal)[1];
	
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
			$sql= "SELECT @MaxIndex:=MAX(CAST(SUBSTRING_INDEX(PictureName, '.', 1) AS UNSIGNED)) 
                   FROM album_pictures 
                   WHERE albumId=" . $albumId . ";

                   SET @MaxIndex:=IF(@MaxIndex IS NULL, 0, @MaxIndex);

                   SET @MaxIndex:=@MaxIndex+1;

                   SET @PictureName:=CONCAT(@MaxIndex, '" . $fileExtension . "');

                   INSERT album_pictures (PictureName, AlbumId) VALUES(@PictureName," . $albumId . ");

                   SELECT @PictureName AS PictureName;";
			
			$fileNameDatabase='error.jpg';
			
			$iRecordset=1;
			if ($connection->multi_query($sql)) {
				do {
					/* store first result set */
					if ($result = $connection->store_result()) {
						if($iRecordset==6)
						{
							$row = $result->fetch_row();
							$fileNameDatabase=$row[0];
						}
						$result->free();
					}
					
					$iRecordset=$iRecordset+1;
				} while ($connection->next_result());
			}
			else 
			{
				$errorType=-1;
				$errorDesc="Error when retrieve multi recordsets";
			}
						
			/* close connection */
			$connection->close();
		}
	
		$fullError="";
	
		if($errorType!=0)
		{
			$fullError="Error type: " . $errorType . " Error description: " . $errorDesc;
		}
		
		$retValue=Array($fullError,$fileNameDatabase);
		
		return $retValue;
	}
	
	function deleteFicture($pictureName
						  ,$albumId
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
			$sql="DELETE FROM album_pictures WHERE AlbumId=? AND PictureName=?;";
	
			$stmt = $connection->prepare($sql);
	
			$stmt->bind_param("is"
						     ,$albumId
							 ,$pictureName);
	
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