<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'individual-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'user_id'); ?>
		<?php echo $form->textField($model,'user_id'); ?>
		<?php echo $form->error($model,'user_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'transaction_id'); ?>
		<?php echo $form->textField($model,'transaction_id'); ?>
		<?php echo $form->error($model,'transaction_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'individual_amount'); ?>
		<?php echo $form->textField($model,'individual_amount'); ?>
		<?php echo $form->error($model,'individual_amount'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->