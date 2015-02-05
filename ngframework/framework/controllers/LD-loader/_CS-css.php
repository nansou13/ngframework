<?php
class ALDCS extends Action
{
	
	function launch(Request $request, Response $response)
	{
            $arrayInfo  = $request->getParam('params');
            $type       = $arrayInfo[0];
            $fileName   = $arrayInfo[1];

        switch($type){
			case 'ultraGlobals' :
								$filez = _PATH_ULTRA_GLOBAL."index.css";
								$filezCache = _PATH_ULTRA_GLOBAL."index.css";
                            break;
            case 'globals' : $filez = _PATH_GLOBALS_GENE.$fileName;
								$filezCache = _PATH_CACHE_GLOBAL.$fileName;
                            break;
            case 'gadget'  :$filez = _PATH_GADGETS_GENE.basename($fileName,'.css').'/'._PATH_VIEWS_GENE.$fileName;
							$filezCache = _PATH_CACHE_GADGET.basename($fileName,'.css').'-'.$fileName;
                            break;

            default :       $filez = _PATH_CONTROLLERS_GENE.$type.'/'._PATH_VIEWS_GENE.$fileName;
							$filezCache = _PATH_CACHE.$type.'-'.$fileName;
                            break;
        }
        
        if (!function_exists('apache_request_headers')) {

            function apache_request_headers()
            {
                 foreach($_SERVER as $h=>$v)
                     if(ereg('HTTP_(.+)',$h,$hp))
                         $headers[$hp[1]]=$v;

                     return $headers;
            }
        }

        if(file_exists($filez)){

			if(_AUTO_CHANGE_CACHE){
				$filemtime = filemtime($filez);
				$cachemtime = (file_exists($filezCache)?filemtime($filezCache):0);

				$recreate = false;

				if($cachemtime<$filemtime){
					$recreate = true;
				}
				
			}


			if((!file_exists($filezCache)) || $recreate){
				$contenu=file_get_contents($filez);
				$contenuMod=str_replace('url("', 'url("'._SS_DOSSIER.'/', $contenu);
				$contenuMod=str_replace(array("\r\n", "\r", "\n", "\t", '  ', '	 ', '	 '), '', $contenuMod);
				$fichier = fopen($filezCache,"w+");
				fwrite($fichier,$contenuMod);

			}
			$filez = $filezCache;

            $fileSize = filesize($filez);
            $filemtime = filemtime($filez);


            $hashFile = md5($filez);

            header('Pragma: ');
            header('Cache-Control: max-age=10800');
            header('Last-Modified: '.gmdate('D, d M Y H:i:s', $filemtime).' GMT');
            header('Etag: "'.$hashFile.'"');
            header('Expires: '.gmdate('D, d M Y H:i:s', $filemtime + 100000000).' GMT');

            header('Content-type: text/css');
            header('Content-length: '.$fileSize);


            $headers = apache_request_headers();

            if(isset($headers['IF_MODIFIED_SINCE'])){
                $if_modified_since=preg_replace('/;.*$/','',$headers["IF_MODIFIED_SINCE"]);
            }

            if(isset($headers['IF_MODIFIED_SINCE']) && (strtotime($if_modified_since) == $filemtime))
            {
                header("HTTP/1.1 304 Not Modified");
                exit;
            }
			
			
            readfile($filez);
            die();
        }else{
            echo '';die();
        }
	}
}

?>
