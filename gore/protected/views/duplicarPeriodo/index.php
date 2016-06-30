<?php

$this->breadcrumbs = array(
     'Periodos'
);
?>

<div class="form" style="position:relative;">
        <h2>DUPLICAR PLANIFICACIÓN SEGÚN UN PERIODO</h2>
        <h3 style='display:none'>Duplicar Periodo</h3>
        <label>Para poder duplicar la información asociada a un periodo, es necesario completar todos los campos que a continuación se presentan: </label>
        <table width="100%" border="0" cellspacing="5" cellpadding="5">            
            <tbody>
                <tr>
                    <th width='190' style='text-align: right;'>Periodo a duplicar:</th>
                    <td>
                        <?php 
                            echo CHtml::dropDownList('PeriodosProcesos', '', GxHtml::listDataEx(PeriodosProcesos::model()->findAllAttributes(null, true)), array('empty' => 'Seleccione un periodo'));                             
                        ?>
                    </td>
               </tr>
               <tr>
                    <th style='text-align: right;'>Año del nuevo periodo:</th>
                    <td>
                        <input type="text" name="nombrePeriodo" id="nombrePeriodo" maxlength="4"/>
                    </td>
               </tr>
               <tr>
                    <th style='text-align: right;'>Nombre de la Planificación:</th>
                    <td>
                        <input type="text" name="nombrePlanificacion" id="nombrePlanificacion" style='width: 400px;' maxlength="250" />
                    </td>
               </tr>
               <tr>
                    <th></th>
                    <td><input type="button" value="Duplicar" onclick="duplicarPeriodo()"/></td>
                </tr>
            </tbody>
        </table>  
        <div class='fondoForm'>
            <div style="margin: 50px auto auto;width: 250px;">
                <img src="<?php echo Yii::app()->request->baseUrl;?>/images/loadingEsperar.gif"/>
            </div>
        </div>      
</div>
