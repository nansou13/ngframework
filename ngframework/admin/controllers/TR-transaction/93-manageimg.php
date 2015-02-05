<?php

class ATR93 extends Action {
	function init() {
		ngRequire('DAO/transactionDAO.php');
	}

	function launch(Request $request, Response $response) {
		$this->has_css = true;
		$this->has_js = false;
		if(isset($_POST['getimglist'])){
			$productDAO = new productDAO();
			$mandatID = $_POST['id'];
			$htmlContent = "";
			
			$orderBDD = $productDAO->getInfo($mandatID, 'orderimg');
			$arrayOrderBDD = explode(',',$orderBDD->orderimg);		

			$folderW = str_replace('admin','monagence',$_SERVER["DOCUMENT_ROOT"]);       
			$urlAbs = $folderW . '/_img/mandatimg/' . $mandatID . '/';
			

			$toto = $this->get_files_names($urlAbs);		

			$arrayOrderBDD = array_intersect($arrayOrderBDD, $toto);

			$realOrder = $arrayOrderBDD + array_diff($toto,$arrayOrderBDD);

			$nbrPhoto = $this->count_files($urlAbs);
			
			foreach($realOrder as $valueOrder){
				$nbFormat = $valueOrder;
				$htmlContent .='<tr id="'.$nbFormat.'"><td>'.$nbFormat.'</td><td><img src="http://transaction.immextenso.fr/LD/IM/globals/mandatimg/'.$mandatID.'/mini/'.$nbFormat.'.jpg?'.time().'"</td></tr>';
			}
			echo $htmlContent;
			
		}
		if(isset($_POST['order'])){
			$productDAO = new productDAO();
			$order = $productDAO->saveOrderImg($_POST['id'], $_POST['order']);
			/*$mandatID = $_POST['id'];

			$folderW = str_replace('admin','monagence',dirname($_SERVER['SCRIPT_FILENAME']));
			$urlAbs = $folderW . '/_img/mandatimg/' . $mandatID . '/';
			$nbrPhoto = $this->count_files($urlAbs);

			$arrayOrderImg = explode(',',$_POST['order']);			
var_dump($arrayOrderImg);
			for($i = 1; $i <= $nbrPhoto; $i++){
				$newI = str_pad($i, 2, '0', STR_PAD_LEFT);
				if($arrayOrderImg[$i-1] == $newI){
					var_dump($arrayOrderImg[$i-1].' -> OK');
				}else{
					var_dump($arrayOrderImg[$i-1].' -> RENAME EN '.$newI);
				}
			}
			*/
			
		}

		
		die();
	}
public function count_files($dir) {
		$num = 0;
		if (is_dir($dir)) {
			$dir_handle = opendir($dir);
			while ($entry = readdir($dir_handle))
				if (is_file($dir . '/' . $entry))
					$num++;
			closedir($dir_handle);
		}
		return $num;
	}


public function get_files_names($dir) {
		$arrayName = array();
		if (is_dir($dir)) {
			$dir_handle = opendir($dir);
			while ($entry = readdir($dir_handle))
				if (is_file($dir . '/' . $entry)){
					$TfileName = explode('.',$entry);
					$arrayName[] = $TfileName[0];
				}
			closedir($dir_handle);
		}
		return $arrayName;
	}

}
?>
