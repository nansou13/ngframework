<?php

class ALDIM extends Action {

	
	function getContentype($filename) {
		$ext = explode('.', $filename);
		switch ($ext[1]) {
			case 'gif':
				$content_type = "Content-type: image/gif";
				break;
			case 'jpg':
			case 'jpeg':
				$content_type = "Content-type: image/jpeg";
				break;
			case 'png':
				$content_type = "Content-type: image/png";
				break;
			case 'swf':
				$content_type = "Content-type: application/x-shockwave-flash";
				break;
			case 'xml':
				$content_type = "Content-type: text/xml";
				break;
		}
		return $content_type;
	}

	function launch(Request $request, Response $response) {

		$arrayInfo = $request->getParam('params');
		$type = $arrayInfo[0];
		if (isset($arrayInfo[2]) && $arrayInfo[2] != '') {
			$gadgetName = $arrayInfo[1];
			$arraySpe = $arrayInfo;
			array_shift($arraySpe);
			array_shift($arraySpe);
			$fileName = implode('/', $arraySpe);
		}
		else
			$fileName = $arrayInfo[1];

		switch ($type) {
			case 'globals' :
				if (isset($arrayInfo[2]) && $arrayInfo[2] != '') {
					$filez = _PATH_IMG_GENE . $gadgetName . '/' . $fileName;
				} else {
					$filez = _PATH_IMG_GENE . $fileName;
				}
				break;
			case 'gadget' :$filez = _PATH_GADGETS_GENE . $gadgetName . '/' . _PATH_IMG . $fileName;
				break;

			default : $filez = _PATH_CONTROLLERS_GENE . $type . '/' . _PATH_IMG . $fileName;
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

		

		if (isset($_GET['debugImg'])) {
			var_dump($filez, file_exists($filez), $this->getContentype($fileName));
			die();
		}
		if (file_exists($filez)) {
			$fileSize = filesize($filez);
			$filemtime = filemtime($filez);


			$hashFile = md5($filez);

			header('Pragma: ');
			header('Cache-Control: max-age=10800');
			header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $filemtime) . ' GMT');
			header('Etag: "' . $hashFile . '"');
			header('Expires: ' . gmdate('D, d M Y H:i:s', $filemtime + 100000000) . ' GMT');

			header('Content-type: ' . $this->getContentype($fileName));
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
			echo '';
			die();
		}
	}

}

?>
