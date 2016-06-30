<?php
$this->breadcrumbs=array(
	'Preferencias'=>array('/preferencias'),
	UserModule::t('Manage'),
);


?>
<h1><?php echo UserModule::t("Manage Users"); ?></h1>

<?php 
 $this->widget('zii.widgets.CMenu', array(
                'items'=>array(array('label'=>'Agregar', 'url'=>array('create'))),
                'htmlOptions'=>array('class'=>'MenuOperations'),
            ));
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-grid',
	'dataProvider'=>$model->search(),
	 'afterAjaxUpdate'=>'function(id, data){afterAjaxUpdateSuccess();}',
	'columns'=>array(
	array(
            'header'=>'N°',
            'htmlOptions'=>array('width'=>'30'),
            'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
        ),
		array(
			'name' => 'nombres',
			'type'=>'raw',
			//'value' => 'UHtml::markSearch($data,"username")',
		),
		array(
            'name' => 'ape_paterno',
            'type'=>'raw',
            //'value' => 'UHtml::markSearch($data,"username")',
        ),
        array(
            'name' => 'perfiles',
            'type'=>'raw',
            //'value' => 'UHtml::markSearch($data,"username")',
        ),
		array(
			'name'=>'email',
			'type'=>'raw',
			'value'=>'CHtml::link(UHtml::markSearch($data,"email"), "mailto:".$data->email)',
		),
		//'create_at',
		'lastvisit_at',
		/*array(
			'name'=>'superuser',
			'value'=>'User::itemAlias("AdminStatus",$data->superuser)',
			'filter'=>User::itemAlias("AdminStatus"),
		),*/
		array(
			'name'=>'status',
			'value'=>'User::itemAlias("UserStatus",$data->status)',
			'filter' => User::itemAlias("UserStatus"),
		),
		array(
			'class'=>'CButtonColumn',
			'header'=>'Acciones',
			'template'=>'{update}{delete}',
			'afterDelete'=>'function(link,success,data){if(success)mostrarMensajes(data); }',
			'buttons'=>array(
                         'update'=> array(
                                                                 
                                      'imageUrl'=>Yii::app()->request->baseUrl.'/images/edit.png',
                                   ),
                        'delete'=>  array('imageUrl'=>Yii::app()->request->baseUrl.'/images/delete.png',
                                      
                                    ),
                ),
		),
	),
)); ?>
