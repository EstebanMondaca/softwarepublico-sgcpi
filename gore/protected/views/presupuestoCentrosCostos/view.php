<?php 
Yii::app()->clientScript->registerScript('habilitar', "
    
        var montoTotal=0;
        $('.inputMontos:not(:disabled)').each(function(){
              if (/^([0-9])*$/.test($(this).val()) && $(this).val()!=''){
                  montoTotal+=parseInt($(this).val());
              }
        });            
        $('#totalOP').html(montoTotal);

    //cambiando alto del iframe
    parent.$('#iframeModal').height($('html').height());

");

?>
<div class="form">
        <h3>Centro de costo</h3>
        <br/>
    <div class="fieldset2 grid-view"> 
        <div class="legend">Presupuesto operativo del centro de costo.</div>
        <?php
        $total=0;
            if(!$model->productosItemes){
                echo '<span class="empty">No se encontraron resultados.</span>';
            }else{ 
                echo "<ul>";   
                foreach($model->productosItemes as $items){
                    echo "<li>".$items->itemPresupuestario.": ".$items->monto."</li>";
                    $total+=$items->monto;
                }
                echo "</ul>";    
                echo "<h4><strong>TOTAL: $".$total."</strong></h4>";    
            }    
        ?>
    </div>
    <div class="fieldset2 grid-view"> 
        <div class="legend">Distribución de presupuesto operativo por producto estratégico.</div> 
        <?php 
                $sqlIndicadores=Yii::app()->db->createCommand('
                        Select t.nombre,pes.nombre as pesNombre,pes.id,pecc.porcentaje as porcentaje 
                        FROM indicadores t 
                        join productos_especificos pe on t.producto_especifico_id=pe.id 
                        join subproductos sp on pe.subproducto_id=sp.id 
                        join productos_estrategicos pes on sp.producto_estrategico_id=pes.id 
                        left join producto_estrategico_centro_costo pecc on pecc.producto_estrategico_id=pes.id and sp.centro_costo_id=pecc.centro_costo_id 
                        INNER JOIN objetivos_productos op ON pes.id = op.producto_estrategico_id
                        INNER JOIN objetivos_estrategicos oe ON op.objetivo_estrategico_id = oe.id
                        INNER JOIN desafios_objetivos do2 ON  oe.id = do2.objetivo_estrategico_id
                        INNER JOIN desafios_estrategicos de ON do2.desafio_estrategico_id = de.id
                        INNER JOIN planificaciones pl ON de.planificacion_id = pl.id 
                        INNER JOIN periodos_procesos pp ON pl.periodo_proceso_id = pp.id
                        WHERE t.estado=1 AND pe.estado=1 AND sp.estado=1 AND sp.centro_costo_id='.$model->id.' AND pp.id = '.Yii::app()->session['idPeriodo'].'
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
                            if($v['porcentaje']!=null)
                                echo "<td>".$v['porcentaje']."%</td>";
                            else 
                                echo "<td>0%</td>";
                            $montoOP=$total*$v['porcentaje']/100;
                            echo "<td class='presupuestoOP'>$".round($montoOP)."</td>";
                        echo "</tr>";
                    endforeach;
                    if(empty($arrayIndicadores)){
                        echo '<tr><td colspan="4"><span class="empty">No se encontraron resultados.</span></td></tr>';
                    }
                    
                    ?>
                </tbody>            
            </table>
    </div>   
</div>