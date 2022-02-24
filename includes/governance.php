<?php
include_once("../config/symbini.php");
header("Content-Type: text/html; charset=".$CHARSET);
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
?>
<html>
<head>
    <title><?php echo $DEFAULT_TITLE?> Governance</title>
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
	$displayLeftMenu = false;
	include($SERVER_ROOT.'/includes/header.php');
	?>
        <!-- This is inner text! -->
        <div  id="innertext">
        	<div>
            	<h1>Governance</h1>
				<hr />
 				<div>
 					<div style="margin-bottom:20px;">
						<p>Interim assignments for governance of the CHN were established among the attendees of our 2008 meeting. A more formal governing structure was
						adopted at our 2009 meeting (<a href="<?php echo $CLIENT_ROOT; ?>/includes/gov_recommend.pdf">download</a>).</p>
						<p><strong>Steering committee</strong></p>
						<p>The committee includes individuals focusing on particular tasks as well as those with special expertise. The current members of the committee are:</p>
						<p><strong><a href="mailto:Patrick.Sweeney@yale.edu">Patrick Sweeney</a></strong>, Yale University, chairman<br />
						<strong>Alain Belliveau</strong>, Acadia University<br />
						<strong>Michael Donoghue</strong>, Yale University<br />
						<strong>Jennifer Doubt</strong>, Canadian Museum of Nature<br />
						<strong>James Macklin</strong>,&nbsp;Agriculture and Agri-Food Canada<br />
						<strong>Deborah Metsger</strong>, Royal Ontario Museum<br />
						<strong>Chris Neefus</strong>, University of New Hampshire</p>
					</div>
				</div>
			</div>
		</div>
		<!-- end of inner text! -->
	<?php
	include($SERVER_ROOT.'/includes/footer.php');
	?>
</body>
</html>
