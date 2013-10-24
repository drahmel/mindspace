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
var portalObjects = [];
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
	if(false) {
		camera = new BABYLON.ArcRotateCamera("Camera", 1, 0.8, 10, new BABYLON.Vector3(0, 0, 0), scene);
		camera.setPosition(new BABYLON.Vector3(-40, 40, 0));
	} else {
		camera = new BABYLON.FreeCamera("Camera", new BABYLON.Vector3(-20, 0, -60), scene);
	}
	// Creating a omnidirectional light
	//var light0 = new BABYLON.PointLight("Omni", new BABYLON.Vector3(0, 0, 10), scene);
	var sun = new BABYLON.PointLight("Omni0", new BABYLON.Vector3(60, 100, 10), scene);
	
	window.addEventListener("resize", function () {
		engine.resize();
	});
	
}

function addParams(obj, params) {
	if(params['xyz'] != undefined) {
		obj.position = new BABYLON.Vector3(params['xyz'][0], params['xyz'][1], params['xyz'][2]);
	}
	if(params['type'] != undefined) {
		obj.type = params['type'];
	}
	if(params['color']!=undefined) {
		var matName = params['name']+"_mat";
		var matObj = new BABYLON.StandardMaterial(matName, scene);
		matObj.diffuseColor = new BABYLON.Color3(params['color'][0], params['color'][1], params['color'][2]);
		if(params['alpha']!=undefined) {
			matObj.alpha = params['alpha'];
		}
		if(params['texture'] != undefined) {
			matObj.diffuseTexture = new BABYLON.Texture(params['texture'], scene);
			matObj.emissiveTexture = new BABYLON.Texture(params['texture'], scene);
			// new BABYLON.Texture(params['texture'], scene);
			if(params['texture_alpha'] != undefined) {
				matObj.diffuseTexture.hasAlpha = true;
			}
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
	if(params['scalex'] != undefined) {
		obj.scaling.x = params['scalex'];
	}
	if(params['scaley'] != undefined) {
		obj.scaling.y = params['scaley'];
	}
	if(params['scalez'] != undefined) {
		obj.scaling.z = params['scalez'];
	}
	if(params['collision'] != undefined) {
		obj.checkCollisions = true;
	}
	if(params['portal'] != undefined) {
		obj.portal = params['portal'];
		portalObjects.push(obj);
	}
	
}

function addSphere(params) {
	var segments = (params['segments'] != undefined) ? params['segments'] : 10;
	var width = (params['width'] != undefined) ? params['width'] : 1;
	var obj = BABYLON.Mesh.CreateSphere(params['name'], segments, width, scene);
	var materialSphere2 = new BABYLON.StandardMaterial("texture1", scene);		
	addParams(obj, params);
	objDom[name] = obj;
	return obj;
}


function addBox(params) {
	var width = (params['width'] != undefined) ? params['width'] : 1;
	var obj = BABYLON.Mesh.CreateBox(params['name'], width, scene);
	addParams(obj, params);
	objDom[name] = obj;
	return obj;
}
function addPicture(params) {
	var width = (params['width'] != undefined) ? params['width'] : 1;
	params['scalez'] = .05;
	//params['scalez'] = .1;
	
	var obj = BABYLON.Mesh.CreateBox(params['name'], width, scene);
	addParams(obj, params);
	objDom[name] = obj;
	return obj;
}

function addCylinder(params) {
	var segments = (params['segments'] != undefined) ? params['segments'] : 20;
	var width = (params['width'] != undefined) ? params['width'] : 1;
	var widthTop = (params['widthtop'] != undefined) ? params['widthtop'] : 0;
	var widthBottom = (params['widthbottom'] != undefined) ? params['widthbottom'] : 0;
	if(widthTop == 0 && widthBottom == 0) {
		widthTop = width;
		widthBottom = width;
	}
	var obj = BABYLON.Mesh.CreateCylinder(params['name'], widthTop, widthBottom, segments, scene, false);
	addParams(obj, params);
	objDom[name] = obj;
	return obj;
}
function addDonut(params) {
	var segments = (params['segments'] != undefined) ? params['segments'] : 20;
	var width = (params['width'] != undefined) ? params['width'] : 5;
	var thickness = (params['thickness'] != undefined) ? params['thickness'] : 1;
	var obj = BABYLON.Mesh.CreateTorus(params['name'], width, thickness, segments, scene, false);
	addParams(obj, params);
	objDom[name] = obj;
	return obj;
}
function addPointLight(params) {
	var lightx = 1;
	var lighty = 5;
	var lightz = 1;
	if(params['lightxyz']!=undefined) {
		lightx = params['lightxyz'][0];
		lighty = params['lightxyz'][1];
		lightz = params['lightxyz'][2];
	}
	var obj = new BABYLON.PointLight(name, new BABYLON.Vector3(lightx, lighty, lightz), scene);
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
function addGravity() {
	var ground = BABYLON.Mesh.CreatePlane("ground", 20.0, scene);
	ground.material = new BABYLON.StandardMaterial("groundMat", scene);
	ground.material.diffuseColor = new BABYLON.Color3(1,1,1);
	ground.material.backFaceCulling = false;
	ground.position = new BABYLON.Vector3(5, -10, -15);
	ground.rotation = new BABYLON.Vector3(Math.PI / 2, 0, 0);

    	console.log("Adding gravity");
    	scene.gravity = new BABYLON.Vector3(0, -0.1, 0);
	scene.collisionsEnabled = true;	
	//camera.checkCollisions = true;
	//scene.gravity = new BABYLON.Vector3(0, -9.81, 0);
	//camera.applyGravity = true;
	camera.ellipsoid = new BABYLON.Vector3(1, 1, 1);
}
function addCollision() {
    scene.registerBeforeRender(function () {

	if(false) {
		//Baloon 1 collision -- Precise = false
		if (balloon1.intersectsMesh(plan1, false)) {
			balloon1.material.emissiveColor = new BABYLON.Color4(1, 0, 0, 1);
		} else {
			balloon1.material.emissiveColor = new BABYLON.Color4(1, 1, 1, 1);
		}
	}

        var num = portalObjects.length;
        for(var i=0;i<num;i++) {
		if (portalObjects[i].intersectsPoint(camera.position)) {
		    portalObjects[i].material.emissiveColor = new BABYLON.Color4(1, 0, 0, 1);
		    window.location = portalObjects[i].portal;
		}
	}
	/*
        alpha += 0.01;
        balloon1.position.y += Math.cos(alpha) / 10;
        balloon2.position.y += Math.cos(alpha) / 10;
        balloon3.position.y += Math.cos(alpha) / 10;
        */
    });
}
function addSelection() {
	window.addEventListener("click", function (evt) {
		var pickResult = scene.pick(evt.clientX, evt.clientY);
		if(pickResult.hit == true) {
			if(pickResult.pickedMesh.type != undefined) {
				pickResult.pickedMesh.position.x += 10;
				console.log(pickResult);
				console.log(pickResult.pickedMesh.type);
			}
		}
		
	});	
}
function addPlane(name) {
	var plane = BABYLON.Mesh.CreatePlane(name, 50.0, scene);
	plane.position = new BABYLON.Vector3(0, 50, 0);
}
function addEmitter(name) {
	var fountain = BABYLON.Mesh.CreateBox("fountain", 0.1, scene);
	var particleSystem = new BABYLON.ParticleSystem("particles", 2000, scene);
	particleSystem.particleTexture = new BABYLON.Texture("/images/mindspace/Flare.png", scene);
	particleSystem.textureMask = new BABYLON.Color4(0.1, 0.8, 0.8, 1.0);
	particleSystem.emitter = fountain;
	particleSystem.color1 = new BABYLON.Color4(0.7, 0.8, 1.0, 1.0);
	particleSystem.color2 = new BABYLON.Color4(0.2, 0.5, 1.0, 1.0);
	particleSystem.colorDead = new BABYLON.Color4(0, 0, 0.2, 0.0);
	particleSystem.minSize = 0.1;
	particleSystem.maxSize = 0.5;
	particleSystem.minLifeTime = 0.3;
	particleSystem.maxLifeTime = 5.5;
	particleSystem.emitRate = 500;
	particleSystem.blendMode = BABYLON.ParticleSystem.BLENDMODE_ONEONE;
	particleSystem.gravity = new BABYLON.Vector3(0, -9.81, 0);
	particleSystem.direction1 = new BABYLON.Vector3(-7, 8, 3);
	particleSystem.direction2 = new BABYLON.Vector3(7, 8, -3);
	particleSystem.minAngularSpeed = 0;
	particleSystem.maxAngularSpeed = Math.PI;
	particleSystem.minEmitPower = 1;
	particleSystem.maxEmitPower = 3;
	
	particleSystem.updateSpeed = 0.005;
	particleSystem.start();
}
