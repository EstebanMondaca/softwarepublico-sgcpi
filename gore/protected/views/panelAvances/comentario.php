<div class="form">
<h3 rel="Observaciones"></h3>
<?php 
Yii::app()->clientScript->registerScript('ready', "
    
    $(document).ready(function() {
    	$('#btn').attr('onclick','mostrarComentarios(1,0, 0)');
    
    });
");

?>

<?php


$form = $this->beginWidget('GxActiveForm', array(
	'id' => 'comentario-form',
	'enableAjaxValidation' => false,
	'action' => Yii::app()->request->baseUrl.'/reporteAvanceIndicadores/addComentario'
	
));
?>
<table>
<tr>
<td><h3><?php echo 'Indicador: '.$model->nombreIndicador ?></h3></td>
</tr>
<tr>
<td>
<?php 
echo $form->textArea($model, 'observacion', array('rows'=>6, 'cols'=>120,'readonly'=>'true'));
echo $form->hiddenField($model,'id_indicador',array('type'=>"hidden",'size'=>2,'maxlength'=>2));
echo $form->hiddenField($model,'id_usuario',array('type'=>"hidden",'size'=>2,'maxlength'=>2));

?>
</td>
</tr>
<tr>
<td>
</td>
</tr>
<tr>
<td><?php 
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$model->search(),
	'id' => 'coment-grid',
	'afterAjaxUpdate'=>'function(id, data){parent.afterAjaxUpdateSuccess();}',
	'selectableRows'=>1,
	'selectionChanged'=>'function(id){observacionTextArea($.fn.yiiGridView.getSelection(id));}',
	  'columns'=>array(
		array(
			'name'=>'fecha',
			'header'=>'Fecha',
		),
		array(
            //'name'=>'nombreUsuario',
            'header'=>'Usuario',
            'value'=>'$data->idUsuario->nombreycargo[0]',           
        ),
		array(
			'header'=>'Observación',
			'value'=>'PanelAvancesController::gridDataBreakText($data->observacion,30)',
			'htmlOptions'=>array('width'=>'50%'),
			),		
		),
));



?></td>
</tr>
</table>
<?php 

$this->endWidget();
?>
</div>