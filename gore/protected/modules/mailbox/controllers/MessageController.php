<?php

class MessageController extends Controller
{
	public $defaultAction = 'inbox';
	public $buttons = array( // Ex output: {count} messages have been {value}
				'default'=>array('delete'=>'deleted','read'=>'marked read','unread'=>'marked unread'),
				'trash'=>array('delete'=>'permanently deleted','restore'=>'restored')
		);
	
	public function filters()
	{
		if($this->module->authManager=='rights') {
			return array(
				'rights', // perform access control for CRUD operations
			);
		}
		else return array();
	}
	
	public function behaviors()
	{
		return array(
			'ButtonAction'=>array(
				'class'=>'mailbox.behaviors.ButtonActionBehavior',
				'controller'=>$this,
				'module'=>$this->module,
				'buttons'=>$this->buttons,
				'arclass'=>'Mailbox',
			)
		);
	}
	
	public function actionInbox($ajax=null)
	{
		$this->module->registerConfig($this->getAction()->getId());
		//--RCP--$cs =& $this->module->getClientScript();
        $cs = $this->module->getClientScript();
		$cs->registerScriptFile($this->module->getAssetsUrl().'/js/mailbox.js',CClientScript::POS_END);
		//$js = '$("#mailbox-list").yiiMailboxList('.$this->module->getOptions().');console.log(1)';

		//$cs->registerScript('mailbox-js',$js,CClientScript::POS_READY);
		
		
		if(isset($_POST['convs']))
		{
			$this->buttonAction('inbox');
		}
		$dataProvider = new CActiveDataProvider( Mailbox::model()->inbox($this->module->getUserId()) );
		if(isset($ajax))
			$this->renderPartial('_mailbox',array('dataProvider'=>$dataProvider));
		else{
			if(!isset($_GET['Mailbox_sort']))
				$_GET['Mailbox_sort'] = 'modified.desc';
				
			$this->render('mailbox',array('dataProvider'=>$dataProvider));
		}
	}
	
	public function actionSent()
	{
		// auth manager
		if(!$this->module->authManager && (!$this->module->sentbox  || ($this->module->readOnly && !$this->module->isAdmin()) ) )
			$this->redirect(array('message/inbox'));
		
		$this->module->registerConfig($this->getAction()->getId());
		
		$this->module->getClientScript()->registerScriptFile($this->module->getAssetsUrl().'/js/jquery.colors.js');
		$this->module->getClientScript()->registerScriptFile($this->module->getAssetsUrl().'/js/mailbox.js',CClientScript::POS_END);
		if(isset($_POST['convs']))
		{
			$this->buttonAction('sent');
		}
		$dataProvider = new CActiveDataProvider( Message::model()->sent($this->module->getUserId()) );
		$this->render('mailbox',array('dataProvider'=>$dataProvider));
	}
	
	
	public function actionTrash($ajax=null)
	{
		// auth manager
		if(!$this->module->authManager && (!$this->module->trashbox  || ($this->module->readOnly && !$this->module->isAdmin()) ))
			$this->redirect(array('message/inbox'));
		
		$this->module->registerConfig($this->getAction()->getId());
		
		$this->module->getClientScript()->registerScriptFile($this->module->getAssetsUrl().'/js/jquery.colors.js');
		$this->module->getClientScript()->registerScriptFile($this->module->getAssetsUrl().'/js/mailbox.js',CClientScript::POS_END);
		if(isset($_POST['convs']))
		{
			$this->buttonAction('trash','trash');
		}
		//--RCP--$period =& $this->module->recyclePeriod;
        $period =$this->module->recyclePeriod;
		Yii::app()->user->setFlash('notice', "Los mensajes serán eliminados en un periodo de {$period} días.");
		$dataProvider = new CActiveDataProvider( Mailbox::model()->trash($this->module->getUserId()) );
		if(isset($ajax))
			$this->renderPartial('_mailbox',array('dataProvider'=>$dataProvider));
		else{
			$this->render('mailbox',array('dataProvider'=>$dataProvider));
		}
	}
	
	public function actionNew()
	{
		$this->module->registerConfig($this->getAction()->getId());
		//--RCP--$cs =& $this->module->getClientScript();
        $cs =$this->module->getClientScript();
		$cs->registerScriptFile($this->module->getAssetsUrl().'/js/compose.js');
		$cs->registerScriptFile($this->module->getAssetsUrl().'/js/jquery.combobox.contacts.js');
		$js = '$(".mailbox-compose").yiiMailboxCompose('.$this->module->getOptions().");";
		$cs->registerScript('mailbox-js',$js,CClientScript::POS_READY);
		if(!$this->module->authManager && (!$this->module->sendMsgs  || ($this->module->readOnly && !$this->module->isAdmin()) ))
			$this->redirect(array('message/inbox'));
		
		if(isset($_POST['Mailbox']['to']))
		{
			$t = time();
			$conv = new Mailbox();
			$conv->subject = ($_POST['Mailbox']['subject'])? $_POST['Mailbox']['subject'] : $this->module->defaultSubject;
			$conv->to = $_POST['Mailbox']['to'];
            $conv->tipo_mensaje_id = $_POST['Mailbox']['tipo_mensaje_id'];
			$conv->initiator_id = $this->module->getUserId();

			// Check if username exist
			if(strlen($_POST['Mailbox']['to'])>1)
				$conv->interlocutor_id = $this->module->getUserId($_POST['Mailbox']['to']);
			else
				$conv->interlocutor_id = 0;
			// ...if not check if To field is user id
			if(!$conv->interlocutor_id)
			{
				if($_POST['Mailbox']['to'] && ($this->module->allowLookupById || $this->module->isAdmin()))
					$username = $this->module->getUserName($_POST['Mailbox']['to']);
				if(@$username) {
					$conv->interlocutor_id = $_POST['Mailbox']['to'];
					$conv->to = $username;
				}
				else {
					// possible that javscript was off and user selected from the userSupportList drop down.
					if(isset($_POST['ajax']['to']) && $this->module->getUserId($_POST['ajax']['to'])) {
						$conv->to = $_POST['ajax']['to'];
						$conv->initiator_id = $this->module->getUserId($_POST['ajax']['to']);
					}
					else
						$conv->addError('to','Usuario existe en la plataforma?');
				}
			}
			
			if($conv->interlocutor_id && $conv->initiator_id == $conv->interlocutor_id) {
				$conv->addError('to', "No se pueden enviar mensajes a si mismo!");
			}
			
			if(!$this->module->isAdmin() && $conv->interlocutor_id == $this->module->newsUserId){
				$conv->addError('to', "Usuario existe en la plataforma?");
			}
			
			// check user-to-user perms
			if(!$conv->hasErrors() && !$this->module->userToUser && !$this->module->isAdmin())
			{
				if(!$this->module->isAdmin($conv->to))
					$conv->addError('to', "Usuario invalido!");
			}
			
			$conv->modified = $t;
			$conv->bm_read = Mailbox::INITIATOR_FLAG;
			if($this->module->isAdmin())
				$msg = new Message('admin');
			else
				$msg = new Message('user');
			$msg->text = $_POST['Message']['text'];
			$validate = $conv->validate(array('text'),false); // html purify
			$msg->created = $t;
			$msg->sender_id = $conv->initiator_id;
			$msg->recipient_id = $conv->interlocutor_id;			
            
			if($this->module->checksums) {
				$msg->crc64 = Message::crc64($msg->text); // 64bit INT
			}
			else
				$msg->crc64 = 0;
			// Validate
			$validate = $conv->validate(null,false); // don't clear errors
			$validate = $msg->validate() && $validate;
			
			if($validate)
			{
				$conv->save();
				$msg->conversation_id = $conv->conversation_id;
				$msg->save();
				Yii::app()->user->setFlash('success', "El mensaje fue enviado exitosamente!");
                
                //Mensaje a enviar para el interlocutor
                $message = new YiiMailMessage;
                $message->setBody('<font style="line-height: 150%; ">Estimado(a) <b>'.$msg->recipient->username.'</b>, usted tiene un nuevo mensaje en el <i>SISTEMA DE PLANIFICACIÓN Y CONTROL DE GESTIÓN DEL GOBIERNO REGIONAL DE LOS LAGOS</i>, 
                    enviado por "'.$msg->sender->nombres.' '.$msg->sender->ape_paterno.'", con el siguiente asunto: <i>'.$conv->subject.'</i>. 
                    <br/><br/>Para poder leer el mensaje es necesario ingresar a la <a href="'.Yii::app()->getBaseUrl(true).'/mailbox/message/inbox">plataforma</a> con su cuenta de usuario.
                    <br/><br/> ATTE.<br/>GOBIERNO REGIONAL DE LOS LAGOS
                    <br/>AV. DÉCIMA REGIÓN 480, 4TO PISO. PUERTO MONTT - CHILE </font> ', 'text/html');
                $message->subject = 'Mensaje automático enviado desde la plataforma';
                $message->addTo($msg->recipient->email);
                $message->from = Yii::app()->params['adminEmail'];
                Yii::app()->mail->send($message);
                //
                
				$this->redirect(array('message/inbox'));
			}
			else
			{
				Yii::app()->user->setFlash('error', "Error al enviar el mensaje!");
			}
		}
		else{
			$conv = new Mailbox();
			if(isset($_GET['id']))
				$conv->to = $this->module->getUserName($_GET['id']);
			elseif(isset($_GET['to']))
				$conv->to = $_GET['to'];
			else
				$conv->to = '';
			$msg = new Message();
		}
		$this->render('compose',array('conv'=>$conv,'msg'=>$msg));
	}
	
	public function actionReply()
	{
		if(!$this->module->authManager && (!$this->module->sendMsgs  || ($this->module->readOnly && !$this->module->isAdmin()) ))
			$this->redirect(array('message/inbox'));
		
		$this->module->registerConfig($this->getAction()->getId());
		
		if($this->module->isAdmin())
			$reply = new Message('admin');
		else
			$reply = new Message('user');
		
		$conv = Mailbox::conversation($_GET['id']);
		
		if(isset($_POST['text']))
		{
			$reply->text = $_POST['text'];
			$validate = $conv->validate(array('text'),false); // html purify
			$reply->conversation_id = $conv->conversation_id;
			if($conv->initiator_id != Yii::app()->user->id) {
				$reply->recipient_id = $conv->initiator_id;
				$conv->bm_read = $conv->bm_read & ~Mailbox::INITIATOR_FLAG;
			}
			else {
				$reply->recipient_id = $conv->interlocutor_id;
				$conv->bm_read = $conv->bm_read & ~Mailbox::INTERLOCUTOR_FLAG;
			}
			
			$reply->sender_id = $this->module->getUserId();

			$reply->created = time();
			$conv->modified = $reply->created;
			
			$reply->crc64 = Message::crc64($reply->text);
			
			$conv->bm_deleted = 0; // restore message
			$conv->interlocutor_del = 0;
			$conv->initiator_del = 0;
			
			$validate = $reply->validate();
			$validate = $conv->validate() && $validate;
			
			if($validate)
			{
				$conv->save();
				$reply->save();
				Yii::app()->user->setFlash('success', "Mensaje enviado!");
                
                //Mensaje a enviar para el interlocutor
                $message = new YiiMailMessage;
                $message->setBody('<font style="line-height: 150%; ">Estimado(a) <b>'.$reply->recipient->username.'</b>, 
                    el usuario "'.$reply->sender->nombres.' '.$reply->sender->ape_paterno.'" ha respondido el mensaje con asunto: <i>'.$conv->subject.'</i>. 
                    <br/><br/>Para poder leer el mensaje es necesario ingresar a la <a href="'.Yii::app()->getBaseUrl(true).'/mailbox/message/inbox">plataforma</a> con su cuenta de usuario.
                    <br/><br/> ATTE.<br/>GOBIERNO REGIONAL DE LOS LAGOS
                    <br/>AV. DÉCIMA REGIÓN 480, 4TO PISO. PUERTO MONTT - CHILE </font> ', 'text/html');
                $message->subject = 'Mensaje automático enviado desde la plataforma';
                $message->addTo($reply->recipient->email);
                $message->from = Yii::app()->params['adminEmail'];
                Yii::app()->mail->send($message);
                //
                
                
				$this->redirect(array('message/inbox'));
			}
			else{
				Yii::app()->user->setFlash('error', "Error al enviar el mensaje!");
			
				$this->render('message',array('conv'=>$conv, 'reply'=>$reply));
			}
		}
	}
	
	public function actionView()
	{
		$this->module->registerConfig($this->getAction()->getId());
		
        //--RCP--$cs =& $this->module->getClientScript();
        $cs =$this->module->getClientScript();
		$cs->registerScriptFile($this->module->getAssetsUrl().'/js/message.js');
		$js = '$(".mailbox-message-list").yiiMailboxMessage('.$this->module->getOptions().");";
		$cs->registerScript('mailbox-js',$js,CClientScript::POS_READY);
		
		$conv = Mailbox::conversation($_GET['id']);
		
		$conv->markRead($this->module->getUserId());
		$reply = new Message;
		$this->render('message',array('conv'=>$conv, 'reply'=>$reply));
		
	}
	
	
}
