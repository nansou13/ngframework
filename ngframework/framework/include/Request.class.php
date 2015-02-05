<?php

class Request {
	/*
	 * $args = array
	 */

	private $args;

	public function getParam($key = 'params') {
		switch ($key) {
			case 'params_as_array' :
			case 'params' :
				return $this->args['params'];
				break;

			case 'all' :
				return $this->args;
				break;

			default :
				return filter_var($this->args[$key], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
				break;
		}
	}

	public function getTaintedParam($key) {
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST[$key])) {
			return $_POST[$key];
		} else {
			return $_GET[$key];
		}
	}

	/*
	 * fonction route
	 */

	public function route() {
		$arrayUrl = explode('?', $_SERVER['REQUEST_URI']);
		$arrayUrl = explode('/', $arrayUrl[0]);
		$arrayUrl = array_slice($arrayUrl, _NB_SS_DOSSIER);

		if ($arrayUrl[0] == '' || $arrayUrl[0] == 'index.php') {
			$this->accueilURLFormat();
		} else {
			$this->args['getController'] = $arrayUrl[0];
			$this->args['getMethode'] = (isset($arrayUrl[1]) ? $arrayUrl[1] : '');

			$this->setFolderController();	   //recuperation du controller
			$this->setFileMethode();			//recuperation de la methode

			array_shift($arrayUrl);
			array_shift($arrayUrl);

			$this->args['params'] = $arrayUrl;
		}

		return $this->args;
	}

	private function wrongURLFormat() {
		$this->args['controller'] = "XX-Error";
		$this->args['controller_code'] = "XX";
		$this->args['controller_name'] = "erreur";
		$this->args['methode'] = "99-404.php";
		$this->args['methode_code'] = "99";
		$this->args['methode_name'] = "404";
	}

	private function accueilURLFormat() {
		$this->args['controller'] = "00-accueil";
		$this->args['controller_code'] = "00";
		$this->args['controller_name'] = "accueil";

		$this->indexFormat();
	}

	private function indexFormat() {
		$this->args['methode'] = "00-index.php";
		$this->args['methode_code'] = "00";
		$this->args['methode_name'] = "index";
	}

	/*
	 * Recuperation du controller = dossier
	 */

	private function setFolderController() {

		$arrayCompat = array('LD', 'loader');
		if ($this->args['getController'])
		//liste les dossiers
			if (in_array($this->args['getController'], $arrayCompat)) {
				$repController = _PATH . "controllers/";
			} else {
				$repController = _PATH_CONTROLLERS_GENE;
			}

		$dir = opendir($repController);
		while ($f = readdir($dir)) {

			if (is_dir($repController . $f) && $f != '.' && $f != '..') {
				//recup le mini et le maxi name
				$arrayControllerNameComplet = explode('-', $f);
				$miniControllerName = $arrayControllerNameComplet[0];
				$maxiControllerName = $arrayControllerNameComplet[1];

				//verifie si le lien est compressé
				if (strlen($this->args['getController']) == 2) {
					if ($this->args['getController'] == $miniControllerName) {
						//Controller trouvé
						$this->args['controller'] = $f;
						$this->args['controller_name'] = $maxiControllerName;
						$this->args['controller_code'] = $miniControllerName;
					}
				} elseif (strlen($this->args['getController']) > 2) {
					if ($this->args['getController'] == $maxiControllerName) {
						//Controller trouvé
						$this->args['controller'] = $f;
						$this->args['controller_name'] = $maxiControllerName;
						$this->args['controller_code'] = $miniControllerName;
					}
				}
			}
		}

		closedir($dir);
		//si aucun controller trouvé
		if (!isset($this->args['controller']) || $this->args['controller'] == '') {
			//error
			$this->wrongURLFormat();
		}
	}

	/*
	 * Recuperation de la methode / le fichier
	 */

	private function setFileMethode() {
		$arrayCompat = array('IM', 'im','JS','js','CS','css');
		if ($this->args['getMethode'] != '') {
			//list les fichiers
			
			if (in_array($this->args['getMethode'], $arrayCompat)) {
				$repMethode = _PATH . "controllers/". $this->args['controller'] . '/';
			} else {
				$repMethode = _PATH_CONTROLLERS_GENE . $this->args['controller'] . '/';
			}
			
			//$repMethode = _PATH_CONTROLLERS_GENE . $this->args['controller'] . '/';
			$dir = opendir($repMethode);

			while ($f = readdir($dir)) {
				if (is_file($repMethode . $f)) {
					//recup le mini et le maxi name
					$arrayMethodeNameComplet = explode('-', $f);
					$miniMethodeName = $arrayMethodeNameComplet[0];

					$arrayMaxiMethodeName = explode('.', $arrayMethodeNameComplet[1]);
					$maxiMethodeName = $arrayMaxiMethodeName[0];

					//verifie si le lien est compressé
					if (strlen($this->args['getMethode']) == 2) {
						if ($this->args['getMethode'] == $miniMethodeName) {
							//Methode trouvé
							$this->args['methode'] = $f;
							$this->args['methode_name'] = $maxiMethodeName;
							$this->args['methode_code'] = $miniMethodeName;
						}
					} elseif (strlen($this->args['getMethode']) > 2) {
						if ($this->args['getMethode'] == $maxiMethodeName) {
							//Methode trouvé
							$this->args['methode'] = $f;
							$this->args['methode_name'] = $maxiMethodeName;
							$this->args['methode_code'] = $miniMethodeName;
						}
					}
				}
			}
			closedir($dir);
			//si aucune methode trouvée
			if (!isset($this->args['methode']) || $this->args['methode'] == '') {
				//error
				$this->wrongURLFormat();
			}
		} else {
			if (!isset($this->args['methode']) || $this->args['methode'] == '')
				$this->indexFormat();
		}
	}

	public function doSpecialAction() {

		if (isset($_GET['purge']) && $_GET['purge'] == 'clearcache') {
			//supprime le cache
			$dossier = _PATH_CACHE;
			$dir = opendir($dossier);
			while ($file = readdir($dir)) {
				if (is_file($dossier . '/' . $file)) {
					unlink("$dossier/$file");
				}
			}
			closedir($dir);

			$dossier = _PATH_CACHE_GADGET;
			$dir = opendir($dossier);
			while ($file = readdir($dir)) {
				if (is_file($dossier . '/' . $file)) {
					unlink("$dossier/$file");
				}
			}
			closedir($dir);

			$dossier = _PATH_CACHE_GLOBAL;
			$dir = opendir($dossier);
			while ($file = readdir($dir)) {
				if (is_file($dossier . '/' . $file)) {
					unlink("$dossier/$file");
				}
			}
			closedir($dir);

			$dossier = _PATH_ULTRA_GLOBAL;
			$dir = opendir($dossier);
			while ($file = readdir($dir)) {
				if (is_file($dossier . '/' . $file)) {
					unlink("$dossier/$file");
				}
			}
			closedir($dir);
		}
	}

	public function server($key = null, $default = null) {
		if (null === $key) {
			return $_SERVER;
		}

		return (isset($_SERVER[$key])) ? $_SERVER[$key] : $default;
	}

	public function method() {
		$sm = strtoupper($this->server('REQUEST_METHOD'));

		return $sm;
	}

	public function get($key, $default = null) {
		switch (true) {
			case isset($this->args[$key]):
				$value = $this->args[$key];
				break;

			case isset($_GET[$key]):
				$value = $_GET[$key];
				break;

			case isset($_POST[$key]):
				$value = mysql_real_escape_string(trim($_POST[$key]));
				break;

			case isset($_COOKIE[$key]):
				$value = $_COOKIE[$key];
				break;

			case isset($_SERVER[$key]):
				$value = $_SERVER[$key];
				break;

			case isset($_ENV[$key]):
				$value = $_ENV[$key];
				break;

			default:
				$value = $default;
		}

		// Key not found, default is being used
		if ($value === $default) {
			// Check for dot-separator (convenience access for nested array values)
			if (strpos($key, '.') !== false) {
				// Get all dot-separated key parts
				$keyParts = explode('.', $key);

				// Remove first key because we're going to start with it
				$keyFirst = array_shift($keyParts);

				// Get root value array to begin
				$value = $this->get($keyFirst);

				// Loop over remaining key parts to see if value can be found in resulting array
				foreach ($keyParts as $keyPart) {
					if (is_array($value)) {
						if (isset($value[$keyPart])) {
							$value = $value[$keyPart];
						} else {
							$value = $default;
						}
					}
				}
			}
		}

		return $value;
	}

	public function isPost() {
		return ($this->method() == "POST");
	}

	public function isGet() {
		return ($this->method() == "GET");
	}

	public function fget($key, $int = null) {
				if(!empty($_GET[$key])){
					$value = mysql_real_escape_string(trim($_GET[$key]));
					return $value;
				}else
					return null;
				
		
	}


}

?>
