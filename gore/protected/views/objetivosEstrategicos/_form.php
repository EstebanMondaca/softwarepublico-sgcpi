<div class="form">


<?php 

Yii::app()->clientScript->registerScript('disenio', "
    $(document).ready(function() {
        $('table tr').removeClass();
        $('table tr:even').addClass('even');
        $('table tr:odd').addClass('odd');
    });
");


$form = $this->beginWidget('GxActiveForm', array(
	'id' => 'objetivos-estrategicos-form',
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

        <div class="rowleft72">
		<?php echo $form->labelEx($model,'nombre'); ?>
		<?php echo $form->textField($model, 'nombre', array('style'=>'width: 510px;','maxlength' => 200)); ?>
		<?php echo $form->error($model,'nombre'); ?>
		</div><!-- row -->
		<div class="rowright23">
            <?php echo $form->labelEx($model,'perspectiva_estrategica_id',array('class'=>'blockLabel')); ?>
         <?php echo $form->radioButtonList($model, 'perspectiva_estrategica_id', GxHtml::encodeEx(GxHtml::listDataEx(PerspectivasEstrategicas::model()->findAllByAttributes(array('estado'=>'1'))), false, true), array('class'=>'formCheckbox')); ?>
            <?php echo $form->error($model,'perspectiva_estrategica_id'); ?>
        </div><!-- row -->
		<div class="rowleft72">
		<?php echo $form->labelEx($model,'descripcion',array('class'=>'blockLabel')); ?>
		<?php echo $form->textArea($model,'descripcion',array('rows'=>3, 'style'=>'width: 632px;')); ?>
		<?php echo $form->error($model,'descripcion'); ?>
		</div><!-- row -->		
		
		<div class="limpia"></div>
</div><!--fin box containerIframeUpdate-->		
		
        <div class="rowleft47 box">   
             <h3><?php echo $form->labelEx($model,'objetivosMinisteriales');//echo GxHtml::encode($model->getRelationLabel('objetivosMinisteriales')); ?></h3>
             <?php echo $form->error($model,'objetivosMinisteriales'); ?>
             <div class="grid-view overflow">                
              <table class="items">
                <thead>
                <tr><th>Objetivos</th><th width="40px">Vínculo</th></tr>
            </thead>
              <?php echo $form->checkBoxList($model, 'objetivosMinisteriales', GxHtml::encodeEx(GxHtml::listDataEx(ObjetivosMinisteriales::model()->buscarObjetivosMinisteriales()), false, true),array('separator'=>'','template'=>'<tr class="odd"><td>{label}</td><td>{input}</td></tr>')); ?>
         </tbody>
            </table>
            </div>
        </div>
        <div class="rowright47 box">
             <h3><?php echo $form->labelEx($model,'desafiosEstrategicoses');//GxHtml::encode($model->getRelationLabel('desafiosEstrategicoses')); ?></h3>
                <?php echo $form->error($model,'desafiosEstrategicoses'); ?>
                <input type="hidden" name="ObjetivosEstrategicos[desafiosEstrategicoses]" value="" id="ytObjetivosEstrategicos_desafiosEstrategicoses">
            <div class="grid-view overflow">    		     
        		<table class="items">
        		<thead>
        		  <tr><th>Desafíos Estratégicos</th><th width="40px">Vínculo</th></tr>
        		</thead>
        		<tbody>
        		      <?php        		          
        		          //echo $form->checkBoxList($model, 'desafiosEstrategicoses', GxHtml::encodeEx(GxHtml::listDataEx(DesafiosEstrategicos::model()->findAll(array('condition'=>'pp.id = '.Yii::app()->session['idPeriodo'].' AND t.estado = 1','join'=>'INNER JOIN planificaciones p ON t.planificacion_id=p.id inner join periodos_procesos pp on pp.id=p.periodo_proceso_id'))), false, true),array('separator'=>'','template'=>'<tr class="odd"><td>{label}</td><td>{input}</td></tr>')); 
        		          $consulta=DesafiosEstrategicos::model()->findAll(array('condition'=>'pp.id = '.Yii::app()->session['idPeriodo'].' AND t.estado = 1','join'=>'INNER JOIN planificaciones p ON t.planificacion_id=p.id inner join periodos_procesos pp on pp.id=p.periodo_proceso_id'));
        		          $SeleccionadosArray=(isset($model->desafiosEstrategicoses[0]))?GxHtml::listDataEx($model->desafiosEstrategicoses,'id','id'):array();
        		          $i=0;
         		          foreach($consulta as $value){
        		              $selected='';
                              $disabled='';
                              if(isset($value->objetivosEstrategicoses[0])){
                                  $disabled=' disabled="disabled" title="Desafío asociado con el objetivo: '.$value->objetivosEstrategicoses[0]->nombre.'" ';
                              }
        		              if(in_array($value->id,$SeleccionadosArray)){
        		                  $disabled='';
        		                  $selected=' checked="checked "';
        		              }
        		              echo '<tr><td>'.$value->nombre.'</td><td><input type="checkbox" name="ObjetivosEstrategicos[desafiosEstrategicoses][]" value="'.$value->id.'" '.$selected.$disabled.' id="ObjetivosEstrategicos_desafiosEstrategicoses_'.$i.'"></td></tr>';
        		              $i++;
                          }
        		          ?>
        		  </tbody>
        		</table>
    		</div>
		</div>
		
        
		<div class="limpia"></div>		
<div class="row buttons">        
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Guardar'); ?>
    </div>
<?php
//echo GxHtml::submitButton(Yii::t('app', 'Save'));

$this->endWidget();
?>
