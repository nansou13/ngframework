<?php
//include de tout !
require(_PATH_INCLUDE_GENE."ngRequire.class.php");
require(_PATH_INCLUDE_GENE."XmlParser.php");
require(_PATH_INCLUDE_GENE."FirePHP/fb.php");
require(_PATH_INCLUDE_GENE."Response.class.php");
require(_PATH_INCLUDE_GENE."Request.class.php");
require(_PATH_INCLUDE_GENE."View.class.php");
require(_PATH_INCLUDE_GENE."Action.class.php");
require(_PATH_INCLUDE_GENE."NgGadget.class.php");
require(_PATH_INCLUDE_GENE."CAjaxResponse.php");
require(_PATH_INCLUDE_GENE."Error.class.php");
require(_PATH_INCLUDE_GENE."Sql.class.php");
require(_PATH_INCLUDE_GENE."DAO.php");
require(_PATH_CONSTANTS_GENE."Class.php");

//require "include/Browser.class.php";

//require "include/Action.class.php";
//require "include/vmeGadgets.class.php";


class parametreDAO extends DAO {

	const table = "parametre";

	function __construct() {
		
	}

	function getInfo($nom) {
		if (empty($nom)) {
			throw new Exception('Parameter is empty');
		}
		$qry = "SELECT * FROM " . self::table . " WHERE nom='" . $nom . "'";

		return $this->fetch($qry, 'object', true);
	}
}

class GateKeeper
{
    private $_request;
    private $_response;

    private static $_instance = null;

    public static function singleton()
    {
        if (is_null(self::$_instance)) self::$_instance = new self();
        return self::$_instance;
    }

    private function __construct()
    {
        $this->_request = new Request();
        $this->_response = new Response();
    }

    public function getResponse()
    {
        return $this->_response;
    }

    public function getRequest()
    {
        return $this->_request;
    }

    public function dispatch()
	{
		$dataBaseConnect = _DATABASE_CONNECT;
		if($dataBaseConnect != false){
			$sql = new Sql();
			$sql->connect();
		}
		
		$parametreDAO = new parametreDAO();
        $parametreInfo = $parametreDAO->getInfo('CACHE_TIME');
define('_CACHE_TIME_',$parametreInfo->value);

		$this->_request->doSpecialAction();
        $parseUrl = $this->_request->route();
        $this->forward($parseUrl);
    }

    public static function factory($argUrlParse, $GateKeeper)
	{
		//recupere global (tous les fichiers du dossier avec detection de l'extension
        View::getGlobalsFiles();
        
		//recupere le fichier de class
		$arrayCompat = array('LD-loader');
		if(!in_array($argUrlParse['controller'], $arrayCompat))
			$pathClass = _PATH_CONTROLLERS_GENE.$argUrlParse['controller'].'/'.$argUrlParse['methode'];
		else {
			$pathClass = _PATH . "controllers/".$argUrlParse['controller'].'/'.$argUrlParse['methode'];
		}
        require($pathClass);

        $class = 'A'.$argUrlParse["controller_code"].$argUrlParse["methode_code"];
        $action = new $class($GateKeeper);

        return $action;

    }

    private function getGlobalScripts()
    {
        $global_dir = _PATH_GLOBALS_GENE;
        $filez = scandir($global_dir, 1);
        foreach($filez as $inc)
        {
                $infos = pathinfo($inc);
                if ($infos['extension'] == "php")
                        require(preg_replace("/^(\d\d\.\S+)$/", $global_dir."/$1.php", $infos['filename']));
        }
    }

    public function forward($argUrlParse)
    {
        $command = self::factory($argUrlParse, $this);
		$command->init();
        session_start();
		require(_PATH_INCLUDE_GENE."globalPhp.php");
		require(_PATH_GLOBALS_GENE."99.globalPhp.php");


		if($this->_request->isGet())
			$command->getAction();

		if($this->_request->isPost())
			$command->postAction();

        //$this->getGlobalScripts();
        $command->launch($this->_request, $this->_response);
    }

    public function render($module, $action){
        $render = View::render($module, $action,$this->getResponse()->getVars());
        //setBody
        $this->_response->setBody($render);
    }

	static public function redirect($url)
	{
		header("Location: "._SS_DOSSIER.$url);
		exit();
	}
}

?>
