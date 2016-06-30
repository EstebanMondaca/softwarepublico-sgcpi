<div class="form">
<h3>Ordenar Productos Estrategicos Para la cadena de valor</h3>
<div id="loadingProcesos" style="width: 140px; height: 40px;display:none;" class="precarga"></div>
<?php
	Yii::app()->clientScript->registerCoreScript('jquery.ui');
    Yii::app()->clientScript->registerCssFile(
    Yii::app()->clientScript->getCoreScriptUrl().
        '/jui/css/base/jquery-ui.css'
    );
	$csrf_token_name = Yii::app()->request->csrfTokenName;
	$csrf_token = Yii::app()->request->csrfToken;
    $str_js = "
        var fixHelper = function(e, ui) {
            ui.children().each(function() {
                $(this).width($(this).width());
            });
            return ui;
        };
 
        $('#orden-grid table.items tbody').sortable({
            forcePlaceholderSize: true,
            forceHelperSize: true,
            items: 'tr',
            update : function () {
                serial = $('#orden-grid table.items tbody').sortable('serialize', {key: 'items[]', attribute: 'class'});
                $('#loadingProcesos').show();
                $.ajax({
                    'url': '" . $this->createUrl('/productosEstrategicos/orden/'.$tipoProducto)."',
                    'type': 'post',
                    'data': serial,
                    'success': function(data){
                    	$('#loadingProcesos').hide();
                    },
                    'error': function(request, status, error){
                        alert('No podemos establecer el orden en este momento. Por favor, inténtelo de nuevo en unos minutos.');
                    	$('#loadingProcesos').hide();
                    }
                });
            },
            helper: fixHelper
        }).disableSelection();
    ";
 
    Yii::app()->clientScript->registerScript('installSortable', $str_js);
?>

<?php 
 $this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'orden-grid',
	'dataProvider' => $model->searchOrden(),
	//'filter' => $model,
	'summaryText' => false,
	'rowCssClassExpression'=>'"items[]_{$data->id}"',
	'columns' => array(
		//'id',	
		'nombre_corto',
 		'nombre',
		//'orden',
	),
)); 

?>
<div class="limpia"></div>
</div>
<div class="limpia"></div>