<?php

class villeDAO extends DAO {

	const table = "maville";

	function __construct() {
		
	}

	function getInfo($id, $selectFields = "id, ville, cp") {
		if (empty($id)) {
			throw new Exception('Parameter is empty');
		}
		$qry = "SELECT " . $selectFields . " FROM " . self::table . " WHERE id='" . $id . "'";

		return $this->fetch($qry, 'object', true);
	}
	
	function delete($villeID) {
		if(empty($villeID)) { throw new Exception('Parameter 1 ($villeID) is empty'); }
		$qry = "DELETE FROM " . self::table . " WHERE id=".$villeID;
		return $this->fetch($qry,'update');
		
		
	}

	function gets($offset = 0, $limit = 10, $selectFields = "id, ville, cp", $type = 'object') {
		$qry = "SELECT " . $selectFields . " FROM " . self::table . " WHERE 1=1 order by ville ASC "; //LIMIT ".$offset.",".$limit;
		return $this->fetch($qry, $type);
	}

	function save($comp, $ID = null) {
		if (empty($comp)) {
			throw new Exception('Parameter 1 ($comp) is empty');
		}
		$date = date("Y-m-d H:i:s");

		if (isset($ID)) {
			//update
			$qry = 'UPDATE ' . self::table . ' set'
					. ' ville = "' . utf8_decode($comp->ville) . '",'
					. ' cp = "' . utf8_decode($comp->cp) . '"'
					. ' where id = "' . $ID . '"';

			$idMoment = $this->fetch($qry, 'update');
		} else {
			$qry = 'INSERT INTO ' . self::table . ' (ville, cp) VALUES(
						\'' . utf8_decode($comp->ville) . '\',
						\'' . utf8_decode($comp->cp) . '\'
					)';

			$idMoment = $this->fetch($qry, 'insert');
		}
		$this->generatejson();
		return $idMoment;
	}

	function generatejson() {
		$list = $this->gets(0, 0, "ville","array");
		foreach ($list as $value) {
			$tmp[] = $value[0];
		}
		$fp = fopen(dirname($_SERVER['SCRIPT_FILENAME']).'/data/ville.json', 'w+');
		fwrite($fp, json_encode($tmp));
		fclose($fp);
	}
	function generateselect() {
		$list = $this->gets(0, 0, "ville,id","array");
		foreach ($list as $value) {
			$tmp[] = array(
				'id' => $value['id'],
				'value' => $value['ville']
			);
		}
		return $tmp;
	}

}

?>