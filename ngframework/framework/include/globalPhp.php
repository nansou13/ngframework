<?php
		if(isset($_GET['logout']))
			unset ($_SESSION['user']);

		if(isset($_POST['login']) && isset($_POST['password'])){
			ngRequire('DAO/clientDAO.php');
			$clientDAO = new clientDAO();
			$_SESSION['user'] = $clientDAO->loginAnLoad($_POST['login'], md5($_POST['password']));

		}

		class Iterrator
    	{
        private $index;
        private $current;
        private $first = true;
        private $last = false;
        private $modulo2;
        private $i = 0;

        private $first_key;
        private $last_key;

        public function __construct($items)
        {
            reset($items);
            $this->first_key = key($items);
            end($items);
            $this->last_key = key($items);
        }

        public function __set($property_name, $value)
        {
            if ($property_name == "index")
            {
                $this->i++;
                if ($value == $this->first_key) $this->first = true;
                else $this->first = false;
                if ($value == $this->last_key) $this->last = true;
                else $this->last = false;
                $this->modulo2 = $this->i % 2;
            }
            $this->$property_name = $value;
        }

        public function __get($property_name)
        {
            return $this->$property_name;
        }
    }
?>
