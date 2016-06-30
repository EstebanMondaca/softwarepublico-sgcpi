<?php 
Yii::app()->clientScript->registerScript('habilitar', "


    $('.desabilitarInputText').change(function(){
            if($(this).is(':checked')){
                $('#Actividades_itemesActividades_'+$(this).val()).removeAttr('disabled');
            }else{
                $('#Actividades_itemesActividades_'+$(this).val()).attr('disabled','disabled');
            }
    });
    
    //cambiando alto del iframe
    parent.$('#iframeModal').height($('body').outerHeight(true)+20);
    //alert($(document).outerHeight(true));    
");

?>
<div class="form">

    <?php 
        if(isset($titulo)) echo "<h3>".$titulo."</h3>";
    ?>
<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'actividades-form',
	'enableAjaxValidation' => false,
	//'enableAjaxValidation'=>true,
    //'enableClientValidation'=>true,
));
?>
    
	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>
    <?php if($model->indicador_id)
                echo $form->hiddenField($model, 'indicador_id'); 
             else
                 echo $form->hiddenField($model, 'indicador_id',array('value'=>$_GET['idIndicador'])); 
    ?>
    
	<?php echo $form->errorSummary($model); ?>
	<table width="100%" border="0" cellspacing="5" cellpadding="5" class="control">
          <tr>
              <td width="524">
                    <?php echo $form->labelEx($model,'nombre'); ?>
                    <?php echo $form->textField($model, 'nombre', array('style'=>'width: 440px;','maxlength' => 200)); ?>
                    <?php echo $form->error($model,'nombre'); ?>
              </td>
              <td align="right"><?php echo $form->labelEx($model,'fecha_inicio'); ?></td>
              <td><?php $form->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'model' => $model,
                        'attribute' => 'fecha_inicio',
                        'value' => $model->fecha_inicio,
                        'options' => array(
                            //'showButtonPanel' => true,
                            //'changeYear' => true,
                            'dateFormat' => 'yy-mm-dd',
                            'monthNames' => array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'),
                            'monthNamesShort' => array("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"),
                            'dayNames' => array('Domingo,Lunes,Martes,Miercoles,Jueves,Viernes,Sabado'),
                            'dayNamesMin' => array('Do','Lu','Ma','Mi','Ju','Vi','Sa'),
                            ),
                        ));
                        ; ?>
                    <?php echo $form->error($model,'fecha_inicio'); ?></td>
          </tr>
          <tr>
              <td rowspan="2">
                    <?php echo $form->labelEx($model,'descripcion',array('class'=>'blockLabel')); ?>
                    <?php echo $form->textArea($model, 'descripcion',array('rows'=>3,'style'=>'width: 500px;')); ?>
                    <?php echo $form->error($model,'descripcion'); ?>
              </td>
              <td align="right"><?php echo $form->labelEx($model,'fecha_termino'); ?></td>
              <td> <?php $form->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'model' => $model,
                        'attribute' => 'fecha_termino',
                        'value' => $model->fecha_termino,                        
                        'options' => array(
                            //'showButtonPanel' => true,
                            //'changeYear' => true,
                            'language '=>'es',
                            'dateFormat' => 'yy-mm-dd',
                            'monthNames' => array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'),
                            'monthNamesShort' => array("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"),
                            'dayNames' => array('Domingo,Lunes,Martes,Miercoles,Jueves,Viernes,Sabado'),
                            'dayNamesMin' => array('Do','Lu','Ma','Mi','Ju','Vi','Sa'),
                                                        
                            ),
                        ));
                    ; ?>
                    <?php echo $form->error($model,'fecha_termino'); ?></td>
          </tr>
          <tr>
              <td align="right"><?php echo $form->labelEx($model,'actividad_parent'); ?></td>
              <td>
                        <?php echo $form->dropDownList($model, 'actividad_parent', GxHtml::listDataEx(Actividades::model()->findAll(array('condition'=>'t.estado=1 AND t.indicador_id='.$_GET['idIndicador']))), array('empty'=>'Seleccione actividad')); ?>
                        <?php echo $form->error($model,'actividad_parent'); ?>
             </td>
          </tr>
    </table>
        
        <div class="limpia"></div>
</div><!-- form -->

<div class="form">
    <h3>Presupuesto Actividad</h3>
    <div class="grid-view">        
        <table class="items">
            <thead>
              <tr><th width="30">N°</th><th width="55">Vínculo</th><th>Item Presupuestario</th><th width="150">Monto</th></tr>
            </thead>
            <tbody>
               
                <?php 
              $arrayItemesPresupuestarios = CHtml::listData(ItemesPresupuestarios::model()->findAll(array('condition'=>'t.estado=1 AND t.tipo_item_id=1')), 'id', 'nombre');
              $arraySelectedItemes=CHtml::listData($model->itemesPresupuestarioses,'id','id');
              $x=0;   
              if($model->id){
                 $arrayItemesActividades = CHtml::listData(ItemesActividades::model()->findAll(array('condition'=>'t.actividad_id='.$model->id)), 'item_presupuestario_id', 'monto'); 
              }           
              foreach($arrayItemesPresupuestarios as $k=>$v):
                  $parOImpar=$x%2?"even":"odd";
                  echo "<tr class=".$parOImpar.">";
                  echo "<td>".($x+1)."</td>";                  
                  //if (array_key_exists($k, $arraySelectedItemes)) {
                  if(isset($arrayItemesActividades[$k])){
                     echo "<td align='center'><input class='desabilitarInputText' type=\"checkbox\" name=\"Actividades[itemesPresupuestarioses][]\" checked=\"checked\" value=\"".$k."\" id=\"Actividades_itemesPresupuestarioses_".$x."\"></td>";     
                  }else{
                      echo "<td align='center'><input class='desabilitarInputText' type=\"checkbox\" name=\"Actividades[itemesPresupuestarioses][]\" value=\"".$k."\" id=\"Actividades_itemesPresupuestarioses_".$x."\"></td>";
                  }
                  
                  echo "<td><label for=\"Actividades_itemesPresupuestarioses_".$x."\">".$v."</label></td>";
                  if(isset($arrayItemesActividades[$k])){
                      echo "<td align='center'><input id='Actividades_itemesActividades_".$k."' name=\"Actividades[itemesActividades][i".$k."]\" value='".$arrayItemesActividades[$k]."'></td>"; 
                  }else{
                      echo "<td align='center'><input disabled='disabled' id='Actividades_itemesActividades_".$k."' name=\"Actividades[itemesActividades][i".$k."]\" value=''></td>"; 
                  }                    
                  echo "</tr>";
                    $x++; 
              endforeach;
              ?> 
            <?php 
                    //echo $form->checkBoxList($model, 'itemesPresupuestarioses', GxHtml::encodeEx(GxHtml::listDataEx(ObjetivosEstrategicos::model()->findAll()), false, true),array('separator'=>'','template'=>'<tr class="odd"><td>{label}</td><td>{input}</td></tr>')); ?>
            <?php 
              //  echo $form->checkBoxList($model, 'itemesPresupuestarioses', GxHtml::encodeEx(GxHtml::listDataEx(ItemesPresupuestarios::model()->findAll()), false, true),array('separator'=>'','template'=>'<tr class="odd"><td></td><td>{input}</td><td>{label}</td><td></td></tr>')); 
                
            ?>
        </tbody>
            </table>
             
        </div>      
    
    
<div class="row buttons">        
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Guardar'); ?>
        <?php echo CHtml::button('Cancelar',array('onclick'=>"window.parent.cerrarModalSinCambios()")); ?>        
</div> 
    
    <?php
    $this->endWidget();
    ?>
</div>
