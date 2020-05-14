<?php
include_once('../../config/symbini.php');
include_once($SERVER_ROOT.'/classes/TPEditorManager.php');
include_once($SERVER_ROOT.'/classes/TPDescEditorManager.php');
include_once($SERVER_ROOT.'/classes/TPImageEditorManager.php');
header("Content-Type: text/html; charset=".$CHARSET);

$tid = array_key_exists("tid",$_REQUEST)?$_REQUEST["tid"]:0;
$taxon = array_key_exists("taxon",$_REQUEST)?$_REQUEST["taxon"]:"";
$lang = array_key_exists("lang",$_REQUEST)?$_REQUEST["lang"]:"";
$action = array_key_exists("action",$_REQUEST)?$_REQUEST["action"]:"";
$tabIndex = array_key_exists("tabindex",$_REQUEST)?$_REQUEST["tabindex"]:0;

if(!is_numeric($tabIndex)) $tabIndex = 0;

$tEditor;
if($tabIndex == 1 || $tabIndex == 2){
	$tEditor = new TPImageEditorManager();
}
elseif($tabIndex == 4){
	$tEditor = new TPDescEditorManager();
}
else{
	$tEditor = new TPEditorManager();
}

$tid = $tEditor->setTid($tid?$tid:$taxon);
if($lang) $tEditor->setLanguage($lang);

$statusStr = "";
$editable = false;
if($IS_ADMIN || array_key_exists("TaxonProfile",$USER_RIGHTS)){
	$editable = true;
}

if($editable && $action){
	if($action == "Edit Synonym Sort Order"){
		$synSortArr = Array();
		foreach($_REQUEST as $sortKey => $sortValue){
			if($sortValue && (substr($sortKey,0,4) == "syn-")){
				$synSortArr[substr($sortKey,4)] = $sortValue;
			}
		}
		$statusStr = $tEditor->editSynonymSort($synSortArr);
	}
	elseif($action == "Submit Common Name Edits"){
		$editVernArr = Array();
		$editVernArr["vid"] = $_REQUEST["vid"];
		if($_REQUEST["vernacularname"]) $editVernArr["vernacularname"] = str_replace("\"","-",$_REQUEST["vernacularname"]);
		if($_REQUEST["language"]) $editVernArr["language"] = $_REQUEST["language"];
		$editVernArr["notes"] = str_replace("\"","-",$_REQUEST["notes"]);
		$editVernArr["source"] = $_REQUEST["source"];
		if($_REQUEST["sortsequence"]) $editVernArr["sortsequence"] = $_REQUEST["sortsequence"];
		$editVernArr["username"] = $PARAMS_ARR["un"];
		$statusStr = $tEditor->editVernacular($editVernArr);
	}
	elseif($action == "Add Common Name"){
		$addVernArr = Array();
		$addVernArr["vernacularname"] = str_replace("\"","-",$_REQUEST["vern"]);
		if($_REQUEST["language"]) $addVernArr["language"] = $_REQUEST["language"];
		if($_REQUEST["notes"]) $addVernArr["notes"] = str_replace("\"","-",$_REQUEST["notes"]);
		if($_REQUEST["source"]) $addVernArr["source"] = $_REQUEST["source"];
		if($_REQUEST["sortsequence"]) $addVernArr["sortsequence"] = $_REQUEST["sortsequence"];
		$addVernArr["username"] = $PARAMS_ARR["un"];
		$statusStr = $tEditor->addVernacular($addVernArr);
	}
	elseif($action == "Delete Common Name"){
		$delVern = $_REQUEST["delvern"];
		$statusStr = $tEditor->deleteVernacular($delVern);
	}
	elseif($action == 'Add Description Block'){
		if(!$tEditor->addDescriptionBlock($_POST)){
			$statusStr = $tEditor->getErrorMessage();
		}
	}
	elseif($action == 'saveDescriptionBlock'){
		if(!$tEditor->editDescriptionBlock($_POST)){
			$statusStr = $tEditor->getErrorMessage();
		}
	}
	elseif($action == 'Delete Description Block'){
		if(!$tEditor->deleteDescriptionBlock($_POST['tdbid'])){
			$statusStr = $tEditor->getErrorMessage();
		}
	}
	elseif($action == "remap"){
		if(!$tEditor->remapDescriptionBlock($_GET['tdbid'])){
			$statusStr = $tEditor->getErrorMessage();
		}
	}
	elseif($action == "Add Statement"){
		if(!$tEditor->addStatement($_POST)){
			$statusStr = $tEditor->getErrorMessage();
		}
	}
	elseif($action == "saveStatementEdit"){
		if(!$tEditor->editStatement($_POST)){
			$statusStr = $tEditor->getErrorMessage();
		}
	}
	elseif($action == "Delete Statement"){
		if(!$tEditor->deleteStatement($_POST['tdsid'])){
			$statusStr = $tEditor->getErrorMessage();
		}
	}
	elseif($action == "Submit Image Sort Edits"){
		$imgSortArr = Array();
		foreach($_REQUEST as $sortKey => $sortValue){
			if($sortValue && substr($sortKey,0,6) == "imgid-"){
				$imgSortArr[substr($sortKey,6)]  = $sortValue;
			}
		}
		$statusStr = $tEditor->editImageSort($imgSortArr);
	}
	elseif($action == "Upload Image"){
		if($tEditor->loadImage($_POST)){
			$statusStr = 'Image uploaded successful';
		}
		if($tEditor->getErrorMessage()){
			$statusStr .= '<br/>'.$tEditor->getErrorMessage();
		}
	}
}
?>
<html>
<head>
	<title><?php echo $DEFAULT_TITLE." Taxon Editor: ".$tEditor->getSciName(); ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $CHARSET;?>" />
	<?php
	$activateJQuery = true;
	if(file_exists($SERVER_ROOT.'/includes/head.php')){
		include_once($SERVER_ROOT.'/includes/head.php');
	}
	else{
		echo '<link href="'.$CLIENT_ROOT.'/css/jquery-ui.css" type="text/css" rel="stylesheet" />';
		echo '<link href="'.$CLIENT_ROOT.'/css/base.css?ver=1" type="text/css" rel="stylesheet" />';
		echo '<link href="'.$CLIENT_ROOT.'/css/main.css?ver=1" type="text/css" rel="stylesheet" />';
	}
	?>
	<script type="text/javascript" src="../../js/symb/shared.js"></script>
	<script type="text/javascript" src="../../js/jquery.js"></script>
	<script type="text/javascript" src="../../js/jquery-ui.js"></script>
	<script type="text/javascript" src="../../js/tinymce/tinymce.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$("#sninput").autocomplete({
				source: function( request, response ) {
					$.getJSON( "rpc/gettaxasuggest.php", { "term": request.term, "taid": "1" }, response );
				}
			},{ minLength: 3, autoFocus: true }
			);

			$('#tabs').tabs({
				active: <?php echo $tabIndex; ?>
			});

		});

		function checkGetTidForm(f){
			if(f.taxon.value == ""){
				alert("Please enter a scientific name.");
				return false;
			}
			return true;
		}

		function submitAddImageForm(f){
			var fileBox = document.getElementById("imgfile");
			var file = fileBox.files[0];
			if(file.size>4000000){
				alert("The image you are trying to upload is too big, please reduce the file size to less than 4MB");
				return false;
			}
		}

		function openOccurrenceSearch(target) {
			occWindow=open("../../collections/misc/occurrencesearch.php?targetid="+target,"occsearch","resizable=1,scrollbars=1,width=700,height=500,left=20,top=20");
			if (occWindow.opener == null) occWindow.opener = self;
		}
	</script>
	<style type="text/css">
		#redirectedfrom{ font-size:16px; margin-top:5px; margin-left:10px; font-weight:bold; }
		#taxonDiv{ font-size:18px; margin-top:15px; margin-left:10px; }
		#taxonDiv a{ color:#990000; font-weight: bold; font-style: italic; }
		#taxonDiv img{ border: 0px; margin: 0px; height: 15px; }
		#family{ margin-left:20px; margin-top:0.25em; }
		.tox-dialog{ min-height: 400px }
		input{ margin:3px; }
		hr{ margin:30px 0px; }
	</style>
</head>
<body>
	<?php
	$displayLeftMenu = (isset($taxa_admin_tpeditorMenu)?$taxa_admin_tpeditorMenu:false);
	include($SERVER_ROOT.'/includes/header.php');
	if(isset($taxa_admin_tpeditorCrumbs)){
		echo "<div class='navpath'>";
		echo $taxa_admin_tpeditorCrumbs;
		echo " <b>Taxon Profile Editor</b>";
		echo "</div>";
	}
	?>
	<div id="innertext">
		<?php
		if($tEditor->getTid()){
			if($editable){
				if($tEditor->isForwarded()) echo '<div id="redirectedfrom">Redirected from: <i>'.$tEditor->getSubmittedValue('sciname').'</i></div>';
				echo '<div id="taxonDiv"><a href="../index.php?taxon='.$tEditor->getTid().'">'.$tEditor->getSciName().'</a> '.$tEditor->getAuthor();
				if($tEditor->getRankId() > 140) echo "&nbsp;<a href='tpeditor.php?tid=".$tEditor->getParentTid()."'><img src='../../images/toparent.png' title='Go to Parent' /></a>";
				echo "</div>\n";
				if($tEditor->getFamily()) echo '<div id="familyDiv"><b>Family:</b> '.$tEditor->getFamily().'</div>'."\n";
				if($statusStr) echo '<div style="margin:15px;font-weight:bold;font-size:120%;color:'.(stripos($statusStr,'error') !== false?'red':'green') .';">'.$statusStr.'</div>';
				?>
				<div id="tabs" style="margin:10px;">
					<ul>
						<li><a href="#commontab"><span>Synonyms / Vernaculars</span></a></li>
				        <li><a href="tpimageeditor.php?tid=<?php echo $tEditor->getTid().'&lang='.$lang; ?>"><span>Images</span></a></li>
				        <li><a href="tpimageeditor.php?tid=<?php echo $tEditor->getTid().'&lang='.$lang.'&cat=imagequicksort'; ?>"><span>Image Sort</span></a></li>
				        <li><a href="tpimageeditor.php?tid=<?php echo $tEditor->getTid().'&lang='.$lang.'&cat=imageadd'; ?>"><span>Add Image</span></a></li>
				        <li><a href="tpdesceditor.php?tid=<?php echo $tEditor->getTid().'&lang='.$lang.'&action='.$action; ?>"><span>Descriptions</span></a></li>
				    </ul>
					<div id="commontab">
						<?php
						//Display Common Names (vernaculars)
						$vernList = $tEditor->getVernaculars();
						?>
						<div>
							<div style="margin:10px 0px">
								<b><?php echo ($vernList?'Common Names':'No common names in system'); ?></b>
								<span onclick="toggle('addvern');" title="Add a New Common Name">
									<img style="border:0px;width:15px;" src="../../images/add.png"/>
								</span>
							</div>
							<div id="addvern" class="addvern" style="display:<?php echo ($vernList?'none':'block'); ?>;">
								<form name="addvernform" action="tpeditor.php" method="post" >
									<fieldset style="width:250px;margin:5px 0px 0px 20px;">
										<legend><b>New Common Name</b></legend>
										<div>
											Common Name:
											<input name="vern" style="margin-top:5px;border:inset;" type="text" />
										</div>
										<div>
											Language:
											<input name="language" style="margin-top:5px;border:inset;" type="text" />
										</div>
										<div>
											Notes:
											<input name="notes" style="margin-top:5px;border:inset;" type="text" />
										</div>
										<div>
											Source:
											<input name="source" style="margin-top:5px;border:inset;" type="text" />
										</div>
										<div>
											Sort Sequence:
											<input name="sortsequence" style="margin-top:5px;border:inset;width:40px" type="text" />
										</div>
										<div>
											<input type="hidden" name="tid" value="<?php echo $tEditor->getTid(); ?>" />
											<input id="vernsadd" name="action" style="margin-top:5px;" type="submit" value="Add Common Name" />
										</div>
									</fieldset>
								</form>
							</div>
							<?php
							foreach($vernList as $lang => $vernsList){
								?>
								<div style="width:250px;margin:5px 0px 0px 15px;">
									<fieldset>
									<legend><b><?php echo $lang; ?></b></legend>
									<?php
										foreach($vernsList as $vernArr){
											?>
											<div style="margin-left:10px;">
												<b><?php echo $vernArr["vernacularname"]; ?></b>
												<span onclick="toggle('vid-<?php echo $vernArr["vid"]; ?>');" title="Edit Common Name">
													<img style="border:0px;width:12px;" src="../../images/edit.png" />
												</span>
											</div>
											<form name="updatevern" action="tpeditor.php" method="post" style="margin-left:20px;">
												<div class='vid-<?php echo $vernArr["vid"]; ?>' style='display:none;'>
													<input id='vernacularname' name='vernacularname' style='margin:2px 0px 5px 15px;border:inset;' type='text' value='<?php echo $vernArr["vernacularname"]; ?>' />
												</div>
												<div>
													Language: <?php echo $vernArr["language"]; ?>
												</div>
												<div class='vid-<?php echo $vernArr["vid"]; ?>' style='display:none;'>
													<input id='language' name='language' style='margin:2px 0px 5px 15px;border:inset;' type='text' value='<?php echo $vernArr["language"]; ?>' />
												</div>
												<div>
													Notes: <?php echo $vernArr["notes"]; ?>
												</div>
												<div class='vid-<?php echo $vernArr["vid"]; ?>' style='display:none;'>
													<input id='notes' name='notes' style='margin:2px 0px 5px 15px;border:inset;' type='text' value='<?php echo $vernArr["notes"];?>' />
												</div>
												<div style=''>Source: <?php echo $vernArr["source"]; ?></div>
												<div class='vid-<?php echo $vernArr["vid"]; ?>' style='display:none;'>
													<input id='source' name='source' style='margin:2px 0px 5px 15px;border:inset;' type='text' value='<?php echo $vernArr["source"]; ?>' />
												</div>
												<div style=''>Sort Sequence: <?php echo $vernArr["sortsequence"];?></div>
												<div class='vid-<?php echo $vernArr["vid"]; ?>' style='display:none;'>
													<input id='sortsequence' name='sortsequence' style='margin:2px 0px 5px 15px;border:inset;width:40px;' type='text' value='<?php echo $vernArr["sortsequence"]; ?>' />
												</div>
												<input type='hidden' name='vid' value='<?php echo $vernArr["vid"]; ?>' />
												<input type='hidden' name='tid' value='<?php echo $tEditor->getTid();?>' />
												<div class='vid-<?php echo $vernArr["vid"];?>' style='display:none;'>
													<input id='vernssubmit' name='action' type='submit' value='Submit Common Name Edits' />
												</div>
											</form>
											<div class='vid-<?php echo $vernArr["vid"]; ?>' style='display:none;margin:15px;'>
												<form id='delvern' name='delvern' action='tpeditor.php' method='post' onsubmit="return window.confirm('Are you sure you want to delete this Common Name?')">
													<input type='hidden' name='delvern' value='<?php echo $vernArr["vid"]; ?>' />
													<input type='hidden' name='tid' value='<?php echo $tEditor->getTid(); ?>' />
													<input name='action' type='hidden' value='Delete Common Name' />
													<input name='submitaction' type='image' value='Delete Common Name' style='height:12px;' src='../../images/del.png' />
													Delete Common Name
												</form>
											</div>
											<?php
										}
										?>
									</fieldset>
								</div>
								<?php
							}
							?>
						</div>
						<hr/>
						<fieldset style='padding:10px;margin:30px 0px;width:400px;'>
							<legend><b>Synonyms</b></legend>
							<?php
							//Display Synonyms
							if($synonymArr = $tEditor->getSynonym()){
								?>
								<div style="float:right;" title="Edit Synonym Sort Order">
									<a href="#"  onclick="toggle('synsort');return false;"><img style="border:0px;width:12px;" src="../../images/edit.png"/></a>
								</div>
								<div style="font-weight:bold;margin-left:15px;">
									<ul>
										<?php
										foreach($synonymArr as $tidKey => $valueArr){
											 echo '<li>'.$valueArr["sciname"].'</li>';
										}
										?>
									</ul>
								</div>
								<div class="synsort" style="display:none;">
									<form name="synsortform" action="tpeditor.php" method="post">
										<input type="hidden" name="tid" value="<?php echo $tEditor->getTid(); ?>" />
										<fieldset style='margin:5px 0px 5px 5px;margin-left:20px;width:350px;'>
										<legend><b>Synonym Sort Order</b></legend>
										<?php
										foreach($synonymArr as $tidKey => $valueArr){
											?>
												<div>
													<b><?php echo $valueArr["sortsequence"]; ?></b> -
													<?php echo $valueArr["sciname"]; ?>
												</div>
												<div style="margin:0px 0px 5px 10px;">
													new sort value:
													<input type="text" name="syn-<?php echo $tidKey; ?>" style="width:35px;border:inset;" />
												</div>
												<?php
											}
											?>
											<div>
												<input type="submit" name="action" value="Edit Synonym Sort Order" />
											</div>
										</fieldset>
									</form>
								</div>
								<?php
							}
							else{
								echo '<div style="margin:20px 0px"><b>No synonym links</b></div>';
							}
							?>
							<div style="margin:10px;">
								*Most of the synonym management must be done in the Taxonomic Thesaurus editing module (see <a href="../../sitemap.php">sitemap</a>).
							</div>
						</fieldset>
					</div>
				</div>
				<?php
			}
			else{
				?>
				<div style="margin:30px;">
					<h2>You are not authorized to edit this page</h2>
				</div>
				<?php
			}
		}
		else{
			?>
			<div style="margin:20px;">
				<div style="font-weight:bold;">
				<?php
				if($taxon){
					echo "<i>".ucfirst($taxon)."</i> not found in system. Check to see if spelled correctly and if so, add to system.";
				}
				else{
					echo "Enter scientific name you wish to edit:";
				}
				?>
				</div>
				<form name="gettidform" action="tpeditor.php" method="post" onsubmit="return checkGetTidForm(this);">
					<input id="sninput" name="taxon" value="<?php echo $taxon; ?>" size="40" />
					<input type="hidden" name="lang" value="<?php echo $lang; ?>" />
					<input type="hidden" name="tabindex" value="<?php echo $tabIndex; ?>" />
					<input type="submit" name="action" value="Edit Taxon" />
				</form>
			</div>
			<?php
		}
		?>
	</div>
	<?php
	include($SERVER_ROOT.'/includes/footer.php');
	?>
</body>
</html>