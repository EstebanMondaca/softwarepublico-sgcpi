<?php

Yii::import('application.models._base.BaseProductosClientes');

class ProductosClientes extends BaseProductosClientes
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}