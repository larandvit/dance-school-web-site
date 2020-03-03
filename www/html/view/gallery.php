<!DOCTYPE html>
<html lang="en">
	
	<?php
		require("../template/macros.php");
		//page description		
		$localWebPageDescription="Art of Soul Dance School gallery";
		// page title suffix		
		$localWebPageTitle="Gallery";
	?>
	
	<?php require("../template/header.html"); ?>
  
	<body>
	
		<script type="text/javascript" >
		
			function ShowCarousel(pictureIndex)
			{
				$("#albumModal").modal();
				$("#imageCarousel").carousel(pictureIndex).carousel("pause");
				
				return false;
			}
			
			function ShowNextPage(pageIndex)
			{
				hiddenPageClassName=".hiddenPage" + pageIndex;
				pageButtonId="#pageButton" + pageIndex;
				nextButtonId="#pageButton" + (pageIndex+1);
								
				$(pageButtonId).addClass("hidden");
				$(hiddenPageClassName).removeClass("hidden");
				$(nextButtonId).removeClass("hidden");
								
				return false;
			}
		
		</script>
		
  		<?php 
			require("../template/menu.php");
			showMenu("gallery");
			require("../data/data-gallery.php");
		?>
	
		<!-- page content -->
		<div id="firstContainer" class="container">
			<div class="panel panel-default">
  				<div class="panel-heading">
    				<h1 class="panel-title">Gallery</h1>
  				</div>
  				<div class="panel-body">
  					<h3 class="text-center">Albums</h3>
  					<ul class="nav nav-pills">
  					<?php
  					
	  					$currentAlbum=null;
	  					$currentAlbumId=0;
	  					
	  					if(isset($_GET["albumId"]))
	  					{
	  						$currentAlbumId=$_GET["albumId"];
	  					}
  						
  						$albums=retrieveAlbums(0);
  						
  						foreach($albums as $album)
  						{
  							if($currentAlbumId==$album->albumId or $currentAlbumId==0)
  							{
  								echo "<li role='presentation'><a href='#" . $album->albumCaption . "'>" . $album->albumCaption . "</a></li>";
  								$currentAlbum=$album;
  								$currentAlbumId=$album->albumId;
  								
  							}
  							else
  							{
  								echo "<li role='presentation'><a href='gallery?albumId=" . $album->albumId . "#" . $album->albumCaption . "'>" . $album->albumCaption . "</a></li>";
  							}
  						}
  					?>
					</ul>
					<hr id="<?php echo $currentAlbum->albumCaption ?>">
					<h3 class="text-center"><?php echo $currentAlbum->albumCaption ?></h3>
    				<?php
    					$pagePictures=12;
    					$rowCounter=1;
    					$picCounter=1;
    					$pictureVisibility="";
    					$rowHiddenClassName="";
    					$pageCounter=1;
    					$buttonVisibility="";
    					
    					$pictures=retrievePictures($currentAlbum->albumId);
    					
    					foreach($pictures as $picture)
    					{						
    						
							if((($picCounter-1) % $pagePictures)==0 and $picCounter!=1)
							{				
								if($pageCounter>1)
								{
									$buttonVisibility=" hidden";
								}								
								echo "<div  id=\"pageButton" . $pageCounter .  "\" class=\"row text-right" . $buttonVisibility . "\">";
								echo "</br></br><button style=\"margin-right: 13px;\" class=\"btn btn-default btn-md\" onClick=\"return ShowNextPage(" . $pageCounter . ")\">More pictures</button>";
								echo "</div>";
							}
							    						
    						if($rowCounter==1) 
    						{			
								#start new row    							
    							echo "<div class=\"row" . $pictureVisibility . " " . $rowHiddenClassName . "\">";
    						}
    						
							$filePath=$currentAlbum->picturePath($picture);	
    						
							echo "<div class=\"col-md-4\">";
							echo "<a class=\"hidden-xs hidden-sm\" id=\"imageA\" href=\"#\" onclick=\"return ShowCarousel(" . ($picCounter-1) . ")\"><img class=\"img-responsive center-block img-thumbnail\" src=\"" . $filePath . "\"></img></a>";  
							echo "<img class=\"img-responsive center-block visible-xs visible-sm\" src=\"" . $filePath . "\"></img>";
							echo "</div>";
							
    						
    						if($rowCounter==3) 
    						{
								#close new row    							
    							echo "</div>";
    							$rowCounter=1;
    						}
    						else 
    						{
    							$rowCounter++;
    						}
    						
    						if(($picCounter % $pagePictures)==0)
							{				
								$pageCounter=(int)($picCounter/$pagePictures);
								$rowHiddenClassName="hiddenPage" . $pageCounter;
								$pictureVisibility=" hidden";
							}
							
    						$picCounter++;
    					}
    					echo "</div>";
    				?>
    				
					<!-- Modal -->
					<div id="albumModal" class="modal fade" role="dialog">
  						<div class="modal-dialog">
    						<!-- Modal content-->
    						<div class="modal-content">
      						<div class="modal-header">
        							<button type="button" class="close" data-dismiss="modal">&times;</button>
        							<!--h4 class="modal-title"></h4-->
      						</div>
      						<div class="modal-body">
      
      							<!-- Carousel -->
									<div id="imageCarousel" class="carousel slide" data-ride="carousel">
										<div class="carousel-inner" role="listbox">
											<?php
						    					$picCounter=1;
						    					$activeItemText=" active";
						    					foreach($pictures as $picture)
						    					{
						    						$filePath=$currentAlbum->picturePath($picture);
																									
													echo "<div class=\"item" . $activeItemText . "\">";
													echo "	<img class=\"img-responsive center-block\" src=\"" . $filePath . "\" alt=\"Art of Soul Dance School\">";
													echo "</div>";
													$picCounter++;
													$activeItemText="";
												}
											?>
										</div>
										<a class="left carousel-control" href="#imageCarousel" role="button" data-slide="prev">
											<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
											<span class="sr-only">Previous</span>
										</a>
										<a class="right carousel-control" href="#imageCarousel" role="button" data-slide="next">
											<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
											<span class="sr-only">Next</span>
										</a>
									</div><!-- carousel -->
        
						      </div>
						      <div class="modal-footer">
						        	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						      </div>
						   </div><!--modal-content-->
					  	</div><!--modal-dialog-->
					</div><!-- Modal -->    				
    				
  				</div>
			</div>  
		</div>
		
		<?php require("../template/footer.html"); ?>
		
	</body>
</html>
