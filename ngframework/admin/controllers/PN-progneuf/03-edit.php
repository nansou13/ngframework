<?php

class APN03 extends Action {

	function init() {
		ngRequire('DAO/productDAO.php');
	}

	function launch(Request $request, Response $response) {
		

		$this->has_css = true;
		$this->has_js = true;

		if (isset($_POST['deletelot'])) {
			if ($_POST['deletelot'] == '') {
				echo 'error';
				die();
			}

			$productDAO = new productDAO();
			$productDAO->deleteLot($_POST['deletelot']);
			die();
		}

		if (isset($_POST['mandat3'])) {
			if ($_POST['mandat3'] == '') {
				echo 'error';
				die();
			}

			$productDAO = new productDAO();
			$lotComp = new stdClass();

			$lotComp->nom = $_POST['nom'];
			$lotComp->type = $_POST['type'];
			$lotComp->etage = $_POST['etage'];
			$lotComp->surface = $_POST['surface'];
			$lotComp->terasse = $_POST['terasse'];
			$lotComp->prix = $_POST['prix'];
						
			
			$idLot = $productDAO->saveLot($_POST['mandat3'], $lotComp);
			
			//deplace le pdf si existe
			$folderW = str_replace('admin','programmeneuf',$_SERVER["DOCUMENT_ROOT"]);
			$filePdf = $folderW . '/data/waitlot/' . $lotComp->nom . '.pdf';
if(file_exists($filePdf)){

	//on le deplace
	//check si dossier existe
            if (!is_dir($folderW . '/data/planLot/')) {
                mkdir($folderW . '/data/planLot/');
            }
            if (!is_dir($folderW . '/data/planLot/'.$_POST['mandat3'].'/')) {
                mkdir($folderW . '/data/planLot/'.$_POST['mandat3'].'/');
            }
			$rename01 = rename($folderW . '/data/waitlot/' . $lotComp->nom . '.pdf',$folderW . '/data/planLot/'.$_POST['mandat3'].'/'.$lotComp->nom. '.pdf');

}
			header('Content-Type: text/html; charset=utf-8');
			echo $idLot;
			die();
		}

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
					case 'description_short':
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

			
			$id = $productDAO->save($_POST['mandat2'], $productComp);
			echo $id;
			die();
		}

		View::addJsFile('includes', 'jquery.ui.widget');
		View::addJsFile('includes', 'jquery.iframe-transport');
		View::addJsFile('includes', 'jquery.fileupload');
		View::addJsFile('includes', 'jquery.fileupload-process');
		View::addJsFile('includes', 'jquery.fileupload-validate');

		$param = $request->getParam();
		$mandatID = $param[0];

		$productDAO = new productDAO();
		$productinfo = $productDAO->getInfo($mandatID);

		$listeLot = $productDAO->getsLot($mandatID);
		$response->listeLot = $listeLot;
                    
                $folderW = str_replace('admin','programmeneuf',$_SERVER["DOCUMENT_ROOT"]);
                
		$urlAbs = $folderW . '/_img/neufimg/' . $mandatID . '/';
		$nbrPhoto = $this->count_files($urlAbs);

		$response->nbrPhoto = $nbrPhoto;
		
		$response->productInfo = $productinfo;

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
