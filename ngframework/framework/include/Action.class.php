<?php

abstract class Action {

	protected $_GateKeeper;
	protected $contollerName;
	protected $methodeName;
	protected $has_css = false;
	protected $has_js = false;

	abstract public function launch(Request $request, Response $response);

	public function init() {
		
	}

	public function __construct($GateKeeper) {
		$this->_GateKeeper = $GateKeeper;

		$this->controllerName = $this->_GateKeeper->getRequest()->getParam('controller');
		$this->methodeName = $this->_GateKeeper->getRequest()->getParam('methode');
	}

	public function render($controller, $methode) {
		//recupere le CSS de la page
		$methode = basename($methode, '.php');
		if ($this->has_css)
			View::addCssFile($controller, $methode);
		if ($this->has_js)
			View::addJsFile($controller, $methode);

		$this->_GateKeeper->render($controller, $methode);
	}

	public function printOut($justBody = false) {
		$this->_GateKeeper->getResponse()->printOut($justBody);
	}

	public function fetchOut() {
		return $this->_GateKeeper->getResponse()->fetchOut();
	}

	protected function redirect($url) {
		$this->_GateKeeper->redirect($url);
	}

	public function postAction() {
		
	}

	public function getAction() {
		
	}

}

?>
