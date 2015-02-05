<?php
class ATR05 extends Action
{
    function init()
    {
		ngRequire('DAO/villeDAO.php');
    }
	
    function launch(Request $request, Response $response)
    {
		
		
        $this->has_css = true;
		$this->has_js = true;
		
		$param = $request->getParam();
		$villeID = $param[0];
		
		if(isset($_POST['ville'])){
			if($_POST['ville']==''){
				echo 'error'; die();
			}
				
			$productDAO = new villeDAO();
			$productComp = new stdClass();
			
			$productComp->ville = $_POST['ville'];
			$productComp->cp = $_POST['cp'];
			
			
			$idMandat = $productDAO->save($productComp,$villeID);
			echo $idMandat; die();
		}
		
		
		$productDAO = new villeDAO();
		$productinfo = $productDAO->getInfo($villeID);
		
		$response->idville = $villeID;
		$response->productInfo = $productinfo;
		
        $this->render($this->controllerName, $this->methodeName);
        $this->printOut();
    }
}
?>
