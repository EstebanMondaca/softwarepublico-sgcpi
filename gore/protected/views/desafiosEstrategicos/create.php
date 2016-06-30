<?php
/* @var $this DesafiosEstrategicosController */
/* @var $model DesafiosEstrategicos */

$this->breadcrumbs=array(
    'Desafíos Estratégicos'=>array('index'),
    'Crear',
);

/*$this->menu=array(
    array('label'=>'List DesafiosEstrategicos', 'url'=>array('index')),
    array('label'=>'Manage DesafiosEstrategicos', 'url'=>array('admin')),
);*/
?>


<?php echo $this->renderPartial('_form', array('model'=>$model,'titulo'=>'Definición de Desafíos Estratégicos')); ?>
