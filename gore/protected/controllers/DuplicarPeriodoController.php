<?php
ini_set('max_execution_time', 3000);
class DuplicarPeriodoController extends GxController
{
	/**
	 * Declares class-based actions.
	 */
	

	public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }
    
    public function accessRules() {
          return array(
            array('allow',
                'actions'=>array('index','create'),                
                'roles'=>array('admin'),
            ),
            array('deny',
                'users'=>array('*'),
            ),
        );
    } 

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		$this->layout = '//layouts/iframe';
		$this->render('index');
	}
    
    public function actionCreate(){
        $trans = Yii::app()->db->beginTransaction();
        try {
             //DUPLICANDO PRODUCTOS ESTRATEGICOS
            $objetivosEstrategicosArray=array();
            $ProductosEstrategicos=ProductosEstrategicos::model()->with('objetivosEstrategicoses.desafiosEstrategicoses.planificacion.periodoProceso')->findAll(array('condition'=>'periodoProceso.id='.$_POST['periodo']));            
            foreach($ProductosEstrategicos as $pe){
                  $modelProductosEstrategicos=$this->loadModel($pe->id,'ProductosEstrategicos');
                  $modelProductosEstrategicos->id = null;
                  $modelProductosEstrategicos->isNewRecord = true;
                  $modelProductosEstrategicos->save(false);
                  
                  /*foreach($pe->objetivosEstrategicoses as $objEst){
                      array_push($objetivosEstrategicosArray, $objEst->id);                    
                  }*/
                  //DUPLICANDO OBJETIVOS ESTRATEGICOS
                  foreach($pe->objetivosEstrategicoses as $objEst){
                      if (array_key_exists($objEst->id, $objetivosEstrategicosArray)) {
                          $modelObjetivoProducto=new ObjetivosProductos;
                          $modelObjetivoProducto->objetivo_estrategico_id=$objetivosEstrategicosArray[$objEst->id];
                          $modelObjetivoProducto->producto_estrategico_id=$modelProductosEstrategicos->id;
                          $modelObjetivoProducto->save(false);                            
                      }else{
                          $modelObjetivosEstrategicos=$this->loadModel($objEst->id,'ObjetivosEstrategicos');
                          $modelObjetivosEstrategicos->id = null;
                          $modelObjetivosEstrategicos->isNewRecord = true;
                          $modelObjetivosEstrategicos->save(false);   
                          $objetivosEstrategicosArray[$objEst->id]=$modelObjetivosEstrategicos->id;                  
                          //DUPLICANDO OBJETICOS PRODUCTO  
                          $modelObjetivoProducto=new ObjetivosProductos;
                          $modelObjetivoProducto->objetivo_estrategico_id=$modelObjetivosEstrategicos->id;
                          $modelObjetivoProducto->producto_estrategico_id=$modelProductosEstrategicos->id;
                          $modelObjetivoProducto->save(false);
                      }
                      
                      //END DUPLICANDO OBJETICOS PRODUCTOS                   
                  }//END DUPLICANDO OBJETIVOS ESTRATEGICOS
                  
                  /*//DUPLICANDO OBJETICOS PRODUCTOS
                  $objetivosProductos=ObjetivosProductos::model()->findAll(array('condition'=>'t.producto_estrategico_id='.$pe->id));
                  foreach($objetivosProductos as $ObP){
                      $modelObjetivoProducto=new ObjetivosProductos;
                      $modelObjetivoProducto->objetivo_estrategico_id=$ObP->objetivo_estrategico_id;
                      $modelObjetivoProducto->producto_estrategico_id=$modelProductosEstrategicos->id;
                      $modelObjetivoProducto->save(false);                      
                  }//END DUPLICANDO OBJETICOS PRODUCTOS*/
                  
                  //DUPLICANDO PRODUCTOS CLIENTES
                  $productosClientes=ProductosClientes::model()->findAll(array('condition'=>'t.producto_estrategico_id='.$pe->id));
                  foreach($productosClientes as $pcl){
                      $productoCliente=new ProductosClientes;
                      $productoCliente->cliente_id=$pcl->cliente_id;
                      $productoCliente->producto_estrategico_id=$modelProductosEstrategicos->id;
                      $productoCliente->save(false);
                  }//END DUPLICANDO PRODUCTOS CLIENTES
                  
                  //DUPLICANDO PRODUCTOS ESTRATEGICOS CENTROS DE COSTOS
                  $productoEstrategicoCentroCosto=ProductoEstrategicoCentroCosto::model()->findAll(array('condition'=>'t.producto_estrategico_id='.$pe->id));
                  foreach($productoEstrategicoCentroCosto as $pecc){
                      $productoEstrateficoCC=new ProductoEstrategicoCentroCosto;
                      $productoEstrateficoCC->centro_costo_id=$pecc->centro_costo_id;
                      $productoEstrateficoCC->porcentaje=$pecc->porcentaje;
                      $productoEstrateficoCC->producto_estrategico_id=$modelProductosEstrategicos->id;
                      $productoEstrateficoCC->save(false);
                  }//END DUPLICANDO PRODUCTOS ESTRATEGICOS CENTROS DE COSTOS
                  
                  //DUPLICANDO SUBPRODUCTOS  
                  foreach($pe->subproductoses as $subp){
                      $subproducto=$this->loadModel($subp->id,'Subproductos');
                      $subproducto->id = null;
                      $subproducto->producto_estrategico_id=$modelProductosEstrategicos->id;
                      $subproducto->isNewRecord = true;
                      $subproducto->save(false);
                      
                      //DUPLICANDO PRODUCTOS ESPECIFICOS
                      foreach($subp->productosEspecificoses as $proE){ 
                          $productosEspecificos=$this->loadModel($proE->id,'ProductosEspecificos');
                          $productosEspecificos->id = null;
                          $productosEspecificos->subproducto_id=$subproducto->id;
                          $productosEspecificos->isNewRecord = true;
                          $productosEspecificos->save(false);
                          
                          //DUPLICANDO INDICADORES
                          foreach($proE->indicadores as $ind){ 
                              $indicadores=$this->loadModel($ind->id,'Indicadores');
                              $indicadores->id = null;
                              $indicadores->producto_especifico_id=$productosEspecificos->id;
                              $indicadores->isNewRecord = true;
                              $indicadores->save(false);
                              
                              //DUPLICANDO LINEAS DE ACCION
                              foreach($ind->lineasAccions as $lacn){ 
                                  $lineasAccion=$this->loadModel($lacn->id,'LineasAccion');
                                  $lineasAccion->id = null;
                                  $lineasAccion->id_indicador=$indicadores->id;
                                  $lineasAccion->isNewRecord = true;
                                  $lineasAccion->save(false);
                                  
                                  //DUPLICANDO LINEAS ACCION - ACTORES
                                  $laActores=LaActores::model()->findAll(array('condition'=>'t.id_la='.$lacn->id));
                                  foreach($laActores as $la){
                                      $laActor=new LaActores;
                                      $laActor->id_usuario=$la->id_usuario;
                                      $laActor->id_la=$lineasAccion->id;
                                      $laActor->save(false);
                                  }//END DUPLICANDO LINEAS ACCION - ACTORES
                              }//END DUPLICANDO LINEAS DE ACCION
                              
                              //DUPLICANDO ACTIVIDADES
                              foreach($ind->actividades as $act){ 
                                  $actividades=$this->loadModel($act->id,'Actividades');
                                  $actividades->id = null;
                                  $actividades->fecha_inicio = null;
                                  $actividades->fecha_termino = null;
                                  $actividades->avance_actual = $act->avance_anterior;
                                  $actividades->avance_anterior = null;
                                  $actividades->verificacion = null;
                                  $actividades->actividad_parent = null;                                                                    
                                  $actividades->indicador_id=$indicadores->id;
                                  $actividades->isNewRecord = true;
                                  $actividades->save(false);
                                  
                                  //DUPLICANDO HITOS ACTIVIDADES
                                  $hitosActividades=HitosActividades::model()->findAll(array('condition'=>'t.id_actividad='.$act->id));
                                  foreach($hitosActividades as $hitosAct){
                                      $hitoActividad=new HitosActividades;
                                      $hitoActividad->id = null;
                                      $hitoActividad->id_actividad = $actividades->id;
                                      $hitoActividad->estado = $hitosAct->estado;
                                      $hitoActividad->actividad_mes = $hitosAct->actividad_mes;
                                      $hitoActividad->avance_actual = null;     
                                      $hitoActividad->save(false); 
                                  }//END DUPLICANDO HITOS ACTIVIDADES
                                  
                                  //DUPLICANDO ITEMES ACTIVIDADES
                                  $itemsActividades=ItemesActividades::model()->findAll(array('condition'=>'t.actividad_id='.$act->id));
                                  foreach($itemsActividades as $itemAct){
                                      $itemActividad=new ItemesActividades;
                                      $itemActividad->item_presupuestario_id=$itemAct->item_presupuestario_id;
                                      $itemActividad->actividad_id=$actividades->id;
                                      $itemActividad->monto=$itemAct->monto;
                                      $itemActividad->save(false);
                                  }//END DUPLICANDO ITEMES ACTIVIDADES
                              }//END ACTIVIDADES
                              
                              //DUPLICANDO HITOS INDICADORES
                              foreach($ind->hitosIndicadores as $Hind){ 
                                  $hitosIndicadores=$this->loadModel($Hind->id,'HitosIndicadores');
                                  $hitosIndicadores->id = null;
                                  $hitosIndicadores->meta_parcial=null;
                                  $hitosIndicadores->meta_reportada=null;
                                  $hitosIndicadores->conceptoa=null;
                                  $hitosIndicadores->conceptob=null;
                                  $hitosIndicadores->conceptoc=null;
                                  $hitosIndicadores->evidencia=null;                                  
                                  $hitosIndicadores->id_indicador=$indicadores->id;
                                  $hitosIndicadores->isNewRecord = true;
                                  $hitosIndicadores->save(false);
                              }//END HITOS INDICADORES
                              
                              //DUPLICANDO INDICADORES INSTRUMENTOS
                              foreach($ind->indicadoresInstrumentoses as $indInst){ 
                                  $indicadoresInstrumentos=$this->loadModel($indInst->id,'IndicadoresInstrumentos');
                                  $indicadoresInstrumentos->id = null;
                                  $indicadoresInstrumentos->id_indicador=$indicadores->id;
                                  $indicadoresInstrumentos->isNewRecord = true;
                                  $indicadoresInstrumentos->save(false);
                              }//END INDICADORES INSTRUMENTOS
                              
                          }//END DUPLICANDO INDICADORES
                      }//END DUPLICANDO PRODUCTOS ESPECIFICOS
                      
                  }//END DUPLICANDO SUBPRODUCTOS  
                  
            }//END DUPLICANDO PRODUCTOS ESTRATEGICOS
            
            //DUPLICANDO PERIODO DE UN PROCESO
            $periodoProceso=PeriodosProcesos::model()->findAll(array('condition'=>'t.id='.$_POST['periodo']));
            foreach($periodoProceso as $per){
                $Periodo=$this->loadModel($per->id,'PeriodosProcesos');
                $Periodo->id = null;
                $Periodo->descripcion=$_POST['nombrePeriodo'];
                $Periodo->isNewRecord = true;
                $Periodo->save(false);
                
                //DUPLICANDO ACTIVACION DE PROCESO
                foreach($per->activacionProcesos as $actPro){ 
                    $modelActivacionProceso=$this->loadModel($actPro->id,'ActivacionProceso');
                    $modelActivacionProceso->id = null;
                    $modelActivacionProceso->isNewRecord = true;
                    $modelActivacionProceso->periodo_id=$Periodo->id;
                    $modelActivacionProceso->inicio=date('Y-m-d H:i:s', strtotime("+1 year",strtotime($actPro->inicio)));
                    $modelActivacionProceso->fin=date('Y-m-d H:i:s', strtotime("+1 year",strtotime($actPro->fin)));//$actPro->fin;
                    $modelActivacionProceso->save(false);
                }
                
                //END DUPLICANDO ACTIVACION DE PROCESO
                
                //DUPLICANDO PLANIFICACION                
                foreach($per->planificaciones as $plani){
                        $modelPlanificacion=$this->loadModel($plani->id,'Planificaciones');
                        $modelPlanificacion->id = null;
                        $modelPlanificacion->nombre=$_POST['nombrePlanificacion'];
                        $modelPlanificacion->periodo_proceso_id=$Periodo->id;
                        $modelPlanificacion->isNewRecord = true;
                        $modelPlanificacion->save(false);
                        
                        
                        $modelEvaluacion=new EvaluacionJornada;
                        $modelEvaluacion->id = null;
                        $modelEvaluacion->planificacion_id=$modelPlanificacion->id;
                        $modelEvaluacion->save(false);
                        
                        //DUPLICANDO LOS "LA ELEMENTOS GESTION"                
                        foreach($plani->laElemGestions as $laelem){
                          $modelLaElemGestion=$this->loadModel($laelem->id,'LaElemGestion');
                          $modelLaElemGestion->id = null;
                          $modelLaElemGestion->id_planificacion=$modelPlanificacion->id;
                          $modelLaElemGestion->isNewRecord = true;
                          $modelLaElemGestion->save(false);
                        }//END LOS "LA ELEMENTOS GESTION"
                        
                        //DUPLICANDO DESAFIOS ESTRATEFICOS                
                        foreach($plani->desafiosEstrategicoses as $desEstra){
                          $modelDesafiosEstrategicos=$this->loadModel($desEstra->id,'DesafiosEstrategicos');
                          $modelDesafiosEstrategicos->id = null;
                          $modelDesafiosEstrategicos->planificacion_id=$modelPlanificacion->id;
                          $modelDesafiosEstrategicos->isNewRecord = true;
                          $modelDesafiosEstrategicos->save(false);
                          foreach($desEstra->objetivosEstrategicoses as $objEst){
                              if (array_key_exists($objEst->id, $objetivosEstrategicosArray)) {
                                  $modelDesafiosObjetivos=new DesafiosObjetivos;
                                  $modelDesafiosObjetivos->objetivo_estrategico_id=$objetivosEstrategicosArray[$objEst->id];
                                  $modelDesafiosObjetivos->desafio_estrategico_id=$modelDesafiosEstrategicos->id;
                                  $modelDesafiosObjetivos->save(false);                            
                              }else{
                                  $modelObjetivosEstrategicos=$this->loadModel($objEst->id,'ObjetivosEstrategicos');
                                  $modelObjetivosEstrategicos->id = null;
                                  $modelObjetivosEstrategicos->isNewRecord = true;
                                  $modelObjetivosEstrategicos->save(false);   
                                  $objetivosEstrategicosArray[$objEst->id]=$modelObjetivosEstrategicos->id;                  
                                  //DUPLICANDO OBJETICOS PRODUCTO  
                                  $modelDesafiosObjetivos=new DesafiosObjetivos;
                                  $modelDesafiosObjetivos->objetivo_estrategico_id=$modelObjetivosEstrategicos->id;
                                  $modelDesafiosObjetivos->desafio_estrategico_id=$modelDesafiosEstrategicos->id;
                                  $modelDesafiosObjetivos->save(false);
                              }
                          } 
                           
                        }//END DESAFIOS ESTRATEFICOS
                        
                        //DUPLICANDO ELEMENTOS GESTION PRIORIZADOS                
                        foreach($plani->elementosGestionPriorizadoses as $elemGP){
                          $modelElemGestionPriorizados=$this->loadModel($elemGP->id,'ElementosGestionPriorizados');
                          $modelElemGestionPriorizados->id = null;
                          $modelElemGestionPriorizados->id_planificacion=$modelPlanificacion->id;
                          $modelElemGestionPriorizados->isNewRecord = true;
                          $modelElemGestionPriorizados->save(false);
                        }//END DUPLICANDO ELEMENTOS GESTION PRIORIZADOS          
                        
                        //DUPLICANDO ELEMENTOS GESTION RESPONSABLE                
                        foreach($plani->elementosGestionResponsables as $elemGR){
                          $modelElemGestionResponsable=$this->loadModel($elemGR->id,'ElementosGestionResponsable');
                          $modelElemGestionResponsable->id = null;
                          $modelElemGestionResponsable->planificacion_id=$modelPlanificacion->id;
                          //Calculando el ultimo puntaje revisado del periodo para insertarlo como puntaje actual
                          $puntajeActual=0;
                            $indicadores = LaElemGestion::model()->findAll(array('condition'=>'t.id_elem_gestion='.$elemGR->elemento_gestion_id.' AND t.puntaje_revisado IS NOT NULL AND t.id_planificacion='.Yii::app()->session['idPlanificaciones'].'  AND estado = 1','order'=>'t.fecha DESC','select'=>'t.puntaje_revisado'));
                            if(isset($indicadores[0])){
                                $puntajeActual=$indicadores[0]->puntaje_revisado;
                            }
                            
                          $modelElemGestionResponsable->puntaje_actual=$puntajeActual;
                          $modelElemGestionResponsable->isNewRecord = true;
                          $modelElemGestionResponsable->save(false); 
                        }//END DUPLICANDO ELEMENTOS GESTION RESPONSABLE 
                        
                        //DUPLICANDO MISIONES Y VISIONES               
                        foreach($plani->misionesVisiones as $MV){
                          $modelMisionVision=$this->loadModel($MV->id,'MisionesVisiones');
                          $modelMisionVision->id = null;
                          $modelMisionVision->planificacion_id=$modelPlanificacion->id;
                          $modelMisionVision->isNewRecord = true;
                          $modelMisionVision->save(false);
                        }//END DUPLICANDO MISIONES Y VISIONES   
                        
                        //DUPLICANDO PRODUCTOS ITEMES
                        $productosItemes=ProductosItemes::model()->findAll(array('condition'=>'t.planificacion_id='.$plani->id));
                        foreach($productosItemes as $proItem){
                              $productoItem=new ProductosItemes;
                              $productoItem->centro_costo_id=$proItem->centro_costo_id;
                              $productoItem->item_presupuestario_id=$proItem->item_presupuestario_id;
                              $productoItem->monto=$proItem->monto;
                              $productoItem->planificacion_id=$modelPlanificacion->id;
                              $productoItem->save(false);
                        }
                        //END DUPLICANDO PRODUCTOS ITEMES    
                      
                }//END DUPLICANDO PLANIFICACION
                
            }//END DUPLICANDO PERIODO DE UN PROCESO
            
            //DUPLICANDO OBJETIVOS MINISTERIALES
            $objetivosMinisterialesArray=array();
            foreach($objetivosEstrategicosArray as $k=>$v){
                $objetivosEstrategicos=$this->loadModel($k,'ObjetivosEstrategicos');
                foreach($objetivosEstrategicos->objetivosMinisteriales as $objM){
                      if (array_key_exists($objM->id, $objetivosMinisterialesArray)){
                          $modelObjetivosObjetivos=new ObjetivosObjetivos;
                          $modelObjetivosObjetivos->objetivo_estrategico_id=$v;
                          $modelObjetivosObjetivos->objetivo_ministerial_id=$objetivosMinisterialesArray[$objM->id];
                          $modelObjetivosObjetivos->save(false);
                      }else{                          
                          $modelObjetivosMinisterial=$this->loadModel($objM->id,'ObjetivosMinisteriales');
                          $modelObjetivosMinisterial->id = null;
                          $modelObjetivosMinisterial->isNewRecord = true;
                          $modelObjetivosMinisterial->save(false);   
                          $objetivosMinisterialesArray[$objM->id]=$modelObjetivosMinisterial->id;                  
                          //DUPLICANDO OBJETICOS PRODUCTO  
                          $modelObjetivosObjetivos=new ObjetivosObjetivos;
                          $modelObjetivosObjetivos->objetivo_estrategico_id=$v;
                          $modelObjetivosObjetivos->objetivo_ministerial_id=$modelObjetivosMinisterial->id;
                          $modelObjetivosObjetivos->save(false);
                      }   
                }
            }
            //END DUPLICANDO OBJETIVOS MINISTERIALES             
            $trans->commit();                        
            echo "ok";        
        } catch (Exception $e) {                
                $trans->rollback();
                throw $e;
                echo $e;                            
        }
    }
    
}