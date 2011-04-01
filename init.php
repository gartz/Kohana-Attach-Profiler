<?php defined('SYSPATH') or die('No direct access allowed.');

Route::set('profiler', 'profiler(/<route>)',
	array(
		'route' => '.*'
	))
	->defaults(array(
		'controller' => 'profiler',
		'action'     => 'index',
		'route'      => '/',
		'profiler'   => 'profiler',
	));