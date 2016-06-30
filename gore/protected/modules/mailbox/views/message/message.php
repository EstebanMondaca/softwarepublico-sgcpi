<?php
$this->breadcrumbs=array(
	'Mensajería de usuarios'=>array('mailbox/inbox'),
	'Mensaje',
);

$this->renderPartial('_menu'); 

$subject = ($conv->subject)? $conv->subject : $this->module->defaultSubject;
$tipoMensaje=($conv->tipoMensaje)? $conv->tipoMensaje : '';

if(strlen($subject) > 100)
{
	$subject = substr($subject,0,100);
}

?>
<div class="mailbox-message-list">


<?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }
?>
<div class="mailbox-message-subject  mailbox-ellipsis"><?php echo $subject; echo ($tipoMensaje)?' ('.$tipoMensaje.')':'' ?></div>

<br />
<?php
$first_message=1;
foreach($conv->messages as $msg): 
	$sender = $this->module->getUserName($msg->sender_id);
	if(!$sender)
		$sender = $this->module->deletedUser;
	?>

	<div class="mailbox-message-header">
		<div class="message-sender">
<?php	echo ($msg->sender_id == Yii::app()->user->id)? 'Tu' : ucfirst($sender);
	echo ($first_message)? ' dices' : ' respuesta'; ?></div>
		<div class="message-date"><?php echo date("Y-m-d H:i a",$msg->created); ?></div>
		<br />
	</div>
	<div class="mailbox-message-text"><?php echo $msg->text; ?></div>
	<br />
<?php $first_message=0;
endforeach; 

if($this->module->authManager)
	$authReply = Yii::app()->user->checkAccess("Mailbox.Message.Reply");
else
	$authReply = $this->module->sendMsgs;

if($authReply)
{

$form=$this->beginWidget('CActiveForm', array(
    'action'=>$this->createUrl('message/reply',array('id'=>$_GET['id'])),
    'id'=>'message-reply-form',
    'enableAjaxValidation'=>false,
)); ?>
	<div class="mailbox-message-reply ui-helper-clearfix">
	<?php /* echo $form->errorSummary(array($reply,$conv));*/ ?>
	<?php echo $form->error($reply,'text'); ?>
		<div class="mailbox-textarea-wrap ui-helper-clearfix">
			<textarea name="text" cols="50" rows="7" placeholder="Responder aquí..."></textarea>
		</div>
	<input type="submit" class="btn btn-large mailbox-input" value="Enviar respuesta" />
	</div>



<?php $this->endWidget(); 
}
?>
</div>

