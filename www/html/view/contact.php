<!DOCTYPE html>
<html lang="en">
	
	<?php
		require("../template/macros.php");
		//page description
		$localWebPageDescription="Art of Soul Dance School contact information";
		// page title suffix		
		$localWebPageTitle="Contact";
	?>
	
	<?php require("../template/header.html"); ?>
  
	<body>
	
		<?php 
			require("../template/menu.php");
			showMenu("contact");
		?>
		
		<?php
			if(isset($_POST['submittedContactForm']))
			{
				$submittedContactForm=$_POST['submittedContactForm'];
			}
			
			$IsSendContactFormSuccess=false;
				
			if (isset($submittedContactForm)) 
			{
				$name=trim($_POST['inputName']);
				$email=trim($_POST['inputEmail']);
				$phone=trim($_POST['inputPhone']);
				$message=trim($_POST['inputMessage']);				
				
				// Always set content-type when sending HTML email
				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

				// More headers
				$headers .= 'From: admin@artofsouldanceschool.com' . "\r\n";
				$headers .= 'Cc: admin@artofsouldanceschool.com' . "\r\n";
				$to='stervella101@yahoo.com';
				$subject='Art Of Soul Dance School Contact Form';
				$mailContent='<b>Name:</b> ' .$name. '<br>';
				$mailContent .='<b>Email:</b> ' .$email. '<br>';
				$mailContent .='<b>Phone:</b> ' .$phone. '<br>';
				$mailContent .='<b>Message:</b><br><br>'  .nl2br($message);

				$IsSendContactFormSuccess=mail($to, $subject, $mailContent, $headers);
			} 
			
			function repopulate ($field, $IsSendContactFormSuccess) 
			{
		    	if (isset($_POST['submittedContactForm']) and !$IsSendContactFormSuccess) 
		    	{
					echo htmlspecialchars($_POST[$field]);
		    	}
			}
		?>
		
		<!-- page content -->
		<div class="container">
		
			<div class="row">
				<div class="col-md-8">
					<div id="contact-form" class="panel panel-default">
						<div class="panel-heading">
							<h1 class="panel-title">Contact form</h1>
						</div>
						<div class="panel-body">
							<form class="form-horizontal" method="post">
								<div class="form-group">
									<label for="inputName" class="col-sm-2 control-label">Name</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="inputName" value="<?php repopulate('inputName',$IsSendContactFormSuccess); ?>" placeholder="Your name" required>
									</div>
								</div>
								<div class="form-group">
									<label for="inputEmail" class="col-sm-2 control-label">Email</label>
									<div class="col-sm-10">
										<input type="email" class="form-control" name="inputEmail" value="<?php repopulate('inputEmail',$IsSendContactFormSuccess) ?>" placeholder="Your email" required>
									</div>
								</div>
								<div class="form-group">
									<label for="inputPhone" class="col-sm-2 control-label">Phone</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="inputPhone" value="<?php repopulate('inputPhone',$IsSendContactFormSuccess) ?>" placeholder="Your phone" required>
									</div>
								</div>
								<div class="form-group">
									<label for="inputMessage" class="col-sm-2 control-label">Message</label>
									<div class="col-sm-10">
										<textarea class="form-control" rows="8" name="inputMessage" placeholder="Message" required><?php repopulate('inputMessage',$IsSendContactFormSuccess) ?></textarea>
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-10">
										<button type="submit" class="btn btn-default" name="submittedContactForm" value="SubmitContactForm">Submit</button>
									</div>
								</div>
								<?php
									if (isset($submittedContactForm)) 
									{
										if($IsSendContactFormSuccess==false) 
										{
											echo
											"<div class='col-sm-12'>
												<div class='alert alert-danger'>
			    									<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
			    									<strong>Contact Form submission has failed. Try again or use another method to contact us</strong>
			  									</div>
			  								</div>";
			  							}
			  							else
			  							{
			  								echo
											"<div class'col-sm-12'>
												<div class='alert alert-success'>
			    									<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
			    									<strong>Contact Form has been submitted successfully</strong>
			  									</div>
			  								</div>";
			  								repopulate('inputName',$IsSendContactFormSuccess);
			  								repopulate('inputEmail',$IsSendContactFormSuccess);
			  								repopulate('inputPhone',$IsSendContactFormSuccess);
			  								repopulate('inputMessage',$IsSendContactFormSuccess);
			  							}
	  								}
	  							?>
							</form>
						</div>
					</div>  
				</div> <!-- col 8-->
				
				<div class="col-md-4">
					<div id="contact-us" class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">Contact us</h3>
						</div>
						<div class="panel-body">
							<address>
								<strong>Inessa Rolik</strong><br>
								<abbr title="Phone">P:</abbr> (416) 854-1728<br>
								<a href="mailto:artofsouldance@yahoo.com">artofsouldance@yahoo.com</a><br><br>
									<a href="https://www.facebook.com/Art-Of-Soul-Dance-School-345986452168637/" target='_blank'>
										<img src="../img/facebook-small.png" alt="Connect with Art of Soul Dance School Facebook"></img>
									</a>
									<a href="https://www.instagram.com/art_of_soul_dance/" target='_blank'>
										<img src="../img/instagram-small.png" alt="Connect with Art of Soul Dance School instagram"></img>
									</a>
							</address>
						</div>
					</div>
					
					<div id="application-form" class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">Application form</h3>
						</div>
						<div class="panel-body">
							If you would like to register your child, you can submit the Art of Soul Dance School Application Form 
    						in any of electronic formats at <a href="mailto:artofsouldance@yahoo.com">artofsouldance@yahoo.com</a> 
    						<ul>
    							<li>
    								<a target="_blank" href="../document/Art of Soul Dance School Registration Form.pdf">Application Form in Adobe Acrobat (PDF) format</a>
    							</li>
    							<li>
    								<a target="_blank" href="../document/Art of Soul Dance School Registration Form.doc">Application Form in Microsoft Word format</a>
    							</li>
    							<li>
    								<a target="_blank" href="../document/Art of Soul Dance School Registration Form.txt">Application Form in plain text format</a>
    							</li>
    						</ul>
						</div>
					</div>
				</div> <!-- col 4-->
			</div> <!--row-->
			
		</div>
		
		<div class="container">
				<div id="mississauga-location" class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Mississauga location</h3>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-3">
								<address>
								  354 Lakeshore Rd W<br>
								  Mississauga ON L5H 1H3<br>
								  <abbr title="Phone">P:</abbr> (416) 854-1728
								</address>
							</div> <!--col 4-->
							<div class="col-md-9">
								<div class="embed-responsive embed-responsive-16by9">
									<iframe class="embed-responsive-item" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2892.069278122031!2d-79.59810914913237!3d43.54259776749139!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x882b45d70e5f4127%3A0xb3de50e454389d6f!2s354+Lakeshore+Rd+W%2C+Mississauga%2C+ON+L5H+1H3!5e0!3m2!1sen!2sca!4v1466034324150" allowfullscreen></iframe>
								</div>
							</div> <!--col 8-->
						</div> <!--row-->
					</div>
				</div>
		</div>	
		
		
		<?php require("../template/footer.html"); ?>
		
	</body>
</html>
