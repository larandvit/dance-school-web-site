<!DOCTYPE html>
<html lang="en">

	<?php 
		require("../template/macros.php");
		require("../template/header.html"); 
	?>

	<body>
		
		<?php 
			require("../template/menu.php");
			showMenu("main");
			require("../data/data-events.php");
			require("../data/data-gallery.php");
			require("../data/data-news.php");
		?>
		
		<div class="container">
			<div class="row">
				<div class="col-md-6 visible-lg visible-md">
					<img class="img-responsive center-block" src="../img/logo-main.jpg" alt="Dance Make Music Visible"></img>
				</div>		
				<div class="col-md-6">
					<div class="row">
						<img class="img-responsive center-block visible-lg visible-md" src="../img/logo-name-no-address.jpg" alt="Art of Soul Dance School"></img>
						<img class="img-responsive center-block visible-xs visible-sm" src="../img/logo-name-address.jpg" alt="Art of Soul Dance School"></img>
					</div>
					<div class="row" style="margin-top: 15px;">
						<div class="col-md-6">
							<div class="panel panel-default">
  								<div class="panel-heading">
    								<h3 class="panel-title">News</h3>
  								</div>
  								<div class="panel-body">
  									<?php
  										$firstNews=true;
  										
  										$newss=newsMainPage();
  										
	  									foreach($newss as $news)
	  									{
	  										$showNews=$news[0];
	  										$newsDate=$news[1];
	  										$newsText=$news[2];
	  										$showNewsMainPage=$news[3];
	  										$showMainPageFlag=$news[4];
	  										$mainPageNewsText=$news[5];
	  										$mainPageNumberCharacter=$news[6];
	  											
  											if(!$firstNews)
  											{
  												echo "</p>";
  											}
  											
  											$firstNews=false;
  											
  											echo "<p>";
  											echo "<strong>" . $newsDate . "</strong>" . "<br>";
  											switch ($showMainPageFlag) {
  												case 1:
  													echo $mainPageNewsText;
  													break;
  												case 2:
  													echo substr($newsText,0,$mainPageNumberCharacter);
  													break;
  												default;
  													echo "Undefined";
  													break;
  											}
	  									}
  									?>
    								<a href="../view/news" class="visible-lg-inline visible-md-inline" data-toggle="tooltip" title="More details"><span class="glyphicon glyphicon-circle-arrow-right" aria-hidden="false"></span></a>
    								<?php echo "</p>" ?>
    								<button class="btn btn-default btn-md visible-xs visible-sm"  onClick="location.href='../view/news'">More details</button>
  								</div>
							</div>  
						</div>
						<div class="col-md-6">
							<div class="panel panel-default">
  								<div class="panel-heading">
    								<h3 class="panel-title">Upcoming events</h3>
  								</div>
  								<div class="panel-body">
  									<?php
  										$firstEvent=true;
  										
  										$events=eventsMainPage();
  										
	  									foreach($events as $event)
	  									{
	  										$showEvent=$event[0];
	  										$eventDate=$event[1];
	  										$eventCaption=$event[2];
	  										$eventText=$event[3];
	  										$showEventMainPage=$event[4];
	  										$showMainPageFlag=$event[5];
	  										$mainPageEventText=$event[6];
	  										$mainPageNumberCharacter=$event[7];
	  											
	  										if($showEventMainPage and $showEvent)
	  										{
	  											if(!$firstEvent)
	  											{
	  												echo "</p>";
	  											}
	  											
	  											$firstEvent=false;
	  											
	  											echo "<p>";
	  											echo "<strong>" . $eventDate . "</strong>" . "<br>" . $eventCaption;
	  											
	  											if($showMainPageFlag==1)
	  											{
	  												echo "<br><br>" . $mainPageEventText;
	  											}
	  											
	  											if($showMainPageFlag==2)
	  											{
	  												echo "<br><br>" . substr($eventText,0,$mainPageNumberCharacter);
	  											}
	  										}
	  										
	  									}
  									?>
										<a href="../view/events" class="visible-lg-inline visible-md-inline" data-toggle="tooltip" title="More details"><span class="glyphicon glyphicon-circle-arrow-right" aria-hidden="false"></span></a>
									<?php echo "</p>" ?> 
									<p>
										<button class="btn btn-default btn-md visible-xs visible-sm" onClick="location.href='../view/events'">More details</button>
									</p> 
  								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="container">
			<div class="panel panel-default">
  				<div class="panel-heading">
    				<h1 class="panel-title">Dance makes music visible</h1>
  				</div>
  				<div class="panel-body">
    				<div class="row">
    					<!-- lg & md -->
    					<div class="col-md-4 hidden-xs hidden-sm" >
    						<p>
	 							The Art of Soul Dance Studio is the perfect place to fall in love with dance. Under the supervision of Inessa Rolik, founder and artistic director, the studio has been in the dance business since 2006. Formerly known as Dance Mania by Inessa, the Art of Soul Dance Studio is located in the city of Mississauga minutes away from Port Credit.
	 						</p>
    					</div>
    					<div class="col-md-4 hidden-xs hidden-sm">
    						<p>
    						 	The studio specializes mainly in International Latin and Ballroom, with workshops offered in other dance styles. Both as a competitive and recreational studio, the Art of Soul has been recognized at many competitions and events.
    						</p> 
    					</div>
    					<div class="col-md-4 hidden-xs hidden-sm">
    						<p>
    							Classes are offered at all levels and registration begins from the age of 4. Aside from the competitive and recreational classes, the studio offers special packages for wedding dances, quinceañera and debutante balls.
    						</p> 
    					</div>
    					<!-- sm -->
    					<div class="col-sm-6 visible-sm">
    						<p>
    							The Art of Soul Dance Studio is the perfect place to fall in love with dance. Under the supervision of Inessa Rolik, founder and artistic director, the studio has been in the dance business since 2006. Formerly known as Dance Mania by Inessa, the Art of Soul Dance Studio is located in the city of Mississauga minutes away from Port Credit.
    						</p>
    						<p>
    							The studio specializes mainly in International Latin and Ballroom, with workshops offered in other
    						</p>
    					</div>
    					<div class="col-sm-6 visible-sm">
    						<p>
    							dance styles. Both as a competitive and recreational studio, the Art of Soul has been recognized at many competitions and events.
    						</p>
    						<p>
    							Classes are offered at all levels and registration begins from the age of 4. Aside from the competitive and recreational classes, the studio offers special packages for wedding dances, quinceañera and debutante balls.
    						</p>
    					</div>
    					<!-- xs -->
    					<div class="col-xs-12 visible-xs">
    						<p>
    							The Art of Soul Dance Studio is the perfect place to fall in love with dance. Under the supervision of Inessa Rolik, founder and artistic director, the studio has been in the dance business since 2006. Formerly known as Dance Mania by Inessa, the Art of Soul Dance Studio is located in the city of Mississauga minutes away from Port Credit.
    						</p>
    						<p>
    							The studio specializes mainly in International Latin and Ballroom, with workshops offered in other dance styles. Both as a competitive and recreational studio, the Art of Soul has been recognized at many competitions and events.
    						</p>
    						<p>
    							Classes are offered at all levels and registration begins from the age of 4. Aside from the competitive and recreational classes, the studio offers special packages for wedding dances, quinceañera and debutante balls.
    						</p>
    					</div>
    				</div>  
  				</div>
  				
			</div>  			
			
		</div>
		
		<!-- feature #3: pictures -->
		<div class="container">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Our life</h3>
				</div>
				<div class="panel-body">
	  				<p>Art of Soul Dance School is engaged in numerous competitions and show cases
						<a href="../view/gallery" class="visible-lg-inline visible-md-inline" data-toggle="tooltip" title="Open gallery"><span class="glyphicon glyphicon-circle-arrow-right" aria-hidden="false"></span></a>
					</p>
					<p>
						<button class="btn btn-default btn-md visible-xs visible-sm" onClick="location.href='../view/gallery'">Open gallery</button>
					</p>
					<!-- Carousel -->
					<div id="imageCarousel" class="carousel slide" data-ride="carousel">
						<div class="carousel-inner" role="listbox">
							<?php
		    					$albums=retrieveAlbums(2);	
								
								$picCounter=1;
		    					$activeItemText=" active";
		    					
		    					foreach ($albums as $album){
		    						
		    						$pictures=retrievePictures($album->albumId);
		    						
			    					foreach($pictures as $picture)
			    					{
			    						$filePath=$album->picturePath($picture);
																						
										echo "<div class=\"item" . $activeItemText . "\">";
										echo "	<img class=\"img-responsive center-block\" src=\"" . $filePath . "\" alt=\"Art of Soul Dance School\">";
										echo "</div>";
										$picCounter++;
										$activeItemText="";
									}
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
			</div>
		</div>
		
		<?php require("../template/footer.html"); ?>
		
	</body>
</html>
