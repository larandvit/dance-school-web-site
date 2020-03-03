<!DOCTYPE html>
<html lang="en">

<?php
	require_once("../../template/macros.php");
	// page description
	$localWebPageDescription="Art of Soul Dance School add and edit web site gallery albums";
	// page title suffix
	$localWebPageTitle="Add/Edit gallery albums";
?>
	
	<?php session_start();?>
	
	<?php require("../template/header.html"); ?>
  
	<body>
		<?php 
			require("../template/login.php");
			
			start("gallery");
		?>
  		
    	
    	<?php function showMain()
		{
			require_once("../../data/data-gallery.php");
		?>
		
		<?php
			//clicked Save album button
			if(isset($_POST["submittedSaveButton"]))
			{
				$showAlbum=$_POST["inputShowAlbum"]=="on"?1:0;
				$albumDate=$_POST["inputDate"];
				$albumCaption=$_POST["inputAlbumCaption"];
				$showAlbumMainPage=0;
				if(isset($_POST["inputShowAlbumMainPage"]))
				{
					$showAlbumMainPage=$_POST["inputShowAlbumMainPage"]=="on"?1:0;
				}
				$albumFolder=$_POST["inputAlbumFolder"];
				$albumId=$_POST["inputAlbumId"];
				$writeType=($albumId==-1);
				
				$returnedDesc=writeAlbum($showAlbum
									    ,$albumDate
									    ,$albumCaption
									    ,$showAlbumMainPage
									    ,$albumFolder
					                    ,$albumId
									    ,$writeType);
				
				if(empty($returnedDesc))
				{
				    $folderPath=albumPictureFolder($albumFolder,true);
				    mkdir($folderPath);
				}
				
				echo $returnedDesc;
			}
			
			//clicked upload button
			if(isset($_FILES['image']))
			{
				$errors= array();
				$file_name = $_FILES['image']['name'];
				$file_size =$_FILES['image']['size'];
				$file_tmp =$_FILES['image']['tmp_name'];
				$file_type=$_FILES['image']['type'];
				$file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));
				
				$albumFolder=$_POST["albumFolder"];
				$albumId=$_POST["albumId"];
			
				if($file_name=="")
				{
					$errors[]="File for upload is not selected";
				}
			
				$expensions= array("jpg","png");
					
				if(in_array($file_ext,$expensions)=== false){
					$errors[]="Extension not allowed. Choose JPEG or PNG file";
				}
                
				if($file_size > 102400 or $file_size==0){
					$errors[]='File size must not exceed 100 KB';
				}
					
				if(empty($errors))
				{
					$retValue=writePicture($albumId,$file_name,true);
					$errMessage=$retValue[0];
					$fileNameDatabase=$retValue[1];
					
					if($errMessage=="")
					{
						$filePath=albumPictureFolder($albumFolder,true) . $fileNameDatabase;

						$ret=move_uploaded_file($file_tmp, $filePath);
						if(!$ret)
						{
							$errors[]="Unknow error when saving file";
						}
					}
					else 
					{
						$errors[]=$retValue[0];
					}
				}
			}
			
			if(isset($_POST["submittedYesButton"]))
			{
				$errors= array();
			
				$albumFolder=$_POST["inputDeletePictureAlbumFolder"];
				$fileName=$_POST["inputDeletePictureFileName"];
				$albumId=$_POST["inputDeletePictureAlbumId"];
			
				$filePath=albumPictureFolder($albumFolder,true) . $fileName;
				
				$returnCode=true;
				
				if(file_exists($filePath))
				{
					$returnCode=unlink($filePath);
					if(!$returnCode)
					{
						$errors[]="Unknow error when deleting file";
					}
				}
				
				if($returnCode)
				{
					$detetePictureRet=deleteFicture($fileName ,$albumId ,true);
					if($detetePictureRet!="")
					{
						$errors[]=$detetePictureRet;
					}
				}
			}
		?>
		
		<!-- page content -->
		<div id="firstContainer" class="container">
			<div class="panel panel-default">
  				<div class="panel-heading">
    				<h1 class="panel-title">Add/Edit gallery albums</h1>
  				</div>
  				<div class="panel-body">
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
	  				
  					<p>
						<button type="submit" class="btn btn-default" onclick="return ShowAlbumModal(null)">Add album</button>
					</p>
					<hr>
					<h3 class="text-center">Albums</h3>
					<div class="table-responsive">
  						<table class="table table-striped table-bordered table-condensed">
  							<thead>
  								<tr>
  									<th class="text-center">Show album</th>
  									<th class="text-center">Date</th>
  									<th class="text-center">Caption</th>
  									<th class="text-center">Show on main page</th>
  									<th class="text-center">Album folder</th>
  									<th class="text-center">Id</th>
								</tr>
							</thead>
					   		<tbody>
			  					<?php
			  						$albums=retrieveAlbums(1, true);	
			  					
			  						foreach($albums as $album)
			  						{
										echo "<tr>";
			  								
			  							echo "<td id='showAlbum_" . $album->albumId . "'>" . ($album->ShowAlbum==1?"Yes":"No") . "</td>";
			  							echo "<td id='albumDate_" . $album->albumId . "'>" . $album->albumDate . "</td>";
			  							echo "<td id='albumCaption_" . $album->albumId . "'><a href=\"#\" onclick=\"return ShowAlbumModal('" . $album->albumId . "')\">" . $album->albumCaption . "</a></td>";
			  							echo "<td id='showAlbumMainPage_" . $album->albumId . "'>" . ($album->ShowAlbumMainPage==1?"Yes":"No") . "</td>";
			  							echo "<td id='albumFolder_" . $album->albumId . "'><a href='service-gallery?albumId=" . $album->albumId . "#" . $album->albumCaption . "'>" . $album->albumFolder . "</a></td>";
			  							echo "<td id='albumId_" . $album->albumId . "'>" . $album->albumId . "</td>";
			  							
			  							echo "</tr>";
			  						}
			    				?>
    						</tbody>
						</table>
					</div>
					
					<?php
						$currentAlbum=$albums[0];
						$currentAlbumId=$albums[0]->albumId;
						
						if(isset($_GET["albumId"]))
						{
							$currentAlbumId=$_GET["albumId"];
							
							foreach($albums as $album)
							{
								if($album->albumId==$currentAlbumId)
								{
									$currentAlbum=$album;
									break;
								}
							}
						}
					?>
					
					<hr id="<?php echo $currentAlbum->albumCaption ?>">
					<h3 class="text-center"><?php echo $currentAlbum->albumCaption;?></h3>
					<br>
					<p>
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
						            <input type="text" name="albumId" value="<?php echo $currentAlbum->albumId;?>" class="hidden">
						            <input type="text" name="albumFolder" value="<?php echo $currentAlbum->albumFolder;?>" class="hidden">
						            <br>
						            <button type="submit" name="submittedUploadButton" class="btn btn-default">Upload</button>
					            </div>
				            </div>
						</form>
					</p>
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
			  						$pictures=retrievePictures($currentAlbum->albumId,true);
			  						
			  						foreach($pictures as $picture)
			  						{
			  							$fileName=$picture;
			  							$filePath=$currentAlbum->picturePathService($fileName); 
			  						?>
										<tr>
											<td><button type='button' class='btn btn-default' onclick='return ShowDeletePictureModal(<?php echo $currentAlbum->albumId?>,"<?php echo $currentAlbum->albumFolder; ?>","<?php echo $fileName; ?>");'>Delete</button></td>
											<td><?php echo $fileName; ?></td>
				  							<td><img width='40%' class='center-block img-thumbnail' src='<?php echo $filePath; ?>'></img></td>
			  							</tr>
			  						<?php
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
		<div id="albumModal" class="modal fade" role="dialog" data-backdrop="static">
  			<div class="modal-dialog modal-lg">
    			<!-- Modal content-->
    			<div class="modal-content">
    			
      				<div class="modal-header">
        				<button type="button" class="close" data-dismiss="modal">&times;</button>
        				<h4 id="albumModalCaption" class="modal-title"></h4>
      				</div><!-- modal-header -->
      				
      				<div class="modal-body">
        				
        				<form class="form" action="#" method="post">
							<div class="checkbox">
								<label>
									<input id="showAlbum" type="checkbox" name="inputShowAlbum"><b>Show news</b>
								</label>
							</div>
							<div class="form-group">
								<label for="inputDate">Date (yyyy-mm-dd format)</label>
								<input id="albumDate" type="text" class="form-control" name="inputDate" placeholder="Date in yyyy-mm-dd format" required>
							</div>
							<div class="form-group">
								<label for="inputAlbumCaption">Album caption</label>
								<textarea id="albumCaption" class="form-control" rows="4" name="inputAlbumCaption" placeholder="Album caption" required></textarea>
							</div>
							<div class="checkbox">
								<label>
									<input id="showAlbumMainPage" type="checkbox" name="inputShowAlbumMainPage"><b>Show album on main page</b>
								</label>
							</div>
							<div class="form-group">
								<label for="inputAlbumFolder">Album folder</label>
								<input id="albumFolder" type="text" class="form-control" name="inputAlbumFolder" placeholder="Enter folder name without spaces in lower case separated by dashes" required>
							</div>
							
							<input type="text" id="albumId" name="inputAlbumId" class="hidden">
							
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
								<button type="submit" name="submittedSaveButton" class="btn btn-default">Save</button>
							</div><!-- modal-footer -->
						</form>
        				
					</div><!-- modal-body -->
				</div><!--modal-content-->
	  		</div><!--modal-dialog-->
		</div><!-- Modal --> 
		
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
							<input type="text" id="inputDeletePictureAlbumId" name="inputDeletePictureAlbumId" class="hidden">
							<input type="text" id="inputDeletePictureAlbumFolder" name="inputDeletePictureAlbumFolder" class="hidden">
							
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
		
			function ShowDeletePictureModal(albumId, albumFolder, pictureFileName)
			{
				$("#deletePictureFileName").text("'" + pictureFileName + "'");
				$("#inputDeletePictureAlbumId").val(albumId);
				$("#inputDeletePictureAlbumFolder").val(albumFolder);
				$("#inputDeletePictureFileName").val(pictureFileName);
				
				$("#deletePictureModal").modal();
				
				return false;
			}
		
			function ShowAlbumModal(albumId)
			{
				newsCaption="Add album";
				$("#albumId").attr("value",-1);
				
				if(albumId==null)
				{		
					idTarget="#albumDate";
					$(idTarget).attr("value","");

					idTarget="#showAlbum";
					$(idTarget).prop("checked",true);

					idTarget="#albumCaption";
					$(idTarget).text("");

					idTarget="#showAlbumMainPage";
					$(idTarget).prop("checked",false);
					
					idTarget="#albumFolder";
					$(idTarget).attr("value","");

				}
				else
				{
					idTarget="#albumCaption";
					idSource=idTarget + "_" + albumId;
					$(idTarget).text($(idSource).text());
					
					newsCaption="Edit '" + $(idSource).text() + "' album";
					
					idTarget="#albumDate";
					idSource=idTarget + "_" + albumId;
					$(idTarget).attr("value",$(idSource).text());

					idTarget="#showAlbum";
					idSource=idTarget + "_" + albumId;
					$(idTarget).prop("checked",$(idSource).text()=="Yes");

					idTarget="#showAlbumMainPage";
					idSource=idTarget + "_" + albumId;
					$(idTarget).prop("checked",$(idSource).text()=="Yes");

					idTarget="#albumCaption";
					idSource=idTarget + "_" + albumId;
					$(idTarget).text($(idSource).text());

					idTarget="#albumFolder";
					idSource=idTarget + "_" + albumId;
					$(idTarget).attr("value",$(idSource).text());

					idTarget="#albumId";
					$(idTarget).attr("value",albumId);
				}
				
				$("#albumModalCaption").text(newsCaption);
				
				$("#albumModal").modal();
				
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
