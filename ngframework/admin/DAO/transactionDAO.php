<?php

class productDAO extends DAO {

	const table = "mabien";

	function __construct() {
		
	}

	function getInfo($id, $selectFields = "*") {
		if (empty($id)) {
			throw new Exception('Parameter is empty');
		}
		$qry = "SELECT " . $selectFields . " FROM " . self::table . " WHERE 1 = 1 AND mandat='" . $id . "'";
		return $this->fetch($qry, 'object', true);
	}

	function gets($offset = 0, $limit = 10, $selectFields = "mabien.id, mandat, title, description, superficie, nbrepiece, urltext, prix, villeID,ville, cp, created_date, updated_date", $type = "object", $justonline=false) {
		$qry = "SELECT * FROM " . self::table . ",maville WHERE 1=1 AND maville.id = mabien.villeID"; //LIMIT ".$offset.",".$limit;
		if($justonline){
			$qry.= " AND online=1";
		}
		$qry.= " order by created_date DESC ";
		//echo $qry;
		return $this->fetch($qry, $type);
	}

	function delete($mandatID) {
		if (empty($mandatID)) {
			throw new Exception('Parameter 1 ($mandatID) is empty');
		}
		$qry = "DELETE FROM " . self::table . " WHERE id=" . $mandatID;
		return $this->fetch($qry, 'update');
	}

	function getspiece($mandatID, $ext = false) {
                $extTable = ($ext?'ext':'');
		$idMandat = $this->getInfo($mandatID, "mabien.id");
		$qry = "SELECT id,bien_id, nom, surface, orientation, solmur, note, pos FROM mapiece".$extTable." WHERE 1=1 AND mapiece".$extTable.".bien_id='" . $idMandat->id . "' order by pos ASC "; //LIMIT ".$offset.",".$limit;
		
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
	function updatepiece($arrayComp,$id, $ext = false) {
        $extTable = ($ext?'ext':'');

			$qry = 'UPDATE mapiece'.$extTable.' set';
			$qry.= ' nom = "' . $arrayComp['nom'].'",';
			$qry.= ' surface = "' . $arrayComp['surface'].'",';
			$qry.= ' solmur = "' . $arrayComp['solmur'].'",';
			$qry.= ' orientation = "' . $arrayComp['orientation'].'",';
			$qry.= ' note = "' . $arrayComp['note'].'"';
			$qry.= ' where id = "' . $id . '"';
mysql_query('SET NAMES UTF8');
	
$idMoment = $this->fetch($qry, 'update');
		
	}
	function getpiece($pieceID, $ext = false) {
        $extTable = ($ext?'ext':'');
		$qry = "SELECT id, nom, surface, orientation, solmur, note, pos FROM mapiece".$extTable." WHERE id=".$pieceID;

		return $this->fetch($qry, 'object', true);
	}
	

	function deletepiece($id, $ext = false) {
		if (empty($id)) {
			throw new Exception('Parameter 1 ($id) is empty');
		}
                $extTable = ($ext?'ext':'');
		$qry = "DELETE FROM mapiece".$extTable." WHERE id=" . $id;
		//echo $qry;
		return $this->fetch($qry, 'update');
	}

	function savePiece($mandatID, $comp, $ext = false) {
		$idMandat = $this->getInfo($mandatID, "mabien.id");
                $extTable = ($ext?'ext':'');
		$qry = 'INSERT INTO mapiece'.$extTable.' (bien_id, nom, surface, orientation, solmur, note, pos) VALUES(
						\'' . $idMandat->id . '\',
						\'' . utf8_decode($comp->nom) . '\',
						\'' . $comp->surface . '\',
						\'' . utf8_decode($comp->orientation) . '\',
						\'' . utf8_decode($comp->solmur) . '\',
						\'' . utf8_decode($comp->note) . '\',
						\'' . $comp->pos . '\'
					)';

		$idMoment = $this->fetch($qry, 'insert');
		return $idMoment;
	}

	function savePosPiece($order, $ext=false){
		$arrayOrder = explode(',', $order);
        $nb = count($arrayOrder);
		$extTable = ($ext?'ext':'');

        $i = 1;

        foreach ($arrayOrder as $content) {
			$IDCONTENT = explode('-',$content);
            $qry = 'UPDATE mapiece'.$extTable.' set 
					pos = ' . $i . ' where id = ' . $IDCONTENT[1];
            $i++;

            echo $qry . '<br/>';

            $this->fetch($qry, 'update');
        }

	
	}

	function save($mandatID, $comp = null) {
		if (empty($mandatID)) {
			throw new Exception('Parameter 1 ($mandatID) is empty');
		}
		$date = date("Y-m-d H:i:s");

		if (isset($comp)) {
			//update
			$champsbinaire = $this->getBinaire();
			$arrayOccurence = $this->getOccurence();



			$qry = 'UPDATE ' . self::table . ' set';

			foreach ($arrayOccurence as $valueOccurence) {
				if (isset($comp->$valueOccurence)){
					$qry.= ' ' . $valueOccurence . ' = "' . addslashes($comp->$valueOccurence) . '",';

				}
			}

			foreach ($champsbinaire as $keyBinaire => $valueBinaire) {
				if (isset($comp->$keyBinaire))
					$qry.= ' ' . $keyBinaire . ' = "' . $comp->$keyBinaire . '",';
			}

			$urlText = "bien de monagence";
			//les accents
			$titleMoment = isset($comp->title) ? strtolower($comp->title) : $urlText;
			$chaine = trim($titleMoment);
			$chaine = strtr($chaine, "ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ", "aaaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuuuynn");
			//les caracètres spéciaux (aures que lettres et chiffres en fait)
			$chaine = preg_replace('/([^.a-z0-9]+)/i', '-', $chaine);
			$urlText = $chaine;
			
			$qry.=' urltext="'.$urlText.'",';

			mysql_query('SET NAMES UTF8');
			

			$qry.= ' updated_date = "' . $date . '"'
					. ' where mandat = "' . $mandatID . '"';
			echo $qry;
			$idMoment = $this->fetch($qry, 'update');
		} else {
			$qry = 'INSERT INTO ' . self::table . ' (mandat, created_date) VALUES(
						\'' . $mandatID . '\',
						\'' . $date . '\'
					)';

			$idMoment = $this->fetch($qry, 'insert');
		}
		$this->generatejson();

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
	
	function saveOrderImg($ID, $list){
			$qry = 'UPDATE ' . self::table . ' set';
			$qry.= ' orderimg = "' . $list . '"';
			$qry.= ' where mandat = "' . $ID . '"';
			$idMoment = $this->fetch($qry, 'update');

	}

	function saveBlog($title, $content, $categ=1) {
		$date = date("Y-m-d H:i:s");
		$qry = 'INSERT INTO mablog (title, content, date, categorie) VALUES(
						\'' . addslashes($title) . '\',
						\'' . addslashes($content) . '\',
						\'' . $date . '\',
						\'' . addslashes($categ) . '\'
					
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
	function getBlogCategories() {
		$qry = "SELECT * FROM mablogcateg";
		return $this->fetch($qry, 'object');
	}
	
	function getBinaire(){
		$champsbinaire = array(
			'wc_ind' => 'Wc ind&eacute;pendant',
			'terrain' => 'Terrain',
			'balcon' => 'Balcon',
			'loggia' => 'Loggia',
			'cave' => 'Cave',
			'stationnement' => 'Stationnement',
			'parking' => 'Parking',
			'box' => 'Box',
			'residence_fermee' => 'r&eacute;sidence ferm&eacute;e',
			'alarme' => 'Alarme',
			'digicode' => 'Digicode',
			'interphone' => 'Interphone',
			'gardien' => 'Gardien',
			'piscine' => 'Piscine',
			'chauffage' => 'Chauffage',
			'four' => 'Four',
			'micro_onde' => 'Micro onde',
			'plaque_cuisson' => 'Plaque de cuisson',
			'hotte' => 'Hotte aspirante',
			'frigo' => 'r&eacute;frig&eacute;rateur',
			'lave_vaisselle' => 'lave-vaiselle',
			'lave_linge' => 'lave linge'
		);
		return $champsbinaire;
	}
	
	function getOccurence(){
		$arrayOccurence = array(
				"title",
				"description",
				"urltext",
				"superficie",
				"superficie_carrez",
				"nbrepiece",
				"prix",
				"villeID",
				"type",
				"etage",
				"etage_max",
				"ascenseur",
				"etat_bien",
				"annee_construction",
				"type_construction",
				"nbre_niveau",
				"nbre_chambre",
				"nbre_sdb",
				"nbre_se",
				"charge_copro",
				"eau",
				"gaz",
				"edf",
				"t_fonciere",
				"t_habitation",
				"dpe_nrj",
				"dpe_climat",
				"extrainfo",
				"adresse",
				"propnom",
				"propadresse",
				"propphone",
				"revenus_loc",
				"online"
				
			);		
		return $arrayOccurence;
	}

	function getTypeBien(){
		$arrayTypeBien = array(
				"Appartement",
				"Maison",
				"Terrain",
				"Loft",
				"Garage",
				"Autre"
			);		
		return $arrayTypeBien;
	}
	
	function getOccurenceDemande(){
		$arrayOccurenceDemande = array(
				"mandat",
				"titre",
				"localisation_mini",
				"localisation_maxi",
				"budget",
				"detail"
			);		
		return $arrayOccurenceDemande;
	}
	function getBinaireDemande(){
		$arrayBinaireDemande = array(
				"type_investissement",
				"bien_recherche",
				"exterieur",
				"commodite",
				"autre"

				
			);		
		return $arrayBinaireDemande;
	}
	function getBinaireDemandeDetail(){
		$arrayOccurenceDemandeDetail = array(
				"type_investissement" => array(
					1 => 'Investissement',
					2 => 'résidence secondaire',
					3 => 'résidence principale'
				),
				"bien_recherche" => array(
					1 => 'Terrain',
					2 => 'Villa',
					3 => 'Appart.',
					4 => 'Garage',
					5 => 'Parking',
					6 => 'Cave',
					7 => 'Ascenseur',
					8 => 'Vue mer'
				),
				"exterieur" => array(
					1 => 'Balcon',
					2 => 'Terrasse',
					3 => 'Jardin',
					4 => 'Piscine'
				),

				"commodite" => array(
					1 => 'Ecole',
					2 => 'Bus',
					3 => 'Tram',
					4 => 'Metro',
					5 => 'Autoroute',
					6 => 'Commerces'
				),
				"autre" => array(
					1 => 'Travaux',
					2 => 'Neuf',
					3 => 'Rénové',
					4 => 'Bon état général'
				)	
			);		
		return $arrayOccurenceDemandeDetail;
	}	

	function getsDemande() {
		$qry = "SELECT * FROM demande"; //LIMIT ".$offset.",".$limit;
		$qry.= " order by id DESC ";
		//echo $qry;
		return $this->fetch($qry, 'object');
	}

	function saveDemande($ID, $comp = null) {
		if (empty($ID)) {
			throw new Exception('Parameter 1 ($ID) is empty');
		}
		$date = date("Y-m-d H:i:s");

		if (isset($comp)) {
			//update
			$arrayOccurence = $this->getOccurenceDemande();
			$champsbinaire = $this->getBinaireDemandeDetail();

			$qry = 'UPDATE demande set';

			foreach ($arrayOccurence as $valueOccurence) {
				if (isset($comp->$valueOccurence)){
					$qry.= ' ' . $valueOccurence . ' = "' . addslashes($comp->$valueOccurence) . '",';

				}
			}

			foreach ($champsbinaire as $keyBinaire => $valueBinaire) {
				if (isset($comp->$keyBinaire))
					$qry.= ' ' . $keyBinaire . ' = "' . $comp->$keyBinaire . '",';
			}

			$urlText = "Demande client";
			//les accents
			$titleMoment = isset($comp->titre) ? strtolower($comp->titre) : $urlText;
			$chaine = trim($titleMoment);
			$chaine = strtr($chaine, "ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ", "aaaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuuuynn");
			//les caracètres spéciaux (aures que lettres et chiffres en fait)
			$chaine = preg_replace('/([^.a-z0-9]+)/i', '-', $chaine);
			$urlText = $chaine;
			
			$qry.=' urltext="'.$urlText.'",';

			mysql_query('SET NAMES UTF8');
			

			$qry.= ' updated_date = "' . $date . '"'
					. ' where id = "' . $ID . '"';
			echo $qry;
			$idMoment = $this->fetch($qry, 'update');
		} else {
			$qry = 'INSERT INTO demande (mandat, updated_date) VALUES(
						\'' . $ID . '\',
						\'' . $date . '\'
					)';

			$idMoment = $this->fetch($qry, 'insert');
		}

		return $idMoment;
	}
	function getInfoDemande($id, $selectFields = "*") {
		if (empty($id)) {
			throw new Exception('Parameter is empty');
		}
		$qry = "SELECT " . $selectFields . " FROM demande WHERE 1 = 1 AND id='" . $id . "'";
		return $this->fetch($qry, 'object', true);
	}

	function deleteDemande($mandatID) {
		if (empty($mandatID)) {
			throw new Exception('Parameter 1 ($mandatID) is empty');
		}
		$qry = "DELETE FROM demande WHERE id=" . $mandatID;
		return $this->fetch($qry, 'update');
	}

}

?>