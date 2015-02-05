<?php
class APN98 extends Action
{
	
    function launch(Request $request, Response $response)
    {
        $this->has_css = true;
		$this->has_js = false;
		ngRequire('DAO/UploadHandler.php');
		
		$upload_handler = new UploadHandler();
		
        $this->render($this->controllerName, $this->methodeName);
        $this->fetchOut();
    }
}
?>
