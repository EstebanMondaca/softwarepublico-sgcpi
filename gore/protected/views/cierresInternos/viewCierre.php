<?php
$this->renderPartial('_viewPdf', array(
		'model' => $model,
		'id_etapa' => $id_etapa,
		'nombreEtapa' => $nombreEtapa,
		'idPlanificaciones' => $idPlanificaciones,
		));
?>