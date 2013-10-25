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
		camera = new BABYLON.FreeCamera("Camera", new BABYLON.Vector3(0, 0, -60), scene);
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
		matObj.emissiveColor = new BABYLON.Color3(params['color'][0], params['color'][1], params['color'][2]);
		if(params['alpha']!=undefined) {
			matObj.alpha = params['alpha'];
		}
		if(params['texture'] != undefined && params['texture'].length != 0) {
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
	if(params['rotatexyz'] != undefined) {
		obj.rotation = new BABYLON.Vector3(params['rotatexyz'][0], params['rotatexyz'][1], params['rotatexyz'][2]);
	}
	if(params['collision'] != undefined) {
		obj.checkCollisions = true;
	}
	if(params['portal'] != undefined) {
		obj.portal = params['portal'];
		portalObjects.push(obj);
	}
	if(params['animation'] != undefined) {
		var numFrames = addAnimation(obj, params);
		scene.beginAnimation(obj, 0, numFrames, true);
	}
}

function addAnimation(obj, params) {
	var numFrames = 0;
	if(params['animation'] == 'breathe') {
		var animationBox = new BABYLON.Animation(
			name+"_anim", "scaling.x", 30,
			BABYLON.Animation.ANIMATIONTYPE_FLOAT,
			BABYLON.Animation.ANIMATIONLOOPMODE_CYCLE
		);
		var keys = [];  
		var breathe_min = (params['breathe_min'] != undefined) ? parseFloat(params['breathe_min']) : 0.2;
		var breathe_max = (params['breathe_max'] != undefined) ? parseFloat(params['breathe_max']) : 1;
		keys.push({ frame: 0, value: breathe_max });
		keys.push({ frame: 20, value: breathe_min });
		keys.push({ frame: 100, value: breathe_max });
		animationBox.setKeys(keys);
		obj.animations.push(animationBox);
		numFrames = 100;
	} else if(params['animation'] == 'move') {
		var animationBox = new BABYLON.Animation(
			name+"_anim", "position.x", 60,
			BABYLON.Animation.ANIMATIONTYPE_FLOAT,
			BABYLON.Animation.ANIMATIONLOOPMODE_CYCLE
		);
		var keys = [];  
		keys.push({ frame: 0, value: 1 });
		keys.push({ frame: 100, value: 100 });
		keys.push({ frame: 200, value: 1 });
		animationBox.setKeys(keys);
		obj.animations.push(animationBox);
		numFrames = 200;
	}
	return numFrames;
}

function addSphere(params) {
	var segments = (params['segments'] != undefined) ? params['segments'] : 10;
	var width = (params['width'] != undefined) ? params['width'] : 1;
	var obj = BABYLON.Mesh.CreateSphere(params['name'], segments, width, scene);
	var materialSphere2 = new BABYLON.StandardMaterial("texture1", scene);		
	addParams(obj, params);
	objDom[name] = obj;
	console.log(obj);
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

function addSkybox(skyboxName, postId) {
	// Skybox
	var skybox = BABYLON.Mesh.CreateBox("skyBox", 1000.0, scene);
	var skyboxMaterial = new BABYLON.StandardMaterial("skyBox", scene);

//	var postId = 0; // post_id to use for tinting.  152712 -- red.  375914 -- blue.  906805 -- pink

	// Which skybox to use?
//	var skyboxName = 'snowbox';
//	var skyboxName = 'lavabox';
//	var skyboxName = 'cloudbox';

	skyboxMaterial.backFaceCulling = false;
	skyboxMaterial.reflectionTexture = new BABYLON.CubeTexture("/services/mindspace/skybox?post_id="+postId+"&file="+skyboxName, scene);
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
	if(false) {
		var ground = BABYLON.Mesh.CreatePlane("ground", 20.0, scene);
		ground.material = new BABYLON.StandardMaterial("groundMat", scene);
		ground.material.diffuseColor = new BABYLON.Color3(1,1,1);
		ground.material.backFaceCulling = false;
		ground.position = new BABYLON.Vector3(5, -10, -15);
		ground.rotation = new BABYLON.Vector3(Math.PI / 2, 0, 0);
	}
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
function addPlane(params) {
	var size = (params['size'] != undefined) ? params['size'] : 50.0;
	var obj = BABYLON.Mesh.CreatePlane(params['name'], size, scene);
	obj.rotation = new BABYLON.Vector3(Math.PI / 2, 0, 0);
	addParams(obj, params);
	objDom[name] = obj;
	return obj;
}
function addEmitter(params) {
	var particle = (params['particle'] != undefined) ? params['particle'] : "/images/mindspace/Flare.png";
	var fountain = BABYLON.Mesh.CreateBox("fountain", .1, scene);
	var particleSystem = new BABYLON.ParticleSystem("particles", 4000, scene);
	particleSystem.particleTexture = new BABYLON.Texture(particle, scene);
	particleSystem.textureMask = new BABYLON.Color4(0.1, 0.8, 0.8, 1.0);
	particleSystem.emitter = fountain;
	particleSystem.color1 = new BABYLON.Color4(1.0, 1.0, 1.0, 1.0);
	particleSystem.color2 = new BABYLON.Color4(0.2, 0.5, 1.0, 1.0);
	particleSystem.colorDead = new BABYLON.Color4(0, 0, 0.2, 0.0);
	particleSystem.minSize = 0.1;
	particleSystem.maxSize = 0.5;
	particleSystem.minLifeTime = 0.3;
	particleSystem.maxLifeTime = 5.5;
	particleSystem.emitRate = 500;
	particleSystem.blendMode = BABYLON.ParticleSystem.BLENDMODE_ONEONE;
	particleSystem.gravity = new BABYLON.Vector3(0, -9.81, 0);
	particleSystem.direction1 = new BABYLON.Vector3(-7, -8, 3);
	particleSystem.direction2 = new BABYLON.Vector3(7, -8, -3);
	particleSystem.minAngularSpeed = 0;
	particleSystem.maxAngularSpeed = Math.PI;
	particleSystem.minEmitPower = 1;
	particleSystem.maxEmitPower = 3;
	particleSystem.minEmitBox = new BABYLON.Vector3(-60, 0, -60); // Starting all From
	particleSystem.maxEmitBox = new BABYLON.Vector3(60, 0, 60); // To...
	
	particleSystem.updateSpeed = 0.005;
	//fountain = obj;
	addParams(fountain, params);
	particleSystem.start();
}
