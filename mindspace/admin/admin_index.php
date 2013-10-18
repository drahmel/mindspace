<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Mindspace CMS</title>
	<link href="/ui/css/bootstrap.css" rel="stylesheet" type="text/css" />
	<link href="/ui/css/bootstrap-responsive.css" rel="stylesheet" type="text/css" />
	<style>
	html, body {
		background-color: darkgray;
		color: white;
	}
	</style>
</head>
<body>
<h1>Mindspace CMS</h1>

<?php foreach($scene['objects'] as $object): ?>
	<p><?php echo $object['name']; ?> = <?php echo $object['xyz'][0].','.$object['xyz'][1].','.$object['xyz'][2]; ?></p>
<?php endforeach; ?>

<form method="POST" action="/mindspace/add">
	<input name="name" placeholder="Enter name" value="obj<?php echo rand(1000,10000); ?>" />
	<input name="x" placeholder="x" value="<?php echo rand(-10,10); ?>" />
	<input name="y" placeholder="y" value="<?php echo rand(-10,10); ?>" />
	<input name="z" placeholder="z" value="<?php echo rand(-10,10); ?>" />
	<select name="type">
		<option value="1">Ball</option>
		<option value="2">Box</option>
		<option value="3">Tube</option>
		<option value="4">Torus</option>
	</select>
	<input type="submit" value="Add" />
</form>
