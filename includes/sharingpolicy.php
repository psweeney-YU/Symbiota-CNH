<?php
include_once('../config/symbini.php');
header("Content-Type: text/html; charset=".$CHARSET);
?>
<html>
	<head>
		<title><?php echo $DEFAULT_TITLE; ?> Data Usage</title>
		<link rel="stylesheet" href="<?php echo $CLIENT_ROOT; ?>/css/base.css" type="text/css" />
		<link rel="stylesheet" href="<?php echo $CLIENT_ROOT; ?>/css/main.css" type="text/css" />
	</head>
<body>
<?php
	$displayLeftMenu = true;
	include($SERVER_ROOT.'/includes/header.php');
	?>
	<div class="navpath">
		<a href="../index.php">Home</a> &gt;
		<b>Data Usage</b>
	</div>
	<div id="innertext">
	    <div style="margin:25px;">
	        <h3 style="margin-top:10px;">Data Sharing Policy for Data Providers<sup>1</sup>: </H3>
	        <p>By sharing data through the Consortium of Northeastern Herbaria (CNH), data providers agree to make their data available for scientific research and for public information and education. Data providers must agree to the following terms and conditions:</p>
	        <ol>
	        	<li>Specimen data and related material (images, floristic lists, etc.; hereafter referred to simply as "data") accessible through the CNH Portal are openly and universally available to all users within the framework of the Data Usage Policy and within the terms and conditions that the data provider has identified in its metadata (e.g., in the "rights" field for specimen occurrence records).</li>
	        	<li>CNH does not assert intellectual property rights over the data made available through its network. Owners of the data (identified in the "rightsHolder" field for specimen occurrence records) retain all rights to the data that are shared.</li>
	        	<li>The data provider warrants that they have made the necessary agreements with the original owners of the data and have obtained rights to make the data available through the CNH Portal.</li>
	        	<li>The data provider makes reasonable efforts to ensure that the data they serve are accurate.</li>
	        	<li>CNH does not by default restrict access to sensitive data, thus the provider of the data may wish to withhold sensitive information in the dataset they provide. If data are withheld, the "informationWithheld" field should be used to indicate this.</li>
	        	<li>The sharing of data in a lower quality than the original (e.g., "fuzzed" locality information) is not recommended.   If this is done, it must be disclosed using the "dataGeneralizations" field to say so.</li>
	        	<li>The data provider is encouraged to provide a stable and unique identifier for each record in their dataset, so it can be referenced.</li>
	        	<li>Data providers should indicate their collection ("collectionCode," preferably an Index Herbariorum code), institution ("institutionCode" and"rightsHolder"), and intellectual property rights ("rights") in the data and metadata, where appropriate, so they can be attributed by the data user.</li>
	        	<li>CNH caches, on its web server, a copy of the data made available by each provider, to be used in accordance with the terms and conditions set forth by the data provider.</li>
	        	<li>CNH is not liable or responsible for the data contents, or for any loss, damage, claim, cost or expense however it may arise, from an inability to use the CNH Portal.</li>
			</ol>

<p>Data providers must agree to the <a href="usagepolicy.php">Data Usage Policy.</a></p>

<p><sup>1</sup>Adapted from the Consortium of Pacific Northwest Herbaria web site (www.pnwherbaria.org)</p>

	    </div>
	</div>
	<?php
	include($SERVER_ROOT.'/includes/footer.php');
	?>
</body>
</html>
