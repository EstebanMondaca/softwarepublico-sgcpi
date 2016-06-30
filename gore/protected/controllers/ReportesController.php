 <?php
class ReportesController extends GxController
{
	/**
	 * Declares class-based actions.
	 */
	

	public function accessRules() {
        return array(
                array('allow',
                    'actions'=>array('index', 'view','reportes','cadenaValorNegocio','formHexportfileServer','formA1exportfileServe','contenidoFormularioA1'),
                    'users'=>array('@'),
                    ),
                array('deny',  // deny all other users
                        'users'=>array('*'),
                        ),
                );
    }
	
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		
		$this->render('index');
	}
	
	/**
	 * This is the default 'preferencias' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionView($id)
	{
		$this->render('radar');
	}
		
	
	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}
	
	public function actionFormularioH(){
	
		$model = new Indicadores('busquedaParaFormularioH');
		$model->unsetAttributes();
		
		if (isset($_GET['Indicadores'])){
			$model->setAttributes($_GET['Indicadores']);
		}
	
		$this->render('formularioH' ,array(
				'model' => $model,
		));
	
	}
	
	public function actionFormHexportfile(){
		ini_set('memory_limit', '512M');
		$archovoparaddoc="";
		$periodoActual = Yii::app()->session['idPeriodoSelecionado'];
		$periodo= 'Meta '.$periodoActual;
		$t1 = $periodoActual-1;
		$t2 = $periodoActual-2;
		$t3 = $periodoActual-3;
		$t4 = $periodoActual-4;
		
		$nombret1 = 'Efectivo a Junio '.$t1;
		$nombret2 = 'Efectivo '.$t2;
		$nombret3 = 'Efectivo '.$t3;
		$nombret4 = 'Efectivo '.$t4;
		$Estimaciont1 = 'Estimación '.$t1;
		$archivoparaddoc= "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'/>";
		$archivoparaddoc= $archivoparaddoc."<table align='center'><tr><td><h2>FORMULARIO INDICADORES DE DESEMPEÑO AÑO $periodoActual </h2></td></tr></table>";
		
		$archivoparaddoc= $archivoparaddoc."<br><table border='1' align='center' cellpadding='0' cellspacing='0' style='width: 100%;'>";
		$archivoparaddoc= $archivoparaddoc."<tr><th style='background-color:#E6E3E3;'>MINISTERIO</th>";
		$archivoparaddoc= $archivoparaddoc."<td>MINISTERIO DEL INTERIOR</td>";
		$archivoparaddoc= $archivoparaddoc."<th style='background-color:#E6E3E3;'>PARTIDA</th>";
		$archivoparaddoc= $archivoparaddoc."<td>05</td></tr><tr>";
		$archivoparaddoc= $archivoparaddoc."<th style='background-color:#E6E3E3;'>SERVICIO</th>";
		$archivoparaddoc= $archivoparaddoc."<td>GOBIERNO REGIONAL REGION X LOS RIOS</td>";
		$archivoparaddoc= $archivoparaddoc."<th style='background-color:#E6E3E3;'>CAPITULO</th>";
		$archivoparaddoc= $archivoparaddoc."<td>70</td></tr></table><br>";
		
		$archivoparaddoc= $archivoparaddoc."<table border='1' cellpadding='0' cellspacing='0' align='center' style='width: 100%;'>";
		
		//titulos
		$archivoparaddoc= $archivoparaddoc."<tr style='background-color:#E6E3E3;'>";
		$archivoparaddoc= $archivoparaddoc."<th>Producto Estratégico al que se Vincula</th>";
		$archivoparaddoc= $archivoparaddoc."<th>Descripción</th>";
		$archivoparaddoc= $archivoparaddoc."<th style='width: 15%;'>Indicador</th>";
		$archivoparaddoc= $archivoparaddoc."<th>Fórmula de<br>Cálculo</th>";
		$archivoparaddoc= $archivoparaddoc."<th>";
// 		$archivoparaddoc= $archivoparaddoc.$nombret4;
// 		$archivoparaddoc= $archivoparaddoc."</th><th>";
// 		$archivoparaddoc= $archivoparaddoc.$nombret3;
// 		$archivoparaddoc= $archivoparaddoc."</th><th>";
// 		$archivoparaddoc= $archivoparaddoc.$nombret2;
// 		$archivoparaddoc= $archivoparaddoc."</th><th>";
// 		$archivoparaddoc= $archivoparaddoc.$nombret1;
// 		$archivoparaddoc= $archivoparaddoc."</th><th>";
// 		$archivoparaddoc= $archivoparaddoc.$Estimaciont1;
// 		$archivoparaddoc= $archivoparaddoc."</th><th>";
		$archivoparaddoc= $archivoparaddoc.$periodo;
		$archivoparaddoc= $archivoparaddoc."</th><th>Ponde-<br>ración</th>";
		$archivoparaddoc= $archivoparaddoc."<th>Medios de <br> Verificación</th>";
		$archivoparaddoc= $archivoparaddoc."<th>Supuestos</th>";
		$archivoparaddoc= $archivoparaddoc."<th>Notas</th></tr>";
		
		$indicadores=Indicadores::model()->busquedaParaFormularioHdoc();
		//filas y columnas de la tabla
		if(empty($indicadores)){
			echo ' No se encontraron registros';
		}else{
			for($i=0; $i<count($indicadores);$i++){
				$archivoparaddoc= $archivoparaddoc."<tr><td>";
				$productos=ProductosEstrategicos::model()->productosEstrategicosporindicador($indicadores[$i]['id']);
				if(empty($productos)){
					echo ' No se encontraron registros';
				}else{
					$archivoparaddoc= $archivoparaddoc.$productos[0]['nombre'];
				}
		
				$archivoparaddoc= $archivoparaddoc."</td><td>";
				$archivoparaddoc= $archivoparaddoc.$indicadores[$i]['descripcion'];
				$archivoparaddoc= $archivoparaddoc."</td><td>";
				$indicador=Indicadores::model()->columnaIndicadorCDCExcel($indicadores[$i]['id']);
				if(empty($indicador)){
					echo ' No se encontraron registros';
				}else{
					$archivoparaddoc= $archivoparaddoc.$indicador;
				}
				$archivoparaddoc= $archivoparaddoc."</td><td>";
				$archivoparaddoc= $archivoparaddoc.$indicadores[$i]['formula'];
				$archivoparaddoc= $archivoparaddoc."</td><td>";
// 				$archivoparaddoc= $archivoparaddoc.$indicadores[$i]['estado'];
// 				$archivoparaddoc= $archivoparaddoc."</td><td>";
// 				$archivoparaddoc= $archivoparaddoc.$indicadores[$i]['efectivot3'];
// 				$archivoparaddoc= $archivoparaddoc."</td><td>";
// 				$archivoparaddoc= $archivoparaddoc.$indicadores[$i]['efectivot2'];
// 				$archivoparaddoc= $archivoparaddoc."</td><td>";
// 				$archivoparaddoc= $archivoparaddoc.$indicadores[$i]['efectivot1'];
// 				$archivoparaddoc= $archivoparaddoc."</td><td>";
// 				$archivoparaddoc= $archivoparaddoc.$indicadores[$i]['estado'];
// 				$archivoparaddoc= $archivoparaddoc."</td><td>";
				$archivoparaddoc= $archivoparaddoc.$indicadores[$i]['meta_anual']."%";
				$archivoparaddoc= $archivoparaddoc."</td><td>";
				$archivoparaddoc= $archivoparaddoc.$indicadores[$i]['ponderacion'];
				$archivoparaddoc= $archivoparaddoc."%";
				$archivoparaddoc= $archivoparaddoc."</td><td>";
				$archivoparaddoc= $archivoparaddoc.$indicadores[$i]['medio_verificacion'];
				$archivoparaddoc= $archivoparaddoc."</td><td>";
				$archivoparaddoc= $archivoparaddoc.$indicadores[$i]['supuestos'];
				$archivoparaddoc= $archivoparaddoc."</td><td>";
				$archivoparaddoc= $archivoparaddoc.$indicadores[$i]['notas'];
				$archivoparaddoc= $archivoparaddoc."</td></tr>";
			}
		}
		$archivoparaddoc= $archivoparaddoc."</table>";
		$nombrearchivo="FormularioH_".date("d_m_Y").".doc";
		$nombrearchivopdf="FormularioH_".date("d_m_Y").".pdf";
		//$nombrearchivopdfservidor=Yii::getPathOfAlias('webroot').'/upload/reportes/'."formularioH_".date("d_m_Y").".pdf";
		$nombrearchivopdfservidor=Yii::getPathOfAlias('webroot').'/upload/reportes/'.$nombrearchivopdf.".pdf";
		
		if(isset($_GET['pdf'])){
			$mPDF1 = Yii::app()->ePdf->mpdf('','A4-L');
			$mPDF1->DeflMargin=2;
			$mPDF1->DefrMargin=2;
			$mPDF1->tMargin=2;
			$mPDF1->bMargin=2;
			$mPDF1->WriteHTML($archivoparaddoc);
			$mPDF1->Output($nombrearchivopdf,'D');
		}
		if(isset($_GET['doc'])){
			Yii::app()->request->sendFile($nombrearchivo,$archivoparaddoc);			
		}
		if(isset($_GET['pdfaservidor'])){
			$mPDF1 = Yii::app()->ePdf->mpdf('','A4-L');
			$mPDF1->DeflMargin=2;
			$mPDF1->DefrMargin=2;
			$mPDF1->tMargin=2;
			$mPDF1->bMargin=2;
			$mPDF1->WriteHTML($archivoparaddoc);
			$mPDF1->Output($nombrearchivopdfservidor,'F');
		}
	}
	
	public function formHexportfileServer(){
		ini_set('memory_limit', '512M');
		$archovoparaddoc="";
		$periodoActual = Yii::app()->session['idPeriodoSelecionado'];
		$periodo= 'Meta '.$periodoActual;
		$t1 = $periodoActual-1;
		$t2 = $periodoActual-2;
		$t3 = $periodoActual-3;
		$t4 = $periodoActual-4;
		
		$nombret1 = 'Efectivo a Junio '.$t1;
		$nombret2 = 'Efectivo '.$t2;
		$nombret3 = 'Efectivo '.$t3;
		$nombret4 = 'Efectivo '.$t4;
		$Estimaciont1 = 'Estimación '.$t1;
		$archivoparaddoc= "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'/>";
		$archivoparaddoc= $archivoparaddoc."<table align='center'><tr><td><h2>FORMULARIO INDICADORES DE DESEMPEÑO AÑO $periodoActual </h2></td></tr></table>";
		
		$archivoparaddoc= $archivoparaddoc."<br><table border='1' align='center' cellpadding='0' cellspacing='0' style='width: 100%;'>";
		$archivoparaddoc= $archivoparaddoc."<tr><th style='background-color:#E6E3E3;'>MINISTERIO</th>";
		$archivoparaddoc= $archivoparaddoc."<td>MINISTERIO DEL INTERIOR</td>";
		$archivoparaddoc= $archivoparaddoc."<th style='background-color:#E6E3E3;'>PARTIDA</th>";
		$archivoparaddoc= $archivoparaddoc."<td>05</td></tr><tr>";
		$archivoparaddoc= $archivoparaddoc."<th style='background-color:#E6E3E3;'>SERVICIO</th>";
		$archivoparaddoc= $archivoparaddoc."<td>GOBIERNO REGIONAL REGION X LOS RIOS</td>";
		$archivoparaddoc= $archivoparaddoc."<th style='background-color:#E6E3E3;'>CAPITULO</th>";
		$archivoparaddoc= $archivoparaddoc."<td>70</td></tr></table><br>";
		
		$archivoparaddoc= $archivoparaddoc."<table border='1' cellpadding='0' cellspacing='0' align='center' style='width: 100%;'>";
		
		//titulos
		$archivoparaddoc= $archivoparaddoc."<tr style='background-color:#E6E3E3;'>";
		$archivoparaddoc= $archivoparaddoc."<th>Producto Estratégico al que se Vincula</th>";
		$archivoparaddoc= $archivoparaddoc."<th>Descripción</th>";
		$archivoparaddoc= $archivoparaddoc."<th style='width: 15%;'>Indicador</th>";
		$archivoparaddoc= $archivoparaddoc."<th>Fórmula de<br>Cálculo</th>";
		$archivoparaddoc= $archivoparaddoc."<th>";
		$archivoparaddoc= $archivoparaddoc.$periodo;
		$archivoparaddoc= $archivoparaddoc."</th><th>Ponde-<br>ración</th>";
		$archivoparaddoc= $archivoparaddoc."<th>Medios de <br> Verificación</th>";
		$archivoparaddoc= $archivoparaddoc."<th>Supuestos</th>";
		$archivoparaddoc= $archivoparaddoc."<th>Notas</th></tr>";
		
		$indicadores=Indicadores::model()->busquedaParaFormularioHdoc();
		//filas y columnas de la tabla
		if(empty($indicadores)){
			echo ' No se encontraron registros';
		}else{
			for($i=0; $i<count($indicadores);$i++){
				$archivoparaddoc= $archivoparaddoc."<tr><td>";
				$productos=ProductosEstrategicos::model()->productosEstrategicosporindicador($indicadores[$i]['id']);
				if(empty($productos)){
					echo ' No se encontraron registros';
				}else{
					$archivoparaddoc= $archivoparaddoc.$productos[0]['nombre'];
				}
		
				$archivoparaddoc= $archivoparaddoc."</td><td>";
				$archivoparaddoc= $archivoparaddoc.$indicadores[$i]['descripcion'];
				$archivoparaddoc= $archivoparaddoc."</td><td>";
				$indicador=Indicadores::model()->columnaIndicadorCDCExcel($indicadores[$i]['id']);
				if(empty($indicador)){
					echo ' No se encontraron registros';
				}else{
					$archivoparaddoc= $archivoparaddoc.$indicador;
				}
				$archivoparaddoc= $archivoparaddoc."</td><td>";
				$archivoparaddoc= $archivoparaddoc.$indicadores[$i]['formula'];
				$archivoparaddoc= $archivoparaddoc."</td><td>";
				$archivoparaddoc= $archivoparaddoc.$indicadores[$i]['meta_anual']."%";
				$archivoparaddoc= $archivoparaddoc."</td><td>";
				$archivoparaddoc= $archivoparaddoc.$indicadores[$i]['ponderacion'];
				$archivoparaddoc= $archivoparaddoc."%";
				$archivoparaddoc= $archivoparaddoc."</td><td>";
				$archivoparaddoc= $archivoparaddoc.$indicadores[$i]['medio_verificacion'];
				$archivoparaddoc= $archivoparaddoc."</td><td>";
				$archivoparaddoc= $archivoparaddoc.$indicadores[$i]['supuestos'];
				$archivoparaddoc= $archivoparaddoc."</td><td>";
				$archivoparaddoc= $archivoparaddoc.$indicadores[$i]['notas'];
				$archivoparaddoc= $archivoparaddoc."</td></tr>";
			}
		}
		$archivoparaddoc= $archivoparaddoc."</table>";
		$nombrearchivo="FormularioH_".date("d_m_Y").".doc";
		$nombrearchivopdf="FormularioH_".date("d_m_Y").".pdf";
		$nombrearchivopdfservidor=Yii::getPathOfAlias('webroot').'/upload/reportes/'.$nombrearchivopdf;
		

		//Copiando el archivo al servidor
		$mPDF1 = Yii::app()->ePdf->mpdf('','A4-L');
		$mPDF1->DeflMargin=2;
		$mPDF1->DefrMargin=2;
		$mPDF1->tMargin=2;
		$mPDF1->bMargin=2;
		$mPDF1->WriteHTML($archivoparaddoc);
		$mPDF1->Output($nombrearchivopdfservidor,'F');
		
		//Retornamos el nombre del PDF
		return $nombrearchivopdf;
	}
	
	public function formA1exportfileServer(){
		ini_set('memory_limit', '512M');
		$archivoparaddoc=ReportesController::contenidoFormularioA1();
		
		$nombrearchivopdf="FormularioA1_".date("d_m_Y").".pdf";
		$nombrearchivopdfservidor=Yii::getPathOfAlias('webroot').'/upload/reportes/'.$nombrearchivopdf;
	
		$mPDF1 = Yii::app()->ePdf->mpdf('','A4-L');
		$mPDF1->DeflMargin=2;
		$mPDF1->DefrMargin=2;
		$mPDF1->tMargin=2;
		$mPDF1->bMargin=2;
		$mPDF1->WriteHTML($archivoparaddoc);
		$mPDF1->Output($nombrearchivopdfservidor,'F');
		
		//Retornamos el nombre del PDF
		return $nombrearchivopdf;
		
	}
	
	public function actionFormA1exportfile(){
		ini_set('memory_limit', '512M');
		
		$archivoparaddoc=ReportesController::contenidoFormularioA1();
		
		$nombrearchivo="FormularioA1_".date("d_m_Y").".doc";
		$nombrearchivopdf="FormularioA1_".date("d_m_Y").".pdf";
		//$nombrearchivopdfservidor=Yii::getPathOfAlias('webroot').'/upload/reportes/'."formularioH_".date("d_m_Y").".pdf";
		$nombrearchivopdfservidor=Yii::getPathOfAlias('webroot').'/upload/reportes/'.$nombrearchivopdf.".pdf";
	
		if(isset($_GET['pdf'])){
			$mPDF1 = Yii::app()->ePdf->mpdf('','A4-L');
			$mPDF1->DeflMargin=2;
			$mPDF1->DefrMargin=2;
			$mPDF1->tMargin=2;
			$mPDF1->bMargin=2;
			$mPDF1->WriteHTML($archivoparaddoc);
			$mPDF1->Output($nombrearchivopdf,'D');
		}
		if(isset($_GET['doc'])){
			Yii::app()->request->sendFile($nombrearchivo,$archivoparaddoc);
		}
		if(isset($_GET['pdfaservidor'])){
			$mPDF1 = Yii::app()->ePdf->mpdf('','A4-L');
			$mPDF1->DeflMargin=2;
			$mPDF1->DefrMargin=2;
			$mPDF1->tMargin=2;
			$mPDF1->bMargin=2;
			$mPDF1->WriteHTML($archivoparaddoc);
			$mPDF1->Output($nombrearchivopdfservidor,'F');
		}
	}
	
	public function contenidoFormularioA1()
	{
		ini_set('memory_limit', '512M');
		$archovoparaddoc="";
		$periodoActual = Yii::app()->session['idPeriodoSelecionado'];
		$periodosiguiente= $periodoActual+1;
		$periodosubsiguiente= $periodoActual+2;
		
		$archivoparaddoc= "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'/>";
		$archivoparaddoc= $archivoparaddoc."<table align='center'><tr><td><h2 align='center'>Propuesta Ficha A-1 de Definiciones Estratégicas Año $periodosiguiente-$periodosubsiguiente</h2></td></tr></table>";
	
		$archivoparaddoc= $archivoparaddoc."<br><table border='1' align='center' cellpadding='0' cellspacing='0' style='width: 100%;'>";
		$archivoparaddoc= $archivoparaddoc."<tr><th style='background-color:#E6E3E3;'>MINISTERIO</th>";
		$archivoparaddoc= $archivoparaddoc."<td>MINISTERIO DEL INTERIOR</td>";
		$archivoparaddoc= $archivoparaddoc."<th style='background-color:#E6E3E3;'>PARTIDA</th>";
		$archivoparaddoc= $archivoparaddoc."<td>05</td></tr><tr>";
		$archivoparaddoc= $archivoparaddoc."<th style='background-color:#E6E3E3;'>SERVICIO</th>";
		$archivoparaddoc= $archivoparaddoc."<td>GOBIERNO REGIONAL REGION X LOS RIOS</td>";
		$archivoparaddoc= $archivoparaddoc."<th style='background-color:#E6E3E3;'>CAPITULO</th>";
		$archivoparaddoc= $archivoparaddoc."<td>70</td></tr></table><br><br>";
	
		$archivoparaddoc= $archivoparaddoc."<table border='1' cellpadding='0' cellspacing='0' style='width: 100%;'><tr align='center'><th style='background-color:#E6E3E3'>";
		$archivoparaddoc= $archivoparaddoc."<p><h3formA1>Ley orgánica o Decreto que la rige</h3formA1></p></th></tr><tr><td align='left'>";
		$leyesmandatos=LeyesMandatos::model()->buscarLeyesMandatos();
		if(empty($leyesmandatos)){
			$archivoparaddoc= $archivoparaddoc."No se encontraron registros";
		}else{
			for($i=0; $i<count($leyesmandatos);$i++){
				$archivoparaddoc= $archivoparaddoc.$leyesmandatos[$i]['nombre'];
				if($i<(count($leyesmandatos)-2))
					$archivoparaddoc= $archivoparaddoc." , ";
				if($i==(count($leyesmandatos)-2))
					$archivoparaddoc= $archivoparaddoc." y ";
		}}
		$archivoparaddoc= $archivoparaddoc."<br>&nbsp;</td></tr></table><br><br>";
		
		$archivoparaddoc= $archivoparaddoc."<table border='1'  cellpadding='0' cellspacing='0' style='width: 100%;'><tr align='center'><th style='background-color:#E6E3E3'>";
		$archivoparaddoc= $archivoparaddoc."<p><h3formA1>Misión Institucional</h3formA1></p></th></tr><tr><td align='left'>";
		$misionperiodo=MisionesVisiones::model()->buscarMisionporPeriodo();
		if(empty($misionperiodo)){
			$archivoparaddoc= $archivoparaddoc." No se encontraron registros";
		}else{
			for($i=0; $i<count($misionperiodo);$i++){
				if($misionperiodo[$i]['nombre']=='Misión'||$misionperiodo[$i]['nombre']=='Mision'||$misionperiodo[$i]['nombre']=='MISION'||$misionperiodo[$i]['nombre']=='MISIÓN'){
					$archivoparaddoc= $archivoparaddoc.$misionperiodo[$i]['descripcion'];
					$archivoparaddoc= $archivoparaddoc."<br><br>";
				}
			}
		}
		$archivoparaddoc= $archivoparaddoc."</td></tr></table><br><br>";
		
		$archivoparaddoc= $archivoparaddoc."<table border='1' cellpadding='0' cellspacing='0' style='width: 100%;'><tr><th colspan='2' align='justify' style='background-color:#E6E3E3'><h3formA1>";
		for($i=0;$i<22;$i++){
			$archivoparaddoc= $archivoparaddoc."&nbsp;";
		}
		$archivoparaddoc= $archivoparaddoc."Objetivos Relevantes del Ministerio<br>&nbsp;</h3formA1></td></tr><tr align='center'>";
		$archivoparaddoc= $archivoparaddoc."<th>&nbsp;&nbsp;Número&nbsp;&nbsp;<br>&nbsp;</th><th>Descripción<br>&nbsp;</th></tr>";
		$sumatotal=0;
		$objetivosdelministerio=ObjetivosMinisteriales::model()->buscarObjetivosMinisteriales();
		if(empty($objetivosdelministerio)){
			$archivoparaddoc= $archivoparaddoc."<tr><td colspan='2'>&nbsp;No se encontraron registros</td></tr>";
		}else{
			for($i=0; $i<count($objetivosdelministerio);$i++){
				$archivoparaddoc= $archivoparaddoc."<tr><td align='center'>";
				$archivoparaddoc= $archivoparaddoc.($i+1);
				$archivoparaddoc= $archivoparaddoc."<br>&nbsp;</td><td>";
				$archivoparaddoc= $archivoparaddoc.$objetivosdelministerio[$i]['descripcion'];
				$idobjministerial[$i] = $objetivosdelministerio[$i]['id'];
				$archivoparaddoc= $archivoparaddoc."<br>&nbsp;</td></tr>";
				}
		}	
		$archivoparaddoc= $archivoparaddoc."</table><br><br>";
		
		
		$archivoparaddoc= $archivoparaddoc."<table border='1' cellpadding='0' cellspacing='0' style='width: 100%;'><tr><th colspan='5' style='background-color:#E6E3E3'><h3formA1>";
		for($i=0;$i<20;$i++){
			$archivoparaddoc= $archivoparaddoc."&nbsp;";
		}
		$archivoparaddoc= $archivoparaddoc."Objetivos Estratégicos Institucionales<br>&nbsp;</h3formA1></th></tr><tr align='center'>"; 
		$archivoparaddoc= $archivoparaddoc."<th>&nbsp;&nbsp;Nº&nbsp;&nbsp;<br>&nbsp;</th><th>Descripción<br>&nbsp;</th><th>Objetivos<br>Relevantes<br>del<br>Ministerio<br>vinculados<br>&nbsp;</th>";
		$tipoproductos=TiposProductos::model()->buscartipodeproducto();
		if(empty($tipoproductos)){
		}else{
			for($i=0; $i<count($tipoproductos);$i++){
				$archivoparaddoc= $archivoparaddoc."<th>Productos<br>Estratégicos<br>";
				$archivoparaddoc= $archivoparaddoc.$tipoproductos[$i]['nombre'];
				$archivoparaddoc= $archivoparaddoc."<br>vinculados<br>&nbsp;</th>";
			}
		}
		$archivoparaddoc= $archivoparaddoc."</tr>";
		$objetivosestrategicos=ObjetivosEstrategicos::model()->buscarObjetivosEstrategicos();
		if(empty($objetivosestrategicos)){
			$archivoparaddoc= $archivoparaddoc."<tr><td colspan='5'>&nbsp;No se encontraron registros</td></tr>";
		}else{
		for($i=0; $i<count($objetivosestrategicos);$i++){
			$archivoparaddoc= $archivoparaddoc."<tr><td align='center'>";
			$archivoparaddoc= $archivoparaddoc.($i+1);
			$archivoparaddoc= $archivoparaddoc."<br>&nbsp;</td><td>";
			$archivoparaddoc= $archivoparaddoc.$objetivosestrategicos[$i]['descripcion'];
			$archivoparaddoc= $archivoparaddoc."<br>&nbsp;</td><td align='center'>";
			$objetivosobjetivos=ObjetivosObjetivos::model()->buscarObjetivosObjetivo($objetivosestrategicos[$i]['id']);
			if(empty($objetivosobjetivos)){
				$archivoparaddoc= $archivoparaddoc."No Se Vincula";
			}else{
				$l=count($idobjministerial);
				for($j=0;$j<count($objetivosobjetivos);$j++){
					$m=0;
					while($m<$l){
					if($objetivosobjetivos[$j]['objetivo_ministerial_id']==$idobjministerial[$m]){
						if($j!=0){$archivoparaddoc= $archivoparaddoc.",";}
						$archivoparaddoc= $archivoparaddoc.($m+1);
						$m++;
					}else{
					      $m++;
					}
				}
			}
		}
		for($b=0; $b<count($tipoproductos);$b++){
			$objetivosproductos=ObjetivosProductos::model()->buscarobjetivosProducto($objetivosestrategicos[$i]['id']);
			$archivoparaddoc= $archivoparaddoc."<br>&nbsp;</td><td align='center'>";
			$productosestrategicos=ProductosEstrategicos::model()->productosestrategicosporObjetivosestrategicosytipoproducto($objetivosestrategicos[$i]['id'],$tipoproductos[$b]['id']);
			for($j=0;$j<count($productosestrategicos);$j++){
				$id_productoestrategico[$j]=$productosestrategicos[$j]['id'];
			}
			if(empty($productosestrategicos)){
					$archivoparaddoc= $archivoparaddoc."No Se Vincula";
			}else{
				$l=count($id_productoestrategico);
				for($j=0;$j<count($objetivosproductos);$j++){
					$bandera=0;
					$m=0;
					while($m<$l){
					if($objetivosproductos[$j]['producto_estrategico_id']==$id_productoestrategico[$m]){
						if($j!=0 && $bandera>0){$archivoparaddoc= $archivoparaddoc.",";}
						$archivoparaddoc= $archivoparaddoc.($m+1);
						$m++;
					}else{
						$m++;
						$bandera++;
					}
				}
		}}}
		$archivoparaddoc= $archivoparaddoc."<br>&nbsp;</td></tr>";
		}}
		$archivoparaddoc= $archivoparaddoc."</table><br><br>";
		
		$tipoproductos=TiposProductos::model()->buscartipodeproducto();
		
		if(empty($tipoproductos)){
		}else{
			for($i=0; $i<count($tipoproductos);$i++){
				$tab=$i;
			}
		}
		for($u=0;$u<=$tab;$u++){	
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
		$archivoparaddoc= $archivoparaddoc."<table border='1' cellpadding='0' cellspacing='0' style='width: 100%;'><tr><th colspan='7' style='background-color:#E6E3E3'><h3formA1>";
		for($i=0;$i<20;$i++){$archivoparaddoc= $archivoparaddoc."&nbsp;";}
		$archivoparaddoc= $archivoparaddoc."Productos Estratégicos ";
		$archivoparaddoc= $archivoparaddoc.$tipoproductos[$u]['nombre'];
		$archivoparaddoc= $archivoparaddoc." (Bienes y/o Servicios) <br>&nbsp;</h3formA1></th></tr><tr><th>&nbsp;Nº&nbsp;</th><th>Producto Estratégico";
		$archivoparaddoc= $archivoparaddoc.$tipoproductos[$u]['nombre'];
		$archivoparaddoc= $archivoparaddoc."</th><th>Descripción</th><th>Subproducto-Productos<br>Específicos</th><th>Clientes</th><th>Aplica<br>G. Territorial</th><th>Aplica<br>Género</th></tr>";
		$productoestrategico=ProductosEstrategicos::model()->productosestrategicosportipoproducto($tipoproductos[$u]['id']);
		if(empty($productoestrategico)){
			$archivoparaddoc= $archivoparaddoc."<tr><td colspan='7'>&nbsp;No se encontraron registros</td></tr>";
		}else{
			for($i=0;$i<count($productoestrategico);$i++){
				$archivoparaddoc= $archivoparaddoc."<tr><td align='center'>";
				$archivoparaddoc= $archivoparaddoc.($i+1);
				$archivoparaddoc= $archivoparaddoc."</td><td>";
				$archivoparaddoc= $archivoparaddoc.$productoestrategico[$i]['nombre'];
				$archivoparaddoc= $archivoparaddoc."</td><td>";
				$archivoparaddoc= $archivoparaddoc.$productoestrategico[$i]['descripcion'];
				$archivoparaddoc= $archivoparaddoc."</td><td style='width: 35%;'>";
				$subproducto=Subproductos::model()->subproductosxproductoestrategico($productoestrategico[$i]['id']);
				if(empty($subproducto)){
					$archivoparaddoc= $archivoparaddoc." No se encontraron registros";
				}else{
					for($j=0;$j<count($subproducto);$j++){
					$archivoparaddoc= $archivoparaddoc." * ";
					$archivoparaddoc= $archivoparaddoc.$subproducto[$j]['nombre'];
					$archivoparaddoc= $archivoparaddoc."<br>";
					$productoespecifico=ProductosEspecificos::model()->productoEspecificoPorSub($subproducto[$j]['id']);
					if(empty($productoespecifico)){
						$archivoparaddoc= $archivoparaddoc."";
					}else{
						for($k=0;$k<count($productoespecifico);$k++){
						$archivoparaddoc= $archivoparaddoc."&nbsp;&nbsp;-&nbsp;";
						$archivoparaddoc= $archivoparaddoc.$productoespecifico[$k]['nombre'];
						$archivoparaddoc= $archivoparaddoc."<br>";
					}
				}
			}
		}
		$archivoparaddoc= $archivoparaddoc."</td><td align='center'>";
		$productos_clientes= ProductosClientes::model()->buscarclientesporproducto($productoestrategico[$i]['id']);
		$l=count($id_clientes);
		for($j=0;$j<count($productos_clientes);$j++){
			$bandera=0;
			$m=0;
			while($m<$l){
			if($productos_clientes[$j]['cliente_id']==$id_clientes[$m]){
				if($j!=0 && $bandera>0){$archivoparaddoc= $archivoparaddoc.",";}
					if($j%3==0){$archivoparaddoc= $archivoparaddoc."<br>";}
						$archivoparaddoc= $archivoparaddoc.($m+1);
									$m++;
				}else{
					$m++;
					$bandera++;
				}
			}
		}
		$archivoparaddoc= $archivoparaddoc."<br>&nbsp;</td><td align='center'>";
		if($productoestrategico[$i]['gestion_territorial']==1){
			$archivoparaddoc= $archivoparaddoc."Si";
		}else{
			$archivoparaddoc= $archivoparaddoc."No";
		}
		$archivoparaddoc= $archivoparaddoc."</td><td align='center'>";
		if($productoestrategico[$i]['desagregado_sexo']==1){
			$archivoparaddoc= $archivoparaddoc."Si";
		}else{
			$archivoparaddoc= $archivoparaddoc."No";
		}
		$archivoparaddoc= $archivoparaddoc."</td></tr>";
		}}			
		$archivoparaddoc= $archivoparaddoc."</table><br><br>";
		}
		
		$archivoparaddoc= $archivoparaddoc."<table border='1' cellpadding='0' cellspacing='0' style='width: 100%;'><tr align='center' style='background-color:#E6E3E3'><th>&nbsp;Nº&nbsp;&nbsp;<br>&nbsp;</th>";
		$archivoparaddoc= $archivoparaddoc."<th>Clientes<br>&nbsp;</th><th>Cuantificación<br>&nbsp;</th></tr>";
		if(empty($clientes)){
			$archivoparaddoc= $archivoparaddoc."<tr><td colspan='3'>&nbsp;No se encontraron registros</td></tr>";
		}else{
			for($i=0; $i<count($clientes);$i++){
				$archivoparaddoc= $archivoparaddoc."<tr><td align='center'>";
				$archivoparaddoc= $archivoparaddoc.($i+1);
				$archivoparaddoc= $archivoparaddoc."<br>&nbsp;</td><td>";
				$archivoparaddoc= $archivoparaddoc.$clientes[$i]['nombre'];								
				$archivoparaddoc= $archivoparaddoc."<br>&nbsp;</td><td><br>&nbsp;</td></tr>";
			}
		$archivoparaddoc= $archivoparaddoc."</table><br><br>";
		}	
		
		for($y=0;$y<=$tab;$y++){
		$archivoparaddoc= $archivoparaddoc."<table border='1' cellpadding='0' cellspacing='0' style='width: 100%';><tr style='background-color:#E6E3E3'><th rowspan='2' scope='col'>Nº</th>";
		$archivoparaddoc= $archivoparaddoc."<th rowspan='2' scope='col'>Producto Estratégico ";
		$archivoparaddoc= $archivoparaddoc.$tipoproductos[$y]['nombre'];
		$archivoparaddoc= $archivoparaddoc."</th><th colspan='2' scope='col'>Presupuesto ";
		$archivoparaddoc= $archivoparaddoc.$periodosiguiente;
		$archivoparaddoc= $archivoparaddoc."</th></tr><tr><th align='center' scope='col'>(Miles de $)</th><th align='center' scope='col'>%</th></tr>";
		$productoestrategico=ProductosEstrategicos::model()->productosestrategicosportipoproducto($tipoproductos[$y]['id']);
		if(empty($productoestrategico)){
			$archivoparaddoc= $archivoparaddoc."<tr><td colspan='4'>&nbsp;No se encontraron registros</td></tr>";
		}else{
			for($i=0;$i<count($productoestrategico);$i++){
				$archivoparaddoc= $archivoparaddoc."<tr><td align='center'>";
				$archivoparaddoc= $archivoparaddoc.($i+1);
				$archivoparaddoc= $archivoparaddoc."</td><td>";
				$archivoparaddoc= $archivoparaddoc.$productoestrategico[$i]['nombre'];
				$archivoparaddoc= $archivoparaddoc."</td><td align='center'>";
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
				$archivoparaddoc= $archivoparaddoc."$";
				$archivoparaddoc= $archivoparaddoc.number_format($numero,0, "", ".");
				$archivoparaddoc= $archivoparaddoc."</td><td align='center'>";
                if($sumatotal>0){
                    $porc=((($sumaia+$sumapi)*100)/$sumatotal);
                }else{
                    $porc=0;
                }
				
					if($porc==0){
						$archivoparaddoc= $archivoparaddoc.$porc;
						$archivoparaddoc= $archivoparaddoc."%";
					}else{
						$archivoparaddoc= $archivoparaddoc.$english_format_number = number_format($porc, 2, ',', '');
						$archivoparaddoc= $archivoparaddoc."%";
					}
				$archivoparaddoc= $archivoparaddoc."</td></tr>";
			}
		}			
		$archivoparaddoc= $archivoparaddoc."</table>";
		if($y!=$tab){
			$archivoparaddoc= $archivoparaddoc."<br><br>";
			}
		}
		
		return $archivoparaddoc;
		
	}
	public function actionFormularioA1(){
	
		$this->render('formularioA1');
	
	}    

	public function actionMapaEstrategico(){
       $modelDesafiosEstrategicos=DesafiosEstrategicos::model()->findAll(array('select'=>'t.*','distinct'=>true,'condition'=>'pp.id = '.Yii::app()->session['idPeriodo'].' AND t.estado = 1','join'=>'INNER JOIN planificaciones p ON t.planificacion_id=p.id  inner join periodos_procesos pp on pp.id=p.periodo_proceso_id'));
       $modelObjetivosEstrategicos=ObjetivosEstrategicos::model()->findAll(array('select'=>'t.*','distinct'=>true,'condition'=>'pp.id = '.Yii::app()->session['idPeriodo'].' AND t.estado = 1','join'=>'INNER JOIN desafios_objetivos do ON t.id = do.objetivo_estrategico_id            INNER JOIN desafios_estrategicos de ON do.desafio_estrategico_id = de.id            INNER JOIN planificaciones pl ON de.planificacion_id = pl.id            INNER JOIN periodos_procesos pp ON pl.periodo_proceso_id = pp.id'));
        
        $this->render('mapaEstrategico' ,array(
                'modelDesafiosEstrategicos' => $modelDesafiosEstrategicos,
                'modelObjetivosEstrategicos'=>$modelObjetivosEstrategicos
        ));
    }
    public function actionCadenaValorNegocio()
	{
        $model = ProductosEstrategicos::model()->productosestrategicosportipoproducto(1);	      
		$this->render('cadenaValorNegocio' ,array(
				'model' => $model,
		));
		
	}
    public function actionCadenaValorApoyo()
	{
		$model = ProductosEstrategicos::model()->productosestrategicosportipoproducto(2);       
        $this->render('cadenaValorApoyo' ,array(
                'model' => $model,
        ));
		
	}
    

}

