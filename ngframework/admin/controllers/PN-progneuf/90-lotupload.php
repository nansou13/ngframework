<?php

class APN90 extends Action {

    function launch(Request $request, Response $response) {
        $this->has_css = false;
        $this->has_js = false;
		
		$folderW = str_replace('admin', 'programmeneuf', dirname($_SERVER['SCRIPT_FILENAME']));

            $dirold = dirname($_SERVER['SCRIPT_FILENAME']) . '/_img/filesUp/';

//check si dossier existe
            if (!is_dir($folderW . '/data/waitlot/')) {
                mkdir($folderW . '/data/waitlot/');
            }

            //deplace normal
            $rename01 = rename($dirold . $_POST['fileName'], $folderW . '/data/waitlot/' . $_POST['idpict'] . '.pdf');
            
            echo $_POST['id'] . '-' . $_POST['idpict'] . '-' . $rename01;
        
        die();
    }

}
?>
