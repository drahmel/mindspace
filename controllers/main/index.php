<?php

const FNAME = "scene.json";

function _index() {
	ini_set('memory_limit', '1990M');
	ini_set('display_errors', true);
	set_time_limit(0);
	$view = new View(VIEW_PATH."main/mindspace_index.php");
	$scene = array('objects' => array());
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
function getScene() {
	$fname = self::getFName();
	if(!is_file($fname)) {
		ll::_("No file: $fname");
		$scene = array(
			'objects' => array(
				array('name' => 'obj1', 'xyz' => array(-10,0,0)),
				array('name' => 'obj2', 'xyz' => array(-10,-10,0)),
				array('name' => 'obj3', 'xyz' => array(-10,0,-10)),
			)
		);
		$this->saveScene($scene);
	} else {
		ll::_("Get scene from file: $fname");
		$json = file_get_contents($fname);
		$scene = json_decode($json, true);
		ll::_("File has ".count($scene['objects'])." objects");
	}
	return $scene;		
}
function saveScene($scene) {
	file_put_contents(self::FNAME, json_encode($scene));
}
function getFName() {
	$user = utils::getRequest('user');
	$userPrefix = !empty($user)	?	$user.'_'	:	'';
	$fname = "scene".$userPrefix.".json";
	return $fname;
}
