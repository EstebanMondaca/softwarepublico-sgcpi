<div class="form">


<?php 
Yii::app()->clientScript->registerScript('disenio', "
    $(document).ready(function() {
        $('table tr').removeClass();
        $('table tr:even').addClass('even');
        $('table tr:odd').addClass('odd');
        cambiarEstadoInputSegunCheckbox();
    });
");

$form = $this->beginWidget('GxActiveForm', array(
	'id' => 'productos-estrategicos-form',
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
        
        <div class="rowleft45">
        <?php echo $form->labelEx($model,'nombre'); ?>
        <?php echo $form->textField($model, 'nombre', array('size'=>71,'maxlength' => 200,'style'=>'width: 322px;')); ?>
        <?php echo $form->error($model,'nombre'); ?>        
        <?php 
            if($model->tipo_producto_id=='1' || $_GET['tipoProducto']=='1'){
                echo '<br/>';
                echo $form->labelEx($model,'nombre_corto');
                echo $form->textField($model, 'nombre_corto', array('size'=>30,'maxlength' => 20,'style'=>'width: 322px;'));
                echo $form->error($model,'nombre_corto');
            }
        ?>
        </div><!-- row -->

        
        <div class="rowleft52">
        <?php echo $form->labelEx($model,'division_id',array('class'=>'blockLabel')); ?>
        <?php echo $form->dropDownList($model, 'division_id', GxHtml::listDataEx(Divisiones::model()->findAll(array('condition'=>'estado=1'))),array('style'=>'width: 365px;')); ?>
        <?php echo $form->error($model,'division_id'); ?>
        </div><!-- row -->
        <div class="limpia"></div>
        <div class="rowleft45">
        <?php echo $form->labelEx($model,'descripcion',array('class'=>'blockLabel')); ?>
        <?php echo $form->textArea($model, 'descripcion',array('rows'=>7, 'cols'=>52)); ?>
        <?php echo $form->error($model,'descripcion'); ?>
        </div><!-- row -->        
        
        <?php if($model->tipo_producto_id)
                echo $form->hiddenField($model, 'tipo_producto_id'); 
             else
                 echo $form->hiddenField($model, 'tipo_producto_id',array('value'=>''.$_GET['tipoProducto'])); 
        ?>
		
		
        <?php if($model->tipo_producto_id=='1' || $_GET['tipoProducto']=='1'){
        ?>
            <div class="rowleft45">
               <div class="rowleft45">
                <?php echo $form->labelEx($model,'gestion_territorial',array('class'=>'blockLabel')); ?>
                <?php echo $form->radioButtonList($model,'gestion_territorial',array('1' =>'Sí', '0'=> 'No'),array('class'=>'toggleEnabled','onclick'=>'cambiarEstadoInputSegunCheckbox()','nameTextArea'=>'ProductosEstrategicos_gestion_territorial_descripcion'));?>
                <?php echo $form->error($model,'gestion_territorial'); ?>
                </div><!-- row -->
                 <div class="rowleft45"> 
                <label for="ProductosEstrategicos_gestion_territorial_descripcion" class=" required colon">¿Cómo aplica? </label>               
                <?php echo $form->textArea($model, 'gestion_territorial_descripcion',array('rows'=>2, 'style'=>'width: 270px;')); ?>
                <?php echo $form->error($model,'gestion_territorial_descripcion'); ?>
                </div><!-- row -->
                <div class="limpia"></div>
                <div class="rowleft45">                
                <?php echo $form->labelEx($model,'desagregado_sexo',array('class'=>'blockLabel')); ?>
                <?php echo $form->radioButtonList($model,'desagregado_sexo',array('1' =>'Sí', '0'=> 'No'),array('class'=>'toggleEnabled','onclick'=>'cambiarEstadoInputSegunCheckbox()','nameTextArea'=>'ProductosEstrategicos_desagregado_sexo_descripcion'));?>
                <?php echo $form->error($model,'desagregado_sexo'); ?>
                </div><!-- row -->
                <div class="rowleft45">
                <label for="ProductosEstrategicos_desagregado_sexo_descripcion" class="required colon">¿Cómo aplica? </label>
                <?php echo $form->textArea($model, 'desagregado_sexo_descripcion',array('rows'=>2, 'style'=>'width: 270px;')); ?>
                <?php echo $form->error($model,'desagregado_sexo_descripcion'); ?>
                </div>
                
            </div>
        <?php }else{
                echo '<div class="rowleft45">';
                echo $form->labelEx($model,'nombre_corto');
                echo $form->textField($model, 'nombre_corto', array('size'=>30,'maxlength' => 20,'style'=>'width: 322px;'));
                echo $form->error($model,'nombre_corto');
                echo '</div>';
        }        
        
        
        ?>
        <div class="limpia"></div>
</div><!-- form -->

		<div class="box rowleft47">  
    		<h3>
    		    <label class="required" for="ProductosEstrategicos_clientes">
                    <span class="required"> * </span>
                          <?php echo GxHtml::encode($model->getRelationLabel('clientes'))." ".$model->tipoProducto; ?>
                    </label>
    		 </h3>  
    		  <?php echo $form->error($model,'clientes'); ?> 
    		<div class="grid-view overflow"> 
    		<table class="items">
                <thead>
                <tr><th>Clientes</th><th width="50px">Vínculo</th></tr>
            </thead>
            <tbody>
            <?php echo $form->checkBoxList($model, 'clientes', GxHtml::encodeEx(GxHtml::listDataEx(Clientes::model()->findAll(array('condition'=>'t.estado=1 AND tipo_cliente_id='.$_GET['tipoProducto']))), false, true),array('separator'=>'','template'=>'<tr class="odd"><td>{label}</td><td align="center">{input}</td></tr>')); ?>
        </tbody>
            </table>
        </div>
        </div>
        
        <div class="box rowright47">
		  <h3>
		      <label class="required" for="ProductosEstrategicos_objetivosEstrategicoses">
                  <span class="required"> * </span>
                  <?php echo GxHtml::encode($model->getRelationLabel('objetivosEstrategicoses')); ?>
             </label> 
		      
		  </h3>
		   <?php echo $form->error($model,'objetivosEstrategicoses'); ?>
        <div class="grid-view overflow"> 
        <table class="items">
            <thead>
              <tr><th>Objetivos</th><th width="50px">Vínculo</th></tr>
            </thead>
            <tbody>
            <?php echo $form->checkBoxList($model, 'objetivosEstrategicoses', GxHtml::encodeEx(GxHtml::listDataEx(ObjetivosEstrategicos::model()->findAll(array('select'=>'t.*','distinct'=>'true','condition'=>'pp.id = '.Yii::app()->session['idPeriodo'].' AND t.estado = 1','join'=>'INNER JOIN desafios_objetivos do ON t.id = do.objetivo_estrategico_id            INNER JOIN desafios_estrategicos de ON do.desafio_estrategico_id = de.id            INNER JOIN planificaciones pl ON de.planificacion_id = pl.id            INNER JOIN periodos_procesos pp ON pl.periodo_proceso_id = pp.id'))), false, true),array('separator'=>'','template'=>'<tr class="odd"><td>{label}</td><td align="center">{input}</td></tr>')); ?>
        </tbody>
            </table>
             </div> 
        </div>           
        <div class="limpia"></div>
<div class="row buttons">        
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Guardar'); ?>
    </div>		
<?php
$this->endWidget();
?>
