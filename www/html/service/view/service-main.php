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
			
			start("main");
		?>
  		
    	
    	<?php function showMain()
		{
		?>
		<!-- page content -->
		<div id="firstContainer" class="container">
			<div class="panel panel-default">
  				<div class="panel-heading">
    				<h1 class="panel-title">Manual</h1>
  				</div>
  				<div class="panel-body">
					<p>
						This is content management system (CMS) web site. The purpose of this service web site is to manage digital content of Art of Soul Dance School web site. 
						The functionality of the service web site is aimed to simplify support of the school web site. It doesn't request any special skills 
						or extensive training. Everybody with minimum training can do it. As a result, administrative staff might do changes to the content of 
						Art of Soul Dance School web site. 
					</p>
					<p>
						There are pages which can be partually or fully modified on Art of Soul Dance School web site
					</p>
					<ol>
						<li>
							Home
							<ul>
								<li>
									News list
								</li>
								<li>
									Events list
								</li>
								<li>
									Slide show pictures
								</li>
							</ul>
						</li>
						<li>
							News
						</li>
						<li>
							Events
						</li>
						<li>
							Gallery
						</li>
						<li>
							Schedule
						</li>
						<li>
							Fees
						</li>
					</ol>
					<p>
						News and Events functionality includes a varieties of functions which create rich web pages. The list of functions is
						<table class="table table-striped table-bordered table-condensed">
							<thead>
								<tr>
									<th style="text-align:center;">Name</th>
									<th style="text-align:center;">Description</th>
									<th style="text-align:center;">Sample</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>ShowMiscPicture(pictureName, picrureHiddenText)</td>
									<td>Show an uploaded miscellaneous picture and open the full size picture when the picture has been clicked</td>
									<td>ShowMiscPicture(richard-lifshitz1.jpg,Richard Lifshitz)</td>
								</tr>
								<tr>
									<td>ShowMiscPictureGoWebSite(pictureName, picrureHiddenText, webSiteAddress)</td>
									<td>Show an uploaded miscellaneous picture and go to the specified web address when the picture has been clicked</td>
									<td>ShowMiscPictureGoWebSite(2017-toronto-dance-festival.jpg,2017 Toronto Dance Festival,https://www.facebook.com/annasmodlev/photos/gm.986134251498065/858055554329355/?type=3&theater)</td>
								</tr>
								<tr>
									<td>ContactsMississaugaLocation()</td>
									<td>Show Mississauga dance school location with hyperlink to jump to Mississauga location panel in Contacts</td>
									<td>ContactsMississaugaLocation()</td>
								</tr>
								<tr>
									<td>ExternalLink(linkAddress, linkCaption)</td>
									<td>Show hyperlink to go to any external web site</td>
									<td>ExternalLink(https://www.facebook.com/annasmodlev/photos/gm.986134251498065/858055554329355/?type=3&theater, Dance National League)</td>
								</tr>
								<tr>
									<td>ContactsApplicationForm()</td>
									<td>Show hyperlink to go to Application form panel in Contacts</td>
									<td>ContactsApplicationForm()</td>
								</tr>
								<tr>
									<td>ShowEmail(emailAddress, emailSubject)</td>
									<td>Show email hyperlink. When the email hyperlink has been clicked, pre-populated email comes up</td>
									<td>ShowEmail(dzhumakiryna@hotmail.com, Sponsor Request)</td>
								</tr>
							</tbody>
						</table>
					</p>
					<p>
						This is a list of HTML elements to be used in News and Events
						<table class="table table-striped table-bordered table-condensed">
							<thead>
								<tr>
									<th style="text-align:center;">Name</th>
									<th style="text-align:center;">Description</th>
									<th style="text-align:center;">Sample</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>&lt;br&gt;</td>
									<td>Show text on new line</td>
									<td>TICKETS: Adults - $10, children - $25 (includes sweets and gifts from Santa Clause)&lt;br&gt;&lt;br&gt;RSVP: By December 1, 2016 (please let us know if you are attending as soon as possible)&lt;br&gt;&lt;br&gt;</td>
								</tr>
								<tr>
									<td>&lt;p&gt;&lt;/p&gt;</td>
									<td>Show text as a paragraph</td>
									<td>&lt;p&gt;TICKETS: Adults - $10, children - $25 (includes sweets and gifts from Santa Clause)&lt;/p&gt;&lt;p&gt;RSVP: By December 1, 2016 (please let us know if you are attending as soon as possible)&lt;/p&gt;</td>
								</tr>
								<tr>
									<td>
										&lt;div class="row"&gt;<br>
									    &lt;div class="col-md-4"&gt;Cell #1 text&lt;/div&gt;<br>
									    &lt;div class="col-md-4"&gt;Cell #2 text&lt;/div&gt;<br>
									    &lt;div class="col-md-4"&gt;Cell #3 text&lt;/div&gt;<br>
									    &lt;/div&gt;
									</td>
									<td>Show table with 1 row and 3 columns. The size of column is 1/3 of total width. There are 12 cells for each row</td>
									<td>
										&lt;div class="row"&gt;<br>
									    &lt;div class="col-md-4"&gt;ShowMiscPicture(richard-lifshitz1.jpg,Richard Lifshitz)&lt;/div&gt;<br>
									    &lt;div class="col-md-4"&gt;ShowMiscPicture(richard-lifshitz2.jpg,Richard Lifshitz)&lt;/div&gt;<br>
									    &lt;div class="col-md-4"&gt;ShowMiscPicture(richard-lifshitz3.jpg,Richard Lifshitz)&lt;/div&gt;<br>
									    &lt;/div&gt;
									</td>
								</tr>
							</tbody>
						</table>
					</p>
  				</div>
			</div>  
		</div>
		<?php
		}
    	?>
    	
		<?php require("../template/footer.html"); ?>
		
	</body>
</html>