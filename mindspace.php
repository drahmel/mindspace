<?php defined('SYSPATH') OR die('No Direct Script Access');

Class Controller_MindSpace extends Controller
{ 
	const FNAME = "scene.json";
	
	public function action_index()
	{
		ini_set('memory_limit', '1990M');
		ini_set('display_errors', true);
		set_time_limit(0);
		$view = View::factory('mindspace/mindspace_index');
		$scene = $this->getScene();
		$view->set('scene', $scene);
		echo $view->render();
		exit;
	}
	public function action_admin()
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
	public function action_add()
	{
		$scene = $this->getScene();
		$scene['objects'][] = array(
			'name' => utils::getRequest('name'),
			'xyz' => array(utils::getRequest('x'), utils::getRequest('y'), utils::getRequest('z')),
			'type' => utils::getRequest('type'),
		);
		//utils::print_r($scene);
		$this->saveScene($scene);
		utils::redirect('/mindspace/admin',200);
		
	}
	function getScene() {
		$fname = "scene.json";
		if(!is_file($fname)) {
			$scene = array(
				'objects' => array(
					array('name' => 'obj1', 'xyz' => array(-10,0,0)),
					array('name' => 'obj2', 'xyz' => array(-10,-10,0)),
					array('name' => 'obj3', 'xyz' => array(-10,0,-10)),
				)
			);
			$this->saveScene($scene);
		} else {
			$json = file_get_contents($fname);
			$scene = json_decode($json, true);
		}
		return $scene;		
	}
	function saveScene($scene) {
		file_put_contents(self::FNAME, json_encode($scene));
	}
}
