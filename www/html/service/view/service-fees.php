<!DOCTYPE html>
<html lang="en">

<?php
	require_once("../../template/macros.php");
	// page description
	$localWebPageDescription="Art of Soul Dance School edit web site schedule";
	// page title suffix
	$localWebPageTitle="Manage fees";
?>
	
	<?php session_start();?>
	
	<?php require("../template/header.html"); ?>
  
	<body>
		<?php 
			require("../template/login.php");
			
			start("fees");
		?>
  		
    	
    	<?php function showMain()
		{
			require_once("../../data/data-fee.php");
		?>
		
		<?php
			//clicked Save button of Payment information
			if(isset($_POST["submittedSavePaymentInformationButton"]))
			{
				$periodName = $_POST["inputPeriodName"];
				$firstClass = $_POST["inputFirstClass"];
				$lastClass = $_POST["inputLastClass"];
				$postDatedCheques = $_POST["inputPostDatedCheques"];
				$deadlineFullSessionPayment = $_POST["inputDeadlineFullSessionPayment"];
				$sessionDuration = $_POST["inputSessionDuration"];
				$mergedPaymentPeriods = $_POST["inputMergedPaymentPeriods"];
				$makeupLessons = $_POST["inputMakeupLessons"];
				$paymentInformationId = $_POST["inputPaymentInformationId"];
				
				$returnedDesc=writePaymentInformation($periodName,
                                    				  $firstClass,
                                    				  $lastClass,
                                    				  $postDatedCheques,
                                    				  $deadlineFullSessionPayment,
                                    				  $sessionDuration,
                                    				  $mergedPaymentPeriods,
                                    				  $makeupLessons,
                                    				  $paymentInformationId);
				if($returnedDesc)
				{
				    $errors = array($returnedDesc);
				}
			}
			
			//clicked Save button of Group lessons
			if(isset($_POST["submittedSaveGroupLessonsButton"]))
			{
			    
			    $feeGroupLessons = array();
			    
			    for($groupLessonId=1; $groupLessonId<13; $groupLessonId++)
			    {
			        $showLesson = 0;
			        if(isset($_POST["inputEditGroupLessonsShow" . $groupLessonId]))
			        {
			            $showLesson = 1;
			        }
			        $duration = $_POST["inputEditGroupLessonsDuration" . $groupLessonId];
			        $lessonPayments = $_POST["inputEditGroupLessonsPayemnts" . $groupLessonId];
			        $lessonOrder = $_POST["inputEditGroupLessonsOrder" . $groupLessonId];
    			    
    			    $feeGroupLesson = array($duration,
                        			        $lessonPayments,
                        			        $showLesson,
                        			        $lessonOrder,
    			                            $groupLessonId
    			    );
    			    
    			    array_push($feeGroupLessons, $feeGroupLesson);
			    }
			    
			    $paymentInformationId = $_POST["inputpaymentInformationIdInGroupLessons"];
			    
			    $returnedDesc=writeGroupLessons($paymentInformationId, $feeGroupLessons);
			    if($returnedDesc)
			    {
			        $errors = array($returnedDesc);
			    }
			}
			
			//clicked Save button of Private lessons
			if(isset($_POST["submittedSavePrivateLessonsButton"]))
			{
			    
			    $feePrivateLessons = array();
			    
			    for($privateLessonId=1; $privateLessonId<13; $privateLessonId++)
			    {
			        $showLesson = 0;
			        if(isset($_POST["inputEditPrivateLessonsShow" . $privateLessonId]))
			        {
			             $showLesson = 1;
			        }
			        $level = $_POST["inputEditPrivateLessonsLevel" . $privateLessonId];
			        $payment = $_POST["inputEditPrivateLessonsPayment" . $privateLessonId];
			        $lessonOrder = $_POST["inputEditPrivateLessonsOrder" . $privateLessonId];
			        
			        $feePrivateLesson = array($level,
                    			              $payment,
                    			              $showLesson,
                    			              $lessonOrder,
                    			              $privateLessonId
			        );
			        
			        array_push($feePrivateLessons, $feePrivateLesson);
			    }
			    
			    $paymentInformationId = $_POST["inputpaymentInformationIdInPrivateLessons"];
			    
			    $returnedDesc=writePrivateLessons($paymentInformationId, $feePrivateLessons);
			    if($returnedDesc)
			    {
			        $errors = array($returnedDesc);
			    }
			}
			
			//clicked Save button of special instructions lessons
			if(isset($_POST["submittedSaveSpecialInstructionsButton"]))
			{
			    $specialInstructions = array();
			    
			    for($specialInstructionsId=1; $specialInstructionsId<13; $specialInstructionsId++)
			    {
			        $showText = 0;
			        if(isset($_POST["inputEditSpecialInstructionsShow" . $specialInstructionsId]))
			        {
			            $showText = 1;
			        }
			        $text = $_POST["inputEditSpecialInstructionsText" . $specialInstructionsId];
			        $textOrder = $_POST["inputEditSpecialInstructionsOrder" . $specialInstructionsId];
			        
			        $specialInstruction = array($text,
                        			            $showText,
                        			            $textOrder,
                        			            $specialInstructionsId
			        );
			        
			        array_push($specialInstructions, $specialInstruction);
			    }
			    
			    $paymentInformationId = $_POST["inputpaymentInformationIdInSpecialInstructions"];
			    
			    $returnedDesc=writeSpecialInstructions($paymentInformationId, $specialInstructions);
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
    				<h1 class="panel-title">Manage fees</h1>
  				</div>
  				<div class="panel-body">
  					<?php
						if (isset($_POST["submittedSavePaymentInformationButton"]) or isset($_POST["submittedSaveButton"])) 
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
		  						
		  						if(isset($_POST["submittedSavePaymentInformationButton"]))
		  						{
		  							$successMessage="Payment Information savedd successfully";
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
					<h3 class="text-center">Payment Information</h3>
					<div class="table-responsive">
  						<table class="table table-striped table-bordered table-condensed">
  							<thead>
  								<tr>
  									<th class="text-center">Period name</th>
  									<th class="text-center">First class</th>
  									<th class="text-center">Last class</th>
  									<th class="text-center">Post dated cheques</th>
  									<th class="text-center">Deadline full session payment</th>
  									<th class="text-center">Session duration</th>
  									<th class="text-center">Merged payment periods</th>
  									<th class="text-center">Makeup lessons</th>
  									<th class="text-center">Id</th>
								</tr>
							</thead>
					   		<tbody>
			  					<?php
			  					    $fees=serviceFees();	
			  					
			  					    foreach($fees as $fee)
			  						{
			  						    $periodName = $fee[0];
			  						    $firstClass = $fee[1];
			  						    $lastClass = $fee[2];
			  						    $postDatedCheques = implode(";",$fee[3]);
			  						    $deadlineFullSessionPayment = $fee[4];
			  						    $sessionDuration = $fee[5];
			  						    $makeupLessons = implode(";",$fee[6]);
			  						    $Id = $fee[7];
			  						    $mergedPeriods = implode(";",$fee[8]);
			  						    $mergedPeriodsHeaderText = $fee[9];
			  						    $feePeriods = $fee[10];
			  						    $feeGroupLessons = $fee[11];
			  						    $feePrivateLessons = $fee[12];
			  						    $specialInstructions = $fee[13];
			  						    
			  						    echo "<tr>";
			  							
			  						    echo "<td id='periodName_" . $Id . "'><a href=\"#\" onclick=\"return ShowPaymentInformationModal(" . $Id . ")\">" . $periodName . "</a></td>";
			  						    echo "<td id='firstClass_" . $Id . "'>" . $firstClass . "</td>";
			  						    echo "<td id='lastClass_" . $Id . "'>" . $lastClass . "</td>";
			  						    echo "<td id='postDatedCheques_" . $Id . "'>" . $postDatedCheques . "</td>";
			  						    echo "<td id='deadlineFullSessionPayment_" . $Id . "'>" . $deadlineFullSessionPayment . "</td>";
			  						    echo "<td id='sessionDuration_" . $Id . "'>" . $sessionDuration . "</td>";
			  						    echo "<td id='mergedPaymentPeriods_" . $Id . "'>" . $mergedPeriods . "</td>";
			  						    echo "<td id='makeupLessons_" . $Id . "'>" . $makeupLessons . "</td>";
			  						    echo "<td id='scheduleId_" . $Id . "'>" . $Id . "</td>";
			  							
			  							echo "</tr>";
			  						}
			    				?>
    						</tbody>
						</table>
					</div>
					
					<?php 
					    #show group lessons table
					    echo "<h3><center><a href=\"#\" onclick=\"return ShowGroupLessonsModal(" . $Id . ")\">Group Lessons for " . $periodName . "</a></center></h3>";
    					echo "<div class=\"table-responsive\">";
    					echo "<table class=\"table table-striped table-bordered table-condensed\">";
    					echo "  <thead>";
    					echo "    <tr>";
    					echo "	   <th rowspan=\"2\" style=\"text-align:center;\">";
    					echo "		  Hours/</br>Week";
    					echo "	   </th>";
    					echo "	   <th rowspan=\"2\" style=\"text-align:center;\">";
    					echo "		  Total</br>Session";
    					echo "	   </th>";
    					echo "      <th colspan=\"" . sizeof($feePeriods) . "\" style=\"text-align:center;\">Monthly Fee</th>";
    					echo "    </tr>";
    					
    					echo "    <tr>";
    					#table header names
    					foreach($feePeriods as $feePeriod)
    					{
    					    echo "<th style=\"text-align:center;\">" . $feePeriod . "</th>";
    					}
    					
    					echo "    </tr>";
    					echo "  </thead>";
    					echo "  <tbody>";

    					foreach($feeGroupLessons as $feeGroupLesson)
    					{
    					    $groupLessonId = $feeGroupLesson[5];
    					    
    					    if($feeGroupLesson[3]==1)
    					    {
    					       $hideRow="";
    					    }
    					    else {
    					        $hideRow=" class=\"hidden\"";
    					    }
    					    
    					    echo "<tr". $hideRow . ">";
    					    
    					    $dataStorage = "data-payments=\"" . $feeGroupLesson[2] . "\" data-feeorder=\"" . $feeGroupLesson[4] . "\"";
    					    
    					    echo "<td id='duration_" . $groupLessonId . "' " . $dataStorage . ">" . $feeGroupLesson[1] . "</td>";
    					    
    					    $payments = explode(";" ,$feeGroupLesson[2]);
    					    if(sizeof($payments)==1){
    					        for($i=0; $i<=sizeof($feePeriods); $i++){
    					            echo "<td>N/A</td>";
    					        }
    					    }
    					    else{
        					    foreach($payments as $payment)
        					    {
        					        echo "<td>" . $payment . "</td>";
        					    }
    					    }
    					    echo "</tr>";
    					}
    					
					    echo "</tbody>";
  				        echo "</table>";
  				        echo "</div>";
  				        
  				        # show private lessons table
  				        echo "<h3><center><a href=\"#\" onclick=\"return ShowPrivateLessonsModal(" . $Id . ")\">Private Lessons for " . $periodName . "</a></center></h3>";
  				        echo "<div class=\"table-responsive\">";
  				        echo "<table class=\"table table-striped table-bordered table-condensed\">";
  				        echo "  <thead>";
  				        echo "    <tr>";
  				        echo "	   <th style=\"text-align:center;\">";
  				        echo "		  Level</br></br>";
  				        echo "	   </th>";
  				        echo "	   <th style=\"text-align:center;\">";
  				        echo "		  Payment</br>per couple</br>10 lessons";
  				        echo "	   </th>";
  				        echo "    </tr>";
  				        echo "  </thead>";
  				        echo "  <tbody>";
  				        
  				        foreach($feePrivateLessons as $feePrivateLesson)
  				        {
  				            $privateLessonId = $feePrivateLesson[5];
  				            
  				            if($feePrivateLesson[3]==1)
  				            {
  				                $hideRow="";
  				            }
  				            else {
  				                $hideRow=" class=\"hidden\"";
  				            }
  				            
  				            echo "<tr". $hideRow . ">";
  				            
  				            $dataStorage = "data-feeorder=\"" . $feePrivateLesson[4] . "\"";
  				            
  				            echo "<td id='level_" . $privateLessonId . "' " . $dataStorage . ">" . $feePrivateLesson[1] . "</td>";
  				            echo "<td id='payment_" . $privateLessonId . "'>" . $feePrivateLesson[2] . "</td>";
  				            echo "</tr>";
  				        }
  				        
  				        echo "</tbody>";
  				        echo "</table>";
  				        echo "</div>";
  				        
  				        # show special instructions table
  				        echo "<h3><center><a href=\"#\" onclick=\"return ShowSpecialInstructionsModal(" . $Id . ")\">Special Instructions for " . $periodName . "</a></center></h3>";
  				        echo "<div class=\"table-responsive\">";
  				        echo "<table class=\"table table-striped table-bordered table-condensed\">";
  				        echo "  <thead>";
  				        echo "    <tr>";
  				        echo "	   <th style=\"text-align:center;\">";
  				        echo "		  Text";
  				        echo "	   </th>";
  				        echo "    </tr>";
  				        echo "  </thead>";
  				        echo "  <tbody>";
  				        
  				        foreach($specialInstructions as $specialInstruction)
  				        {
  				            $specialInstructionsId = $specialInstruction[4];
  				            
  				            if($specialInstruction[2]==1)
  				            {
  				                $hideRow="";
  				            }
  				            else {
  				                $hideRow=" class=\"hidden\"";
  				            }
  				            
  				            echo "<tr". $hideRow . ">";
  				            
  				            $dataStorage = "data-textorder=\"" . $feePrivateLesson[4] . "\"";
  				            
  				            echo "<td id='text_" . $specialInstructionsId . "' " . $dataStorage . ">" . $specialInstruction[1] . "</td>";
  				            echo "</tr>";
  				        }
  				        
  				        echo "</tbody>";
  				        echo "</table>";
  				        echo "</div>";
  				    ?>
  				</div>
			</div>  
		</div>
		<?php
		}
    	?>
		
		<!-- Modal Payment Information-->
		<div id="paymentInformationModal" class="modal fade" role="dialog" data-backdrop="static">
  			<div class="modal-dialog modal-lg">
    			<!-- Modal content-->
    			<div class="modal-content">
    			
      				<div class="modal-header">
        				<button type="button" class="close" data-dismiss="modal">&times;</button>
        				<h4 id="paymentInformationModalCaption" class="modal-title"></h4>
      				</div><!-- modal-header -->
      				
      				<div class="modal-body">
        				
        				<form class="form" action="#" method="post">
							
							<div class="form-group">
								<label for="inputPeriodName">Period name</label>
								<textarea id="periodName" class="form-control" rows="1" name="inputPeriodName" required></textarea>
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
								<label for="inputPostDatedCheques">Post dated cheques (dates separated by ";" semi-colon)</label>
								<textarea id="postDatedCheques" class="form-control" rows="2" name="inputPostDatedCheques"></textarea>
							</div>
							
							<div class="form-group">
								<label for="inputDeadlineFullSessionPayment">Deadline full session payment</label>
								<textarea id="deadlineFullSessionPayment" class="form-control" rows="1" name="inputDeadlineFullSessionPayment"></textarea>
							</div>
							
							<div class="form-group">
								<label for="inputSessionDuration">Session duration</label>
								<textarea id="sessionDuration" class="form-control" rows="1" name="inputSessionDuration"></textarea>
							</div>
							
							<div class="form-group">
								<label for="inputMergedPaymentPeriods">Merged payment periods (dates separated by ";" semi-colon)</label>
								<textarea id="mergedPaymentPeriods" class="form-control" rows="1" name="inputMergedPaymentPeriods"></textarea>
							</div>
							
							<div class="form-group">
								<label for="inputMakeupLessons">Makeup lessons (dates separated by ";" semi-colon)</label>
								<textarea id="makeupLessons" class="form-control" rows="2" name="inputMakeupLessons"></textarea>
							</div>
							
							<input type="text" id="paymentInformationId" name="inputPaymentInformationId" class="hidden">
							
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
								<button type="submit" name="submittedSavePaymentInformationButton" class="btn btn-default">Save</button>
							</div><!-- modal-footer -->
						</form>
        				
					</div><!-- modal-body -->
				</div><!--modal-content-->
	  		</div><!--modal-dialog-->
		</div><!-- Modal --> 
		
		<!-- Modal Group Lessons-->
		<div id="groupLessonsModal" class="modal fade" role="dialog" data-backdrop="static">
  			<div class="modal-dialog modal-lg">
    			<!-- Modal content-->
    			<div class="modal-content">
    			
      				<div class="modal-header">
        				<button type="button" class="close" data-dismiss="modal">&times;</button>
        				<h4 id="groupLessonsModalCaption" class="modal-title"></h4>
      				</div><!-- modal-header -->
      				
      				<div class="modal-body">
        				<p>
        					<b>Payments</b> field conains values seprated by ";" semi-colon character. The first value represents
        					a total of all amounts. Each amount defines a monthly or joint payments. For example, $400.00;$80.00;$80.00;$80.00;$160.00,
        					$400.00 is total of 4 payments. $80.00 is the first payment and $160.00 is the last payment
    					</p>
        					
        				<form class="form-horizontal" action="#" method="post">
							
							<?php  	
        					    
        					    #table header names
        					    for($groupLessonId=1; $groupLessonId<13; $groupLessonId++)
        					    {
        					        echo "<div class=\"checkbox\">";
        					        echo "<label>";
        					        echo "<input id=\"editGroupLessonsShow" . $groupLessonId . "\" type=\"checkbox\" name=\"inputEditGroupLessonsShow" . $groupLessonId . "\"><b>Show lesson # " . $groupLessonId . "</b>";
                                    echo "</label>";
        					        echo "</div>";
        					        
        					        echo "<p></p>";
        					        
        					        echo "<div class=\"form-group\">";
        					        echo "<label class=\"control-label col-sm-2\" for=\"inputeditGroupLessonsDuration\">Duration</label>";
        					        echo "<div class=\"col-sm-10\">";
        					        echo "<textarea id=\"editGroupLessonsDuration" . $groupLessonId . "\" class=\"form-control\" rows=\"1\" name=\"inputEditGroupLessonsDuration" . $groupLessonId . "\"></textarea>";
        					        echo "</div>";
        					        echo "</div>";
        					        
        					        echo "<div class=\"form-group\">";
        					        echo "<label class=\"control-label col-sm-2\" for=\"inputEditGroupLessonsPayemnts\">Payments</label>";
        					        echo "<div class=\"col-sm-10\">";
        					        echo "<textarea id=\"editGroupLessonsPayemnts" . $groupLessonId . "\" class=\"form-control\" rows=\"2\" name=\"inputEditGroupLessonsPayemnts" . $groupLessonId . "\"></textarea>";
        					        echo "</div>";
        					        echo "</div>";
        					        
        					        echo "<div class=\"form-group\">";
        					        echo "<label class=\"control-label col-sm-2\" for=\"inputEditDuration\">Fee order</label>";
        					        echo "<div class=\"col-sm-2\">";
        					        echo "<textarea id=\"editGroupLessonsOrder" . $groupLessonId . "\" class=\"form-control\" rows=\"1\" name=\"inputEditGroupLessonsOrder" . $groupLessonId . "\"></textarea>";
        					        echo "</div>";
        					        echo "</div>";
        					    }
        					    
							?>
							
							<input type="text" id="paymentInformationIdInGroupLessons" name="inputpaymentInformationIdInGroupLessons" class="hidden">
							
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
								<button type="submit" name="submittedSaveGroupLessonsButton" class="btn btn-default">Save</button>
							</div><!-- modal-footer -->
						</form>
        				
					</div><!-- modal-body -->
				</div><!--modal-content-->
	  		</div><!--modal-dialog-->
		</div><!-- Modal --> 
		
		<!-- Modal Private Lessons-->
		<div id="privateLessonsModal" class="modal fade" role="dialog" data-backdrop="static">
  			<div class="modal-dialog modal-lg">
    			<!-- Modal content-->
    			<div class="modal-content">
    			
      				<div class="modal-header">
        				<button type="button" class="close" data-dismiss="modal">&times;</button>
        				<h4 id="privateLessonsModalCaption" class="modal-title"></h4>
      				</div><!-- modal-header -->
      				
      				<div class="modal-body">
        				
        				<form class="form-horizontal" action="#" method="post">
							
							<?php  	
        					    
        					    #table header names
        					    for($privateLessonId=1; $privateLessonId<13; $privateLessonId++)
        					    {
        					        echo "<div class=\"checkbox\">";
        					        echo "<label>";
        					        echo "<input id=\"editPrivateLessonsShow" . $privateLessonId . "\" type=\"checkbox\" name=\"inputEditPrivateLessonsShow" . $privateLessonId . "\"><b>Show lesson # " . $privateLessonId . "</b>";
                                    echo "</label>";
        					        echo "</div>";
        					        
        					        echo "<p></p>";
        					        
        					        echo "<div class=\"form-group\">";
        					        echo "<label class=\"control-label col-sm-2\" for=\"inputPrivateLessonsLevel\">Level</label>";
        					        echo "<div class=\"col-sm-10\">";
        					        echo "<input id=\"editPrivateLessonsLevel" . $privateLessonId . "\" class=\"form-control\" rows=\"1\" name=\"inputEditPrivateLessonsLevel" . $privateLessonId . "\"></input>";
        					        echo "</div>";
        					        echo "</div>";
        					        
        					        echo "<div class=\"form-group\">";
        					        echo "<label class=\"control-label col-sm-2\" for=\"inputEditPrivateLessonsPayment\">Payment</label>";
        					        echo "<div class=\"col-sm-10\">";
        					        echo "<textarea id=\"editPrivateLessonsPayment" . $privateLessonId . "\" class=\"form-control\" rows=\"2\" name=\"inputEditPrivateLessonsPayment" . $privateLessonId . "\"></textarea>";
        					        echo "</div>";
        					        echo "</div>";
        					        
        					        echo "<div class=\"form-group\">";
        					        echo "<label class=\"control-label col-sm-2\" for=\"inputEditPrivateLessonsOrder\">Fee order</label>";
        					        echo "<div class=\"col-sm-2\">";
        					        echo "<input type=\"number\" min=0 max=255 id=\"editPrivateLessonsOrder" . $privateLessonId . "\" class=\"form-control\" name=\"inputEditPrivateLessonsOrder" . $privateLessonId . "\"></input>";
        					        echo "</div>";
        					        echo "</div>";
        					    }
        					    
							?>
							
							<input type="text" id="paymentInformationIdInPrivateLessons" name="inputpaymentInformationIdInPrivateLessons" class="hidden">
							
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
								<button type="submit" name="submittedSavePrivateLessonsButton" class="btn btn-default">Save</button>
							</div><!-- modal-footer -->
						</form>
        				
					</div><!-- modal-body -->
				</div><!--modal-content-->
	  		</div><!--modal-dialog-->
		</div><!-- Modal --> 
		
		<!-- Modal Special Instructions -->
		<div id="specialInstructionsModal" class="modal fade" role="dialog" data-backdrop="static">
  			<div class="modal-dialog modal-lg">
    			<!-- Modal content-->
    			<div class="modal-content">
    			
      				<div class="modal-header">
        				<button type="button" class="close" data-dismiss="modal">&times;</button>
        				<h4 id="specialInstructionsModalCaption" class="modal-title"></h4>
      				</div><!-- modal-header -->
      				
      				<div class="modal-body">
        				
        				<form class="form-horizontal" action="#" method="post">
							
							<?php  	
        					    
        					    #table header names
							    for($specialInstructionId=1; $specialInstructionId<13; $specialInstructionId++)
        					    {
        					        echo "<div class=\"checkbox\">";
        					        echo "<label>";
        					        echo "<input id=\"editSpecialInstructionsShow" . $specialInstructionId . "\" type=\"checkbox\" name=\"inputEditSpecialInstructionsShow" . $specialInstructionId . "\"><b>Show Text # " . $specialInstructionId . "</b>";
                                    echo "</label>";
        					        echo "</div>";
        					        
        					        echo "<p></p>";
        					        
        					        echo "<div class=\"form-group\">";
        					        echo "<label class=\"control-label col-sm-2\" for=\"inputSpecialInstructionsText\">Text</label>";
        					        echo "<div class=\"col-sm-10\">";
        					        echo "<input id=\"editSpecialInstructionsText" . $specialInstructionId . "\" class=\"form-control\" rows=\"1\" name=\"inputEditSpecialInstructionsText" . $specialInstructionId . "\"></input>";
        					        echo "</div>";
        					        echo "</div>";
        					        
        					        echo "<div class=\"form-group\">";
        					        echo "<label class=\"control-label col-sm-2\" for=\"inputEditSpecialInstructionsOrder\">Text order</label>";
        					        echo "<div class=\"col-sm-2\">";
        					        echo "<input type=\"number\" min=0 max=255 id=\"editSpecialInstructionsOrder" . $specialInstructionId . "\" class=\"form-control\" name=\"inputEditSpecialInstructionsOrder" . $specialInstructionId . "\"></input>";
        					        echo "</div>";
        					        echo "</div>";
        					    }
        					    
							?>
							
							<input type="text" id="paymentInformationIdInSpecialInstructions" name="inputpaymentInformationIdInSpecialInstructions" class="hidden">
							
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
								<button type="submit" name="submittedSaveSpecialInstructionsButton" class="btn btn-default">Save</button>
							</div><!-- modal-footer -->
						</form>
        				
					</div><!-- modal-body -->
				</div><!--modal-content-->
	  		</div><!--modal-dialog-->
		</div><!-- Modal --> 
		
		<?php require("../template/footer.html"); ?>
		
		<script type="text/javascript" >
		
			function ShowPaymentInformationModal(formId)
			{
				formCaption="Undefined";
				
				$("#paymentInformationId").attr("value",-1);
				
				if(formId==null)
				{		
					//something is wrong
				}
				else
				{
					idTarget="#periodName";
					idSource=idTarget + "_" + formId;
					$(idTarget).text($(idSource).text());
					
					formCaption="Edit '" + $(idSource).text() + "' period";

					idTarget="#firstClass";
					idSource=idTarget + "_" + formId;
					$(idTarget).text($(idSource).text());

					idTarget="#lastClass";
					idSource=idTarget + "_" + formId;
					$(idTarget).text($(idSource).text());

					idTarget="#postDatedCheques";
					idSource=idTarget + "_" + formId;
					$(idTarget).text($(idSource).text());

					idTarget="#deadlineFullSessionPayment";
					idSource=idTarget + "_" + formId;
					$(idTarget).text($(idSource).text());

					idTarget="#sessionDuration";
					idSource=idTarget + "_" + formId;
					$(idTarget).text($(idSource).text());

					idTarget="#mergedPaymentPeriods";
					idSource=idTarget + "_" + formId;
					$(idTarget).text($(idSource).text());

					idTarget="#makeupLessons";
					idSource=idTarget + "_" + formId;
					$(idTarget).text($(idSource).text());
					
					idTarget="#paymentInformationId";
					$(idTarget).attr("value",formId);
				}
				
				$("#paymentInformationModalCaption").text(formCaption);
				
				$("#paymentInformationModal").modal();
				
				return false;
			}

			function ShowGroupLessonsModal(formId)
			{
				formCaption="Undefined";
				
				$("#paymentInformationIdInGroupLessons").attr("value",-1);
				
				if(formId==null)
				{		
					//something is wrong
				}
				else
				{
					idTarget="#periodName";
					idSource=idTarget + "_" + formId;
					
					formCaption="Edit group lessons in '" + $(idSource).text() + "' period";

					for(groupLessonId=1; groupLessonId<13; groupLessonId++)
				    {
						//Duration
						var idSource = "#duration_" + groupLessonId;
						var idTarget = "#editGroupLessonsDuration" + groupLessonId;
    					$(idTarget).text($(idSource).text());

    					//Payments source control
    					idSource = "duration_" + groupLessonId;
						
    					var dataStored = document.getElementById(idSource);
    					if(dataStored)
    					{
							//Payments destination population
    						idTarget = "#editGroupLessonsPayemnts" + groupLessonId;
        					$(idTarget).text(dataStored.dataset.payments);

							//Order destination population
        					idTarget = "#editGroupLessonsOrder" + groupLessonId;
        					$(idTarget).text(dataStored.dataset.feeorder);

        					//Show lesson population
        					idTarget = "#editGroupLessonsShow" + groupLessonId;
        					hiddenLesson = dataStored.parentElement.getAttribute("class");
        					isShowLesson = false;
        					if(hiddenLesson==null)
        					{
        						isShowLesson = true;
        					}
        					$(idTarget).prop("checked",isShowLesson);
    					}
					}

					//Payment information ID population
					idTarget="#paymentInformationIdInGroupLessons";
					$(idTarget).attr("value",formId);
				}
				
 				$("#groupLessonsModalCaption").text(formCaption);
				
				$("#groupLessonsModal").modal();
				
				return false;
			}
			
			function ShowPrivateLessonsModal(formId)
			{
				formCaption="Undefined";
				
				$("#paymentInformationIdInPrivateLessons").attr("value",-1);
				
				if(formId==null)
				{		
					//something is wrong
				}
				else
				{
					idTarget="#periodName";
					idSource=idTarget + "_" + formId;
					
					formCaption="Edit private lessons in '" + $(idSource).text() + "' period";

					for(privateLessonId=1; privateLessonId<13; privateLessonId++)
				    {
						//Level
						var idSource = "#level_" + privateLessonId;
						var idTarget = "#editPrivateLessonsLevel" + privateLessonId;
						$(idTarget).attr("value",$(idSource).text());

    					//Payment
						var idSource = "#payment_" + privateLessonId;
						var idTarget = "#editPrivateLessonsPayment" + privateLessonId;
    					$(idTarget).text($(idSource).text());
    					
    					idSource = "level_" + privateLessonId;
    					var dataStored = document.getElementById(idSource);
    					if(dataStored)
    					{
							//Order destination population
        					idTarget = "#editPrivateLessonsOrder" + privateLessonId;
        					$(idTarget).attr("value",dataStored.dataset.feeorder);

        					//Show lesson population
        					idTarget = "#editPrivateLessonsShow" + privateLessonId;
        					hiddenLesson = dataStored.parentElement.getAttribute("class");
        					isShowLesson = false;
        					if(hiddenLesson==null)
        					{
        						isShowLesson = true;
        					}
        					$(idTarget).prop("checked",isShowLesson);
    					}
					}

					//Payment information ID population
					idTarget="#paymentInformationIdInPrivateLessons";
					$(idTarget).attr("value",formId);
				}
				
 				$("#privateLessonsModalCaption").text(formCaption);
				
				$("#privateLessonsModal").modal();
				
				return false;
			}

			function ShowSpecialInstructionsModal(formId)
			{
				formCaption="Undefined";
				
				$("#paymentInformationIdInSpecialInstructions").attr("value",-1);
				
				if(formId==null)
				{		
					//something is wrong
				}
				else
				{
					idTarget="#periodName";
					idSource=idTarget + "_" + formId;
					
					formCaption="Edit special instructions in '" + $(idSource).text() + "' period";

					for(specialInstructionId=1; specialInstructionId<13; specialInstructionId++)
				    {
						//Level
						var idSource = "#text_" + specialInstructionId;
						var idTarget = "#editSpecialInstructionsText" + specialInstructionId;
						$(idTarget).attr("value",$(idSource).text());

    					idSource = "text_" + specialInstructionId;
    					var dataStored = document.getElementById(idSource);
    					if(dataStored)
    					{
							//Order destination population
        					idTarget = "#editSpecialInstructionsOrder" + specialInstructionId;
        					$(idTarget).attr("value",dataStored.dataset.textorder);

        					//Show lesson population
        					idTarget = "#editSpecialInstructionsShow" + specialInstructionId;
        					hiddenLesson = dataStored.parentElement.getAttribute("class");
        					isShowLesson = false;
        					if(hiddenLesson==null)
        					{
        						isShowLesson = true;
        					}
        					$(idTarget).prop("checked",isShowLesson);
    					}
					}

					//Payment information ID population
					idTarget="#paymentInformationIdInSpecialInstructions";
					$(idTarget).attr("value",formId);
				}
				
 				$("#specialInstructionsModalCaption").text(formCaption);
				
				$("#specialInstructionsModal").modal();
				
				return false;
			}
		</script>
	</body>
</html>
