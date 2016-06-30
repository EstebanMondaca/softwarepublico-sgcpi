<?php

$this->breadcrumbs = array(
    $model->label(2) => array('index'),
    Yii::t('app', 'Create'),
);

?>

<?php
$this->renderPartial('_form', array(
        'model' => $model,
        'producto_especificoID' => $producto_especificoID,
        'producto_especificoN' => $producto_especificoN,
        'centroCosto' => $centroCosto,
        'centroResponsabilidad'=> $centroResponsabilidad,
        'usuarioActivoConcatenado'=>$usuarioActivoConcatenado,
        'buttons' => 'create',
        'nombreProductoEstrategico' => $nombreProductoEstrategico ,
        'nombreSubproducto' => $nombreSubproducto,
        'titulo' => Yii::t('app', 'Create') . ' indicador.'
        )
);

?>