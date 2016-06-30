

<?php
$this->renderPartial('_form_cierre', array(
		'model' => $model,
		'id_etapa' => $id_etapa,
		'idPlanificaciones' => $idPlanificaciones,
		'nombreEtapa' => $nombreEtapa,
		'buttons' => 'create'));
?>