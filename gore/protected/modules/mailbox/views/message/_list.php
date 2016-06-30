<?php

//--RCP--$userid =& $this->module->getUserId();
$userid =$this->module->getUserId();

if($this->getAction()->getId()=='sent') {
	$counterUserId = $data->recipient_id;
}
else {
	if($this->module->getUserId() == $data->initiator_id)
		$counterUserId = $data->interlocutor_id;
	else
		$counterUserId = $data->initiator_id;
}
$username = $this->module->getFromLabel($counterUserId);

if($username && ($this->module->isAdmin() || $this->module->linkUser)) {
	$url = $this->module->getUrl($counterUserId);
	if($url){
		$username = '<a href="'.$url.'" class="update">'.$username.'</a>';		
    }
}
elseif(!$username)
	$username = '<span class="mailbox-deleted-user">'.$this->module->deletedUser.'</span>';

$viewLink = $this->createUrl('message/view',array('id'=>$data->conversation_id));

if($this->getAction()->getId()=='sent') {
	$received = $this->module->getDate($data->created);
	if($this->module->recipientRead)
		$itemCssClass = ($data->isRead($userid))? 'msg-read' : 'msg-deliver';
	else
		$itemCssClass = 'msg-sent';
}
else{ 
	$received =$this->module->getDate($data->modified);
	$itemCssClass = $data->isNew($userid)? 'msg-new' : 'msg-read';
}
switch($itemCssClass)
{
	case 'msg-read': $status = ($this->getAction()->getId()=='sent')? 'Destinatario ha leído el mensaje' : 'El mensaje ha sido leído' ; break;
	case 'msg-deliver':  $status = 'El destinatario no ha leído su mensaje todavía';
	case 'msg-new': $status =  ($this->getAction()->getId()=='sent')? 'El destinatario no ha leído su mensaje todavía' : 'Ha recibido un nuevo mensaje'; break;
	case 'msg-sent': $status = "Usted envió un mensaje a {$username}";
}

$subject  = '<span class="mailbox-subject-text">';
$subject .= '<a class="mailbox-link" title="'.$status.'" href="'.$viewLink.'">';
$subjectSeperator = ' - ';
/*if(strlen($data->subject) > $this->module->subjectMaxCharsDisplay)
{
	$subject .= substr($data->subject,0,$this->module->subjectMaxCharsDisplay - strlen($this->module->ellipsis) ). $this->module->ellipsis . '</a></span>';
}
else
{
	$subject .= $data->subject .'</a></span><span class="mailbox-msg-brief">'.$subjectSeperator
		 .substr(strip_tags($data->text),0,$this->module->subjectMaxCharsDisplay - strlen($data->subject) - strlen($subjectSeperator) - strlen($this->module->ellipsis) );
	if(strlen($data->subject) + strlen($data->text) + strlen($subjectSeperator) > $this->module->subjectMaxCharsDisplay)
		$subject .= $this->module->ellipsis;
}*/

$viewEmail="<a title='Mostrar' href='".$viewLink."'><img alt='Mostrar' src='".Yii::app()->request->baseUrl."/images/view.png'></a>";
$subject .= $data->subject;

$subject = preg_replace('/[\n\r]+/','',$subject);
$subject.= '</span>';

if($index==0){
    echo '<tr><th width="15%">Usuario</th><th width="35%">Asunto</th><th width="35%">Tipo Mensaje</th><th width="10%">Fecha de envío</th><th width="5%"></th></tr>';
}

?>
<tr class="mailbox-item <?php echo $itemCssClass; ?> <?php //if($this->getAction()->getId()!='sent') echo 'mailbox-draggable-row'; ?>">
	<?php if($this->getAction()->getId()!='sent'): // add dragdrop handle ?>
		<!--<td width="25" style="width:50px;"><div class="mailbox-item-wrapper">&nbsp;</div></td>-->
	<?php endif; ?>
    
    <!--<td width="25" style="width:50px;">
	<?php //if($this->getAction()->getId()=='sent') : ?>
		<div class="mailbox-item-wrapper">&nbsp;</div>
	<?php //else: ?>
		<div class="mailbox-item-wrapper">
		<label class="ui-helper-reset" for="conv_<?php echo $data->conversation_id; ?>">
		
		</div>
		</label>
	<?php //endif; ?>
    </td>-->
    <td>
		<div  class="mailbox-item-wrapper mailbox-from mailbox-ellipsis"><?php echo $username; ?></div>
    </td>
    <td class="mailbox-subject-brief">
	    <div class="mailbox-item-wrapper mailbox-item-outer mailbox-subject">
	       <!-- <div class="mailbox-item-inner mailbox-ellipsis ui-helper-clearfix">
			     <?php //echo $subject; ?>
		      </div>-->
		      <?php echo $subject; ?>
		</div>
    </td>
    <td>
        <?php echo $data->tipoMensaje;?>
    </td>
    <td class="mailbox-received">
		<div align="right" class="mailbox-item-wrapper" style="width:80px">
			<?php if($data->is_replied) : ?>
			<div class="mailbox-replied" title="Este mensaje ha sido respondido">&nbsp;&nbsp;</div>
			<?php endif; ?>
			<?php echo $received; ?>
		</div>

    </td>
    <td>
        <?php echo $viewEmail;?>
    </td>
</tr>




