<?php
class APN02 extends Action
{
    function init()
    {
		ngRequire('DAO/productDAO.php');
    }
	
    function launch(Request $request, Response $response)
    {

        $this->has_css = true;
		$this->has_js = true;
		
		if(isset($_POST['mandat'])){
			if($_POST['mandat']==''){
				echo 'error'; die();
			}
				
			$productDAO = new productDAO();
			$idMandat = $productDAO->save($_POST['mandat']);
			echo $idMandat; die();
		}
		
        $this->render($this->controllerName, $this->methodeName);
        $this->printOut();
    }
}
?>
