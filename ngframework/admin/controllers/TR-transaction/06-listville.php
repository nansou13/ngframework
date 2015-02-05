<?php

class ATR06 extends Action {

	function init() {
		ngRequire('DAO/villeDAO.php');
	}

	function launch(Request $request, Response $response) {
		$this->has_css = true;
		//$this->has_js = true;

		$productDAO = new villeDAO();
		
		echo $productDAO->generatejson();
		
		$productList = $productDAO->gets();

		$response->productList = $productList;

		$this->render($this->controllerName, $this->methodeName);
		$this->printOut();
	}

}

?>
