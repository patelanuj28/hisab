<?php
$this->breadcrumbs=array(
	'Individuals'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Individual', 'url'=>array('index')),
	array('label'=>'Create Individual', 'url'=>array('create')),
	array('label'=>'View Individual', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Individual', 'url'=>array('admin')),
);
?>

<h1>Update Individual <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>