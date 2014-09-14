FormManager\Bootstrap
=====================

Created by Oscar Otero <http://oscarotero.com> <oom@oscarotero.com>

Requirements:

* PHP 5.4
* Composer or any PSR-4 autoloader


This is a extension of [FormManager](https://github.com/oscarotero/form-manager) library to generate bootstrap forms easily

Usage
---------------

```php
use FormManager\Bootstrap;

$myForm = Bootstrap::form([
	'name' => Bootstrap::text()->label('Your name'),
	'email' => Bootstrap::email()->label('Your email')
]);

echo $myForm;
```

You can generate horizontal forms and inline forms:

```php
use FormManager\Bootstrap;

$myHorizontalForm = Bootstrap::formHorizontal($fields);
$myInlineForm = Bootstrap::formInline($fields);
```

Use `set` method to customize each field. The available properties:

* size: (sm|lg) To create small/large fields
* addon-before: To insert an addon before the input
* addon-after: To insert an addon after the input
* help: To insert a help block before the input

```php
use FormManager\Bootstrap;

$myForm = Bootstrap::form([
	'name' => Bootstrap::text()->label('Your name')->set('size', 'lg'),
	'email' => Bootstrap::email()->label('Your email')->set([
		'addon-before' => '@',
		'help' => 'Insert here your email'
	])
]);

echo $myForm;
```

More information:

* [FormManager library](https://github.com/oscarotero/form-manager)
* [Bootstrap forms](http://getbootstrap.com/css/#forms)
