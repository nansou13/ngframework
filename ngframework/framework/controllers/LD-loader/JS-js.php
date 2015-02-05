<?php

class ALDJS extends Action {

	function launch(Request $request, Response $response) {
		$arrayInfo = $request->getParam('params');
		$type = $arrayInfo[0];
		$fileName = $arrayInfo[1];

		switch ($type) {
			case 'ultraGlobals' :
				$filez = _PATH_ULTRA_GLOBAL . "index.js";
				$filezCache = _PATH_ULTRA_GLOBAL . "index.js";
				break;
			case 'globals' : $filez = _PATH_GLOBALS_GENE . $fileName;
				$filezCache = _PATH_CACHE_GLOBAL . $fileName;
				break;
			case 'includes' : 
				if(isset($arrayInfo[2]))
					$filez = _PATH_INCLUDE_GENE . $fileName.'/'. $arrayInfo[2];
				else
					$filez = _PATH_INCLUDE_GENE . $fileName;
				$filezCache = false;
				break;
			case 'gadget' :$filez = _PATH_GADGETS_GENE . basename($fileName, '.js') . '/' . _PATH_VIEWS_GENE . $fileName;
				$filezCache = _PATH_CACHE_GADGET . basename($fileName, '.js') . '-' . $fileName;
				break;

			default : $filez = _PATH_CONTROLLERS_GENE . $type . '/' . _PATH_VIEWS_GENE . $fileName;
				$filezCache = _PATH_CACHE . $type . '-' . $fileName;
				break;
		}


		if (!function_exists('apache_request_headers')) {

			function apache_request_headers() {
				foreach ($_SERVER as $h => $v)
					if (ereg('HTTP_(.+)', $h, $hp))
						$headers[$hp[1]] = $v;

				return $headers;
			}

		}
$recreate = true;		
		if (file_exists($filez)) {
			if ($filezCache !== false) {
				if (_AUTO_CHANGE_CACHE) {
					$filemtime = filemtime($filez);
					$cachemtime = (file_exists($filezCache) ? filemtime($filezCache) : 0);

					$recreate = false;

					if ($cachemtime < $filemtime) {
						$recreate = true;
					}
				}


				if ((!file_exists($filezCache)) || $recreate) {
					$contenu = file_get_contents($filez);
					$fichier = fopen($filezCache, "w+");
					fwrite($fichier, $contenu);
				}



				$filez = $filezCache;
			}
			$fileSize = filesize($filez);
			$filemtime = filemtime($filez);

$cacheSeconds = 172861; // 2jours + 1heure + 1s
			$hashFile = md5($filez);

			header('Pragma: ');
			header('Cache-Control: max-age='.$cacheSeconds);
			header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $filemtime) . ' GMT');
			header('Etag: "' . $hashFile . '"');
			header('Expires: ' . gmdate('D, d M Y H:i:s', strtotime('+ ' . $cacheSeconds . ' seconds')) . ' GMT');

			header('Content-type: text/javascript');
			header('Content-length: ' . $fileSize);


			$headers = apache_request_headers();

			if (isset($headers['IF_MODIFIED_SINCE'])) {
				$if_modified_since = preg_replace('/;.*$/', '', $headers["IF_MODIFIED_SINCE"]);
			}

			if (isset($headers['IF_MODIFIED_SINCE']) && (strtotime($if_modified_since) == $filemtime)) {
				header("HTTP/1.1 304 Not Modified");
				exit;
			}

			readfile($filez);
			die();
		} else {
			echo 'file doesnt exist : '.$filez;
			die();
		}
	}

}

?>
