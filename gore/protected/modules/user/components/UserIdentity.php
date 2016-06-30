<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	private $_id;
	const ERROR_EMAIL_INVALID=3;
	const ERROR_STATUS_NOTACTIV=4;
	const ERROR_STATUS_BAN=5;
    const ERROR_PASSWORD_USERNAME_INVALID=6; 
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
	  //if($this->username=='adminspcg'){         
            $user=User::model()->notsafe()->findByAttributes(array('username'=>$this->username));
            if($user===null)
                if (strpos($this->username,"@")) {
                    $this->errorCode=self::ERROR_EMAIL_INVALID;
                    } else {
                        $this->errorCode=self::ERROR_USERNAME_INVALID;
                }
            else if(Yii::app()->getModule('user')->encrypting($this->password)!==$user->password)
                $this->errorCode=self::ERROR_PASSWORD_INVALID;
            else if($user->status==0&&Yii::app()->getModule('user')->loginNotActiv==false)
                $this->errorCode=self::ERROR_STATUS_NOTACTIV;
            else if($user->status==-1)
                $this->errorCode=self::ERROR_STATUS_BAN;
            else {
                $this->_id=$user->id;
                $this->username=$user->username;
                $this->errorCode=self::ERROR_NONE;
            }
            return !$this->errorCode;
       /*}else{  
        	     // View the ['params']['ldap'] at the bottom of configs/main.php for settings
                $options = Yii::app()->params['ldap'];
                $dc_string = "dc=" . implode(",dc=",$options['dc']);
                 
                $connection = ldap_connect($options['host']);
                //if($connection) echo "successful"; 
                
                ldap_set_option($connection, LDAP_OPT_PROTOCOL_VERSION, 3);
                ldap_set_option($connection, LDAP_OPT_REFERRALS, 0);
                 
                if($connection){
                    //$bind = ldap_bind($connection, "uid={$this->username},ou={$options['ou']},{$dc_string}", $this->password);                    
                    try {
                        $bind = @ldap_bind($connection, $this->username, $this->password);                    
                        if(!$bind){
                            $this->errorCode = self::ERROR_PASSWORD_USERNAME_INVALID; 
                        }else{
                            $user=User::model()->notsafe()->findByAttributes(array('username'=>$this->username));
                            if($user===null)
                                $this->errorCode = self::ERROR_USERNAME_INVALID;                
                            else if($user->status==0&&Yii::app()->getModule('user')->loginNotActiv==false)
                                $this->errorCode=self::ERROR_STATUS_NOTACTIV;
                            else if($user->status==-1)
                                $this->errorCode=self::ERROR_STATUS_BAN;
                            else{
                                $this->_id=$user->id;
                                $this->username=$user->username;
                                $this->errorCode = self::ERROR_NONE;
                            }               
                        }
                    } catch (Exception $e) {
                        $this->errorCode = self::ERROR_PASSWORD_USERNAME_INVALID; 
                    }
                }
        }*/
        
        return !$this->errorCode;
	}
    
    /**
    * @return integer the ID of the user record
    */
	public function getId()
	{
		return $this->_id;
	}
}