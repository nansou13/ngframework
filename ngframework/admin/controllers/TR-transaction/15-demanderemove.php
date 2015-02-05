<?php
class ATR15 extends Action
{
    function init()
    {
		ngRequire('DAO/transactionDAO.php');
    }
	
    function launch(Request $request, Response $response)
    {
		
		
        $this->has_css = true;
		$this->has_js = true;
		
		
		
		if(isset($_POST['mandatID'])){
			if($_POST['mandatID']==''){
				echo 'error'; die();
			}
			$productDAO = new productDAO();
			$idMandat = $productDAO->deleteDemande($_POST['mandatID']);
			echo $idMandat; die();
		}
		
		$param = $request->getParam();
		$mandatID = $param[0];
		
		$productDAO = new productDAO();

		$productinfo = $productDAO->getInfoDemande($mandatID);
		$response->productInfo = $productinfo;
		
        $this->render($this->controllerName, $this->methodeName);
        $this->printOut();
    }
}
?>
