<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Mindscape</title>
    <link rel="shortcut icon" href='/favicon.ico' />
    <script src="/js/mindspace/babylon.js?v=1" ></script>
    <script src="/js/mindspace/hand.js"></script>
    <script src="/js/mindspace/core.js"></script>

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
		<canvas id="renderCanvas"></canvas>
	</div>
</body>



<script type="text/javascript">
    	init("renderCanvas");
	var addMethods = {1:'addSphere', 2:'addBox', 3:'addCylinder', 4:'addDonut', 5:'addPointLight', 6:'addPicture', 7:'addPlane', 10:'addEmitter'};

	<?php
	echo "var sceneData = JSON.parse('".json_encode($scene)."');\n";
	?>
	for(var i in sceneData['objects']) {
		var curObj = sceneData['objects'][i];
		if (curObj['type'] in addMethods) {
			var cmd = addMethods[curObj['type']];
			window[cmd](curObj);
		}
	}
        // Attach the camera to the scene
        scene.activeCamera.attachControl(canvas);
        addSelection();
               
	var beforeRenderFunction = function () {
		// Camera
		if (camera.beta < 0.1) {
			camera.beta = 0.1;
		} else if (camera.beta > (Math.PI / 2) * 0.9) {
			camera.beta = (Math.PI / 2) * 0.9;
		}
		
		if (camera.radius > 50) {
			camera.radius = 50;
		}
		
		if (camera.radius < 5) {
			camera.radius = 5;
		}
	};
	//scene.registerBeforeRender(beforeRenderFunction);
	
	// Once the scene is loaded, just register a render loop to render it
	engine.runRenderLoop(function () {
		scene.render();
	});

</script>


</html>
