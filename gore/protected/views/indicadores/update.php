<?php
if(!isset($nombreProductoEstrategico) || is_null($nombreProductoEstrategico)){
    $tipoProducto=null;
}else{
    $tipoProducto = TiposProductos::model()->find(array('condition'=>'id='. $nombreProductoEstrategico->tipo_producto_id .' AND estado = 1'));    
    $tipoProducto=$tipoProducto->descripcion;
}


	if($permiteSoloVisualizar)
	{
		$this->renderPartial('_formView', array(
				'model' => $model,
				'producto_especificoID' => $producto_especificoID,
				'producto_especificoN' => $producto_especificoN,
				'centroCosto' => $centroCosto,
				'centroResponsabilidad'=> $centroResponsabilidad,
				'usuarioActivoConcatenado'=>$usuarioActivoConcatenado,
				'hitosIndicadores'=>$hitosIndicadores,
				'buttons' => 'update',
				'nombreProductoEstrategico' => $nombreProductoEstrategico ,
				'nombreSubproducto' => $nombreSubproducto,
				'titulo' => ' Vista del indicador de desempeño  ' 
		));
		
	}else{
		$this->renderPartial('_form', array(
				'model' => $model,
				'producto_especificoID' => $producto_especificoID,
				'producto_especificoN' => $producto_especificoN,
				'centroCosto' => $centroCosto,
				'centroResponsabilidad'=> $centroResponsabilidad,
				'usuarioActivoConcatenado'=>$usuarioActivoConcatenado,
				'hitosIndicadores'=>$hitosIndicadores,
				'buttons' => 'update',
				'nombreProductoEstrategico' => $nombreProductoEstrategico ,
				'nombreSubproducto' => $nombreSubproducto,
				'titulo' => Yii::t('app', 'Update') . ' INDICADOR DE DESEMPEÑO ASOCIADO A UN '.$tipoProducto,
		));
	}
?>