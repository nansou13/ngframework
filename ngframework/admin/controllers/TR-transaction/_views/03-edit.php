<?php
class ATR03 extends Action
{
    function init()
    {
		ngRequire('DAO/productDAO.php');
		ngRequire('DAO/villeDAO.php');
    }
	
    function launch(Request $request, Response $response)
    {
		
		
        $this->has_css = true;
		$this->has_js = true;
		View::addJsFile('includes','jquery.ui.widget');
		View::addJsFile('includes','jquery.iframe-transport');
		View::addJsFile('includes','jquery.fileupload');
		View::addJsFile('includes','jquery.fileupload-process');
		View::addJsFile('includes','jquery.fileupload-validate');
		
		$villeDAO = new villeDAO();
		$response->selectContent = $villeDAO->generateselect();
		
		$param = $request->getParam();
		$mandatID = $param[0];
		
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
		
		
		
		if(isset($_POST['mandat2'])){
			if($_POST['mandat2']==''){
				echo 'error'; die();
			}
			/*	
			$productDAO = new productDAO();
			$productComp = new stdClass();
			
			$productComp->title = $_POST['titre'];
			$productComp->description = $_POST['description'];
			$productComp->superficie = $_POST['superficie'];
			$productComp->nbrepiece = $_POST['nbrepiece'];
			$productComp->urltext = $_POST['url'];
			$productComp->prix = $_POST['prix'];
                        $productComp->type = $_POST['type'];
			$productComp->villeID = $_POST['localisation'];
			*/
                        
                        $productDAO = new productDAO();
			$productComp = new stdClass();
			
			
			
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
		
		
		$productDAO = new productDAO();
		$productinfo = $productDAO->getInfo($mandatID);

		$response->productInfo = $productinfo;
		
        $this->render($this->controllerName, $this->methodeName);
        $this->printOut();
    }
}
?>
