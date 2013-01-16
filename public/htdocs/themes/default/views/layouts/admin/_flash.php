<?php

/**
 * Nii view file.
 * probably move this into a widget in the admin module.
 * Needs some javascript to go with it so that flash messages can also be added via javascript function
 * for ajax events,
 * Responds to success, error, info, and warning flash message categories
 * Yii::app()->user->setFlash('success', "message")
 *
 * @author Newicon, Steven O'Brien <steven.obrien@newicon.net>
 * @link http://github.com/newicon/Nii
 * @copyright Copyright &copy; 2009-2011 Newicon Ltd
 * @license http://newicon.net/framework/license/
 */
?>

<div class="alert-messages">
<?php $flashes = array('success', 'error', 'info', 'warning'); ?>
<?php foreach($flashes as $k => $flashKey): ?>
	<?php if(Yii::app()->user->hasFlash($flashKey)): ?>
		<div class="alert alert-block fade in alert-<?php echo $flashKey ?>">
			<a class="close" data-dismiss="alert" href="#">&times;</a>
			<p><?php echo Yii::app()->user->getFlash($flashKey); ?></p>
		</div>
	<?php endif; ?>
<?php endforeach; ?>
<?php if (Yii::app()->user->hasFlash('error-block-message')) : ?>
	<div class="alert alert-block alert-error"><?php echo Yii::app()->user->getFlash('error-block-message'); ?></div>
<?php endif; ?>
</div>