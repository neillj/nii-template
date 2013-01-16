<?php $this->renderPartial('//layouts/admin/_header'); ?>
<body class="<?php echo Yii::app()->getModule('admin')->logo ? 'show-logo':''?><?php echo Yii::app()->getModule('admin')->fixedHeader==true ? ' fixed':''?>">
	<div class="page liquid">
		<div class="body">
			<div class="main">
				<?php echo $content; ?>
			</div>
		</div>
	</div>
</body>
<?php $this->renderPartial('//layouts/admin/_footer'); ?>