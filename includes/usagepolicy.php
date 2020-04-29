<?php
//error_reporting(E_ALL);
 include_once('../config/symbini.php');
 header("Content-Type: text/html; charset=".$charset);
 
?>
<html>
	<head>
		<title><?php echo $defaultTitle; ?> Data Usage</title>
		<link rel="stylesheet" href="<?php echo $clientRoot; ?>/css/main.css" type="text/css" />
	</head>
<body>
<?php
	$displayLeftMenu = true;	
	include($serverRoot.'/header.php');
	echo "<div class='navpath'>";
	echo "<a href='../index.php'>Home</a> &gt; ";
	echo " <b>Data Usage</b>";
	echo "</div>";
	?>

	<div id="innertext">
	    <div style="margin:25px;">
	        <h3 style="margin-top:10px;">Data Usage Policy<sup>1</sup>: </H3>
	        <p>The Consortium of Northeastern Herbaria (CNH) provides access to specimen data and related material (e.g., images, floristics lists, etc.; hereafter referred to simply as "data") from multiple institutions. These institutions have agreed to make their data available for scientific research and for public information and education. Use of any data accessed through the CNH Portal requires agreement to the terms and conditions in the following data usage policy:</p>
	        <ol>
				<li>The quality and completeness of data cannot be guaranteed. Users employ these data at their own risk. Data users are encouraged to personally verify data before use in critical applications.</li>
				<li>Data accuracy and content are determined by the individual providers.  Any reports of errors in the data should be directed to the original data providers, not CNH.</li>
				<li>CNH does not assert intellectual property rights over the data made available through its network. Owners of the data retain all rights to the data that are shared. If specific location information is provided about sensitive species in response to a user request, the user shall respect restrictions of access to the wider community and general public.</li>
				<li>In order to make attribution of use for owners of the data possible, the identifier of ownership of data must be retained with every data record and other related materials. For specimen occurrence records, the person or organization owning or managing rights over the resource is given in the "rightsHolder" field.</li>
				<li>Users must, in conjunction with the use of the data, acknowledge the data providers whose data they have used.</li>
				<li>Users must comply with additional terms and conditions of use set by the data provider. Where these exist they will be available through the metadata associated with the item. For specimen occurrence records, these terms are provided in the "rights" field.</li>
				</ol>

<p>Data providers must agree to the <a href="sharingpolicy.php">Data Sharing Policy.</a></p>

<h3>Citing Data:</h3>
<p>You may use the following format to cite data obtained through the CNH Portal:</p>
<p>Herbarium specimen data provided by: [list of providers] (Accessed through the Consortium of Northeastern Herbaria web site, www.neherbaria.org, YYYY-MM-DD)</p>

<p>For example:</p>
<p>Herbarium specimen data provided by: George Safford Torrey Herbarium (CONN), University of Connecticut; Yale University Herbarium (YU), Peabody Museum of Natural History (Accessed through the Consortium of Northeastern Herbaria web site, www.neherbaria.org, 2011-08-27)</p>


<p><sup>1</sup>Adapted from the Consortium of Pacific Northwest Herbaria web site (www.pnwherbaria.org)</p>

	    </div>
	</div>
<?php 
	include($serverRoot.'/footer.php');
?>
</body>

</html>
