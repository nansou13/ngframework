<?php
/**
 * Description of constructeur
 *
 * @author nans.gigan
 */
require("modules/controllerMethode.class.php");
class constructeur {
    private $title ;
    private $description ;
    private $keyword ;
    private $language ;

    private $styles ;
    private $javascripts ;
    private $pageContent ;

    public $__ERROR = null;

    public function __construct(){
        //class_exists('ErrorConstants') || require(_PATH_SOAP.'ErrorClass.class.php');

        $this->styles = array() ;
        $this->javascripts = array() ;
        //$this->__ERROR = new ErrorClass();


        //execute session
        session_start();

        //Recuperation de l'url
        $arrayUrl = explode('/',$_SERVER['REQUEST_URI']);
        $arrayUrl = array_slice($arrayUrl,1);

        $controller = $arrayUrl[0];
        $methode = $arrayUrl[1];

        $test = new controllerMethode($controller, $methode);
        echo $test->getFullIncludeUrl();

        /*$urlIncludeController = $this->getFolderController($controller);
        $urlIncludeMethode = $this->getFileMethode($urlIncludeController, $methode);


        if($urlIncludeController == ''){
            echo 'error 404';
        }else{
            if($urlIncludeMethode == ''){
                echo $urlIncludeController.'/00-index.php';
            }else{
                echo $urlIncludeController.'/'.$urlIncludeMethode;
            }
        }*/
        
        //recupere la page
        //include("");
        

        
    }
    public function generateHeader(){
        $tmpHeader = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
        $tmpHeader .= "<html xmlns=\"http://www.w3.org/1999/xhtml\" lang=\"fr\" xml:lang=\"fr\">\n";
        $tmpHeader .= "<head>\n";
        $tmpHeader .= "\t<title>".$this->getTitle()."</title>\n";
        $tmpHeader .= "\t<meta name=\"description\" content=\"". $this->getDescription() ."\" />\n";
        $tmpHeader .= "\t<meta name=\"keywords\" content=\"". $this->getKeyword() ."\" />\n";
        $tmpHeader .= "\t<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n";
        $tmpHeader .= "\t<meta http-equiv=\"Content-Language\" content=\"". $this->getLanguage() ."\" />\n";
        $tmpHeader .= "\t<meta name=\"robots\" content=\"index, follow\" />\n";
        $tmpHeader .= "\t<meta name=\"rating\" content=\"General\" />\n";
        $tmpHeader .= "\t<meta name=\"distribution\" content=\"Global\" />\n";
        $tmpHeader .= "\t<meta name=\"Identifier-URL\" content=\"". _URL ."\" />\n";
        $tmpHeader .= "\t<meta name=\"revisit-after\" content=\"7\" />\n";
        $tmpHeader .= "\t<meta name=\"author\" content=\"". _AUTHOR_SITE ."\" />\n";
        $tmpHeader .= "\t<meta name=\"reply-to\" content=\"". _AUTHOR_MAIL_SITE ."\" />\n";
        $tmpHeader .= "\t<meta name=\"owner\" content=\"". _CONTACT_MAIL ."\" />\n";
        $tmpHeader .= "\t<meta http-equiv=\"pragma\" content=\"no-cache\" />\n";
        $tmpHeader .= "\t<meta http-equiv=\"cache-control\" content=\"no-cache\" />\n";
        $tmpHeader .= "\t<meta http-equiv=\"expires\" content=\"0\" />\n";

        //GESTION DES SCRIPTS avec la variable

        //GESTION DES CSS avec la variable 

        $tmpHeader .= "</head>\n";
        $tmpHeader .= "<body>\n ahahaha";
        $tmpHeader .= "\n</body>";
        $tmpHeader .= "\n</html>";
        //$tmpHeader .= "<link href=\"/LD/CS/".$css."\" media=\"all\" rel=\"stylesheet\" type=\"text/css\" />\n";
        echo $tmpHeader;
    }
    public function setTitle($value){
        $this->title = $value ;
    }
    public function getTitle(){
        $this->title = ($this->title !='') ? $this->title : _TITLE_SITE ;
        return $this->title;
    }

    public function setDescription($value){
        $this->description = $value ;
    }
    public function getDescription(){
        $this->description = ($this->description !='') ? $this->description : _DESCRIPTION_SITE ;
        return $this->description;
    }

    public function setKeyword($value){
        $this->keyword = $value ;
    }
    public function getKeyword(){
        $this->keyword = ($this->keyword !='') ? $this->keyword : _KEYWORD_SITE ;
        return $this->keyword;
    }

    public function setLanguage($value){
        $this->language = $value ;
    }
    public function getLanguage(){
        $this->language = ($this->language !='') ? $this->language : _LANGUAGE_SITE ;
        return $this->language;
    }

    public function buildPage(){
        
    }

}
?>
