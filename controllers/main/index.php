<?php
require(APP_PATH.'classes/mindspace.php');

class Controller_Main {
	
	function _index() {
		ini_set('memory_limit', '1990M');
		ini_set('display_errors', true);
		set_time_limit(0);
		$view = new View(VIEW_PATH."main/mindspace_index.php");
		$sceneID = utils::getRequest('id', 1, 'int');
		$scene = mindspace::getScene($sceneID);
		$view->set("scene", $scene);
		$view->set("username","Eric");
		ll::header_ll();
		echo $view->fetch();
		exit;
	}
}
