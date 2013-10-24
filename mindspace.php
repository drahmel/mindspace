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
	
	static function getScene($user) {
		$fname = self::_getFName($user);

		if (!is_file($fname)) {
			$scene = array(
				'user' => $user,
				'objects' => array(
					array('name' => 'Ball1', 'type' => 1, 'xyz' => array(-10,0,0), 'width' => 1, 'color' => array(0, 1, 0), 'active' => TRUE),
					array('name' => 'Ball2', 'type' => 1, 'xyz' => array(-10,-10,0), 'width' => 2, 'color' => array(0, 0, 1), 'active' => TRUE),
					array('name' => 'Ball3', 'type' => 1, 'xyz' => array(-10,0,-10), 'width' => 3, 'color' => array(1, 0, 0), 'active' => TRUE),
					// Box
					array('name' => 'Box1', 'type' => 2, 'xyz' => array(-20,0,-10), 'width' => 3, 'scaley'=>2, 'color' => array(1, 1, 0), 'active' => TRUE),
					// Cylinder
					array('name' => 'Cylinder1', 'type' => 3, 'xyz' => array(-20,0,-20), 'width' => 2, 'color' => array(1, 1, 1), 'active' => TRUE),
					// Donut
					array('name' => 'Donut1', 'type' => 4, 'xyz' => array(-20,-20,-20), 'width' => 2, 'collision' => 1, 'color' => array(0, 1, 1), 'active' => TRUE),
					// Point light
					array('name' => 'PointLight1', 'type' => 5, 'xyz' => array(-20,0,-10), 'lightcolor' => array(0, 1, 1), 'active' => TRUE),
					// Box
					array('name' => 'Box2', 'type' => 2, 'xyz' => array(-30,0,-10), 'width' => 3, 'color' => array(1, 1, 0), 'alpha' => 0.5, 'active' => TRUE),
					// Sphere
					array('name' => 'BallTexture1', 'type' => 1, 'xyz' => array(-40,0,-10), 'width' => 3, 'color' => array(0, 0, 1), 'texture' => "/images/mindspace/6808232_14801161_ir.jpg", 'active' => TRUE),
					// Sphere
					array('name' => 'BallTextureAlpha1', 'type' => 1, 'xyz' => array(-20,-10,-30), 'width' => 3, 'color' => array(0, 0, 1), 'texture' => "/images/mindspace/tree.png", 'texture_alpha' => 1, 'active' => TRUE),
					// Cylinder
					array('name' => 'Cylinder2', 'type' => 3, 'xyz' => array(-20,-10,-20), 'widthtop' => 5, 'widthbottom' => 1,'color' => array(1, 1, 1), 'active' => TRUE),
					// Picture
					array('name' => 'Picture1', 'type' => 6, 'xyz' => array(0, -20,-10), 'width' => 8, 'color' => array(.5, .5, 0), 'texture' => "/images/mindspace/tree.png", 'active' => TRUE),
				)
			);
			self::saveScene($scene, $user);

		} else {
			$json = file_get_contents($fname);
			$scene = json_decode($json, true);
		}

		return $scene;		
	}


	static function saveScene($scene, $userId) {
		$fname = self::_getFName($userId);
		file_put_contents($fname, json_encode($scene));
	}


	protected static function _getFName($userId) {
		$fname = $userId ? "scene_$userId.json" : "scene_0.json";
		return PUB_PATH . 'spaces/mindspace/' .$fname;
	}
}
