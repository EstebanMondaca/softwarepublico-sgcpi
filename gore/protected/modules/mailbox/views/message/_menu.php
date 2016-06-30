<?php
$newMsgs = Yii::app()->getModule('mailbox')->getNewMsgs();
$action = $this->getAction()->getId();
$cantidadMails="";
if($newMsgs){
    $cantidadMails="(".$newMsgs.")";
}
//<span class="mailbox-new-msgs"><?php echo $newMsgs? '('.$newMsgs.')' : null ; </span>

if($this->module->authManager)
{
	$authNew = Yii::app()->user->checkAccess("Mailbox.Message.New");
	$authInbox = Yii::app()->user->checkAccess("Mailbox.Message.Inbox");
	$authSent = Yii::app()->user->checkAccess("Mailbox.Message.Sent");
	$authTrash = Yii::app()->user->checkAccess("Mailbox.Message.Trash");
}
else
{
	$authNew = $this->module->sendMsgs && (!$this->module->readOnly || $this->module->isAdmin());
	$authInbox = ( !$this->module->readOnly || $this->module->isAdmin() );
	$authTrash = $this->module->trashbox && (!$this->module->readOnly || $this->module->isAdmin());
	$authSent = $this->module->sentbox && (!$this->module->readOnly || $this->module->isAdmin());
}
?>
<div class="mailbox-menu  ui-helper-clearfix">
	<div class="mailbox-menu-folders ui-helper-clearfix">
		<?php
		if($authInbox):?>
		<div id="mailbox-inbox" class="mailbox-menu-item <?php echo ($action=='inbox')? 'mailbox-menu-current' : '' ; ?>">
			<a href="<?php echo $this->createUrl('message/inbox'); ?>"><img src="<?php echo Yii::app()->request->baseUrl;?>/images/mail-entrada.png"/> Entrada <?php echo $cantidadMails;?></a>
		</div>
		<?php endif;
		if($authSent) : ?>
		<div  id="mailbox-sent" class="mailbox-menu-item <?php if($action=='sent') echo 'mailbox-menu-current '; ?>">
			<a href="<?php echo $this->createUrl('message/sent'); ?>"><img src="<?php echo Yii::app()->request->baseUrl;?>/images/mail-enviados.png"/> Mensajes enviados</a>
		</div>
		<?php endif;
		?>
	</div>
<?php
if($authNew) :
	?>
	<div class="mailbox-menu-newmsg  ui-helper-clearfix" align="center">
		<span><a href="<?php echo $this->createUrl('message/new'); ?>"><img src="<?php echo Yii::app()->request->baseUrl;?>/images/mail-nuevo.png"/> Nuevo mensaje</a></span>
	</div>
<?php endif; ?>

</div>