<?php
require_once __DIR__ . '/Classes/Asset.php';

$assets = [
	'name-of-your-theme-or-plugin' => [
		'assets-directory-in-theme-or-plugin-root' => [
			'css' => [
				'foundation' => [
					'src' => 'css/foundation.css',
					'deps' => [],
					'ver' => '6.0.0',
					'media' => 'screen'
				],
                'main-stylesheet' => [
                    'src' => 'css/main.css',
					'deps' => ['foundation'],
					'ver' => '0.0.1',
					'media' => 'screen'
                ]
			],
			'js' => [
                'modernizr' => [
					'src' => 'js/modernizr.js',
					'deps' => [],
					'ver' => '5.3.0',
					'in_footer' => false
				],
				'main' => [
					'src' => 'js/main.js',
					'deps' => ['jquery'],
					'ver' => '0.0.1',
					'in_footer' => true
				]
			]
		]
	]
];
new Asset($assets, 'theme');
