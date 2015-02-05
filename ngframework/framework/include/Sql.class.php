<?php
class Sql {

	private $server;
	private $user;
	private $password;
	private $basename;

	function __construct() {
			$this->server = _SERVER_SQL;
			$this->user = _USER_SQL;
			$this->password = _PASSWORD_SQL;
			$this->basename = _BASENAME_SQL;
    }

    function connect(){
		if(isset($this->server)){
			$db_link = @mysql_connect($this->server,$this->user,$this->password);
			if(!$db_link) {echo "Connexion impossible à la base de données sur le serveur.";exit;}
			mysql_select_db($this->basename,$db_link);
		}
    }

    
}
?>