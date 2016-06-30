<?php

Yii::import('application.models._base.BaseClientes');

class Clientes extends BaseClientes
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}