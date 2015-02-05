<?php
class ATR02 extends Action
{
    function init()
    {
		ngRequire('DAO/transactionDAO.php');
		ngRequire('DAO/villeDAO.php');
    }
	
    function launch(Request $request, Response $response)
    {
		
		
		if(isset($_POST['mandat3'])){
			if($_POST['mandat3']==''){
				echo 'error'; die();
			}
				
			$productDAO = new productDAO();
			$pieceComp = new stdClass();
			
			$pieceComp->nom = $_POST['nom'];
			$pieceComp->surface = $_POST['surface'];
			$pieceComp->orientation = $_POST['orientation'];
			$pieceComp->solmur = $_POST['solmur'];
			$pieceComp->note = $_POST['note'];
			$pieceComp->pos = 0;
			
			$idPiece = $productDAO->savePiece($_POST['mandat3'],$pieceComp);
			header('Content-Type: text/html; charset=utf-8');
			echo $idPiece.'--'.  utf8_encode($pieceComp->nom); die();
		}
		
		
        $this->has_css = true;
		$this->has_js = true;
		View::addJsFile('includes','jquery.ui.widget');
		View::addJsFile('includes','jquery.iframe-transport');
		View::addJsFile('includes','jquery.fileupload');
		View::addJsFile('includes','jquery.fileupload-process');
		View::addJsFile('includes','jquery.fileupload-validate');
		
		$villeDAO = new villeDAO();
		$response->selectContent = $villeDAO->generateselect();
		
		$champsbinaire = array(
				'wc_ind'=>'Wc ind&eacute;pendant',
				'terrain'=>'Terrain',
				'balcon'=>'Balcon',
				'loggia'=>'Loggia',
				'cave'=>'Cave',
				'stationnement'=>'Stationnement',
				'parking'=>'Parking',
				'box'=>'Box',
				'residence_fermee'=>'r&eacute;sidence ferm&eacute;e',
				'alarme'=>'Alarme',
				'digicode'=>'Digicode',
				'interphone'=>'Interphone',
				'gardien'=>'Gardien',
				'piscine'=>'Piscine',
				'chauffage'=>'Chauffage',
				'four'=>'Four',
				'micro_onde'=>'Micro onde',
				'plaque_cuisson'=>'Plaque de cuisson',
				'hotte'=>'Hotte aspirante',
				'frigo'=>'r&eacute;frig&eacute;rateur',
				'lave_vaisselle'=>'lave-vaiselle',
				'lave_linge'=>'lave linge'
				);
		
		$response->champsbinaire = $champsbinaire;
		
		if(isset($_POST['mandat'])){
			if($_POST['mandat']==''){
				echo 'error'; die();
			}
				
			$productDAO = new productDAO();
			$idMandat = $productDAO->save($_POST['mandat']);
			echo $idMandat; die();
		}
		if(isset($_POST['mandat2'])){
			if($_POST['mandat2']==''){
				echo 'error'; die();
			}
				
			$productDAO = new productDAO();
			$productComp = new stdClass();
			/*
			$productComp->title = $_POST['titre'];
			$productComp->description = $_POST['description'];
			$productComp->superficie = $_POST['superficie'];
			$productComp->superficie_carrez = $_POST['superficie_carrez'];
			$productComp->nbrepiece = $_POST['nbrepiece'];
			$productComp->urltext = $_POST['url'];
			$productComp->prix = $_POST['prix'];
			$productComp->villeID = $_POST['localisation'];
			$productComp->type = $_POST['type'];
			$productComp->etage = $_POST['etage'];
			$productComp->etage_max = $_POST['etage_max'];
			$productComp->etat_bien = $_POST['etat_bien'];
			$productComp->annee_construction = $_POST['annee_construction'];
			$productComp->type_construction = $_POST['type_construction'];
			$productComp->nbre_niveau = $_POST['nbre_niveau'];
			$productComp->nbre_chambre = $_POST['nbre_chambre'];
			$productComp->nbre_sdb = $_POST['nbre_sdb'];
			$productComp->nbre_se = $_POST['nbre_se'];
			*/
			
			
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
				"revenus_loc"
			);
			
			foreach ($arrayOccurence as $valueOccurence) {
				if(isset($_POST[$valueOccurence]))
					$productComp->$valueOccurence = $_POST[$valueOccurence];
				else
					$productComp->$valueOccurence = null;
			}
			
			
			$productComp->ascenseur = isset($_POST['ascenseur'])?1:0;
			
		
		
			//input binaire
			foreach($champsbinaire as $key=>$value){
				if(isset($_POST[$key]))
					$productComp->$key = 1;
				else
					$productComp->$key = 0;
			}
			
			
			
			$idMandat = $productDAO->save($_POST['mandat2'],$productComp);
			echo $idMandat; die();
		}
		
		
		
		
        $this->render($this->controllerName, $this->methodeName);
        $this->printOut();
    }
}
?>
