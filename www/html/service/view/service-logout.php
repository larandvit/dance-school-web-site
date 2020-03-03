<!DOCTYPE html>
<html lang="en">

<?php
	require_once("../../template/macros.php");
	// page description
	$localWebPageDescription="Art of Soul Dance School service web site home page";
	// page title suffix
	$localWebPageTitle="Service home";
?>
	
	<?php session_start();?>
	
	<?php require("../template/header.html"); ?>
  
	<body>
		<?php 
			require("../template/login.php");
			
			unset($_SESSION["user"]);
			
			start("main");
		?>
  		
    	
    	<?php function showMain()
		{
			Header('Location: ../view/service-main');
  			exit;
		}
    	?>
		
		<?php require("../template/footer.html"); ?>
		
	</body>
</html>