<!DOCTYPE html>
<html lang="en">

	<?php
		require_once("../../template/macros.php");
		// page description
		$localWebPageDescription="Art of Soul Dance School add and edit web site news";
		// page title suffix
		$localWebPageTitle="Edit classes";
	?>
	
	<?php session_start();?>
	
	<?php require("../template/header.html"); ?>
  
	<body>
		<?php 
			require("../template/login.php");
			
			start("classes");
		?>
  		
    	
    	<?php function showMain()
		{
			require_once("../../data/data-classes.php");
		?>
		
		<?php
			//clicked Save button
			if(isset($_POST["submittedSaveButton"]))
			{
				$className=$_POST["inputClassName"];
				$coachName=$_POST["inputCoachName"];
				$colorName=$_POST["inputColorName"];
				$Id=$_POST["inputId"];
				
				$returnedDesc=writeClass($className
                    				    ,$coachName
                    				    ,$colorName
					                    ,$Id);
				if($returnedDesc)
				{
				    $errors = array($returnedDesc);
				}
			}
			
		?>
		
		<!-- page content -->
		<div id="firstContainer" class="container">
			<div class="panel panel-default">
  				<div class="panel-heading">
    				<h1 class="panel-title">Edit classes</h1>
  				</div>
  				<div class="panel-body">
  					<?php
						if (isset($_POST["submittedSaveButton"])) 
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
		  						
		  						if(isset($_POST["submittedSaveButton"]))
		  						{
		  							$successMessage="Class savedd successfully";
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
					<div class="table-responsive">
					<table class="table table-striped table-bordered table-condensed">
						<thead>
							<tr>
								<th class="text-center">Id</th>
								<th class="text-center">Class Name</th>
								<th class="text-center">Coach Name</th>
							</tr>
						</thead>
				   		<tbody>
		  					<?php
  						
		  					    $classes = retrieveClasses();
		  						
		  					    foreach($classes as $class)
		  						{
									echo "<tr>";
									echo "<td id='Id_" . $class->id . "'><a href=\"#\" onclick=\"return ShowClassModal(" . $class->id . ")\">" . $class->id . "</a></td>";
									echo "<td id='className_" . $class->id . "' style='color:" . $class->colorName . "' data-classname='" . $class->className . "' data-colorname='". $class->colorName . "'>" . $class->className . "</td>";
									echo "<td id='coachName_" . $class->id . "' data-coachname='" . $class->coachName . "'>" . $class->coachName . "</td>";
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
		<div id="classModal" class="modal fade" role="dialog" data-backdrop="static">
  			<div class="modal-dialog modal-lg">
    			<!-- Modal content-->
    			<div class="modal-content">
    			
      				<div class="modal-header">
        				<button type="button" class="close" data-dismiss="modal">&times;</button>
        				<h4 id="classModalCaption" class="modal-title"></h4>
      				</div><!-- modal-header -->
      				
      				<div class="modal-body">
        				
        				<form class="form" action="#" method="post">
							<div class="form-group">
								<label for="inputClassName">Class name</label>
								<textarea id="className" class="form-control" rows="2" name="inputClassName" placeholder="Class name" required></textarea>
							</div>
							<div class="form-group">
								<label for="inputCoachName">Coach name</label>
								<textarea id="coachName" class="form-control" rows="2" name="inputCoachName" placeholder="Coach name"></textarea>
							</div>
							
							<div class="form-group">
                                <label class="control-label">Class color</label>
                                  <select id="colorName" class="combobox form-control" name="horizontal" required="required" onchange="colorChanged()">
                                  	<option value="" selected="selected">Select a color</option>
                                  	<?php 
                                  	     $colors = retrieveColorNames();
                                  	     foreach($colors as $color)
                                  	     {
                                  	         echo "<option value=\"" . $color . "\">" . $color . "</option>";
                                  	     }
                                  	?>
                                  </select>
                              </div>
							
							<input type="text" id="colorNamePost" name="inputColorName" class="hidden">
							<input type="text" id="Id" name="inputId" class="hidden">
							
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
								<button type="submit" name="submittedSaveButton" class="btn btn-default">Save</button>
							</div><!-- modal-footer -->
						</form>
        				
					</div><!-- modal-body -->
				</div><!--modal-content-->
	  		</div><!--modal-dialog-->
		</div><!-- Modal --> 
		
		<?php require("../template/footer.html"); ?>
		
		<script type="text/javascript" >
		
			function ShowClassModal(id)
			{
				
				classCaption="Edit class #" + id;

				var elementName = "className";
				var idSource = elementName + "_" + id;
				var idTarget = "#" + elementName;
				var dataStored = document.getElementById(idSource);
				var colorName = dataStored.dataset.colorname;
				document.getElementById(elementName).style.color = colorName;
				$(idTarget).text(dataStored.dataset.classname);

				var idSource = "coachName_" + id;
				var idTarget = "#coachName";
				var dataStored = document.getElementById(idSource);
				$(idTarget).text(dataStored.dataset.coachname);

				var elementName = "colorName";
				document.getElementById(elementName).value = colorName;
				document.getElementById(elementName + "Post").value = colorName;
				
				idTarget="#Id";
				idSource=idTarget + "_" + id;
				$(idTarget).attr("value",$(idSource).text());
				
				$("#classModalCaption").text(classCaption);
				
				$("#classModal").modal();
				
				return false;
			}

			function colorChanged()
			{
				var elementName = "colorName";
				colorName = document.getElementById(elementName).value;
				document.getElementById(elementName + "Post").value = colorName;

				var elementName = "className";
				document.getElementById(elementName).style.color = colorName;
			}
		</script>
	</body>
</html>
