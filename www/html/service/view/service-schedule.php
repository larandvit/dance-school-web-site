<!DOCTYPE html>
<html lang="en">

<?php
	require_once("../../template/macros.php");
	// page description
	$localWebPageDescription="Art of Soul Dance School edit web site schedule";
	// page title suffix
	$localWebPageTitle="Manage schedules";
?>
	
	<?php session_start();?>
	
	<?php require("../template/header.html"); ?>
  
	<body>
		<?php 
			require("../template/login.php");
			
			start("schedule");
		?>
  		
    	
    	<?php function showMain()
		{
			require_once("../../data/data-schedule.php");
		?>
		
		<?php
			//clicked Save album button
			if(isset($_POST["submittedSaveButton"]))
			{
				$showSchedule = $_POST["inputShowSchedule"]=="on"?1:0;
				$scheduleName = $_POST["inputScheduleName"];
				$firstClass = $_POST["inputFirstClass"];
				$lastClass = $_POST["inputLastClass"];
				$noClasses = $_POST["inputNoClasses"];
				$scheduleOrder = $_POST["inputScheduleOrder"];
				$scheduleId = $_POST["inputScheduleId"];
				
				$returnedDesc=writeSchedule($showSchedule
                        				   ,$scheduleName
                        				   ,$firstClass
                        				   ,$lastClass
                        				   ,$noClasses
                        				   ,$scheduleOrder
				                           ,$scheduleId);
				if($returnedDesc)
				{
				    $errors = array($returnedDesc);
				}
			}
			
			//clicked Days Save album button
			if(isset($_POST["submittedDaysSaveButton"]))
			{
			    $weekDays = array();
			    
			    for($iDay=0; $iDay<7; $iDay++)
			    {
			        $sourceName = "inputEditDataDay" . $iDay;
			        
			        if($_POST[$sourceName])
			        {
			            $weekDayRawValue = trim($_POST[$sourceName]);
			            
			            if($weekDayRawValue!="")
			            {
			                //adding day of week as well
			                array_push($weekDays, $iDay . ";" . $weekDayRawValue);
			            }
			        }
			    }
			    
			    $scheduleId = $_POST["inputEditScheduleId"];
			    
			    $returnedErrors=writeScheduleDays($scheduleId, $weekDays);
			    
			    if($returnedErrors)
			    {
			        $errors = $returnedErrors;
			    }
			}
		?>
		
		<!-- page content -->
		<div id="firstContainer" class="container">
			<div class="panel panel-default">
  				<div class="panel-heading">
    				<h1 class="panel-title">Manage schedules</h1>
  				</div>
  				<div class="panel-body">
  					<?php
						if (isset($_POST["submittedDaysSaveButton"]) or isset($_POST["submittedSaveButton"])) 
						{
							if(!empty($errors))
							{
								//scan all errors
								$errBuf = "";
								$newLine = "";
								foreach($errors as $error)
								{
								    $errBuf = $errBuf . $newLine . $error;
								    $newLine = "<br>";
								}
							    echo "<div class'col-sm-12'>
									      <div class='alert alert-danger'>
		    							      <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
		    							      <strong>" . $errBuf . "</strong>
		  							      </div>
		  						      </div>";
		  					}
		  					else
		  					{
		  						$successMessage="Operation completed successfully";
		  						
		  						if(isset($_POST["submittedDaysSaveButton"]))
		  						{
		  							$successMessage="Schedule days saved succesfully";
		  						}
		  						
		  						if(isset($_POST["submittedSaveButton"]))
		  						{
		  							$successMessage="Schedule savedd successfully";
		  						}
		  						
		  						echo "<div class'col-sm-12'>
									      <div class='alert alert-success'>
		    							        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
		    							        <strong>" . $successMessage . "</strong>
		  							      </div>
		  						      </div>";
		  					}
  						}
	  				?>
					<h3 class="text-center">Schedules</h3>
					<div class="table-responsive">
  						<table class="table table-striped table-bordered table-condensed">
  							<thead>
  								<tr>
  									<th class="text-center">Show schedule</th>
  									<th class="text-center">Schedule name</th>
  									<th class="text-center">First class</th>
  									<th class="text-center">Last class</th>
  									<th class="text-center">No Classes</th>
  									<th class="text-center">Order</th>
  									<th class="text-center">Id</th>
								</tr>
							</thead>
					   		<tbody>
			  					<?php
			  					    $schedules=allSchedules();	
			  					
			  					    foreach($schedules as $schedule)
			  						{
			  						    $showSchedule = $schedule[7];
			  						    $scheduleName = $schedule[0];
			  						    $firstClass = $schedule[1];
			  						    $lastClass = $schedule[2];
			  						    $noClasses = implode("|",$schedule[5]);
			  						    $scheduleOrder = $schedule[8];
			  						    $Id = $schedule[9];
			  						    echo "<tr>";
			  							
			  						    echo "<td id='showSchedule_" . $Id . "'><a href='service-schedule?scheduleId=" . $Id . "#" . $scheduleName . "'>" . ($showSchedule==1?"Yes":"No") . "</a></td>";
			  						    echo "<td id='scheduleName_" . $Id . "'><a href=\"#\" onclick=\"return ShowScheduleModal(" . $Id . ")\">" . $scheduleName . "</a></td>";
			  						    echo "<td id='firstClass_" . $Id . "'>" . $firstClass . "</td>";
			  						    echo "<td id='lastClass_" . $Id . "'>" . $lastClass . "</td>";
			  						    echo "<td id='noClasses_" . $Id . "'>" . $noClasses . "</td>";
			  						    echo "<td id='scheduleOrder_" . $Id . "'>" . $scheduleOrder . "</td>";
			  						    echo "<td id='scheduleId_" . $Id . "'>" . $Id . "</td>";
			  							
			  							echo "</tr>";
			  						}
			    				?>
    						</tbody>
						</table>
					</div>
					
					<?php
						$currentSchedule = $schedules[0];
						$currentSchduleId = $currentSchedule[9];
						
						if(isset($_GET["scheduleId"]))
						{
						    $currentSchduleId=$_GET["scheduleId"];
							
						    foreach($schedules as $schedule)
							{
							    if($schedule[9]==$currentSchduleId)
								{
								    $currentSchedule=$schedule;
									break;
								}
							}
						}
					?>
					
					<?php 
					    #show schedule table
					    
					    $schedule = $currentSchedule;
					    
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
									
						echo "<hr id=\"" . $schedule[0] . "\">";  	
  						echo "<div class=\"table-responsive\">";
  						echo "<table class=\"table table-striped table-bordered table-condensed\">";
  						echo "  <caption ><h2><a href=\"#\" onclick=\"return ShowScheduleDaysModal(" . $currentSchduleId . ")\">" . $schedule[0] . "</a></h2></br></br>First Class: " . $schedule[1] . "</br>Last Class: " . $schedule[2] . "</br></br></caption>";
  						echo "  <thead>";
  						echo "    <tr>";
  						echo "	   <th style=\"text-align:center;\">";
  						echo "		  Time";
  						echo "	   </th>";
						
						#table header names
  						foreach($schedule[6] as $week)
						{
						    $dayClasses = array();
						    
						    foreach($schedule[3] as $weekTime)
						    {
						        $weekClassId = $weekTime[6];
						        $weekClassFrom = $weekTime[2];
						        $weekClassTo = $weekTime[3];
						        $weekClassDay=$weekTime[0];
						        
						        if($week==$weekClassDay)
						        {
						            $weekDayOfWeekId = $weekTime[5];
						            $class = array($weekClassId, $weekClassFrom, $weekClassTo);
    						        
    						        //convert array to string. One string for each classarray
    						        array_push($dayClasses, implode(";",$class));
						        }
						    }
						    
						    $dataStorage = "id=\"storedDataDay" . $weekDayOfWeekId . "\" data-day=\"" . implode("|",$dayClasses) . "\"";
						    
						    echo "<th style=\"text-align:center;\" " . $dataStorage . ">" . $week . "</th>";
							
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
  				    ?>
  				</div>
			</div>  
		</div>
		<?php
		}
    	?>
		
		<!-- Modal -->
		<div id="scheduleModal" class="modal fade" role="dialog" data-backdrop="static">
  			<div class="modal-dialog modal-lg">
    			<!-- Modal content-->
    			<div class="modal-content">
    			
      				<div class="modal-header">
        				<button type="button" class="close" data-dismiss="modal">&times;</button>
        				<h4 id="scheduleModalCaption" class="modal-title"></h4>
      				</div><!-- modal-header -->
      				
      				<div class="modal-body">
        				
        				<form class="form" action="#" method="post">
							<div class="checkbox">
								<label>
									<input id="showSchedule" type="checkbox" name="inputShowSchedule"><b>Show schedule</b>
								</label>
							</div>
							
							<div class="form-group">
								<label for="inputScheduleName">Schedule name</label>
								<textarea id="scheduleName" class="form-control" rows="1" name="inputScheduleName" required></textarea>
							</div>
							
							<div class="form-group">
								<label for="inputFirstClass">First class</label>
								<textarea id="firstClass" class="form-control" rows="1" name="inputFirstClass" required></textarea>
							</div>
							
							<div class="form-group">
								<label for="inputLastClass">Last class</label>
								<textarea id="lastClass" class="form-control" rows="1" name="inputLastClass" required></textarea>
							</div>
							
							<div class="form-group">
								<label for="inputNoClasses">No classes (separate each day by '|' (pipe) character)</label>
								<textarea id="noClasses" class="form-control" rows="2" name="inputNoClasses"></textarea>
							</div>
							
							<div class="form-group">
								<label for="inputScheduleOrder">Schedule order</label>
								<input type="number" min=0 max=255 id="scheduleOrder" class="form-control" name="inputScheduleOrder" required></input>
							</div>
							
							<input type="text" id="scheduleId" name="inputScheduleId" class="hidden">
							
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
								<button type="submit" name="submittedSaveButton" class="btn btn-default">Save</button>
							</div><!-- modal-footer -->
						</form>
        				
					</div><!-- modal-body -->
				</div><!--modal-content-->
	  		</div><!--modal-dialog-->
		</div><!-- Modal --> 
		
		<!-- Modal -->
		<div id="scheduleDaysModal" class="modal fade" role="dialog" data-backdrop="static">
  			<div class="modal-dialog modal-lg">
    			<!-- Modal content-->
    			<div class="modal-content">
    			
      				<div class="modal-header">
        				<button type="button" class="close" data-dismiss="modal">&times;</button>
        				<h4 id="scheduleDaysModalCaption" class="modal-title"></h4>
      				</div><!-- modal-header -->
      				
      				<div class="modal-body">
        				<p>
        					Each week day contins a set of values separated by "|" pipe character. A set defines a class in a time. For example,
        					4;17:00;18:00|2;18:00;19:00|1;19:00;20:00|0;20:00;21:00. The classes are "4;17:00;18:00", "2;18:00;19:00", "1;19:00;20:00",
        					and "0;20:00;21:00". The structure of a set is (1) class Id taken from Classes page, (2) class start, and (3) class finish.
        					For example, 1;19:00;20:00, class Id is 1 which is "Bronze/Silver Latin & Standard Formation Group 2", class start is
        					19:00 and class finish is 20:00
        				</p>
        				<form class="form-horizontal" action="#" method="post">
        					<?php  	
        					    $weekDays = array("Monday", "Tuesday", "Wednesday","Thursday", "Friday", "Saturday", "Sunday");
        					    
        					    $dayId = 0;
        					    
        					    #table header names
        					    foreach($weekDays as $weekDay)
        					    {
        					        echo "<div class=\"form-group\">";
        					        echo "<label class=\"control-label col-sm-2\" for=\"inputLastClass\">" . $weekDay . "</label>";
        					        echo "<div class=\"col-sm-10\">";
        					        echo "<textarea id=\"editDataDay" . $dayId . "\" class=\"form-control\" rows=\"2\" name=\"inputEditDataDay" . $dayId . "\"></textarea>";
        					        echo "</div>";
        					        echo "</div>";
        					        
        					        $dayId = $dayId + 1;
        					    }
        					    
							?>
							
							<input type="text" id="editScheduleId" name="inputEditScheduleId" class="hidden">
							
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
								<button type="submit" name="submittedDaysSaveButton" class="btn btn-default">Save</button>
							</div><!-- modal-footer -->
						</form>
        				
					</div><!-- modal-body -->
				</div><!--modal-content-->
	  		</div><!--modal-dialog-->
		</div><!-- Modal --> 
		
		<?php require("../template/footer.html"); ?>
		
		<script type="text/javascript" >
		
			function ShowScheduleModal(scheduleId)
			{
				newsCaption="Undefined";
				$("#scheduleId").attr("value",-1);
				
				if(scheduleId==null)
				{		
					//something is wrong

				}
				else
				{
					idTarget="#scheduleName";
					idSource=idTarget + "_" + scheduleId;
					$(idTarget).text($(idSource).text());
					
					newsCaption="Edit '" + $(idSource).text() + "' schedule";
					
					idTarget="#showSchedule";
					idSource=idTarget + "_" + scheduleId;
					$(idTarget).prop("checked",$(idSource).text()=="Yes");

					idTarget="#firstClass";
					idSource=idTarget + "_" + scheduleId;
					$(idTarget).text($(idSource).text());

					idTarget="#lastClass";
					idSource=idTarget + "_" + scheduleId;
					$(idTarget).text($(idSource).text());

					idTarget="#noClasses";
					idSource=idTarget + "_" + scheduleId;
					$(idTarget).text($(idSource).text());

					idTarget="#scheduleOrder";
					idSource=idTarget + "_" + scheduleId;
					$(idTarget).attr("value",$(idSource).text());
					
					idTarget="#scheduleId";
					$(idTarget).attr("value",scheduleId);
				}
				
				$("#scheduleModalCaption").text(newsCaption);
				
				$("#scheduleModal").modal();
				
				return false;
			}

			function ShowScheduleDaysModal(scheduleId)
			{
				var newsCaption="Undefined";
				$("#editScheduleId").attr("value",-1);
				
				if(scheduleId==null)
				{		
					//something is wrong

				}
				else
				{
					idTarget="#scheduleName";
					idSource=idTarget + "_" + scheduleId;
					$(idTarget).text($(idSource).text());
					
					newsCaption="Edit '" + $(idSource).text() + "' schedule";
					
					for(iDay = 0; iDay < 7; iDay++)
					{
						var idSource = "storedDataDay" + iDay;
						var idTarget = "#editDataDay" + iDay;
						
    					var dataStored = document.getElementById(idSource);
    					if(dataStored)
    					{
        					$(idTarget).text(dataStored.dataset.day);
    					}
					}

					idTarget="#editScheduleId";
					$(idTarget).attr("value",scheduleId);
				}
				
				$("#scheduleDaysModalCaption").text(newsCaption);
				
				$("#scheduleDaysModal").modal();
				
				return false;
			}
			
		</script>
	</body>
</html>
