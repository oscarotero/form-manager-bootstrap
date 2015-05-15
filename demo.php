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
	'date' =>	Bootstrap::group([
		'day' => Bootstrap::number()->min(1)->max(31)->label('Day'),
		'month' => Bootstrap::number()->min(1)->max(12)->label('Month'),
		'year' => Bootstrap::number()->min(1900)->max(2013)->label('Year')
	])->set([
		'columnSizing' => [
			'day' => 'col-sm-4 col-md-3', 
			'month' => 'col-sm-4 col-md-3', 
			'year' => 'col-sm-4 col-md-3'
		]
	]),
	'colors' => Bootstrap::choose([
		'red' => Bootstrap::radio()->label('Red'),
		'blue' => Bootstrap::radio()->label('Blue'),
		'green' => Bootstrap::radio()->label('Green')
	]),
	'reset' => Bootstrap::submit()->val('ola')->html('ola'),
	'submit' => Bootstrap::submit()->html('Send')
]);
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
</head>

<body>
	<div class="container">
		<?php echo $form; ?>
	</div>
</body>
</html>
