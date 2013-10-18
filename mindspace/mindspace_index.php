<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Mindscape</title>

    <!--Loading babylon engine -->
    <script src="/ui/js/babylon.js"></script>
    <script src="/ui/js/hand.js"></script>


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
        var light0 = new BABYLON.PointLight("Omni", new BABYLON.Vector3(0, 0, 10), scene);
        var plan = BABYLON.Mesh.CreatePlane("Plane", 50.0, scene);
        //plan.position = new BABYLON.Vector3(0, 50, 0);
        // Creating a sphere of size 1, at 0,0,0
	<?php foreach($scene['objects'] as $object): ?>
		<?php
		$type = isset($object['type']) ? $object['type'] : 1; 
		if($type==1) {
			echo 'var origin = BABYLON.Mesh.CreateSphere("' . $object['name'] . '", 10, 1.0, scene);';
			echo 'var materialSphere2 = new BABYLON.StandardMaterial("texture1", scene);';
			echo 'materialSphere2.diffuseTexture = new BABYLON.Texture("http://a1.s6img.com/cdn/0018/p/6808232_14801161_ir.jpg", scene);';
			//echo 'origin.material = materialSphere2;';
		} elseif($type==2) {
			echo 'var origin = BABYLON.Mesh.CreateBox("' . $object['name'] . '", 6.0, scene);';			
			echo 'origin.rotation.x = Math.PI/4;';
			echo 'var materialSphere1 = new BABYLON.StandardMaterial("texture1", scene);';
			echo 'origin.material = materialSphere1;';
			echo 'materialSphere1.alpha = 0.5;';
			//echo 'materialSphere1.diffuseTexture = new BABYLON.Texture("http://a1.s6img.com/cdn/0018/p/6808232_14801161_ir.jpg", scene);';
		} elseif($type==3) {
			//echo 'var cylinder = BABYLON.Mesh.CreateCylinder("' . $object['name'] . '", 3, 3, 3, 6, scene, false);';
		} elseif($type==4) {
			//echo 'var torus = BABYLON.Mesh.CreateTorus("' . $object['name'] . '", 5, 1, 10, scene, false);';
		}
		?>
		
		origin.position = new BABYLON.Vector3(<?php echo $object['xyz'][0].','.$object['xyz'][1].','.$object['xyz'][2]; ?>);
	<?php endforeach; ?>

        // Attach the camera to the scene
        scene.activeCamera.attachControl(canvas);


        // Once the scene is loaded, just register a render loop to render it
        engine.runRenderLoop(function () {
            scene.render();
        });

    </script>


</html>
