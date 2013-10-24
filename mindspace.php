<?php

/** @license
 *
 * Mindspace: WebGL Content Management System (CMS)
 * ----------------------------------------------
 * https://github.com/drahmel/mindspace
 *
 * Copyright (c) 2013, Dan Rahmel. All rights reserved.
 * Code provided under the MIT License:
 * https://github.com/drahmel/mindspace/blob/master/LICENSE-MIT
 *
 */


Class Mindspace
{ 
	const FNAME = "scene.json";
	
	static function getScene($addSampleData = FALSE) {
		$fname = self::getFName();
		if(!is_file(DAT_PATH.$fname)) {
			//ll::_("No file: $fname");
			$scene = array('objects' => array());
			if($addSampleData) {
				$scene['objects'] = array(
					array('name' => 'obj1', 'type' => 1, 'xyz' => array(-10,0,0), 'width' => 1, 'color' => array(0, 1, 0)),
					array('name' => 'obj2', 'type' => 1, 'xyz' => array(-10,-10,0), 'width' => 2, 'color' => array(0, 0, 1)),
					array('name' => 'obj3', 'type' => 1, 'xyz' => array(-10,0,-10), 'width' => 3, 'color' => array(1, 0, 0)),
					// Box
					array('name' => 'obj4', 'type' => 2, 'xyz' => array(-20,0,-10), 'width' => 3, 'scaley'=>2, 'color' => array(1, 1, 0)),
					// Cylinder
					array('name' => 'obj5', 'type' => 3, 'xyz' => array(-20,0,-20), 'width' => 2, 'color' => array(1, 1, 1)),
					// Donut
					array('name' => 'obj6', 'type' => 4, 'xyz' => array(-20,-20,-20), 'width' => 2, 'collision' => 1, 'color' => array(0, 1, 1)),
					// Point light
					array('name' => 'obj7', 'type' => 5, 'xyz' => array(-20,0,-10), 'lightcolor' => array(0, 1, 1)),
					// Box
					array('name' => 'obj8', 'type' => 2, 'xyz' => array(-30,0,-10), 'width' => 3, 'color' => array(1, 1, 0), 'alpha' => 0.5),
					// Sphere
					array('name' => 'obj9', 'type' => 1, 'xyz' => array(-40,0,-10), 'width' => 3, 'color' => array(0, 0, 1), 'texture' => "/images/mindspace/6808232_14801161_ir.jpg"),
					// Sphere
					array('name' => 'obj10', 'type' => 1, 'xyz' => array(-20,-10,-30), 'width' => 3, 'color' => array(0, 0, 1), 'texture' => "/images/mindspace/tree.png", 'texture_alpha' => 1 ),
					// Cylinder
					array('name' => 'obj11', 'type' => 3, 'xyz' => array(-20,-10,-20), 'widthtop' => 5, 'widthbottom' => 1,'color' => array(1, 1, 1)),
					// Picture
					array('name' => 'obj12', 'type' => 6, 'xyz' => array(0, -20,-10), 'width' => 8, 'color' => array(.5, .5, 0), 'texture' => "/images/mindspace/tree.png"),
				);
			}
			self::saveScene($scene);
		} else {
			//ll::_("Get scene from file: $fname");
			$json = file_get_contents(DAT_PATH.$fname);
			$scene = json_decode($json, true);
			//ll::_("File has ".count($scene['objects'])." objects");
		}
		return $scene;		
	}
	static function saveScene($scene) {
		file_put_contents(DAT_PATH.self::FNAME, json_encode($scene));
	}
	static function getFName() {
		$user = self::getRequest('user');
		$userPrefix = !empty($user)	?	$user.'_'	:	'';
		$fname = "scene".$userPrefix.".json";
		return $fname;
	}
	static function getRequest($varname,$defaultVal='',$varType='str',$mysqlEscape=false,$htmlDecode=false) {
		$outVal = $defaultVal;
		if(isset($_GET[$varname])) {
			$temp = $_GET[$varname];
		} elseif(isset($_POST[$varname])) {
			$temp = $_POST[$varname];
		} elseif(isset($_REQUEST[$varname])) {
			$temp = $_REQUEST[$varname];
		} else {
			return $outVal;
		}
		if($varType=='int') {
			$outVal = intval($temp);
		} elseif($varType=='float') {
			$outVal = floatval($temp);			
		} else {
			if($mysqlEscape) {
				$outVal = real_escape($temp);
			} else {
				$outVal = self::realEscape($temp);
			}
		}
		return $outVal;
	}

}
