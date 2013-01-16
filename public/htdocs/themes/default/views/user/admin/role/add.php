<?php
	$form = $this->beginWidget('NActiveForm', array(
		'id' => 'add-role-form',
		'clientOptions' => array(
			'validateOnSubmit' => true,
			'validateOnChange' => true,
		),
		'focus' => array($model, 'name'),
	));
?>
<fieldset>
	<?php echo $form->field($model, 'name'); ?>
	<?php echo $form->field($model, 'name','dropDownList', NHtml::listData(Yii::app()->authManager->roles, 'name', 'description'),array('prompt' => 'No. Create from a blank role')); ?>
</fieldset>
<?php $this->endWidget(); ?>