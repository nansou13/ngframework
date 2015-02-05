<?php
function ngRequire($class_path)
{
	static $loaded_classes = array();

	if(!isset($loaded_classes[$class_path]))
	{
		if(file_exists($class_path)){
			$loaded_classes[$class_path] = true;
			require($class_path);
		}
	}
	return true;
}
?>