<?php
Yii::app()->clientScript->registerScript('ready', "
    var atributos='';
    $('#la-elem-gestion-grid tbody td.id_elem_gestion input').each(function(){
            if($(this).parent('td').parent('tr').not('.deleteRecord')){
                atributos+='el[]='+$(this).val()+'&';
            }
    });
    
    $('#agregarLA').attr('href',$('#urlSitioWeb').val()+'/ElementosGestion/indexLA/?idLA=".$model->id."&'+atributos);
    
        
        $('.puntaje_esperado input').keyup(function(){
            $('.labelpuntaje_elemento').each(function(){
                 var total=(parseFloat($(this).parent('td').parent('tr').children('.puntaje_esperado').children('input').val()) - parseFloat($(this).parent('td').parent('tr').children('.puntaje_actual').html()))*parseFloat($(this).prev('input.puntaje_elemento').val());
                 total=Math.round(total*100)/100;//con 2 decimales                 
                 if(isNaN(parseFloat(total))){
                     $(this).html('0');
                 }else{
                     $(this).html(total);
                 }
                 
            });          
        });
        
        $('.puntaje_esperado input').change(function() {
            //Validando de que no este mal ingresado el numero
            if(isNaN(parseFloat($(this).val())) || $(this).val()==''){
                $(this).val('0');
            }else{
                if($(this).val()<6){
                    $(this).val(parseFloat($(this).val()));
                }else{
                    $(this).val('0');
                }
                
            }
            $(this).keyup();
        });
        
        $('.puntaje_esperado input').eq(0).change();
        
        //Cargando centros de costos
        $('#LineasAccion_producto_estrategico_id').change();
        
",3);
?>



<div class="form">

<?php 
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js');

    $form = $this->beginWidget('GxActiveForm', array(
	'id' => 'lineas-accion-form',
	'enableAjaxValidation' => true,
));
?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php 
	   echo $form->errorSummary($model); 
	   
	?>
      
     <table border="0" cellspacing="5" cellpadding="5" width="100%">
        <tr>
            <td align="right"><?php echo $form->labelEx($model,'id_tipo_la'); ?></td>
            <td><?php echo $form->dropDownList($model, 'id_tipo_la', GxHtml::listDataEx(TiposLa::model()->findAll(array('condition'=>'t.estado=1')))); ?>
        <?php echo $form->error($model,'id_tipo_la'); ?></td>
        </tr>
        <tr>
            <td align="right"><?php echo $form->labelEx($model,'nombre'); ?></td>
            <td><?php echo $form->textField($model, 'nombre', array('maxlength' => 300,'style'=>'width: 720px;')); ?>
        <?php echo $form->error($model,'nombre'); ?></td>
        </tr>
        <tr>
            <td align="right"><?php echo $form->labelEx($model,'descripcion'); ?></td>
            <td><?php echo $form->textArea($model, 'descripcion',array('style'=>'width: 718px;','rows'=>2)); ?>
        <?php echo $form->error($model,'descripcion'); ?></td>
        </tr>
        
     </table>
		
		
	<div class="fieldset2">
	    <div class="legend">Asignación Responsabilidad Interna</div>
	    <table border="0" cellspacing="5" cellpadding="5" width="100%">
            <tr>
                <td align="right" style="width: 176px;"><?php echo $form->labelEx($model,'producto_estrategico_id'); ?></td>
                <td style="width: 230px;"><?php echo $form->dropDownList($model, 'producto_estrategico_id', GxHtml::listDataEx(ProductosEstrategicos::model()->findAll(array('condition'=>'t.estado = 1  AND pp.id = '.Yii::app()->session['idPeriodo'],'join'=>'INNER JOIN objetivos_productos op ON t.id = op.producto_estrategico_id
                INNER JOIN objetivos_estrategicos oe ON op.objetivo_estrategico_id = oe.id
                INNER JOIN desafios_objetivos do2 ON  oe.id = do2.objetivo_estrategico_id
                INNER JOIN desafios_estrategicos de ON do2.desafio_estrategico_id = de.id
                INNER JOIN planificaciones pl ON de.planificacion_id = pl.id 
                INNER JOIN periodos_procesos pp ON pl.periodo_proceso_id = pp.id'))),array(
                'ajax' => array(
                    'type' => 'POST',
                    'url' => CController::createUrl('lineasAccion/cargarCentroCosto'),
                    'success' => 'function(data){ $("#LineasAccion_centro_costo_id").empty().append(data); $("#LineasAccion_centro_costo_id").change();}',
                    'beforeSend'=>'function(){$("#LineasAccion_centro_costo_id").empty().append("<option value=\"0\">Cargando...</option>");}',
                    'error'=>'function(){$("#LineasAccion_centro_costo_id").empty();}',                    
                )   
                )); ?>
                    <?php echo $form->error($model,'producto_estrategico_id'); ?>
                </td>
                <td rowspan="5">
                    <!--start actores internos-->                    
                    <div class="box">       
        
                          <h3><?php echo GxHtml::encode($model->getRelationLabel('users')); ?></h3>
                          <input type="hidden" name="LineasAccion[users]" value="" id="ytLineasAccion_users">
                          <div class="grid-view overflow"> 
                                <table class="items">
                                <thead>
                                  <tr><th width="50%">Nombre</th><th width="35%">Cargo</th><th>Vínculo</th></tr>
                                </thead>
                                <tbody>  
                                          
                                          <?php 
                                          $arrayPerfiles = CHtml::listData(User::model()->with('authItems')->findAll(array('order'=>'user.ape_paterno ASC','condition'=>'user.status=1 AND user.estado=1 AND authItems.name="gestor"')),'id','nombreycargo');
                                          $arraySelectedPerfiles=CHtml::listData($model->users,'id','nombrecompleto');
                                          $x=0;                                                        
                                          foreach($arrayPerfiles as $k=>$v):
                                              $parOImpar=$x%2?"even":"odd";
                                              echo "<tr class=".$parOImpar.">";
                                              echo "<td><label for=\"LineasAccion_users_".$x."\">".$v[0]."</label></td>";
                                              echo "<td>".$v[1]."</td>";
                                              if (array_key_exists($k, $arraySelectedPerfiles)) {
                                                 echo "<td align='center'><input type=\"checkbox\" name=\"LineasAccion[users][]\" checked=\"checked\" value=\"".$k."\" id=\"LineasAccion_users_".$x."\"></td>";     
                                              }else{
                                                  echo "<td align='center'><input type=\"checkbox\" name=\"LineasAccion[users][]\" value=\"".$k."\" id=\"LineasAccion_users_".$x."\"></td>";
                                              }
                                              echo "</tr>";
                                          ?>    
                                          
                                          <?php $x++; endforeach; ?>     
                                 </tbody>
                         
                                </table>
                        </div>
                    </div>
                    
                    <!--end actores internos-->
                </td>
            </tr>
            <tr>
                <td align="right"><?php echo $form->labelEx($model,'centro_costo_id'); ?></td>
                <td>
                    <?php 
                        //echo "<h1>".$model->producto_estrategico_id->getPrimaryKey()."</h1>";
                        if($model->producto_estrategico_id){
                            echo $form->dropDownList($model, 'centro_costo_id', GxHtml::listDataEx(CentrosCostos::model()->findAll(array('condition'=>'t.division_id='.$model->productoEstrategico->division->getPrimaryKey()))),array(
                            'ajax' => array(
                                'beforeSend'=>'function() {$("#LineasAccion_id_responsable_mantencion").empty().append("<option>Cargando...</option>"); }',
                                'type'=>'POST', //request type
                                'url'=>CController::createUrl('CentrosCostos/usuariosPorCentroCosto'), 
                                'update'=>'#LineasAccion_id_responsable_mantencion', 
                            ))); 
                        }else{
                            echo $form->dropDownList($model, 'centro_costo_id', array(),array(
                            'ajax' => array(
                                'beforeSend'=>'function() {$("#LineasAccion_id_responsable_mantencion").empty().append("<option>Cargando...</option>"); }',
                                'type'=>'POST', //request type
                                'url'=>CController::createUrl('CentrosCostos/usuariosPorCentroCosto'), 
                                'update'=>'#LineasAccion_id_responsable_mantencion', 
                            ))); 
                        }                        
                        
                    ?>
                    
                    <?php echo $form->error($model,'centro_costo_id'); ?></td>
            </tr>
            <tr>
                <td align="right"><?php echo $form->labelEx($model,'id_responsable_implementacion'); ?>:</td>
                <td>
                    
                    <?php 
                        if(isset($model->id_responsable_implementacion)){
                            echo $form->hiddenField($model, 'id_responsable_implementacion');
                            echo '<label id="nombreResponsableLA">'.$model->idResponsableImplementacion->nombrecompleto.'</label>';
                        }else{                
                            echo $form->hiddenField($model, 'id_responsable_implementacion',array('value'=>Yii::app()->user->id));
                            $user=User::model()->findbypk(Yii::app()->user->id);
                            if(isset($user))
                                echo '<label id="nombreResponsableLA">'.$user->nombrecompleto.'</label>';;
                        }
                         
                        
                        ?>
                    
                    </td>
            </tr>
            <tr>
                <td align="right"><?php echo $form->labelEx($model,'id_responsable_mantencion'); ?></td>
                <td><?php 
                        if($model->producto_estrategico_id){
                            echo $form->dropDownList($model, 'id_responsable_mantencion', GxHtml::listDataEx(User::model()->responsablesPorCentroCosto($model->centro_costo_id),'id','nombrecompleto')); 
                        }else{
                            echo $form->dropDownList($model, 'id_responsable_mantencion', array()); 
                        }                        
                    ?>
                    <?php echo $form->error($model,'id_responsable_mantencion'); ?></td>
            </tr> 
            <tr>
                <td height="60">&nbsp;</td>
                <td></td>
            </tr>                   
        </table>
	</div>	<!--end fieldset-->
		
	<div class="fieldset2">
        <div class="legend">Información de Cumplimiento</div>
        <?php
            if(isset($model->id_indicador)){
                echo $form->hiddenField($model, 'id_indicador');
            }else{                
                echo $form->hiddenField($model, 'id_indicador',array('value'=>''));
            }
            echo $form->error($model,'id_indicador');
        ?>       
        <table id="informacionCumplimiento" width="100%" border="0" cellspacing="5" cellpadding="5">
          <tr>
            <td width="143">
                <a id="agregarIndicador" class="boton2 left update" onclick="return false;" href="<?php echo Yii::app()->request->baseUrl;?>/indicadores/<?php echo ($model->isNewRecord && (!isset($model->id_indicador) || is_null($model->id_indicador)))? 'createnew/' : 'updatenew/'.$model->id_indicador; ?>"><?php echo $model->isNewRecord ? 'Agregar' : 'Editar'; ?> Indicador</a></td>
            <td width="137" align="right"><label>Indicador de Cumplimiento</label></td>
            <td colspan="3"><?php echo $form->textArea($model, 'idIndicador[descripcion]',array('style'=>'width: 560px;','rows'=>2,'disabled'=>'disabled')); ?></td>
          </tr>
          <tr>
            <td rowspan="2">&nbsp;</td>
            <td rowspan="2" align="right"><label>Medio de Verificación</label></td>
            <td width="280" rowspan="2"><?php echo $form->textArea($model, 'idIndicador[medio_verificacion]',array('style'=>'width: 275px;','rows'=>2,'disabled'=>'disabled')); ?></td>
            <td width="129" align="right"><label>Meta Anual</label></td>
            <td width="115"><?php echo $form->textField($model, 'idIndicador[meta_anual]', array('maxlength' => 100,'style'=>'width: 100px;','disabled'=>'disabled')); ?></td>
          </tr>
          <tr>
            <td align="right"><label>Frecuencia de Control</label></td>
            <td width="115"><?php echo $form->textField($model, 'idIndicador[frecuenciaControl]', array('maxlength' => 100,'style'=>'width: 100px;','disabled'=>'disabled')); ?></td>
          </tr>
        </table>        
        
             
   </div>
   <div class="fieldset2 grid-view">
        <div class="legend">Elementos de Gestión Asociados</div>       
        <?php 
        if($model->isNewRecord){
              echo "<p>* Para poder asociar elementos de gestión, es necesario almacenar los cambios.</p>";
        }else{
            echo '<ul id="yw1" class="MenuOperations"><li><a id="agregarLA" onclick="return validarCentroCostoConLA();" href="'.Yii::app()->request->baseUrl.'/ElementosGestion/indexLA" class="cboxElement">Agregar</a></li></ul>';
            $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'la-elem-gestion-grid',
                'dataProvider' => $modelLA->searchLineasAccion(), 
                'enableSorting'=>false,
                'enablePagination'=>false,                                                          
                'columns' => array(                         
                    array(
                            'header'=>'Elementos de Gestión',
                            'name'=>'id_elem_gestion',
                            'value'=>'$data->idElemGestion->n_elementogestion',
                            'htmlOptions'=>array('width'=>'90'),
                    ),                
                    array(
                            'header'=>'Nombre elementos de gestión',
                            'name'=>'nombre',
                            'value'=>'$data->idElemGestion->nombre',
                         ),
                    array(
                            'header'=>'Puntaje Actual',
                            'name'=>'puntaje_actual',
                            'value'=>'$data->idElemGestion->ultimoPuntajeActual',
                            'htmlOptions'=>array('width'=>'90','class'=>'puntaje_actual'),
                         ),
                    array(
                            'header'=>'Puntaje Esperado',
                            'name'=>'puntaje_esperado',
                            'type'=>'raw',                            
                            'value'=>'CHtml::textField("LaElemGestion[$row][puntaje_esperado][$data->id]",$data->puntaje_esperado,array("style"=>"width:40px;","maxlength"=>"1"))',
                            'htmlOptions'=>array('width'=>'90','class'=>'puntaje_esperado'),
                         ),
                    array(
                            'type'=>'raw',
                            'value'=>'CHtml::hiddenField("LaElemGestion[$row][id_elem_gestion]",$data->id_elem_gestion)',
                            'htmlOptions'=>array('style'=>'width:0%; display:none','class'=>'id_elem_gestion'),
                            'headerHtmlOptions'=>array('style'=>'width:0%; display:none')
                    ),
                    array(
                            'type'=>'raw',
                            'header'=>'Diferencia Ponderada',
                             'value'=>'CHtml::hiddenField("puntaje_elemento",$data->idElemGestion->idSubcriterio->puntaje_elemento,array("class"=>"puntaje_elemento"))." ".CHtml::label("","puntaje_elemento",array("class"=>"labelpuntaje_elemento"))',
                            'htmlOptions'=>array('width'=>'90'),
                         ),
                    array(
                            'type'=>'raw',
                            'value'=>'CHtml::hiddenField("LaElemGestion[$row][id]",$data->id)',
                            'htmlOptions'=>array('style'=>'width:0%; display:none','class'=>'id_la_elem_gestion'),
                            'headerHtmlOptions'=>array('style'=>'width:0%; display:none')
                    ),
                    array(
                        'class' => 'CButtonColumn',
                        'template'=>'{delete2}',
                        'header' => 'Acción',
                        'buttons'=>array(                  
                        'delete2'=>
                                array(                                        
                                        'imageUrl'=>Yii::app()->request->baseUrl.'/images/delete.png',
                                        'label'=>'',
                                        'url'=>'$this->grid->controller->createUrl("#")',
                                        'options'=>array('onclick'=>'return eliminandoElementoGestionAsociadoLA(this);'),
                                    ),
                        ),      
                    ),
                ),
            ));         
        }
        ?>
        
    </div>
	<input type="hidden" name="idLA" id="idLa" value="<?php echo $model->id;?>"/>	
	<input type="hidden" name="centroCostoOriginal" id="centroCostoOriginal" value="<?php echo $model->centro_costo_id;?>"/>

		<label><?php //echo GxHtml::encode($model->getRelationLabel('laElemGestions')); ?></label>
		<?php //echo $form->checkBoxList($model, 'laElemGestions', GxHtml::encodeEx(GxHtml::listDataEx(LaElemGestion::model()->findAllAttributes(null, true)), false, true)); ?>

<?php
echo GxHtml::submitButton(Yii::t('app', 'Save'));
$this->endWidget();
?>
</div><!-- form -->