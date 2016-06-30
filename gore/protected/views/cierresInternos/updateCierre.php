
<?php
$this->renderPartial('view_formPDF', array(
		'model' => $model,
		'id_etapa' => $id_etapa,
		'nombreEtapa' => $nombreEtapa,
		'idPlanificaciones' => $idPlanificaciones,
		));
?>