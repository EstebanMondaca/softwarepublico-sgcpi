<?php
class ReporteConvenioDesempenoColecitvoController extends GxController {

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
    
	public function actionReportes($id, $anio, $division){

		
	$datosDocumento= "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'/>";
	$datosDocumento=$datosDocumento.'<center><strong>METAS CONVENIO DESEMPE&Ntilde;O COLECTIVO '.$anio.' GOBIERNO REGIONAL DE LOS LAGOS</strong></center>
	<strong>EQUIPO DE TRABAJO: '.$division.'<br/>
	RESPONSABLE: JEFATURA '.$division.'</strong>
	<br/> 
	<table height="69" border="1" align="center" cellpadding="0" cellspacing="0">
	  <tr>
	    <td height="21" align="center" bgcolor="#CCCCCC"><strong>Producto Estratégico al que se Vincula</strong></td>
	    <td align="center" bgcolor="#CCCCCC"><strong>Descripción</strong></td>
	    <td align="center" bgcolor="#CCCCCC"><strong>Indicador</strong></td>
	    <td align="center" bgcolor="#CCCCCC"><strong>Fórmula de Cálculo</strong></td>
	    <td align="center" bgcolor="#CCCCCC"><strong>Meta</strong></td>
	    <td align="center" bgcolor="#CCCCCC"><strong>Ponderación</strong></td>
	    <td align="center" bgcolor="#CCCCCC"><strong>Medios de Verificación</strong></td>
	    <td align="center" bgcolor="#CCCCCC"><strong>Supuestos</strong></td>
	    <td align="center" bgcolor="#CCCCCC"><strong>Notas</strong></td>
	  </tr>';

	$indi= Indicadores::model()->indicadoresCDC($id, 0);
  	
  	//echo count($indi);
	if(!empty($indi)&&count($indi)!=0){
		//$indi=$indi->getData();
		for ($i=0; $i<count($indi);$i++){

			$indicador ='';
			$formula ='';
			$indicador = Indicadores::model()->columnaIndicadorCDCExcel($indi[$i]['id']);
			$formula = TiposFormulas::model()->columnaFormulaReporteReport($indi[$i]['id'], 0);
			
			
					$datosDocumento = $datosDocumento.'
				
					  <tr>
					    <td height="46">&nbsp;'.$indi[$i]['productoEstrategico'].'</td>
					    <td>&nbsp;'.$indi[$i]['descripcion'].'</td>
					    <td>&nbsp;'.$indicador.'</td>
					    <td>&nbsp;'.$formula.'</td>
					    <td>&nbsp;'.$indi[$i]['meta_anual'].'</td>
					    <td>&nbsp;'.$indi[$i]['ponderacion'].'</td>
					    <td>&nbsp;'.$indi[$i]['medio_verificacion'].'</td>
					    <td>&nbsp;'.$indi[$i]['supuestos'].'</td>
					    <td>&nbsp;'.$indi[$i]['notas'].'</td>
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