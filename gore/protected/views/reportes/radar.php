<?php

$this->breadcrumbs = array(
	 'Reportes'=>array('index'),
	 'Resultados de la Gestión Global'
);

Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/FusionCharts.debug.js'); 
?>

<h1>Resultados de la Gestión Global</h1>
<h2>Evaluaci&oacute;n global de la gesti&oacute;n del GORE Los Lagos respecto del puntaje m&aacute;ximo alcanzable</h2>
    <div id="chartdiv1" class="grafico left" style="margin:auto;"></div> 

      <script type="text/javascript">
           var chart = new FusionCharts("<?php echo Yii::app()->request->baseUrl;?>/swf/Radar.swf", "ChartId", "800", "350", "0", "0");
           chart.setDataURL("<?php echo Yii::app()->request->baseUrl;?>/xml/radar.xml");          
           chart.render("chartdiv1");          
        </script>