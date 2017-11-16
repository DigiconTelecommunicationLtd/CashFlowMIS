<div class="lotProducts view">
<h2><?php echo __('Lot Product'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($lotProduct['LotProduct']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Lot'); ?></dt>
		<dd>
			<?php echo $this->Html->link($lotProduct['Lot']['id'], array('controller' => 'lots', 'action' => 'view', $lotProduct['Lot']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Product'); ?></dt>
		<dd>
			<?php echo $this->Html->link($lotProduct['Product']['name'], array('controller' => 'products', 'action' => 'view', $lotProduct['Product']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Quantity'); ?></dt>
		<dd>
			<?php echo h($lotProduct['LotProduct']['quantity']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Uom'); ?></dt>
		<dd>
			<?php echo h($lotProduct['LotProduct']['uom']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Unit Weight'); ?></dt>
		<dd>
			<?php echo h($lotProduct['LotProduct']['unit_weight']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Remarks'); ?></dt>
		<dd>
			<?php echo h($lotProduct['LotProduct']['remarks']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Added By'); ?></dt>
		<dd>
			<?php echo h($lotProduct['LotProduct']['added_by']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Added Date'); ?></dt>
		<dd>
			<?php echo h($lotProduct['LotProduct']['added_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified By'); ?></dt>
		<dd>
			<?php echo h($lotProduct['LotProduct']['modified_by']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified Date'); ?></dt>
		<dd>
			<?php echo h($lotProduct['LotProduct']['modified_date']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Lot Product'), array('action' => 'edit', $lotProduct['LotProduct']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Lot Product'), array('action' => 'delete', $lotProduct['LotProduct']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $lotProduct['LotProduct']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Lot Products'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Lot Product'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Lots'), array('controller' => 'lots', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Lot'), array('controller' => 'lots', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Products'), array('controller' => 'products', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Product'), array('controller' => 'products', 'action' => 'add')); ?> </li>
	</ul>
</div>
