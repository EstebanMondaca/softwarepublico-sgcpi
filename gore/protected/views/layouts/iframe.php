<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/DTD/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head style="background-color: #FFF;">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery.alerts.css" rel="stylesheet" type="text/css" /> 
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/gore.css" />
	
	
	
<?php
	   $cs = Yii::app()->clientScript;        
       $cs->registerCoreScript('jquery'); 
       $cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/form.js'); 
       Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.alerts.js'); 
	?>

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
<input type="hidden" id="urlSitioWeb" value="<?php echo Yii::app()->request->baseUrl;?>"/>
<!--<div class="containerIframeUpdate" id="page">-->

	<?php echo $content; ?>

	<div class="clear"></div>

<!--</div> page -->

</body>
</html>
