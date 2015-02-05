<?php
class A0000 extends Action
{
    
	
    function launch(Request $request, Response $response)
    {
        $this->has_css = true;
        $this->has_js = true;
		/*View::addJsFile('includes', 'charts/excanvas.min');
		View::addJsFile('includes', 'charts/jquery.flot.min');
		View::addJsFile('includes', 'charts/jquery.flot.resize.min');
		View::addJsFile('includes', 'charts/jquery.flot.pie.min');
		View::addJsFile('includes', 'jquery.sparkline.min');*/

        $this->render($this->controllerName, $this->methodeName);
        $this->printOut();
    }
}
?>
