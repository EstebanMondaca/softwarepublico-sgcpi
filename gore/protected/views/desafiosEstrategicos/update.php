<?php
/* @var $this DesafiosEstrategicosController */
/* @var $model DesafiosEstrategicos */

$this->breadcrumbs=array(
    'Desafios Estrategicoses'=>array('index'),
    $model->id=>array('view','id'=>$model->id),
    'Modificar Desafios Estrategicos',
);
//$this->pageTitle = "My Page Title";

/*$this->menu=array(
    array('label'=>'List DesafiosEstrategicos', 'url'=>array('index')),
    array('label'=>'Create DesafiosEstrategicos', 'url'=>array('create')),
    array('label'=>'View DesafiosEstrategicos', 'url'=>array('view', 'id'=>$model->id)),
    array('label'=>'Manage DesafiosEstrategicos', 'url'=>array('admin')),
);*/

?>

<?php echo $this->renderPartial('_form', array('model'=>$model,'titulo'=>'Definición de Desafíos Estratégicos')); ?>

