<?php
include_once($SERVER_ROOT.'/classes/Manager.php');

class GamesManager extends Manager{

	private $clid;
	private $clidStr;
	private $dynClid;
	private $taxonFilter;
	private $showCommon = 0;
	private $langId;

	public function __construct(){
		parent::__construct();
	}

	public function __destruct(){
		parent::__destruct();
	}

	public function getChecklistArr($projId = 0){
		$retArr = Array();
		$sql = 'SELECT DISTINCT c.clid, c.name '.
			'FROM fmchecklists c INNER JOIN fmchklstprojlink plink ON c.clid = plink.clid ';
		if($projId){
			$sql .= 'WHERE c.type = "static" AND (plink.pid = '.$projId.') ';
		}
		else{
			$sql .= 'INNER JOIN fmprojects p ON plink.pid = p.pid WHERE c.type = "static" AND p.ispublic = 1 ';
		}
		$sql .= 'ORDER BY c.name';
		//echo '<div>'.$sql.'</div>';
		$rs = $this->conn->query($sql);
		while($row = $rs->fetch_object()){
			$retArr[$row->clid] = $row->name;
		}
		$rs->free();
		return $retArr;
	}

	//Organism of the day game
	public function setOOTD($oodID,$clid){
		global $SERVER_ROOT;
		//Sanitation: $clid variable cound be a single checklist or a collection of clid separated by commas
		if(!preg_match('/^[\d,]+$/',$clid)) return '';
		if(is_numeric($oodID)){
			$currentDate = date("Y-m-d");
			$replace = 0;
			$oldArr = array();
			if(file_exists($SERVER_ROOT.'/content/ootd/'.$oodID.'_info.json')){
				$oldArr = json_decode(file_get_contents($SERVER_ROOT.'/content/ootd/'.$oodID.'_info.json'), true);
				$lastDate = $oldArr['lastDate'];
				$lastCLID = $oldArr['clid'];
				if(($currentDate > $lastDate) || ($clid && $clid != $lastCLID)) $replace = 1;
			}
			else $replace = 1;
			if($replace == 1){
				//Delete old files
				$previous = Array();
				if(file_exists($SERVER_ROOT.'/content/ootd/'.$oodID.'_previous.json')){
					$previous = json_decode(file_get_contents($SERVER_ROOT.'/content/ootd/'.$oodID.'_previous.json'), true);
					unlink($SERVER_ROOT.'/content/ootd/'.$oodID.'_previous.json');
				}
				if(file_exists($SERVER_ROOT.'/content/ootd/'.$oodID.'_info.json')){
					unlink($SERVER_ROOT.'/content/ootd/'.$oodID.'_info.json');
				}
				if($oldArr){
					foreach($oldArr['images'] as $imgUrl){
						$fileUrl = $SERVER_ROOT.substr($imgUrl,strlen($GLOBALS['CLIENT_ROOT']));
						if(file_exists($fileUrl)) unlink($fileUrl);
					}
				}

				//Create new files
				$ootdInfo = array();
				$ootdInfo['lastDate'] = $currentDate;

				$tidArr = Array();
				$sql = 'SELECT l.TID, COUNT(m.mediaID) AS cnt '.
					'FROM fmchklsttaxalink l INNER JOIN media m ON l.TID = m.tid '.
					'LEFT JOIN omoccurrences o ON m.occid = o.occid '.
					'LEFT JOIN omcollections c ON o.collid = c.collid '.
					'WHERE (l.CLID IN('.$clid.')) AND (m.occid IS NULL OR c.CollType LIKE "%Observations") '.
					'GROUP BY l.TID';

				$rs = $this->conn->query($sql);
				while($row = $rs->fetch_object()){
					if(($row->cnt > 2) && (!in_array($row->TID, $previous))){
						$tidArr[] = $row->TID;
					}
				}
				$rs->free();
				$k = array_rand($tidArr);
				$randTaxa = $tidArr[$k];
				if($randTaxa){
					$previous[] = $randTaxa;
					//echo $randTaxa.' ';
					//echo json_encode($previous);

					$ootdInfo['clid'] = $clid;

					$sql2 = 'SELECT t.TID, t.SciName, t.UnitName1, s.family '.
						'FROM taxa AS t INNER JOIN taxstatus AS s ON t.TID = s.tid '.
						'WHERE s.taxauthid = 1 AND t.TID = '.$randTaxa.' ';
					//echo '<div>'.$sql2.'</div>';
					$rs = $this->conn->query($sql2);
					while($row = $rs->fetch_object()){
						$ootdInfo['tid'] = $row->TID;
						$ootdInfo['sciname'] = $row->SciName;
						$ootdInfo['genus'] = $row->UnitName1;
						$ootdInfo['family'] = $row->family;
					}
					$rs->free();

					$domain = "http://";
					if((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443) $domain = "https://";
					$domain .= $_SERVER["HTTP_HOST"];
					if($_SERVER["SERVER_PORT"] && $_SERVER["SERVER_PORT"] != 80 && $_SERVER['SERVER_PORT'] != 443) $domain .= ':'.$_SERVER["SERVER_PORT"];

					$files = Array();
					$sql3 = 'SELECT url FROM media WHERE (tid = '.$randTaxa.' AND url IS NOT NULL AND url != "empty") ORDER BY sortsequence ';
					//echo '<div>'.$sql.'</div>';
					$cnt = 1;
					$repcnt = 1;
					$rs = $this->conn->query($sql3);
					$newfileBase = '/content/ootd/'.$oodID.'_'.time().'_';
					while(($row = $rs->fetch_object()) && ($cnt < 6)){
						$file = '';
						if (substr($row->url, 0, 1) == '/'){
							if(!empty($GLOBALS['MEDIA_DOMAIN'])) $file = $GLOBALS['MEDIA_DOMAIN'] . $row->url;
							else $file = $domain.$row->url;
						}
						else{
							$file = $row->url;
						}
						$newfile = $newfileBase.$cnt.'.jpg';
						if(copy($file, $SERVER_ROOT.$newfile)){
							$files[] = $GLOBALS['CLIENT_ROOT'].$newfile;
							$cnt++;
						}
					}
					$rs->free();
					$ootdInfo['images'] = $files;

					if(array_diff($tidArr,$previous)){
						$fp = fopen($SERVER_ROOT.'/content/ootd/'.$oodID.'_previous.json', 'w');
						fwrite($fp, json_encode($previous));
						fclose($fp);
					}
					$fp = fopen($SERVER_ROOT.'/content/ootd/'.$oodID.'_info.json', 'w');
					fwrite($fp, json_encode($ootdInfo));
					fclose($fp);
				}
			}

			$infoArr = json_decode(file_get_contents($SERVER_ROOT.'/content/ootd/'.$oodID.'_info.json'), true);
			//echo json_encode($infoArr);
		}
		return $infoArr;
	}

	//Flashcard functions
	public function getFlashcardImages(){
			//Get species list
		$taxaArr = Array();
		//Grab a random list of no more than 200 taxa
		$sql = '';
		if($this->clid){
			if(!$this->clidStr) $this->setClidStr();
			$sql = 'SELECT DISTINCT t.tid, t.sciname, ts.tidaccepted '.
				'FROM taxa t INNER JOIN fmchklsttaxalink ctl ON t.tid = ctl.tid '.
				'INNER JOIN taxstatus ts ON t.tid = ts.tid '.
				'WHERE (ctl.clid IN('.$this->clidStr.')) AND (ts.taxauthid = 1) ';
		}
		else{
			$sql = 'SELECT DISTINCT t.tid, t.sciname, ts.tidaccepted '.
				'FROM taxa t INNER JOIN fmdyncltaxalink ctl ON t.tid = ctl.tid '.
				'INNER JOIN taxstatus ts ON t.tid = ts.tid '.
				'WHERE (ctl.dynclid = '.$this->dynClid.') AND (ts.taxauthid = 1) ';
		}
		if($this->taxonFilter) $sql .= 'AND (ts.Family = "'.$this->taxonFilter.'" OR t.sciname Like "'.$this->taxonFilter.'%") ';
		$sql .= 'ORDER BY RAND() LIMIT 200 ';
		if($rs = $this->conn->query($sql)){
			while($r = $rs->fetch_object()){
				$taxaArr[$r->tidaccepted]['tid'] = $r->tid;
				$taxaArr[$r->tidaccepted]['sciname'] = $r->sciname;
			}
			$rs->free();
		}

		if($taxaArr){
			$tidStr = implode(',',array_keys($taxaArr));

			if($this->showCommon){
				//Grab vernaculars
				$sqlV = 'SELECT ts.tidaccepted, v.vernacularname '.
					'FROM taxavernaculars v INNER JOIN taxstatus ts ON v.tid = ts.tid '.
					'WHERE v.langid = '.$this->langId.' AND ts.taxauthid = 1 AND ts.tidaccepted IN('.$tidStr.') '.
					'ORDER BY v.SortSequence';
				if($rsV = $this->conn->query($sqlV)){
					while($rV = $rsV->fetch_object()){
						if(!array_key_exists('vern', $taxaArr[$rV->tidaccepted])) $taxaArr[$rV->tidaccepted]['vern'] = $rV->vernacularname;
					}
					$rsV->free();
				}
			}
			foreach($taxaArr as $tidAccepted => $retData){
				//Grab images, first pass
				$this->loadImages($taxaArr, $tidAccepted);
				if(isset($taxaArr[$tidAccepted]['url']) && count($taxaArr[$tidAccepted]['url']) < 5) $this->loadImages($taxaArr, $tidAccepted, true);
			}
		}
		return $taxaArr;
	}

	private function loadImages(&$taxaArr, $tid, $targetChildTaxa = false){
		$sql = 'SELECT m.mediaID, m.url, m.originalUrl
			FROM media m INNER JOIN taxstatus ts ON m.tid = ts.tid
			WHERE ts.taxauthid = 1 AND ts.' . ($targetChildTaxa ? 'parenttid' : 'tidaccepted') . ' IN(' . $tid . ') AND (m.mediaType = "image") AND (m.creatorUid IS NOT NULL)
			ORDER BY m.sortsequence LIMIT 5';
		$rs = $this->conn->query($sql);
		while($r = $rs->fetch_object()){
			$url = $r->url;
			if(!$url && $url == 'empty') $url = $r->originalUrl;
			if(array_key_exists('MEDIA_DOMAIN', $GLOBALS) && substr($url, 0, 1) == '/'){
				$url = $GLOBALS['MEDIA_DOMAIN'] . $url;
			}
			$taxaArr[$tid]['url'][$r->mediaID] = $url;
			if(count($taxaArr[$tid]['url']) >= 5) break;
		}
		$rs->free();
	}

	public function echoFlashcardTaxonFilterList(){
		$returnArr = Array();
		if($this->clid || $this->dynClid){
			$sqlFamily = '';
			if($this->clid){
				if(!$this->clidStr) $this->setClidStr();
				$sqlFamily = 'SELECT DISTINCT IFNULL(ctl.familyoverride,ts.Family) AS family '.
					'FROM taxa t INNER JOIN taxstatus ts ON t.TID = ts.TID '.
					'INNER JOIN fmchklsttaxalink ctl ON t.TID = ctl.TID '.
					'WHERE (ts.taxauthid = 1) AND (ctl.clid IN('.$this->clidStr.')) ';
			}
			else{
				$sqlFamily = 'SELECT DISTINCT ts.Family AS family '.
					'FROM taxa t INNER JOIN taxstatus ts ON t.TID = ts.TID '.
					'INNER JOIN fmdyncltaxalink ctl ON t.TID = ctl.TID '.
					'WHERE (ts.taxauthid = 1) AND (ctl.dynclid = '.$this->dynClid.') ';
			}
			//echo $sqlFamily."<br>";
			$rsFamily = $this->conn->query($sqlFamily);
			while ($row = $rsFamily->fetch_object()){
				$returnArr[] = $row->family;
			}
			$rsFamily->free();

			$sqlGenus = '';
			if($this->clid){
				$sqlGenus = 'SELECT DISTINCT t.unitname1 '.
					'FROM taxa t INNER JOIN fmchklsttaxalink ctl ON t.tid = ctl.tid '.
					'WHERE (ctl.clid IN('.$this->clidStr.')) ';
			}
			else{
				$sqlGenus = 'SELECT DISTINCT t.unitname1 '.
					'FROM taxa t INNER JOIN fmdyncltaxalink ctl ON t.tid = ctl.tid '.
					'WHERE (ctl.clid = '.$this->dynClid.') ';
			}
			//echo $sqlGenus."<br>";
	 		$rsGenus = $this->conn->query($sqlGenus);
			while ($row = $rsGenus->fetch_object()){
				$returnArr[] = $row->unitname1;
			}
			$rsGenus->free();
			natcasesort($returnArr);
			$returnArr["-----------------------------------------------"] = "";
			foreach($returnArr as $value){
				echo "<option ";
				if($this->taxonFilter && $this->taxonFilter == $value){
					echo " SELECTED";
				}
				echo ">".$value."</option>\n";
			}
		}
	}

	public function getNameGameWordList(){
		$retArr = array();
		$sql = '';
		if($this->clid){
			$this->setClidStr();
			$sql = 'SELECT DISTINCT IFNULL(cl.familyoverride,ts.family) AS family, CONCAT_WS(" ",t.unitind1,t.unitname1,t.unitind2,t.unitname2) AS sciname '.
				'FROM fmchklsttaxalink cl INNER JOIN taxa t ON cl.tid = t.tid '.
				'INNER JOIN taxstatus ts ON t.tid = ts.tid '.
				'WHERE cl.clid IN('.$this->clidStr.') AND ts.taxauthid = 1 ORDER BY RAND() LIMIT 25';
		}
		elseif($this->dynClid){
			$sql = 'SELECT DISTINCT ts.family, CONCAT_WS(" ",t.unitind1,t.unitname1,t.unitind2,t.unitname2) AS sciname '.
				'FROM fmdyncltaxalink cl INNER JOIN taxa t ON cl.tid = t.tid '.
				'INNER JOIN taxstatus ts ON t.tid = ts.tid '.
				'WHERE cl.dynclid = '.$this->dynClid.' AND ts.taxauthid = 1 ORDER BY RAND() LIMIT 25';
		}
		//echo $sql.'<br/><br/>';
		if($sql){
			$rs = $this->conn->query($sql);
			$retStr = "";
			while($r = $rs->fetch_object()){
				$retArr[] = array($r->sciname,$r->family);
			}
			$rs->free();
		}
		return $retArr;
	}

	//Misc functions
	private function setClidStr(){
		$clidArr = array($this->clid);
		$sqlBase = 'SELECT clidchild FROM fmchklstchildren WHERE clid != clidchild AND clid IN(';
		$sql = $sqlBase.$this->clid.')';
		do{
			$childStr = "";
			$rs = $this->conn->query($sql);
			while($r = $rs->fetch_object()){
				$clidArr[] = $r->clidchild;
				$childStr .= ','.$r->clidchild;
			}
			$sql = $sqlBase.substr($childStr,1).')';
		}while($childStr);
		$this->clidStr = implode(',',$clidArr);
	}

	public function getSynonymArr($tid){
		$retArr = array();
		if(is_numeric($tid)){
			$sql = 'SELECT DISTINCT t.sciname FROM taxa t INNER JOIN taxstatus ts ON t.tid = ts.tid INNER JOIN taxstatus ts2 ON ts.tidaccepted = ts2.tidaccepted WHERE ts2.tid = '.$tid;
			$rs = $this->conn->query($sql);
			while($r = $rs->fetch_object()){
				$retArr[] = strtolower($r->sciname);
			}
			$rs->free();
		}
		return $retArr;
	}

	//Setters and getters
	public function getClid(){
		return $this->clid;
	}

	public function getDynClid(){
		return $this->dynClid;
	}

	public function setClid($id){
		if(is_numeric($id)){
			$this->clid = $id;
		}
	}

	public function setDynClid($id){
		if(is_numeric($id)){
			$this->dynClid = $id;
		}
	}

	public function setTaxonFilter($tValue){
		$this->taxonFilter = $tValue;
	}

	public function setShowCommon($sc){
		$this->showCommon = $sc;
	}

	public function setLang($l){
		if(is_numeric($l)) $this->langId = $l;
		else{
			$sql = 'SELECT langid FROM adminlanguages WHERE langname = "'.$this->cleanInStr($l).'" OR iso639_1 = "'.$this->cleanInStr($l).'"';
			$rs = $this->conn->query($sql);
			while($r = $rs->fetch_object()){
				$this->langId = $r->langid;
			}
			$rs->free();
		}
	}

	public function getClName(){
		$retStr = '';
		if($this->clid || $this->dynClid){
			$sql = "SELECT name ";
			if($this->clid){
				$sql .= 'FROM fmchecklists WHERE (clid = '.$this->clid.')';
			}
			else{
				$sql .= 'FROM fmdynamicchecklists WHERE (dynclid = '.$this->dynClid.')';
			}
			//echo $sql;
			$rs = $this->conn->query($sql);
			if($row = $rs->fetch_object()){
				$retStr = $row->name;
			}
			$rs->free();
		}
		return $retStr;
	}
}
?>
