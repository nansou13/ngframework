<?php

class APN97 extends Action {

    function launch(Request $request, Response $response) {
        $this->has_css = true;
        $this->has_js = false;
		
		$folderW = str_replace('admin','programmeneuf',dirname($_SERVER['SCRIPT_FILENAME']));
	
        if (isset($_POST['delImg'])) {
            $fileWhere = $folderW . '/_img/neufimg/' . $_POST['id'] . '/' . $_POST['delImg'] . '.jpg';
            unlink($fileWhere);
        } else {
            $dirold = dirname($_SERVER['SCRIPT_FILENAME']) . '/_img/filesUp/';

//check si dossier existe
            if (!is_dir($folderW . '/_img/neufimg/' . $_POST['id'] . '/')) {
                mkdir($folderW . '/_img/neufimg/' . $_POST['id'] . '/');
            }

            if (!is_dir($folderW . '/_img/neufimg/' . $_POST['id'] . '/mini/')) {
                mkdir($folderW . '/_img/neufimg/' . $_POST['id'] . '/mini/');
            }


            //deplace normal
            $rename01 = rename($dirold . $_POST['fileName'], $folderW . '/_img/neufimg/' . $_POST['id'] . '/' . $_POST['idpict'] . '.jpg');
            //deplace mini
            $rename02 = rename($dirold . 'thumbnail/' . $_POST['fileName'], $folderW . '/_img/neufimg/' . $_POST['id'] . '/mini/' . $_POST['idpict'] . '.jpg');

            echo $_POST['id'] . '-' . $_POST['idpict'] . '-' . $rename01 . '-' . $rename02;
        }
        die();
    }

}
?>
