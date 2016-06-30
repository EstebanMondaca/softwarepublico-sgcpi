<?php

if($this->getAction()->getId()!='inbox') 
$this->breadcrumbs=array(
		'Mensajes de entrada'=>array('inbox'),
		'Mensajes enviados'
);
else
	$this->breadcrumbs=array('Mensajes de entrada');

$this->renderpartial('_menu');

if(isset($_GET['Message_sort']))
	$sortby = $_GET['Message_sort'];
elseif(isset($_GET['Mailbox_sort']))
	$sortby = $_GET['Mailbox_sort'];
else
	$sortby = '';
$ie6br = <<<EOD
<!--[if lt IE 6]>
<br clear="all" />
<![endif]-->
EOD;
echo '<div id="mailbox-list" class="mailbox-list ui-helper-clearfix" sortby="'.$sortby.'">';

$this->renderpartial('_flash');

if($dataProvider->getItemCount() > 0) {
?>
<form id="message-list-form" action="<?php echo $this->createUrl($this->getId().'/'.$this->getAction()->getId()); ?>" method="post">
	<input type="hidden" class="mailbox-count" name="ui[]" value="<?php echo $dataProvider->getItemCount(); ?>" />
	<input type="hidden" class="mailbox-sortby" name="ui[]" value="<?php echo $sortby; ?>" />
	
		
	<div class="mailbox-clistview-container ui-helper-clearfix grid-view">
	    

<?php

if($this->getAction()->getId()=='inbox'){
    echo "<h3>Mensajes de entrada</h3>";    
}else{
    echo "<h3>Mensajes enviados</h3>";   
}


$this->widget('zii.widgets.CListView', array(
    'id'=>'mailbox',
    'dataProvider'=>$dataProvider,
    'itemView'=>'_list',
    'itemsTagName'=>'table',
    //'template'=>'<div class="mailbox-summary">{summary}</div>{sorter}'.$ie6br.'<div id="mailbox-items" class="ui-helper-clearfix grid-view">{items}</div>{pager}',
    //'sortableAttributes'=>$this->getAction()->getId()=='sent'?array('created'=>'Fecha de envío'):array('modified'=>'Fecha de recepción'),
    'loadingCssClass'=>'mailbox-loading',
    'ajaxUpdate'=>'mailbox-list',
    'afterAjaxUpdate'=>'$.yiimailbox.updateMailbox',
    'emptyText'=>'<div style="width:100%"><h3>Tu no tienes correos en tu carpeta '.$this->getAction()->getId().'.</h3></div>',
    //'htmlOptions'=>array('class'=>'ui-helper-clearfix'),
    'sorterHeader'=>'', 
    'sorterCssClass'=>'mailbox-sorter',
    'itemsCssClass'=>'items',
    'pagerCssClass'=>'mailbox-pager',
    //'updateSelector'=>'.inbox',
    'enablePagination' => true,
        'pager' => array(                        
                        'header' => false,
                        'firstPageLabel' => 'First',
                        'prevPageLabel' => 'Anterior&nbsp;&nbsp;',
                        'nextPageLabel' => 'Siguiente',
                        'lastPageLabel' => 'Last',
                    ),
));

?>
	<?php if($this->getAction()->getId()!='sent') : ?>
<div style="clear:left"> <span class="mailbox-buttons-label">Seleccionados:</span> 
		<?php if($this->getAction()->getId()=='trash') : ?>
		<?php else: ?>
			<?php if(!$this->module->readOnly || ( $this->module->readOnly && !$this->module->isAdmin()) ): ?>
			<?php endif; ?>
	 
		<?php endif; ?>
</div>
	<?php endif; ?>
	</div>
</form>

<?php

}
else {
	$this->renderpartial('_empty');
} 
?>
</div>

<script type="text/javascript">
/*<![CDATA[*/
jQuery(function($) {
	$('.message-subject').hide();
});
/*]]>*/
</script>