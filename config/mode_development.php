<?php

/**
 * Development configuration
 * Usage:
 * - Local website
 * - Local DB
 * - Show all details on each error
 * - Gii module enabled
 */

return array(

	// Set YII_DEBUG and YII_TRACE_LEVEL flags
	'yiiDebug' => true,
	'yiiTraceLevel' => 3,
	
	'yiiSetPathOfAlias' => array(
		// uncomment the following to define a path alias
		//'local' => 'path/to/local-folder'
	),

	// This is the specific Web application configuration for this mode.
	// Supplied config elements will be merged into the main config array.
	'config' => array(
		'modules'=>array(
			'gii'=>array(
				'class'=>'system.gii.GiiModule',
				'password'=>'bonsan',
				// If removed, Gii defaults to localhost only. Edit carefully to taste.
				'ipFilters'=>array('127.0.0.1','::1'),
				'generatorPaths'=>array(
					'ext.gtc',   // Gii Template Collection
					'ext.bootstrap.gii',
					'ext.nii.gii',
				),
			),
			'dev'
		),
		'components'=>array(
			'log'=>array(
				'class'=>'CLogRouter',
				'routes'=>array(
					array(
						'class'=>'CFileLogRoute',
					),
					array(
						'class'=>'dev.widgets.yii-debug-toolbar.YiiDebugToolbarRoute',
					)
				),
			),
			// development mode we want to profile the database and have debug options
			'db'=>array(
				'schemaCachingDuration' => 86400,
				'enableProfiling'=>true,
				'enableParamLogging'=>true,
			),
		)
	),
);
