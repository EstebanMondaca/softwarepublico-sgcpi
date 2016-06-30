<?php

$this->breadcrumbs=array(
        Yii::t('ui','Reportes')=>array('/reportes'),       
        'Mapa Estratégico',
    );

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.dotdotdot-1.5.4.js');
Yii::app()->clientScript->registerScript('habilitar', "
   var anchoMax='120';
   $('.mapaDesafioEstrategico').width(anchoMax);
   $('#mapaEstrategico .tdDesafiosEstrategicos').each(function(){
       var anchoCelda=$(this).width()-20;
       var totalDesafios=$(this).children('.mapaDesafioEstrategico').length;
       var totalAnchoDesafio=0;
       if($(this).children('.mapaDesafioEstrategico').eq(0)){
           totalAnchoDesafio=parseInt($(this).children('.mapaDesafioEstrategico').eq(0).outerWidth(true))*parseInt(totalDesafios);
       }
       
       if(totalAnchoDesafio>anchoCelda){
           var totalPaddingMargin=parseInt($('.mapaDesafioEstrategico').eq(0).outerWidth(true))-anchoMax;
           var anchoMaxPermitido=(anchoCelda-(totalPaddingMargin*totalDesafios))/totalDesafios;
           $(this).children('.mapaDesafioEstrategico').width(anchoMaxPermitido);
       }              
       
   });
   
    $('.informacion').dotdotdot();  
    $('.mapaObjetivoEstrategico').dotdotdot(); 
");
    //
    $perspectivasEstrategicasArray=array();
    $desafiosEstrategicosArray=array();
    $colorFondoArray=array('F5FCED','da9b58','F8DA4E','F7F3DE','FFFFFF','994D53','FEE4BD','990033','FF3333','000099');
    $colorLetraArray=array('333333','FFFFFF','915608','3A3427','333333','FFFFFF','592003','FFFFFF','FFFFFF','FFFFFF');
    $colorBordeArray=array('8CCE3B','FED22F','FCD113','B2A266','AAAAAA','F8893F','74736D','FFFFFF','FFFFFF','FFFFFF');
    $colorObjetivo=array();
    
    $misionConsulta=MisionesVisiones::model()->findAll(array('condition'=>'planificacion_id="'.Yii::app()->session['idPlanificaciones'].'" AND (nombre LIKE "M%" OR nombre LIKE "m%")'));

    $textoMision="";
    if($misionConsulta){
        $textoMision=$misionConsulta[0]->descripcion;
    }
    echo '
            <div style="font-size: 15px;font-weight: bold;text-align: center;">MISIÓN</div>
            <div class="mapaMision">'.$textoMision.'</div>';
    
    
    echo '<div class="grid-view"><table id="mapaEstrategico" width="100%" border="1" cellspacing="5" cellpadding="5" class="mapaEstrategico items">
              <tr>
                <th width="30%">OBJETIVOS ESTRATÉGICOS</th>
                <th width="70%">DESAFÍOS ESTRATÉGICOS</th>
              </tr>';   
    
    
    $x=0;  
    foreach($modelObjetivosEstrategicos as $objetivosEstrategicos){
        $perspectivasEstrategicasArray[$objetivosEstrategicos->perspectivaEstrategica->id]['nombre']=$objetivosEstrategicos->perspectivaEstrategica;
        $perspectivasEstrategicasArray[$objetivosEstrategicos->perspectivaEstrategica->id]['objetivosEstrategicos'][$objetivosEstrategicos->id]['nombre']=$objetivosEstrategicos;
        $perspectivasEstrategicasArray[$objetivosEstrategicos->perspectivaEstrategica->id]['objetivosEstrategicos'][$objetivosEstrategicos->id]['id']=$objetivosEstrategicos->id;
        $perspectivasEstrategicasArray[$objetivosEstrategicos->perspectivaEstrategica->id]['objetivosEstrategicos'][$objetivosEstrategicos->id]['colorFondo']=$colorFondoArray[$x];
        $perspectivasEstrategicasArray[$objetivosEstrategicos->perspectivaEstrategica->id]['objetivosEstrategicos'][$objetivosEstrategicos->id]['colorLetra']=$colorLetraArray[$x];
        $perspectivasEstrategicasArray[$objetivosEstrategicos->perspectivaEstrategica->id]['objetivosEstrategicos'][$objetivosEstrategicos->id]['colorBorde']=$colorBordeArray[$x];
        
        $colorObjetivo[$objetivosEstrategicos->id]['colorFondo']=$colorFondoArray[$x];
        $colorObjetivo[$objetivosEstrategicos->id]['colorLetra']=$colorLetraArray[$x];  
        $colorObjetivo[$objetivosEstrategicos->id]['colorBorde']=$colorBordeArray[$x];                
        $x++;
        if(!isset($colorFondoArray[$x])){
            $x=0;
        }       
    }
    
    
    foreach($modelDesafiosEstrategicos as $desafiosEstrategicos){        
        //$desafiosEstrategicosArray[$desafiosEstrategicos->id]=$desafiosEstrategicos->id;
        $perspectivasEstrategicasArray[$desafiosEstrategicos->perspectivaEstrategica->id]['nombre']=$desafiosEstrategicos->perspectivaEstrategica;
        $perspectivasEstrategicasArray[$desafiosEstrategicos->perspectivaEstrategica->id]['desafiosEstrategicos'][$desafiosEstrategicos->id]['nombre']=$desafiosEstrategicos;
        $perspectivasEstrategicasArray[$desafiosEstrategicos->perspectivaEstrategica->id]['desafiosEstrategicos'][$desafiosEstrategicos->id]['id']=$desafiosEstrategicos->id;
        $perspectivasEstrategicasArray[$desafiosEstrategicos->perspectivaEstrategica->id]['desafiosEstrategicos'][$desafiosEstrategicos->id]['colorFondo']='FFFFFF';
        $perspectivasEstrategicasArray[$desafiosEstrategicos->perspectivaEstrategica->id]['desafiosEstrategicos'][$desafiosEstrategicos->id]['colorLetra']='333333';
        $perspectivasEstrategicasArray[$desafiosEstrategicos->perspectivaEstrategica->id]['desafiosEstrategicos'][$desafiosEstrategicos->id]['colorBorde']='333333';
        foreach($desafiosEstrategicos->objetivosEstrategicoses as $objetivo){
            if(array_key_exists($objetivo->id, $colorObjetivo)){
                $perspectivasEstrategicasArray[$desafiosEstrategicos->perspectivaEstrategica->id]['desafiosEstrategicos'][$desafiosEstrategicos->id]['colorFondo']=$colorObjetivo[$objetivo->id]['colorFondo'];
                $perspectivasEstrategicasArray[$desafiosEstrategicos->perspectivaEstrategica->id]['desafiosEstrategicos'][$desafiosEstrategicos->id]['colorLetra']=$colorObjetivo[$objetivo->id]['colorLetra'];
                $perspectivasEstrategicasArray[$desafiosEstrategicos->perspectivaEstrategica->id]['desafiosEstrategicos'][$desafiosEstrategicos->id]['colorBorde']=$colorObjetivo[$objetivo->id]['colorBorde'];
            }
        }
    }
       
    
    //cargando datos a la matriz
    $letraNumber=0;
    $asociacionArray=array();
    foreach($perspectivasEstrategicasArray as $key=>$perspectiva){
        echo '<tr><td valign="top" style="vertical-align:top;">';
        echo '<table class="mapaPerspectivas" width="97%" border="0" cellspacing="0" cellpadding="0">';
        echo '<tr><td valign="top" style="height: 30px;border: 0 none;padding: 0;"><h3>'.$perspectiva['nombre'].'</h3></td></tr>';
         echo '<tr><td class="linkObjetivo" valign="top" style="border: 0 none;padding: 0;">';
         if(isset($perspectiva['objetivosEstrategicos'])){
             foreach($perspectiva['objetivosEstrategicos'] as $datosObjetivos){
                echo '<a href="'.Yii::app()->request->baseUrl.'/mapaEstrategico/viewObjetivo/'.$datosObjetivos['id'].'" class="update"><div class="mapaObjetivoEstrategico" style="background-color:#'.$datosObjetivos['colorFondo'].';color:#'.$datosObjetivos['colorLetra'].';border-color:#'.$datosObjetivos['colorBorde'].';">'.$datosObjetivos['nombre'].'</div></a>';
            }
         }
            
        echo '</td></tr>';
        echo '</table></td>';
            
        //<th valign="top" style="height: 30px;">'.$perspectiva['nombre'].'</th>';
        $letra=chr(65+$letraNumber);
        
        /*if(!array_key_exists($letra, $asociacionArray)){
            
        }*/
        //
        
        
        echo'<td valign="top" class="tdDesafiosEstrategicos">';          
        $numeroLetra=1;  
        if(isset($perspectiva['desafiosEstrategicos'])){
            foreach($perspectiva['desafiosEstrategicos'] as $datosDesafios){
                echo '<div class="mapaDesafioEstrategico" style="background-color:#'.$datosDesafios['colorFondo'].';color:#'.$datosDesafios['colorLetra'].';border-color:#'.$datosObjetivos['colorBorde'].';"><a href="'.Yii::app()->request->baseUrl.'/mapaEstrategico/view/'.$datosDesafios['id'].'" class="update"><div class="informacion" style="color:#'.$datosDesafios['colorLetra'].';">'.$datosDesafios['nombre'].'</div></a><div class="asociacion">'.$letra.$numeroLetra.'</div></div>';
                $asociacionArray[$datosDesafios['id']]['nombre']=$letra.$numeroLetra;
                $asociacionArray[$datosDesafios['id']]['asociacion']=array();                
                foreach($datosDesafios['nombre']->desafioDesafios as $v){
                    $asociacionArray[$datosDesafios['id']]['asociacion'][]=$v->desafio_estrategico_mm_id; 
                }
                $numeroLetra++;
            }
        }
        echo'</td></tr>';
        $letraNumber++;
    }
    
    echo '</table></div>';
     
     echo '<br/><br/><br/><h3>Asociación de Desafíos Estratégicos</h3>';
     echo '<div class="grid-view"><table class="items" width="50%" border="1" cellspacing="5" cellpadding="5">';
     echo '<tr><th width="200">Desafío Estratégico</th><th>Asociados</th></tr>';
     $conDatos=false;
     foreach($asociacionArray as $key=>$value){
         if(!empty($value['asociacion'])){
             $conDatos=true;
             echo '<tr><td>'.$value['nombre'].'</td><td>';
                $existe=false;
                foreach($value['asociacion'] as $k=>$v){
                  if(array_key_exists($v, $asociacionArray)){
                      if($existe){
                          echo '-';                          
                      }
                      $existe=true;
                      echo $asociacionArray[$v]['nombre'];
                  }  
                }
             echo'</td></tr>';
         }
     }
     
     if(!$conDatos){
         echo '<tr><td class="empty" colspan="2"><span class="empty">No se encontraron resultados.</span></td></tr>';
     }
     
     echo '</table></div>';
?>