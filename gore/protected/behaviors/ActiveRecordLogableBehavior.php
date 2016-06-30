<?php
set_error_handler('exceptions_error_handler');

function exceptions_error_handler($severity, $message, $filename, $lineno) {
  if (error_reporting() == 0) {
    return;
  }
  if (error_reporting() & $severity) {
    throw new ErrorException($message, 0, $severity, $filename, $lineno);
  }
}

class ActiveRecordLogableBehavior extends CActiveRecordBehavior
{
    private $_oldattributes = array();
 
    public function afterSave($event)
    {
        if (!$this->Owner->isNewRecord) {
 
            // new attributes
            $newattributes = $this->Owner->getAttributes();
            $oldattributes = $this->getOldAttributes();
 
            // compare old and new
            foreach ($newattributes as $name => $value) {
                if (!empty($oldattributes)) {
                    $old = $oldattributes[$name];
                } else {
                    $old = '';
                }
 
                if ($value != $old) {
                    //$changes = $name . ' ('.$old.') => ('.$value.'), ';
 
                    $log=new ActiveRecordLog;
                    if(is_array($this->Owner->getPrimaryKey())){
                        try {
                              $many2many=implode(",", $this->Owner->getPrimaryKey());
                        } catch (Exception $e) {
                              $many2many='';
                        }
                    }else
                        $many2many=$this->Owner->getPrimaryKey();
                    $log->description=  'El usuario "' . Yii::app()->user->Name 
                                            . '" ha cambiado el campo "' . $name . '" en ' 
                                            . get_class($this->Owner) 
                                            . '[' . $many2many .'].';
                    $log->action=       'CHANGE';
                    $log->model=        get_class($this->Owner);
                    $log->idModel=      $many2many;
                    $log->field=        $name;
                    $log->creationdate= new CDbExpression('NOW()');
                    $log->userid=       Yii::app()->user->id;
                    $log->save();
                }
            }
        } else {
            $log=new ActiveRecordLog;
            if(is_array($this->Owner->getPrimaryKey())){
                try {
                      $many2many=implode(",", $this->Owner->getPrimaryKey());
                } catch (Exception $e) {
                      $many2many='';
                }
            }
            else
                $many2many=$this->Owner->getPrimaryKey();
            $log->description=  'El usuario "' . Yii::app()->user->Name 
                                    . '" ha creado ' . get_class($this->Owner) 
                                    . '[' . $many2many .'].';
            $log->action=       'CREATE';
            $log->model=        get_class($this->Owner);
            $log->idModel=      $many2many;
            $log->field=        '';
            $log->creationdate= new CDbExpression('NOW()');
            $log->userid=       Yii::app()->user->id;
            $log->save();
        }
    }
    
    
    
    public function afterDelete($event)
    {
        $log=new ActiveRecordLog;
         if(is_array($this->Owner->getPrimaryKey())){
                try {
                      $many2many=implode(",", $this->Owner->getPrimaryKey());
                } catch (Exception $e) {
                      $many2many='';
                }
            }else
                        $many2many=$this->Owner->getPrimaryKey();
        $log->description=  'El usuario "' . Yii::app()->user->Name . '" ha eliminado ' 
                                . get_class($this->Owner) 
                                . '[' . $many2many .'].';
        $log->action=       'DELETE';
        $log->model=        get_class($this->Owner);
        $log->idModel=      $many2many;
        $log->field=        '';
        $log->creationdate= new CDbExpression('NOW()');
        $log->userid=       Yii::app()->user->id;
        $log->save();
    }
 
    public function afterFind($event)
    {
        // Save old values
        $this->setOldAttributes($this->Owner->getAttributes());
    }
 
    public function getOldAttributes()
    {
        return $this->_oldattributes;
    }
 
    public function setOldAttributes($value)
    {
        $this->_oldattributes=$value;
    }
}