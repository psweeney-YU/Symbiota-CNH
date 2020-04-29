<?php
include_once("config/symbini.php");
include_once("classes/CountOccurrenceRecords.php");
include_once('content/lang/index.'.$LANG_TAG.'.php');
header("Content-Type: text/html; charset=".$charset);
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past

$countRecords = new CountOccurrenceRecords();
?>
<html>
<head>
    <title><?php echo $defaultTitle?> Home</title>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
	<?php
	$activateJQuery = false;
	if(file_exists($SERVER_ROOT.'/includes/head.php')){
		include_once($SERVER_ROOT.'/includes/head.php');
	}
	else{
		echo '<link href="'.$CLIENT_ROOT.'/css/jquery-ui.css" type="text/css" rel="stylesheet" />';
		echo '<link href="'.$CLIENT_ROOT.'/css/base.css?ver=1" type="text/css" rel="stylesheet" />';
		echo '<link href="'.$CLIENT_ROOT.'/css/main.css?ver=1" type="text/css" rel="stylesheet" />';
	}
	?>
    <meta name='keywords' content='' />
</head>
<body>

	<?php
	$displayLeftMenu = "true";
	include($serverRoot."/header.php");
	?>
	
        <!-- This is inner text! -->
        <div  id="innertext">
        	<div>
            	<h1>Herbarium Specimen Data Sharing Portal for CNH</h1>
					<?php
						echo "<h4>Number of records in database: <em>".number_format($countRecords->theCount())."</em></h4>";
					?>
 				<hr />
 				<div>
 				<div style="margin-bottom:20px;">
 				<!--
				<h4 style="color:red">NOTE: As of Wednesday, October 21, images for some specimens are not available. This is due to a recent upgrade of iPlant servers that host NEVP images. We hope to resolve this issue soon. Sorry for the inconvenience.</h4>
				--!>
				<h4>About:</h4>
				<p>The CNH portal provides access to herbarium specimen data housed in member institutions, with particular emphasis on specimens collected in the region. The database includes taxa traditionally found in herbaria, including plants, fungi, diatoms, algae, and lichens.</p>
				<p>Use of any specimen data and related material (e.g., images, species checklists, etc.) accessed through this portal requires agreement to the terms and conditions in the <a style="color:#816E68;font-weight:bold;" href="/portal/misc/usagepolicy.php">CNH data usage policy.</a></p>
				<p>If your institution is interested in sharing data and is willing to abide by the terms of our <a style="color:#816E68;font-weight:bold;" href="/portal/misc/sharingpolicy.php">data sharing</a> and <a style="color:#816E68;font-weight:bold;" href="/portal/misc/usagepolicy.php">data usage</a> policies, email <a style="color:#816E68;font-weight:bold;" href="mailto:patrick.sweeney@yale.edu">Patrick Sweeney</a> for further instructions about how to make this happen.
				<h4>Acknowledgements:</h4>
				<p>The CNH specimen portal utilizes the Symbiota framework.  The Symbiota Software Project (<a href="http://www.symbiota.org">www.symbiota.org</a>) is an NSF funded endeavor based at Arizona State University.  We are particularly indebted to Edward Gilbert for assiting CNH in implementing this Symbiota instance.
				</p>
			</div>
		<hr style="margin: 25px 0;"/>
			<div style="width:100%;padding:0;">
				<img style="float: left;margin: 0;" title="Dicentra" src="images/YU_specimen_sm.jpg" alt="Herbarium specimen" height="118" />
				<img style="margin-left: 27px;" title="Map" src="images/CNH_map.jpg" alt="Map" height="118" />
				<img style="margin-left: 27px;" title="Data" src="images/spreadsheet.png" alt="data" height="118" />
				<img style="margin-left: 27px;" title="Plot" src="images/plot.png" alt="plot" height="118" /><br clear="both" />
			</div>
		</div>
		<!-- end of inner text! -->
		
	<?php
	//include($serverRoot."/footer.php");
	?> 

	<script type="text/javascript">
		var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
		document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
	</script>
	<script type="text/javascript">
		try {
			var pageTracker = _gat._getTracker("<?php echo $googleAnalyticsKey; ?>");
			pageTracker._trackPageview();
		} catch(err) {}
	</script>

</body>
</html>
