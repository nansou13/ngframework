<?php
class ATR92 extends Action {
	function init() {
		ngRequire('DAO/transactionDAO.php');
	}

	function launch(Request $request, Response $response) {
		$this->has_css = true;
		$this->has_js = false;
		
		$param = $request->getParam();
		$pieceID = $param[0];
		$ext = (int)$param[1];
	
		$productDAO = new productDAO();

		if(isset($_POST['saveeditpiece'])){
header('Content-Type: text/html; charset=utf-8');

$arrayInfopiece = array(
'nom'=>$_POST['nom'],
'surface'=>$_POST['surface'],
'solmur'=>$_POST['solmur'],
'orientation'=>$_POST['orientation'],
'note'=>$_POST['note']
);

			if($_POST['ext'] == 1){
			$productDAO->updatepiece($arrayInfopiece,$_POST['saveeditpiece'],true);
			
		}else{
			$productDAO->updatepiece($arrayInfopiece,$_POST['saveeditpiece']);
		}
			
			die();
		}


		if($ext == 1){
			$infoPiece = $productDAO->getpiece($pieceID,true);
			$idinput = "idp-".$pieceID.'-ext';
		}else{
			$infoPiece = $productDAO->getpiece($pieceID);
			$idinput = "idp-".$pieceID;
		}

$response->pieceInfo = $infoPiece;
$response->idinput = $idinput;

		$this->render($this->controllerName, $this->methodeName);
		$this->printOut(true);
	}

}
?>
