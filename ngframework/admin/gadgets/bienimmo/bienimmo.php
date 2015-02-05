<?php

class bienimmo extends NgGadget {

	function launch() {
		$this->has_css = true;
		$this->has_js = false;

		/*if ($this->valueBien->urltext == '') {


//les accents
			$chaine = trim($this->valueBien->title);
			$chaine = strtr($chaine, "ְֱֲֳִֵאבגדהוׂ׃װױײ״עףפץצרָֹÊֻטיךכַחּֽ־ֿלםמןÙÚÛÜשתûüÿׁס", "aaaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuuuynn");
//les caracטtres spיciaux (aures que lettres et chiffres en fait)
			$chaine = preg_replace('/([^.a-z0-9]+)/i', '-', $chaine);
			$this->valueBien->urltext = $chaine;
		}*/
	}

}
?>