<?php

class View {
	private static $css_files = array();
	private static $js_files = array();
	private static $php_files = array();

	private static $textAparser;

    static public function getGlobalsFiles(){

        $global_dir = _PATH_GLOBALS_GENE;
		$files = scandir($global_dir);
		foreach($files as $key => $inc)
		{
		    $infos = pathinfo($inc);
		    switch ($infos['extension']){
			case 'js' : View::addJsFile('globals',$infos['filename']);
			    break;

			case 'css' : View::addCssFile('globals',$infos['filename']);
			    break;

			case 'php' : View::addPhpFile('globals',$infos['filename']);
			    break;
		    }
		}
    }

    static public function getExtraPhp(){

        $global_dir = _PATH_EXTRA_GENE;
	$files = scandir($global_dir, 1);
	foreach($files as $key => $inc)
	{
	    $infos = pathinfo($inc);
	    if($infos['extension']=='php'){
		include(_PATH_EXTRA_GENE.$inc);break;
	    }
	}
    }

    static public function getJsFiles(){
        $jsAll = '';
        $jsGlobals = '';
        $jsReste = '';
		if(_ULTRA_GLOBAL){
				if(!file_exists(_PATH_ULTRA_GLOBAL."index.js")){
					View::createUltraGlobalFile('js',self::$js_files);
				}
				$jsGlobals = "<script type=\"text/javascript\" language=\"javascript\" src=\""._URL."/LD/JS/ultraGlobals/index.js\"></script>\n";
		}else{
			foreach(self::$js_files as $key => $value){
				if($value){
					$infoJs = explode('--',$key);
					$type = $infoJs[0];
					$name = $infoJs[1];

					switch($type){
						case 'globals' : $jsGlobals .= "<script type=\"text/javascript\" language=\"javascript\" src=\""._URL."/LD/JS/globals/".$name.'.js'."\"></script>\n";break;
						case 'gadget' : $jsReste .= "<script type=\"text/javascript\" language=\"javascript\" src=\""._URL."/LD/JS/gadget/".$name.'.js'."\"></script>\n";break;
						default : $jsReste .= "<script type=\"text/javascript\" language=\"javascript\" src=\""._URL."/LD/JS/". $type ."/".$name.'.js'."\"></script>\n";break;
					}
				}
			}
		}
        $jsAll = $jsGlobals.$jsReste;
        return $jsAll;
    }

    static public function addJsFile ($type, $name){
        $name = basename($name,'.php');
        if(!isset(self::$js_files[$type.'--'.$name])){
            self::$js_files[$type.'--'.$name] = true;
        }
    }

	static public function createUltraGlobalFile($ext, $var){
		$AllContentFile = '';
		foreach($var as $key => $value){
			if($value){
				$infoCss = explode('--',$key);
				$type = $infoCss[0];
				$name = $infoCss[1];


				switch($type){
					case 'globals' : $UrlFile =  _PATH_GLOBALS_GENE.$name.'.'.$ext;break;
					case 'gadget' : $UrlFile = _PATH_GADGETS_GENE.basename($name,'.'.$ext).'/'._PATH_VIEWS_GENE.$name.'.'.$ext;break;
					default : $UrlFile = _PATH_CONTROLLERS_GENE.$type.'/'._PATH_VIEWS_GENE.$name.'.'.$ext;break;
				}

				$AllContentFile .= "\n".file_get_contents($UrlFile);
			}
		}
		$fichier = fopen(_PATH_ULTRA_GLOBAL."index.".$ext,"w+");
		$AllContentFile=str_replace('url("', 'url("'._URL.'/', $AllContentFile);
		fwrite($fichier,$AllContentFile);

	}

    static public function getCssFiles(){
        $cssAll = '';
        $cssGlobals = '';
        $cssReste = '';
		if(_ULTRA_GLOBAL){
				if(!file_exists(_PATH_ULTRA_GLOBAL."index.css")){
					View::createUltraGlobalFile('css',self::$css_files);
				}
				$cssGlobals = "<link href=\""._URL."/LD/CS/ultraGlobals/index.css\" media=\"all\" rel=\"stylesheet\" type=\"text/css\" />\n";
		}else{
			foreach(self::$css_files as $key => $value){

				if($value){
					$infoCss = explode('--',$key);
					$type = $infoCss[0];
					$name = $infoCss[1];

					switch($type){
						case 'globals' : $cssGlobals .= "<link href=\""._URL."/LD/CS/globals/".$name.".css\" media=\"all\" rel=\"stylesheet\" type=\"text/css\" />\n";break;
						case 'gadget' : $cssReste .= "<link href=\""._URL."/LD/CS/gadget/".$name.".css\" media=\"all\" rel=\"stylesheet\" type=\"text/css\" />\n";break;
						default : $cssReste .= "<link href=\""._URL."/LD/CS/".$type."/".$name.".css\" media=\"all\" rel=\"stylesheet\" type=\"text/css\" />\n";break;
					}
				}
			}
        }
        $cssAll = $cssGlobals.$cssReste;
        return $cssAll;
    }

    static public function addCssFile ($type, $name){
        $name = basename($name,'.php');
        if(!isset(self::$css_files[$type.'--'.$name])){
            self::$css_files[$type.'--'.$name] = true;
        }
    }

    static public function getPhpFiles(){
	foreach(self::$php_files as $key => $value){
	    if($value){
                $infoCss = explode('--',$key);
                $type = $infoCss[0];
                $name = $infoCss[1];
		/*switch($type){
		    default : ngRequire('./_globals/'.$name.'.php');break;
		}*/
	    }
	    
	}
    }

    static  public function addPhpFile($type, $name){
	$name = basename($name,'.php');
        if(!isset(self::$php_files[$type.'--'.$name])){
            self::$php_files[$type.'--'.$name] = true;
        }
    }

    static public function render($type, $name,$args){
        $value = self::findFile($type, $name,$args);
        return $value;
    }

    static private function findFile($type, $name,$args){
        if (is_array($args)) extract($args);
        switch($type){
            case 'gadget' :
                if(!file_exists( _PATH_CACHE_GADGET.$name.'.php')){
                    $url = _PATH_GADGETS_GENE.$name.'/'._PATH_VIEWS_GENE.$name.".xml";
                    $contentFile = XmlParser::parse($url);
                    $newFileParse = _PATH_CACHE_GADGET.$name.'.php';

                    $fichier = fopen($newFileParse,"a");
                    fwrite($fichier,$contentFile);
                }else{
					if(_AUTO_CHANGE_CACHE){
						$filemtime = filemtime( _PATH_GADGETS_GENE.$name.'/'._PATH_VIEWS_GENE.$name.".xml");
						$cachemtime = filemtime( _PATH_CACHE_GADGET.$name.'.php');

						if($cachemtime<$filemtime){
							$url = _PATH_GADGETS_GENE.$name.'/'._PATH_VIEWS_GENE.$name.".xml";
							$contentFile = XmlParser::parse($url);
							$newFileParse = _PATH_CACHE_GADGET.$name.'.php';

							$fichier = fopen($newFileParse,"w");
							fwrite($fichier,$contentFile);
						}
					}
                }


                $pathFile = _PATH_CACHE_GADGET.$name.'.php';

                break;
            default :
                //cherche ds le cache
                if(!file_exists(_PATH_CACHE.$type.'-'.$name)){
                    $url = _PATH_CONTROLLERS_GENE.$type.'/'._PATH_VIEWS_GENE.basename($name, ".php").".xml";
                    $contentFile = XmlParser::parse($url);

                    $newFileParse = _PATH_CACHE.$type.'-'.$name;
                    $fichier = fopen($newFileParse,"w");
                    fwrite($fichier,$contentFile);
                }else{
					if(_AUTO_CHANGE_CACHE){
						$filemtime = filemtime( _PATH_CONTROLLERS_GENE.$type.'/'._PATH_VIEWS_GENE.basename($name, ".php").".xml");
						$cachemtime = filemtime( _PATH_CACHE.$type.'-'.$name);
						if($cachemtime<$filemtime){
							$url = _PATH_CONTROLLERS_GENE.$type.'/'._PATH_VIEWS_GENE.basename($name, ".php").".xml";
							$contentFile = XmlParser::parse($url);

							$newFileParse = _PATH_CACHE.$type.'-'.$name;
							$fichier = fopen($newFileParse,"w");
							fwrite($fichier,$contentFile);
						}
					}
                }
                $pathFile = _PATH_CACHE.$type.'-'.$name;
                break;
            }
            ob_start();
            require($pathFile);
            $str = ob_get_contents();
            ob_end_clean();
            
            return $str;
    }

}
?>
