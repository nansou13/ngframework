<?php
class APN99 extends Action
{
    
	
    function launch(Request $request, Response $response)
    {
        $this->has_css = true;
		$this->has_js = true;

        $this->render($this->controllerName, $this->methodeName);
        $this->printOut();
    }
}
?>
