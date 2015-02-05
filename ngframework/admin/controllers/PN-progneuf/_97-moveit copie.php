<?php

class APN97 extends Action {

    function launch(Request $request, Response $response) {
        $this->has_css = true;
        $this->has_js = false;

        if (isset($_POST['delImg'])) {
            $fileWhere = dirname($_SERVER['SCRIPT_FILENAME']) . '/_img/neufimg/' . $_POST['id'] . '/' . $_POST['delImg'] . '.jpg';
            unlink($fileWhere);
        } else {
            $dirold = dirname($_SERVER['SCRIPT_FILENAME']) . '/_img/filesUp/';

//check si dossier existe
            if (!is_dir(dirname($_SERVER['SCRIPT_FILENAME']) . '/_img/neufimg/' . $_POST['id'] . '/')) {
                mkdir(dirname($_SERVER['SCRIPT_FILENAME']) . '/_img/neufimg/' . $_POST['id'] . '/');
            }

            if (!is_dir(dirname($_SERVER['SCRIPT_FILENAME']) . '/_img/neufimg/' . $_POST['id'] . '/mini/')) {
                mkdir(dirname($_SERVER['SCRIPT_FILENAME']) . '/_img/neufimg/' . $_POST['id'] . '/mini/');
            }


            //deplace normal
            $rename01 = rename($dirold . $_POST['fileName'], dirname($_SERVER['SCRIPT_FILENAME']) . '/_img/neufimg/' . $_POST['id'] . '/' . $_POST['idpict'] . '.jpg');
            //deplace mini
            $rename02 = rename($dirold . 'thumbnail/' . $_POST['fileName'], dirname($_SERVER['SCRIPT_FILENAME']) . '/_img/neufimg/' . $_POST['id'] . '/mini/' . $_POST['idpict'] . '.jpg');

            echo $_POST['id'] . '-' . $_POST['idpict'] . '-' . $rename01 . '-' . $rename02;
        }
        die();
    }

}
?>
