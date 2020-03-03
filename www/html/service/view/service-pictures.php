<!DOCTYPE html>
<html lang="en">

	<?php
		require_once("../../template/macros.php");
		// page description
		$localWebPageDescription="Art of Soul Dance School miscellaneous pictures";
		// page title suffix
		$localWebPageTitle="Manage miscellaneous pictures";
	?>
	
	<?php session_start();?>
	
	<?php require("../template/header.html"); ?>
  
	<body>
		<?php 
			require("../template/login.php");
			
			start("pictures");
		?>
  		
    	
    	<?php function showMain()
		{
			require_once("../../data/data-news.php");
		?>
		
		<?php
			if(isset($_FILES['image']))
			{
				$errors= array();
				$file_name = $_FILES['image']['name'];
				$file_size =$_FILES['image']['size'];
				$file_tmp =$_FILES['image']['tmp_name'];
				$file_type=$_FILES['image']['type'];
				$file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));
				
				if($file_name=="")
				{
					$errors[]="File for upload is not selected";	
				}
				
				$expensions= array("jpg","png");
			
				if(in_array($file_ext,$expensions)=== false){
					$errors[]="Extension not allowed. Choose JPEG or PNG file";
				}
			
				if($file_size > 102400){
					$errors[]='File size must not exceed 100 KB';
				}
			
				if(empty($errors))
				{
					$ret=move_uploaded_file($file_tmp,"../../img/misc/" . $file_name);
					if(!$ret)
					{
						$errors[]="Unknow error when saving file";
					}
				}
			}
			
			if(isset($_POST["submittedYesButton"]))
			{
				$errors= array();
				
				$dir = "../../img/misc";
				$fileName=$_POST["inputDeletePictureFileName"];
				$filePath=$dir . "/" . $fileName;
				$ret=unlink($filePath);
				if(!$ret)
				{
					$errors[]="Unknow error when deleting file";
				}
			}
		?>
		
		<!-- page content -->
		<div id="firstContainer" class="container">
			<div class="panel panel-default">
  				<div class="panel-heading">
    				<h1 class="panel-title">Manage miscellaneous pictures</h1>
  				</div>
  				<div class="panel-body">
  					<p>
  						The functionaity is used to upload miscellaneous picture which are used 
  						on News and Events pages.
  					</p>
  					<p>
  						The picture requirements are
  						<ol>
  							<li>
  								Picture file size doesn't exceed 100 KB
  							</li>
  							<li>
  								Acceptable picture types are JPG and PNG  
  							</li>
  							<li>
  								Picture file name
  								<ul>
  									<li>
  								  		It doesn't include any spaces
  									</li>
  									<li>
  										All letters are lowercase 
  									</li>
  									<li>
  										Words are separated by dash (-) character
  									</li>
  								</ul> 
  							</li>
  						</ol>
  					</p>
  					<br>
  					<?php
						if (isset($_POST["submittedUploadButton"]) or isset($_POST["submittedYesButton"])) 
						{
							if(!empty($errors))
							{
								echo "<div class'col-sm-12'>
									      <div class='alert alert-danger'>
		    							      <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
		    							      <strong>" . $errors[0] . "</strong>
		  							      </div>
		  						      </div>";
		  					}
		  					else
		  					{
		  						$successMessage="Operation completed successfully";
		  						
		  						if(isset($_POST["submittedUploadButton"]))
		  						{
		  							$successMessage="Picture uploaded successfully";
		  						}
		  						
								if(isset($_POST["submittedYesButton"]))
		  						{
		  							$successMessage="Picture deleted successfully";
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
					<form class="form" action="#" method="POST" enctype="multipart/form-data">
						<div class="panel panel-default">
							<div class="panel-heading">Add picture</div>
	  						<div class="panel-body">
								<div class="input-group">
					                <label class="input-group-btn">
					                    <span class="btn btn-primary">
					                        Browse&hellip; 
					                        <input type="file" name="image" style="display: none;">
					                    </span>
					                </label>
					                <input id="inputSelectedFile" type="text" class="form-control" readonly>
					            </div>
					            <br>
					            <button type="submit" name="submittedUploadButton" class="btn btn-default">Upload</button>
				            </div>
			            </div>
					</form>
	  				
	  				<br>
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-condensed">
						  <thead>
						    <tr>
							   <th style="text-align:center;">Action</th>
							   <th style="text-align:center;">File name</th>
							   <th style="text-align:center;">Picture</th>
						    </tr>
						  </thead>
						  <tbody>
							<?php 
								$dir = "../../img/misc";
								$dh  = opendir($dir);
								while (false !== ($fileName = readdir($dh))) 
								{
									if (!in_array($fileName,array(".","..")))
									{
										$filePath=$dir . "/" . $fileName;
							?>
										<tr>
										<td><button type='button' class='btn btn-default' onclick='return ShowDeletePictureModal("<?php echo $fileName; ?>");'>Delete</button></td>
										<td><?php echo $fileName; ?></td>
										<td><img width='40%' class='center-block img-thumbnail' src='<?php echo $filePath; ?>'></img></td>
										</tr>
							<?php 
									}
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
		
		<!-- Modal - confirm picture deletion -->
		<div id="deletePictureModal" class="modal fade" role="dialog" data-backdrop="static">
  			<div class="modal-dialog modal-sm">
    			<!-- Modal content-->
    			<div class="modal-content">
    			
      				<div class="modal-header">
        				<button type="button" class="close" data-dismiss="modal">&times;</button>
        				<h4 class="modal-title">Delete picture</h4>
      				</div><!-- modal-header -->
      				
      				<div class="modal-body">
        				
        				<form class="form" action="#" method="POST">
							
							<p>
								Are you sure you want to delete <span id="deletePictureFileName"></span> file?
							</p>
							
							<input type="text" id="inputDeletePictureFileName" name="inputDeletePictureFileName" class="hidden">
							
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
								<button type="submit" name="submittedYesButton" class="btn btn-default">Yes</button>
							</div><!-- modal-footer -->
						</form>
        				
					</div><!-- modal-body -->
				</div><!--modal-content-->
	  		</div><!--modal-dialog-->
		</div><!-- Modal --> 
			
		<?php require("../template/footer.html"); ?>
		
		<script type="text/javascript" >
		
			function ShowDeletePictureModal(pictureFileName)
			{
				$("#deletePictureFileName").text("'" + pictureFileName + "'");
				$("#inputDeletePictureFileName").val(pictureFileName);
				
				$("#deletePictureModal").modal();
				
				return false;
			}

			$(function() 
			{
				  // We can attach the `fileselect` event to all file inputs on the page
				  $(document).on('change', ':file', function() {
				    var input = $(this),
				        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
				    input.trigger('fileselect', label);
				  });

				  // We can watch for our custom `fileselect` event like this
				  $(document).ready( function() {
				      $(':file').on('fileselect', function(event, label) {

				          var input = $(this).parents('.input-group').find(':text');
				         
				          input.val(label);
				      });
				  });
			});
		</script>
	</body>
</html>
