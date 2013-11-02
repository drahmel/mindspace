<?php
require(APP_PATH.'classes/mindspace.php');

class Controller_Main {
	const FNAME = "scene.json";
	
	function _index() {
		ini_set('memory_limit', '1990M');
		ini_set('display_errors', true);
		set_time_limit(0);
		$view = new View(VIEW_PATH."main/mindspace_index.php");
		$scene = mindspace::getScene(); //array('objects' => array());
		$view->set("scene", $scene);
		$view->set("username","Eric");
		echo $view->fetch();
	
		exit;
		/*
		$view = View::factory('mindspace/mindspace_index');
		$scene = $this->getScene();
		$view->set('scene', $scene);
		echo $view->render();
		exit;
		*/
	}
	function action_admin()
	{
		ini_set('memory_limit', '1990M');
		ini_set('display_errors', true);
		set_time_limit(0);
		$view = View::factory('mindspace/admin/admin_index');
		$scene = $this->getScene();
		$view->set('scene', $scene);
		echo $view->render();
		echo ll::get_ll_html();
		exit;
	}
	function action_add()
	{
		$scene = $this->getScene();
		$scene['objects'][] = array(
			'name' => utils::getRequest('name'),
			'xyz' => array(utils::getRequest('x'), utils::getRequest('y'), utils::getRequest('z')),
			'type' => utils::getRequest('type'),
		);
		//utils::print_r($scene);
		$this->saveScene($scene);
		$user = utils::getRequest('user');
		$url = '/mindspace/admin';
		$url = (!empty($user))	?	$url . "?user=".$user	:	$url;
		if(true) {
			utils::redirect($url,200);
		} else {
			ll::_("Redirect to $url");
			echo ll::get_ll_html();
		}
		exit;
		
	}
}
