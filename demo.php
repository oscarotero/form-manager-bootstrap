<?php 
require 'vendor/autoload.php';

use FormManager\Bootstrap;

$form = Bootstrap::form([
	'name' => Bootstrap::text()->label('O teu nome')->set(['size' => 'lg']),
	'email' => Bootstrap::email()->label('Email')->set([
		'addon-after' => '@',
		//'size' => 'sm',
		'help' => 'Helping text'
	]),
	'private' => Bootstrap::checkbox()->label('Private'),
	'private2' => Bootstrap::checkbox()->label('Private2')->disabled(),
	'names' => Bootstrap::select()->label('Names')->options([
		1 => 'Laura',
		2 => 'Oscar'
	]),
	'reset' => Bootstrap::submit()->val('ola')->html('ola'),
	'submit' => Bootstrap::submit()->html('Send')
]);
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="bower_components/bootstrap/dist/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="bower_components/bootstrap/dist/css/bootstrap-theme.css">
</head>

<body>
	<div class="container">
		<?php echo $form; ?>
	</div>
</body>
</html>