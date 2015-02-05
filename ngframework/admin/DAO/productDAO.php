<?php

class productDAO extends DAO {

	const table = "maprogneuf";

	function __construct() {
		
	}

	function getInfo($id, $selectFields = "*") {
		if (empty($id)) {
			throw new Exception('Parameter is empty');
		}
		$qry = "SELECT " . $selectFields . " FROM " . self::table . " WHERE 1 = 1 AND id='" . $id . "'";
		return $this->fetch($qry, 'object', true);
	}

	function gets($offset = 0, $limit = 10, $selectFields = "*", $type = "object", $justonline=false) {
		$qry = "SELECT * FROM " . self::table . " WHERE 1=1"; //LIMIT ".$offset.",".$limit;
		if($justonline){
			$qry.= " AND online=1";
		}
		//echo $qry;
		return $this->fetch($qry, $type);
	}

	function delete($ID) {
		if (empty($ID)) {
			throw new Exception('Parameter 1 ($ID) is empty');
		}
		$qry = "DELETE FROM " . self::table . " WHERE id=" . $ID;
		return $this->fetch($qry, 'update');
	}

	function getsLot($ID) {
		$qry = "SELECT * FROM mapnlot WHERE 1=1 AND mapnlot.prog_id='" . $ID . "'"; //LIMIT ".$offset.",".$limit;
		return $this->fetch($qry, 'object');
	}

	function updatepospiece($arrayComp, $ext = false) {
		$i = 0;
                $extTable = ($ext?'ext':'');
		foreach ($arrayComp as $value) {
			$i++;
			$qry = 'UPDATE mapiece'.$extTable.' set';
			$qry.= ' pos = "' . $i;
			$qry.= ' where id = "' . $value->id . '"';
			$idMoment = $this->fetch($qry, 'update');
		}
	}

	function deleteLot($id) {
		if (empty($id)) {
			throw new Exception('Parameter 1 ($id) is empty');
		}
                
		$qry = "DELETE FROM mapnlot WHERE id=" . $id;
		//echo $qry;
		return $this->fetch($qry, 'update');
	}

	function saveLot($mandatID, $comp) {

		$qry = 'INSERT INTO mapnlot (prog_id, nom, type, etage, surface, terasse, prix) VALUES(
						\'' . $mandatID . '\',
						\'' . utf8_decode($comp->nom) . '\',
						\'' . utf8_decode($comp->type) . '\',
						\'' . utf8_decode($comp->etage) . '\',
						\'' . utf8_decode($comp->surface) . '\',
						\'' . utf8_decode($comp->terasse) . '\',
						\'' . utf8_decode($comp->prix) . '\'
					)';
		//echo $qry;
		$idMoment = $this->fetch($qry, 'insert');
		return $idMoment;
	}

	function save($mandatID, $comp = null) {
		if (empty($mandatID)) {
			throw new Exception('Parameter 1 ($mandatID) is empty');
		}
		$date = date("Y-m-d H:i:s");

		if (isset($comp)) {
			//update
			
			$arrayOccurence = $this->getOccurence();

			$qry = 'UPDATE ' . self::table . ' set';

			foreach ($arrayOccurence as $valueOccurence) {
				if (isset($comp->$valueOccurence)){
					$qry.= ' ' . $valueOccurence . ' = "' . addslashes($comp->$valueOccurence) . '",';

				}
			}

			$urlText = "bien de monagence";
			//les accents
			$titleMoment = isset($comp->nom) ? strtolower($comp->nom) : $urlText;
			$chaine = trim($titleMoment);
			$chaine = strtr($chaine, "ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ", "aaaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuuuynn");
			//les caracètres spéciaux (aures que lettres et chiffres en fait)
			$chaine = preg_replace('/([^.a-z0-9]+)/i', '-', $chaine);
			$urlText = $chaine;
			
			$qry.=' urltext="'.$urlText.'"';

			mysql_query('SET NAMES UTF8');
			//$qry = mb_substr($qry, 0, -1,'UTF-8');
			$qry.=' where id = "' . $mandatID . '"';
			echo $qry;
			$idMoment = $this->fetch($qry, 'update');
		} else {
			$qry = 'INSERT INTO ' . self::table . ' (nom) VALUES(
						\'' . $mandatID . '\'
					)';

			$idMoment = $this->fetch($qry, 'insert');
		}
		return $idMoment;
	}

	function generatejson() {
		$list = $this->gets(0, 0, "mandat", "array");
		if (isset($list) && count($list) > 0) {
			foreach ($list as $value) {
				$tmp[] = $value[0];
			}
			$fp = fopen(dirname($_SERVER['SCRIPT_FILENAME']) . '/data/mandat.json', 'w+');
			fwrite($fp, json_encode($tmp));
			fclose($fp);
		}
	}

	function search($mandat = null, $superficiemin = null, $superficiemax = null, $localisation = null, $nbrepiecemin = null, $nbrepiecemax = null,$prixmin = null, $prixmax = null, $type=null) {
		$qry = "SELECT * FROM " . self::table . ",maville WHERE 1=1 AND maville.id = mabien.villeID";
		if (isset($mandat) && $mandat != '') {
			$qry .= " AND mandat = '" . $mandat . "'";
		}
		if (isset($localisation) && $localisation != '') {
			$qry .= " AND ville like '%" . $localisation . "%'";
		}
		if (isset($type) && $type != '') {
			$qry .= " AND type = '" . $type . "'";
		}
		if (isset($superficiemin) && $superficiemin != '') {
			//check si ya aussi max
			if (isset($superficiemax) && $superficiemax != '') {
				//between
				$qry .= " AND superficie BETWEEN " . $superficiemin . " AND " . $superficiemax;
			} else {
				// superieur � 
				$qry .= " AND superficie > " . $superficiemin;
			}
		} else {
			if (isset($superficiemax) && $superficiemax != '') {
				// inferieur �
				$qry .= " AND superficie < " . $superficiemax;
			}
		}
		if (isset($prixmin) && $prixmin != '') {
			//check si ya aussi max
			if (isset($prixmax) && $prixmax != '') {
				//between
				$qry .= " AND prix BETWEEN " . $prixmin . " AND " . $prixmax;
			} else {
				// superieur � 
				$qry .= " AND prix > " . $prixmin;
			}
		} else {
			if (isset($prixmax) && $prixmax != '') {
				// inferieur �
				$qry .= " AND prix < " . $prixmax;
			}
		}

		if (isset($nbrepiecemin) && $nbrepiecemin != '') {
			//check si ya aussi max
			if (isset($nbrepiecemax) && $nbrepiecemax != '') {
				//between
				$qry .= " AND nbrepiece BETWEEN " . $nbrepiecemin . " AND " . $nbrepiecemax;
			} else {
				// superieur � 
				$qry .= " AND nbrepiece > " . $nbrepiecemin;
			}
		} else {
			if (isset($nbrepiecemax) && $nbrepiecemax != '') {
				// inferieur �
				$qry .= " AND nbrepiece < " . $nbrepiecemax;
			}
		}


		$qry .= " order by created_date DESC "; //LIMIT ".$offset.",".$limit;
		//echo 'search - '.$qry;

		return $this->fetch($qry, "object");
	}

	function getAPN($mandat, $idapn) {
		if (isset($idapn) && $idapn != '') {
			$idid = explode('-', $idapn);
			$qry = "SELECT * FROM maimgapn WHERE id = '" . $idid[1] . "' AND mandat=" . $mandat;
			return $this->fetch($qry, 'object', true);
		} else {
			return false;
		}
	}

	function getsAPN($mandat) {
		$idMandat = $this->getInfo($mandat, "mabien.id");
		$qry = "SELECT * FROM maimgapn WHERE mandat=" . $idMandat->id;

		return $this->fetch($qry, 'object');
	}

	function deleteAPN($ID) {
		$qry = "DELETE FROM maimgapn WHERE id = " . $ID;
		return $this->fetch($qry, 'update');
	}

	function addAPN($mandatID, $comp) {
		$idMandat = $this->getInfo($mandatID, "mabien.id");

		$exist = $this->getAPN($idMandat->id, $comp->idapn);

		if ($exist) {
			//update
			$qry = 'UPDATE maimgapn set';
			$qry.= ' css = "' . $comp->css . '"';
			$qry.= ' , idapn = "' . $comp->idapn . '"';
			$qry.= ' where id = "' . $comp->id . '"';
			$qry.= ' and mandat = ' . $idMandat->id . '';
			$idMoment = $this->fetch($qry, 'update');
		} else {
			$qry = 'INSERT INTO maimgapn (mandat, idapn, css, img) VALUES(
						\'' . $idMandat->id . '\',
						\'' . $comp->idapn . '\',
						\'' . $comp->css . '\',
						\'' . $comp->img . '\'
					)';

			$idMoment = $this->fetch($qry, 'insert');
		}
		return $idMoment;
	}

	function saveBlog($title, $content) {
		$date = date("Y-m-d H:i:s");
		$qry = 'INSERT INTO mablog (title, content) VALUES(
						\'' . addslashes($title) . '\',
						\'' . addslashes($content) . '\'
					
					)';

		$idMoment = $this->fetch($qry, 'insert');

		return $idMoment;
	}

	function getBlog($ID) {

		$qry = "SELECT * FROM mablog WHERE id = " . $ID ;
		return $this->fetch($qry, 'object', true);
	}
	function getsBlog() {
		$qry = "SELECT * FROM mablog";
		return $this->fetch($qry, 'object');
	}
	
	function getOccurence(){
		$arrayOccurence = array(
				"identifiant",
				"nom",
				"prix",
				"ville",
				"quartier",
				"date_livraison",
				"description",
				"description_short",
				"promoteur",
				"nbre_lot",
				"adresse",
				"online"
				
			);		
		return $arrayOccurence;
	}
}

?>