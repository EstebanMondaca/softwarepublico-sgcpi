<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Sistema de Planificación Institucional - Gobierno Regional de Los Lagos',
	// preloading 'log' component
	'preload'=>array(
		'log',
		'bootstrap',
	),
	'language'=>'es',
	'sourceLanguage'=>'00',
	'defaultController'=>'user/login/',
	// autoloading model and component classes
	'import'=>array(
		    'application.models.*',
		    'application.components.*',
		    'application.controllers.*',		
            'application.modules.user.models.*',
            'application.modules.user.components.*',
    		//'application.modules.user.models. *',
    		'ext.giix-components.*', // giix components
            'ext.fileimagebehavior.*',
            'ext.yii-mail.YiiMailMessage',
	),
    
	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'admin',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('190.98.231.79','127.0.0.1','::1'),
			'generatorPaths' => array(
                   'ext.giix-core', // giix generators
             ),
		),
		'mailbox'=>
            array(  
            'userClass' => 'User',
            'userIdColumn' => 'id',
            'usernameColumn' =>  'username',
              ),
		'user'=>array(
                # encrypting method (php hash function)
                'hash' => 'md5',

                # send activation email
                'sendActivationMail' => true,

                # allow access for non-activated users
                'loginNotActiv' => false,

                # activate user on registration (only sendActivationMail = false)
                'activeAfterRegister' => false,

                # automatically login from registration
                'autoLogin' => true,

                # registration path
                #  'registrationUrl' => array('/user/registration'),

                # recovery password path
                #'recoveryUrl' => array('/user/recovery'),

                # login form path
                'loginUrl' => array('/user/login'),

                # page after login
                'returnUrl' => array('/site'),
                //'returnUrl' => array('gore/site'),

                # page after logout
                'returnLogoutUrl' => array('/'),
            ),		
		
	),

	// application components
	'components'=>array(
		'ePdf' => array(
			'class'         => 'ext.yii-pdf.EYiiPdf',
			'params'        => array(
					'mpdf'     => array(
							'librarySourcePath' => 'application.vendors.mpdf.*',
							'constants'         => array(
									'_MPDF_TEMP_PATH' => Yii::getPathOfAlias('application.runtime'),
							),
							'class'=>'mpdf', // the literal class filename to be loaded from the vendors folder
							/*'defaultParams'     => array( // More info: http://mpdf1.com/manual/index.php?tid=184
							 'mode'              => '', //  This parameter specifies the mode of the new document.
									'format'            => 'A4', // format A4, A5, ...
									'default_font_size' => 0, // Sets the default document font size in points (pt)
									'default_font'      => '', // Sets the default font-family for the new document.
									'mgl'               => 15, // margin_left. Sets the page margins for the new document.
									'mgr'               => 15, // margin_right
									'mgt'               => 16, // margin_top
									'mgb'               => 16, // margin_bottom
									'mgh'               => 9, // margin_header
									'mgf'               => 9, // margin_footer
									'orientation'       => 'P', // landscape or portrait orientation
							)*/
					),
					'HTML2PDF' => array(
							'librarySourcePath' => 'application.vendors.html2pdf.*',
							'classFile'         => 'html2pdf.class.php', // For adding to Yii::$classMap
							/*'defaultParams'     => array( // More info: http://wiki.spipu.net/doku.php?id=html2pdf:en:v4:accueil
							 'orientation' => 'P', // landscape or portrait orientation
									'format'      => 'A4', // format A4, A5, ...
									'language'    => 'en', // language: fr, en, it ...
									'unicode'     => true, // TRUE means clustering the input text IS unicode (default = true)
									'encoding'    => 'UTF-8', // charset encoding; Default is UTF-8
									'marges'      => array(5, 5, 5, 8), // margins by default, in order (left, top, right, bottom)
							)*/
					)
			),
		),
		'bootstrap'=>array(
            'class'=>'ext.bootstrap.components.Bootstrap', // assuming you extracted bootstrap under extensions
         ),
         'coreMessages'=>array(
            'basePath'=>null,
        ),
        'mail' => array(
            'class' => 'ext.yii-mail.YiiMail',
            'transportType' => 'smtp',
            'transportOptions' => array(
                'host' => 'smtp.gmail.com',
                'username' => 'gore.tide@gmail.com',
                'password' => 'gore.1234',
                'port' => '465',
                'encryption'=>'tls',
            ),
            'viewPath' => 'application.views.mail',
            'logging' => true,
            'dryRun' => false
        ),
		/*'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),*/
			'user'=>array(
                // enable cookie-based authentication
                'class' => 'WebUser',
                'allowAutoLogin'=>true,
                'loginUrl' => array('/user/login'),
            ),
			//'cache' => array ('class' => 'system.caching.CDummyCache'),
		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		
		/*'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),*/
		// uncomment the following to use a MySQL database
		
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=sgcpi',
			'tablePrefix' => '',
			'emulatePrepare' => true,
			'username' => 'sgcpi',
			'password' => 'chilevalora-sgcpi',
			'charset' => 'utf8',
		),
		'authManager'=>array(
            'class'=>'CDbAuthManager',
            'connectionID'=>'db',
            //'itemTable'=>'AuthItem', // Tabla que contiene los elementos de autorizacion
            //'itemChildTable'=>'AuthItemChild', // Tabla que contiene los elementos padre-hijo
            //'assignmentTable'=>'AuthAssignment', // Tabla que contiene la signacion usuario-autorizacion            
        ),
		/*	'db'=>array(
					'connectionString' => 'mysql:host=localhost;dbname=goreLosLagos',
					'emulatePrepare' => true,
					'username' => 'root',
					'password' => 'moroni',
					'charset' => 'utf8',
			),
		*/
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				/*array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),*/
				// uncomment the following to show log messages on web pages
				
				/*array(
					'class'=>'CWebLogRoute',
				),*/
				
			),
		),
	),
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'marcelo.ceballos@tide.cl',
		'ldap' => array(
                'host' => '192.168.100.2',
                'ou' => 'users', // such as "people" or "users"
                'dc' => array('goreloslagos','cl'),
         ),    
	),	
	
);