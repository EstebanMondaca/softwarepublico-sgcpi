<?php


// Cambiar las siguientes rutas de acceso si es necesario
$yii=dirname(__FILE__).'/../../yii/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';

// Cambiar el true a false cuando pase a producccion
defined('YII_DEBUG') or define('YII_DEBUG',true);

// Especificar el número de niveles de la pila de llamadas se debe mostrar en cada mensaje de registro
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
Yii::createWebApplication($config)->run();
