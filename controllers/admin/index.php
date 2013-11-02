<?php
require(APP_PATH.'classes/mindspace.php');

class Controller_Admin {
	const FNAME = "scene.json";
	
	function _index() {
		ini_set('memory_limit', '1990M');
		ini_set('display_errors', true);
		set_time_limit(0);
		$view = new View(VIEW_PATH."admin/admin_index.php");
		$sceneID = utils::getRequest('id', 1, 'int');
		$scene = mindspace::getScene($sceneID);
		$view->set("scene", $scene);
		$view->set("username","Eric");
		echo $view->fetch();
	
		exit;
	}
	
	function _add()
	{
		$sceneID = utils::getRequest('id', 1, 'int');
		$scene = mindspace::getScene($sceneID, false);
		$name = utils::getRequest('name');
		$xyz =  array(utils::getRequest('x', 0.0), utils::getRequest('y', 0.0), utils::getRequest('z', 0.0));
		$type = utils::getRequest('type');
		if(!empty($name) && !empty($type)) {
			$scene['objects'][$name] = array(
				'name' => $name,
				'xyz' => $xyz,
				'type' => $type,
				'active' => 1,
			);
			//utils::print_r($scene);
			mindspace::saveScene($scene);
		} else {
			ll::_("Empty name or type");
		}
		$url = '/admin';
		//$url = (!empty($sceneID))	?	$url . "?id=".$sceneID	:	$sceneID;
		if(true) {
			utils::redirect($url,200);
		} else {
			ll::_("Redirect to $url");
			echo ll::get_ll_html();
		}
		exit;
		
	}
}

