<?php

namespace Album;

use Zend\Router\Http\Segment;
//use Zend\ServiceManager\Factory\InvokableFactory;

return [
	'router' => [
		'routes' => [
			'album' => [
				'type' => Segment::class,
				'options' => [
					'route' => '/album[/:action[/:id]]',
					'constraints' => [
						'action' => '[a-zA-Z][a-zA-A0-9_-]*',
						'id' => '[0-9]+'
					],
					'defaults' => [
						'controller' => Controller\AlbumController::class,
						'action' => 'index'
					]
				]
			]
		]
	],
	'view_manager' => [
		'template_path_stack' => [
			'album' => __DIR__ . '/../view'
		]
	]
];