		<?php function showMenu($pageName)
		{
		?>
		
		<!-- top navigation bar -->
		<header id="top" class="navbar navbar-default navbar-fixed-top"> 
			<div class="container"> 
				<div class="navbar-header"> 
					<button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#bs-navbar" aria-expanded="false">  
						<span class="sr-only">
							Toggle navigation
						</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a href="../" class="navbar-brand" style="padding-top:5px">
						<img src="../img/logo-small.png" alt="Art of Soul Dance School logo"/>
					</a>
				</div>
				<nav id="bs-navbar" class="collapse navbar-collapse">
					<ul class="nav navbar-nav"> 
						<li <?php if ($pageName=="main") echo("class='active'") ?>><a href="../view/main">Home</a></li>
						<li <?php if ($pageName=="about") echo("class='active'") ?>><a href="../view/about">About</a></li>
						<li <?php if ($pageName=="news") echo("class='active'") ?>><a href="../view/news">News</a></li>
						<li <?php if ($pageName=="events") echo("class='active'") ?>><a href="../view/events">Events</a></li>
						<li <?php if ($pageName=="gallery") echo("class='active'") ?>><a href="../view/gallery">Gallery</a></li>
						<li <?php if ($pageName=="schedule") echo("class='active'") ?>><a href="../view/schedule">Schedule</a></li>
						<li <?php if ($pageName=="fees") echo("class='active'") ?>><a href="../view/fees">Fees</a></li>
						<li <?php if ($pageName=="contact") echo("class='active'") ?>><a href="../view/contact">Contact</a></li>
					</ul>
				</nav>
			</div>
		</header>
		
		<?php
		}
		?>