<?php
include dirname(Yii::app()->request->scriptFile).'/protected/views/panelAvances/ConsultasView.php';

class ReporteIndicadorescdcController extends GxController {

    public function filters() {
    return array(
            'accessControl', 
            );
    }
    
    public function accessRules() {                  
          return array(
            array('allow',
                'actions'=>array('index','reportes'),    
            	'roles'=>array('gestor','finanzas','supervisor','supervisor2'),            
            
            ),             
            array('deny',
                'users'=>array('*'),
            ),
        );
    }  


public function actionIndex() {
     
		$model = new Divisiones('search');
		$model->unsetAttributes();
		$model = $model->search();


		$this->render('index', array(
			'model' => $model,
		));
	}

    
     
	public function actionReportes() {
	
	$datosDocumento= "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'/>";
	$datosDocumento=$datosDocumento.'<center><strong>INFORME EVALUACI&Oacute;N DEFINITIVO CUMPLIMIENTO METAS DE GESTI&Oacute;N CONVENIO DESEMPE&Ntilde;O COLECTIVO</strong></center><table align="center" border="1" cellpadding="0" cellspacing="0" >
				<tbody>
				<tr style=background-color:#E6E3E3;>
					<td style="text-align: center;">
						<strong>LINEA ACCI&Oacute;N</strong></td>
					<td style="text-align: center;">
						<strong>INDICADORES DE EVALUACI&Oacute;N</strong></td>
					<td style="text-align: center;">
						<strong>META</strong></td>
					<td style="text-align: center;">
						<strong>% CUMPLIMIENTO</strong></td>
					<td style="text-align: center;">
						<strong>EFECTIVO</strong></td>
					<td style="text-align: center;">
						<strong>CUMPLE</strong></td>
					<td style="text-align: center;">
						<strong>PONDERACI&Oacute;N</strong></td>
					<td style="text-align: center;">
						<strong>EVALUACI&Oacute;N MEDIOS DE VERIFICACI&Oacute;N</strong></td>
				</tr>
				';

	$indi= LineasAccion::model()->busquedaPersonalizadaReportecdc(0);
  	
	if(!empty($indi)){
		
				for ($i=0; $i<count($indi);$i++){
						
					$auxiliar=array();
					$c = new ConsultasView();
					
					if(!empty($indi[$i]['idIndicador']['id'])&&!empty($indi[$i]['idIndicador']['frecuenciaControl']['plazo_maximo'])&&!empty($indi[$i]['idIndicador']['tipoFormula']['formula'])&&$indi[$i]['idIndicador']['meta_anual']>=0&&$indi[$i]['idIndicador']['tipoFormula']['tipo_resultado']>=0){
					
						
						$auxiliar = $c->construyendoBarras($indi[$i]['idIndicador']['id'], $indi[$i]['idIndicador']['frecuenciaControl']['plazo_maximo'],
						 $indi[$i]['idIndicador']['tipoFormula']['formula'],$indi[$i]['idIndicador']['meta_anual'],$indi[$i]['idIndicador']['tipoFormula']['tipo_resultado']);
					
						 if($auxiliar['value'] != -1 && !empty($auxiliar['value'])){
						 	$indi[$i]['value'] = $auxiliar['value'];
						 }else{
						 	$indi[$i]['value'] = 'S.I.';
						 }
		
					}//fin if si no vienen parametros vacios
					else{
						
						$indi[$i]['value'] = 'S.I.';
		
					}
					if($indi[$i]['value']!='S.I.'&&!empty($indi[$i]['meta_anual'])){
						if($indi[$i]['meta_anual']!=0){
							$indi[$i]['cumplimiento']  = ($indi[$i]['value']*100)/$indi[$i]['meta_anual'];
						}else{
							$indi[$i]['cumplimiento']  = ($indi[$i]['value']*100)/1;
						}
						if($indi[$i]['cumplimiento']>=100){
							$indi[$i]['cumple']  = 'SI';
						}else{
							$indi[$i]['cumple']  = 'NO';
						}
				
					}else{
						
						$indi[$i]['cumplimiento'] = 'S.I.';
						
						$indi[$i]['cumple']  = 'S.I.';
					}
				
					$ponderacion = Indicadores::model()->obtenerPonderacionPorColumnaExcel($indi[$i]['idIndicador']['id'], 1);
					
					
					$datosDocumento = $datosDocumento.'
				
					<tr>
						<td>&nbsp;'.$indi[$i]['nombre'].'</td>
						<td>&nbsp;'.$indi[$i]['idIndicador']['nombre'].'</td>
						<td>&nbsp;'.$indi[$i]['idIndicador']['meta_anual'].'</td>
						<td>&nbsp;'.$indi[$i]['cumplimiento'].'</td>
						<td>&nbsp;'.$indi[$i]['value'].'</td>
						<td>&nbsp;'.$indi[$i]['cumple'].'</td>
						<td>&nbsp;'.$ponderacion.'</td>
						<td>&nbsp;'.$indi[$i]['medio_verificacion'].'</td>
					</tr>
					
			
					';

				}//fin for
	}//fin if
			
	$datosDocumento = $datosDocumento.'	</tbody></table>';
	
	if(isset($_GET['pdf'])){
			$mPDF1 = Yii::app()->ePdf->mpdf('','A4-L');
			$mPDF1->WriteHTML($datosDocumento);
			$mPDF1->Output('ReporteCDC.pdf','D');
	}
	if(isset($_GET['doc'])){
			Yii::app()->request->sendFile('ReporteCDC.doc',$datosDocumento);		
	}
	
  
       
}
	



}
?>