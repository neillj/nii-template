<?php $this->pageTitle = Yii::app()->name . ' - Installer'; ?>
<?php $form = $this->beginWidget('NActiveForm', array(
		'id' => 'installForm',
		'htmlOptions'=>array('class'=>'form-horizontal')
	));
?>
<fieldset>
	
	<legend>Admin User Details</legend>
	
	<div class="control-group <?php echo ($userForm->hasErrors('email'))?'error':''; ?>">
		<?php echo $form->labelEx($userForm, 'email'); ?>
		<div class="controls">
			<?php echo $form->textField($userForm, 'email'); ?>
			<?php echo $form->error($userForm, 'email', array('class'=>'input-large')); ?>
		</div>
	</div>
	
	<div class="control-group <?php echo ($userForm->hasErrors('username'))?'error':''; ?>">
		<?php echo $form->labelEx($userForm, 'username'); ?>
		<div class="controls">
			<?php echo $form->textField($userForm, 'username'); ?>
			<?php echo $form->error($userForm, 'username'); ?>
		</div>
	</div>
	
	<div class="control-group <?php echo ($userForm->hasErrors('password'))?'error':''; ?>">
		<?php echo $form->labelEx($userForm, 'password'); ?>
		<div class="controls">
			<?php echo $form->passwordField($userForm, 'password'); ?>
			<?php echo $form->error($userForm, 'password'); ?>
		</div>
	</div>
	
	<div class="form-actions">
		<?php echo NHtml::submitButton('Install',array('class'=>'btn installSubmit btn-primary btn-large')); ?>
	</div>
	
</fieldset>
<?php $this->endWidget(); ?>