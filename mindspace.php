<?php defined('SYSPATH') OR die('No Direct Script Access');

Class Mindspace
{ 
	const FNAME = "scene.json";
	
	static function getScene() {
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
	static function saveScene($scene) {
		file_put_contents(self::FNAME, json_encode($scene));
	}
	static function getFName() {
		$user = utils::getRequest('user');
		$userPrefix = !empty($user)	?	$user.'_'	:	'';
		$fname = "scene".$userPrefix.".json";
		return $fname;
	}
}
