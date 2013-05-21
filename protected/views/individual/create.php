<?php
$this->breadcrumbs=array(
	'Individuals'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Individual', 'url'=>array('index')),
	array('label'=>'Manage Individual', 'url'=>array('admin')),
);
?>

<h1>Create Individual</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>