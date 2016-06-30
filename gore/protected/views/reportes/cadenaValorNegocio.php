<?php
$this->breadcrumbs = array(
    Yii::t('ui','Reportes')=>array('/reportes'),
    'Procesos del Negocio',
);
//si necesitamos ampliar el ancho de la primera columna debemos modificar el 90 de $porcentajeWidth
$cantidadDeColumnas=count($model);
$cantidadDeColumnas=($cantidadDeColumnas!=0 && $cantidadDeColumnas!='')?$cantidadDeColumnas:1;
$porcentajeWidth=floor(90/$cantidadDeColumnas);


?>
<h3>Procesos del Negocio</h3>
<table class="cadenaValor" width="100%" border="0" cellspacing="5" cellpadding="5">
  <tr>
      <td width="10%"></td>
      <td valign="top" colspan="<?php echo $cantidadDeColumnas;?>">
          <?php
            $divisionesArray=array();
            $colorFondoArray=array('F5FCED','da9b58','F8DA4E','F7F3DE','FFFFFF','994D53','FEE4BD','990033','FF3333','000099');
            $colorLetraArray=array('333333','FFFFFF','915608','3A3427','333333','FFFFFF','592003','FFFFFF','FFFFFF','FFFFFF');
            $colorBordeArray=array('8CCE3B','FED22F','FCD113','B2A266','AAAAAA','F8893F','74736D','FFFFFF','FFFFFF','FFFFFF');
            $x=0;
            
            foreach($model as $value){
                if(isset($value->division)){
                    if((isset($value->division->nombre)) && (isset($value->division->id))){
                        if (!array_key_exists($value->division->id, $divisionesArray)) {
                            $divisionesArray[$value->division->id]['nombre']=$value->division->nombre;
                            $divisionesArray[$value->division->id]['posColor']=$x;    
                            $x++;                
                            if(!isset($colorFondoArray[$x])){
                                $x=0;
                            }
                        }
                    }
                }
            }    
                
            
            foreach($divisionesArray as $k=>$v){
                echo '<div style="float:left;margin-right: 10px; padding: 5px 20px; background-color:#'.$colorFondoArray[$v['posColor']].';color:#'.$colorLetraArray[$v['posColor']].';" class="borde">'.$v['nombre'].'</div>';
            }
            
        ?>
      </td>
  </tr>
  <tr>
    <th style="vertical-align: middle;background-color: #F4F4F4;" class="borde">CLIENTES</th>
    <td style="background-color: #F4F4F4;" valign="top" class="borde" colspan="<?php echo $cantidadDeColumnas;?>">
        <ul>
        <?php
        $clientesArray=array();
        foreach($model as $key=>$value){
            foreach($value->clientes as $k=>$v){
                $clientesArray[$v->id]=$v;
            }
        }
        
        foreach($clientesArray as $v){
            echo '<li>'.$v.'</li>';
        }
        
        ?>
        </ul>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <?php
        foreach($model as $value){
            echo '<td style="text-align:center;" width="'.$porcentajeWidth.'%"><img src="'.Yii::app()->request->baseUrl.'/images/arrow_large_up.png"/></td>';
        }
    ?>
  </tr>
  <tr>
    <th style="vertical-align: middle; background-color: #F4F4F4;" class="borde">PROCESOS Y PRODUCTOS</th>
    <?php
        foreach($model as $key=>$value){
            $colorFondo='#FFF';
            $colorLetra='#000';
            if(isset($value->division->id)){
                $colorFondo='#'.$colorFondoArray[$divisionesArray[$value->division->id]['posColor']];
                $colorLetra='#'.$colorLetraArray[$divisionesArray[$value->division->id]['posColor']];
            }
            
            echo '<td valign="top" class="borde" style="color:'.$colorLetra.';background-color:'.$colorFondo.'">';
                echo '<ul>';
                foreach($value->subproductoses as $ke=>$va){
                    echo '<li>'.$va;
                        echo '<ul>';
                        foreach($va->productosEspecificoses as $k=>$v){
                            echo '<li>'.$v.'</li>';    
                        }               
                        echo '</ul>';         
                    echo '</li>';
                }
                echo '</ul>';
            echo'</td>';
        }
    ?>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <?php
        foreach($model as $value){
            echo '<td style="text-align:center;"><img src="'.Yii::app()->request->baseUrl.'/images/arrow_large_up.png"/></td>';
        }
    ?>
  </tr>
  <tr>
    <th style="vertical-align: middle;background-color: #F4F4F4;" class="borde">MACRO PROCESOS</th>
    <?php
        foreach($model as $value){
            echo '<td style="text-align:center;background-color: #F4F4F4;"  class="borde">'.$value->nombre_corto.'</td>';
        }
    ?>
  </tr>
  <!--<tr>
    <td>&nbsp;</td>
    <?php
        foreach($model as $value){
            echo '<td style="text-align:center;"><img src="'.Yii::app()->request->baseUrl.'/images/arrow_large_up.png"/></td>';
        }
    ?>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td style="text-align: center;" class="borde" colspan="<?php echo $cantidadDeColumnas;?>">PROCESOS DE APOYO</td>
  </tr>-->
</table>