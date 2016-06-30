<?php
Yii::app()->clientScript->registerScript('ready', "
    $.getJSON('".Yii::app()->request->baseUrl."/resumenGeneral/jsonGraficoRadarPorCriteriosSegunPeriodos/', function(data) {
        var chart = new FusionCharts('".Yii::app()->request->baseUrl."/swf/Radar.swf?ChartNoDataText=Información no disponible', 'ChartId', '290', '250', '0', '0');
           chart.setJSONData(data);          
           chart.render('chartdiv1'); 
    });
    $.getJSON('".Yii::app()->request->baseUrl."/resumenGeneral/jsonGraficoBarraPorIndicadoresFH/', function(data) {
        var chart2 = new FusionCharts('".Yii::app()->request->baseUrl."/swf/Bar2D.swf?ChartNoDataText=Información no disponible', 'ChartId', '290', '250', '0', '0');
           chart2.setJSONData(data);          
           chart2.render('chartdiv2'); 
    });
");


$this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Login");
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/FusionCharts.debug.js');
?>
</div><!-- Cerrando content -->

    <div class="graficos-inicio left">
        <h1> GRÁFICAS AVANCE GENERAL</h1>
        <div class="grafico left"><div id="chartdiv1" style="height: 250px;width: 290px;"><div style='margin:auto;padding-top:100px;text-align: center;'><img src="<?php echo Yii::app()->baseUrl.'/images/loading.gif';?>"/></div></div><br/>Comparación de la gestión actual del GORE Los lagos con la última autoevaluación realizada, en las ocho categorías del modelo de gestión.</div>
        <div class="grafico right"><div id="chartdiv2" style="height: 250px;width: 290px;"><div style='margin:auto;padding-top:100px;text-align: center;'><img src="<?php echo Yii::app()->baseUrl.'/images/loading.gif';?>"/></div></div><br/>Estado de avance de cada unos de los indicadores del Formulario H del año en curso del GORE Los Lagos.</div>
        
    </div><!-- graficos-inicio -->
    <div class="sidebar right">
        <div class="login-inicio"> 
            <h1> ACCESO FUNCIONARIOS GORE</h1>
            Para acceder al sistema por favor ingrese su nombre de usuario y contraseña <br />
            <?php if(Yii::app()->user->hasFlash('loginMessage')): ?>
                <?php echo Yii::app()->user->getFlash('loginMessage'); ?>
            <?php endif; ?>
            <div class="form2">
            <?php echo CHtml::beginForm(); ?>    
                <?php echo CHtml::errorSummary($model); ?>
                <table class="login">
                    <tr><td><?php echo CHtml::activeLabelEx($model,'username'); ?></td><td><?php echo CHtml::activeTextField($model,'username') ?></td></tr>
                    <tr><td><?php echo CHtml::activeLabelEx($model,'password'); ?></td><td><?php echo CHtml::activePasswordField($model,'password') ?></td></tr>
                    <tr><td></td><td><?php echo CHtml::submitButton(UserModule::t("ACCEDER"),array('class'=>'boton')); ?></td></tr>
                </table>
            <?php echo CHtml::endForm(); ?>
            </div><!-- form -->
            
       </div> <!-- End login-inicio -->
    <p>El acceso a este sistema está restringido únicamente a los funcionarios del GORE Los Lagos.</p>
    </div><!-- End Sidebar -->
    <br class="clear" />
    
    <div id="zona-banner">
        <a href="http://www.gobiernodechile.cl/"><img alt="" border="0" class="left" src="http://www.goreloslagos.cl/resources/img/banners/GobiernoChile.gif" /></a>
        <a href="http://www.goreloslagos.cl/"><img alt="" border="0" class="left" src="<?php echo Yii::app()->request->baseUrl;?>/images/curri_loslagos.jpg" /></a>
        <a href="http://www.acreditaciongores.cl/"><img alt="" border="0" class="left" src="<?php echo Yii::app()->request->baseUrl;?>/images/subdere.jpg" /></a>
        <a href="http://www.goreloslagos.cl/transparencia/index.html"><img alt="" border="0" class="left" src="http://www.goreloslagos.cl/resources/img/banners/gobiernotransparente.gif" /></a>
        <br class="clear" />
    
<?php
$form = new CForm(array(
    'elements'=>array(
        'username'=>array(
            'type'=>'text',
            'maxlength'=>32,
        ),
        'password'=>array(
            'type'=>'password',
            'maxlength'=>32,
        )
    ),
    'buttons'=>array(
        'login'=>array(
            'type'=>'submit',
            'label'=>'Login',
        ),
    ),
), $model);
?>