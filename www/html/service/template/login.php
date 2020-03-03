<?php
	require_once('../../data/data-users.php');
	
	function start($menuName)
	{
		$user=null;
		
		if(isset($_POST["submittedLogin"]))
		{
			$loginName= htmlspecialchars(stripslashes(trim($_POST["inputLoginName"])));
			$password=htmlspecialchars(stripslashes(trim($_POST["inputPassword"])));
		
			$user=retrieveUser($loginName, true);
			
			if($user->Verify($password))
			{
				$_SESSION["user"]=$user;
			}
		}
			
		if(isset($_SESSION["user"]))
		{
			require("../template/menu.php");
			showMenu($menuName);
			showMain();
		}
		else
		{
			showLogin($user);
		}
	}
	
	function isVerified()
	{
		return isset($_SESSION["user"]);
	}
?>
		
<?php 
function showLogin($user)
{
?>
	<!-- login screen -->
	<div id="firstContainer" class="container">
		<div class="row">
			<div class="col-sm-3"></div>
			<div class="col-sm-6">
				<div class="panel panel-default">
	  				<div class="panel-heading">
	    				<h1 class="panel-title">Art of Soul Dance School login</h1>
	  				</div>
	  				<div class="panel-body">
						<form class="form" method="post">
							<div class="form-group">
								<label for="inputName" class="control-label">Login name</label>
								<input type="email" class="form-control" name="inputLoginName" placeholder="Your login name" required autofocus/>
							</div>
							<div class="form-group">
								<label for="inputEmail" class="control-label">Password</label>
								<input type="password" class="form-control" name="inputPassword" placeholder="Your password" required/>
							</div>
							<div class="form-group">
								<button type="submit" class="btn btn-default" name="submittedLogin" value="SubmitLogin">Submit</button>
								<!-- button type="submit" class="btn btn-default" name="submittedForgetPassword" value="SubmitForgetPassword">Forget password</button-->
							</div>
							<?php
								$alerstHidden=(isset($user)?"":" hidden");
							?>
							<div class="alert alert-danger<?php echo $alerstHidden ?>">
    							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    							<strong>Authentication failed. Login name and password are wrong</strong>
			  				</div>
						</form>
		    		</div>
	    		</div>
	    	</div>
	    	<div class="col-sm-3"></div>
    	</div>
    </div>
<?php
}
?>