var objDom = {};
var canvas;
var engine;
var scene;
var camera;

function init(canvasId) {
        canvas = document.getElementById(canvasId);

        // Load BABYLON 3D engine and set the root directory
        engine = new BABYLON.Engine(canvas, true);

        //Create a new scene with a camera (mandatory), a light (better) and a sphere (to see the origin)
        scene = new BABYLON.Scene(engine);

        // Creating a camera looking to the zero point (0,0,0)
        camera = new BABYLON.ArcRotateCamera("Camera", 1, 0.8, 10, new BABYLON.Vector3(0, 0, 0), scene);
	// Creating a omnidirectional light
	//var light0 = new BABYLON.PointLight("Omni", new BABYLON.Vector3(0, 0, 10), scene);
	var plane = BABYLON.Mesh.CreatePlane("Plane", 50.0, scene);
	plane.position = new BABYLON.Vector3(0, 50, 0);
	var sun = new BABYLON.PointLight("Omni0", new BABYLON.Vector3(60, 100, 10), scene);

	camera.setPosition(new BABYLON.Vector3(-40, 40, 0));
	
}
function addSphere(name, x, y, z) {
	var obj = BABYLON.Mesh.CreateSphere(name, 10, 1.0, scene);
	var materialSphere2 = new BABYLON.StandardMaterial("texture1", scene);		
	obj.position = new BABYLON.Vector3(-10,0,0);
	objDom[name] = obj;
	return obj;
}

function addBox(name, x, y, z) {
	var obj = BABYLON.Mesh.CreateBox(name, 6.0, scene);
	obj.position = new BABYLON.Vector3(x, y, z);
	objDom[name] = obj;
	return obj;
}
function addTube(name, x, y, z) {
	var obj = BABYLON.Mesh.CreateCylinder(name, 3, 3, 20, scene, false);
	obj.position = new BABYLON.Vector3(x, y, z);
	objDom[name] = obj;
	return obj;
}
function addDonut(name, x, y, z) {
	var obj = BABYLON.Mesh.CreateTorus(name, 5, 1, 20, scene, false);
	obj.position = new BABYLON.Vector3(x, y, z);
	objDom[name] = obj;
	return obj;
}
function addPointLight(name, x, y, z) {
	var obj = new BABYLON.PointLight(name, new BABYLON.Vector3(1, 5, 1), scene);
	obj.diffuse = new BABYLON.Color3(1, 0, 0);
	obj.specular = new BABYLON.Color3(1, 1, 1);
	obj.position = new BABYLON.Vector3(x, y, z);
	objDom[name] = obj;
	return obj;
}
