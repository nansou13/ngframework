<?php

class ATR12 extends Action {

	function init() {
		ngRequire('DAO/transactionDAO.php');
	}

	function launch(Request $request, Response $response) {
		$this->has_css = true;
		$this->has_js = true;
		
		View::addJsFile('includes','typeahead.min');
		//View::addJsFile('includes','jquery.dataTables.min');
		
		
		$productDAO = new productDAO();
		$demandeList = $productDAO->getsDemande();

		$response->demandeList = $demandeList;

		$this->render($this->controllerName, $this->methodeName);
		$this->printOut();
	}

}

?>
