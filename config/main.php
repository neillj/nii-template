<?php
$base = realpath(dirname(__DIR__));
$htdocs = realpath("$base/htdocs");
$app = realpath("$base/vendor/newicon/nii");
$modules = realpath("$base/vendor/newicon/nii/modules");
$localmodules = realpath("$base/modules");
$commmodules = realpath("$base/vendor/nii-modules");
$nii = realpath("$modules/nii");
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	// Set YII_DEBUG and YII_TRACE_LEVEL flags
	'yiiDebug' => true,
	'yiiTraceLevel' => 0,
	'yiiSetPathOfAlias' => array(
		'base' => $base,
		'public' => $base,
		'htdocs' => $htdocs,
		'app' => $app,
		'modules' => $modules,
		'nii' => $nii,
		'localmodules' => $localmodules,
		'commmodules'  => $commmodules
	),
	// This is the main Web application configuration. Any writable
	// CWebApplication properties can be configured here.
	'config' => array(
		'id' => 'rluXH0IoT8XhSuaVswIZP0p4CeGb',
		'basePath' => $app,
		'runtimePath'=>"$base/runtime",
		'sourceLanguage' => 'en_GB',
		'domain' => false,
		'hostname' => 'local.newicon.org',
		// set default system timezone (overriden by the users local.php config) if this omitted 
		// php get very irrate
		'timezone'=>'Europe/London',
		// preloading 'log' component
		'preload' => array('log', 'NFileManager', 'bootstrap'),
		// autoloading model and component classes
		'defaultController' => 'admin',
		'import' => array(
			'application.models.*',
			'application.components.*',
			'ext.*',
			'application.modules.nii.components.*',
			'application.modules.nii.widgets.*',
			'application.vendors.*',
			'application.vendors.FirePHPCore.*',
			'application.modules.user.models.*',
			'application.modules.user.components.*',
		),
		'theme' => 'default',
		'modulePath' => $modules,
		'modules' => array(
			'nii',
			'user' => array(
				'registrationCaptcha' => false,
				'termsRequired' => false,
				'sendActivationMail' => true,
				'activeAfterRegister' => true,
				'usernameRequired' => false,
				'showUsernameField' => false,
				'enableGoogleAuth'=>false
			),
			'admin',
			//'contact',
			'dev',
		),
		// application components
		'components' => array(
			'db'=>array(
				'emulatePrepare' => true,
				'charset' => 'utf8',
			),
			'menus' => array(
				'class' => 'NMenuManager',
			),
			'settings'=>array(
				'class' => 'NSettings',
			),
			'user' => array(
				'class' => 'NWebUser',
				// enable cookie-based authentication
				'allowAutoLogin' => true,
				'loginUrl' => array("/user/account/login"),
				'authTimeout'=>2592000 // logs the user out after a period of activity.
			),
			'authManager' => array(
				'class' => 'NDbCacheAuthManager',
				'connectionID' => 'db',
				'assignmentTable' => 'auth_assignment',
				'itemChildTable' => 'auth_item_child',
				'itemTable' => 'auth_item',
				'defaultRoles' => array('authenticated', 'guest'),
			),
			// uncomment the following to enable URLs in path-format
			'urlManager' => array(
				'urlFormat' => 'path',
				'rules' => array(
					'<controller:\w+>/<id:\d+>' => '<controller>/view',
					'<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
					'<controller:\w+>/<action:\w+>' => '<controller>/<action>',
					
				),
				'showScriptName' => false,
			),

			'image' => array(
				'class' => 'nii.components.NImage',
				// GD or ImageMagick
				'driver' => 'GD',
				// ImageMagick setup path
				'params' => array('directory' => '/Applications/XAMPP/xamppfiles/bin'),
				// An array of different sizes which can be reffered to throughout the program
				'types' => array(
					'grid' => array(
						'resize' => array('width' => 150, 'height' => 150, 'master' => 'width', 'scale' => 'down')
					),
					'grid-thumbnail-person' => array(
						'resize' => array('width' => 24, 'height' => 24, 'master' => 'width', 'scale' => 'down'),
						'noimage' => realpath("$htdocs/images/blank-profile.jpg"),
					),
					'grid-thumbnail-organisation' => array(
						'resize' => array('width' => 24, 'height' => 24, 'master' => 'width', 'scale' => 'down'),
						'noimage' => realpath("$htdocs/images/blank-profile-org.jpg"),
					),
					'profile-main-person' => array(
						'resize' => array('width' => 145, 'height' => 180, 'master' => 'width', 'scale' => 'down')
					),
					'profile-main-organisation' => array(
						'resize' => array('width' => 145, 'height' => 180, 'master' => 'width', 'scale' => 'down'),
						'noimage' => realpath("$htdocs/images/blank-profile-org.jpg"),
					),
					'profile-small-person' => array(
						'resize' => array('width' => 42, 'height' => 42, 'master' => 'width', 'scale' => 'down')
					),
					'profile-small-organisation' => array(
						'resize' => array('width' => 42, 'height' => 42, 'master' => 'width', 'scale' => 'down'),
						'noimage' => realpath("$htdocs/images/blank-profile-org.jpg"),
					),
					'profile-menu' => array(
						'resize' => array('width' => 40, 'height' => 40, 'master' => 'max', 'scale' => 'down')
					),
					'note-thumbnail' => array(
						'resize' => array('width' => 48, 'height' => 48, 'master' => 'width', 'scale' => 'down')
					),
				),
				'notFoundImage' => realpath("$htdocs/images/blank-profile.jpg"),
			),
			'cache' => array(
				'class' => 'CFileCache',
			),
			'fileManager' => array(
				'class' => 'NFileManager',
				'location' => realpath($base."/uploads"),
				'locationIsAbsolute' => true,
				'defaultCategory' => 'attachments',
				'categories' => array(
					'attachments' => 'attachments',
					'profile_photos' => 'profile_photos',
					'logos' => 'logos',
				),
			),
			'sprite' => array(
				'class' => 'nii.components.sprite.NSprite',
				'imageFolderPath'=>array(
					realpath($app.'/sprite'),
				),
			),
			'widgetFactory' => array(
				'widgets' => array(
					'NGridView' => array(
						'template' => "{scopes}\n{buttons}<div class='grid-top-summary'>{summary} {pager}</div>{items}\n{pager}",
					),
					'CGridView' => array(
						'template' => "<div class='grid-top-summary'>{summary} {pager}</div>{items}\n{pager}",
						'summaryText' => "Displaying {start}-{end} of {count} results",
					),
					'NScopeList' => array(
						'htmlOptions' => array(
							'class' => 'scopes',
						),
					),
					'CLinkPager' => array(
						'header' => '',
					),
				),
			),
			'securityManager'=>array(
				'validationKey'=>'6fad6c61071e437d283ad604221d474c',
				'encryptionKey'=>'1969e32e2fdb65e83f1d43686cbc652d'
			),
		),
	)
);
