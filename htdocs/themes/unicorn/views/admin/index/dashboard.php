<div class="row-fluid">
	<div class="span6">
		<?php foreach($portlets as $portlet) : if($portlet['position'] == 'main') : ?>
			<?php $this->widget($portlet['widget']); ?>
		<?php endif;endforeach; ?>
	</div>
	<div class="span6">
		<?php foreach($portlets as $portlet) : if($portlet['position'] == 'side') : ?>
			<?php $this->widget($portlet['widget']); ?>
		<?php endif;endforeach; ?>
	</div>
</div>