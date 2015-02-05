<?php

class ABL03 extends Action {

	function init() {
		ngRequire('DAO/blogDAO.php');
	}

	function launch(Request $request, Response $response) {

		$this->has_css = true;
		$this->has_js = true;

		if (isset($_POST['idblog'])) {

			if ($_POST['idblog'] == '') {
				echo 'error';
				die();
			}
			header('Content-type: text/html; charset=utf-8');
			$blogDAO = new blogDAO();
			
			$id = $blogDAO->save(utf8_decode($_POST['title']), utf8_decode(html_entity_decode($_POST['description'])),$_POST['idblog'], $_POST['categblog']);
			echo $id;
			die();
		}

		View::addJsFile('includes', 'jquery.ui.widget');
		View::addJsFile('includes', 'jquery.iframe-transport');
		View::addJsFile('includes', 'jquery.fileupload');
		View::addJsFile('includes', 'jquery.fileupload-process');
		View::addJsFile('includes', 'jquery.fileupload-validate');

		$param = $request->getParam();
		$mandatID = $param[0];

		$blogDAO = new blogDAO();
		$bloginfo = $blogDAO->get($mandatID);
                    
        $folderW = str_replace('admin','blog',$_SERVER["DOCUMENT_ROOT"]);
                
		$urlAbs = $folderW . '/_img/blogimg/' . $mandatID . '/';
		$nbrPhoto = $this->count_files($urlAbs);

		$response->nbrPhoto = $nbrPhoto;
		//var_dump($urlAbs,$nbrPhoto);
		$response->blogInfo = $bloginfo;
		$response->listCateg = $blogDAO->getCategories();

		$this->render($this->controllerName, $this->methodeName);
		$this->printOut();
	}

	public function count_files($dir) {
		$num = 0;
		if (is_dir($dir)) {
			$dir_handle = opendir($dir);
			while ($entry = readdir($dir_handle))
				if (is_file($dir . '/' . $entry))
					$num++;
			closedir($dir_handle);
		}
		return $num;
	}

}

?>
