<?php 
	//Consultamos si hay un periodo selecionado, de lo contrario lo enviamos a la pagina principal
	if(!isset(Yii::app()->session['idPeriodoSelecionado'])){
		$parts = explode('/', Yii::app()->request->getPathInfo());
		//preguntamos si estamos dentro del site, para no redireccionar
		
		// Aqui es necesario insertar los nombres de mantenedores que no requieran el periodo actual
		if($parts[0] !='' && $parts[0]!='site'){
			Yii::app()->request->redirect(Yii::app()->getHomeUrl());	
		}
	}
?>
<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="en" />

    <!-- blueprint CSS framework -->
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
    <!--[if lt IE 8]>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
    <![endif]-->
    
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/gore.css" /> 
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery.alerts.css" rel="stylesheet" type="text/css" /> 
     <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>

    <?php $colorbox = $this->widget('application.extensions.colorpowered.JColorBox'); 
        
    Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/mantenedores.js'); 
    Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.alerts.js'); 
    ?>  

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">
    <!-- DIV que se utiliza para llenar el estado de alguna acción... (delete)-->
         <div id="statusMsg"></div>
<!--end DIV statusMsg--> 
    <input type="hidden" id="urlSitioWeb" value="<?php echo Yii::app()->request->baseUrl;?>"/>
	<div id="header">
    	<a href="#"><img class="left" src="<?php echo Yii::app()->request->baseUrl;?>/css/imag/logo-gob.jpg" alt="" /></a>
        <a href="#"><img class="right" src="<?php echo Yii::app()->request->baseUrl;?>/css/imag/logo-gore.png" alt="" /></a>
    </div>
	<div id="main">	    
            <?php 
           // echo Yii::app()->session['planificacion']."<-";
           // echo Yii::app()->session['control']."<-";
           // echo Yii::app()->session['control']."<-";
            if(!Yii::app()->user->isGuest){?>
            <div class="menu"> 
            <ul class="left">               
                   <li class="first">
                        <a id="menuSupPlanificacion" href="
                        	<?php
                        	if(isset(Yii::app()->session['planificacion'])){
                        		if(Yii::app()->session['planificacion']=='1'){
                        			if(isset(Yii::app()->session['idPeriodoSelecionado'])) echo Yii::app()->request->baseUrl."/site?periodo=".Yii::app()->session['idPeriodoSelecionado']."&lvl1=etapasPlanificacion"; else echo "#";
                        		}else{
                        			echo "#";
                        		}
                        	}	
                        	 ?>" <?php if(!isset(Yii::app()->session['idPeriodoSelecionado']) AND Yii::app()->session['planificacion']=='1') echo "onclick=\"activarProceso2('etapasPlanificacion'); return false;\""; ?>>Planificación</a>
                    </li>
                    <li>
                        <a id="menuSupControl" href="
                        <?php 
                        if(isset(Yii::app()->session['control'])){
                        	if(Yii::app()->session['control']=='1'){
                        		 if(isset(Yii::app()->session['idPeriodoSelecionado'])) echo Yii::app()->request->baseUrl."/site?periodo=".Yii::app()->session['idPeriodoSelecionado']."&lvl1=etapasControl"; else echo "#";
                        	
                        }else{
                        	echo "#";
                        }
                        }
                       
                        ?>" <?php if(!isset(Yii::app()->session['idPeriodoSelecionado']) AND Yii::app()->session['control']=='1') echo "onclick=\"activarProceso2('etapasControl'); return false;\""; ?>>Control de Gestión</a>
                    </li>
                    <li>
                        <a id="menuSupEvaluacion" href="
                        	<?php
                        		if(isset(Yii::app()->session['evaluacion'])){
                        			if(Yii::app()->session['evaluacion']=='1'){
                        				if(isset(Yii::app()->session['idPeriodoSelecionado'])) echo Yii::app()->request->baseUrl."/site?periodo=".Yii::app()->session['idPeriodoSelecionado']."&lvl1=etapasEvaluacion"; else echo "#";
                        			}else{
                        				echo "#";
                        			} 	                      		
                        		}
                        		?>" <?php if(!isset(Yii::app()->session['idPeriodoSelecionado']) AND Yii::app()->session['evaluacion']=='1') echo "onclick=\"activarProceso2('etapasEvaluacion'); return false;\""; ?>>Evaluación de Gestión</a>
                    </li>
                    <li>
                        <a href="<?php echo Yii::app()->request->baseUrl;?>/reportes" >Reportes</a>
                    </li>
                    <?php 
                    if(Yii::app()->user->checkAccess("admin")){ ?>
                        <li>
                            <a href="<?php echo Yii::app()->request->baseUrl;?>/preferencias">Preferencias</a>
                        </li>
                    <?php }?>
                   
             </ul> 
             <?php
                $newMsgs = Yii::app()->getModule('mailbox')->getNewMsgs();
                $cantidadMails="";
                $rutaImagenMail=Yii::app()->request->baseUrl."/images/mail-close.png";
                if($newMsgs){
                    $rutaImagenMail=Yii::app()->request->baseUrl."/images/mail2.png";
                    $cantidadMails="(".$newMsgs.")";
                }
             ?>
             <div class=" sesion right"><a href="<?php echo Yii::app()->request->baseUrl;?>/mailbox/"><img alt="" src="<?php echo $rutaImagenMail;?>"><?php echo $cantidadMails;?></a> Bienvenido <?php echo Yii::app()->user->name;?> <a href="<?php echo Yii::app()->request->baseUrl;?>/user/logout">Cerrar sesión </a></div>
             </div> 
             <?php }else{
                 echo "<div class='menuIndex'></div> ";
             } ?>
          
	    
	    <?php	    
	    $listExceptController= array('site','preferencias');
        $controllerName = Yii::app()->controller->id;
          
	       if(isset(Yii::app()->session['idPeriodoSelecionado'])){
	           $anio=Yii::app()->session['idPeriodoSelecionado'];
               //Se debe dejar el espacio en blanco al lado del campo $anio... de lo contrario siempre arrojará "0"
	           $beginningURL=array(' '.$anio=>array('/site?periodo='.$anio));
               if(!in_array($controllerName,$listExceptController)){
                   //echo "Permitido obtener breadcrums";
                  $consulta=MenuPrincipal::model()->findAll(array('condition'=>'t.estado=1 AND t.controller="'.$controllerName.'"'));
                  if(isset($consulta[0])){
                      if(isset($consulta[0]->parent->parent->nombre)){
                        $nombrelvl1=$consulta[0]->parent->parent->nombre;
                        $nombrelvl2=$consulta[0]->parent->nombre;
                        $beginningURL=array(' '.$anio=>array('/site?periodo='.$anio),$nombrelvl1=>array('/site?periodo='.$anio.'&lvl1='.$consulta[0]->parent->parent->descripcion),$nombrelvl2=>array('/site?periodo='.$anio.'&lvl1='.$consulta[0]->parent->parent->descripcion.'&lvl2='.$consulta[0]->parent->descripcion));                      
                      }else{
                         $nombrelvl1=$consulta[0]->parent->nombre;
                         $beginningURL=array(' '.$anio=>array('/site?periodo='.$anio),$nombrelvl1=>array('/site?periodo='.$anio.'&lvl1='.$consulta[0]->parent->descripcion));                      
                       
                      }
                      
                  }                  
               }
	       }else{
	           $beginningURL=array();
	       }       
       
	   if(isset($this->breadcrumbs) && !Yii::app()->user->isGuest):?>
    	        <?php $this->widget('zii.widgets.CBreadcrumbs', array(
    	            'links'=>array_merge((array)$beginningURL, (array)$this->breadcrumbs),
    	            'homeLink' => CHtml::link('Inicio', Yii::app()->homeUrl),
    	             
    	        ));
	        ?><!-- breadcrumbs -->

	    <?php endif;?>	       
	     
	     
	    <?php echo $content; ?>

	   
	    <div class="clear"></div>
        </div> <!-- End-main -->
    <div id="footer">
        GOBIERNO REGIONAL DE LOS LAGOS</br>
        AV. DÉCIMA REGIÓN 480, 4TO PISO. PUERTO MONTT - CHILE                
    </div><!-- footer -->

</div><!-- contenedor -->

</body>
</html>
