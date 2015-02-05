<?php

class ATR95 extends Action {

	function launch(Request $request, Response $response) {
		$this->has_css = true;
		$this->has_js = false;
		
		$folderW = str_replace('admin','monagence',dirname($_SERVER['SCRIPT_FILENAME']));
		
		if (isset($_POST['delImg'])) {
            $fileWhere = $folderW . '/_img/mandatimg/' . $_POST['idplan']. '/plan/plan.jpg';
            unlink($fileWhere);
        } else {


		$dirold = dirname($_SERVER['SCRIPT_FILENAME']) . '/_img/filesUp/';

//check si dossier existe
		if (!is_dir($folderW . '/_img/mandatimg/' . $_POST['idplan'] . '/')) {
			mkdir($folderW .'/_img/mandatimg/' . $_POST['idplan'] . '/');
		}

		if (!is_dir($folderW . '/_img/mandatimg/' . $_POST['idplan']. '/plan/')) {
			mkdir($folderW .'/_img/mandatimg/' . $_POST['idplan']. '/plan/');
		}


		//deplace normal
		$rename01 = rename($dirold . $_POST['fileName'], $folderW .'/_img/mandatimg/' . $_POST['idplan'] . '/plan/plan.jpg');
		//deplace mini
		
die();
	}

}
}

?>
