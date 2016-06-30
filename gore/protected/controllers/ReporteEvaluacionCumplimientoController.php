<?php
include dirname(Yii::app()->request->scriptFile).'/protected/views/panelAvances/ConsultasView.php';
class ReporteEvaluacionCumplimientoController extends GxController {

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
    
    
   /* protected function validateAccess(){
        $owner_id='';
           //Si viene el idIndicador es porque estamos actualizando o eliminando una actividad de un indicador
           if(Yii::app()->user->checkAccess("admin")){
               $owner_id=TRUE;
           }else{
               if(isset($_GET['idIndicador'])){
                   $model = Indicadores::model()->findAll(array('condition'=>'t.id='.$_GET['idIndicador']));
                   $userID = Yii::app()->user->id;
                   if(isset($model[0]->responsable_id)){
                       $owner_id=$model[0]->responsable_id;
                   } 
                   //Verificando si el usuario tiene permisos para acceder o si es admin     
                   $owner_id=($userID === $owner_id);               
                }
           }
           
       return $owner_id;
    }
    
     public static function validateAccessbyIndicador($idIndicador=0){
       $owner_id=FALSE;     
       if(Yii::app()->user->checkAccess("admin")){
           $owner_id=TRUE;
       }else{
           $model = Indicadores::model()->findAll(array('condition'=>'t.id='.$idIndicador));
           $userID = Yii::app()->user->id;
           if(isset($model[0]->responsable_id)){
               $owner_id=$model[0]->responsable_id;
           } 
           //Verificando si el usuario tiene permisos para acceder o si es admin     
           $owner_id=(($userID === $owner_id));
       }     
       
       return $owner_id;
    }*/
    
	public function actionReportes($id, $anio, $division, $fecha){
	$meses = array(1  => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4  => 'Abril', 5 => 'Mayo', 6 => 'Junio', 7  => 'Julio', 8 => 'Agosto', 9 => 'Septiembre', 10  => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre' );
	$c = new ConsultasView();
	$datosDocumento= "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'/>";
	$datosDocumento=$datosDocumento.'<strong><center>INFORME DE EVALUACIÓN CUMPLIMIENTO AÑO  '.$anio.' GOBIERNO REGIONAL DE LOS LAGOS</center></strong>
	<table  border="1" cellpadding="0" cellspacing="0" align="center" >
	  <tr>
	    <td>SERVICIO</td>
	    <td>GOBIERNO REGIONAL DE LOS LAGOS</td>
	    <td>FECHA INFORME</td>
	    <td>&nbsp;'.$fecha.'</td>
	  </tr>
	  <tr>
	    <td>CENTRO DE RESPONSABILIDAD</td>
	    <td>&nbsp;'.$division.'</td>
	    <td>ENCARGADO DE EVALUACIÓN</td>
	    <td>&nbsp;</td>
	  </tr>
	</table>
	<br/> 
	<table height="69" border="1" align="center" cellpadding="0" cellspacing="0">
	  <tr>
	    <td height="21" align="center" bgcolor="#CCCCCC"><strong>Indicador</strong></td>
	    <td align="center" bgcolor="#CCCCCC"><strong>Fórmula de Cálculo</strong></td>
	    <td align="center" bgcolor="#CCCCCC"><strong>Meta</strong></td>
	    <td align="center" bgcolor="#CCCCCC"><strong>Efectivo</strong></td>
	    <td align="center" bgcolor="#CCCCCC"><strong>Cumple</strong></td>
	    <td align="center" bgcolor="#CCCCCC"><strong>% Cumplimiento</strong></td>
	    <td align="center" bgcolor="#CCCCCC"><strong>Ponderación</strong></td>
	    <td align="center" bgcolor="#CCCCCC"><strong>Evaluación Cualitativa</strong></td>
	  </tr>';

	$indi= Indicadores::model()->indicadoresCDC($id, 0);
  //	$indi=$indi->getData();
  	//echo count($indi);
	if(!empty($indi)&&count($indi)!=0){
		for ($i=0; $i<count($indi);$i++){

			$indicador ='';
			$formula='';
			$indicador = Indicadores::model()->columnaIndicadorCDCExcel($indi[$i]['id']);
			$formula = TiposFormulas::model()->columnaFormulaReporteReport($indi[$i]['id'], 0);
			
				$hitosIndicador = HitosIndicadores::model()->ultimoHitoIndicador($indi[$i]['id']);
				$ultimoHito = $c->encuentraUltimoHitoAnioAnterior($hitosIndicador,$meses); 
			
				if(isset($ultimoHito['meta_reportada'])){
					$indi[$i]['meta_reportada'] = $ultimoHito['meta_reportada'];
					
					if($indi[$i]['meta_reportada']>=$indi[$i]['meta_anual2']){
						$indi[$i]['cumple'] = 'SI';
						
					}else{
						$indi[$i]['cumple'] = 'NO';
						$indi[$i]['porcentajeCumplimiento'] = 'S.I.';
					}
					if($indi[$i]['meta_anual2']!=0){
						$indi[$i]['porcentajeCumplimiento'] = ($indi[$i]['meta_reportada']*100)/$indi[$i]['meta_anual2'];
					}else{
						$indi[$i]['porcentajeCumplimiento'] = ($indi[$i]['meta_reportada']*100)/1;
					}
				}else{
					$indi[$i]['meta_reportada'] = 'S.I.';
					$indi[$i]['cumple'] = 'S.I.';
					$indi[$i]['porcentajeCumplimiento'] = 'S.I.';
				}
		
			
			
			
					$datosDocumento = $datosDocumento.'
				
					  <tr>
					    <td height="46">&nbsp;'.$indicador.'</td>
					    <td>&nbsp;'.$formula.'</td>
					    <td>&nbsp;'.$indi[$i]['meta_anual'].'</td>
					    <td>&nbsp;'.$indi[$i]['meta_reportada'].'</td>
					    <td>&nbsp;'.$indi[$i]['cumple'].'</td>
					    <td>&nbsp;'.$indi[$i]['porcentajeCumplimiento'].'</td>
					    <td>&nbsp;'.$indi[$i]['ponderacion'].'</td>
					    <td>&nbsp;</td>
					  </tr>
					
			
					';

		}//fin for
	}//fin if
			
	$datosDocumento = $datosDocumento.'	</tbody></table>';
	
	if(isset($_GET['pdf'])){
			$mPDF1 = Yii::app()->ePdf->mpdf('','A4-L');
			$mPDF1->WriteHTML($datosDocumento);
			$mPDF1->Output('ReporteConvenioDC.pdf','D');
	}
	if(isset($_GET['doc'])){
			Yii::app()->request->sendFile('ReporteConvenioDC.doc',$datosDocumento);		
	}
	}
	




}
?>