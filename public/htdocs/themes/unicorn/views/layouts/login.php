<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title><?php echo CHtml::encode($this->pageTitle); ?></title>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/unicorn.main.css" />
		<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/unicorn.grey.css" class="skin-color" />
		<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/style.css" />
		<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/unicorn.js"></script>
	</head>
	<body class="login-page">
		<div class="page">
			<div class="main">
				<?php echo $content; ?>
			</div>
		</div>
	</body>
</html>