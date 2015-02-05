<?php

class APN96 extends Action {

	function init() {
		ngRequire('DAO/productDAO.php');
	}

	function launch(Request $request, Response $response) {
		$this->has_css = true;
		$this->has_js = true;
		
		//View::addJsFile('includes','typeahead.min');
		//View::addJsFile('includes','jquery.dataTables.min');
		$productDAO = new productDAO();
		
		if(isset($_POST['mandatAPN'])){
			if($_POST['mandatAPN']==''){
				echo 'error'; die();
			}
				
			
			$APNComp = new stdClass();
			
			$mandatAPN = $_POST['mandatAPN'];
			$APNComp->idapn = $_POST['idapn'];
			$APNComp->css = "top : ".$_POST['top']."; left:".$_POST['left'].";";
			$APNComp->img = 'test';//$_POST['img'];

			
			$idAPN = $productDAO->addAPN($mandatAPN,$APNComp);
			header('Content-Type: text/html; charset=utf-8');
			echo $mandatAPN.'--'. $idAPN; die();
		}
		
		
		//recupere position de tous les apn
		$APNs = $productDAO->getsAPN('TOTO');
		$css="";
		$htmlAPN="";
		foreach($APNs as $apnInfo){
			
			$css.="#".$apnInfo->idapn." {".$apnInfo->css."} ";
			$htmlAPN.='<div class="APNicon" id="'.$apnInfo->idapn.'"></div>';

		}
		
		$response->css = $css;
		$response->htmlAPN = $htmlAPN;
		
		$this->render($this->controllerName, $this->methodeName);
		$this->printOut();
	}

}

?>
