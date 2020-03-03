<!DOCTYPE html>
<html lang="en">
	
	<?php
		require("../template/macros.php");
		// page description		
		$localWebPageDescription="Art of Soul Dance School news";
		// page title suffix		
		$localWebPageTitle="News";
	?>
	
	<?php require("../template/header.html"); ?>
  
	<body>
	
  		<?php 
			require("../template/menu.php");
			showMenu("news");
			require("../data/data-news.php");
		?>
	
		<!-- page content -->
		<div id="firstContainer" class="container">
			<div class="panel panel-default">
  				<div class="panel-heading">
    				<h1 class="panel-title">News</h1>
  				</div>
  				<div class="panel-body">
  					<?php
  						$colNumber=1;
  						
  						$newss=newsPage();
  						
  						foreach($newss as $news)
  						{
  							$shownews=$news[0];
  							$newsDate=$news[1];
  							$newsText=$news[2];
  							
  							if($colNumber==1)
  							{
  								echo "<div class='row'>";
  							}
  								
  							echo"<div class='col-md-4'>";
  							echo "<p>";
  							echo "<strong>" . $newsDate . "</strong>" . "<br>" . $newsText;
  							echo "</p>";
  							echo "</div>";
  							
  							if($colNumber==3)
  							{
  								echo "</div>";
  								$colNumber=0;
  							}
  								
  							$colNumber++;
  						}
  						echo "</div>";
    				?>
  				</div>
			</div>  
		</div>
		
		<div class="visible-lg visible-md">  
    		<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    	</div>		
		
		<?php require("../template/footer.html"); ?>
		
	</body>
</html>
