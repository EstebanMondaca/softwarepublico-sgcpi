<?php 
Yii::app()->clientScript->registerScript('init', "

		$('#tabs').tabs();
    	$('.graficoProgressbar').each(
    	function(){
    		var value = $(this).attr('valIndicador');
    		var meta = $(this).attr('meta');
    		var asc =  $(this).attr('asc');
    		if(meta != '-' && value != '-'){

    		}else{
    			$(this).progressbar({value:parseInt(0)});
    		}
    		$(this).css({ 'height': '25px' });
  			$(this).css({ 'width': '145px' });
    	});
");

$this->breadcrumbs = array(
	Yii::t('ui','Reportes')=>array('/reportes'),
    'Formulario A1 Definiciones Estratégicas',
);

$periodoActual = Yii::app()->session['idPeriodoSelecionado'];
$periodosiguiente= $periodoActual+1;
$periodosubsiguiente= $periodoActual+2;


echo "<h2 align='center'>Propuesta Ficha A-1 de Definiciones Estratégicas Año $periodosiguiente-$periodosubsiguiente</h2>";

  ?>
<div style="float:right;" id='contenedoricono'">
<div style="float:left">Exportar a:&nbsp&nbsp</div>
<a id="linkExcel"  name="linkExcel" title="Exportar a Pdf" href="<?php echo Yii::app()->request->baseUrl.'/reportes/FormA1exportfile?pdf=1'; ?>" >
<div class="iconoPdf" id ="iconoPdf" style="float:right"></div></a>
<a id="linkExcel"  name="linkExcel" title="Exportar a MS Word" href="<?php echo Yii::app()->request->baseUrl.'/reportes/FormA1exportfile?doc=1'; ?>" >
<div class="iconoWord" id ="iconoWord" style="float:right"></div></a>
</div>

<div id="contenedorformA1" class="contenedorformA1">
<div id="tabs">
		<ul>
			<li style="width: 10%"><a href="#tabs-1"><cbT>Ley Org.<br>o Decreto<br>que la rige<br><br></cbT></a></li>
			<li style="width: 11%"><a href="#tabs-2"><cbT><br>Misión<br>Institucional<br><br></cbT></a></li>
			<li style="width: 9%"><a href="#tabs-3"><cbT>Obj. Rel.<br>del <br>Ministerio<br><br></cbT></a></li>
			<li style="width: 11%"><a href="#tabs-4"><cbT><br>Obj. Est.<br>Institucional<br><br></cbT></a></li>
			<?php $tipoproductos=TiposProductos::model()->buscartipodeproducto();
			if(empty($tipoproductos)){
				echo ' No se encontraron registros';
			}else{
				for($i=0; $i<count($tipoproductos);$i++){
			$tab=$i;

			?>
			<li style="width: 11%"><a href="#tabs-<?php echo $i+5;?>"><cbT>Prod. Est.<br><?php echo $tipoproductos[$i]['nombre']; ?><br>(Bienes y/o<br> Servicios)</cbT></a></li>
			<?php }}?>
			<li style="width: 8%"><a href="#tabs-<?php echo $tab+6;?>"><cbT><br>Clientes<br><br><br></cbT></a></li>
			<?php $tipoproductos=TiposProductos::model()->buscartipodeproducto();
			if(empty($tipoproductos)){
				echo ' No se encontraron registros';
			}else{
				for($i=0; $i<count($tipoproductos);$i++){
			?>
			<li style="width: 10%"><a href="#tabs-<?php echo $tab+$i+7;?>"><cbT><br>Prod. Est.<br><?php echo $tipoproductos[$i]['nombre']; ?><br><br></cbT></a></li>
			<?php }}?>
		</ul>

	<div id="tabs-1">	
		<div id="contenedorControl1" class="contenedorformA1Pest">
			<?php 
			$leyesmandatos=LeyesMandatos::model()->buscarLeyesMandatos();
			if(empty($leyesmandatos)){
				echo ' No se encontraron registros';
					
			}else{			
			?>
			<table border='2'  cellpadding='0' cellspacing='0' style='width: 100%;' bordercolor="#6095BD"><tr align="center" bgcolor="#6095BD"><th>
			<p><h3formA1><font color="white">Ley Orgánica o Decreto Que La Rige</font></h3formA1></p>
				</th></tr>
				<tr bgcolor='#E5F1F4'><td align="left">
				<?php
				for($i=0; $i<count($leyesmandatos);$i++){
							echo $leyesmandatos[$i]['nombre'];
							if($i<(count($leyesmandatos)-2))
								echo " , ";
							if($i==(count($leyesmandatos)-2))
								echo " y ";
						}
			?>
				<br>&nbsp</td></tr>
			</table>
			<?php }?>
		 </div>
	</div>
	<div id="tabs-2">
		<div id="contenedorControl1" class="contenedorformA1Pest">
			<?php 
			$misionperiodo=MisionesVisiones::model()->buscarMisionporPeriodo();
			if(empty($misionperiodo)){
				echo ' No se encontraron registros';
					
			}else{
			?>
			<table border='2'  cellpadding='0' cellspacing='0' style='width: 100%;' bordercolor="#6095BD"><tr align="center" bgcolor="#6095BD"><th>
			<p><h3formA1><font color="white">Misión Institucional</font></h3formA1></p>
			</th></tr>
			<tr bgcolor='#E5F1F4'><td align="left">
			<?php
			
						for($i=0; $i<count($misionperiodo);$i++){
							if($misionperiodo[$i]['nombre']=='Misión'||$misionperiodo[$i]['nombre']=='Mision'||$misionperiodo[$i]['nombre']=='MISION'||$misionperiodo[$i]['nombre']=='MISIÓN'){
								echo $misionperiodo[$i]['descripcion'];
								echo "<br>";
							}
						}
			?>
			</td></tr>
			</table>
			<?php }?>
		</div>
	</div>
	<div id="tabs-3">
		<div id="contenedorControl1" class="contenedorformA1Pest">
			<?php 
			$objetivosdelministerio=ObjetivosMinisteriales::model()->buscarObjetivosMinisteriales();
			if(empty($objetivosdelministerio)){
				echo ' No se encontraron registros';
					
			}else{
			?>
			
			<table border='1' cellpadding='0' cellspacing='0' style='width: 100%;' bordercolor='#6095BD'>
			<tr><td colspan="2" align="justify">
			<h3formA1><?php for($i=0;$i<22;$i++){echo "&nbsp";} ?> Objetivos Relevantes del Ministerio<br>&nbsp</h3formA1>
			</td></tr>
			<tr align="center" bgcolor="#6095BD">
			<th style="border:1px solid #0489B1"><font color="white">&nbsp&nbspNúmero&nbsp&nbsp<br>&nbsp</font></th>
			<th style="border:1px solid #0489B1"><font color="white">Descripción<br>&nbsp</font></th>
			</tr>
			<?php
					for($i=0; $i<count($objetivosdelministerio);$i++){
								echo "<tr";
								if(($i+1)%2==1){
									echo " bgcolor='#E5F1F4'";
							    }else{echo " bgcolor='#FBFBEF'";}
								echo "><td align='center'>";
								echo ($i+1);
								echo "<br>&nbsp</td><td>";
								echo $objetivosdelministerio[$i]['descripcion'];
								$idobjministerial[$i] = $objetivosdelministerio[$i]['id'];
								
								echo "<br>&nbsp</td></tr>";
						}
						echo "</table>";
				}	
			?>
		 </div>
	</div>
	<div id="tabs-4">
		<div id="contenedorControl1" class="contenedorformA1Pest">
			<?php 
				$sumatotal=0;
				$objetivosestrategicos=ObjetivosEstrategicos::model()->buscarObjetivosEstrategicos();
				if(empty($objetivosestrategicos)){
				echo ' No se encontraron registros';
				}else{
					
			?>
			<table border='1' cellpadding='0' cellspacing='0' style='width: 100%;' bordercolor='#6095BD'>
			<tr><td colspan='5'>
			<h3formA1><?php for($i=0;$i<20;$i++){echo "&nbsp";}?>Objetivos Estratégicos Institucionales<br>&nbsp</h3formA1>
			</td></tr>
			<tr align="center" bgcolor="#6095BD">
			<th style="border:1px solid #0489B1"><font color="white">&nbsp&nbspNº&nbsp&nbsp<br>&nbsp</font></th>
			<th style="border:1px solid #0489B1"><font color="white">Descripción<br>&nbsp</font></th>
			<th style="border:1px solid #0489B1"><font color="white">Objetivos<br>Relevantes<br>del<br>Ministerio<br>vinculados<br>&nbsp</font></th>
			<?php 
			if(empty($tipoproductos)){
				echo ' No se encontraron registros';
			}else{
				for($i=0; $i<count($tipoproductos);$i++){
					echo "<th style='border:1px solid #0489B1'><font color='white'>Productos<br>Estratégicos<br>";
					echo $tipoproductos[$i]['nombre'];
					echo "<br>vinculados<br>&nbsp</font></th>";
				}
			}
			
			?>			
			</tr>
				<?php
							
					for($i=0; $i<count($objetivosestrategicos);$i++){
						echo "<tr";
								if(($i+1)%2==1){
									echo " bgcolor='#E5F1F4'";
							    }else{echo " bgcolor='#FBFBEF'";}
						echo "><td align='center'>";
						echo $i+1;
						echo "<br>&nbsp</td><td>";
						echo $objetivosestrategicos[$i]['descripcion'];
						echo "<br>&nbsp</td><td align='center' style='width: 15%;'>";
						$objetivosobjetivos=ObjetivosObjetivos::model()->buscarObjetivosObjetivo($objetivosestrategicos[$i]['id']);
						
						if(empty($objetivosobjetivos)){
							echo 'No Se Vincula';
						}
						else{
							$l=count($idobjministerial);
							for($j=0;$j<count($objetivosobjetivos);$j++){
							$m=0;
							while($m<$l){
								if($objetivosobjetivos[$j]['objetivo_ministerial_id']==$idobjministerial[$m]){
										if($j!=0){echo ',';}
											echo $m+1;
											$m++;
											}else{
												$m++;
											}
									}
							}
						}
						for($b=0; $b<count($tipoproductos);$b++){
							$objetivosproductos=ObjetivosProductos::model()->buscarobjetivosProducto($objetivosestrategicos[$i]['id']);
							echo "<br>&nbsp</td><td align='center' style='width: 15%;'>";
							$productosestrategicos=ProductosEstrategicos::model()->productosestrategicosporObjetivosestrategicosytipoproducto($objetivosestrategicos[$i]['id'],$tipoproductos[$b]['id']);
							for($j=0;$j<count($productosestrategicos);$j++){
								$id_productoestrategico[$j]=$productosestrategicos[$j]['id'];
							}
							if(empty($productosestrategicos)){
								echo 'No Se Vincula';
							}
							else{
								$l=count($id_productoestrategico);
								for($j=0;$j<count($objetivosproductos);$j++){
									$bandera=0;
									$m=0;
									while($m<$l){
										if($objetivosproductos[$j]['producto_estrategico_id']==$id_productoestrategico[$m]){
											if($j!=0 && $bandera>0){echo ',';}
											echo $m+1;
											$m++;
										}else{
											$m++;
											$bandera++;
										}
									}
								}	
							}

						}
							echo "<br>&nbsp</td></tr>";
					}
			?>
		</table>
		<?php }?>
		 </div>
	</div>
	<?php for($u=0;$u<=$tab;$u++){?>
	<div id="tabs-<?php echo $u+5;?>">
		<div id="contenedorControl1" class="contenedorformA1Pest">
		<?php 
		$clientes=Clientes::model()->buscarClientes();
		if(empty($clientes)){
		
		}else{
			for($j=0;$j<count($clientes);$j++){
				$id_clientes[$j]=$clientes[$j]['id'];
			}
		}
		$productoestrategico=ProductosEstrategicos::model()->productosestrategicosportipoproducto($tipoproductos[$u]['id']);
		//**************************Se suma el total del presupuesto*****************//
		for($i=0;$i<count($productoestrategico);$i++){
			$montoitemactividad=ItemesActividades::model()->buscarmontoporitemactividaddeproductoestra($productoestrategico[$i]['id']);
			$sumaia = 0;
			$sumapi = 0;
			$sumapitotal=0;
			if(empty($montoitemactividad)){
				$sumaia=0;
			}else{
				for($j=0;$j<count($montoitemactividad);$j++){
					$sumaia = $sumaia+$montoitemactividad[$j]['monto'];
				}
			}
			$porcentaje = ProductoEstrategicoCentroCosto::model()->buscarporcporpestrategico($productoestrategico[$i]['id']);
				if(empty($porcentaje)){
					$sumapi=0;
					$sumapitotal=0;
				}else{
					for($m=0;$m<count($porcentaje);$m++){
						$sumapi=0;
						$montoproductoitem=ProductosItemes::model()->buscarmontoporproductoitem($productoestrategico[$i]['id'],$porcentaje[$m]['centro_costo_id']);
						if(empty($montoproductoitem)){
		
						}else{
							for($j=0;$j<count($montoproductoitem);$j++){
								$sumapi = $sumapi+$montoproductoitem[$j]['monto'];
							}
							$sumapi = $sumapi*($porcentaje[$m]['porcentaje']/100);
							$sumapitotal = $sumapitotal + $sumapi;
						}
					}
				}
			$sumatotal = $sumatotal+($sumaia+$sumapitotal);
		}
		//**********************fin*********************//
		
		if(empty($productoestrategico)){
			echo ' No se encontraron registros';
		
		}else{
		?>
		<table border='1' cellpadding='0' cellspacing='0' style='width: 100%;' bordercolor="#6095BD">
		<tr><td colspan='7'>
		<h3formA1><?php for($i=0;$i<20;$i++){echo "&nbsp";}?>Productos Estratégicos <?php echo $tipoproductos[$u]['nombre']; ?> (Bienes y/o Servicios) <br>&nbsp</h3formA1>
		</td></tr>
		<tr bgcolor="#6095BD">
		<th style="border:1px solid #0489B1"><font color="white">&nbspNº&nbsp</font></th>
		<th style="border:1px solid #0489B1"><font color="white">Producto Estratégico <?php echo $tipoproductos[$u]['nombre']; ?></font></th>
		<th style="border:1px solid #0489B1"><font color="white">Descripción</font></th>
		<th style="border:1px solid #0489B1"><font color="white">Subproducto-Productos<br>Específicos</font></th>
		<th style="border:1px solid #0489B1"><font color="white">Clientes</font></th>
		<th style="border:1px solid #0489B1"><font color="white">Aplica<br>G. Territorial</font></th>
		<th style="border:1px solid #0489B1"><font color="white">Aplica<br>Género</font></th>
		</tr>
		<?php
			for($i=0;$i<count($productoestrategico);$i++){
				echo "<tr";
				if(($i+1)%2==1){
					echo " bgcolor='#E5F1F4'";
				}else{echo " bgcolor='#FBFBEF'";}
				echo "><td align='center'>";
				echo $i+1;
				echo "</td><td>";
				echo $productoestrategico[$i]['nombre'];
				echo "</td>";
				echo "<td>";
				echo $productoestrategico[$i]['descripcion'];
				echo "</td>";
				echo "<td style='width: 35%;'>";
				$subproducto=Subproductos::model()->subproductosxproductoestrategico($productoestrategico[$i]['id']);
				if(empty($subproducto)){
					echo ' No se encontraron registros';
				}else{
					for($j=0;$j<count($subproducto);$j++){
						echo " * ".$subproducto[$j]['nombre']."<br>";
						$productoespecifico=ProductosEspecificos::model()->productoEspecificoPorSub($subproducto[$j]['id']);
						if(empty($productoespecifico)){
							echo "";
						
						}else{
							for($k=0;$k<count($productoespecifico);$k++){
								echo "&nbsp&nbsp-&nbsp".$productoespecifico[$k]['nombre']."<br>";
							}
						}
					}
				}
				echo "</td>";
				echo "<td align='center'>";
				$productos_clientes= ProductosClientes::model()->buscarclientesporproducto($productoestrategico[$i]['id']);
				
				$l=count($id_clientes);
				for($j=0;$j<count($productos_clientes);$j++){
					$bandera=0;
					$m=0;
					while($m<$l){
						if($productos_clientes[$j]['cliente_id']==$id_clientes[$m]){
							if($j!=0 && $bandera>0){echo ',';}
							if($j%3==0){echo "<br>";}
							echo $m+1;
							$m++;
						}else{
							$m++;
							$bandera++;
						}
					}
				}
				
				echo "<br>&nbsp</td>";
				echo "<td align='center'>";
				if($productoestrategico[$i]['gestion_territorial']==1){
					echo "Si";
				}else{
					echo "No";
				}
				echo "</td>";
				echo "<td align='center'>";
				if($productoestrategico[$i]['desagregado_sexo']==1){
					echo "Si";
				}else{
					echo "No";
				}
				echo "</td>";
				echo "</tr>";
			}	
		?>
		</table>
		<?php }?>
		</div>
	</div>
	<?php }?>
	<div id="tabs-<?php echo $tab+6;?>">
 		<div id="contenedorControl1" class="contenedorformA1Pest"> 
		<?php 
 		if(empty($clientes)){
 			echo ' No se encontraron registros';
				
 		}else{
 		?>
		<table border='1' cellpadding='0' cellspacing='0' style='width: 100%;' bordercolor='#6095BD'>
 			<tr align="center" bgcolor="#6095BD"> 
			<th style="border:1px solid #0489B1"><font color="white">&nbsp&nbspNº&nbsp&nbsp<br>&nbsp</font></th>
			<th style="border:1px solid #0489B1"><font color="white">Clientes<br>&nbsp</font></th>
			<th style="border:1px solid #0489B1"><font color="white">Cuantificación<br>&nbsp</font></th>
 			</tr>
			<?php
					for($i=0; $i<count($clientes);$i++){
							echo "<tr";
							if(($i+1)%2==1){
								echo " bgcolor='#E5F1F4'";
							}else{echo " bgcolor='#FBFBEF'";}
							echo "><td align='center'>";
							echo ($i+1);
							echo "<br>&nbsp</td><td>";
							echo $clientes[$i]['nombre'];								
							echo "<br>&nbsp</td><td><br>&nbsp</td></tr>";
						}
				echo "</table>";
			}	
		?>
		</div> 
 	</div> 
	<?php for($y=0;$y<=$tab;$y++){?>
	<div id="tabs-<?php echo $tab+$y+7;?>">
		<div id="contenedorControl1" class="contenedorformA1Pest">
		<?php 
		$productoestrategico=ProductosEstrategicos::model()->productosestrategicosportipoproducto($tipoproductos[$y]['id']);
		
		if(empty($productoestrategico)){
			echo ' No se encontraron registros';
		
		}else{
		?>
		<table border='2' cellpadding='0' cellspacing='0' style='width: 100%;' bordercolor="#6095BD">
		<tr bgcolor="#6095BD">
		<th rowspan='2' scope='col'><font color="white">Nº</font></th>
		<th rowspan='2' scope='col' style="border:1px solid #0489B1"><font color="white">Producto Estratégico <?php echo $tipoproductos[$y]['nombre']; ?></font></th>
		<th colspan='2' scope='col' style="border:1px solid #0489B1"><font color="white">Presupuesto <?php echo $periodosiguiente;?><br>&nbsp</font></th>
		</tr>
		<tr bgcolor="#6095BD" >
		<th align='center' scope='col' style="border:1px solid #0489B1"><font color="white">(Miles de $)<br>&nbsp</font></th>
		<th align='center' scope='col' style="border:1px solid #0489B1"><font color="white">%<br>&nbsp</font></th>
		</tr>
		<?php
			
			for($i=0;$i<count($productoestrategico);$i++){
				?>
				<tr onclick="className='onclickmouse';" 
				<?php
				if(($i+1)%2==1){
					echo " bgcolor='#E5F1F4'";
					?> onmouseout="className='offclickmouseimpar';" <?php 
				}else{echo " bgcolor='#FBFBEF'";
							?> onmouseout="className='offclickmousepar';" <?php
				}
				echo ">";
				
				echo "<td align='center'>";
				echo $i+1;
				echo "</td>";
				echo "<td>";
				echo $productoestrategico[$i]['nombre'];
				echo "</td>";
				echo "<td align='center'>";
				$montoitemactividad=ItemesActividades::model()->buscarmontoporitemactividaddeproductoestra($productoestrategico[$i]['id']);
				$sumaia = 0;
				$sumapi = 0;
				$sumapitotal=0;
				if(empty($montoitemactividad)){
					$sumaia=0;
				}else{
					for($j=0;$j<count($montoitemactividad);$j++){
						$sumaia = $sumaia+$montoitemactividad[$j]['monto'];
					}
				}
				$porcentaje = ProductoEstrategicoCentroCosto::model()->buscarporcporpestrategico($productoestrategico[$i]['id']);
				if(empty($porcentaje)){
					$sumapi=0;
					$sumapitotal=0;
				}else{
					for($m=0;$m<count($porcentaje);$m++){
						$sumapi=0;
						$montoproductoitem=ProductosItemes::model()->buscarmontoporproductoitem($productoestrategico[$i]['id'],$porcentaje[$m]['centro_costo_id']);
						if(empty($montoproductoitem)){
		
						}else{
							for($j=0;$j<count($montoproductoitem);$j++){
								$sumapi = $sumapi+$montoproductoitem[$j]['monto'];
							}
							$sumapi = $sumapi*($porcentaje[$m]['porcentaje']/100);
							$sumapitotal = $sumapitotal + $sumapi;
						}
					}
				}
				$numero = $sumaia+$sumapitotal;
				echo "$".number_format($numero,0, "", ".");
				echo "</td>";
				echo "<td align='center'>";
/*
 * 
 					if($sumatotal>0){
						$porc=((($sumaia+$sumapitotal)*100)/$sumatotal);
					}else{
						$porc= 0;
					}
*/
                    if($sumatotal!=0){
					   $porc=((($sumaia+$sumapitotal)*100)/$sumatotal);
                    }else {
                        $porc=0;
                    }
                    
					if($porc==0){
						echo $porc."%";
					}else{
						echo $english_format_number = number_format($porc, 2, ',', '')."%";
					}
					
				echo "</td>";
				echo "</tr>";
			}			
		?>
		</table>
		<?php }?>
		</div>
	</div>
	<?php }?>
</div>
</div>