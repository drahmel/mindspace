<?php
require(APP_PATH.'classes/mindspace.php');

class Controller_Admin {
	const FNAME = "scene.json";
	
	function _index() {
		ini_set('memory_limit', '1990M');
		ini_set('display_errors', true);
		set_time_limit(0);
		$view = new View(VIEW_PATH."admin/admin_index.php");
		$scene = mindspace::getScene(); //array('objects' => array());
		$view->set("scene", $scene);
		$view->set("username","Eric");
		echo $view->fetch();
	
		exit;
	}
	
	function _add()
	{
		$scene = mindspace::getScene();
		$name = utils::getRequest('name');
		$xyz =  array(utils::getRequest('x', 0.0), utils::getRequest('y', 0.0), utils::getRequest('z', 0.0));
		$user = utils::getRequest('user');
		$type = utils::getRequest('type');
		if(!empty($name) && !empty($type)) {
			$scene['objects'][] = array(
				'name' => $name,
				'xyz' => $xyz,
				'type' => $type,
			);
			ll::_("# of objects: ".count($scene['objects']));
			//utils::print_r($scene);
			mindspace::saveScene($scene);
		} else {
			ll::_("Empty name or type");
		}
		$url = '/admin';
		$url = (!empty($user))	?	$url . "?user=".$user	:	$url;
		if(false) {
			utils::redirect($url,200);
		} else {
			ll::_("Redirect to $url");
			echo ll::get_ll_html();
		}
		exit;
		
	}
}

