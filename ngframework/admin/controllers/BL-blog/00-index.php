<?php
class ABL00 extends Action
{
    function init() {
		ngRequire('DAO/productDAO.php');
	}
	
    function launch(Request $request, Response $response)
    {
        $this->has_css = true;
        $this->has_js = true;
		
		$productDAO = new productDAO();
		
		if(isset($_POST['title'])){
			header('Content-type: text/html; charset=utf-8');
			$productDAO->saveBlog(utf8_decode($_POST['title']), html_entity_decode($_POST['content']));
			
		}
		
		
		$listBlog = $productDAO->getsBlog();
		
		$response->listBlog = $listBlog;
		$response->addMeta("viewport","width=1000px");
        $this->render($this->controllerName, $this->methodeName);
        $this->printOut();
    }
}
?>
