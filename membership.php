<?php
include_once("config/symbini.php");
header("Content-Type: text/html; charset=".$charset);
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
?>
<html>
<head>
    <title><?php echo $defaultTitle?> Membership</title>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
    <link rel="stylesheet" href="css/base.css" type="text/css" />
    <link rel="stylesheet" href="css/main.css" type="text/css" />
    <meta name='keywords' content='' />
</head>
<body>

	<?php
	include($serverRoot."/header.php");
	?>
	
        <!-- This is inner text! -->
        <div  id="innertext">
        	<div>
            	<h1>Membership</h1>
				<hr />
 					<div>
 						<div style="margin-bottom:20px;">
							<p>The Consortium of Northeastern Herbaria is an organization comprised of herbaria in northeastern North America, a region encompassing the Canadian provinces New Brunswick, Newfoundland & Labrador, Nova Scotia, Prince Edward Island, Ontario, and Quebec, and Connecticut, Maine, Massachusetts, New Hampshire, New Jersey, New York, Pennsylvania, Rhode Island, and Vermont in the United States.</p>

							<p>Membership is open to herbaria within our geographic scope whose collections include regional holdings.  We hope to represent the interests of all of the official plant collections in the area – from large ones with millions of specimens to the very smallest with only a single herbarium cabinet.</p>   

							<p>We expect that member collections are permanently housed in the region, maintained to accepted curatorial standards, managed by trained personnel, and accessible for consultation.</p>

							<p>Our organismal scope includes taxa traditionally found in herbaria, including plants, fungi, diatoms, algae, and lichens.</p>

							<p>Specimen occurrence data from member institutions can be shared through our data sharing portal.  If your institution is interested in sharing data and are willing to abide by the terms of our <a style=color:blue; href="http://portal.neherbaria.org/portal/misc/sharingpolicy.php">data sharing</a> and <a style=color:blue; href="http://portal.neherbaria.org/portal/misc/usagepolicy.php">data usage</a> policies, email <a style=color:blue; href="mailto:patrick.sweeney@yale.edu">Patrick Sweeney</a> for further instructions about how to make this happen.</p>

							<p>To join CNH click <a style=color:blue; href="https://docs.google.com/forms/d/e/1FAIpQLSc2GqOSktOg7GzmtuQDiBAOJXUS9FxOt87K_f-86rQTyo-vYQ/viewform">here</a>.</p>
							<!-- <p>Visit this <a style=color:blue; href="http://neherbaria.org">page</a> to join CNH.</p> -->
						</div>
					</div>
		<!-- end of inner text! -->
			</div>
		</div>

	<?php
	include($serverRoot."/footer.php");
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
