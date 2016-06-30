<?php
include dirname(Yii::app()->request->scriptFile).'/protected/views/panelAvances/ConsultasView.php';

class ResumenGeneralController extends GxController {
//comentario
    public function filters() {
    return array(
            'accessControl', 
            );
    }
    
    public function accessRules() {                  
          return array(
            array('allow',
                		'actions'=>array('index','reportesTab1','reporteTab2', 'reporteTab3', 'reporteTab4', 'obtenerDatosTablaElementos','prueba','obtenerSubcriterios', 'obtenerElementos' , 'jsonGraficoPorCriterio'),    
           				'roles'=>array('gestor','finanzas','supervisor','supervisor2'),  
            		),
          	array('allow',
            		'actions'=>array('jsonGraficoRadarPorCriteriosSegunPeriodos','jsonGraficoBarraPorIndicadoresFH'),    
                 	'users'=>array('*'), 
            ),             
            array('deny',
                'users'=>array('*'),
            ),
        );
    }  


public function actionIndex() {
    
        //trae todos los criterios de estado 1
        $dataProvider1 = array();
        $dataProvider2 = array();
        $arraySubcriterio=array();
        $arrayCalculoPRC = array();
        $arrayPuntajeActual = array();
        $arraySubcriterioF = array();
        $subOrdenado = array();
        //tabs 2
        if(isset($_GET['ElementosGestion']['id_subcriterio'])){
        
            $id_subcriterio = $_GET['ElementosGestion']['id_subcriterio'];
            $dataProvider1 = ElementosGestion::model()->findAll(array('condition'=>'estado = 1 AND id_subcriterio='.$id_subcriterio));
        }
        //convirtiendo el array en un dataprovider
        $dataProvider = new CArrayDataProvider($dataProvider1,
                array(
                        'keyField' => 'id',
                        'id' => 'data',
                        'pagination'=>array(
                                'pageSize'=>15,
                        ),
                )
                    
        );
        //tabs 3

        if(isset($_GET['SubcriteriosPuntaje']['id_criterio'])){
            
            $id_criterioS = $_GET['SubcriteriosPuntaje']['id_criterio'];
            
            $subCriteriosFiltro = Subcriterios::model()->findAll(array('condition'=>'estado = 1 AND id_criterio='.$id_criterioS));
                
            $arrayPuntajeActualF = array();
            $arrayCalculoPRCF = array();
            $dataRF = array();
                
            foreach ($subCriteriosFiltro as $s){
                    
                $arraySubcriterioF[$s->id]['id']=$s->id;
                $arraySubcriterioF[$s->id]['valor']='S.I.';
                $arraySubcriterioF[$s->id]['nombre']=$s->nombre;
                $arraySubcriterioF[$s->id]['factor']=$s->factor;
                    
                //obtine la suma de puntaje actual por subcriterio
                $arraySubcriterioF[$s->id]['puntajeActualSub']=0;
                    
                $arrayPuntajeActualF =ElementosGestion::model()->getPuntajesActualPorSub($s->id);
                    
                    
                $arraySubcriterioF[$s->id]['puntajeActualSub']=$arrayPuntajeActualF[0]['puntaje_actual'];
                $cantidadEl = 0;
                foreach($s->elementosGestions as $el){
                    if($el->estado==1)
                        $cantidadEl++;
                }
                    
                $arraySubcriterioF[$s->id]['puntaje_maximoSub']=$cantidadEl*5;
                $arraySubcriterioF[$s->id]['logro']=0;
                $arraySubcriterioF[$s->id]['PRN']=0;
                $arraySubcriterioF[$s->id]['PAN']=0;
                $arrayCalculoPRCF['revisadoN']='S.I.';
                $arrayCalculoPRCF['maximo']='S.I.';
                $arrayCalculoPRCF['maximo2']='S.I.';
                $arrayCalculoPRCF['revisado']='S.I.';
                $arrayCalculoPRCF['criterio_nom']='S.I.';
                $arrayCalculoPRCF['porcentaje_final']='S.I.';
                $arrayCalculoPRCF['porcentaje_finalActual']='S.I.';
                $arrayCalculoPRCF['actual']='S.I.';
                $arraySubcriterioF[$s->id]['logroActual']=0;
                    
                if($arraySubcriterioF[$s->id]['puntaje_maximoSub']!=0){
                        
                    $arraySubcriterioF[$s->id]['logroActual']=($arraySubcriterioF[$s->id]['puntajeActualSub']/$arraySubcriterioF[$s->id]['puntaje_maximoSub']);
                        
                }else{
                    $arraySubcriterioF[$s->id]['logroActual']=($arraySubcriterioF[$s->id]['puntajeActualSub']/1);
                }
                $arraySubcriterioF[$s->id]['PAN']=$arraySubcriterioF[$s->id]['logroActual']*$arraySubcriterioF[$s->id]['factor'];
                $dataRF = Subcriterios::model()->getDatosResumenGeneral($s->id);
                for($i=0; $i<count($dataRF); $i++){
                
                    $arraySubcriterioF[$dataRF[$i]['id_subcriterio']]['valor']=$dataRF[$i]['puntaje_revisado'];
                    if($arraySubcriterioF[$dataRF[$i]['id_subcriterio']]['puntaje_maximoSub'] != 0){
                        $arraySubcriterioF[$dataRF[$i]['id_subcriterio']]['logro']=($dataRF[$i]['puntaje_revisado']/$arraySubcriterioF[$dataRF[$i]['id_subcriterio']]['puntaje_maximoSub'])*100;
                    }else{
                        $arraySubcriterioF[$dataRF[$i]['id_subcriterio']]['logro']=($dataRF[$i]['puntaje_revisado']/1)*100;
                    }
                    $arraySubcriterioF[$dataRF[$i]['id_subcriterio']]['PRN']=$arraySubcriterioF[$dataRF[$i]['id_subcriterio']]['logro']*$dataRF[$i]['factor'];

                }//fin segundo for
                
            }//fin primer for
                
            
                
            //segundo for
            
            $division = 0;
            foreach ($arraySubcriterioF as $k=>$v){
                //echo $v['PRN'];
                $subOrdenado[$k]['nombre']=$v['nombre'];
                $subOrdenado[$k]['id'] = $v['id'];
                $division = $v['PRN']/100;
                $subOrdenado[$k]['revisado']= round($division, 2);
                $subOrdenado[$k]['actual']= round($v['PAN'], 2);
                $subOrdenado[$k]['logro']= round($v['logro'], 2);
            //  echo $v[$k]['PRN'];
                
            }//fin tercer for
            

        }//fin if
        
        $dataProvider_tab3 = new CArrayDataProvider($subOrdenado,
                array(
                        'keyField' => 'id',
                        'id' => 'data2',
                        'pagination'=>array(
                                'pageSize'=>15,
                        ),
                )
                    
        );
        //tabs 1
        if(!isset($_GET['SubcriteriosPuntaje']['id_criterio'])&&!isset($_GET['ElementosGestion']['id_subcriterio'])){
                
                $subCriterios = Subcriterios::model()->findAll(array('condition'=>'estado = 1'));
                $bandera = -1;
                
                foreach ($subCriterios as $c){
                
                    $arraySubcriterio[$c->id_criterio][$c->id]['valor']='S.I.';
                    $arraySubcriterio[$c->id_criterio][$c->id]['nombre']=$c->idCriterio->nombre;
                    $arraySubcriterio[$c->id_criterio][$c->id]['factor']=$c->factor;
                    
                    //obtine la suma de puntaje actual por subcriterio
                    $arraySubcriterio[$c->id_criterio][$c->id]['puntajeActualSub']=0;
                
                    $arrayPuntajeActual =ElementosGestion::model()->getPuntajesActualPorSub($c->id);
                    
            
                    $arraySubcriterio[$c->id_criterio][$c->id]['puntajeActualSub']=$arrayPuntajeActual[0]['puntaje_actual'];
                    $cantidadEl = 0;
                    foreach($c->elementosGestions as $el){
                        if($el->estado==1)
                                $cantidadEl++;
                    }
                    
                    $arraySubcriterio[$c->id_criterio][$c->id]['puntaje_maximoSub']=$cantidadEl*5;
                    $arraySubcriterio[$c->id_criterio][$c->id]['logro']=0;
                    $arraySubcriterio[$c->id_criterio][$c->id]['PRN']=0;
                    $arraySubcriterio[$c->id_criterio][$c->id]['PAN']=0;
                    $arrayCalculoPRC[$c->id_criterio]['revisadoN']='S.I.';
                    $arrayCalculoPRC[$c->id_criterio]['maximo']='S.I.';
                    $arrayCalculoPRC[$c->id_criterio]['maximo2']='S.I.';
                    $arrayCalculoPRC[$c->id_criterio]['revisado']='S.I.';
                    $arrayCalculoPRC[$c->id_criterio]['criterio_nom']='S.I.';
                    $arrayCalculoPRC[$c->id_criterio]['porcentaje_final']='S.I.';
                    $arrayCalculoPRC[$c->id_criterio]['porcentaje_finalActual']='S.I.';
                    $arrayCalculoPRC[$c->id_criterio]['actual']='S.I.';
                    $arraySubcriterio[$c->id_criterio][$c->id]['logroActual']=0;
                    
                    if($arraySubcriterio[$c->id_criterio][$c->id]['puntaje_maximoSub']!=0){
                        $arraySubcriterio[$c->id_criterio][$c->id]['logroActual']=($arraySubcriterio[$c->id_criterio][$c->id]['puntajeActualSub']/$arraySubcriterio[$c->id_criterio][$c->id]['puntaje_maximoSub']);
                    }else{
                        $arraySubcriterio[$c->id_criterio][$c->id]['logroActual']=($arraySubcriterio[$c->id_criterio][$c->id]['puntajeActualSub']/1);
                    }
                    $arraySubcriterio[$c->id_criterio][$c->id]['PAN']=$arraySubcriterio[$c->id_criterio][$c->id]['logroActual']*$arraySubcriterio[$c->id_criterio][$c->id]['factor'];

                    
                }//fin primer for
                
                $dataR = Subcriterios::model()->getDatosResumenGeneral(0);
                
                //segundo for 
                for($i=0; $i<count($dataR); $i++){  
                    
                    $arraySubcriterio[$dataR[$i]['id_criterio']][$dataR[$i]['id_subcriterio']]['valor']=$dataR[$i]['puntaje_revisado'];
                    if($arraySubcriterio[$dataR[$i]['id_criterio']][$dataR[$i]['id_subcriterio']]['puntaje_maximoSub'] != 0){
                        $arraySubcriterio[$dataR[$i]['id_criterio']][$dataR[$i]['id_subcriterio']]['logro']=($dataR[$i]['puntaje_revisado']/$arraySubcriterio[$dataR[$i]['id_criterio']][$dataR[$i]['id_subcriterio']]['puntaje_maximoSub']);

                    }else{
                        $arraySubcriterio[$dataR[$i]['id_criterio']][$dataR[$i]['id_subcriterio']]['logro']=($dataR[$i]['puntaje_revisado']/1);
                    }       
                    $arraySubcriterio[$dataR[$i]['id_criterio']][$dataR[$i]['id_subcriterio']]['PRN']=$arraySubcriterio[$dataR[$i]['id_criterio']][$dataR[$i]['id_subcriterio']]['logro']*$dataR[$i]['factor'];
                
                }//fin segundo for
            
            foreach ($arraySubcriterio as $k=>$v){
                $porcentajeFinal = 0.0;
                $porcentajeFinalActual = 0.0;
                foreach($v as $key=>$value){
                    $arrayCalculoPRC[$k]['revisadoN']+=$value['PRN'];
                    $arrayCalculoPRC[$k]['revisado']+=$value['valor'];
                    $arrayCalculoPRC[$k]['maximo']+=$value['puntaje_maximoSub'];
                    $arrayCalculoPRC[$k]['maximo2']+=$value['factor'];
                    $arrayCalculoPRC[$k]['actual']+=$value['PAN'];
                }//fin for interno
                
                if($arrayCalculoPRC[$k]['maximo'] != 0){                    
                    $porcentajeFinalActual = ($arrayCalculoPRC[$k]['actual']/$arrayCalculoPRC[$k]['maximo'])*100;
                }else{                    
                    $porcentajeFinalActual = ($arrayCalculoPRC[$k]['actual']/1)*100;
                }
                                
                if($arrayCalculoPRC[$k]['maximo2'] != 0){
                    $porcentajeFinal = ($arrayCalculoPRC[$k]['revisadoN']/$arrayCalculoPRC[$k]['maximo2'])*100;//($arrayCalculoPRC[$k]['revisado']/$arrayCalculoPRC[$k]['maximo'])*100;
                }
    
                $arrayCalculoPRC[$k]['porcentaje_final']=(isset($porcentajeFinal))?$porcentajeFinal:0;
                $arrayCalculoPRC[$k]['porcentaje_finalActual']=(isset($porcentajeFinalActual))?$porcentajeFinalActual:0;
                $arrayCalculoPRC[$k]['criterio_nom']=$value['nombre'];
            }//fin tercer for

        }
        
        
        //Creando Gráfico RADAR
        $resultado=array();        
        $resultado['chart']=array();
        $resultado['chart']['caption']="Resultado Gestión Global";
        $resultado['chart']['xAxisName']="";
        $resultado['chart']['yAxisName']="";
        $resultado['chart']['numberSuffix']="%";
        $resultado['chart']['yAxisMaxValue']="100";
        $resultado['chart']['yAxisMinValue']="0";     
        $resultado['chart']['canvasborderalpha']="0";     

        $resultado['categories']=array();
        $resultado['categories']['category']=array();
        $resultado['dataset']=array();
        $resultado['dataset'][0]['seriesname']='';
        $resultado['dataset'][0]['data']=array();
        if(isset($arrayCalculoPRC)){
            $i=0;
            foreach($arrayCalculoPRC as $k=>$v){
                $resultado['categories']['category'][$i]['label']=$v['criterio_nom'];
                $resultado['dataset'][0]['data'][$i]['value']=round($v['porcentaje_final'],1);
                //$resultado['data'][$i]['label']=$v['criterio_nom'];
                //$resultado['data'][$i]['value']=$v['porcentaje_final'];
                $i++;
            }
            $resultado=CJSON::encode($resultado);
        }

        $this->render('index', array(
                'arrayCalculoPRC'=>$arrayCalculoPRC,
                'dataProvider'=>$dataProvider,
                'dataProvider_tab3'=>$dataProvider_tab3,
                'dataProvider_tab5'=>$resultado
        ));
        
}

//trae los subcriterios para el combobox
public function actionObtenerSubcriterios($id){
	
		$subs = Subcriterios::model()->findAll(array('condition'=>'id_criterio = '.$id.' AND estado = 1') );
		header("Content-type: application/json");
		echo CJSON::encode($subs);
	
	
}

public function actionReportesTab1(){
    
    //variables
    $actual = '';
    $revisadoN = '';
    $maximo = '';
    $porcentaje_final = '';
    $totalActual=0;
    $totalRevisado = 0;
    $totalMaximo = 0;
    $totalGestion = 0;
    $revisadoN = '';
    $maximo = '';
    $porcentaje_final = '';
    $resumenGeneralTab1 = '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>';
    $arrayCalculoPRC = array();
    
    //primera tabla, primer tab
    
    $arrayCalculoPRC = $this->obtenerDatosTabla1();
    $resumenGeneralTab1 = $resumenGeneralTab1.'<table  border="1" cellpadding="0" cellspacing="0">
    <tr>
        <td colspan="5" bgcolor="#CCCCCC"><center><strong>RESUMEN DE RESULTADO GENERAL</strong></center></td>
    </tr>
    <tr>
        <td rowspan="2" bgcolor="#CCCCCC" width="350"><center><strong>Categoría de Análisis</strong></center></td>
        <td rowspan="2" bgcolor="#CCCCCC"><center><strong>Puntaje Actual</strong></center></td>
        <td colspan="2" bgcolor="#CCCCCC"><center><strong>Niveles de Gestión según Puntaje</strong></center></td>
        <td bgcolor="#CCCCCC"><center><strong>Niveles de Gestión según Porcentaje de Logro</strong></center></td>
    </tr>
    <tr>
        <td bgcolor="#CCCCCC"><center><strong>Puntaje Revisado</strong></center></td>
        <td bgcolor="#CCCCCC"><center><strong>Puntaje Máximo</strong></center></td>
        <td bgcolor="#CCCCCC"><center><strong>% Logro Revisado</strong></center></td>
    </tr> ';
        
    $i=0;
    $cantidadCriterios=0;
    foreach($arrayCalculoPRC as $key=>$value){
            
    $resumenGeneralTab1 = $resumenGeneralTab1.'<tr>
                <td>&nbsp;'.$value['criterio_nom'].'</td>
                <td>&nbsp;';
                
                    
    
                        $actual=round($value['actual'],1);
                        $totalActual = $totalActual+round($value['actual'],1);
                    
                
    $resumenGeneralTab1 = $resumenGeneralTab1.$actual.'</td>
                <td>&nbsp;';
                
                if($value['revisadoN']!='S.I.'){
                    $revisadoN= round($value['revisadoN'],1);
    
                    
                        $totalRevisado = $totalRevisado+round($value['revisadoN'],1);
                }else {
                    $revisadoN=  $value['revisadoN'];
                }
                 
    $resumenGeneralTab1 = $resumenGeneralTab1.$revisadoN.'</td>
                <td>&nbsp;';
                
                if($value['maximo']!='S.I.'){
                    $maximo = round($value['maximo2'],1);
                    
                        $totalMaximo = $totalMaximo+round($value['maximo2'],1);
                        
                }else{
    
                    $maximo =  $value['maximo2'];
                }
                
  $resumenGeneralTab1 = $resumenGeneralTab1.$maximo.'</td>
                <td>&nbsp;';
                
                if($value['porcentaje_final']!='S.I.'){
                    $porcentaje_final = round($value['porcentaje_final'],1);
                    $totalGestion = $totalGestion+round($value['porcentaje_final'],1);
                    $cantidadCriterios++;
                }else{
    
                    $porcentaje_final = $value['porcentaje_final'];
                }
                
 $resumenGeneralTab1 = $resumenGeneralTab1.$porcentaje_final.'</td>
                </tr>';
                
                $i++;
                }//fin for
            
            if($cantidadCriterios>0){
                $totalGestion=round($totalGestion/$cantidadCriterios,1).'%'; 
            }else{
                $totalGestion='0%';
            }
            
                
$resumenGeneralTab1 = $resumenGeneralTab1.'
          <tr >
            <td bgcolor="#CCCCCC"><center><strong>Puntaje Final</strong></center></td>
            <td>&nbsp;'.$totalActual.'</td>
            <td>&nbsp;'.$totalRevisado.'</td>
            <td>&nbsp;'.$totalMaximo.'</td>
            <td>&nbsp;'.$totalGestion.'</td>
          </tr>
        </table>';

    //imprime pdf   
    if(isset($_GET['pdf'])){
        $mPDF1 = Yii::app()->ePdf->mpdf('','A4-L');
        $mPDF1->WriteHTML($resumenGeneralTab1);
        $mPDF1->Output('ReporteAutoEvaluacion.pdf','D');
    }
    //imprime el word
    if(isset($_GET['doc'])){
                    
        Yii::app()->request->sendFile('ReporteAutoEvaluacion.doc',$resumenGeneralTab1);     
    }

    
}

public function actionReporteTab3(){
	
	$revisado = '';
	$actual = '';
	$tabla ='<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>';
	//iniciando tabla
	$tabla = $tabla.'<table border="1" cellpadding="0" cellspacing="0">
  								<tr>
									<td bgcolor="#CCCCCC"><center><strong>Criterio</strong></center></td>
									<td bgcolor="#CCCCCC"><center><strong>Elemento de Gestión</strong></center></td>
									<td bgcolor="#CCCCCC"><center><strong>Puntaje Revisado</strong></center></td>
									<td bgcolor="#CCCCCC"><center><strong>Puntaje Actual</strong></center></td>
  								</tr>';
	
	//trayendo todos los subcriterios
	$subriterios = Subcriterios::model()->findAll(array('condition'=>'estado = 1'));
	$datos = array();
	
	//recorriendo los subcriterios
	foreach ($subriterios as $s){
		
		//trayendo los elementos de gestion
		$datos = ElementosGestion::model()->findAll(array('condition'=>'estado = 1 AND id_subcriterio='.$s->id));
		foreach ($datos as $j){
			
			$tabla = $tabla.'<tr><td>'.$s->idCriterio.'</td>
							 <td>'.$j['nombre'].'</td>';
			
			$revisado = LaElemGestion::model()->puntajeRevisadoPorElemento($j['id'], -1);
			
			$tabla = $tabla.'<td>'.$revisado.'</td>';
			$actual = ElementosGestionResponsable::model()->getPuntajeActual($j['id'], -1);
			$tabla = $tabla.'<td>'.$actual.'</td></tr>';
			
		}
	}
	
	$tabla = $tabla.'</table>';
	
	if(isset($_GET['pdf'])){
		$mPDF1 = Yii::app()->ePdf->mpdf('','A4-L');
		$mPDF1->WriteHTML($tabla);
		$mPDF1->Output('ReporteAutoEvaluacionEG.pdf','D');
	}
	//imprime el word
	if(isset($_GET['doc'])){
			
		Yii::app()->request->sendFile('ReporteAutoEvaluacionEG.doc',$tabla);
	}
	
	
}//fin funcion

public function actionReporteTab2(){
	$tablaTab2='<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>';
	$arayTab2= array();
	$arayTab2 = $this->obtenerDatosPorCriterio();
	
	$tablaTab2 = $tablaTab2.'<table border="1" cellpadding="0" cellspacing="0">
  								<tr>
									<td bgcolor="#CCCCCC"><center><strong>Criterio</strong></center></td>
									<td bgcolor="#CCCCCC"><center><strong>Sub Criterio</strong></center></td>
	    							<td bgcolor="#CCCCCC"><center><strong>%  Logro</strong></center></td>
	    							<td bgcolor="#CCCCCC"><center><strong>Puntaje Sub Criterio</strong></center></td>
	    							<td bgcolor="#CCCCCC"><center><strong>Puntaje Actual</strong></center></td>
  								</tr>';
	$sumaPuntajeActual=0;
	foreach ($arayTab2 as $s){
		if(isset($s['actual'])){
		    if(is_numeric($s['actual']))
		          $sumaPuntajeActual+=$s['actual'];
		}
		$tablaTab2 = $tablaTab2.'
  								<tr>
									<td>&nbsp;'.$s['criterio'].'</td>
								    <td>&nbsp;'.$s['nombre'].'</td>
								    <td>&nbsp;'.$s['logro'].'</td>
								    <td>&nbsp;'.$s['revisado'].'</td>
								    <td>&nbsp;'.$s['actual'].'</td>
								  </tr>
								';
	}//fin for
	$tablaTab2 = $tablaTab2.'<tr><td bgcolor="#CCCCCC" colspan="2"><strong><center>PUNTAJE TOTAL</center></strong></td><td bgcolor="#CCCCCC">&nbsp;</td><td bgcolor="#CCCCCC">&nbsp;</td><td bgcolor="#CCCCCC">'.$sumaPuntajeActual.'</td></tr>';
	//$sumaPuntajeActual
	$tablaTab2 = $tablaTab2.'</table>';
	//imprime pdf
	if(isset($_GET['pdf'])){
		$mPDF1 = Yii::app()->ePdf->mpdf('','A4-L');
		$mPDF1->WriteHTML($tablaTab2);
		$mPDF1->Output('ReporteAutoEvaluacionCriterio.pdf','D');
	}
	//imprime el word
	if(isset($_GET['doc'])){
			
		Yii::app()->request->sendFile('ReporteAutoEvaluacionCriterio.doc',$tablaTab2);
	}
	
	
}

public function obtenerDatosPorCriterio(){
	
	//	$id_criterioS = $_GET['SubcriteriosPuntaje']['id_criterio'];
	$arrayPuntajeActualF = array();
	$arrayCalculoPRCF = array();
	$dataRF = array();
	$criterios = Criterios::model()->findAll(array('condition'=>'estado = 1'));
	
	foreach ($criterios as $c){
		//buscando su criterio por id de criterio
		$subCriteriosFiltro = Subcriterios::model()->findAll(array('condition'=>'estado = 1 AND id_criterio='.$c->id));
	
		foreach ($subCriteriosFiltro as $s){
		
			$arraySubcriterioF[$s->id]['id']=$s->id;
			$arraySubcriterioF[$s->id]['criterio']=$c->nombre;
			$arraySubcriterioF[$s->id]['valor']='S.I.';
			$arraySubcriterioF[$s->id]['nombre']=$s->nombre;
			$arraySubcriterioF[$s->id]['factor']=$s->factor;
		
			//obtine la suma de puntaje actual por subcriterio
			$arraySubcriterioF[$s->id]['puntajeActualSub']=0;
		
			$arrayPuntajeActualF =ElementosGestion::model()->getPuntajesActualPorSub($s->id);
		
		
			$arraySubcriterioF[$s->id]['puntajeActualSub']=$arrayPuntajeActualF[0]['puntaje_actual'];
			$cantidadEl = 0;
			foreach($s->elementosGestions as $el){
				if($el->estado==1)
					$cantidadEl++;
			}
		
			$arraySubcriterioF[$s->id]['puntaje_maximoSub']=$cantidadEl*5;
			$arraySubcriterioF[$s->id]['logro']=0;
			$arraySubcriterioF[$s->id]['PRN']=0;
			$arraySubcriterioF[$s->id]['PAN']=0;
			$arrayCalculoPRCF['revisadoN']='S.I.';
			$arrayCalculoPRCF['maximo']='S.I.';
			$arrayCalculoPRCF['maximo2']='S.I.';
			$arrayCalculoPRCF['revisado']='S.I.';
			$arrayCalculoPRCF['criterio_nom']='S.I.';
			$arrayCalculoPRCF['porcentaje_final']='S.I.';
			$arrayCalculoPRCF['porcentaje_finalActual']='S.I.';
			$arrayCalculoPRCF['actual']='S.I.';
			$arraySubcriterioF[$s->id]['logroActual']=0;
		
			if($arraySubcriterioF[$s->id]['puntaje_maximoSub']!=0){
		
				$arraySubcriterioF[$s->id]['logroActual']=($arraySubcriterioF[$s->id]['puntajeActualSub']/$arraySubcriterioF[$s->id]['puntaje_maximoSub']);
		
			}else{
				$arraySubcriterioF[$s->id]['logroActual']=($arraySubcriterioF[$s->id]['puntajeActualSub']/1);
			}
			$arraySubcriterioF[$s->id]['PAN']=$arraySubcriterioF[$s->id]['logroActual']*$arraySubcriterioF[$s->id]['factor'];
			$dataRF = Subcriterios::model()->getDatosResumenGeneral($s->id);
			for($i=0; $i<count($dataRF); $i++){
		
				$arraySubcriterioF[$dataRF[$i]['id_subcriterio']]['valor']=$dataRF[$i]['puntaje_revisado'];
				if($arraySubcriterioF[$dataRF[$i]['id_subcriterio']]['puntaje_maximoSub'] != 0){
					$arraySubcriterioF[$dataRF[$i]['id_subcriterio']]['logro']=($dataRF[$i]['puntaje_revisado']/$arraySubcriterioF[$dataRF[$i]['id_subcriterio']]['puntaje_maximoSub'])*100;
				}else{
					$arraySubcriterioF[$dataRF[$i]['id_subcriterio']]['logro']=($dataRF[$i]['puntaje_revisado']/1)*100;
				}
				$arraySubcriterioF[$dataRF[$i]['id_subcriterio']]['PRN']=$arraySubcriterioF[$dataRF[$i]['id_subcriterio']]['logro']*$dataRF[$i]['factor'];
		
			}//fin segundo for
				
		}//fin primer for
		
		//segundo for
		
		$division = 0;
		foreach ($arraySubcriterioF as $k=>$v){
			//echo $v['PRN'];
			$subOrdenado[$k]['nombre']=$v['nombre'];
			$subOrdenado[$k]['id'] = $v['id'];
			$division = $v['PRN']/100;
			$subOrdenado[$k]['revisado']= round($division, 2);
			$subOrdenado[$k]['actual']= round($v['PAN'], 2);
			$subOrdenado[$k]['logro']= round($v['logro'], 2);
			$subOrdenado[$k]['criterio']= $v['criterio'];
			//	echo $v[$k]['PRN'];
				
		}//fin tercer for
		
	}//fin foreach principal
	
	
	return $subOrdenado; 
	
	
}//fin funcion

//obteniedo datos del primer tab para el reporte
public function obtenerDatosTabla1(){
	
	$arraySubcriterio = array();
	$subCriterios = array();
	$arrayPuntajeActual = array();
	$dataR = array();
	$arrayCalculoPRC = array();
	$subCriterios = Subcriterios::model()->findAll(array('condition'=>'estado = 1'));
	$bandera = -1;

	
	//obteniendo datos 
	foreach ($subCriterios as $c){
	
		$arraySubcriterio[$c->id_criterio][$c->id]['valor']='S.I.';
		$arraySubcriterio[$c->id_criterio][$c->id]['nombre']=$c->idCriterio->nombre;
		$arraySubcriterio[$c->id_criterio][$c->id]['factor']=$c->factor;
			
		//obtine la suma de puntaje actual por subcriterio
		$arraySubcriterio[$c->id_criterio][$c->id]['puntajeActualSub']=0;
	
		$arrayPuntajeActual =ElementosGestion::model()->getPuntajesActualPorSub($c->id);
			
			
		$arraySubcriterio[$c->id_criterio][$c->id]['puntajeActualSub']=$arrayPuntajeActual[0]['puntaje_actual'];
		$cantidadEl = 0;
		foreach($c->elementosGestions as $el){
			if($el->estado==1)
				$cantidadEl++;
		}
			
		$arraySubcriterio[$c->id_criterio][$c->id]['puntaje_maximoSub']=$cantidadEl*5;
		$arraySubcriterio[$c->id_criterio][$c->id]['logro']=0;
		$arraySubcriterio[$c->id_criterio][$c->id]['PRN']=0;
		$arraySubcriterio[$c->id_criterio][$c->id]['PAN']=0;
		$arrayCalculoPRC[$c->id_criterio]['revisadoN']='S.I.';
		$arrayCalculoPRC[$c->id_criterio]['maximo']='S.I.';
		$arrayCalculoPRC[$c->id_criterio]['maximo2']='S.I.';
		$arrayCalculoPRC[$c->id_criterio]['revisado']='S.I.';
		$arrayCalculoPRC[$c->id_criterio]['criterio_nom']='S.I.';
		$arrayCalculoPRC[$c->id_criterio]['porcentaje_final']='S.I.';
		$arrayCalculoPRC[$c->id_criterio]['porcentaje_finalActual']='S.I.';
		$arrayCalculoPRC[$c->id_criterio]['actual']='S.I.';
		$arraySubcriterio[$c->id_criterio][$c->id]['logroActual']=0;
			
		if($arraySubcriterio[$c->id_criterio][$c->id]['puntaje_maximoSub']!=0){
			$arraySubcriterio[$c->id_criterio][$c->id]['logroActual']=($arraySubcriterio[$c->id_criterio][$c->id]['puntajeActualSub']/$arraySubcriterio[$c->id_criterio][$c->id]['puntaje_maximoSub']);
		}else{
			$arraySubcriterio[$c->id_criterio][$c->id]['logroActual']=($arraySubcriterio[$c->id_criterio][$c->id]['puntajeActualSub']/1);
		}
		$arraySubcriterio[$c->id_criterio][$c->id]['PAN']=$arraySubcriterio[$c->id_criterio][$c->id]['logroActual']*$arraySubcriterio[$c->id_criterio][$c->id]['factor'];
	
			
	}//fin primer for
	
	$dataR = Subcriterios::model()->getDatosResumenGeneral(0);
	
	//segundo for
	for($i=0; $i<count($dataR); $i++){
			
		$arraySubcriterio[$dataR[$i]['id_criterio']][$dataR[$i]['id_subcriterio']]['valor']=$dataR[$i]['puntaje_revisado'];
		if($arraySubcriterio[$dataR[$i]['id_criterio']][$dataR[$i]['id_subcriterio']]['puntaje_maximoSub'] != 0){
			$arraySubcriterio[$dataR[$i]['id_criterio']][$dataR[$i]['id_subcriterio']]['logro']=($dataR[$i]['puntaje_revisado']/$arraySubcriterio[$dataR[$i]['id_criterio']][$dataR[$i]['id_subcriterio']]['puntaje_maximoSub']);
	
		}else{
			$arraySubcriterio[$dataR[$i]['id_criterio']][$dataR[$i]['id_subcriterio']]['logro']=($dataR[$i]['puntaje_revisado']/1);
		}
		$arraySubcriterio[$dataR[$i]['id_criterio']][$dataR[$i]['id_subcriterio']]['PRN']=$arraySubcriterio[$dataR[$i]['id_criterio']][$dataR[$i]['id_subcriterio']]['logro']*$dataR[$i]['factor'];
	
	}//fin segundo for
		
	foreach ($arraySubcriterio as $k=>$v){
		$porcentajeFinal = 0.0;
		$porcentajeFinalActual = 0.0;
		foreach($v as $key=>$value){
			$arrayCalculoPRC[$k]['revisadoN']+=$value['PRN'];
			$arrayCalculoPRC[$k]['revisado']+=$value['valor'];
			$arrayCalculoPRC[$k]['maximo']+=$value['puntaje_maximoSub'];
			$arrayCalculoPRC[$k]['maximo2']+=$value['factor'];
			$arrayCalculoPRC[$k]['actual']+=$value['PAN'];
		}//fin for interno
	
		if($arrayCalculoPRC[$k]['maximo'] != 0){
			//$porcentajeFinal = ($arrayCalculoPRC[$k]['revisado']/$arrayCalculoPRC[$k]['maximo'])*100;
			$porcentajeFinalActual = ($arrayCalculoPRC[$k]['actual']/$arrayCalculoPRC[$k]['maximo'])*100;
		}else{
			//$porcentajeFinal = ($arrayCalculoPRC[$k]['revisado']/1)*100;
			$porcentajeFinalActual = ($arrayCalculoPRC[$k]['actual']/1)*100;
		}
                
        if($arrayCalculoPRC[$k]['maximo2'] != 0){
            $porcentajeFinal = ($arrayCalculoPRC[$k]['revisadoN']/$arrayCalculoPRC[$k]['maximo2'])*100;//($arrayCalculoPRC[$k]['revisado']/$arrayCalculoPRC[$k]['maximo'])*100;
        }
	
		$arrayCalculoPRC[$k]['porcentaje_final']=(isset($porcentajeFinal))?$porcentajeFinal:0;
		$arrayCalculoPRC[$k]['porcentaje_finalActual']=(isset($porcentajeFinalActual))?$porcentajeFinalActual:0;
		$arrayCalculoPRC[$k]['criterio_nom']=$value['nombre'];
	}//fin tercer for
	
	
	return $arrayCalculoPRC;
	
}//fin funcion


//obtiene los elementos de gestion para el combobox
public function actionObtenerElementos($idSub){
	$elementos = ElementosGestion::model()->findAll(array('condition'=>'id_subcriterio = '.$idSub.' AND estado = 1') );
	header("Content-type: application/json");
	echo CJSON::encode($elementos);
}//fin funcion

//obtiene los datos para la tabla
public function actionObtenerDatosTablaElementos($id){
	
	$arrOrdenado = array();
	$evidenciaUrl= array();
	$datos = Criterios::model()->datosResumenGeneralTablaElementos($id);//trayendo datos sobre criterio por id elemento
	
	$i=0;
	foreach ($datos as $d){
		
		$evidenciaUrl = LaElemGestion::model()->findAll(array('condition'=>'t.puntaje_revisado IS NOT NULL AND id_la IS NULL AND t.id_elem_gestion='.$d->id_eg.' AND t.id_planificacion='.Yii::app()->session['idPlanificaciones'],'order'=>'t.fecha DESC, t.id DESC','select'=>'t.id,t.puntaje_revisado, t.archivo, t.evidencia'));
		
		if(count($evidenciaUrl)!=0){
			//Consultamos los documentos asociados.	
			$modelDocument = LaElemGestionDocumentos::model()->findAll(array('condition'=>'t.la_elem_id='.$evidenciaUrl[0]["id"] .' AND estado = 1'));
			if (isset($modelDocument[0]['nombre'])){
				$cont=0;
				$arrURL = array();
				foreach($modelDocument as $itemsDoc){
					$nombreDoc = $itemsDoc->nombre;
					$arrURL[$cont] = $nombreDoc;
					$cont++;
				}
				$arrOrdenado[$i]['url'] = $arrURL;
			}else{
				$arrOrdenado[$i]['url'] = 'S.I.';
			}
			//	echo '1-';
		//	echo ' ev '.$evidenciaUrl[0]['evidencia'];
			if(isset($evidenciaUrl[0]['evidencia'])){
		//		echo '2-';
				$arrOrdenado[$i]['evidencia'] = $evidenciaUrl[0]['evidencia'];
			}else{
			//	echo '3-';
				$arrOrdenado[$i]['evidencia'] = 'S.I.';
			}
			/*       				
			if(isset($evidenciaUrl[0]['archivo'])){
		//		echo '4-';
				$arrOrdenado[$i]['url'] = $evidenciaUrl[0]['archivo'];
			}else{
			//	echo '5-';
				$arrOrdenado[$i]['url'] = 'S.I.';
			}
			*/
			if(isset($evidenciaUrl[0]['puntaje_revisado'])){
				//		echo '4-';
				$arrOrdenado[$i]['revisado'] = $evidenciaUrl[0]['puntaje_revisado'];
			}else{
				//	echo '5-';
				$arrOrdenado[$i]['revisado'] = 'S.I.';
			}
			
			
		}else{
		//	echo '6-';
			$arrOrdenado[$i]['evidencia'] ='S.I.';
			$arrOrdenado[$i]['url'] ='S.I.';
			$arrOrdenado[$i]['revisado'] ='S.I.';
		}
		
		$arrOrdenado[$i]['sub'] = $d->sub;
		$arrOrdenado[$i]['nombre'] = $d->nombre;
		$arrOrdenado[$i]['descripcion'] = $d->descripcion;
		$arrOrdenado[$i]['elemento'] = $d->elemento;
		$i++;
	}
	
/*	$elementos = ElementosGestion::model()->findAll(array('condition'=>'id_subcriterio = '.$idSub.' AND estado = 1') );
	*/
	header("Content-type: application/json");
	echo CJSON::encode($arrOrdenado);
	
}//fin function
  
//funcion de rodolfo para graficos
public function actionJsonGraficoPorCriterio($id){
        $id=(isset($id))?$id:0;
        
        $sql ='SELECT SUM( AA.puntaje_revisado ) AS puntaje_revisado, AA.factor, AA.id_subcriterio, AA.id_criterio,AA.nombre,AA.nombreCriterio
        FROM (
        SELECT a.fecha, a.id_elem_gestion, a.puntaje_revisado, b.id_subcriterio,d.nombre as nombreCriterio,c.nombre, c.factor, c.id_criterio
        FROM (
                SELECT ax.* FROM(
                SELECT la.id_elem_gestion, la.puntaje_revisado,la.fecha
                FROM(SELECT MAX(a.fecha) as fecha,a.id_elem_gestion
                        FROM la_elem_gestion a
                        WHERE a.puntaje_revisado IS NOT NULL
                        AND a.fecha IS NOT NULL AND a.id_la IS NULL
                        AND a.estado =1
                        AND a.id_planificacion ='.Yii::app()->session['idPlanificaciones'].'
                        GROUP BY a.id_elem_gestion
                ) latmp
                join la_elem_gestion la on latmp.id_elem_gestion=la.id_elem_gestion AND latmp.fecha=la.fecha and la.puntaje_revisado IS NOT NULL
                                AND la.fecha IS NOT NULL
                                AND la.id_la IS NULL
                                AND la.estado = 1
                                AND la.id_planificacion = '.Yii::app()->session['idPlanificaciones'].'                
                order by la.id_elem_gestion,la.id DESC) ax
                group by ax.id_elem_gestion
        ) a
        INNER JOIN elementos_gestion b
        on a.id_elem_gestion=b.id AND b.estado=1
        INNER JOIN subcriterios c
        on b.id_subcriterio=c.id
        INNER JOIN criterios d
            on c.id_criterio=d.id
        where c.id_criterio='.$id.'
        )AA
        group by AA.id_subcriterio, AA.id_criterio';        
        
        $criteriosSub=Yii::app()->db->createCommand($sql)->queryAll();
        
        $resultado=array();        
        $resultado['chart']=array();
        $resultado['chart']['caption']="";
        $resultado['chart']['xAxisName']="";
        $resultado['chart']['yAxisName']="";
         $resultado['chart']['numberSuffix']="%";
         $resultado['chart']['numDivLines']="9";
         $resultado['chart']['yAxisMaxValue']="100";
         $resultado['chart']['yAxisMinValue']="0";
        
        $resultado['data']=array();
        
        $arraySubcriterio=array();

        $subCriterios = Subcriterios::model()->findAll(array('condition'=>'estado = 1'));
        foreach ($subCriterios as $c){
                $cantidadEl = 0;
                foreach($c->elementosGestions as $el){
                    if($el->estado==1)
                         $cantidadEl++;
                }                    
                $arraySubcriterio[$c->id_criterio][$c->id]['puntaje_maximoSub']=$cantidadEl*5;
       }
        
        for($i=0; $i<count($criteriosSub); $i++){
                $resultado['data'][$i]['label']=$criteriosSub[$i]['nombre'];
                $puntajeMAx=$arraySubcriterio[$criteriosSub[$i]['id_criterio']][$criteriosSub[$i]['id_subcriterio']]['puntaje_maximoSub'];
                $puntajeMAx=(isset($puntajeMAx))?$puntajeMAx:1;
                $resultado['data'][$i]['value']=round(($criteriosSub[$i]['puntaje_revisado']/$puntajeMAx)*100,1);
                $resultado['chart']['caption']=$criteriosSub[$i]['nombreCriterio'];
        }//fin segundo for
        
        header("Content-type: application/json");   
        echo CJSON::encode($resultado);
        
    }


    public function actionJsonGraficoBarraPorIndicadoresFH(){
               
        $listadoMeses=array();
        $listadoMeses[2]=array(3=>'MARZO',6=>'JUNIO',9=>'SEPTIEMBRE',12=>'DICIEMBRE');//TRIMESTRAL
        $listadoMeses[3]=array(1=>'ENERO',2=>'FEBRERO',3=>'MARZO',4=>'ABRIL',5=>'MAYO',6=>'JUNIO',7=>'JULIO',8=>'AGOSTO',9=>'SEPTIEMBRE',10=>'OCTUBRE',11=>'NOVIEMBRE',12=>'DICIEMBRE');//SEMESTRAL
        
        //Volcando valores de los meses que necesitamos consultar de acuerdo al mes actual
        $tmpArray=array();
        foreach($listadoMeses[2] as $k=>$v){
            if($k<=date("n"))
                $tmpArray[]=$v;
            else
                break;            
        }
        $listadoMeses[2]=$tmpArray;
        
        $tmpArray=array();
        foreach($listadoMeses[3] as $k=>$v){
            if($k<=date("n"))
                $tmpArray[]=$v;
            else
                break;            
        }
        $listadoMeses[3]=$tmpArray;
        //FIN VOLCADO
        
        $indicadoresPorHito=Indicadores::model()->findAll(array('condition'=>'ii.id_instrumento=5 AND ii.estado=1 AND t.estado=1 AND hi.estado=1 AND pp.descripcion=YEAR(NOW())','join'=>'inner join indicadores_instrumentos  ii on ii.id_indicador=t.id inner join hitos_indicadores hi on hi.id_indicador=t.id INNER JOIN productos_especificos pes on t.producto_especifico_id=pes.id and pes.estado=1
                INNER JOIN subproductos sp on pes.subproducto_id=sp.id and sp.estado=1
                INNER JOIN productos_estrategicos pe on sp.producto_estrategico_id=pe.id
                INNER JOIN objetivos_productos op ON pe.id = op.producto_estrategico_id
                INNER JOIN objetivos_estrategicos oe ON op.objetivo_estrategico_id = oe.id
                INNER JOIN desafios_objetivos do2 ON  oe.id = do2.objetivo_estrategico_id
                INNER JOIN desafios_estrategicos de ON do2.desafio_estrategico_id = de.id
                INNER JOIN planificaciones pl ON de.planificacion_id = pl.id 
                INNER JOIN periodos_procesos pp ON pl.periodo_proceso_id = pp.id'));
        $indicadores=Indicadores::model()->findAll(array('condition'=>'ii.id_instrumento=5 AND ii.estado=1 AND t.estado=1 AND pp.descripcion=YEAR(NOW())','join'=>'inner join indicadores_instrumentos ii on ii.id_indicador=t.id INNER JOIN productos_especificos pes on t.producto_especifico_id=pes.id and pes.estado=1
                INNER JOIN subproductos sp on pes.subproducto_id=sp.id and sp.estado=1
                INNER JOIN productos_estrategicos pe on sp.producto_estrategico_id=pe.id
                INNER JOIN objetivos_productos op ON pe.id = op.producto_estrategico_id
                INNER JOIN objetivos_estrategicos oe ON op.objetivo_estrategico_id = oe.id
                INNER JOIN desafios_objetivos do2 ON  oe.id = do2.objetivo_estrategico_id
                INNER JOIN desafios_estrategicos de ON do2.desafio_estrategico_id = de.id
                INNER JOIN planificaciones pl ON de.planificacion_id = pl.id 
                INNER JOIN periodos_procesos pp ON pl.periodo_proceso_id = pp.id'));
        
        $valoresIndicadoresFH=array();
        foreach($indicadores as $value){
            $valoresIndicadoresFH[$value->id]['nombre']=$value->nombre;
            $valoresIndicadoresFH[$value->id]['porcentaje']=0;
            //$valoresIndicadoresFH[$value->id]['frecuencia']=$value->frecuencia_control_id;
        }
        
        $resultado=array();        
        $resultado['chart']=array();
        $resultado['chart']['caption']="Indicadores Formulario H";
        $resultado['chart']['xAxisName']="";
        $resultado['chart']['yAxisName']="";
        $resultado['chart']['numberSuffix']="%";
        $resultado['chart']['numDivLines']="9";
        $resultado['chart']['yAxisMaxValue']="100";
        $resultado['chart']['tooltipbgcolor']="E7EFF6";
        $resultado['chart']['plotborderdashed']="0";
        $resultado['chart']['plotborderdashlen']="2";
        $resultado['chart']['plotborderdashgap']="1";
        $resultado['chart']['useroundedges']="1";
        $resultado['chart']['showborder']="0";
        $resultado['chart']['bgAlpha']="0";
        $resultado['chart']['showLabels']="0";
        

        
        $resultado['data']=array();
        

        
        $valoresTemporalesFH=array();
        foreach($indicadoresPorHito as $value){
            foreach($value->hitosIndicadores as $v){
                /*if(strtoupper(end($listadoMeses[$value->frecuencia_control_id]))==strtoupper($v->mes)){
                    if(isset($v->meta_reportada))
                        $valoresIndicadoresFH[$value->id]['porcentaje']=$v->meta_reportada;
                } */
                if(in_array(strtoupper($v->mes),$listadoMeses[$value->frecuencia_control_id])){
                    if(isset($v->meta_reportada)){
                        if($v->meta_reportada!="" && $v->meta_reportada!=null){
                            $key = array_search(strtoupper($v->mes), $listadoMeses[$value->frecuencia_control_id]);
                            $valoresTemporalesFH[$value->id][$key]=$v->meta_reportada;
                        }
                            
                    }
                         
                }
            }            
        }  
        
        foreach($indicadoresPorHito as $value){
            if(isset($valoresTemporalesFH[$value->id])){
                    $valoresIndicadoresFH[$value->id]['porcentaje']=end($valoresTemporalesFH[$value->id]);
            }
        }        
        
        
        //Agregando valores finales al Array de fusionCharts
        $i=0;
        foreach($valoresIndicadoresFH as $key=>$value){
            if($value['porcentaje']!=0){
                $resultado['data'][$i]['label']=$value['nombre'];
                $resultado['data'][$i]['value']=$value['porcentaje'];
                $i++;
            }            
        }
        if(count($resultado['data'])==0){
            $resultado['data'][0]['label']='';
            $resultado['data'][0]['value']=0;
        }

        header("Content-type: application/json");   
        echo CJSON::encode($resultado);      
    }





    public function actionJsonGraficoRadarPorCriteriosSegunPeriodos() {
        $arraySubcriterio=array();
        $arrayCalculoPRC = array();
        $arrayPuntajeActual = array();
        $periodos=array(date("Y"),date("Y")-1,date("Y")-2);
        $planificacionAnterior=0;
        $planificacionActual=0;
        $nombrePlanificacionAnterior='';
        $nombrePlanificacionActual='';
        
        
        $planificacion1=Planificaciones::model()->findAll(array('join'=>'join periodos_procesos pp on t.periodo_proceso_id=pp.id','condition'=>'t.estado=1 AND pp.descripcion="'.$periodos[0].'"'));
        if(isset($planificacion1[0])){
            $planificacionActual=$planificacion1[0]->id;
            $nombrePlanificacionActual=$planificacion1[0]->periodoProceso;
            $planificacion1=Planificaciones::model()->findAll(array('join'=>'join periodos_procesos pp on t.periodo_proceso_id=pp.id','condition'=>'t.estado=1 AND pp.descripcion="'.$periodos[1].'"'));
            if(isset($planificacion1[0])){
                $planificacionAnterior=$planificacion1[0]->id;
                $nombrePlanificacionAnterior=$planificacion1[0]->periodoProceso;
            }
        }else{
            $planificacion1=Planificaciones::model()->findAll(array('join'=>'join periodos_procesos pp on t.periodo_proceso_id=pp.id','condition'=>'t.estado=1 AND pp.descripcion="'.$periodos[1].'"'));
            if(isset($planificacion1[0])){
                $planificacionActual=$planificacion1[0]->id;
                $nombrePlanificacionActual=$planificacion1[0]->periodoProceso;
            }
            $planificacion1=Planificaciones::model()->findAll(array('join'=>'join periodos_procesos pp on t.periodo_proceso_id=pp.id','condition'=>'t.estado=1 AND pp.descripcion="'.$periodos[2].'"'));
            if(isset($planificacion1[0])){
                $planificacionAnterior=$planificacion1[0]->id;
                $nombrePlanificacionAnterior=$planificacion1[0]->periodoProceso;
            }
        }
        
        $subCriterios = Subcriterios::model()->findAll(array('condition'=>'estado = 1'));
        
        foreach ($subCriterios as $c){                    
                    $arraySubcriterio[$c->id_criterio][$c->id][$planificacionActual]['nombre']=$c->idCriterio->nombre;
                    $arraySubcriterio[$c->id_criterio][$c->id][$planificacionAnterior]['nombre']=$c->idCriterio->nombre;
                    $arraySubcriterio[$c->id_criterio][$c->id][$planificacionActual]['factor']=$c->factor;
                    $arraySubcriterio[$c->id_criterio][$c->id][$planificacionAnterior]['factor']=$c->factor;
                    
                    //obtine la suma de puntaje actual por subcriterio
                   // $arraySubcriterio[$c->id_criterio][$c->id]['puntajeActualSub']=0;
                    
                    $criteria = new CDbCriteria;
                    $criteria->select='t.id, SUM(er.puntaje_actual) AS puntaje_actual';
                    $criteria->join = 'INNER JOIN elementos_gestion_responsable er ON er.elemento_gestion_id = t.id';
                    $criteria->condition = 't.estado = 1 AND er.estado=1 AND er.estado=1 AND  t.id_subcriterio = '.$c->id.' AND er.planificacion_id='.$planificacionActual;
                    $puntajes = ElementosGestion::model()->findAll($criteria);                    
                    $arrayPuntajeActual =$puntajes;                   
                    $arraySubcriterio[$c->id_criterio][$c->id][$planificacionActual]['puntajeActualSub']=(isset($arrayPuntajeActual[0]))?$arrayPuntajeActual[0]['puntaje_actual']:0;
                    
                    $criteria = new CDbCriteria;
                    $criteria->select='t.id, SUM(er.puntaje_actual) AS puntaje_actual';
                    $criteria->join = 'INNER JOIN elementos_gestion_responsable er ON er.elemento_gestion_id = t.id';
                    $criteria->condition = 't.estado = 1 AND er.estado=1 AND er.estado=1 AND  t.id_subcriterio = '.$c->id.' AND er.planificacion_id='.$planificacionAnterior;
                    $puntajes = ElementosGestion::model()->findAll($criteria); 
                    $arrayPuntajeActual =$puntajes; 
                    $arraySubcriterio[$c->id_criterio][$c->id][$planificacionAnterior]['puntajeActualSub']=(isset($arrayPuntajeActual[0]))?$arrayPuntajeActual[0]['puntaje_actual']:0;
                    
                    $cantidadEl = 0;
                    foreach($c->elementosGestions as $el){
                        if($el->estado==1)
                                $cantidadEl++;
                    }
                    $arraySubcriterio[$c->id_criterio][$c->id][$planificacionActual]['valor']=0;
                    $arraySubcriterio[$c->id_criterio][$c->id][$planificacionAnterior]['valor']=0;
                    $arraySubcriterio[$c->id_criterio][$c->id][$planificacionActual]['puntaje_maximoSub']=$cantidadEl*5;
                    $arraySubcriterio[$c->id_criterio][$c->id][$planificacionAnterior]['puntaje_maximoSub']=$cantidadEl*5;
                    $arraySubcriterio[$c->id_criterio][$c->id][$planificacionActual]['logro']=0;
                    $arraySubcriterio[$c->id_criterio][$c->id][$planificacionAnterior]['logro']=0;
                    $arraySubcriterio[$c->id_criterio][$c->id][$planificacionActual]['PRN']=0;
                    $arraySubcriterio[$c->id_criterio][$c->id][$planificacionAnterior]['PRN']=0;
                    $arrayCalculoPRC[$c->id_criterio][$planificacionActual]['revisado']=0;
                    $arrayCalculoPRC[$c->id_criterio][$planificacionAnterior]['revisado']=0;
                    $arrayCalculoPRC[$c->id_criterio][$planificacionActual]['revisadoN']=0;
                    $arrayCalculoPRC[$c->id_criterio][$planificacionAnterior]['revisadoN']=0;                    
                    $arrayCalculoPRC[$c->id_criterio][$planificacionActual]['maximo']=0;
                    $arrayCalculoPRC[$c->id_criterio][$planificacionAnterior]['maximo']=0;
                    $arrayCalculoPRC[$c->id_criterio][$planificacionActual]['maximo2']=0;
                    $arrayCalculoPRC[$c->id_criterio][$planificacionAnterior]['maximo2']=0;
                    $arrayCalculoPRC[$c->id_criterio][$planificacionActual]['actual']=0;
                    $arrayCalculoPRC[$c->id_criterio][$planificacionAnterior]['actual']=0;
                    //$arraySubcriterio[$c->id_criterio][$c->id]['PAN']=0;
                    //$arraySubcriterio[$c->id_criterio]['logroActual']=0;
                    
                    
                    $arraySubcriterio[$c->id_criterio][$c->id][$planificacionActual]['logroActual']=(isset($cantidadEl))?($arraySubcriterio[$c->id_criterio][$c->id][$planificacionActual]['puntajeActualSub']/$arraySubcriterio[$c->id_criterio][$c->id][$planificacionActual]['puntaje_maximoSub']):0;
                    $arraySubcriterio[$c->id_criterio][$c->id][$planificacionAnterior]['logroActual']=(isset($cantidadEl))?($arraySubcriterio[$c->id_criterio][$c->id][$planificacionAnterior]['puntajeActualSub']/$arraySubcriterio[$c->id_criterio][$c->id][$planificacionAnterior]['puntaje_maximoSub']):0;
                    
                    $arraySubcriterio[$c->id_criterio][$c->id][$planificacionActual]['PAN']=$arraySubcriterio[$c->id_criterio][$c->id][$planificacionActual]['logroActual']*$arraySubcriterio[$c->id_criterio][$c->id][$planificacionActual]['factor'];
                    $arraySubcriterio[$c->id_criterio][$c->id][$planificacionAnterior]['PAN']=$arraySubcriterio[$c->id_criterio][$c->id][$planificacionAnterior]['logroActual']*$arraySubcriterio[$c->id_criterio][$c->id][$planificacionAnterior]['factor'];
                    
                    
                }//fin primer for
        
        
                $sql ='SELECT SUM( AA.puntaje_revisado ) AS puntaje_revisado, AA.factor, AA.id_subcriterio, AA.id_criterio,AA.nombre,AA.nombreCriterio,AA.id_planificacion
                    FROM (
                    SELECT a.fecha,a.id_planificacion, a.id_elem_gestion, a.puntaje_revisado, b.id_subcriterio,d.nombre as nombreCriterio,c.nombre, c.factor, c.id_criterio
                    FROM (
                    SELECT * FROM (
                                SELECT la.id_elem_gestion, la.puntaje_revisado,la.fecha,latmp.id_planificacion
                                FROM(
                                    SELECT MAX(a.fecha) as fecha,a.id_elem_gestion,a.id_planificacion
                                    FROM la_elem_gestion a
                                    WHERE a.puntaje_revisado IS NOT NULL
                                    AND a.fecha IS NOT NULL AND a.id_la IS NULL
                                    AND a.estado =1
                                    AND (a.id_planificacion ='.$planificacionActual.' OR a.id_planificacion='.$planificacionAnterior.')
                                    GROUP BY a.id_elem_gestion,a.id_planificacion                    
                                ) latmp
                                join la_elem_gestion la on latmp.id_elem_gestion=la.id_elem_gestion AND latmp.fecha=la.fecha and la.puntaje_revisado IS NOT NULL
                                AND la.fecha IS NOT NULL
                                AND la.id_la IS NULL
                                AND la.estado = 1
                                AND (la.id_planificacion = '.$planificacionActual.' OR la.id_planificacion='.$planificacionAnterior.')
                                
                                order by la.id_elem_gestion,la.id DESC
                        )ax
                        group by ax.id_elem_gestion,ax.id_planificacion
                    ) a
                    INNER JOIN elementos_gestion b
                    on a.id_elem_gestion=b.id AND b.estado=1
                    INNER JOIN subcriterios c
                    on b.id_subcriterio=c.id
                    INNER JOIN criterios d
                        on c.id_criterio=d.id
                    )AA
                    group by AA.id_subcriterio, AA.id_criterio,AA.id_planificacion';        
        
                $dataR=Yii::app()->db->createCommand($sql)->queryAll();
                
                //segundo for 
                for($i=0; $i<count($dataR); $i++){                    
                    $arraySubcriterio[$dataR[$i]['id_criterio']][$dataR[$i]['id_subcriterio']][$dataR[$i]['id_planificacion']]['valor']=$dataR[$i]['puntaje_revisado'];
                    $arraySubcriterio[$dataR[$i]['id_criterio']][$dataR[$i]['id_subcriterio']][$dataR[$i]['id_planificacion']]['logro']=(isset($arraySubcriterio[$dataR[$i]['id_criterio']][$dataR[$i]['id_subcriterio']][$dataR[$i]['id_planificacion']]['puntaje_maximoSub']))?($dataR[$i]['puntaje_revisado']/$arraySubcriterio[$dataR[$i]['id_criterio']][$dataR[$i]['id_subcriterio']][$dataR[$i]['id_planificacion']]['puntaje_maximoSub']):0;                           
                    $arraySubcriterio[$dataR[$i]['id_criterio']][$dataR[$i]['id_subcriterio']][$dataR[$i]['id_planificacion']]['PRN']=$arraySubcriterio[$dataR[$i]['id_criterio']][$dataR[$i]['id_subcriterio']][$dataR[$i]['id_planificacion']]['logro']*$dataR[$i]['factor'];
                }//fin segundo for
            
                foreach ($arraySubcriterio as $k=>$v){
                        $porcentajeFinal = 0.0;
                        $porcentajeFinalActual = 0.0;
                        
                        foreach($v as $key=>$value){                      
                            foreach($value as $ke=>$val){
                                //print_r($arrayCalculoPRC);
                                //Yii::app()->end();                        
                                $arrayCalculoPRC[$k][$ke]['revisadoN']+=$val['PRN'];
                                $arrayCalculoPRC[$k][$ke]['revisado']+=$val['valor'];
                                $arrayCalculoPRC[$k][$ke]['maximo']+=$val['puntaje_maximoSub'];
                                $arrayCalculoPRC[$k][$ke]['maximo2']+=$val['factor'];
                                $arrayCalculoPRC[$k][$ke]['actual']+=$val['PAN'];
                            }
                            
                        }//fin for interno
                        //Yii::app()->end();
                        foreach($v as $key=>$value){
                            $porcentajeFinal = 0.0;
                            $porcentajeFinalActual = 0.0; 
                            foreach($value as $ke=>$val){
                                if($arrayCalculoPRC[$k][$ke]['maximo2'] != 0){
                                    $porcentajeFinal = ($arrayCalculoPRC[$k][$ke]['revisadoN']/$arrayCalculoPRC[$k][$ke]['maximo2'])*100;//($arrayCalculoPRC[$k]['revisado']/$arrayCalculoPRC[$k]['maximo'])*100;
                                }                                  
                                //RCP$porcentajeFinal = (isset($arrayCalculoPRC[$k][$ke]['maximo']))?(($arrayCalculoPRC[$k][$ke]['revisado']/$arrayCalculoPRC[$k][$ke]['maximo'])*100):0;
                                $porcentajeFinalActual = (isset($arrayCalculoPRC[$k][$ke]['maximo']))?(($arrayCalculoPRC[$k][$ke]['actual']/$arrayCalculoPRC[$k][$ke]['maximo'])*100):0;
                            
                                $arrayCalculoPRC[$k][$ke]['porcentaje_final']=(isset($porcentajeFinal))?$porcentajeFinal:0;
                                $arrayCalculoPRC[$k][$ke]['porcentaje_finalActual']=(isset($porcentajeFinalActual))?$porcentajeFinalActual:0;
                                $arrayCalculoPRC[$k][$ke]['criterio_nom']=$val['nombre'];
                            }
                        }
        
                    }//fin tercer for
                
                //Creando Gráfico RADAR
                $resultado=array();        
                $resultado['chart']=array();
                $resultado['chart']['caption']="Resultado Gestión Global";
                $resultado['chart']['xAxisName']="";
                $resultado['chart']['yAxisName']="";
                $resultado['chart']['numberSuffix']="%";
                $resultado['chart']['yAxisMaxValue']="100";
                $resultado['chart']['yAxisMinValue']="0";     
                $resultado['chart']['canvasborderalpha']="0";     
                $resultado['chart']['bgAlpha']="0";
                $resultado['categories']=array();
                $resultado['categories']['category']=array();
                $resultado['dataset']=array();
                
                $tempArray=array();
                $tempArray[$planificacionAnterior]=0;
                $tempArray[$planificacionActual]=1;
                $resultado['dataset'][0]['seriesname']=$nombrePlanificacionAnterior;
                $resultado['dataset'][0]['data']=array();
                $resultado['dataset'][1]['seriesname']=$nombrePlanificacionActual;
                $resultado['dataset'][1]['data']=array();
                $x=0;
                if(isset($arrayCalculoPRC)){
                    $i=0;
                    foreach($arrayCalculoPRC as $k=>$v){
                        foreach($v as $ke=>$val){                            
                            //echo "data=".$tempArray[$ke];
                            $resultado['categories']['category'][$i]['label']='Criterio N°'.($i+1);
                            $resultado['dataset'][$tempArray[$ke]]['data'][$i]['value']=round($val['porcentaje_final'],1);
                            $resultado['dataset'][$tempArray[$ke]]['data'][$i]['toolText']=$val['criterio_nom'].",  Planificación: ".$resultado['dataset'][$tempArray[$ke]]['seriesname'].",  Resultado:".round($val['porcentaje_final'],1)."%";
                        }                
                        $i++;
                    }            
                }
                //print_r($resultado);
                //Yii::app()->end(); 
                $resultado=CJSON::encode($resultado);
        
                echo $resultado;                   

    }

    public function actionReporteTab4(){
    	set_time_limit(50000);
    	//$tablaCriterio = '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>';
    	$evidenciaUrl = array();
    	$evidencia = '';
    	$puntajeRevisadoArray=array();
    	$i=1;
    	$puntajeMaximoSub=0;
    	$sumatorioPuntosElementos=array();
    	$puntajeRevisadoSub=0;
    	$cantidadElementos=array();
    	//$elementosGestion = ElementosGestion::model()->findAll(array('condition'=>'estado = 1'));
        
        
        
        $html = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/><style> table th{background-color:#d2f5f5;border: 1px solid #008080;font-size: 11px;}table td{border: 1px solid #008080;font-size: 11px;}</style></head><body style="margin: 10px 100px;">';
         $listadoElementoGestion=Criterios::model()->findAll();
         foreach($listadoElementoGestion as $a){
                $html.='<table width="100%" border="0" cellpadding="5" cellspacing="1" bordercolor="#008080">';
                $html.='<tr><td style="text-align:justify;"><b>'.$a->nombre.'</b><br/>'.$a->descripcion.'</td></tr>';
                $html.='</table><br/>';
                
                foreach($a->subcriterioses as $b){
                    $sumaPuntosSubcriterio=0;
                    $cantidadElementos=0;
                    $html.='<table width="100%" border="0" cellpadding="5" cellspacing="1">';
                    $html.='<tr>
                                <th width="28%" rowspan="2" style="text-align:justify;font-weight:normal;"><b>'.$b->nombre.':</b> '.$b->descripcion.'</th>
                                <td width="12%" align="center">No hay despliegue</td>
                                <td width="24%" colspan="2" align="center">Despliegue parcial</td>
                                <td width="36%" colspan="3" align="center">Despliegue total</td>
                              </tr>
                              <tr>
                                <td width="12%" align="center">No hay enfoque</td>
                                <td width="12%" align="center">Enfoque incipiente</td>
                                <td width="12%" align="center">Enfoque sistemático</td>
                                <td width="12%" align="center">Enfoque evaluado</td>
                                <td width="12%" align="center">Enfoque  mejorado</td>
                                <td width="12%" align="center">Enfoque efectivo</td>
                              </tr>';
                      $html.='</table>';
                      foreach($b->elementosGestions as $c){
                          $html.='<table width="100%" border="0" cellpadding="5" cellspacing="1">';
                          $cantidadElementos++;                          
                          $d=$c->arrayUltimaEvidenciaRevisadaInterna;
                          $color[0]=$color[1]=$color[2]=$color[3]=$color[4]=$color[5]="";
                          if(isset($d['puntaje'])){
                              $sumaPuntosSubcriterio+=$d['puntaje'];
                              $color[$d['puntaje']]=" style='background-color:#E5F1F4'";
                          }
                            
                          $totalFila=2;
                          $filaDocumento="";
                          if(isset($d['documentos'])){
                                  if(!empty($d['documentos'])){
                                      $filaDocumento.='<tr><td colspan="6">Documentos con evidencia de avance:<br/><ul>';
                                      foreach($d['documentos'] as $kDoc=>$vDoc){
                                          $filaDocumento.='<li>'.$vDoc.'</li>';
                                      }
                                      $filaDocumento.='</ul></td></tr>';
                                      $totalFila=3;
                                  }
                          } 
                          
                          $html.='<tr>
                                <td width="28%" rowspan="'.$totalFila.'" valign="top" style="text-align:justify;">'.$c->nombre.'</td>
                                <td width="12%" '.$color[0].' height="30" align="center">0</td>
                                <td width="12%" '.$color[1].' height="30" align="center">1</td>
                                <td width="12%" '.$color[2].' height="30" align="center">2</td>
                                <td width="12%" '.$color[3].' height="30" align="center">3</td>
                                <td width="12%" '.$color[4].' height="30" align="center">4</td>
                                <td width="12%" '.$color[5].' height="30" align="center">5</td>
                              </tr>
                              <tr>';
                              if(isset($d['evidencia'])){
                                  $html.='<td colspan="6" style="text-align:justify;">'.nl2br($d['evidencia']).'</td>';
                              }else{
                                  $html.='<td colspan="6">&nbsp;</td>';
                              }                            
                              $html.='</tr>'.$filaDocumento;
                              $html.='</table>';
                      }  
                    $cantidadMaxPuntaje=$cantidadElementos*5;
                    $porcentajeLogro=0;
                    if($cantidadMaxPuntaje>0){
                        $porcentajeLogro= round((($sumaPuntosSubcriterio*100)/$cantidadMaxPuntaje),1);     
                    }
                       
                    $html.='<table width="100%" border="0" cellpadding="5" cellspacing="1">';             
                    $html.='<tr><td colspan="5" align="left"><b>Puntos del subcriterio</b> (suma de los puntos obtenidos en cada elemento de gestión)</td><td colspan="2" align="right"> '.$sumaPuntosSubcriterio.' puntos</td></tr>'; 
                    $html.='<tr><td colspan="5" align="left"><b>Porcentaje de logro</b> ([puntos del subcriterio / '.$cantidadMaxPuntaje.'] %)</td><td colspan="2" align="right">'.$porcentajeLogro.' %</td></tr>';          
                    $html.='</table><br/><br/><br/>';
                }//Fin subcriterios                
            } 
        
        
        
        
        
        
        
        
        
        
        
        
        
    	//idSubcriterio
    	/*foreach ($elementosGestion as $e){
    		$puntajeMaximoSub=0;
    		$puntajeRevisadoArray=array();
    		$puntajeRevisadoArray = LaElemGestion::model()->findAll(array('condition'=>'t.puntaje_revisado IS NOT NULL AND id_la IS NULL AND t.id_elem_gestion='.$e->id.' AND t.id_planificacion='.Yii::app()->session['idPlanificaciones'],'order'=>'t.fecha DESC, t.id DESC','select'=>'t.puntaje_revisado'));
    		$cantidadElementos = ElementosGestion::model()->findAll(array('condition'=>'t.id_subcriterio='.$e->idSubcriterio->id.' AND t.estado=1','select'=>'COUNT(t.id) AS can'));
    		
    		//trayendo la suma de puntaje revisado por subcriterio
    		 	$sumatorioPuntosElementos = Subcriterios::model()->getDatosResumenGeneral($e->idSubcriterio->id);
    		//fin
    		if(count($sumatorioPuntosElementos)!=0){
    			if(!is_null($sumatorioPuntosElementos[0]['puntaje_revisado']))
    				$puntajeRevisadoSub = $sumatorioPuntosElementos[0]['puntaje_revisado'];
    		}
    		 	
    		if(count($cantidadElementos)!=0){
    			$puntajeMaximoSub = $cantidadElementos[0]['can']*5;
    		}
    		
    		//$tablaCriterio = $tablaCriterio.'<strong><center>Resumen '.$i.'</strong></center>';
    		$tablaCriterio = $tablaCriterio.'<table width="922" height="67" border="1" cellpadding="0" cellspacing="0">';
    		$tablaCriterio = $tablaCriterio.'<tr><td>'.$e->idSubcriterio->idCriterio.'<br/><br/>'.$e->idSubcriterio->idCriterio->descripcion.'</td></tr>';
    		$tablaCriterio = $tablaCriterio.'</table>';
    		
    		$tablaCriterio = $tablaCriterio.'<table width="926" border="1" cellpadding="0" cellspacing="0">
  							<tr><td width="194" rowspan="2" bgcolor="#CCCCCC">&nbsp;<strong><center>'.$e->idSubcriterio.'</strong></center></td>
   							<td width="130" bgcolor="#CCCCCC"><strong><center>No hay despliegue</center></strong></td>
    						<td colspan="2" bgcolor="#CCCCCC"><strong><center>Despliegue Parcial</center></strong></td>
    						<td colspan="3" bgcolor="#CCCCCC"><strong><center>Despliegue Total</center></strong></td></tr>
  							<tr><td height="41">No hay enfoque</td>
    						<td width="134">Enfoque incipiente</td>
    						<td width="130">Enfoque sistemático</td>
    						<td width="100">Enfoque evaluado</td>
    						<td width="100">Enfoque mejorado</td>
    						<td width="122">Enfoque efectivo</td></tr>
  							<tr><td rowspan="2">&nbsp;<strong><center>'.$e->nombre.'</strong></center></td>';
	    	
    		

    			if(count($puntajeRevisadoArray)!=0){
    				if ($puntajeRevisadoArray[0]['puntaje_revisado']==0){
    					$tablaCriterio = $tablaCriterio.'<td bgcolor="RED">0</td>
    											<td>1</td>
    											<td>2</td>
    											<td>3</td>
    											<td>4</td>
    											<td>5</td>';
    				}
    				if ($puntajeRevisadoArray[0]['puntaje_revisado']==1){
    					$tablaCriterio = $tablaCriterio.'<td>0</td>
    											<td  bgcolor="RED">1</td>
    											<td>2</td>
    											<td>3</td>
    											<td>4</td>
    											<td>5</td>';
    				}
    				if ($puntajeRevisadoArray[0]['puntaje_revisado']==2){
    					$tablaCriterio = $tablaCriterio.'<td>0</td>
    											<td>1</td>
    											<td  bgcolor="RED">2</td>
    											<td>3</td>
    											<td>4</td>
    											<td>5</td>';
    				}
    				if ($puntajeRevisadoArray[0]['puntaje_revisado']==3){
    					$tablaCriterio = $tablaCriterio.'<td>0</td>
    											<td>1</td>
    											<td>2</td>
    											<td bgcolor="RED">3</td>
    											<td>4</td>
    											<td>5</td>';
    				}
    				if ($puntajeRevisadoArray[0]['puntaje_revisado']==4){
    					$tablaCriterio = $tablaCriterio.'<td>0</td>
    											<td>1</td>
    											<td>2</td>
    											<td>3</td>
    											<td  bgcolor="RED">4</td>
    											<td>5</td>';
    				}
    				if ($puntajeRevisadoArray[0]['puntaje_revisado']==5){
    					$tablaCriterio = $tablaCriterio.'<td>0</td>
    											<td>1</td>
    											<td>2</td>
    											<td>3</td>
    											<td>4</td>
    											<td bgcolor="RED">5</td>';
    				}
    				
    			}else{
    				$tablaCriterio = $tablaCriterio.'<td>0</td>
    											<td>1</td>
    											<td>2</td>
    											<td>3</td>
    											<td>4</td>
    											<td>5</td>';
    			}
    		
	    		$tablaCriterio = $tablaCriterio.'</tr><tr>';
			
    		 $evidenciaUrl = LaElemGestion::model()->findAll(array('condition'=>'t.puntaje_revisado IS NOT NULL AND id_la IS NULL AND t.id_elem_gestion='.$e->id.' AND t.id_planificacion='.Yii::app()->session['idPlanificaciones'],'order'=>'t.fecha DESC, t.id DESC','select'=>'t.puntaje_revisado, t.archivo, t.evidencia'));
    	
    		 if(isset($evidenciaUrl[0]['evidencia'])){
    		 	//		echo '2-';
    		 	$evidencia = $evidenciaUrl[0]['evidencia'];
    		 }else{    		 	
    		 	$evidencia = 'S.I.';
    		 }
    		 
			 $tablaCriterio = $tablaCriterio.'<td colspan="6">&nbsp;'.$evidencia.'</td>
  							</tr>
						 	 <tr><td bgcolor="#CCCCCC"><strong>Puntos del Subcriterio</strong></td>
			 				<td colspan="6">'.$puntajeRevisadoSub.'</td> 
			 				</tr>
			 				</tr>
						 	 <tr><td bgcolor="#CCCCCC"><strong>Puntos de Logro</strong></td>
			 				<td colspan="6">';
			 				$re=0;
			 				
			 				if($puntajeMaximoSub!=0){
			 					$re= $puntajeRevisadoSub/$puntajeMaximoSub;
			 					$re = round($re, 2);
			 				}else{
			 					$re = $puntajeRevisadoSub/1;
			 					$re = round($re, 2);
			 				}
			 				
			 
			 $tablaCriterio=$tablaCriterio.$re.'</td> 
			 				</tr>
							</table><br/>';
    		$i++;
    	}//fin ciclo
    	*/
    	
    	
    	if(isset($_GET['pdf'])){
    		//$mPDF1 = Yii::app()->ePdf->mpdf('','A4-L');
    		$mPDF1 = Yii::app()->ePdf->mpdf('','A4-L','13','',15,15,16,16,0,0,'P');//LETTER
    		$mPDF1->WriteHTML($html);
    		$mPDF1->Output('ReporteAutoEvaluacionDetalles.pdf','D');
    	}
    	//imprime el word
    	if(isset($_GET['doc'])){
    			
    		Yii::app()->request->sendFile('ReporteAutoEvaluacionDetalles.doc',$html);
    	}
    	    	
    }
    
}//fin controlador
?>
