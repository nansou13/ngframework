<?php

class ATR03 extends Action {

	function init() {
		ngRequire('DAO/transactionDAO.php');
		ngRequire('DAO/villeDAO.php');
	}

	function launch(Request $request, Response $response) {


		$this->has_css = true;
		$this->has_js = true;
		
		$productDAO = new productDAO();
		
		if (isset($_POST['deletepiece'])) {
			if ($_POST['deletepiece'] == '') {
				echo 'error';
				die();
			}


			if($_POST['ext'] == 1)
				$productDAO->deletepiece($_POST['deletepiece'],true);
			else
				$productDAO->deletepiece($_POST['deletepiece']);
			die();
		}
		if (isset($_POST['order'])) {
			$productDAO->savePosPiece($_POST['order']);
			die();
		}
		if (isset($_POST['order_ext'])) {
			$productDAO->savePosPiece($_POST['order_ext'], true);
			die();
		}

		if (isset($_POST['mandatAPN'])) {
			if ($_POST['mandatAPN'] == '') {
				echo 'error';
				die();
			}

			$productDAO = new productDAO();
			$APNComp = new stdClass();

			$mandatAPN = $_POST['mandatAPN'];
			$APNComp->idapn = $_POST['idapn'];
			if (isset($_POST['idapn']) && $_POST['idapn'] != '') {

				$ididid = explode("-", $_POST['idapn']);
				$APNComp->id = $ididid[1];
			}

			$APNComp->css = "top : " . $_POST['top'] . "; left:" . $_POST['left'] . ";";
			$APNComp->img = ''; //$_POST['img'];


			$idAPN = $productDAO->addAPN($mandatAPN, $APNComp);
			header('Content-Type: text/html; charset=utf-8');
			echo $idAPN;
			die();
		}
		if (isset($_POST['mandatAPNDelete'])) {
			if ($_POST['mandatAPNDelete'] == '') {
				echo 'error';
				die();
			}

			$productDAO = new productDAO();
			$idapn = explode('-', $_POST['idapn']);

			$idAPN = $productDAO->deleteAPN($idapn[1]);
			header('Content-Type: text/html; charset=utf-8');
			echo $idAPN;
			die();
		}
		if (isset($_POST['mandat3'])) {
			if ($_POST['mandat3'] == '') {
				echo 'error';
				die();
			}

			$productDAO = new productDAO();
			$pieceComp = new stdClass();

			$pieceComp->nom = addslashes($_POST['nom']);
			$pieceComp->surface = addslashes($_POST['surface']);
			$pieceComp->orientation = addslashes($_POST['orientation']);
			$pieceComp->solmur = addslashes($_POST['solmur']);
			$pieceComp->note = addslashes($_POST['note']);
			$pieceComp->pos = addslashes($_POST['pos']);;
			
			if(isset($_POST['ext']) && $_POST['ext']==1)
				$idPiece = $productDAO->savePiece($_POST['mandat3'], $pieceComp,true);
			else
				$idPiece = $productDAO->savePiece($_POST['mandat3'], $pieceComp);
			
			header('Content-Type: text/html; charset=utf-8');
			echo $idPiece;
			die();
		}

		$champsbinaire = $productDAO->getBinaire();

		$response->champsbinaire = $champsbinaire;
		$response->typebien = $productDAO->getTypeBien();
		$response->etatArray = $etatArray = array(
						'0'=>'',
						'Rénové'=>'Rénové',
						'Bon état général'=>'Bon état général',
						'Ancien'=>'Ancien',
						'Neuf'=>'Neuf',
						'Rafraîchissement à prévoir'=>'Rafraîchissement à prévoir',
						'Gros travaux'=>'Gros travaux');



		if (isset($_POST['mandat2'])) {
			if ($_POST['mandat2'] == '') {
				echo 'error';
				die();
			}

			$productDAO = new productDAO();
			$productComp = new stdClass();
			
			$arrayOccurence = $productDAO->getOccurence();
			
			header('Content-Type: text/html; charset=utf-8');
			foreach ($arrayOccurence as $valueOccurence) {
				switch($valueOccurence){
					case 'description':
					case 'extrainfo':
						$productComp->$valueOccurence = html_entity_decode($_POST[$valueOccurence]);
					break;
					case 'online':
						$productComp->$valueOccurence = isset($_POST[$valueOccurence])?1:0;
					break;
					default :
					if (isset($_POST[$valueOccurence]))
						$productComp->$valueOccurence = $_POST[$valueOccurence];
					else
						$productComp->$valueOccurence = null;
					break;
				}
				
			}


			$productComp->ascenseur = isset($_POST['ascenseur']) ? 1 : 0;



			//input binaire
			foreach ($champsbinaire as $key => $value) {
				if (isset($_POST[$key]))
					$productComp->$key = 1;
				else
					$productComp->$key = 0;
			}


			$idMandat = $productDAO->save($_POST['mandat2'], $productComp);
			echo $idMandat;
			die();
		}

		View::addJsFile('includes', 'jquery.ui.widget');
		View::addJsFile('includes', 'jquery.iframe-transport');
		View::addJsFile('includes', 'jquery.fileupload');
		View::addJsFile('includes', 'jquery.fileupload-process');
		View::addJsFile('includes', 'jquery.fileupload-validate');

		/*View::addJsFile('data', 'editable/js/bootstrap-editable.min');
		View::addCssFile('data', 'editable/css/bootstrap-editable');*/

		$villeDAO = new villeDAO();
		$response->selectContent = $villeDAO->generateselect();

		$param = $request->getParam();
		$mandatID = $param[0];




		$productDAO = new productDAO();
		$productinfo = $productDAO->getInfo($mandatID);
		$listePiece = $productDAO->getspiece($mandatID);
		
		$listePiece_ext = $productDAO->getspiece($mandatID,true);
		// var_dump($listePiece);
		$folderW = str_replace('admin','monagence',$_SERVER["DOCUMENT_ROOT"]);       
		$urlAbs = $folderW . '/_img/mandatimg/' . $mandatID . '/';
		
		$nbrPhoto = $this->count_files($urlAbs);
		
		$response->nbrPhoto = $nbrPhoto;
		$response->listePiece = $listePiece;
		$response->listePiece_ext = $listePiece_ext;
		$response->productInfo = $productinfo;

		//check si ya un plan 

		$urlPlanExist = $folderW . '/_img/mandatimg/' . $mandatID . '/plan/';
		$nbrPhotoPlan = $this->count_files($urlPlanExist);
		if ($nbrPhotoPlan == 0)
			$noPlanExist = 1;
		else
			$noPlanExist = 0;

		$response->noPlanExist = $noPlanExist;


		$APNs = $productDAO->getsAPN($mandatID);
		$css = "";
		$htmlAPN = "";
		foreach ($APNs as $apnInfo) {

			$css.="#idapn-" . $apnInfo->id . " {" . $apnInfo->css . "} ";
			$htmlAPN.='<div class="APNicon" id="idapn-' . $apnInfo->id . '"></div>';
		}

		$response->css = $css;
		$response->htmlAPN = $htmlAPN;

		$this->render($this->controllerName, $this->methodeName);
		$this->printOut();
	}

	public function count_files($dir) {
		$num = 0;
		if (is_dir($dir)) {
			$dir_handle = opendir($dir);
			while ($entry = readdir($dir_handle))
				if (is_file($dir . '/' . $entry))
					$num++;
			closedir($dir_handle);
		}
		return $num;
	}

}

?>
