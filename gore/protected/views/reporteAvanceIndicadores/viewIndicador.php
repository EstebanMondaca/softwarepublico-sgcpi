<div class="form">
<?php
$periodo_ani_seleccionado= Yii::app()->session['idPeriodoSelecionado'];

$fecha=getdate(); 
$anio_sistema=$fecha["year"];
$mes_sistema=$fecha["mon"]; 


Yii::app()->getClientScript()->registerCoreScript( 'jquery.ui' );
Yii::app()->clientScript->registerCssFile(
Yii::app()->clientScript->getCoreScriptUrl().'/jui/css/base/jquery-ui.css');
Yii::app()->clientScript->registerScript('init', "
    	
    	
    	$('.creandoBarras').each(//crea las barras de tabla actividades
    	function(){  
   	
    		var valoresCadena=$(this).html();
    		var valoresArray=valoresCadena.split('-');
    		var valIndicador = valoresArray[0];
    		var esperadoX = valoresArray[1];
    		var idAleatoria=Math.round(Math.random()*1000);
    		var charAleatorio = Math.random().toString(36).substring(7);
    		var idBarra = idAleatoria+charAleatorio;
	    	var selector = '#' + idBarra + ' > div';
	    	
    		if(esperadoX!='S.I.'&&valIndicador!='S.I.'){//si vienen datos para realizar el calculo
    		
    			$(this).html('<div class=\"grafico_indicador\"><div class=\"porcentaje_indicador\" style=\"left: 63px;\">'+valIndicador+'%</div><div id=\"'+idBarra+'\" class=\"progressbar\"></div></div>');
	    		$(this).children('.grafico_indicador').children('.progressbar').progressbar({value:parseInt(valIndicador)});
    			
	    		var e = parseFloat(esperadoX);
    			var p = parseFloat(10);
    			var p2 = parseFloat(100);
    			var total = (e*p)/p2;

    			if(parseFloat(valIndicador)>=e){//si el avance actual es mayor o igual al avance esperado
    				
    				$(selector).css({ 'background':'#009e0f'});
    			
    			}else{
    				if(parseFloat(valIndicador)<e&&parseFloat(valIndicador)+total>=e){//si el avance actual es menor que el esperado en un rango del 10 %
    					
    					$(selector).css({ 'background': '#ffff00' });
    				
    				}else{//sino es rojo
    					
    					$(selector).css({ 'background': '#cc0000' });
    				}
    			}
    		}else{//si no vienen datos para realizar el calculo
    		
    			$(this).html('<div class=\"grafico_indicador\"><div class=\"porcentaje_indicador\" style=\"left: 63px;\">'+valIndicador+'</div><div id=\"'+idBarra+'\" class=\"progressbar\"></div></div>');
	    		$(this).children('.grafico_indicador').children('.progressbar').progressbar({value:parseInt(valIndicador)});
    		}
 
  			$(this).css({ 'height': '25px' });
  			$(this).css({ 'width': '150px' });
  				
    
    	});
    	
    $('.graficoProgressbar2').each(
    	function(){   

    		var value = $(this).attr('valIndicador');
    		var meta = $(this).attr('meta');
    		var asc =  $(this).attr('asc');
    		
    		if(meta != 'S.I.' && value != 'S.I.'){
    		
    		$(this).progressbar({value:parseFloat($(this).attr('valIndicador'))});
    		
    		var selector = '#' + this.id + ' > div';
    		if(this.id != 'esperado'){
    		  var valIndicador = parseFloat($(this).attr('valIndicador'));
    		   
    		  var v = parseFloat(valIndicador);//valor
		      var m = parseFloat(meta);//meta
		      var x = (m*10)/100;//el 10 % de la meta
		      var total = v+x;// es la suma del valor con el 10 % calculado
    		   
		        if(parseInt(asc) == 1){//es ascendente
		        		
		    			if (parseFloat(valIndicador) >= parseFloat(meta)){//si es igual o mayor que meta esperada es verde
				            	$(selector).css({ 'background':'#009e0f'});
				        } 
				        else{
				        	
				        	if(parseFloat(valIndicador)<parseFloat(meta)&&total >=parseFloat(meta)){// si no es mas baja que un 10% debe ser amarillo
				       
				        		$(selector).css({ 'background': '#ffff00' });
				        	
				        	
				        	}
				        	else{//sino rojo
				        		
				        			$(selector).css({ 'background': '#cc0000' });
				        		
				        	
				        	}
				        }
		    		}
		    		else{// es descendente
						
		    			if (parseFloat(valIndicador) <= parseFloat(meta)){// si es menor o igual a la meta esperada es verde
				            
		    			
		    					$(selector).css({ 'background': '#009e0f' });
		    				
				   
				        } 
				        else{
				        
				        	if(parseFloat(valIndicador)>parseFloat(meta)&&total <= parseFloat(meta)){// es amarillo si es mayor en mas de un 10% que la meta esperada
				        	
				        		$(selector).css({ 'background': '#ffff00' });
				        	
				        	}
				        	else{// en el resto de los caso es rojo
				        	
				        		$(selector).css({ 'background': '#cc0000' });
				        		
				        	}
				        }
		    		
		    		}//fin else
		    		}
		     
  				
    		}else{
    		
    			$(this).progressbar({value:parseInt(0)});
    		}
    			$(this).css({ 'height': '25px' });
  				$(this).css({ 'width': '350px' });
  			
  			
  				
    
    	});        
        
");

$this->breadcrumbs = array(

Yii::t('ui','Panel General de Avance')=>array('/panelAvances'),
Yii::t('ui','Indicadores')=>array('/panelAvances/admin'),
Yii::t('app', 'Indicador'),
);


$nombreIndicador = $arr[0]['nom_indicador'];

	$nombreProductoEstrategico =$arr[0]['p_estra_nom'];

	$nombreSubproducto=$arr[0]['subp_nombre'];

	$nombreProductoEspecifico=$arr[0]['pro_especifico_nom'];


?>


<h3>INDICADOR: <?php echo $nombreIndicador;?></h3>
<table class="tablaRegistroAvance">
  <tr>
    <th>Producto Estratégico:&nbsp;&nbsp;</th>
    <th><?php echo $nombreProductoEstrategico;?></th>
  </tr>
  <tr>
    <td>Subproducto:&nbsp;&nbsp;</td>
    <td><?php echo $nombreSubproducto;?></td>
  </tr>
    <tr>
    <td>Producto Específico:&nbsp;&nbsp;</td>
    <td><?php echo $nombreProductoEspecifico?></td>
  </tr>
   </tr>
    <tr>
    <td>Comportamiento:&nbsp;&nbsp;</td>
    <td><?php echo $arr[0]['ascendente1']?></td>
  </tr>

</table>

<div class="actividadesContenedor">
<h2>Estado de Avance Indicador</h2>
S.I.: Sin Información.
<table>
<tr>
<td><div class="lab">Avance Real:</div></td>
<td>	    
<div class="grafico_indicador">
<div class="porcentaje_indicador"><?php 

if($arr[0]['value'] != 'S.I.'){
	
	echo $arr[0]['value'].'%';

}
else{
	echo $arr[0]['value'];
}
?></div>
<div id="avance" meta="<?php echo $arr[0]['esperado']; ?>" asc="<?php echo $arr[0]['ascendente']; ?>" class="graficoProgressbar2" valIndicador="<?php echo $arr[0]['value'].'%'; ?>"></div>
</div></td>
</tr>
<tr>
<td><div class="lab">Avance Esperado:</div></td>
<td><div class="grafico_indicador">
<div class="porcentaje_indicador"><?php 

	if($arr[0]['esperado'] != 'S.I.'){
	
	echo $arr[0]['esperado'].'%';

}
else{
	echo $arr[0]['esperado'];
}

?></div>
<div id="esperado"  class="graficoProgressbar2" valIndicador="<?php echo $arr[0]['esperado'] ?>"></div></div></td>
</tr>
</table>

<?php 

$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvider,
	'afterAjaxUpdate'=>'function(id, data){afterAjaxUpdateSuccess();}',
	'columns'=>array(


		array('header'=>'N°',
            'htmlOptions'=>array('width'=>'30'),
            'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
        ),
			
		array(
			'name'=>'nombre',
			'header'=>'Actividades Asociadas',
			
		
		),
		
		array(
			'name'=>'fecha_inicio',
			'header'=>'Inicio',
			
		
		),
		array(
			'name'=>'fecha_termino',
			'header'=>'Termino',
			
		
		),
		array(
			'name'=>'esperadoX',
			'header'=>'Avance Esperado',
			
		
		),
		array(
			'name'=>'avance_actual',
			'header'=>'Avance a la Fecha',
			'htmlOptions'=>array('class'=>'creandoBarras'),
            'type'=>'html',
		
		),
	




	),

));
/*
$model2 = HitosIndicadores::model();
$dataProviderH=$model2->hitosIndicador($id);
*/
?>
<table class="tablaEstadoActividadesRegistroAvance">
	<tr>
		<td><div class="lab2">Estado de Actividades</div></td>
		<td><div class="iconoVerdeA"></div> En tiempo</td>
		<td><div class="iconoRojoA"></div>Atrasado</td>
		<td><div class="iconoAmarilloA"></div>Levemente atrasado</td>
	</tr>
</table>
</div>
<div class="actividadesContenedor">

<h2>Control de Avance</h2>
<div style="float:left">
	<div><br><br>&nbsp;Meta Parcial&nbsp;&nbsp;</div>
	<div>Avance Real&nbsp;&nbsp;</div>
</div>
<div style="float:rigth"> 
<table class="grid-viewIndicadoresInstrumentos" id="resumen">
	<thead>
		<tr>
			<th> Enero</th>
			<th>Febrero</th>
			<th>Marzo</th>
			<th>Abril</th>
			<th>Mayo</th>
			<th>Junio</th>
			<th>Julio</th>
			<th>Agosto</th>
			<th>Septiembre</th>
			<th>Octubre</th>
			<th>Noviembre</th>
			<th>Diciembre</th>
		</tr>
	</thead>
		<tbody>



			


<?php

//recorremos los meses del año Pra obtener la meta parcial
		echo "<tr class='odd'>";
		foreach($meses as $m)
		{
			$parcial=null;

			
			//recorremos los hitos que contiene el indicador preguntando si hay un dato para el mes $m
			foreach($hitos as $t)
			{
				if (strtolower ($m)==strtolower ($t->mes)){
			    	$parcial= $t->meta_parcial;
				}
				//echo $t->mes;
			}
			
			if (isset($parcial)){
			//if($parcial){	
				echo '<td class="centrarTexto">'.$parcial.'%</td>';
			}else{
				echo '<td class="centrarTexto">-</td>';
			}
			
		}
		echo "</tr>";
		//recorremos los meses del año Para obtener avance real		
		echo "<tr class='odd'>";
		//print_r($meses);
		foreach($meses as $key => $m)
		{
			$real=null;$parcial=null;$idHito=null;$permiteIngresarAvance=true;
			//recorremos los hitos que contiene el indicador preguntando si hay un dato para el mes $m
			foreach($hitos as $t2)
			{
				if (strtolower ($m)==strtolower ($t2->mes)){
			   // echo $t->mes;
				   	$idHito= $t2->id;
					$parcial= $t2->meta_parcial;
					$real= $t2->meta_reportada;
					
					
					//echo $periodo_ani_seleccionado;
					//echo $anio_sistema;
					//if(2012 == 2012){
					if($periodo_ani_seleccionado == $anio_sistema){
						
						//$mes_calculo = $mes_sistema ;
						//$mes_sistema_actual = $meses[$mes_calculo];//Obtiene el nombre del mes
						//$mes_sistema_actual = $mes_sistema;//Obtiene el numero del mes
						
							//echo strtoupper($t2->mes);
							//echo $mes_sistema_actual;
							 $mesNum= $key+1;
													
						//Compara el mes del sistema actual con el mes del arreglo
						if($mes_sistema >= $mesNum){

							$permiteIngresarAvance=true;
						}else{
							$permiteIngresarAvance=false;
						}
					}else{						
							$permiteIngresarAvance=false;					
					}
					
				}
				
			}
			
			if($periodo_ani_seleccionado == $anio_sistema){
			if (isset($real)){
				$cero = substr($real , -2, 2); // extrae 0	
							
				if ($cero<1){
					$real = substr($real , 0, -3);//extraemos desde el punto mas los dos decimales
				}
				if ($permiteIngresarAvance){
					echo '<td class="centrarTexto"><a href="#" onclick="mostrarRegistroAvance(\''.$idHito.'\');return false;">'.$real.'%</a></td>';	
				}else{
					echo '<td class="centrarTexto"><a href="#" onclick="mostrarRegistroAvance(\''.$idHito.'\');return false;">'.$real.'%</a></td>';	
				}
			}else{
				if (isset($parcial)){
					if ($permiteIngresarAvance){
						echo '<td class="centrarTexto">-</td>';	
					}else{
						echo '<td class="centrarTexto">-</td>';	
					}
				}else {
					echo '<td class="centrarTexto">-</td>';
				}
			}
			}//fin if
			else{
				if (isset($real)){
				$cero = substr($real , -2, 2); // extrae 0	
							
				if ($cero<1){
					$real = substr($real , 0, -3);//extraemos desde el punto mas los dos decimales
				}
				if ($permiteIngresarAvance){
					echo '<td class="centrarTexto"><a href="#" onclick="mostrarRegistroAvance(\''.$idHito.'\');return false;">'.$real.'%</a></td>';	
				}else{
				    echo '<td class="centrarTexto"><a href="#" onclick="mostrarRegistroAvance(\''.$idHito.'\');return false;">'.$real.'%</a></td>';
				}
			}else{
				if (isset($parcial)){
					if ($permiteIngresarAvance){
						echo '<td class="centrarTexto">Reg</td>';	
					}else{
						echo '<td class="centrarTexto">Reg</td>';	
					}
				}else {
					echo '<td class="centrarTexto">-</td>';
				}
			}
				
			}
		}//End-foreach
		echo "</tr>";
									
?>
												
			
		</tbody>
</table>
</div>
<div class="limpia"></div>
<div id="avanceMensual" style="display:none;">
    <div id="loadingAvance" style="margin:50px auto auto;width: 250px;display:none;"> <img src="<?php echo Yii::app()->request->baseUrl;?>/images/loadingEsperar.gif"/> </div>
    <div id="iframeModal"></div>
</div>
</div>
</div>
