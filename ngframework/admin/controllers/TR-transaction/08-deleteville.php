<?php
class ATR08 extends Action
{
    function init()
    {
		ngRequire('DAO/villeDAO.php');
    }
	
    function launch(Request $request, Response $response)
    {
		
		
        $this->has_css = true;
		$this->has_js = true;

		if(isset($_POST['villeID'])){
			if($_POST['villeID']==''){
				echo 'error'; die();
			}
			$productDAO = new villeDAO();
			$idMandat = $productDAO->delete($_POST['villeID']);
			echo $idMandat; die();
		}
		
		$param = $request->getParam();
		$villeID = $param[0];
		
		$productDAO = new villeDAO();
		$productinfo = $productDAO->getInfo($villeID);

		$response->productInfo = $productinfo;
		
        $this->render($this->controllerName, $this->methodeName);
        $this->printOut();
    }
}
?>
