<?php
	$form = $this->beginWidget
	(
		'NActiveForm',
		array
		(
			'id' => 'add-user-form',
			'clientOptions' => array
			(
				'validateOnSubmit' => true,
				'validateOnChange' => true,
			),
			'focus' => array($model, 'first_name'),
			'htmlOptions'=>array('class'=>'form-horizontal')
		)
	);
?>
<fieldset>
	<div class="control-group">
		<div class="control-group">
			<?php echo $form->labelEx($model, 'first_name',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo $form->textField($model, 'first_name'); ?>
				<span class="help-inline"><?php echo $form->error($model,'first_name'); ?></span>
			</div>
		</div>
		<div class="control-group">
			<?php echo $form->labelEx($model, 'last_name',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo $form->textField($model, 'last_name',array('placeholder'=>$model->getAttribute('last_name'))); ?>
				<span class="help-inline"><?php echo $form->error($model, 'last_name'); ?></span>
			</div>
		</div>
		<div class="control-group">
			<?php echo $form->labelEx($model, 'email',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo $form->textField($model, 'email'); ?>
				<span class="help-inline"><?php echo $form->error($model, 'email'); ?></span>
			</div>
		</div>
		<div class="control-group">
			<?php echo $form->labelEx($model, 'username',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo $form->textField($model, 'username'); ?>
				<?php echo $form->error($model, 'username'); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo $form->labelEx($model, 'password',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo $form->passwordField($model, 'password'); ?>
				<?php echo $form->error($model, 'password'); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo $form->labelEx($model, 'verifyPassword',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo $form->passwordField($model, 'verifyPassword'); ?>
				<?php echo $form->error($model, 'verifyPassword'); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo $form->labelEx($model, 'superuser',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo $form->dropDownList($model, 'superuser', User::itemAlias('AdminStatus')); ?>
				<?php echo $form->error($model, 'superuser'); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo $form->labelEx($model, 'status',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo $form->dropDownList($model, 'status', User::itemAlias('UserStatus')); ?>
				<?php echo $form->error($model, 'status'); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo $form->labelEx($model, 'roleName',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo $form->dropDownList($model, 'roleName', CHtml::listData(Yii::app()->authManager->roles,'name','description')) ?>
				<?php echo $form->error($model, 'roleName'); ?>
			</div>
		</div>
	</div>
</fieldset>
<?php $this->endWidget(); ?>