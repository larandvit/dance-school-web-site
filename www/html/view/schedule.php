<!DOCTYPE html>
<html lang="en">

	<?php
		require("../template/macros.php");
		//page description
		$localWebPageDescription="Art of Soul Dance School schedule";
		// page title suffix		
		$localWebPageTitle="Schedule";
	?>
	
	<?php require("../template/header.html"); ?>
  
	<body>
	
  		<?php 
			require("../template/menu.php");
			showMenu("schedule");
			require("../data/data-schedule.php");
		?>
		
		<?php
			
		    $schedules=allActiveSchedules();

		?>
					
		<!-- page content -->
		<div id="firstContainer" class="container">
		
		<!--div class="row"-->
		<!--div class="col-md-8"-->
			
			<div class="panel panel-default">
  				<div class="panel-heading hidden-print">
    				<h1 class="panel-title">Schedule</h1>
  				</div>
  				<div class="panel-body">
  				
				<?php
					
					#show links to schedules
					echo "<ul class=\"nav nav-pills hidden-print\">";
					
					foreach($schedules as $schedule)
					{
  						echo "<li role=\"presentation\"><a href=\"#" . $schedule[0] . "\">" . $schedule[0] . "</a></li>";
					}
					echo "</ul>";
				  	
					$scheduleCounter = 0;
					
				  	#show each schedule table
				  	foreach($schedules as $schedule)
					{
						#look for minimum and maximum start times
						$minTimeOriginal="23:00";
						$maxTimeOriginal="00:00";
						foreach($schedule[3] as $classItem)
						{
							if($minTimeOriginal>$classItem[2])
							{
								$minTimeOriginal=$classItem[2];
							}
							
							if($maxTimeOriginal<$classItem[2])
							{
								$maxTimeOriginal=$classItem[2];
							}
						}
						list($hour,$minutes)=explode(":",$minTimeOriginal);
						$minTime=(int)$hour;
						list($hour,$minutes)=explode(":",$maxTimeOriginal);
						$maxTime=(int)$hour;
						
						echo "<hr class=\"hidden-print\" id=\"" . $schedule[0] . "\">";  	
  						echo "<div class=\"table-responsive\">";
  						echo "<table class=\"table table-striped table-bordered table-condensed\">";
  						echo "  <caption ><h2>" . $schedule[0] . "</h2></br></br>First Class: " . $schedule[1] . "</br>Last Class: " . $schedule[2] . "</br></br></caption>";
  						echo "  <thead>";
  						echo "    <tr>";
  						echo "	   <th style=\"text-align:center;\">";
  						echo "		  Time";
  						echo "	   </th>";
						
						#table header names
  						foreach($schedule[6] as $week)
						{
							echo "<th style=\"text-align:center;\">" . $week . "</th>";
						}

						echo "    </tr>";
					   echo "  </thead>";
					   echo "  <tbody>";
	    				
						for($timeScale=$minTime;$timeScale<=$maxTime;$timeScale++) 
						{
							$fullTime=strval($timeScale) . ":00";						
							echo "<tr>";
							echo "<td><strong>" . ShowTime($fullTime) . "</strong></td>";
							
							foreach($schedule[6] as $week)
							{
								$weekText="";								
								foreach($schedule[3] as $weekTime)
								{
								    //echo $weekTime[1];
								    $weekClassDay=$weekTime[0];
									$weekClassName=$weekTime[1];	
									$weekClassFrom=$weekTime[2];
									$weekClassTo=$weekTime[3];
									$weekClassColor=$weekTime[4];
								
									list($weekTimeHour)=explode(":",$weekClassFrom);
									$weekTimeHourInt=(int)$weekTimeHour;
									
									if($timeScale<=$weekTimeHourInt and $timeScale+1>$weekTimeHourInt and $week==$weekClassDay) 
									{
										$weekText=$weekText . "<span style='color: " . $weekClassColor . ";'><strong>" . $weekClassName . "</strong></span></br>" . ShowTime($weekClassFrom,false) . " - " . ShowTime($weekClassTo,false);									
									}
								}
								echo "<td>" . $weekText . "</td>";
							}
							echo "</tr>";
						}
				
						echo "<tr>";
						echo "<td><strong>Coach</strong></td>";
						foreach($schedule[4] as $coachWeek)
						{
							$weekCoachBuf="";
							$newLine="";							
							foreach($coachWeek as $coachName)
							{								
								$weekCoachBuf=$weekCoachBuf . $newLine . $coachName;
								$newLine="</br>";
							}
							echo "<td style=\"text-align:center;\">" . $weekCoachBuf . "</td>";
						}
						echo "</tr>";	
									
					   echo "</tbody>";
  				      echo "</table>";
  				      echo "</div>";
  				      
  				      if(!empty($schedule[5][0]))
  				      {
      				      echo "<p>";
    					  echo "  No Group Lessons";
    					  echo "</p>";
    					  echo "<ol>";
    							
      				      foreach($schedule[5] as $noClassLabel)
      				      {
      				      	
    							echo "<li>" . $noClassLabel . " </li>";
    							
      				      }
      				      
      				      echo "</ol>";
  				      }
  				      
  				      $scheduleCounter = $scheduleCounter + 1;
  				      if(sizeof($schedules)>$scheduleCounter)
  				      {
  				          echo "<div style=\"page-break-after: always;\"></div>";
  				      }
  				      
  				 	}
				  	   
  				?>
				
			</div>  
			
			</div>
			
			
		</div>
		
		<?php require("../template/footer.html"); ?>
		
	</body>
</html>
