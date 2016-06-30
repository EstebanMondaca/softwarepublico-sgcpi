<?php 
require_once 'ConsultasView.php';
Yii::app()->clientScript->registerScript('init', "
    	
		tabsPanelAvance();
	
    	$('.graficoProgressbar').each(
    	function(){   

    		var value = $(this).attr('valIndicador');
    		var meta = $(this).attr('meta');
    		var asc =  $(this).attr('asc');
    		
    		if(meta != '-' && value != '-'){
    		
    		
    		$(this).progressbar({value:parseFloat($(this).attr('valIndicador'))});
    		
    		var selector = '#' + this.id + ' > div';
    		
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
				     
				        	if(parseFloat(valIndicador)<parseFloat(meta)&&total >= parseFloat(meta)){// si no es mas baja que un 10% debe ser amarillo
				        	
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
				        	
				        	if(parseFloat(valIndicador)>parseFloat(meta)&&total2 <= parseFloat(meta)){// es amarillo si es mayor en mas de un 10% que la meta esperada
				        	
				        		$(selector).css({ 'background': '#ffff00' });
				        	
				        	}
				        	else{// en el resto de los caso es rojo
				        	
				        		$(selector).css({ 'background': '#cc0000' });
				        		
				        	}
				        }
		    		
		    		}//fin else
		    		
		     
  				
    		}else{
    		
    			$(this).progressbar({value:parseInt(0)});
    		}
    		$(this).css({ 'height': '25px' });
  			$(this).css({ 'width': '145px' });
  			
  				
    
    	});
");



//Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/gore.js');


$this->breadcrumbs = array(
    'Panel General de Avance',
);


$c=new ConsultasView();
?>
<h1>Panel General de Avance</h1>

<div id="contenedorTab" class="contenedorTab">
<div id="tabs">
    <ul>
        <li><a href="#tabs-1"><cbT>P. Estratégicos (Negocio)</cbT></a></li>
        <li><a href="<?php echo Yii::app()->request->baseUrl.'/panelAvances/productosEstrategicosApoyo'?>"><cbT>P. Estratégicos (Apoyo)</cbT></a></li>
        <li><a href="<?php echo Yii::app()->request->baseUrl.'/panelAvances/indicadoresInstrumentos'?>"><cbT>Por Instrumento</cbT></a></li>
        <li><a href="<?php echo Yii::app()->request->baseUrl.'/panelAvances/indicadoresCentroResponsabilidad'?>"><cbT>Por C. de Responsabilidad</cbT></a></li>

       
    </ul>
  
		    <div id="tabs-1">
		        
		       
		        <div id="contenedorControl1" class="contenedorControl">
		        
		        	
			        <p><h2>Estado General de Avances:</h2></p>
			        <letraSubTitulos>Productos Estratégicos del Negocio</letraSubTitulos></p>
						<?php 
							
							$productoEstrategicoN=Indicadores::model()->buscarProductoEstrategicoIndicadores(1, 0);
						
							if(empty($productoEstrategicoN)){
								echo ' No se encontraron registros';
								
							}else{
							
								$arreglo = array();
								
								$ins2= new ConsultasView;
								
								$arreglo=$c->recorreResultado($productoEstrategicoN, 'id_pro_estrategico', 'producto_estrategico_n', 'P');
								
								//print_r($arreglo);
								if(empty($arreglo)){
									
									
								}else{
									
									for($i=0; $i<count($arreglo);$i++){
											if(isset($arreglo[$i]['id'])){
												$idp=$arreglo[$i]['id'];
											}
											if(isset($arreglo[$i]['c'])){
											$content=$arreglo[$i]['c'];
											}
											if(isset($arreglo[$i]['nom'])){
											$nom= $arreglo[$i]['nom'];
											}
										
										if(empty($idp)||empty($content)||empty($nom)){
											
										}else{
										
											echo '<a class="update"  href="'.Yii::app()->request->baseUrl.'/panelAvances/view?id='.$idp.'&nombreP='.$nom.'&b=1&title=Avance Producto Estratégico">'.$content.'</a>';
										}
									}//fin for
							
								}
								
							}	
							
						?>
		        <br>
		        </div>
		    </div><!-- fin tab 1 -->
		    </div>
		    

		</div><!-- fin tab -->
		
</div>
<!-- fin contendor tab -->


                  

<div class="contenedorIndicaciones">	
				<p><h2><a href="<?php echo Yii::app()->request->baseUrl.'/panelAvances/admin'; ?>">Mis Indicadores</a></h2></p>
				<div class="contenedorProgresBar">
				
				<?php 
				
				$usuariosIndicador = Indicadores::model()->indicadorUnUsuario(0);
		
				if(empty($usuariosIndicador)){
					echo 'No se han econtrado registros';
			
				}else{
					
					
						
				 $x=0;
					$ins2= new ConsultasView;

		              foreach($usuariosIndicador as $v):
		              			$nombre = "grafico_".$x;
								$nombreLargo=$v['nombre'];
								$nombre_indicador = substr($nombreLargo,0,7);
								$value=0;
								$meta = 0;
								
				
		              if(!empty($v['id'])&&!empty($v['plazo_maximo'])){
				              	
								$auxiliar = $ins2->construyendoBarras($v['id'], $v['plazo_maximo']);
		              
								  if($auxiliar['value'] != -1 && $auxiliar['value']>=0){
								 	$value = $auxiliar['value'];
								 	$meta = $auxiliar['meta'];
									 /*  if($v['tipoFormula']['tipo_resultado']==0){
			              					
									   		if(!empty($v['meta_anual'])&&$v['meta_anual'] != 0){
									   			$meta = ($meta*100)/$v['meta_anual'];
									   		}else{
									   			$meta = '-';
									   		}
			              				}*/
								 }else{
								 	$value = '-';
								 	$meta = '-';
								 }
								
		              
		              }else{
		              	
		              	$value = '-';
		              	$meta = '-';
		              }
		         
		         		$asc = $v['ascendente'];     
		              
						?>
		              	      <!-- genera la progressbar para cada indicador -->
						    <p>
							    <div class="grafico_indicador">
								    <div class='nomIndicador' style='height: 10px;'  title="<?php echo $nombreLargo; ?>"><?php echo $nombre_indicador ?>&nbsp;</div>
								    <?php 
								    if($value != '-'){
								    ?>
								    <div class="porcentaje_indicador"><?php echo $value;?>%</div>
								    <?php } else{
								    ?>
								    <div class="porcentaje_indicador">S.I.</div>
								    <?php }?>
								    <div id="<?php echo $nombre; ?>"  class="graficoProgressbar" valIndicador="<?php echo $value;?>" meta="<?php echo $meta;?>" asc="<?php echo $asc;?>"></div>
								</div>
						     </p>
		              	 <?php 
		            
		              	$x++;
		              	
		             endforeach;
				}
		        ?>	
					
			</div>

</div>
