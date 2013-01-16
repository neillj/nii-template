<?php $this->pageTitle = Yii::app()->name . ' - Installer'; ?>
<?php $form = $this->beginWidget('NActiveForm', array(
		'id' => 'installForm',
		'htmlOptions'=>array('class'=>'form-horizontal')
	));
?>
<?php if(Yii::app()->user->hasFlash('debug')): ?>
	<div class="alert alert-error">
		<?php echo Yii::app()->user->getFlash('debug'); ?>
	</div>
<?php endif; ?>

<?php if(Yii::app()->user->hasFlash('error')): ?>
	<div class="alert alert-error">
		<p><?php echo Yii::app()->user->getFlash('error'); ?></p>
	</div>
<?php endif; ?>


	<div class="alert alert-info">
		<p>Please fill in the details below to install this application.</p>
		<div class="alert-actions">
			<a class="btn small" href="<?php echo NHtml::url('/install/requirements/index.php'); ?>">Check Requirements</a>
		</div>
	</div>
	<fieldset>
		<legend>Site Details</legend>
		<div class="control-group">
			<?php echo $form->labelEx($dbForm, 'sitename'); ?>
			<div class="controls">
				<?php echo $form->textField($dbForm, 'sitename'); ?>
				<?php echo $form->error($dbForm, 'sitename'); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo $form->labelEx($dbForm, 'timezone'); ?>
			<div class="controls">
				<?php if (!$dbForm->timezone) $dbForm->timezone = 'Europe/London';
				echo $form->dropDownList($dbForm, 'timezone', Controller::getTimeZones(), array('class'=>'xlarge')); ?>
				<?php echo $form->error($dbForm, 'timezone'); ?>
			</div>
		</div>
	</fieldset>
	<fieldset>
		<legend>Database Details</legend>
		
		<div class="control-group <?php echo ($dbForm->hasErrors('host'))?'error':''; ?>">
			<?php echo $form->error($dbForm, 'db', array('class'=>'errorMessage alert alert-error')); // shows general database errors if in debug mode ?>
			<?php echo $form->labelEx($dbForm, 'host'); ?>
			<div class="controls large">
				<?php echo $form->textField($dbForm, 'host'); ?>
				<?php echo $form->error($dbForm, 'host'); ?>
				<span class="help-block">e.g. localhost <em>-or-</em> mydomain.com</span>
			</div>
		</div>
		<div class="control-group <?php echo ($dbForm->hasErrors('password'))?'error':''; ?> <?php echo ($dbForm->hasErrors('username'))?'error':''; ?>">
			<?php echo $form->labelEx($dbForm, 'username'); ?>
			<div class="controls large">
				<?php echo $form->textField($dbForm, 'username'); ?>
				<?php echo $form->error($dbForm, 'username'); ?>
			</div>
		</div>
		<div class="control-group ">
			<?php echo $form->labelEx($dbForm, 'password'); ?>
			<div class="controls large">
				<?php echo $form->passwordField($dbForm, 'password'); ?>
				<?php echo $form->error($dbForm, 'password'); ?>
				<span class="help-block">Leave blank if using root with no password (not recommended)</span>
			</div>
		</div>
		<div class="control-group <?php echo ($dbForm->hasErrors('name'))?'error':''; ?>">
			<?php echo $form->labelEx($dbForm, 'name'); ?>
			<div class="controls large">
				<?php echo $form->textField($dbForm, 'name'); ?>
				<?php echo $form->error($dbForm, 'name'); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo $form->labelEx($dbForm, 'tablePrefix'); ?>
			<div class="controls small">
				<?php echo $form->textField($dbForm, 'tablePrefix'); ?>
				<?php echo $form->error($dbForm, 'tablePrefix'); ?>
				<span class="help-block">Leave blank for no prefix</span>
			</div>
		</div>
	</fieldset>
	<div class="actions">
		<?php echo NHtml::submitButton('Install Database - Next',array('class'=>'btn installSubmit btn-primary btn-large')); ?>
	</div>
<?php 
$this->endWidget(); ?>
<script>
	$('#installForm').delegate('.installSubmit','click',function(){
		$('#installForm').submit();
		return false;
	}); 
	$('#<?php echo CHtml::activeId($dbForm, 'username'); ?>, #<?php echo CHtml::activeId($dbForm, 'password'); ?>').change(function(){
		$.fn.yiiactiveform.doValidate('#installForm', {attributes:['<?php echo CHtml::activeId($dbForm, 'username'); ?>','<?php echo CHtml::activeId($dbForm, 'password'); ?>']})
	});
</script>