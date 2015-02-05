<?php

class ABL01 extends Action {

	function init() {
		ngRequire('DAO/blogDAO.php');
	}

	function launch(Request $request, Response $response) {
		$this->has_css = true;
		$this->has_js = false;
		
		View::addJsFile('includes','typeahead.min');
		//View::addJsFile('includes','jquery.dataTables.min');
		
		
		$blogDAO = new blogDAO();
		$blogList = $blogDAO->gets();

		$response->blogList = $blogList;

		$this->render($this->controllerName, $this->methodeName);
		$this->printOut();
	}

}

?>
