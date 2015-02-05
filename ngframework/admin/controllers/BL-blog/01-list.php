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
                foreach($blogList as $blog){
			
			//les accents
			$titleMoment = $blog->title;
			$chaine = trim($titleMoment);
			$chaine = strtr($chaine, "¿¡¬√ƒ≈‡·‚„‰Â“”‘’÷ÿÚÛÙıˆ¯»… ÀËÈÍÎ«ÁÃÕŒœÏÌÓÔŸ⁄€‹˘˙˚¸ˇ—Ò", "aaaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuuuynn");
			//les caracËtres spÈciaux (aures que lettres et chiffres en fait)
			$chaine = preg_replace('/([^.a-z0-9]+)/i', '-', $chaine);
			$urlText = $chaine;

			$blog->urltext = $blog->id.'-'.strtolower($urlText);

		}
		$response->blogList = $blogList;

		$this->render($this->controllerName, $this->methodeName);
		$this->printOut();
	}

}

?>
