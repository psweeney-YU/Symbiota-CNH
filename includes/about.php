<?php
include_once("../config/symbini.php");
header("Content-Type: text/html; charset=".$CLIENT_ROOT);
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
?>
<html>
<head>
    <title><?php echo $DEFAULT_TITLE?> About</title>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
    <link rel="stylesheet" href="../css/base.css" type="text/css" />
    <link rel="stylesheet" href="../css/main.css" type="text/css" />
    <meta name='keywords' content='' />
	<script type="text/javascript">
		<?php include_once('includes/googleanalytics.php'); ?>
	</script>
</head>
<body>
	<?php
	include($SERVER_ROOT.'/includes/header.php');
	?>
        <!-- This is inner text! -->
        <div  id="innertext">
        	<div>
            	<h1>About CNH</h1>
				<hr />
 				<div>
 					<div style="margin-bottom:20px;">
						<p><strong>Mission:</strong> The Consortium of Northeastern Herbaria unites herbaria in northeastern North America to provide online access to specimen data
						housed in member institutions, with particular emphasis on collections from the region.  <em>The consortium has the subsidiary goals of:</em></p>
						<ul>
						<li>Facilitating herbarium-based biodiversity research and conservation activities. </li>
						<li>Sharing knowledge on digitization and other museum informatics technologies. </li>
						<li>Coordinating with other relevant regional, national, and international networks and organizations. </li>
						<li>Obtaining funding to support the goals of the consortium. &nbsp; <br />
						<p style="text-align: center;"><strong><br /></strong></p>
						<p style="text-align: center;"><strong>Map of region</strong></p>
						&nbsp;
					<div id="imagecenter"><img title="map" src="../includes/CNH_3.jpg" alt="Map of northeastern North America." width="400" /></div>
				</div>
			</div>
		</div>
		<!-- end of inner text! -->

	<?php
	include($SERVER_ROOT.'/includes/footer.php');
	?>
</body>
</html>
