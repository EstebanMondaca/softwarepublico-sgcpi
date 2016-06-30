<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'evaluacion-jornada-form',
	'enableAjaxValidation' => false,
	'htmlOptions' => array(
        'enctype' => 'multipart/form-data'
    ),
));
?>
	<?php echo $form->errorSummary($model); ?>
    
    <table width="100%" border="0" cellspacing="5" cellpadding="5">
      <tr>
        <th width="560" style="text-align: left;">
            <?php echo $form->labelEx($model,'descripcion'); ?>:
            </th>
        <th style="text-align: right;">
            <?php echo $form->labelEx($model,'fecha_jornada'); ?>:            
            <?php $form->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'model' => $model,
                        'attribute' => 'fecha_jornada',
                        'value' => $model->fecha_jornada,
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
        <?php echo $form->error($model,'fecha_jornada'); ?>
            
        </th>
      </tr>
      <tr>
        <td colspan="2">
            <?php echo $form->textArea($model, 'descripcion',array('rows'=>5,'style'=>'width: 885px;')); ?>
            <?php echo $form->error($model,'descripcion'); ?>
        </td>
      </tr>
      <tr>
        <th style="text-align: left;">Documentos Asociados:</th>
        <td style="text-align: right;"><input type="button" onclick="agregarDocumentosEvaluacionJornada();" value="Agregar" name="yt1"></td>
      </tr>
      <tr>
        <td colspan="2">
            <div class="grid-view" style="padding-top: 0;"> 
                <table class="items" id="documentosAsociados">
                    <tr>
                        <th>Documentos Adjuntos</th>
                        <th width="150">Fecha</th>
                        <th width="55">Acción</th>
                    </tr>
                    <?php 
                        $existe=false;
                        if($model->evaluacionJornadaDocumentoses){
                            $origenUrl= Yii::app()->request->baseUrl.'/upload/evaluacionJornada/';
                            foreach($model->evaluacionJornadaDocumentoses as $v){
                                if($v->estado==1){
                                    $existe=true;
                                    $anio=Yii::app()->dateFormatter->format('dd MMM, yyyy', $v->fecha_creacion);
                                    echo '<tr valueTR="'.$v->id.'"><td><a href="'.$origenUrl.$v->archivo.'" target="_blank"><img src="'.Yii::app()->request->baseUrl.'/images/document_letter_download.png"/>'.$v->archivo.'</a></td><td>'.$anio.'</td><td><a href="#" onclick="eliminarDocumentosEvaluacionJornada(this);return false;"><img src="'.Yii::app()->request->baseUrl.'/images/delete.png" /></a></td></tr>';
                                }
                            }                            
                        }
                        
                        if(!$existe){
                            echo '<tr class="empty"><td colspan="3" class="empty"><span class="empty">No se encontraron resultados.</span></td></tr>';
                        }
                    ?>
                </table>
            </div>          
            
        </td>
      </tr>
    </table>
		<!--<label><?php //echo GxHtml::encode($model->getRelationLabel('evaluacionJornadaDocumentoses')); ?></label>
		<?php //echo $form->checkBoxList($model, 'evaluacionJornadaDocumentoses', GxHtml::encodeEx(GxHtml::listDataEx(EvaluacionJornadaDocumentos::model()->findAllAttributes(null, true)), false, true)); ?>
-->
<?php
echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Guardar');
$this->endWidget();
?>
</div><!-- form -->