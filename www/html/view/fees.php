<!DOCTYPE html>
<html lang="en">
	
	<?php
		require("../template/macros.php");
		//page description
		$localWebPageDescription="Art of Soul Dance School fees";
		//page title suffix		
		$localWebPageTitle="Fees";
	?>
	
	<?php require("../template/header.html"); ?>
  
	<body>
	
  		<?php 
			require("../template/menu.php");
			showMenu("fees");
			require("../data/data-fee.php");
		?>
		
		<?php
    		$fees=showFees();
    		
    		$periodName = "Unknown";
    		$firstClass = "Unknown";
    		$lastClass = "Unknown";
    		$postDatedCheques = "Unknown";
    		$deadlineFullSessionPayment = "Unknown";
    		$sessionDuration = "Unknown";
    		$makeupLessons = "Unknown";
    		$Id = -1;
    		$mergedPeriods = "Unknown";
    		$mergedPeriodsHeaderText = array();
    		$feePeriods = array();
    		$feeGroupLessons = array();
    		$feePrivateLessons = array();
    		$specialInstructions = array();
    		
    		foreach($fees as $fee)
    		{
    		    $periodName = $fee[0];
    		    $firstClass = $fee[1];
    		    $lastClass = $fee[2];
    		    $postDatedCheques = $fee[3];
    		    $deadlineFullSessionPayment = $fee[4];
    		    $sessionDuration = $fee[5];
    		    $makeupLessons = $fee[6];
    		    $Id = $fee[7];
    		    $mergedPeriods = $fee[8];
    		    $mergedPeriodsHeaderText = $fee[9];
    		    $feePeriods = $fee[10];
    		    $feeGroupLessons = $fee[11];
    		    $feePrivateLessons = $fee[12];
    		    $specialInstructions = $fee[13];
    		    
    		    #read just the first record
    		    break;
     		}
			
     		$paymentHeaders = $feePeriods;
			
     		$payments = $feeGroupLessons;
								
     		$privatePayments = $feePrivateLessons;
			                      
     		$postDatedChequePeriods = $postDatedCheques;
			
     		$deadlineFullSessionPayment = $deadlineFullSessionPayment;
			
     		$sessionDuration = $sessionDuration;
			
     		$makeupLessons = $makeupLessons;
		?>
	
		<!-- page content -->
		<div id="firstContainer" class="container">
			<div class="panel panel-default">
  				<div class="panel-heading hidden-print">
    				<h1 class="panel-title">Fees</h1>
  				</div>
  				<div class="panel-body">
  					<div class="hidden-print">
						<ul class="nav nav-pills">
							<li role="presentation"><a href="#GroupLessons">Group Lessons</a></li>
							<li role="presentation"><a href="#PrivateLessons">Private Lessons</a></li>
							<li role="presentation"><a href="#ImportantPaymentInformation">Important Payment Information</a></li>
							<li role="presentation"><a href="#StudioPolicies">Studio Policies</a></li>
						</ul>
					</div>
					<hr class="hidden-print">
					
    				<h2><?php echo $periodName; ?> – Payment Information</h2>
    				<p id="GroupLessons">
    					First Class: <?php echo $firstClass; ?>
    				</p>
    				<p>
    					Last Class: <?php echo $lastClass; ?>
    				</p>
					
					<?php
						echo "<h3><center>Group Lessons</center></h3>";
						echo "<div class=\"table-responsive\">";
  						echo "<table class=\"table table-striped table-bordered table-condensed\">";
  						//echo "  <caption><h3><center>Group Lessons</center></h3></caption>";
  						echo "  <thead>";
  						echo "    <tr>";
  						echo "	   <th rowspan=\"2\" style=\"text-align:center;\">";
  						echo "		  Hours/</br>Week";
  						echo "	   </th>";
  						echo "	   <th rowspan=\"2\" style=\"text-align:center;\">";
  						echo "		  Total</br>Session";
  						echo "	   </th>";
  						echo "      <th colspan=\"4\" style=\"text-align:center;\">Monthly Fee</th>";
  						
						echo "    </tr>";
						
						
												
						echo "    <tr>";						
						#table header names
  						foreach($paymentHeaders as $paymentHeader)
						{
							echo "<th style=\"text-align:center;\">" . $paymentHeader . "</th>";
						}

						echo "    </tr>";
					   echo "  </thead>";
					   echo "  <tbody>";
					   
					   //$currentPaymentIndex and $totalPayments variables are used to track the last record in the payment table
					   //The last payment is utilized as a bookmark to get Private Lessons
					   $totalPayments=count($payments);
					   $currentPaymentIndex=0;
					   
						foreach($payments as $payment)
						{
							$currentPaymentIndex++;
							
							if($currentPaymentIndex==$totalPayments)
							{
								 echo "<tr id=\"PrivateLessons\">";
							}
							else 
							{
								echo "<tr>";
							}
							
							$periodIndex = 0;
							
							echo "<td><strong>" . $payment[1] . "</strong></td>";
						    
							$paymentPeriods = explode(";" ,$payment[2]);
						    
						    foreach($paymentPeriods as $paymentPeriod){
						        echo "<td>" . $paymentPeriod . "</td>";
						    }

							echo "</tr>";
						}
					   
					   echo "</tbody>";
  				      echo "</table>";
  				      echo "</div>";
  				      
  				      echo "<h3><center>Private Lessons</center></h3>";
  				      echo "<div class=\"table-responsive\">";
  						echo "<table class=\"table table-striped table-bordered table-condensed\">";
  						//echo "  <caption ><h3><center>Private Lessons</center></h3></caption>";
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
  						
						foreach($privatePayments as $privatePayment)
						{
							echo "<tr>";
							echo "<td><strong>" . $privatePayment[1] . "</strong></td>";
							echo "<td>" . $privatePayment[2] . "</td>";
							echo "</tr>";
						}				
  						
  						//echo "<tr><td colspan=\"2\"><sup>*</sup>Private Lessons for Singles are based on the level as well</td></tr>";
  						
  						echo "</tbody>";
  				      echo "</table>";
  				      echo "</div>";
					    				
  				      $specialInstructionsCount = sizeof($specialInstructions);
  				      for($i=0; $i<$specialInstructionsCount; $i++){
  				          if($i==$specialInstructionsCount-1){
  				              echo "<p id=\"ImportantPaymentInformation\">" . $specialInstructions[$i][1] . "</p>";
  				          }
  				          else {
  				              echo "<p>" . $specialInstructions[$i][1] . "</p>";
  				          }
  				      }
    				?>
    				<h3 class="text-center">Important Payment Information</h3>
    				<p>The studio accepts both cheque and cash as payment methods. Cheques should be made payable to <strong>“Art of Soul”</strong>:</p>
    				<div>
    					<ul>
    						<li>
    							If paying by cheques you may choose to write <strong>one cheque</strong> for the entire session dated <strong><?php echo $postDatedChequePeriods[0]; ?></strong> 
    						   or you may write <strong>four post-dated cheques</strong> dated 
    						   <?php
    						   	$comma="";
    						   	for($postPeriod=0; $postPeriod<count($postDatedChequePeriods)-1;$postPeriod++) 
    						   	{
    						   		echo $comma . "<strong>" . $postDatedChequePeriods[$postPeriod] . "</strong>";
    						   		$comma=", ";
    						   	} 
    						   ?> 
    						   and 
    						   <?php echo "<strong>" .$postDatedChequePeriods[count($postDatedChequePeriods)-1] . "</strong>"; ?>. 
    						   Please note that the <strong><?php echo implode(" and ", $mergedPeriods) ;?></strong> payments are to be written as one cheque.
    						</li>
    						<li>
    							If paying in cash the full sum for the session must be paid at the beginning of the semester.
    						</li>
    						<li id="StudioPolicies">
    							The <strong>ENTIRE</strong> session payment is required at the beginning of the semester, <?php echo $deadlineFullSessionPayment; ?>. One monthly payments will be 
    							available to <strong>New Comers</strong> during their first month, after which the rest of the semester should be paid.
    						</li>
    						<li>The family discount of 10% is applied to single payments for both students. The discount cannot be combined with any other discounts 
    						    mentioned in the payment information
    						</li>
    						<li>
    						    In order to receive a full refund for the month you must notify your instructor by the first of the month, once the cheque for the month is 
    						    deposited no refund will be issued.
    						</li>
    					</ul>
    				</div>
    				
    				<h3 class="text-center">Studio Policies</h3>
    				<p>To avoid misunderstanding please note of the following studio policies regarding payments and lessons:</p>
    				<div>
    					<ul>
    						<li>
    							No refunds and/or payment combinations are given for missed GROUP lessons!
    						</li>
    						<li>
    							The make-up lessons will be held on the last Tuesday of each month at 6:00 p.m. except for December. 
    							The lessons will happen on: 
    							<?php
    						   	$comma="";
    						   	for($makeupPeriod=0; $makeupPeriod<count($makeupLessons)-1;$makeupPeriod++) 
    						   	{
    						   		echo $comma . "<strong>" . $makeupLessons[$makeupPeriod] . "</strong>";
    						   		$comma=", ";
    						   	} 
    						   ?> 
    						   and 
    						   <?php echo "<strong>" . $makeupLessons[count($makeupLessons)-1] . "</strong>"; ?>. 
    							You must notify your instructor if you are attending a make-up lesson.
    						</li>
    						<li>
    							No payments and/or make-up lessons could be transferred between sessions.
    						</li>
    						<li>
    							For PRIVATE lessons we require a 24h cancellation notice, otherwise full payment will be charged. 
    						</li>
    					</ul>
    				</div>
  				</div>
			</div>  
		</div>
		
		<?php require("../template/footer.html"); ?>
		
	</body>
</html>