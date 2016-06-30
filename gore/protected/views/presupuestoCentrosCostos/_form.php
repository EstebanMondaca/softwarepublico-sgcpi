<?php 
Yii::app()->clientScript->registerScript('habilitar', "
    
    $('.desabilitarInputText').change(function(){
            if($(this).is(':checked')){
                $('#Productos_productosItemes_'+$(this).val()).removeAttr('disabled');
            }else{
                $('#Productos_productosItemes_'+$(this).val()).attr('disabled','disabled');
            }
            var montoTotal=0;
            $('.inputMontos:not(:disabled)').each(function(){
                  if (/^([0-9])*$/.test($(this).val()) && $(this).val()!=''){
                      montoTotal+=parseInt($(this).val());
                  }
            });            
            $('#totalOP').html(montoTotal);
            
           
           $('.inputPorcentaje').each(function(){
               if (!/^([0-9])*$/.test($(this).val()) || $(this).val()==''){
                   $(this).val(0);
               }
               var montoTotalDesdePorcentaje=parseInt($(this).val())*parseInt($('#totalOP').html())/100;
               montoTotalDesdePorcentaje=Math.round(montoTotalDesdePorcentaje); 
               $(this).parent().parent().children('.presupuestoOP').html('$'+montoTotalDesdePorcentaje);
           });
        
    });
    //Calculando valores totales a medida que el usuario escribe montos.
    $('.inputMontos').on('keyup', function(){
        var montoTotal=0;
        $('.inputMontos:not(:disabled)').each(function(){
              if (/^([0-9])*$/.test($(this).val()) && $(this).val()!=''){
                  montoTotal+=parseInt($(this).val());
              }
        });            
        $('#totalOP').html(montoTotal);        
        //Debemos recalcular el nuevo valor para cada porcentaje
        $('.inputPorcentaje').each(function(){            
           if (!/^([0-9])*$/.test($(this).val()) || $(this).val()==''){
               $(this).val(0);
           }
           var montoTotalDesdePorcentaje=parseInt($(this).val())*parseInt($('#totalOP').html())/100;
           montoTotalDesdePorcentaje=Math.round(montoTotalDesdePorcentaje); 
           $(this).parent().parent().children('.presupuestoOP').html('$'+montoTotalDesdePorcentaje);
       });
    });
    
    $('.inputPorcentaje').on('keyup', function(){
        if (!/^([0-9])*$/.test($(this).val())){
              $(this).val(0);
        }
        if($(this).val()=='')
            return false;
        
       var porcentajeTotal=0; 
       //validamos que los valores ingresados como porcentaje previamente no sean error
       $('.inputPorcentaje').each(function(){
           if (/^([0-9])*$/.test($(this).val()) && $(this).val()!=''){
                  porcentajeTotal+=parseInt($(this).val());
           }else{
               $(this).val(0);
           }
       });
        if(porcentajeTotal>100){
            $(this).val(0);
        }/*else if(porcentajeTotal<100){
            $('#errorDistribucion,.errorSummary').show();
            $('.inputPorcentaje').addClass('error');
        }else{
            $('#errorDistribucion,.errorSummary').hide();
            $('.inputPorcentaje').removeClass('error');
        }*/
        var montoTotalDesdePorcentaje=parseInt($(this).val())*parseInt($('#totalOP').html())/100;
        montoTotalDesdePorcentaje=Math.round(montoTotalDesdePorcentaje); 
        $(this).parent().parent().children('.presupuestoOP').html('$'+montoTotalDesdePorcentaje);
    });
    
    //cambiando alto del iframe
    parent.$('#iframeModal').height($('html').height());
        validarPresupuesto();
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
    <div class="errorSummary" style='display:none;'><p>Por favor corrija los siguientes errores de ingreso:</p>
        <ul>
            <li>La distribución del presupuesto debe ser igual a 100%.</li>
        </ul>
    </div>
    <br/>
    <div class="fieldset2 grid-view"> 
        <div class="legend">Presupuesto operativo del centro de costo.</div>
        <table class="items">
            <thead>
              <tr><th width="30">N°</th><th width="55">Vínculo</th><th>Item Presupuestario</th><th width="150">Monto</th></tr>
            </thead>
            <tbody>
                <?php 
              $arrayItemesPresupuestarios = CHtml::listData(ItemesPresupuestarios::model()->findAll(array('condition'=>'t.estado=1 AND t.tipo_item_id=2')), 'id', 'nombre');
              
              $productosItemes=ProductosItemes::model()->findAll(array('condition'=>'centro_costo_id='.$model->id.' AND planificacion_id='.Yii::app()->session['idPlanificaciones']));
              $arraySelectedItemes=array();
              foreach($productosItemes as $value){
                  $arraySelectedItemes[$value->item_presupuestario_id]=$value->item_presupuestario_id;
              }
              //$arraySelectedItemes=CHtml::listData($model->itemesPresupuestarioses,'id','id');
              $x=0;   
              if($model->id){
                 $arrayItemesActividades = CHtml::listData(ProductosItemes::model()->findAll(array('condition'=>'pp.id="'.Yii::app()->session['idPeriodo'].'" AND t.centro_costo_id='.$model->id,'join'=>'inner join planificaciones pl on t.planificacion_id=pl.id inner join periodos_procesos pp on pl.periodo_proceso_id=pp.id')), 'item_presupuestario_id', 'monto'); 
              }           
              foreach($arrayItemesPresupuestarios as $k=>$v):
                  $parOImpar=$x%2?"even":"odd";
                  echo "<tr class=".$parOImpar.">";
                  echo "<td>".($x+1)."</td>";                  
                  if (array_key_exists($k, $arraySelectedItemes)) {
                     echo "<td align='center'><input class='desabilitarInputText' type=\"checkbox\" name=\"Productos[".$k."][itemesPresupuestarioses]\" checked=\"checked\" value=\"".$k."\" id=\"Productos_itemesPresupuestarioses_".$x."\"></td>";     
                  }else{
                      echo "<td align='center'><input class='desabilitarInputText' type=\"checkbox\" name=\"Productos[".$k."][itemesPresupuestarioses]\" value=\"".$k."\" id=\"Productos_itemesPresupuestarioses_".$x."\"></td>";
                  }
                  
                  echo "<td><label for=\"Productos_itemesPresupuestarioses_".$x."\">".$v."</label></td>";
                  if(isset($arrayItemesActividades[$k])){
                      echo "<td align='center'><input class='inputMontos' id='Productos_productosItemes_".$k."' name=\"Productos[".$k."][productosItemes]\" value='".$arrayItemesActividades[$k]."'></td>"; 
                  }else{
                      echo "<td align='center'><input class='inputMontos' disabled='disabled' id='Productos_productosItemes_".$k."' name=\"Productos[".$k."][productosItemes]\" value=''></td>"; 
                  }                    
                  echo "</tr>";
                    $x++; 
              endforeach;
              ?> 
              
              <tr><th style="text-align: right;" colspan="4">Total: $<span id="totalOP">0</span></th></tr>
        </tbody>
            </table>
             
        </div>      
        
        <div class="fieldset2 grid-view"> 
            <div class="legend">Distribución de presupuesto operativo por producto estratégico.</div>            
            <div id='errorDistribucion' style='display:none;' class="errorMessage">La suma de las distribuciones a nivel porcentual debe ser igual a 100%</div>
            <input type='hidden' name="centroCosto" value="<?php echo $model->id;?>"/>
            <?php 
                /*$Criteria = new CDbCriteria();
                $Criteria->condition = 't.estado=1 AND pe.estado=1 AND sp.estado=1 AND sp.centro_costo_id='.$model->id;
                $Criteria->select = array('t.nombre','pes.nombre as pesNombre', 'pes.id','pecc.porcentaje as porcentaje');
                $Criteria->join = 'join productos_especificos pe on t.producto_especifico_id=pe.id join subproductos sp on pe.subproducto_id=sp.id join productos_estrategicos pes on sp.producto_estrategico_id=pes.id left join producto_estrategico_centro_costo pecc on pecc.producto_estrategico_id=pe.id and sp.centro_costo_id=pecc.centro_costo_id';
                $sqlIndicadores=Indicadores::model()->findAll(array('select'=>array('t.nombre','pes.nombre as pesNombre', 'pes.id','pecc.porcentaje as porcentaje'),'condition'=>'t.estado=1 AND pe.estado=1 AND sp.estado=1 AND sp.centro_costo_id='.$model->id,'join'=>'join productos_especificos pe on t.producto_especifico_id=pe.id join subproductos sp on pe.subproducto_id=sp.id join productos_estrategicos pes on sp.producto_estrategico_id=pes.id left join producto_estrategico_centro_costo pecc on pecc.producto_estrategico_id=pe.id and sp.centro_costo_id=pecc.centro_costo_id'));
                 * 
                 */
                 
                 
                 $sqlIndicadores=Yii::app()->db->createCommand('
                        Select t.nombre,pes.nombre as pesNombre,pes.id,pecc.porcentaje as porcentaje 
                        FROM indicadores t 
                        LEFT JOIN lineas_accion la on t.id=la.id_indicador  AND la.estado=1
                        LEFT join productos_especificos pe on t.producto_especifico_id=pe.id AND pe.estado=1
                        LEFT join subproductos sp on pe.subproducto_id=sp.id AND sp.estado=1
                        LEFT join productos_estrategicos pes on sp.producto_estrategico_id=pes.id or la.producto_estrategico_id=pes.id AND pes.estado=1
                        LEFT join producto_estrategico_centro_costo pecc on pecc.producto_estrategico_id=pes.id and (sp.centro_costo_id=pecc.centro_costo_id OR la.centro_costo_id=pecc.centro_costo_id) 
                        INNER JOIN objetivos_productos op ON pes.id = op.producto_estrategico_id
                        INNER JOIN objetivos_estrategicos oe ON op.objetivo_estrategico_id = oe.id
                        INNER JOIN desafios_objetivos do2 ON  oe.id = do2.objetivo_estrategico_id
                        INNER JOIN desafios_estrategicos de ON do2.desafio_estrategico_id = de.id
                        INNER JOIN planificaciones pl ON de.planificacion_id = pl.id 
                        INNER JOIN periodos_procesos pp ON pl.periodo_proceso_id = pp.id
                        WHERE t.estado=1 AND (sp.centro_costo_id='.$model->id.' or la.centro_costo_id='.$model->id.') AND pp.id = '.Yii::app()->session['idPeriodo'].'
                        group by t.nombre,pes.nombre,pes.id,pecc.porcentaje
                        ')->queryAll();      
                $arrayIndicadores= array();
               
                foreach($sqlIndicadores as $v):
                    $arrayIndicadores[$v['id']]['indicadores'][]=$v['nombre'];
                    $arrayIndicadores[$v['id']]['productoEstrategico']=$v['pesNombre'];
                    $arrayIndicadores[$v['id']]['porcentaje']=$v['porcentaje'];
                endforeach;
               
            ?>
            <table class="items">
            <thead>
              <tr><th width="300">Indicador</th><th width="300">Producto Estratégico</th><th width="100">% Distribución presupuesto OP</th><th>Presupuesto Distribuido</th></tr>
            </thead>
                <tbody>
                    <?php
                    foreach($arrayIndicadores as $k=>$v):                        
                        echo "<tr>";
                            echo "<td><ul>";
                                foreach($v['indicadores'] as $key=>$value): echo "<li>".$value."</li>"; endforeach;
                            echo"</ul></td>";
                            echo "<td>".$v['productoEstrategico']."</td>";
                            echo "<td><input  class='inputPorcentaje' type='text' name='DistribucionPresupuesto[$k][porcentaje]' value='".$v['porcentaje']."' maxlength='3' style='width: 40px;'/>%</td>";
                            echo "<td class='presupuestoOP'></td>";
                        echo "</tr>";
                    endforeach;
                    if(empty($arrayIndicadores)){
                        echo '<tr><td colspan="4"><span class="empty">No se encontraron resultados.</span></td></tr>';
                    }
                    ?>
                </tbody>            
            </table>
        </div>
    
<div class="row buttons">        
        <input type="button" value="Guardar" name="yt0" onclick="validarPresupuesto('true');">       
</div> 
    
    <?php
    $this->endWidget();
    ?>
</div>
