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

var objDom = {};
var canvas;
var engine;
var scene;
var camera;
var version = 0.1;

function init(canvasId) {
        canvas = document.getElementById(canvasId);

        // Load BABYLON 3D engine and set the root directory
        engine = new BABYLON.Engine(canvas, true);

        // Create a new scene with a camera (mandatory), a light (better) and a sphere (to see the origin)
        scene = new BABYLON.Scene(engine);

        // Creating a camera looking to the zero point (0,0,0)
        camera = new BABYLON.ArcRotateCamera("Camera", 1, 0.8, 10, new BABYLON.Vector3(0, 0, 0), scene);
	// Creating a omnidirectional light
	//var light0 = new BABYLON.PointLight("Omni", new BABYLON.Vector3(0, 0, 10), scene);
	var sun = new BABYLON.PointLight("Omni0", new BABYLON.Vector3(60, 100, 10), scene);

	camera.setPosition(new BABYLON.Vector3(-40, 40, 0));
	
}

function addParams(obj, params) {
	if(params['xyz']!=undefined) {
		obj.position = new BABYLON.Vector3(params['xyz'][0], params['xyz'][1], params['xyz'][2]);
	}
	if(params['color']!=undefined) {
		var matName = params['name']+"_mat";
		var matObj = new BABYLON.StandardMaterial(matName, scene);
		matObj.diffuseColor = new BABYLON.Color3(params['color'][0], params['color'][1], params['color'][2]);
		if(params['alpha']!=undefined) {
			matObj.alpha = params['alpha'];
		}
		if(params['texture']!=undefined) {
			//matObj.diffuseTexture = new BABYLON.Texture(params['texture'], scene);
			//echo 'materialSphere2.diffuseTexture = new BABYLON.Texture("http://a1.s6img.com/cdn/0018/p/6808232_14801161_ir.jpg", scene);';
			//echo $objectName.'.material = materialSphere2;';
		}
		obj.material = matObj;
		objDom[matName] = matObj;
	}
	if(params['rotate']!=undefined) {
		obj.rotation.x = Math.PI/4;
	}
	if(params['lightcolor']!=undefined) {
		obj.diffuse = new BABYLON.Color3(1, 0, 0);
		obj.specular = new BABYLON.Color3(1, 0, 0);
	}

}

function addSphere(params) {
	var obj = BABYLON.Mesh.CreateSphere(params['name'], 10, params['radius'], scene);
	var materialSphere2 = new BABYLON.StandardMaterial("texture1", scene);		
	addParams(obj, params);
	objDom[name] = obj;
	return obj;
}


function addBox(params) {
	var obj = BABYLON.Mesh.CreateBox(params['name'], params['width'], scene);
	addParams(obj, params);
	objDom[name] = obj;
	return obj;
}
function addCylinder(params) {
	var obj = BABYLON.Mesh.CreateCylinder(params['name'], 3, 3, 20, scene, false);
	addParams(obj, params);
	objDom[name] = obj;
	return obj;
}
function addDonut(params) {
	var obj = BABYLON.Mesh.CreateTorus(params['name'], 5, 1, 20, scene, false);
	addParams(obj, params);
	objDom[name] = obj;
	return obj;
}
function addPointLight(params) {
	var obj = new BABYLON.PointLight(name, new BABYLON.Vector3(1, 5, 1), scene);
	addParams(obj, params);
	objDom[name] = obj;
	return obj;
}

function addFog() {
	scene.fogMode = BABYLON.Scene.FOGMODE_EXP;
	//BABYLON.Scene.FOGMODE_NONE;
	//BABYLON.Scene.FOGMODE_EXP;
	//BABYLON.Scene.FOGMODE_EXP2;
	//BABYLON.Scene.FOGMODE_LINEAR;
	
	scene.fogColor = new BABYLON.Color3(0.9, 0.9, 0.85);
	scene.fogDensity = 0.01;
	
	//Only if LINEAR
	//scene.fogStart = 20.0;
	//scene.fogEnd = 60.0;
	var alpha = 0;
	if(false) {
		scene.registerBeforeRender(function () {
			scene.fogDensity = Math.cos(alpha)/10;
			alpha+=0.02;
		});
	}
}

function addSkybox() {
	// Skybox
	var skybox = BABYLON.Mesh.CreateBox("skyBox", 1000.0, scene);
	var skyboxMaterial = new BABYLON.StandardMaterial("skyBox", scene);
	skyboxMaterial.backFaceCulling = false;
	skyboxMaterial.reflectionTexture = new BABYLON.CubeTexture("/images/mindspace/skybox/skybox", scene);
	skyboxMaterial.reflectionTexture.coordinatesMode = BABYLON.Texture.SKYBOX_MODE;
	skyboxMaterial.diffuseColor = new BABYLON.Color3(0, 0, 0);
	skyboxMaterial.specularColor = new BABYLON.Color3(0, 0, 0);
	skybox.material = skyboxMaterial;
	if(false) {
		var skybox = BABYLON.Mesh.CreateBox("skyBox", 100.0, scene);
		var skyboxMaterial = new BABYLON.StandardMaterial("skyBox", scene);
		skyboxMaterial.backFaceCulling = false;
		skybox.material = skyboxMaterial;
		skyboxMaterial.diffuseColor = new BABYLON.Color3(0, 0, 0);
		skyboxMaterial.specularColor = new BABYLON.Color3(0, 0, 0);
		skyboxMaterial.reflectionTexture = new BABYLON.CubeTexture("/images/mindspace/skybox/skybox", scene);
		skyboxMaterial.reflectionTexture.coordinatesMode = BABYLON.Texture.SKYBOX_MODE;	
	}
}	

function addCameraRestriction() {
	var beforeRenderFunction = function () {
		// Camera
		if (camera.beta < 0.1)
			camera.beta = 0.1;
		else if (camera.beta > (Math.PI / 2) * 0.9)
			camera.beta = (Math.PI / 2) * 0.9;
		
		if (camera.radius > 50) {
			camera.radius = 50;
		}
		
		if (camera.radius < 5) {
			camera.radius = 5;
		}
	};
	scene.registerBeforeRender(beforeRenderFunction);	
}

function addPlane(name) {
	var plane = BABYLON.Mesh.CreatePlane(name, 50.0, scene);
	plane.position = new BABYLON.Vector3(0, 50, 0);
}
