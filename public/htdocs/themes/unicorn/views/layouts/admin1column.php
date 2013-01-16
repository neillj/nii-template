<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?php echo CHtml::encode($this->pageTitle); ?></title>
		<meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/unicorn.main.css" />
		<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/unicorn.grey.css" class="skin-color" />
		<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/style.css" />
		<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/unicorn.js"></script>
		<!--<script src="<?php // echo Yii::app()->theme->baseUrl; ?>/js/unicorn.dashboard.js"></script>-->
<!--		<script src="js/excanvas.min.js"></script>
		<script src="js/jquery.min.js"></script>
		<script src="js/jquery.ui.custom.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/jquery.flot.min.js"></script>
		<script src="js/jquery.flot.resize.min.js"></script>
		<script src="js/jquery.peity.min.js"></script>
		<script src="js/fullcalendar.min.js"></script>-->
	</head>
	<body>
		<div id="header">
			<h1><a href="<?php echo NHtml::url('/admin'); ?>">Newicon Admin</a></h1>		
		</div>
		<div id="user-nav" class="navbar navbar-inverse">
            <ul class="nav btn-group">
				<li class="btn btn-inverse dropdown" id="menu-settings"><a href="#" data-toggle="dropdown" data-target="#menu-settings" class="dropdown-toggle"><i class="icon icon-cog"></i> <span class="text">Settings</span> <b class="caret"></b></a>
					<?php
						$items = Yii::app()->menus->getItems('secondary');
						$this->widget('bootstrap.widgets.TbDropdown', array(
							'items' => $items['Admin']['items'],
							'id' => 'secondaryMenu',
//							'activateParents' => true,
//							'htmlOptions' => array('class' => 'nav pull-right'),
//							'submenuHtmlOptions' => array('class' => 'dropdown-menu'),
						));
					?>
					
<!--					<ul class="dropdown-menu pull-right">
                        <li><a class="sAdd" title="" href="#">new message</a></li>
                        <li><a class="sInbox" title="" href="#">inbox</a></li>
                        <li><a class="sOutbox" title="" href="#">outbox</a></li>
                        <li><a class="sTrash" title="" href="#">trash</a></li>
                    </ul>-->
				</li>
                <li class="btn btn-inverse dropdown" id="menu-user"><a href="#" data-toggle="dropdown" data-target="#menu-user" class="dropdown-toggle"><i class="icon icon-user"></i> <span class="text">Luke Spencer</span> <b class="caret"></b></a>
                    <?php
						Yii::app()->menus->addDivider('user', 'User');
						Yii::app()->menus->addItem('user', 'Logout', array('/user/account/logout'), 'User');
						Yii::app()->menus->setUsername(Yii::app()->user->name);
						$items = Yii::app()->menus->getItems('user');
						$this->widget('bootstrap.widgets.TbDropdown', array(
							'items' => $items['User']['items'],
							'id' => 'userMenu',
		//					'activateParents' => true,
		//					'htmlOptions' => array('class' => 'nav pull-right'),
		//					'submenuHtmlOptions' => array('class' => 'dropdown-menu'),
						));
					?>
<!--					<ul class="dropdown-menu pull-right">
                        <li><a class="sAdd" title="" href="#">new message</a></li>
                        <li><a class="sInbox" title="" href="#">inbox</a></li>
                        <li><a class="sOutbox" title="" href="#">outbox</a></li>
                        <li><a class="sTrash" title="" href="#">trash</a></li>
                    </ul>-->
                </li>
            </ul>
			
        </div>
		<div id="sidebar">
			<a href="#" class="visible-phone"><i class="icon icon-home"></i> Dashboard</a>
			<?php
				$this->widget('nii.widgets.NMenu', array(
					'items' => Yii::app()->menus->getItems('main'),
					'id' => 'mainMenu',
					'activateParents' => true,
					'linkLabelWrapper'=>'span',
//					'htmlOptions' => array('class' => 'nav'),
//					'submenuHtmlOptions' => array('class' => 'dropdown-menu'),
				));
			?>
<!--			<ul>
				<li class="active"><a href="index.html"><i class="icon icon-home"></i> <span>Dashboard</span></a></li>
				<li class="submenu">
					<a href="#"><i class="icon icon-th-list"></i> <span>Form elements</span> <span class="label">3</span></a>
					<ul>
						<li><a href="form-common.html">Common elements</a></li>
						<li><a href="form-validation.html">Validation</a></li>
						<li><a href="form-wizard.html">Wizard</a></li>
					</ul>
				</li>
				<li><a href="buttons.html"><i class="icon icon-tint"></i> <span>Buttons &amp; icons</span></a></li>
				<li><a href="interface.html"><i class="icon icon-pencil"></i> <span>Interface elements</span></a></li>
				<li><a href="tables.html"><i class="icon icon-th"></i> <span>Tables</span></a></li>
				<li><a href="grid.html"><i class="icon icon-th-list"></i> <span>Grid Layout</span></a></li>
				<li class="submenu">
					<a href="#"><i class="icon icon-file"></i> <span>Sample pages</span> <span class="label">4</span></a>
					<ul>
						<li><a href="invoice.html">Invoice</a></li>
						<li><a href="chat.html">Support chat</a></li>
						<li><a href="calendar.html">Calendar</a></li>
						<li><a href="gallery.html">Gallery</a></li>
					</ul>
				</li>
				<li>
					<a href="charts.html"><i class="icon icon-signal"></i> <span>Charts &amp; graphs</span></a>
				</li>
				<li>
					<a href="widgets.html"><i class="icon icon-inbox"></i> <span>Widgets</span></a>
				</li>
			</ul>-->
		</div>
		<div id="content">
			<div id="content-header">
				<h1><?php echo $this->title ?></h1>
				<?php
					$this->widget('ext.bootstrap.widgets.TbButtonGroup',array(
						'buttons'=>$this->actionsMenu,
					));
				?>
			</div>
			<?php
				$this->widget('zii.widgets.CBreadcrumbs', array(
					'homeLink'=>false,
					'htmlOptions'=>array('id'=>'breadcrumb'),
					'links'=>$this->breadcrumbs,
					'separator'=>'',
				));
			?>
			<div class="container-fluid">
				<?php
				// probably move this into a widget in the admin module.
				// Needs some javascript to go with it so that flash messages can also be added via javascript function
				// for ajax events,
				// Responds to success, error, info, and warning flash message categories
				$flashes = array('success', 'error', 'info', 'warning');
				?>
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
				<?php echo $content; ?>
				<div class="row-fluid">
					<div id="footer" class="span12">
						2012 &copy; Newicon Admin. Brought to you by <a href="http://newicon.net">newicon.net</a>
					</div>
				</div>
			</div>
		</div>            
	</body>
</html>
