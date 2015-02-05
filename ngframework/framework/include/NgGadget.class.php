<?php
class NgGadget {
    
    protected $has_css = false;
    protected $has_js = false;
    protected $str = false;

	protected $_var = array();

    protected static $loaded_gadget = array();

    public function __construct($args){
       
        //boucle sur chaques variable et on les assigne a $this pour les recuperer dans le gadget
		if(is_array($args) && count($args) >0){
			foreach($args as $key=>$value){
				$this->$key = $value;
			}
		}

		$className = get_class($this);

		$this->launch();

        //recupere les CSS et JS
        View::addJsFile('gadget',$className);
        View::addCssFile('gadget',$className);
        //parse la page*
        $args = 0;
		//var_dump($this->_var);die();
        $this->str = View::render('gadget', $className,$this->_var);
    }

    public static function singleton()
    {
        if (is_null(self::$_instance)) self::$_instance = new self();
        return self::$_instance;
    }

    public static function factory($name, $arg = null){
        $pathClass = _PATH_GADGETS_GENE.$name.'/'.$name.'.php';
        ngRequire($pathClass);

        return new $name($arg);
        $this->launch();
    }

	public function display(){
		return $this->str;
	}

	protected function launch()
	{

	}

	public function __get($name)
	{
		if(isset($this->_var[$name]))
			return $this->_var[$name];
		else
			return null;
	}

	public function __set($name, $value)
	{
		$this->_var[$name] = $value;
	}
}
?>