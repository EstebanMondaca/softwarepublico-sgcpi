<?php

class ConsultasView{

	 public $mes;
	 public $meses;
	 public $anio;
	 public $numeroMesActual;
	function initialize() 
	{
		date_default_timezone_set("America/Santiago");
	    $this->mes = date("F");
	    $this->anio = date("Y");
	    $this->numeroMesActual = date("n");
	    $this->meses = array(1  => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4  => 'Abril', 5 => 'Mayo', 6 => 'Junio', 7  => 'Julio', 8 => 'Agosto', 9 => 'Septiembre', 10  => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre' );
	
	    	if ($this->mes=="January") $this->mes="Enero";
			if ($this->mes=="February") $this->mes="Febrero";
			if ($this->mes=="March") $this->mes="Marzo";
			if ($this->mes=="April") $this->mes="Abril";
			if ($this->mes=="May") $this->mes="Mayo";
			if ($this->mes=="June") $this->mes="Junio";
			if ($this->mes=="July") $this->mes="Julio";
			if ($this->mes=="August") $this->mes="Agosto";
			if ($this->mes=="September") $this->mes="Setiembre";
			if ($this->mes=="October") $this->mes="Octubre";
			if ($this->mes=="November") $this->mes="Noviembre";
			if ($this->mes=="December") $this->mes="Diciembre";
	}
	//funcion que calcula la meta reportada, no se utiliza por que se extrae directamente de la base de datos el campo meta_reportada
	/*function calcularPorcentajeHito($a, $b, $c, $formula, $metaAnual, $tipo_resultado){
		
			$error=false;
			
		
								
							$bandera = strrpos($formula,'A', 0);
							
							if($bandera===false){
								
							}else{//si esta el concepto a
								if(!empty($a)){
								$formula = str_replace('A',$a,$formula);
								}else{
									$error = true;
								}
							}
				
						
						
							
							$bandera2 = strrpos($formula,"B", 0);
							
							if($bandera2===false){
								
							}else{//si esta el concepto b
								
								if(!empty($b)){  	
									$formula = str_replace('B',$b,$formula);
								}else{
									$error = true;
								}
							}

							
							$bandera3 = strrpos($formula,"C", 0);
							
							if($bandera3===false){
								
							}else{//si esta el concepto b
								
								if(!empty($c)){  	
									$formula = str_replace('C',$c,$formula);
								}else{
									$error = true;
								}
							}
							
							
							if($error===false){
								
								 eval('$resultado = '.$formula.';');
				
								 if($tipo_resultado == 0){//aplicar la regla de 3 simple
								 
								 	if(!empty($metaAnual)&&$metaAnual != 0){
								 	
								 		$resultado = ($resultado*100)/$metaAnual;
								 		
								 	}else{
								 		
								 		$resultado = -1;//falta la meta anual
								 	}
								 	
								 }
							
							}
							else{
								$resultado = -1;//faltan parametos para calcular pocentaje
							}
							
					
			if($resultado != -1){
				return round($resultado*100)/100;// se multipica y divide solo para redondear
			}	
			else{
				return $resultado;//si el resultado es -1 se devuelve tal cual
			}
		
	}*/
	
	function encuentraUltimoHitoAnioAnterior($hitosIndicador, $meses){
		
		$posicionUltimoHito=-1;
		$datosUltimoHito=array();
		$ultimoRegistro=0;
		

		for($i=0; $i<count($hitosIndicador); $i++){
			
			for($j=1; $j<count($meses)+1;$j++){
			
				if(strtolower($hitosIndicador[$i]['mes'])==strtolower($meses[$j])&&!empty($hitosIndicador[$i]['meta_reportada'])){//encuentra el mes del hito en los 12
					
					if($j>$ultimoRegistro){//si el mes encontrado esta por encima del ultimo, cambia a la posicion nueva
						$ultimoRegistro = $j;
						$posicionUltimoHito = $i;
						
						
					}//fin if
				}
			}//fin for interno
		}//fin for externo
		if($posicionUltimoHito != -1){
			/*$datosUltimoHito['conceptoa']=$hitosIndicador[$posicionUltimoHito]['conceptoa'];
			$datosUltimoHito['conceptob']=$hitosIndicador[$posicionUltimoHito]['conceptob'];
			$datosUltimoHito['conceptoc']=$hitosIndicador[$posicionUltimoHito]['conceptoc'];*/
			$datosUltimoHito['meta_parcial']=$hitosIndicador[$posicionUltimoHito]['meta_parcial'];
			$datosUltimoHito['mes']=$hitosIndicador[$posicionUltimoHito]['mes'];
			$datosUltimoHito['fecha']=$hitosIndicador[$posicionUltimoHito]['fecha'];
			$datosUltimoHito['meta_reportada']=$hitosIndicador[$posicionUltimoHito]['meta_reportada'];
		
		}
				
		return $datosUltimoHito;
	}
	
	function verificaAtraso($hitosIndicador, $meses){
		
		$primeraPosicion=14;
		$la='';
		$datosPrimerHito=array();
		$primerRegistro=14;
		

		for($i=0; $i<count($hitosIndicador); $i++){
			
			for($j=1; $j<count($meses)+1;$j++){
			
				if(strtolower($hitosIndicador[$i]['mes'])==strtolower($meses[$j])){//encuentra el mes del hito en los 12
					
					if($j<$primerRegistro){//si el mes encontrado esta por debajo del ultimo, cambia a la posicion nueva
						$primerRegistro = $j;
						$primeraPosicion = $i;
						
						
					}//fin if
				}
			}//fin for interno
		}//fin for externo

		if($primeraPosicion == 14){
			$primerRegistro = -1;
		}
				
		return $primerRegistro;
		
	}
	function encuentraUltimoHito($hitosIndicador, $mesActual, $meses){
		
		$posicionUltimoHito=-1;
		$datosUltimoHito=array();
		$ultimoRegistro=0;
		

		for($i=0; $i<count($hitosIndicador); $i++){
			
			for($j=1; $j<count($meses)+1;$j++){
			
				if(strtolower($hitosIndicador[$i]['mes'])==strtolower($meses[$j])&&!empty($hitosIndicador[$i]['meta_reportada'])){//encuentra el mes del hito en los 12
					
					if($j>$ultimoRegistro&&$j<=$mesActual){//si el mes encontrado esta por encima del ultimo, cambia a la posicion nueva
						$ultimoRegistro=$j;
						$posicionUltimoHito = $i;
						
						
					}//fin if
				}
			}//fin for interno
		}//fin for externo
		if($posicionUltimoHito != -1){
		/*	$datosUltimoHito['conceptoa']=$hitosIndicador[$posicionUltimoHito]['conceptoa'];
			$datosUltimoHito['conceptob']=$hitosIndicador[$posicionUltimoHito]['conceptob'];
			$datosUltimoHito['conceptoc']=$hitosIndicador[$posicionUltimoHito]['conceptoc'];*/
			$datosUltimoHito['meta_parcial']=$hitosIndicador[$posicionUltimoHito]['meta_parcial'];
			$datosUltimoHito['mes']=$hitosIndicador[$posicionUltimoHito]['mes'];
			$datosUltimoHito['fecha']=$hitosIndicador[$posicionUltimoHito]['fecha'];
			$datosUltimoHito['meta_reportada']=$hitosIndicador[$posicionUltimoHito]['meta_reportada'];
		
		}
				
		return $datosUltimoHito;
	}
	
	function construyendoBarras($idIndicador, $frecuencia){
		
			$this->initialize();
			$resultado=array();
			$ultimoHito=array();
			//obtiene el ultimo hito segun la id del indicador
			$hito=HitosIndicadores::model()->ultimoHitoIndicador($idIndicador);
		
			
		
			if(!empty($hito)&&count($hito)!=0){//si tiene al menos un hito registrado
				
				
						if(Yii::app()->session['idPeriodoSelecionado']!=$this->anio){// no lo encontro por lo tanto no se trata del mismo año, lo calcula con el ultimo registrado
			
							$ultimoHito=$this->encuentraUltimoHitoAnioAnterior($hito, $this->meses);
				
						if(!empty($ultimoHito)&&count($ultimoHito)!=0){
							//	$p = $this->calcularPorcentajeHito($ultimoHito['conceptoa'], $ultimoHito['conceptob'],$ultimoHito['conceptoc'], $tipoFormula,$metaAnual, $tipoResultadoFormula);
							
								$resultado['value'] = $ultimoHito['meta_reportada'];
								$resultado['fecha'] = $ultimoHito['fecha'];
								$resultado['meta'] = $ultimoHito['meta_parcial'];
								$resultado['bandera'] = 1;
							
						}else{
								$resultado['value'] = -1;
								$resultado['fecha'] = -1;
								$resultado['meta'] = -1;
								$resultado['bandera'] = 2;
							
						}
						}else{//si lo encuentra se trata del mismo año lo calcula normal
						
						
						$ultimoHito=$this->encuentraUltimoHito($hito, $this->numeroMesActual, $this->meses);
						$resultado['ultimo_hito_largo'] = count($ultimoHito);
						if(!empty($ultimoHito)&&count($ultimoHito)!=0){
							$auxiliar = 0;
							$auxiliar2 = 0;
							$bandera=0;
							$bandera2=0;
							for($j=1; $j < count($this->meses)+1; $j++){
								
								if(strtolower($this->mes)==strtolower($this->meses[$j])){//si pilla al mes dentro del arreglo		
									$auxiliar2 = $j;
									$bandera = 1;
								}
								if(strtolower($ultimoHito['mes'])==strtolower($this->meses[$j])){
									$auxiliar = $j;
									$bandera2=1;
								}
								if($bandera==1&&$bandera2==1){//sale del for ya obtuvo las posiciones de ambos
									$j=count($this->meses);
								}
								
							}//fin for
							
						//analiza las posiciones
						
							if($auxiliar2<=$auxiliar+$frecuencia&&$auxiliar2>=$auxiliar){//esta dentro del rango del trimestre y debe cslcular el porcentaje
								
								//$p = $this->calcularPorcentajeHito($ultimoHito['conceptoa'], $ultimoHito['conceptob'],$ultimoHito['conceptoc'], $tipoFormula,$metaAnual, $tipoResultadoFormula);
							
								$resultado['value'] = $ultimoHito['meta_reportada'];;
								$resultado['fecha'] = $ultimoHito['fecha'];
								$resultado['meta'] = $ultimoHito['meta_parcial'];
								$resultado['bandera'] = 3;
								
								
							}//para todas las otras opcines debe ser rojo
							else{
								//falta ser registrado un hito para el trimestre correspondiente
								$resultado['value'] = -1;
								$resultado['fecha'] = -1;
								$resultado['meta'] = -1;
								$resultado['bandera'] = 4;
							
							}
			
						}//si trae ultimo hito registrado
						else{//no encontro ultimo hito
							
							$posicionPrimerHito = $this->verificaAtraso($hito, $this->meses);
							$aux=0;
							$posicionMesActual=0;
							for($p=1; $p<count($this->meses); $p++){
								if(strtolower($this->mes)==strtolower($this->meses[$p])){//si pilla al mes dentro del arreglo		
										$posicionMesActual = $p;
										$axu = 1;
								}
								
								if($aux==1){
									$p=count($this->meses);
								}
							}//fin for
							if($posicionMesActual<$posicionPrimerHito&&$posicionPrimerHito!=-1){
								$resultado['value'] = -1;
								$resultado['fecha'] = -1;
								$resultado['meta'] = -1;
								$resultado['bandera'] = 9;
								
							}else{
								$resultado['value'] = -1;
								$resultado['fecha'] = -1;
								$resultado['meta'] = -1;
								$resultado['bandera'] = 5;
							}
								
						
							
						}
			}
			}else{//si no tiene hitos registrados, debe ir a rojo
				
						$resultado['value'] = -1;
						$resultado['fecha'] = -1;
						$resultado['meta'] = -1;
						$resultado['bandera'] = 6;
				
			}
		
			
			
		return $resultado;
}
	
	function recorreResultado($r, $i, $n, $m){// datos array, la id, nombre, la primera letra a mostrar
			
		$this->initialize();
		$id = 0; 
		$contadorRojos = 0;
		$contadorAmarillos = 0;
		$nombre='';
		$bandera = 0;
		$x = 0;
		$j=0;
		$arreglo=array();
		
		foreach($r as $k=>$v):
		
				$value = 0;
										
				if($bandera != $v[$i]){
								
					if($id!=0&&$id!=$v[$i]){
						
						$x++;
						if($contadorRojos!=0){
							
							$arreglo[$j]['c']='<br><p><div class=iconoRojo></div>'.' '.$m.$x.': '.$nombre.'</p>';
							$arreglo[$j]['id']=$id;
							$arreglo[$j]['nom']=$nombre;
							$j++;
						}
						else{
													
						if($contadorAmarillos!=0){
							$arreglo[$j]['c']='<br><p><div class=iconoAmarillo></div>'.' '.$m.$x.': '.$nombre.'</p>';
							$arreglo[$j]['id']=$id;
							$arreglo[$j]['nom']=$nombre;
							$j++;
						}else{

							if($contadorAmarillos==0 && $contadorRojos==0){
								$arreglo[$j]['c']='<br><p><div class=iconoVerde></div>'.' '.$m.$x.': '.$nombre.'</p>';
								$arreglo[$j]['id']=$id;
								$arreglo[$j]['nom']=$nombre;
								$j++;
							}
						}
						
					
					}
				$contadorRojos = 0;
				$contadorAmarillos = 0;
												
				}
			
				$value= $this->construyendoBarras($v['id'], $v['plazo_maximo']);

				if($value['value'] != -1 && $value['meta']!= -1 && $value['bandera'] != 9){//si trajo valores reales
					
					$val = $value['value'];//valor
			     	$me = $value['meta'];//meta
			      	$xe = ($me*10)/100;//el 10 % de la meta
			      	$total = $val+$xe;// es la suma del valor con el 10 % calculado
					
					if($v['ascendente'] == 1){//si es ascendente
							if ($value['value'] >= $value['meta']){//si es igual o mayor que meta esperada es verde
					   
					        } 
					        else{
					        
					        	if($value['value']<$value['meta']&&$total >=$value['meta']){// si no es mas baja que un 10% debe ser amarillo
					        	
					        		$contadorAmarillos++;
					        	}
					        	else{//sino rojo
					        	
					        		$contadorRojos++;
									$bandera = $v[$i];
					        	
					        	}
					        }
					
					}else{// si es descendente
						
						/////////////aki la meta esperada puede ser cero
						if ($value['value'] <= $value['meta']){//si es igual o menor que meta esperada es verde
				   
				        } 
				        else{
				        
				        	if($value['value']>$value['meta']&&$total <=$value['meta']){// si no es mas baja que un 10% debe ser amarillo
				        	
				        		$contadorAmarillos++;
				        	}
				        	else{//sino rojo
				        	
				        		$contadorRojos++;
								$bandera = $v[$i];
				        	
				        	}
				        }
						
					}
				
				}//fin si trajo valores reales
				else{
					if($value['bandera']==9){
						$arreglo[$j]['vino']=$value['bandera'];
					}else{
						$arreglo[$j]['vino']=$value['bandera'];
						$contadorRojos++;
						$bandera = $v[$i];
					}
				}
										
			}
			$id = $v[$i];
			$nombre = $v[$n];
			
			
		endforeach;
if($id!=0){

	$x++;

	if($contadorRojos!=0){
		$arreglo[$j]['c']= '<br><p><div class=iconoRojo></div>'.' '.$m.$x.': '.$nombre.'</p>';
		$arreglo[$j]['id']=$id;
		$arreglo[$j]['nom']=$nombre;
		$j++;
	}
	else{
												
		if($contadorAmarillos!=0){
			$arreglo[$j]['c']= '<br><p><div class=iconoAmarillo></div>'.' '.$m.$x.': '.$nombre.'</p>';
			$arreglo[$j]['id']=$id;
			$arreglo[$j]['nom']=$nombre;
			$j++;
		}else{
													
			$arreglo[$j]['c']= '<br><p><div class=iconoVerde></div>'.' '.$m.$x.': '.$nombre.'</p>';
			$arreglo[$j]['id']=$id;
			$arreglo[$j]['nom']=$nombre;
			$j++;
		}
   }

   
}

return $arreglo;

}//fin function



//metodo para encontrar el ultimo la_elem_gestion segun su fecha y que tenga puntaje revisado
/*
public function getUltimoPuntajeElemGestion($puntajes){

	   date_default_timezone_set("America/Santiago");//estableciento la zona horaria
       $fechaActual = date("Y-m-d H:i:s");//obteniendo la fecha actual
       $ultimaPosicion = -1;
       $ultimaFechaAlmacenada = '0000-00-00 00:00:00';
       $ultimoRegistroArray= array();
      
       for($o=0; $o<count($puntajes);$o++){
			//validando que venga la fecha y puntaje revisado
			if(isset($puntajes[$o]['fecha'])&&$puntajes[$o]['puntaje_revisado']>0){

				//si la fecha que vien es menor que la fecha actual y mayor que la ultima almacenada
				if(strtotime($puntajes[$o]['fecha'])<strtotime($fechaActual)&&strtotime($puntajes[$o]['fecha'])>strtotime($ultimaFechaAlmacenada)){
					$ultimaFechaAlmacenada = $puntajes[$o]['fecha'];//guardando ultima fecha que cumple con los requisitos
					$ultimaPosicion = $o;
						
				}//fin if interno
			}//fin if externo
		
		}//fin for
				
		if($ultimaPosicion!=-1){
			$ultimoRegistroArray['puntaje_revisado'] =  $puntajes[$ultimaPosicion]['puntaje_revisado'];
			$ultimoRegistroArray['puntaje_actual'] = $puntajes[$ultimaPosicion]['puntaje_actual'];
			$ultimoRegistroArray['fecha']=$puntajes[$ultimaPosicion]['fecha'];
		}//fin if
		else{
			$ultimoRegistroArray['puntaje_revisado'] =  0;
			$ultimoRegistroArray['puntaje_actual'] = 0;
			$ultimoRegistroArray['fecha']='S.I.';
		}
		
		return $ultimoRegistroArray;
	
}//fin function

public function puntajeRevisadoSubcriterio($puntajeElementoGestion){
	$sumaPuntaje = 0.0;
	
	$sumaPuntaje = $sumaPuntaje+
	
}//fin funcion*/
	
}//fin clase
?>