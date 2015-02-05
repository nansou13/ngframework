<?php

class header extends NgGadget {

	function launch() {
		$this->has_css = true;
		$this->has_js = false;
		
		if (!$this->active) {
			$this->active = 0;
		}
		
		if (!$this->typeHeader) {
			$this->typeHeader = 'normal';
		}
	}

}

?>