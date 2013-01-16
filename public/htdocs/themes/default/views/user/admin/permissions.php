<div class="page-header">
	<h1>Permissions</h1>
	<div class="action-buttons">
		<a class="btn btn-danger" href="<?php echo CHtml::normalizeUrl(array('/user/admin/flushPermissions')) ?>" data-confirm="Are you sure you want to reset all permissions?  This will also remove any user created roles.">Reset All Permissions</a>
		<a class="btn btn-primary" data-toggle="modal" href="#modal-add-role">Add a Role</a>
	</div>
</div>
<?php $this->widget('nii.widgets.NTabs', 
	array(
		'id' => 'PermissionTabs',
		'tabs' => $tabs,
		'htmlOptions' => array(
			'class' => 'vertical',
		)
	)
); ?>
<!-- add role modal -->
<div class="modal hide fade" id="modal-add-role">
	<div class="modal-header">
		<a class="close" href="#" data-dismiss="modal">×</a>
		<h3>Add a Role</h3>
	</div>
	<div class="modal-body">
		<?php
			$model = new UserRole;
			$form = $this->beginWidget('NActiveForm', array(
				'id' => 'add-role-form',
				'action'=>CHtml::normalizeUrl(array('/user/admin/addRole')),
				'clientOptions' => array(
					'validateOnSubmit' => true,
					'validateOnChange' => true,
					'afterValidate'=>'js:function(form,data,hasError){
						window.user.addRoleForm.afterValidate(form,data,hasError)
					}'
				),
				'focus' => array($model, 'name'),
			));
		?>
			<fieldset>
				<?php echo $form->field($model, 'name'); ?>
				<?php echo $form->field($model, 'copy','dropDownList', NHtml::listData(Yii::app()->authManager->roles, 'name', 'description'),array('prompt' => 'No. Create from a blank role')); ?>
			</fieldset>
		<?php $this->endWidget(); ?>
	</div>
	<div class="modal-footer">
		<a id="add-role-save" class="btn btn-primary" href="#">Save</a>
	</div>
</div>

<!-- edit role modal -->
<div class="modal hide fade" id="modal-edit-role">
	<div class="modal-header">
		<a class="close" href="#" data-dismiss="modal">×</a>
		<h3>Edit Role</h3>
	</div>
	<div class="modal-body"></div>
	<div class="modal-footer">
		<a id="edit-role-delete" class="btn btn-danger pull-left" href="#">Delete this Role</a>
		<a id="edit-role-save" class="btn btn-primary" href="#">Save</a>
	</div>
</div>

<script>
	
	window.user = {
		addRoleForm : {
			afterValidate:function(form,data,hasErrors){
				if(!hasErrors){
					$.post(form.attr("action"),form.serialize(),function(response){
						if (response.success) {
							$("#modal-add-role").modal("hide");
							$(".ui-tabs-panel:not(.ui-tabs-hide) .grid-view").each(function(){
								console.log($(this).attr('id'));
								$.fn.yiiGridView.update($(this).attr("id"));
							});
							
						} else {
							alert(response.error);
						}
					},"json")
					.error(function(){
						alert("failed to return a valid response")
					})
				}
			}
		}
	}
	
	jQuery(function($){
		$('#modal-add-role').on('show',function(){
			$('#add-role-form')[0].reset();
		});
		$('#add-role-save').click(function(){
			$('#add-role-form').submit();
			return false;
		});
	});
</script>