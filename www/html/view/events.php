<!DOCTYPE html>
<html lang="en">

	<?php
		require("../template/macros.php");
		// page description
		$localWebPageDescription="Art of Soul Dance School events";
		// page title suffix		
		$localWebPageTitle="Events";
	?>
	
	<?php require("../template/header.html"); ?>
  
	<body>
	
  		<?php 
			require("../template/menu.php");
			showMenu("events");
			require("../data/data-events.php");
		?>
		
		<!-- page content -->
		<div id="firstContainer" class="container">
			<div class="panel panel-default">
  				<div class="panel-heading">
    				<h1 class="panel-title">Events</h1>
  				</div>
  				<div class="panel-body">
  					<?php
  						$colNumber=1;
  						
  						$events=eventsPage();
  						
  						foreach($events as $event)
  						{
  							$showEvent=$event[0];
  							$eventDate=$event[1];
  							$eventCaption=$event[2];
  							$eventText=$event[3];
  							
  							if($showEvent)
  							{
  								if($colNumber==1)
  								{
  									echo "<div class='row'>";
  								}
  								
  								echo"<div class='col-md-4'>";
  								echo "<p>";
  								echo "<strong>" . $eventDate . "</strong>" . "<br>" . $eventCaption . (is_null($eventText) ? "":"<br><br>" . $eventText);
  								echo "</p>";
  								echo "</div>";
  								
  								if($colNumber==3)
  								{
  									echo "</div>";
  									$colNumber=0;
  								}
  								
  								$colNumber++;
  							}
  						}
  						echo "</div>";
    				?>
  				</div>
			</div>  
		</div>
		
		<div class="visible-lg visible-md">  
    		<br><br><br><br><br><br><br><br><br><br>
    	</div>		
		
		<?php require("../template/footer.html"); ?>
		
	</body>
</html>
