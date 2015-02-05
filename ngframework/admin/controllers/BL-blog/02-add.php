<?php
class ABL02 extends Action
{
    function init()
    {
		ngRequire('DAO/blogDAO.php');
    }
	
    function launch(Request $request, Response $response)
    {

        $this->has_css = true;
		$this->has_js = true;
		
		if(isset($_POST['title'])){
			if($_POST['title']==''){
				echo 'error'; die();
			}
				
			$blogDAO = new blogDAO();
			$blogID = $blogDAO->save(utf8_decode($_POST['title']));
			echo $blogID; die();
		}
		
        $this->render($this->controllerName, $this->methodeName);
        $this->printOut();
    }
}
?>
