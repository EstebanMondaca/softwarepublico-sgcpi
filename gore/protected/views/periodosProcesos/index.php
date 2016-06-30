<?php
	
	//Creamos una instancia para ColorBox
	$colorbox = $this->widget('application.extensions.colorpowered.JColorBox'); 
	
	//llamamos a la instancia (conexión en cadena) desde el widget generado.
	$colorbox
    ->addInstance('.MenuOperations li a', array('iframe'=>true, 'width'=>'80%', 'height'=>'80%'))
    ->addInstance('.update', array('iframe'=>true, 'width'=>'80%', 'height'=>'80%'));
    
	$nombreGrilla = 'periodos-procesos-grid';    
	$this->breadcrumbs = array(
		'Periodos',
	);

	$this->menu = array(
		array('label'=>'Agregar',
			'url'=>array('create',"gridId"=>$nombreGrilla,"asDialog"=>1)
		),
		//array('label'=>Yii::t('app', 'Manage') . ' ' . PeriodosProcesos::label(2), 'url' => array('admin')),
	);

echo Yii::app()->session['idPeriodoSelecionado']; // Imprimir variable de sesion
?>

<h1>Periodos</h1>


<?php
	$this->widget('zii.widgets.grid.CGridView', array(
        'id'=>$nombreGrilla,
        'dataProvider'=>$model->search(),
		'afterAjaxUpdate'=>'function(id, data){afterAjaxUpdateSuccess();}',
        'columns'=>array(
            'id',
            'descripcion',
            array(
                'class'=>'CButtonColumn',
                'afterDelete'=>'function(link,success,data){if(success)mostrarMensajes(data); }',
            	'buttons'=>array(
                        'update'=>
                            array(
                                    'url'=>'$this->grid->controller->createUrl("update", array("id"=>$data->primaryKey,"asDialog"=>1,"gridId"=>$this->grid->id))',
                            		'imageUrl'=>Yii::app()->request->baseUrl.'/images/edit.png',	
                            ),
                         'delete'=>
                            array(
                            	'imageUrl'=>Yii::app()->request->baseUrl.'/images/delete.png',
                            ),	   
                            ),
                
            ),
        ),
        //'afterAjaxUpdate'=>"jQuery('.update').colorbox({'iframe':true, 'width':'80%', 'height':'80%'})",
        //->addInstance('.update', array('iframe'=>true, 'width'=>'80%', 'height'=>'80%'));
    )); 
?>

