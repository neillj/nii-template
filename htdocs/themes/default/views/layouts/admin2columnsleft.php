<?php $this->renderPartial('//layouts/admin/_header'); ?>
<body class="<?php echo Yii::app()->getModule('admin')->logo ? 'show-logo':''?><?php echo Yii::app()->getModule('admin')->fixedHeader==true ? ' fixed':''?>">
	<div class="page liquid">
		<?php $this->renderPartial('//layouts/admin/_head'); ?>
		<div class="body">
			<?php $this->renderPartial('//layouts/admin/_flash'); ?>
			<div class="leftCol">
				<?php echo $leftCol; ?>
			</div>
			<div class="main">
				<?php echo $content; ?>
			</div>
		</div>
		<?php $this->renderPartial('//layouts/admin/_foot'); ?>
	</div>
</body>
<?php $this->renderPartial('//layouts/admin/_footer'); ?>