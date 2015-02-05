<?php
class ABL07 extends Action
{
    function init()
    {
		ngRequire('DAO/blogDAO.php');
    }
	
    function launch(Request $request, Response $response)
    {
		
		
        $this->has_css = true;
		$this->has_js = true;
		
		
		
		if(isset($_POST['mandatID'])){
			if($_POST['mandatID']==''){
				echo 'error'; die();
			}
			$blogDAO = new blogDAO();
			$idMandat = $blogDAO->delete($_POST['mandatID']);
			echo $idMandat; die();
		}
		
		$param = $request->getParam();
		$mandatID = $param[0];
		
		$blogDAO = new blogDAO();
		$bloginfo = $blogDAO->get($mandatID);

		$response->blogInfo = $bloginfo;
		
        $this->render($this->controllerName, $this->methodeName);
        $this->printOut();
    }
}
?>
