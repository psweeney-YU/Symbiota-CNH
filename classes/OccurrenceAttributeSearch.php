<?php
include_once($SERVER_ROOT.'/classes/OccurrenceAttributes.php');

class OccurrenceAttributeSearch extends OccurrenceAttributes {

	//use $setAttributes = false in call to ->getTraitArr, if reverting to using OccurrenceAttributes class

	//private $traitSearchArr = array();
	public function __construct(){
		parent::__construct('readonly');
	}

	public function __destruct(){
		parent::__destruct();
	}

  public function getTraitSearchArr($traitID = null){
    if($traitID) {
      $traitIDArr = array_map('trim', explode(',', $traitID));
      if (($key = array_search('0', $traitIDArr)) !== false) {
          unset($traitIDArr[$key]);
      } // this purges potential zeros from the array
      $traitID = implode(',', $traitIDArr);
      foreach($traitIDArr as $tid) {
        if(!is_numeric($tid)) return null; // reject non-numeric IDs
      }
    }
    unset($this->traitArr);
    $this->traitArr = array();
    $this->setTraitSearchArr($traitID);
    $this->setTraitStates();
    return $this->traitArr;
  }

  private function setTraitSearchArr($traitID){
    $sql = 'SELECT traitid, traitname, traittype, units, description, refurl, notes, dynamicproperties FROM tmtraits WHERE traittype IN("UM","OM","TF","NU") ';
    if($traitID) $sql .= 'AND (traitid IN('.$traitID.'))';
    $rs = $this->conn->query($sql);
    while($r = $rs->fetch_object()){
      if(!isset($this->traitArr[$r->traitid])){
        $this->traitArr[$r->traitid]['name'] = $r->traitname;
        $this->traitArr[$r->traitid]['type'] = $r->traittype;
        $this->traitArr[$r->traitid]['props'] = $r->dynamicproperties;
        //Get dependent traits and append to return array
        $this->setDependentTraits($r->traitid);
      }
    }
    $rs->free();
    return $this->traitArr;
  }

	public function echoTraitSearchForm($traitID){
		echo $this->getTraitSearchHTML($traitID);
	}

	private function getTraitSearchHTML($traitID,$classStr=''){
		$divClass = '';
		if($classStr){
			$classArr = explode(' ',$classStr);
			$divClass = array_pop($classArr);
		}
		$retStr = '<div class="'.$divClass.'" style="margin-left:'.($classStr?'10':'').'px;"><div style="clear:both">';
		if(isset($this->traitArr[$traitID]['states'])){
			if($this->traitArr[$traitID]['type']=='TF'){
				$retStr .= '<div style="float:left;margin-left: 15px">'.$this->traitArr[$traitID]['name'].':</div>';
				$retStr .= '<div style="clear:both;margin-left: 25px">';
			}
			else $retStr .= '<div style="float:left;">';
			$attrStateArr = $this->traitArr[$traitID]['states'];
			foreach($attrStateArr as $sid => $sArr){
				$depTraitIdArr = array();
				if(isset($sArr['dependTraitID']) && $sArr['dependTraitID']) $depTraitIdArr = $sArr['dependTraitID'];
				if($this->traitArr[$traitID]['type']=='NU'){
					//Numeric traits are still in development, thus skip as a search term, for now
					continue;
				}
				else{
					$retStr .= '<div title="'.$sArr['description'].'" style="clear:both">';
					$retStr .= '<input name="attr[]" id="traitstateid-'.$sid.'" class="'.$classStr.'" type="checkbox" value="'.$sid.'" onchange="traitChanged(this)" /> ';
					$retStr .= $sArr['name'];
					if($depTraitIdArr){
						foreach($depTraitIdArr as $depTraitId){
							$retStr .= $this->getTraitSearchHTML($depTraitId,trim($classStr.' child-'.$sid));
						}
					}
					$retStr .= '</div>';
				}
			}
			$retStr .= '</div>';
		}
		$retStr .= '</div></div>';
		return $retStr;
	}
}