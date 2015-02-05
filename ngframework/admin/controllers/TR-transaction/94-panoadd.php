<?php

class ATR94 extends Action {

	function launch(Request $request, Response $response) {
		$this->has_css = true;
		$this->has_js = false;
		
		$folderW = str_replace('admin','monagence',dirname($_SERVER['SCRIPT_FILENAME']));
		
		$dirold = dirname($_SERVER['SCRIPT_FILENAME']) . '/_img/filesUp/';

//check si dossier existe
		if (!is_dir($folderW . '/_img/mandatimg/' . $_POST['idplan'] . '/')) {
			mkdir($folderW .'/_img/mandatimg/' . $_POST['idplan'] . '/');
		}

		if (!is_dir($folderW . '/_img/mandatimg/' . $_POST['idplan']. '/pano/')) {
			mkdir($folderW .'/_img/mandatimg/' . $_POST['idplan']. '/pano/');
		}


		//deplace normal
		$rename01 = rename($dirold . $_POST['fileName'], $folderW .'/_img/mandatimg/' . $_POST['idplan'] . '/pano/'.$_POST['idpicto'].'.jpg');
		//deplace mini
		
die();
	}

}

?>
