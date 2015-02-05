<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Responseclass
 *
 * @author Nans
 */

class Response {
    
	private $_vars = array() ;
	private $_header = null ;

    private $_meta = array(
                        'title'             => _TITLE_SITE,
                        'description'       => _DESCRIPTION_SITE,
                        'keywords'          => _KEYWORD_SITE,
                        'robots'            => 'index, follow',
                        'rating'            => 'General',
                        'distribution'      => 'Global',
                        'Identifier-URL'    => _URL,
                        'revisit-after'     => '7',
                        'author'            => _AUTHOR_SITE,
                        'reply-to'          => _AUTHOR_MAIL_SITE,
                        'owner'             => _CONTACT_MAIL,
                        'Content-Type'      => 'text/html; charset=iso-8859-1',
                       // 'Content-Type'      => 'text/html; charset=utf-8',
                        'Content-Language'  => _LANGUAGE_SITE,
                        'pragma'            => 'no-cache',
                        'cache-control'     => 'no-cache',
                        'expires'           => '0',

                    );

    private $_metaFull;
	private $_body ;


	/**
	 * Magic get data
	 *
	 * @return mixed
	 */
	public function __get($key)
	{
		return $this->getVar($key);
	}

	/**
	 * Magic set data
	 *
	 * @return void
	 */
	public function __set($key, $value)
	{
		$this->addVar($key, $value);
	}

	public function addVar($key, $value){
		$this->_vars[$key] = $value;
		return $this->_vars;
	}
	
	public function getVar($key){
		return isset($this->_vars[$key])?$this->_vars[$key]:null;
	}
	
	public function getVars(){
		return $this->_vars;
	}

    public function addMeta ($key, $value){
        $this->_meta[$key] = $value;
    }

    public function getMetas (){
        return $this->_meta;
    }

    public function setTitle($value){
        $this->_meta['title'] = $value ;
    }

    public function setDescription($value){
        $this->_meta['description'] = $value ;
    }

    public function setKeyword($value){
        $this->_meta['keywords'] = $value ;
    }

    public function setLanguage($value){
        $this->_meta['Content-Language'] = $value ;
    }

    public function setBody($value){
        $this->_body = $value;
    }



    public function generateMeta(){

        $this->_metaFull = '';

        foreach ($this->_meta as $key =>  $value){
            
            switch($key){
                case 'title' : $this->_metaFull .= "<title>".$value."</title>\n";
                               break;

                case 'Content-Type' :
                case 'Content-Language' :
                case 'pragma' :
                case 'cache-control' :
                case 'expires' : $this->_metaFull .= "<meta http-equiv=\"".$key."\" content=\"".$value."\" />\n";
                                 break;

                default : $this->_metaFull .= "<meta name=\"".$key."\" content=\"".$value."\" />\n";
                          break;
            }
        }
    }

    private function createHeader(){

        //recupere tous les css et js
        $this->_header .= View::getJsFiles();
        $this->_header .= View::getCssFiles();
        //genere les metas
        $this->generateMeta();

        echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
        echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" lang=\"fr\" xml:lang=\"fr\">\n";
        echo "<head>\n";

        echo $this->_metaFull;

		if(_FAVICON)
			echo '<link rel="icon" href="data/favicon.ico" type="image/vnd.microsoft.icon" />';

        if($this->getVar('_og')){
        echo $this->getVar('_og')."\n";}
    
        echo $this->_header;
		
		//font awesome
		echo "<link href=\"//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css\" rel=\"stylesheet\"/>";
        echo "</head>\n";

    }
    public function fetchOut(){

	return $this->_body;
    }

    public function printOut($justBody = false){

        if(!$justBody){
            $this->createHeader();
        }
        
        echo "<body>\n";
if(file_exists('data/phpBegin.php')){
	include('data/phpBegin.php');
}

	View::getPhpFiles();

	echo "<div id=\"loading\"><div class=\"overlay\"></div><div class=\"info\">Chargement en cours...</div></div>";
        echo $this->_body;

	View::getExtraPhp();

	if(file_exists('data/phpEnd.php')){
	include('data/phpEnd.php');
	}
        echo "</body>\n";
		echo "</html>\n";

    }
    
	
	
}
?>
