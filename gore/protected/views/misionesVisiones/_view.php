<?php
/* @var $this MisionesVisionesController */
/* @var $data MisionesVisiones */
?>

<div class="view">
	<h3><?php echo CHtml::encode($data->nombre); ?></h3>
	<br />
	<?php echo CHtml::decode($data->descripcion); ?>
	<br />
	<div class="row buttons">	    
	    <?php 
	    if(Yii::app()->user->checkAccessChangeDataGore('MisionesVisionesController')){
	       echo CHtml::link('Editar', array('update', 'id'=>$data->id),array('class'=>'update boton')); 
	    }
	    ?> 
	</div>
       
</div>