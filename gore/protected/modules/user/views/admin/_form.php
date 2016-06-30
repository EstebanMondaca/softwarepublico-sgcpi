<?php
Yii::app()->clientScript->registerScript('disenio', "
    /*$(document).ready(function() {
        $('.perfiles').change(function(){
             if($(this).is(':checked')){
                 if($('.perfiles[value=\"admin\"]').is(':checked')){
                    $('input[value!=\"admin\"]').attr('checked', false);
                }
             } 
        });
        
        if($('.perfiles[value=\"admin\"]').is(':checked')){
            $('input[value!=\"admin\"]').attr('checked', false);
        }
    });*/
");
?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	'enableAjaxValidation'=>true,
	'htmlOptions' => array('enctype'=>'multipart/form-data'),
));
?>
    <?php 
        if(isset($titulo)) echo "<h3>".$titulo."</h3>";
    ?>
	<p class="note"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p>

	<?php 
	   //RCP echo $form->errorSummary(array($model,$profile));
	   echo $form->errorSummary(array($model)); 
	?>
    <table border="0" cellspacing="5" cellpadding="5">
        <tr>
            <td align="right" width="150px"><?php echo $form->labelEx($model,'username'); ?></td>
            <td><?php 
                    if($model->isNewRecord){
                            echo $form->textField($model,'username',array('style'=>'width: 250px;','maxlength'=>20)); 
                    }else{
                         if($model->username=='adminspcg'){
                             echo $form->textField($model,'username',array('style'=>'width: 250px;','maxlength'=>20,'readonly'=>true)); 
                         }else{
                             echo $form->textField($model,'username',array('style'=>'width: 250px;','maxlength'=>20)); 
                         }
                    }
                 ?>
                <?php echo $form->error($model,'username'); ?></td>
            <td align="right" width="150px"><?php echo $form->labelEx($model,'password'); ?></td>
            <td><?php 
                if($model->isNewRecord){
                    echo $form->passwordField($model,'password',array('maxlength'=>128,'style'=>'width: 250px;','value'=>'123456','readonly'=>true));    
                }else{
                    if($model->username=='adminspcg'){
                        echo $form->passwordField($model,'password',array('maxlength'=>128,'style'=>'width: 250px;')); 
                    }else{
                        echo $form->passwordField($model,'password',array('maxlength'=>128,'style'=>'width: 250px;','readonly'=>true)); 
                    }
                }
                ?>
                <?php echo $form->error($model,'password'); ?></td>
        </tr>
        <tr>
            <td align="right"><?php echo $form->labelEx($model,'email'); ?></td>
            <td><?php echo $form->textField($model,'email',array('style'=>'width: 250px;','maxlength'=>128)); ?>
        <?php echo $form->error($model,'email'); ?></td>
            <td align="right"> <?php echo $form->labelEx($model,'cargo_id'); ?></td>
            <td><?php echo $form->dropDownList($model,'cargo_id',CHtml::listData(Cargos::model()->findAll(array('condition'=>'t.estado=1')), 'id', 'nombre'),array('style'=>'width: 266px;')); ?>
            <?php echo $form->error($model,'cargo_id'); ?>  </td>
        </tr>
        <tr>
            <td align="right"> <?php //echo $form->labelEx($model,'superuser'); ?></td>
            <td><?php //echo $form->dropDownList($model,'superuser',User::itemAlias('AdminStatus'),array('style'=>'width: 266px;')); ?>
            <?php //echo $form->error($model,'superuser'); ?></td>
            <td align="right"> <?php echo $form->labelEx($model,'status'); ?></td>
            <td >   <?php echo $form->dropDownList($model,'status',User::itemAlias('UserStatus'),array('style'=>'width: 266px;')); ?>
            <?php echo $form->error($model,'status'); ?>
            </td>
        </tr>
        <tr>
            <td align="right"><?php echo $form->labelEx($model,'nombres'); ?></td>
            <td><?php echo $form->textField($model,'nombres',array('style'=>'width: 252px;','maxlength'=>128)); ?>
        <?php echo $form->error($model,'nombres'); ?></td>
            <td align="right"><?php echo $form->labelEx($model,'ape_paterno'); ?></td>
            <td><?php echo $form->textField($model,'ape_paterno',array('style'=>'width: 254px;','maxlength'=>128)); ?>
        <?php echo $form->error($model,'ape_paterno'); ?></td>
            
        </tr>
    
        <tr>
            <td align="right"><?php echo $form->labelEx($model,'ape_materno'); ?></td>
            <td><?php echo $form->textField($model,'ape_materno',array('style'=>'width: 250px;','maxlength'=>128)); ?>
        <?php echo $form->error($model,'ape_materno'); ?></td>
        <td></td>
            <td></td>
        </tr>        
    </table>   
    
 </div><!-- form -->   
	<div class="box rowright47">
              <h3><?php echo $form->labelEx($model,'centrosCostoses'); ?></h3>
              <?php echo $form->error($model,'centrosCostoses'); ?>
              
            <div class="grid-view overflow"> 
            <table class="items">
            <thead>
              <tr><th width="70%">Centros de costo</th><th>Acción</th></tr>
            </thead>
            <tbody>
              <?php 
              //$arrayCentros = CHtml::listData(CentrosCostos::model()->with('division')->findAll(array('condition'=>'t.estado=1','order'=>'division.nombre,t.nombre')), 'id', 'nombre');
              $arrayCentros = CentrosCostos::model()->with('division')->findAll(array('condition'=>'t.estado=1','order'=>'division.nombre,t.nombre'));
              $arraySelectedCentros=CHtml::listData($model->centrosCostoses,'id','id');
              $x=0;   
              //criteria para validar relacion del usuario con algun centro de costo a través del indicador
              if($model->isNewRecord){
                  $arraySelectedCentrosPorIndicador=array();
              }else{
                  $criteria = new CDbCriteria;
                  $id_usuario=$model->id; 
                  $criteria->join=' 
                    LEFT JOIN lineas_accion la on t.id=la.id_indicador                 
                    LEFT JOIN productos_especificos pes on t.producto_especifico_id=pes.id
                    LEFT JOIN subproductos sp on pes.subproducto_id=sp.id
                    INNER JOIN productos_estrategicos pe on sp.producto_estrategico_id=pe.id or la.producto_estrategico_id=pe.id
                    INNER JOIN objetivos_productos op ON pe.id = op.producto_estrategico_id
                    INNER JOIN objetivos_estrategicos oe ON op.objetivo_estrategico_id = oe.id
                    INNER JOIN desafios_objetivos do2 ON  oe.id = do2.objetivo_estrategico_id
                    INNER JOIN desafios_estrategicos de ON do2.desafio_estrategico_id = de.id
                    INNER JOIN planificaciones pl ON de.planificacion_id = pl.id 
                    INNER JOIN centros_costos cc on sp.centro_costo_id=cc.id or la.centro_costo_id=cc.id
                    INNER JOIN periodos_procesos pp ON pl.periodo_proceso_id = pp.id';
                    $criteria->distinct =true;
                    $criteria->select='cc.id as centro_costo_id';
                    $criteria->addCondition('t.estado = 1 AND t.responsable_id='.$id_usuario);
                  $indicadores_por_cc=Indicadores::model()->findAll($criteria);                  
                  $arraySelectedCentrosPorIndicador=CHtml::listData($indicadores_por_cc,'centro_costo_id','centro_costo_id');
              }    
              $nombreDision="";   
              foreach($arrayCentros as $v):
                  $parOImpar=$x%2?"even":"odd";
                  if($nombreDision!=$v->division->nombre){
                      $nombreDision=$v->division->nombre;
                      echo "<tr class=".$parOImpar."><td colspan='2'><strong>".$nombreDision."</strong></td></tr>";
                      $x++;
                      $parOImpar=$x%2?"even":"odd";
                  }
                  echo "<tr class=".$parOImpar.">";
                  echo "<td><label class='blockquote' for=\"User_centrosCostoses_".$x."\">".$v->nombre."</label></td>";
                  if (array_key_exists($v->id, $arraySelectedCentros)){
                      if (array_key_exists($v->id, $arraySelectedCentrosPorIndicador)){
                          echo "<td><input title='El centro de costo está asociado a un indicador donde el usuario es responsable. No es posible desvincularlo.' type=\"checkbox\" name=\"User[centrosCostoses][]\" onclick='return false' onkeydown='return false' checked=\"checked\" value=\"".$v->id."\" id=\"User_centrosCostoses_".$x."\"></td>";
                      }else{
                            echo "<td><input type=\"checkbox\" name=\"User[centrosCostoses][]\" checked=\"checked\" value=\"".$v->id."\" id=\"User_centrosCostoses_".$x."\"></td>";     
                      }                          
                  }else{
                      echo "<td><input type=\"checkbox\" name=\"User[centrosCostoses][]\" value=\"".$v->id."\" id=\"User_centrosCostoses_".$x."\"></td>";
                  }
                  echo "</tr>";
                    $x++; 
              endforeach;                 
              /*foreach($arrayCentros as $k=>$v):
                  $parOImpar=$x%2?"even":"odd";
                  if($nombreDision!=$v->division){
                      $nombreDision=$v->division->nombre;
                      echo "<tr class=".$parOImpar."><td colspan='2'>".$nombreDision."</td></tr>";
                      $x++;
                      $parOImpar=$x%2?"even":"odd";
                  }
                  echo "<tr class=".$parOImpar.">";
                  echo "<td><blockquote><label for=\"User_centrosCostoses_".$x."\">".$v."</label></blockquote></td>";
                  if (array_key_exists($k, $arraySelectedCentros)){
                      if (array_key_exists($k, $arraySelectedCentrosPorIndicador)){
                          echo "<td><input title='El centro de costo está asociado a un indicador donde el usuario es responsable. No es posible desvincularlo.' type=\"checkbox\" name=\"User[centrosCostoses][]\" onclick='return false' onkeydown='return false' checked=\"checked\" value=\"".$k."\" id=\"User_centrosCostoses_".$x."\"></td>";
                      }else{
                            echo "<td><input type=\"checkbox\" name=\"User[centrosCostoses][]\" checked=\"checked\" value=\"".$k."\" id=\"User_centrosCostoses_".$x."\"></td>";     
                      }                          
                  }else{
                      echo "<td><input type=\"checkbox\" name=\"User[centrosCostoses][]\" value=\"".$k."\" id=\"User_centrosCostoses_".$x."\"></td>";
                  }
                  echo "</tr>";
                    $x++; 
              endforeach;*/
              ?>    
                
            </tbody>
     
            </table>
            </div>
    </div>
	<div class="box rowleft47">
              <h3><?php echo $form->labelEx($model,'authItems'); ?></h3>
              <?php echo $form->error($model,'authItems'); ?>
              <div class="grid-view overflow"> 
            <table class="items">
            <thead>
              <tr><th width="70%">Perfiles</th><th>Acción</th></tr>
            </thead>
        <tbody>  
              
              <?php 
              $arrayPerfiles = CHtml::listData(AuthItem::model()->findAll(), 'name', 'description');
              $arraySelectedPerfiles=CHtml::listData($model->authItems,'name','name');
              $x=0;   
                         
              foreach($arrayPerfiles as $k=>$v):
                  $parOImpar=$x%2?"even":"odd";
                  echo "<tr class=".$parOImpar.">";
                  echo "<td><label for=\"User_authItems_".$x."\">".ucfirst($v)."</label></td>";
                  if (array_key_exists($k, $arraySelectedPerfiles)) {
                     echo "<td><input type=\"radio\" class=\"perfiles\" name=\"User[authItems][]\" checked=\"checked\" value=\"".$k."\" id=\"User_authItems_".$x."\"></td>";     
                  }else{
                      echo "<td><input type=\"radio\" class=\"perfiles\" name=\"User[authItems][]\" value=\"".$k."\" id=\"User_authItems_".$x."\"></td>";
                  }
                  echo "</tr>";
              ?>    
              
              <?php $x++; endforeach; ?>     
     </tbody>
     
            </table>
        </div>
    </div>
    
    <div class="limpia"></div>
    
<?php 
		/*$profileFields=$profile->getFields();
		if ($profileFields) {
			foreach($profileFields as $field) {
			
	       echo '<div class="row">';
		 echo $form->labelEx($profile,$field->varname); 
         
		if ($widgetEdit = $field->widgetEdit($profile)) {
			echo $widgetEdit;
		} elseif ($field->range) {
			echo $form->dropDownList($profile,$field->varname,Profile::range($field->range));
		} elseif ($field->field_type=="TEXT") {
			echo CHtml::activeTextArea($profile,$field->varname,array('rows'=>6, 'cols'=>50));
		} else {
			echo $form->textField($profile,$field->varname,array('size'=>60,'maxlength'=>(($field->field_size)?$field->field_size:255)));
		}
		 ?>
		<?php echo $form->error($profile,$field->varname); 
	       echo "</div>";
			
			}
		}*/
?>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? UserModule::t('Create') : UserModule::t('Save')); ?>
	</div>

<?php $this->endWidget(); ?>

