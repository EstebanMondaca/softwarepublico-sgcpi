<h3>Registro de jornada de evaluación anual</h3>


<div class="form">

  <?php $form = $this->beginWidget('GxActiveForm', array(
    'id' => 'evaluacion-jornada-form',
    'enableAjaxValidation' => false,
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data'
    ),
));
?>
    <table width="100%" border="0" cellspacing="5" cellpadding="5">
      <tr>
        <th width="560" style="text-align: left;">
            <?php echo $form->labelEx($model,'descripcion'); ?>:
            </th>
        <th style="text-align: right;">
            <?php echo $form->labelEx($model,'fecha_jornada'); ?>: 
                       
            <?php 
                $fecha=Yii::app()->dateFormatter->format('dd MMM, yyyy', $model->fecha_jornada);
                echo $fecha;
            ?>            
        </th>
      </tr>
      <tr>
        <td colspan="2">
            <?php echo $form->textArea($model, 'descripcion',array('rows'=>5,'style'=>'width: 885px;','disabled'=>'disabled')); ?>
        </td>
      </tr>
      <tr>
        <th style="text-align: left;">Documentos Asociados:</th>
        <td style="text-align: right;"></td>
      </tr>
      <tr>
        <td colspan="2">
            <div class="grid-view" style="padding-top: 0;"> 
                <table class="items" id="documentosAsociados">
                    <tr>
                        <th>Documentos Adjuntos</th>
                        <th width="150">Fecha</th>
                    </tr>
                    <?php 
                        $existe=false;
                        if($model->evaluacionJornadaDocumentoses){
                            $origenUrl= Yii::app()->request->baseUrl.'/upload/evaluacionJornada/';
                            foreach($model->evaluacionJornadaDocumentoses as $v){
                                if($v->estado==1){
                                    $existe=true;
                                    $anio=Yii::app()->dateFormatter->format('dd MMM, yyyy', $v->fecha_creacion);
                                    echo '<tr valueTR="'.$v->id.'"><td><a href="'.$origenUrl.$v->archivo.'" target="_blank"><img src="'.Yii::app()->request->baseUrl.'/images/document_letter_download.png"/>'.$v->archivo.'</a></td><td>'.$anio.'</td></tr>';
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
    
    <?php
    
    $this->endWidget();
    ?>
</div><!-- form -->