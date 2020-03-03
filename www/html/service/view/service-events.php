<!DOCTYPE html>
<html lang="en">

<?php
	require_once("../../template/macros.php");
	// page description
	$localWebPageDescription="Art of Soul Dance School add and edit web site events";
	// page title suffix
	$localWebPageTitle="Add/Edit events";
?>
	
	<?php session_start();?>
	
	<?php require("../template/header.html"); ?>
  
	<body>
		
		<?php 
			require("../template/login.php");
			
			start("events");
		?>
		
    	<?php function showMain()
		{
			require_once("../../data/data-events.php");
		?>
		
		<?php
			//clicked Save button
			if(isset($_POST["submittedSaveButton"]))
			{
				$ShowEvent=$_POST["inputShowEvent"]=="on"?1:0;
				$EventDate=$_POST["inputDate"];
				$EventCaption=$_POST["inputCaption"];
				$EventText=$_POST["inputEventText"];
				$ShowEventMainPage=0;
				if(isset($_POST["inputShowEventMainPage"]))
				{
					$ShowEventMainPage=$_POST["inputShowEventMainPage"]=="on"?1:0;
				}
				$ShowEventMainPageFlag=substr($_POST["inputHowToShowMainPage"],0 ,1);
				$MainPageEventText=$_POST["inputMainPageText"];
				$EventTextShowCharsMainPage=$_POST["inputMainPageChars"];
				$Id=$_POST["inputId"];
				$WriteType=$Id==-1;
				
				$returnedDesc=writeEvents($ShowEvent
										 ,$EventDate
										 ,$EventCaption
										 ,$EventText
										 ,$ShowEventMainPage
										 ,$ShowEventMainPageFlag
										 ,$MainPageEventText
										 ,$EventTextShowCharsMainPage
						                 ,$Id
										 ,$WriteType);
			}
			
			//clicked Preview button
			if(isset($_POST["submittedPreviewButton"]))
			{
				//not developed yet
			}
			
		?>
		<!-- page content -->
		<div id="firstContainer" class="container">
			<div class="panel panel-default">
  				<div class="panel-heading">
    				<h1 class="panel-title">Add/Edit events</h1>
  				</div>
  				<div class="panel-body">
  					<p>
						<button type="submit" class="btn btn-default" onclick="return ShowEventModal(null)">Add event</button>
						<button type="button" class="btn btn-default" onclick="location.href='service-pictures';">Add picture</button>
					</p>
						<div class="table-responsive">
  						<table class="table table-striped table-bordered table-condensed">
  							<thead>
  								<tr>
  									<th class="text-center">Show event</th>
  									<th class="text-center">Date</th>
  									<th class="text-center">Caption</th>
  									<th class="text-center">Text</th>
  									<th class="text-center">Show on main page</th>
  									<th class="text-center">How to show on main page</th>
  									<th class="text-center">Main page text</th>
  									<th class="text-center">Main page chars</th>
  									<th class="text-center">Id</th>
								</tr>
							</thead>
					   		<tbody>
			  					<?php
			  						$colNumber=1;
			  						
			  						$events=eventsServicePage(true);
			  						
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
			  							$Id=$event[8];
			  							
			  							$mainPageFlag="Undefined";
			  							
			  							switch ($showMainPageFlag) 
			  							{
			  								case 0:
			  									$mainPageFlag="0 - only caption";
			  									break;
			  								case 1:
			  									$mainPageFlag="1 - main page text";
			  									break;
			  								case 2:
			  									$mainPageFlag="2 - n chars from event text";
			  									break;
			  							}
			  							
										echo "<tr>";
			  								
			  							echo "<td id='showEvent_" . $eventDate . "'>" . ($showEvent?"Yes":"No") . "</td>";
			  							echo "<td><a href=\"#\" onclick=\"return ShowEventModal('" . $eventDate . "')\">" . $eventDate . "</a></td>";
			  							echo "<td id='eventCaption_" . $eventDate . "'>" . $eventCaption . "</td>";
			  							echo "<td id='eventText_" . $eventDate . "'>" . $eventText . "</td>";
			  							echo "<td id='showEventMainPage_" . $eventDate . "'>" . ($showEventMainPage?"Yes":"No") . "</td>";
			  							echo "<td id='mainPageFlag_" . $eventDate . "'>" . $mainPageFlag . "</td>";
			  							echo "<td id='mainPageEventText_" . $eventDate . "'>" . $mainPageEventText . "</td>";
			  							echo "<td id='mainPageNumberCharacter_" . $eventDate . "'>" . $mainPageNumberCharacter . "</td>";
			  							echo "<td id='Id_" . $eventDate . "'>" . $Id . "</td>";
			  								
			  							echo "</tr>";
			  						}
			    				?>
    						</tbody>
						</table>
					</div>
  				</div>
			</div>  
		</div>
		<?php
		}
    	?>
    	
    	<!-- Modal -->
		<div id="eventModal" class="modal fade" role="dialog" data-backdrop="static">
  			<div class="modal-dialog modal-lg">
    			<!-- Modal content-->
    			<div class="modal-content">
    			
      				<div class="modal-header">
        				<button type="button" class="close" data-dismiss="modal">&times;</button>
        				<h4 id="eventModalCaption" class="modal-title"></h4>
      				</div><!-- modal-header -->
      				
      				<div class="modal-body">
        				
        				<form class="form" action="#" method="post">
							<div class="checkbox">
								<label>
									<input id="showEvent" type="checkbox" name="inputShowEvent"><b>Show event</b>
								</label>
							</div>
							<div class="form-group">
								<label for="inputEmail">Date (yyyy-mm-dd format)</label>
								<input id="eventDate" type="text" class="form-control" name="inputDate" placeholder="Date in yyyy-mm-dd format" required>
							</div>
							<div class="form-group">
								<label for="inputCaption">Caption</label>
								<input id="eventCaption" type="text" class="form-control" name="inputCaption" placeholder="Event caption" required>
							</div>
							<div class="form-group">
								<label for="inputEventText">Text</label>
								<textarea id="eventText" class="form-control" rows="4" name="inputEventText" placeholder="Event text"></textarea>
							</div>
							<div class="checkbox">
								<label>
									<input id="showEventMainPage" type="checkbox" name="inputShowEventMainPage"><b>Show event on main page</b>
								</label>
							</div>
							<div class="form-group">
								<label for="inputHowToShowMainPage">How to show event on main page</label>
								<select id="mainPageFlag" class="form-control" name="inputHowToShowMainPage" required>
									<option>0 - only caption</option>
									<option>1 - main page text</option>
									<option>2 - n chars from event text</option>
								</select>
							</div>
							<div class="form-group">
								<label for="inputMainPageText">Main page text</label>
								<textarea id="mainPageEventText" class="form-control" rows="2" name="inputMainPageText" placeholder="Main page text"></textarea>
							</div>
							<div class="form-group">
								<label for="inputMainPageChars">Main page chars</label>
								<input id="mainPageNumberCharacter" type="number" class="form-control" name="inputMainPageChars" placeholder="Main page chars" required>
							</div>
							
							<input type="text" id="Id" name="inputId" class="hidden">
							
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
								<!-- button type="button" name="submittedPreviewButton" class="btn btn-default">Preview</button-->
								<button type="submit" name="submittedSaveButton" class="btn btn-default">Save</button>
							</div><!-- modal-footer -->
						</form>
        				
					</div><!-- modal-body -->
				</div><!--modal-content-->
	  		</div><!--modal-dialog-->
		</div><!-- Modal -->    			
		
		<?php require("../template/footer.html"); ?>
		
		<script type="text/javascript" >
		
			function ShowEventModal(eventDate)
			{
				eventCaption="Add event";
				$("#Id").attr("value",-1);
				
				if(eventDate==null)
				{
					$("#eventDate").attr("value","");

					idTarget="#showEvent";
					idSource=idTarget + "_" + eventDate;
					$(idTarget).prop("checked",true);

					idTarget="#eventCaption";
					idSource=idTarget + "_" + eventDate;
					$(idTarget).attr("value","");

					idTarget="#eventText";
					idSource=idTarget + "_" + eventDate;
					$(idTarget).text("");

					idTarget="#showEventMainPage";
					idSource=idTarget + "_" + eventDate;
					$(idTarget).prop("checked",false);

					idTarget="#mainPageFlag";
					idSource=idTarget + "_" + eventDate;
					$(idTarget).val("");
					
					idTarget="#mainPageEventText";
					idSource=idTarget + "_" + eventDate;
					$(idTarget).text("");

					idTarget="#mainPageNumberCharacter";
					idSource=idTarget + "_" + eventDate;
					$(idTarget).attr("value",0);
				}
				else
				{
					eventCaption="Edit '" + eventDate + "' event";
					
					$("#eventDate").attr("value",eventDate);

					idTarget="#showEvent";
					idSource=idTarget + "_" + eventDate;
					$(idTarget).prop("checked",$(idSource).text()=="Yes");

					idTarget="#eventCaption";
					idSource=idTarget + "_" + eventDate;
					$(idTarget).attr("value",$(idSource).text());

					idTarget="#eventText";
					idSource=idTarget + "_" + eventDate;
					$(idTarget).text($(idSource).text());

					idTarget="#showEventMainPage";
					idSource=idTarget + "_" + eventDate;
					$(idTarget).prop("checked",$(idSource).text()=="Yes");

					idTarget="#mainPageFlag";
					idSource=idTarget + "_" + eventDate;
					$(idTarget).val($(idSource).text());
					
					idTarget="#mainPageEventText";
					idSource=idTarget + "_" + eventDate;
					$(idTarget).text($(idSource).text());

					idTarget="#mainPageNumberCharacter";
					idSource=idTarget + "_" + eventDate;
					$(idTarget).attr("value",$(idSource).text());

					idTarget="#Id";
					idSource=idTarget + "_" + eventDate;
					$(idTarget).attr("value",$(idSource).text());
				}
				
				$("#eventModalCaption").text(eventCaption);
				
				$("#eventModal").modal();
				
				return false;
			}
			
		</script>
	</body>
</html>
