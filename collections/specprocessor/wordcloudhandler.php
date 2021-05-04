<?php
include_once('../../config/symbini.php');
include_once($SERVER_ROOT.'/classes/WordCloud.php');
header("Content-Type: text/html; charset=".$CHARSET);

$collTarget = array_key_exists("colltarget",$_REQUEST)?$_REQUEST["colltarget"]:5;

$cloudHandler = new WordCloud();
$cloudHandler->setWidth(800);
$cloudHandler->buildWordFile($collTarget);

?>
<html>
	<head>
	    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo $CHARSET;?>">
		<title><?php echo $DEFAULT_TITLE; ?> - Word Cloud Handler Collections</title>
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
		<script type="text/javascript">
		</script>
	</head>
	<body>
		<!-- This is inner text! -->
		<div id="innertext">
			<?php
			$cloudPath = $CLIENT_ROOT;
			if(substr($cloudPath,-1) != '/' && substr($cloudPath,-1) != "\\") $cloudPath .= '/';
			$cloudPath = 'content/collections/wordclouds/ocrcloud'.$collTarget.'.html';
			echo '<a href="'.$cloudPath.'">Cloud'.$collTarget.'</a>';
			?>
		</div>
	</body>
</html>