<?php
include_once('../../config/symbini.php');
include_once($SERVER_ROOT.'/classes/OccurrenceEditorResource.php');
header("Content-Type: text/html; charset=".$CHARSET);

$occid = $_POST['occid'];
$collid = $_POST['collid'];
$occIndex = $_POST['occindex'];
$action = (isset($_POST['submitaction'])?$_POST['submitaction']:'');

//Sanitation
if(!is_numeric($occid)) $occid = 0;
if(!is_numeric($collid)) $collid = 0;
if(!is_numeric($occIndex)) $occIndex = 0;

if($occid && $SYMB_UID){
	$occManager = new OccurrenceEditorResource();
	$occManager->setOccId($occid);
	$occManager->setCollId($collid);
	$occManager->getOccurMap();
	$isEditor = false;
	if($IS_ADMIN) $isEditor = true;
	elseif($collid && array_key_exists('CollAdmin',$USER_RIGHTS) && in_array($collid,$USER_RIGHTS['CollAdmin'])) $isEditor = true;
	elseif($collid && array_key_exists('CollEditor',$USER_RIGHTS) && in_array($collid,$USER_RIGHTS['CollEditor'])) $isEditor = true;
	elseif($occManager->isPersonalManagement()) $isEditor = true;
	if($isEditor){
		if($action == 'createAssociation'){
			$occManager->addAssociation($_POST);
		}
		elseif(array_key_exists('delassocid', $_POST)){
			$occManager->deleteAssociation($_POST['delassocid']);
		}
	}
	header('Location: occurrenceeditor.php?tabtarget=3&occid='.$occid.'&occindex='.$occIndex.'&collid='.$collid);
}

?>