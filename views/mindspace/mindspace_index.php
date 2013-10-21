<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Mindscape</title>

    <!--Loading babylon engine -->
    <script src="/ui/js/mindspace/babylon.js?v=1" ></script>
    <!-- script src="http://www.babylonjs.com/tutorials/blogs/customShaders/babylon.js" ></script -->
    <script src="/ui/js/mindspace/hand.js"></script>


    <!-- CSS -->
    <!-- ------ -->
    <style>
        html, body, div, canvas {
            width: 100%;
            height: 100%;
            padding: 0;
            margin: 0;
            overflow: hidden;
        }
    </style>

</head>

<!-- BODY -->
<!-- ------ -->
<body>

    <div id="rootDiv">

        <!-- Main Canvas -->
        <canvas id="renderCanvas"></canvas>
    </div>

    </body>



    <!-- BABYLON SCRIPT -->
    <!-- -------------- -->
    <script type="text/javascript">

        // Get the Canvas element from our HTML below
        var canvas = document.getElementById("renderCanvas");

        // Load BABYLON 3D engine and set the root directory
        var engine = new BABYLON.Engine(canvas, true);

        //Create a new scene with a camera (mandatory), a light (better) and a sphere (to see the origin)
        var scene = new BABYLON.Scene(engine);

        // Creating a camera looking to the zero point (0,0,0)
        var camera = new BABYLON.ArcRotateCamera("Camera", 1, 0.8, 10, new BABYLON.Vector3(0, 0, 0), scene);
	// Creating a omnidirectional light
	//var light0 = new BABYLON.PointLight("Omni", new BABYLON.Vector3(0, 0, 10), scene);
	var plan = BABYLON.Mesh.CreatePlane("Plane", 50.0, scene);
	plan.position = new BABYLON.Vector3(0, 50, 0);
	var sun = new BABYLON.PointLight("Omni0", new BABYLON.Vector3(60, 100, 10), scene);

	camera.setPosition(new BABYLON.Vector3(-40, 40, 0));
        
        if(false) {
		var skybox = BABYLON.Mesh.CreateBox("skyBox", 100.0, scene);
		var skyboxMaterial = new BABYLON.StandardMaterial("skyBox", scene);
		skyboxMaterial.backFaceCulling = false;
		skybox.material = skyboxMaterial;
		skyboxMaterial.diffuseColor = new BABYLON.Color3(0, 0, 0);
		skyboxMaterial.specularColor = new BABYLON.Color3(0, 0, 0);
		skyboxMaterial.reflectionTexture = new BABYLON.CubeTexture("/ui/images/mindspace/skybox/skybox", scene);
		skyboxMaterial.reflectionTexture.coordinatesMode = BABYLON.Texture.SKYBOX_MODE;	
	} else {
            // Skybox
            var skybox = BABYLON.Mesh.CreateBox("skyBox", 1000.0, scene);
            var skyboxMaterial = new BABYLON.StandardMaterial("skyBox", scene);
            skyboxMaterial.backFaceCulling = false;
            skyboxMaterial.reflectionTexture = new BABYLON.CubeTexture("/ui/images/mindspace/skybox/skybox", scene);
            skyboxMaterial.reflectionTexture.coordinatesMode = BABYLON.Texture.SKYBOX_MODE;
            skyboxMaterial.diffuseColor = new BABYLON.Color3(0, 0, 0);
            skyboxMaterial.specularColor = new BABYLON.Color3(0, 0, 0);
            skybox.material = skyboxMaterial;
		
	}
        // Creating a sphere of size 1, at 0,0,0
	<?php foreach($scene['objects'] as $object): ?>
		<?php
		$type = isset($object['type']) ? $object['type'] : 1;
		$objectName = 'o_'.$object['name'];
		if($type==1) {
			echo 'var '.$objectName.' = BABYLON.Mesh.CreateSphere("' . $object['name'] . '", 10, 1.0, scene);';
			echo 'var materialSphere2 = new BABYLON.StandardMaterial("texture1", scene);';
			//echo 'materialSphere2.diffuseTexture = new BABYLON.Texture("http://a1.s6img.com/cdn/0018/p/6808232_14801161_ir.jpg", scene);';
			//echo $objectName.'.material = materialSphere2;';
		} elseif($type==2) {
			echo 'var '.$objectName.' = BABYLON.Mesh.CreateBox("' . $object['name'] . '", 6.0, scene);';			
			echo $objectName.'.rotation.x = Math.PI/4;';
			echo 'var materialSphere1 = new BABYLON.StandardMaterial("texture1", scene);';
			echo $objectName.'.material = materialSphere1;';
			echo 'materialSphere1.alpha = 0.5;';
			//echo 'materialSphere1.diffuseTexture = new BABYLON.Texture("http://a1.s6img.com/cdn/0018/p/6808232_14801161_ir.jpg", scene);';
		} elseif($type==3) {
			echo 'var o_'.$object['name'].' = BABYLON.Mesh.CreateCylinder("' . $object['name'] . '", 3, 3, 20, scene, false);';
		} elseif($type==4) {
			echo 'var o_'.$object['name'].' = BABYLON.Mesh.CreateTorus("' . $object['name'] . '", 5, 1, 20, scene, false);';
		} elseif($type==5) {
			echo 'var '.$objectName.' = new BABYLON.PointLight("Omni0", new BABYLON.Vector3(1, 5, 1), scene);
				'.$objectName.'.diffuse = new BABYLON.Color3('.rand(0,1).', '.rand(0,1).', '.rand(0,1).');
				'.$objectName.'.specular = new BABYLON.Color3(1, 1, 1);';
		} else {
			echo 'var '.$objectName.' = BABYLON.Mesh.CreateSphere("' . $object['name'] . '", 10, 1.0, scene);';	
		}
		?>
		
		<?php echo $objectName ?>.position = new BABYLON.Vector3(<?php echo $object['xyz'][0].','.$object['xyz'][1].','.$object['xyz'][2]; ?>);
	<?php endforeach; ?>

        // Attach the camera to the scene
        scene.activeCamera.attachControl(canvas);

       
var beforeRenderFunction = function () {
                // Camera
                if (camera.beta < 0.1)
                    camera.beta = 0.1;
                else if (camera.beta > (Math.PI / 2) * 0.9)
                    camera.beta = (Math.PI / 2) * 0.9;

                if (camera.radius > 50)
                    camera.radius = 50;

                if (camera.radius < 5)
                    camera.radius = 5;
            };
            //scene.registerBeforeRender(beforeRenderFunction);

        // Once the scene is loaded, just register a render loop to render it
        engine.runRenderLoop(function () {
            scene.render();
        });

    </script>


</html>
