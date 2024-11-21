<?php
//error_reporting(E_ALL);
//ini_set('display_errors', '1');
include_once('config/symbini.php');
include_once('classes/CountOccurrenceRecords.php');
if($LANG_TAG == 'en' || !file_exists($SERVER_ROOT.'/content/lang/templates/index.'.$LANG_TAG.'.php')) include_once($SERVER_ROOT.'/content/lang/templates/index.en.php');
else include_once($SERVER_ROOT.'/content/lang/templates/index.'.$LANG_TAG.'.php');
header('Content-Type: text/html; charset=' . $CHARSET);

$countRecords = new CountOccurrenceRecords();
?>
<!DOCTYPE html>
<html lang="<?php echo $LANG_TAG ?>">
<head>
    <title><?php echo $DEFAULT_TITLE; ?> Home</title>
	<?php
	$activateJQuery = false;
	include_once($SERVER_ROOT.'/includes/head.php');
	include_once($SERVER_ROOT . '/includes/googleanalytics.php');

	?>
    <meta name='keywords' content='' />
</head>
<body>
	<?php
	include($SERVER_ROOT."/includes/header.php");
	?>
        <!-- This is inner text! -->
        <main  id="innertext">
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
				-->
				<h4>About:</h4>
				<p>The CNH portal provides access to herbarium specimen data housed in member institutions, with particular emphasis on specimens collected in the region. The database includes taxa traditionally found in herbaria, including plants, fungi, diatoms, algae, and lichens.</p>
				<p>Use of any specimen data and related material (e.g., images, species checklists, etc.) accessed through this portal requires agreement to the terms and conditions in the <a style="font-weight:bold;" href="/portal/includes/usagepolicy.php">CNH data usage policy.</a></p>
				<p>If your institution is interested in sharing data and is willing to abide by the terms of our <a style="font-weight:bold;" href="/portal/misc/sharingpolicy.php">data sharing</a> and <a style="font-weight:bold;" href="/portal/includes/usagepolicy.php">data usage</a> policies, email <a style="color:#816E68;font-weight:bold;" href="mailto:patrick.sweeney@yale.edu">Patrick Sweeney</a> for further instructions about how to make this happen.
				<h4>Acknowledgements:</h4>
				<p>The CNH specimen portal utilizes <a href="https://symbiota.org">Symbiota</a>  and is supported by the Symbiota Support Hub, a domain of iDigBio (NSF Award #2027654).
				</p>
			</div>
			<hr style="margin: 25px 0;"/>
			<div style="width:100%;padding:0;">
				<img style="float: left;margin: 0;" title="Dicentra" src="includes/YU_specimen_sm.jpg" alt="Herbarium specimen" height="118" />
				<img style="margin-left: 27px;" title="Map" src="includes/CNH_map.jpg" alt="Map" height="118" />
				<img style="margin-left: 27px;" title="Data" src="includes/spreadsheet.png" alt="data" height="118" />
				<img style="margin-left: 27px;" title="Plot" src="includes/plot.png" alt="plot" height="118" /><br clear="both" />
			</div>
		</main>
	<?php
	//include($SERVER_ROOT."/includes/footer.php");
	?>
</body>
</html>
