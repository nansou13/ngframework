<?php
class DAO {

	function __construct() {
        
    }

    function fetch($qry,$type='array', $justOne=false){
		$resultTot = null;
		$result = mysql_query($qry);
		if($type == 'insert'){
			return mysql_insert_id();
		}
		if($type == 'update'){
			return mysql_affected_rows();
		}
        // Recuperation des resultats
		$tmp = array();
		switch ($type){
			case 'array':
				if ($result) {
					if($justOne){
						$resultTot = @mysql_fetch_array($result);
					}else{
						while($a = @mysql_fetch_array($result)) { $tmp[] = $a; }
						$resultTot = $tmp;
					}
				}
				break;
			case 'object':
				if ($result) {
					if($justOne){
						$resultTot = @mysql_fetch_object($result);
					}else{
						while($a = @mysql_fetch_object($result)) { $tmp[] = $a; }
						$resultTot = $tmp;
					}
				}
				break;
		}

		return $resultTot;

    }

    
}
?>