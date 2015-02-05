<?php
class XmlParser {
    protected static $xmlReader;
    protected static $elmt;

    protected static function _init($content){
        $urlContent = $content;
		self::$xmlReader = new XMLReader();
        self::$xmlReader->open($urlContent, "iso-8859-1");
    }

    protected static function _beginPhp(){
        $begin = "\n<?php\n";
        return $begin;
    }

    protected static function _endPhp(){
        $end = "\n?>\n";
        return $end;
    }

    protected static function _varInBaliseNg($value){
		$value = preg_replace('#\{\$(.+)\}#','\$$1',$value,-1,$count);
		if($count == 0){
			$value='"'.substr($value,1,-1).'"';
		}
        return $value;
    }

    protected static function _varSimple($value){
        /*$value = preg_replace('#\{\$(.+)\}#','<?php echo $$1;?>',$value,-1,$count);*/
		if(!eregi('return;',$value))
			$value = preg_replace('/\{(\$?[^\s\}]+)\}/', '<?php echo $1;?>', $value);
	//return trim($value);
	return $value;
    }

	protected static function _fbBalise(){
		 self::$xmlReader->moveToAttribute("href");
		self::$elmt .= "<fb:like href=\"". self::_varInBaliseNg(self::$xmlReader->value) ."\" send=\"false\" layout=\"box_count\" width=\"65\" show_faces=\"false\"></fb:like>";
	}

    protected static function _ngBalise(){
        if (self::$xmlReader->nodeType == XMLReader::ELEMENT)
            {
                self::$elmt .= self::_beginPhp();
                switch(self::$xmlReader->localName)
                {
                    case 'if' :
                        self::$xmlReader->moveToAttribute("value");
                        self::$elmt .= "\n".'if ('.substr(self::$xmlReader->value,1,-1).') {';
                        if(self::$xmlReader->moveToAttribute("comment"))
                        {
                            self::$elmt .= "//".self::$xmlReader->value;
                        }
                        break;
					 case 'else' :
                        ;
                        self::$elmt .= "\n".'}else{';
                        if(self::$xmlReader->moveToAttribute("comment"))
                        {
                            self::$elmt .= "//".self::$xmlReader->value;
                        }
                        break;
                    case 'foreach' :
                        self::$xmlReader->moveToAttribute("value");
                        $value = self::$xmlReader->value;

                        self::$xmlReader->moveToAttribute("name");
                        $name = self::$xmlReader->value;
						
						self::$elmt .= "\nif ((is_array(".self::_varInBaliseNg($value).") || (".self::_varInBaliseNg($value)." instanceOf ArrayAccess)) && count(".self::_varInBaliseNg($value).") > 0) {\n";
						self::$elmt .= '$'.$name.' = new Iterrator('.self::_varInBaliseNg($value).');'."\n";

                        self::$elmt .= "\n".'foreach ('.self::_varInBaliseNg($value).' as $'. $name .'->index => $'. $name.'->current) {';
                        if(self::$xmlReader->moveToAttribute("comment"))
                        {
                            self::$elmt .= "//".self::$xmlReader->value;
                        }
                        break;
					case 'for' :
                        self::$xmlReader->moveToAttribute("value");
                        $value = self::$xmlReader->value;

                        self::$xmlReader->moveToAttribute("max");
                        $max = self::$xmlReader->value;

                        self::$elmt .= "\n".'for ($i='.self::_varInBaliseNg($value).' ; $i<='. self::_varInBaliseNg($max) .'; $i++) {';
                        if(self::$xmlReader->moveToAttribute("comment"))
                        {
                            self::$elmt .= "//".self::$xmlReader->value;
                        }
                        break;
                    default :
                        $gname = self::$xmlReader->localName;
						$args = null;
						self::$elmt .= "\n"."echo NgGadget::factory(\"".$gname."\"";
						if (self::$xmlReader->hasAttributes)
						{
							while(self::$xmlReader->moveToNextAttribute())
							{
								$args[] = "\"".self::$xmlReader->localName."\"=>".self::_varInBaliseNg(self::$xmlReader->value);
							}
							self::$elmt .= ", array(";
							self::$elmt .= join(", ",$args);
							self::$elmt .= ")";
						}
                        self::$elmt .= ")->display();";
                        break;
                }
                self::$elmt .= self::_endPhp();
            }

            if(self::$xmlReader->nodeType == XMLReader::END_ELEMENT)
            {
                self::$elmt .= self::_beginPhp();
                switch(self::$xmlReader->localName)
                {
                    case 'if' :
					case 'for' :
                        self::$elmt .= "\n".'}'."\n";
                        break;
					case 'foreach' :
						self::$elmt .= "\n".'}}'."\n";
                        break;

                }
                self::$elmt .= self::_endPhp();
            }
    }
    static public function parse($content){
        self::_init($content);
        self::$elmt = "";
        while (self::$xmlReader->read())
        {
			if (self::$xmlReader->prefix == "fb")       //propre balise ng
            {
                self::_fbBalise();
            }
            if (self::$xmlReader->prefix == "ng")       //propre balise ng
            {
                self::_ngBalise();
            }
            else            //balise normale
            {
				
                switch(self::$xmlReader->nodeType)
                {
                    case XMLReader::DOC:
                             Error::addError("Type de noeud ".self::$xmlReader->nodeType." : ". self::$xmlReader->localName ." Non traité !",Error::errorFaible);
                            break;
                    case XMLReader::DOC_TYPE:
                             Error::addError("Type de noeud ".self::$xmlReader->nodeType." : ". self::$xmlReader->localName ." Non traité !",Error::errorFaible);
                            break;
                    case XMLReader::ELEMENT:
                            if (self::$xmlReader->localName == "document") break;
                            if (self::$xmlReader->localName == "body") break;
                            self::$elmt.= "<".((self::$xmlReader->prefix)?self::$xmlReader->prefix.":":"").self::$xmlReader->localName;
                            $isEmpty = self::$xmlReader->isEmptyElement;
                            while(self::$xmlReader->moveToNextAttribute()){
                                self::$elmt .= " ";
                                self::$elmt .= ((self::$xmlReader->prefix) ? self::$xmlReader->prefixe.":" : "").self::$xmlReader->localName."=\"";
								if(self::$xmlReader->localName == 'href' || self::$xmlReader->localName == 'src'){
									if(eregi('http://',self::_varSimple(self::$xmlReader->value)))
										self::$elmt .= self::_varSimple(self::$xmlReader->value);
									else
										self::$elmt .= _FULL_URL.self::_varSimple(self::$xmlReader->value);
								}else{
									self::$elmt .= self::_varSimple(self::$xmlReader->value);
								}

                                self::$elmt .= "\"";
                            }
                            if ($isEmpty) self::$elmt .= "/>";
                            else self::$elmt .= ">";
                            break;
                    case XMLReader::END_ELEMENT:
                            if (self::$xmlReader->localName == "document") break;
                            if (self::$xmlReader->localName == "body") break;
                            self::$elmt .= "</".((self::$xmlReader->prefix)?self::$xmlReader->prefix.":":"").self::$xmlReader->localName.">";
							//if(self::$xmlReader->localName != 'span')
							//	self::$elmt .="\n";
                            break;
                    case XMLReader::TEXT:
                            self::$elmt .= self::_varSimple(self::$xmlReader->value);
                            break;
                    case (XMLReader::SIGNIFICANT_WHITESPACE||XMLReader::WHITESPACE):
                            self::$elmt .= "";
                            break;
                    default:
                            Error::addError("Type de noeud ".self::$xmlReader->nodeType." : ". self::$xmlReader->localName ." Non traité !",Error::errorFaible);
                }
            }

        }
        self::$xmlReader->close();
        return utf8_decode(self::$elmt);
    }
}
?>