<?php

$this -> breadcrumbs = array('Individaul List', );

if ($lic  == "unlock") {
    $this -> widget('zii.widgets.grid.CGridView', array('dataProvider' => $arrayDataProvider, 'ajaxUpdate' => true, 'columns' => array( array('name' => 'name', 'type' => 'raw', 'value' => 'CHtml::encode($data["name"])'), array('name' => 'individual_amount', 'type' => 'raw', 'value' => 'CHtml::encode($data["individual_amount"])', ), array('name' => 'description', 'type' => 'raw', 'value' => 'CHtml::encode($data["description"])', ), array('name' => 'bank_name', 'type' => 'raw', 'value' => 'CHtml::encode($data["bank_name"])', ), array('name' => 'tran_date', 'type' => 'raw', 'value' => 'CHtml::encode($data["tran_date"])', ), ), ));
} else {
    echo '@TODO - Implement on next release!!!';
}
?>

