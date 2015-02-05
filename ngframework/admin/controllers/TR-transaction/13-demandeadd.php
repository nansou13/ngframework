<?php

class ATR13 extends Action {

	function init() {
		ngRequire('DAO/transactionDAO.php');
	}

	function launch(Request $request, Response $response) {
		$this->has_css = true;
		$this->has_js = true;
		
		View::addJsFile('includes','typeahead.min');
		//View::addJsFile('includes','jquery.dataTables.min');
		
		
		$productDAO = new productDAO();
		$optionparent = $productDAO->getBinaireDemande();
		$options = $productDAO->getBinaireDemandeDetail();


		if (isset($_POST['mandat2'])) {
			if ($_POST['mandat2'] == '') {
				echo 'error';
				die();
			}

			$productComp = new stdClass();
			
			$arrayOccurence = $productDAO->getOccurenceDemande();
			
			header('Content-Type: text/html; charset=utf-8');
			foreach ($arrayOccurence as $valueOccurence) {
				switch($valueOccurence){
					case 'localisation_max':
					case 'detail':
						$productComp->$valueOccurence = html_entity_decode($_POST[$valueOccurence]);
					break;
					default :
					if (isset($_POST[$valueOccurence]))
						$productComp->$valueOccurence = $_POST[$valueOccurence];
					else
						$productComp->$valueOccurence = null;
					break;
				}
				
			}
		
			foreach($options as $optKey => $valueKey){
				$arrayC = array();
				foreach($valueKey as $keyC => $valueC){
					$valueOccurenceC = $optKey.'_'.$keyC;
					if(isset($_POST[$valueOccurenceC])){
						$arrayC[] = $keyC;
					}
				}
				$productComp->$optKey = implode(',',$arrayC);
				
			}


			$idMandat = $productDAO->saveDemande($_POST['mandat2'], $productComp);
			die();
		}

		$param = $request->getParam();
		$mandatID = $param[0];

		$productinfo = $productDAO->getInfoDemande($mandatID);
		

		//get binairy informations
	$arrayOptionForm = array();
		foreach($options as $keyOptions => $valueOptions){
			$infoOption = $productinfo->$keyOptions;
			$arrayInfoOption = explode(',',$infoOption);
			foreach($arrayInfoOption as $valueOpt){
				$tt = $keyOptions.'_'.$valueOpt;
				$arrayOptionForm[$tt] = 1;
			}
		}
		
		$response->arrayOptionForm = $arrayOptionForm;

		$response->productInfo = $productinfo;

		$response->optionparent = $optionparent;
		$response->options = $options;

		$this->render($this->controllerName, $this->methodeName);
		$this->printOut();
	}

}

?>
