<?php
$this->breadcrumbs=array(
	'Mensajería de usuarios'=>array('inbox'),
	'Nuevo mensaje'
);

$this->renderpartial('_menu');
?>
<div class="mailbox-compose ui-helper-clearfix">

<?php

$this->renderPartial('_flash');


$form=$this->beginWidget('CActiveForm', array(
'id'=>'message-form',
'enableAjaxValidation'=>false,
'htmlOptions'=>array('autocomplete'=>$this->createUrl('ajax/auto')),
)); ?>
	<div class="message-create">	

		<div class="mailbox-input-row">
			<div style="float:left">
				<?php echo CHtml::activeLabelEx($conv,'to'); ?>
			</div>
			<div style="margin-left:80px">
				<?php echo $form->textField($conv,'to',array('style'=>'width:100%;','id'=>'message-to','class'=>'mailbox-input', 'edit'=>$this->module->editToField? '1' : null)); ?>
				<?php echo $form->error($conv,'to'); ?>


				<?php

					if($this->module->userSupportList)
					{

						$reps = $this->module->getUserSupportList();
						echo '<select name="ajax[to]" class="mailbox-support-list" edit="'.(($this->module->editToField)? '1' : null).'" >';
						foreach($reps as $key => &$label)
						{
						?>
						<option type="hidden" value="<?php echo $key; ?>"><?php echo $label; ?></option>
						<?php
						}
						echo '</select>';
				}
				?>
			</div>
		</div>
		<div class="mailbox-input-row">
            <div style="float:left">
                <?php echo CHtml::activeLabelEx($conv,'tipo_mensaje_id',array('class'=>'mailbox-label')); ?>
            </div>
            <div class="mailbox-compose-inputwrap" style="margin-left:80px;">
                <?php //echo $form->textField($conv,'subject',array('class'=>'mailbox-input','style'=>'width:100%;','placeholder'=>$this->module->defaultSubject)); ?>
                <?php echo $form->dropDownList($conv, 'tipo_mensaje_id', GxHtml::listDataEx(TiposMensajes::model()->findAll(array('condition'=>'t.estado=1'))), array('empty'=>'Seleccione Tipo de Mensaje')); ?>
                <?php echo $form->error($conv,'tipo_mensaje_id'); ?>
            </div>
        </div>
		<div class="mailbox-input-row">
			<div style="float:left">
				<?php echo CHtml::activeLabelEx($conv,'subject',array('class'=>'mailbox-label')); ?>
			</div>
			<div class="mailbox-compose-inputwrap" style="margin-left:80px;">
				<?php //echo $form->textField($conv,'subject',array('class'=>'mailbox-input','style'=>'width:100%;','placeholder'=>$this->module->defaultSubject)); ?>
				<?php echo $form->textField($conv,'subject',array('class'=>'mailbox-input','style'=>'width:100%;','placeholder'=>'(Escribir aquí el asunto)')); ?>
				<?php echo $form->error($conv,'subject'); ?>
			</div>
		</div>
		<div class="mailbox-textarea-wrap">
		<?php //echo $form->textArea($msg,'text',array('cols'=>50,'rows'=>7, 'class'=>'mailbox-message-input','style'=>'width:100%;','placeholder'=>'Enter message here...')); ?>
		<?php echo $form->textArea($msg,'text',array('cols'=>50,'rows'=>7, 'class'=>'mailbox-message-input','style'=>'width:100%;','placeholder'=>'Ingrese su mensaje aquí...')); ?>
		<?php echo $form->error($msg,'text'); ?>
		</div>
		<div>
		<button class="btn btn-large message-btn-reply">Enviar mensaje</button>
		</div>
	</div>
<?php $this->endWidget(); ?><!-- form --> 

</div>
<!-- mailbox -->