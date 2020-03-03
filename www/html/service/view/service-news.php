<!DOCTYPE html>
<html lang="en">

	<?php
		require_once("../../template/macros.php");
		// page description
		$localWebPageDescription="Art of Soul Dance School add and edit web site news";
		// page title suffix
		$localWebPageTitle="Add/Edit news";
	?>
	
	<?php session_start();?>
	
	<?php require("../template/header.html"); ?>
  
	<body>
		<?php 
			require("../template/login.php");
			
			start("news");
		?>
  		
    	
    	<?php function showMain()
		{
			require_once("../../data/data-news.php");
		?>
		
		<?php
			//clicked Save button
			if(isset($_POST["submittedSaveButton"]))
			{
				$ShowNews=$_POST["inputShowNews"]=="on"?1:0;
				$NewsDate=$_POST["inputDate"];
				$NewsText=$_POST["inputNewsText"];
				$ShowNewsMainPage=0;
				if(isset($_POST["inputShowNewsMainPage"]))
				{
					$ShowNewsMainPage=$_POST["inputShowNewsMainPage"]=="on"?1:0;
				}
				$ShowNewsMainPageFlag=substr($_POST["inputHowToShowMainPage"],0 ,1);
				$MainPageNewsText=$_POST["inputMainPageText"];
				$NewsTextShowCharsMainPage=$_POST["inputMainPageChars"];
				$Id=$_POST["inputId"];
				$WriteType=$Id==-1;
				
				$returnedDesc=writeNews($ShowNews
									   ,$NewsDate
									   ,$NewsText
									   ,$ShowNewsMainPage
									   ,$ShowNewsMainPageFlag
									   ,$MainPageNewsText
									   ,$NewsTextShowCharsMainPage
					                   ,$Id
									   ,$WriteType);
				echo $returnedDesc;
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
    				<h1 class="panel-title">Add/Edit news</h1>
  				</div>
  				<div class="panel-body">
  					<p>
						<button type="submit" class="btn btn-default" onclick="return ShowNewsModal(null)">Add news</button>
						<button type="button" class="btn btn-default" onclick="location.href='service-pictures';">Add picture</button>
					</p>
						<div class="table-responsive">
  						<table class="table table-striped table-bordered table-condensed">
  							<thead>
  								<tr>
  									<th class="text-center">Show<br>news</th>
  									<th class="text-center">Date</th>
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
			  						
			  						$newss=newsServicePage(true);
			  						
			  						foreach($newss as $news)
			  						{
			  							$showNews=$news[0];
			  							$newsDate=$news[1];
			  							$newsText=$news[2];
			  							$showNewsMainPage=$news[3];
			  							$showMainPageFlag=$news[4];
			  							$mainPageNewsText=$news[5];
			  							$mainPageNumberCharacter=$news[6];
			  							$Id=$news[7];
			  							
			  							$mainPageFlag="Undefined";
			  							
			  							switch ($showMainPageFlag)
			  							{
			  								case 1:
			  									$mainPageFlag="1 - main page text";
			  									break;
			  								case 2:
			  									$mainPageFlag="2 - n chars from news text";
			  									break;
			  							}
			  							
										echo "<tr>";
			  								
			  							echo "<td id='showNews_" . $newsDate . "'>" . ($showNews?"Yes":"No") . "</td>";
			  							echo "<td><a href=\"#\" onclick=\"return ShowNewsModal('" . $newsDate . "')\">" . $newsDate . "</a></td>";
			  							echo "<td id='newsText_" . $newsDate . "'>" . $newsText . "</td>";
			  							echo "<td id='showNewsMainPage_" . $newsDate . "'>" . ($showNewsMainPage?"Yes":"No") . "</td>";
			  							echo "<td id='mainPageFlag_" . $newsDate . "'>" . $mainPageFlag . "</td>";
			  							echo "<td id='mainPageNewsText_" . $newsDate . "'>" . $mainPageNewsText . "</td>";
			  							echo "<td id='mainPageNumberCharacter_" . $newsDate . "'>" . $mainPageNumberCharacter . "</td>";
			  							echo "<td id='Id_" . $newsDate . "'>" . $Id . "</td>";
			  								
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
		<div id="newsModal" class="modal fade" role="dialog" data-backdrop="static">
  			<div class="modal-dialog modal-lg">
    			<!-- Modal content-->
    			<div class="modal-content">
    			
      				<div class="modal-header">
        				<button type="button" class="close" data-dismiss="modal">&times;</button>
        				<h4 id="newsModalCaption" class="modal-title"></h4>
      				</div><!-- modal-header -->
      				
      				<div class="modal-body">
        				
        				<form class="form" action="#" method="post">
							<div class="checkbox">
								<label>
									<input id="showNews" type="checkbox" name="inputShowNews"><b>Show news</b>
								</label>
							</div>
							<div class="form-group">
								<label for="inputDate">Date (yyyy-mm-dd format)</label>
								<input id="newsDate" type="text" class="form-control" name="inputDate" placeholder="Date in yyyy-mm-dd format" required>
							</div>
							<div class="form-group">
								<label for="inputNewsText">Text</label>
								<textarea id="newsText" class="form-control" rows="4" name="inputNewsText" placeholder="News text"></textarea>
							</div>
							<div class="checkbox">
								<label>
									<input id="showNewsMainPage" type="checkbox" name="inputShowNewsMainPage"><b>Show news on main page</b>
								</label>
							</div>
							<div class="form-group">
								<label for="inputHowToNewsMainPage">How to show news on main page</label>
								<select id="mainPageFlag" class="form-control" name="inputHowToShowMainPage" required>
									<option>1 - main page text</option>
									<option>2 - n chars from news text</option>
								</select>
							</div>
							<div class="form-group">
								<label for="inputMainPageText">Main page text</label>
								<textarea id="mainPageNewsText" class="form-control" rows="2" name="inputMainPageText" placeholder="Main page text"></textarea>
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
		
		<div class="visible-lg visible-md">  
    		<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    	</div>		
		
		<?php require("../template/footer.html"); ?>
		
		<script type="text/javascript" >
		
			function ShowNewsModal(newsDate)
			{
				newsCaption="Add news";
				$("#Id").attr("value",-1);
				
				if(newsDate==null)
				{
					$("#newsDate").attr("value","");

					idTarget="#showNews";
					idSource=idTarget + "_" + newsDate;
					$(idTarget).prop("checked",true);

					idTarget="#newsText";
					idSource=idTarget + "_" + newsDate;
					$(idTarget).text("");

					idTarget="#showNewsMainPage";
					idSource=idTarget + "_" + newsDate;
					$(idTarget).prop("checked",false);

					idTarget="#mainPageFlag";
					idSource=idTarget + "_" + newsDate;
					$(idTarget).val("");
					
					idTarget="#mainPageNewsText";
					idSource=idTarget + "_" + newsDate;
					$(idTarget).text("");

					idTarget="#mainPageNumberCharacter";
					idSource=idTarget + "_" + newsDate;
					$(idTarget).attr("value",0);
				}
				else
				{
					newsCaption="Edit '" + newsDate + "' news";
					
					$("#newsDate").attr("value",newsDate);

					idTarget="#showNews";
					idSource=idTarget + "_" + newsDate;
					$(idTarget).prop("checked",$(idSource).text()=="Yes");

					idTarget="#newsText";
					idSource=idTarget + "_" + newsDate;
					$(idTarget).text($(idSource).text());

					idTarget="#showNewsMainPage";
					idSource=idTarget + "_" + newsDate;
					$(idTarget).prop("checked",$(idSource).text()=="Yes");

					idTarget="#mainPageFlag";
					idSource=idTarget + "_" + newsDate;
					$(idTarget).val($(idSource).text());
					
					idTarget="#mainPageNewsText";
					idSource=idTarget + "_" + newsDate;
					$(idTarget).text($(idSource).text());

					idTarget="#mainPageNumberCharacter";
					idSource=idTarget + "_" + newsDate;
					$(idTarget).attr("value",$(idSource).text());

					idTarget="#Id";
					idSource=idTarget + "_" + newsDate;
					$(idTarget).attr("value",$(idSource).text());
				}
				
				$("#newsModalCaption").text(newsCaption);
				
				$("#newsModal").modal();
				
				return false;
			}
			
		</script>
	</body>
</html>
