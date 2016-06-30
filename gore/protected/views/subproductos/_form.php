<?php
/*$colorbox = $this->widget('application.extensions.colorpowered.JColorBox');   
Yii::app()->clientScript->registerScript('modals', "
        $(document).ready(function() {
            asignacionModalsWithIframe();
        });
    ");*/
?>
<div class="form">


<?php $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'subproductos-form',
	'enableAjaxValidation' => false,
));
?>

     <?php 
        if(isset($titulo)) echo "<h3>".$titulo."</h3>";
    ?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary($model); ?>
        <div class="row">
        <?php echo $form->labelEx($model,'nombre'); ?>
        <?php echo $form->textField($model, 'nombre', array('style'=>'width: 785px;','maxlength' => 200)); ?>
        <?php echo $form->error($model,'nombre'); ?>
        </div><!-- row -->
        <div class="limpia"></div>
        <div class="rowleft47">
        <?php echo $form->labelEx($model,'descripcion',array('class'=>'blockLabel')); ?>
        <?php echo $form->textArea($model, 'descripcion',array('rows'=>3, 'style'=>'width: 407px;')); ?>
        <?php echo $form->error($model,'descripcion'); ?>
        </div><!-- row -->
        
		<div class="rowright47">
		<?php 
		      $idDivision=0;
		      if($model->producto_estrategico_id){
		          $idDivision=$model->productoEstrategico->division->id;
                  echo $form->hiddenField($model, 'producto_estrategico_id'); 
		      }else{
		          echo $form->hiddenField($model, 'producto_estrategico_id',array('value'=>$_GET['productoEstrategico'])); 
                  $idDivision=$_GET['division'];
		      }
        ?>    
		<?php echo $form->labelEx($model,'centro_costo_id'); ?>
		<?php echo $form->dropDownList($model, 'centro_costo_id', GxHtml::listDataEx(CentrosCostos::model()->findAll(array('condition'=>'estado=1 AND division_id='.$idDivision))),array('style'=>'width: 298px;')); ?>
		<?php echo $form->error($model,'centro_costo_id'); ?>
		</div><!-- row -->
		<div class="limpia"></div>
		
<div class="row buttons">        
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Guardar'); ?>
</div>  
        
</div><!-- form -->
        <div id="iframeModal" class='form' style="display:none;height: 265px;">
                <iframe width="100%" height="100%" frameborder="0" scrolling="no">
                    
                </iframe>
        </div>
        
     
<div class="form row">
            <h3>Producto Específico</h3>
            <?php if($model->id){?>               
                <ul class="MenuOperations">
                    <li><a href="<?php echo Yii::app()->request->baseUrl."/ProductosEspecificos/create?subProducto=".$model->id?>" class="cboxElement" onclick="actualizarSRCIframe(this);return false;">Agregar</a></li>
                </ul>
            <?php                
            $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'productos-especificos-grid',
                'dataProvider' => $modelProductosEspecificos->search(),
                'columns' => array(
                    array(
                        'header'=>'N°',
                        'htmlOptions'=>array('width'=>'30'),
                        'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                    ),
                    'nombre',
                    'descripcion',
                    array(
                        'class' => 'CButtonColumn',
                        'header' => 'Acción',
                        'template'=>'{update}{delete}',
                            'buttons'=>array(
                                'update'=>
                                    array(
                                            'url'=>'$this->grid->controller->createUrl("/ProductosEspecificos/update/", array("id"=>$data->primaryKey))',
                                            'options'=>array(                                                
                                               'class'=>'formIframe',
                                               'onclick'=>'actualizarSRCIframe(this);return false;',                                                                                                                                                                                       
                                            ),
                                            'imageUrl'=>Yii::app()->request->baseUrl.'/images/edit.png',
                                        ),
                                  'delete'=>
                                    array(
                                            'url'=>'$this->grid->controller->createUrl("/ProductosEspecificos/delete/", array("id"=>$data->primaryKey))',
                                             'imageUrl'=>Yii::app()->request->baseUrl.'/images/delete.png', 
                                        ),
                               )
                    ),
                ),
            ));
            
        }
        else{
            echo "Usted debe crear el subproducto antes de crear productos específicos.";
        }//end if $modelProductosEspecificos    
            ?>
            
    </div>
<?php

    $this->endWidget();
?>

