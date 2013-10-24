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
	const OBJECT_TYPE_BALL = 1;
	const OBJECT_TYPE_BOX = 2;
	const OBJECT_TYPE_CYLINDER = 3;
	const OBJECT_TYPE_DONUT = 4;
	const OBJECT_TYPE_POINTLIGHT = 5;
	const OBJECT_TYPE_PICTURE = 6;

	static $objectTypes = array(
		self::OBJECT_TYPE_BALL => 'Ball',
		self::OBJECT_TYPE_BOX => 'Box',
		self::OBJECT_TYPE_CYLINDER => 'Cylinder',
		self::OBJECT_TYPE_DONUT => 'Donut',
		self::OBJECT_TYPE_POINTLIGHT => 'PointLight',
		self::OBJECT_TYPE_PICTURE => 'Picture',
	);

	static function getScene($sceneId) {
		$sceneId = (int)$sceneId;
		$fname = self::_getFName($sceneId);

		if (!is_file($fname)) {
			$scene = array(
				'scene_id' => $sceneId,
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
			self::saveScene($scene, $sceneId);

		} else {
			$json = file_get_contents($fname);
			$scene = json_decode($json, TRUE) ;
		}

		foreach ($scene['objects'] as $objId => $object) {
			$scene['objects'][$objId] = $object + self::getEmptyObject($object['type']);
		}

		return $scene;		
	}


	static function saveScene($scene, $sceneId) {
		$fname = self::_getFName($sceneId);
		file_put_contents($fname, json_encode($scene));
	}


	protected static function _getFName($sceneId) {
		$sceneId = (int)$sceneId;
		$fname = $sceneId ? "scene_$sceneId.json" : "scene_0.json";
		return PUB_PATH . 'spaces/mindspace/' .$fname;
	}


	static function getEmptyObject($type)
	{
		$objects = array(
			self::OBJECT_TYPE_BALL => array(
				'name' => 'New Ball',
				'width' => 3,
				'active' => TRUE,
				'texture' => '',
				'xyz' => array(0, 0, 0),
				'color' => array(0, 0, 0),
			),
			self::OBJECT_TYPE_BOX => array(
				'name' => 'New Box',
				'width' => 3,
				'alpha' => 1,
				'scaley' => 2,
				'active' => TRUE,
				'xyz' => array(0, 0, 0),
				'color' => array(0, 0, 0),
			),
			self::OBJECT_TYPE_CYLINDER => array(
				'name' => 'New Cylinder',
				'width' => 3,
				'scaley' => 2,
				#'widthtop' => 5,
				#'widthbottom' => 1,
				'active' => TRUE,
				'xyz' => array(0, 0, 0),
				'color' => array(0, 0, 0),
			),
			self::OBJECT_TYPE_DONUT => array(
				'name' => 'New Donut',
				'width' => 3,
				'collision' => 1,
				'active' => TRUE,
				'xyz' => array(0, 0, 0),
				'color' => array(0, 0, 0),
			),
			self::OBJECT_TYPE_POINTLIGHT => array(
				'name' => 'New PointLight',
				'active' => TRUE,
				'xyz' => array(0, 0, 0),
				'lightcolor' => array(0, 0, 0),
			),
			self::OBJECT_TYPE_PICTURE => array(
				'name' => 'New Picture',
				'width' => 8,
				'texture' => '',
				'active' => TRUE,
				'xyz' => array(0, 0, 0),
				'color' => array(.5, .5, 0),
			),
		);

		$object = isset($objects[$type]) ? $objects[$type] : $objects[self::OBJECT_TYPE_BALL];
		return $object + array('type' => $type);
	}
}
