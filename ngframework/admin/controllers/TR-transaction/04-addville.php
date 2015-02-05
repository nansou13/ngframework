<?php
class ATR04 extends Action
{
    function init()
    {
		ngRequire('DAO/villeDAO.php');
    }
	
    function launch(Request $request, Response $response)
    {
        $this->has_css = true;
		$this->has_js = true;
	
		if(isset($_POST['ville'])){
			if($_POST['ville']==''){
				echo 'error'; die();
			}
				
			$productDAO = new villeDAO();
			
			$productComp = new stdClass();
			$productComp->ville = $_POST['ville'];
			$productComp->cp = $_POST['cp'];
			
			
			$idMandat = $productDAO->save($productComp);
			echo $idMandat; die();
		}
		
		
		
		
        $this->render($this->controllerName, $this->methodeName);
        $this->printOut();
    }
}
?>
