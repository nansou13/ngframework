<?php
class blogDAO extends DAO {

	const table = "mablog";

	function __construct() {
		
	}

	function save($title, $content=null,$id=null, $categ=1) {
		$date = date("Y-m-d H:i:s");
		if (isset($content)) {
			//update
			$qry = 'UPDATE mablog set';
			$qry.= ' title = "' . addslashes($title) . '"';
			$qry.= ' , content = "' . addslashes($content) . '"';
			$qry.= ' , categorie = "' . addslashes($categ) . '"';
			$qry.= ' where id = ' . $id . '';
			
			echo $qry;
			$idMoment = $this->fetch($qry, 'update');
			
			
		}else{
			$qry = 'INSERT INTO mablog (title, date) VALUES(
						\'' . addslashes($title) . '\',
						\'' . $date . '\'
					)';

			$idMoment = $this->fetch($qry, 'insert');
		}
		
		
		return $idMoment;
	}

	function get($ID) {

		$qry = "SELECT * FROM mablog WHERE id = " . $ID ;
		return $this->fetch($qry, 'object', true);
	}
	function gets() {
		$qry = "SELECT * FROM mablog";
		return $this->fetch($qry, 'object');
	}
	function getCategories() {
		$qry = "SELECT * FROM mablogcateg";
		return $this->fetch($qry, 'object');
	}
	function delete($ID) {
		if (empty($ID)) {
			throw new Exception('Parameter 1 ($ID) is empty');
		}
		$qry = "DELETE FROM mablog WHERE id=" . $ID;
		return $this->fetch($qry, 'update');
	}
}

?>