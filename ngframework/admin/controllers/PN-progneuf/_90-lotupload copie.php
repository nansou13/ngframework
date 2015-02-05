<?php

class APN90 extends Action {

    function launch(Request $request, Response $response) {
        $this->has_css = false;
        $this->has_js = false;

            $dirold = dirname($_SERVER['SCRIPT_FILENAME']) . '/_img/filesUp/';

//check si dossier existe
            if (!is_dir(dirname($_SERVER['SCRIPT_FILENAME']) . '/data/waitlot/')) {
                mkdir(dirname($_SERVER['SCRIPT_FILENAME']) . '/data/waitlot/');
            }

            //deplace normal
            $rename01 = rename($dirold . $_POST['fileName'], dirname($_SERVER['SCRIPT_FILENAME']) . '/data/waitlot/' . $_POST['idpict'] . '.pdf');
            
            echo $_POST['id'] . '-' . $_POST['idpict'] . '-' . $rename01;
        
        die();
    }

}
?>
